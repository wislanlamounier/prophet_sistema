<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o procedimento.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-16
     *
    **/
    class ModeloProcedimento extends Modelo{
        use Transformacao;
        use Validacao;

        /**
         * Método utilizado para retornar o objeto DTO
         * do procedimento requisitado
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getProcedimento($cdnProcedimento){
            return $this->getRegistro('procedimento', 'cdnProcedimento', $cdnProcedimento);
        }

        /**
         * Método utilizado para preencher o DTO do procedimento para cadastro.
         *
         * @param Boolean $cdnProcedimento - código numérico do procedimento (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function procedimentoPreparaDTO($cdnProcedimento = 0){
            $mesErro = '';
        	if($cdnProcedimento == 0){
                // está cadastrando
        		$dtoProcedimento = new DTOProcedimento();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('procedimento', 'cdnProcedimento', $cdnProcedimento))
                    return array(new DTOProcedimento(), 'Registro não existente.');
                $dtoProcedimento = $this->getProcedimento($cdnProcedimento);
        	}

            $arrValidacao = array(
                'nomProcedimento' => array('Informe o nome do procedimento.'),
                'desProcedimento' => ''
            );

            $dtoProcedimento->setIndAviso(isset($_POST['indAviso']));

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoProcedimento->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoProcedimento, $mesErro);
        }

        /**
         * Método utilizado para registrar o procedimento
         * no banco de dados
         *
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function procedimentoCadastrarFim(DTOProcedimento $dtoProcedimento){

            $dadosFinais = $dtoProcedimento->getArrayBanco();
            if($this->inserir('procedimento', $dadosFinais)){
                $cdnProcedimento = $this->ultimoInserido('procedimento');
                $this->procedimentoAtualizarPrecos($cdnProcedimento);
                return true;
            }else{
                return false;
            }

        }

        /**
         * Método responsável por finalizar a atualização do procediento
         *
         * @param Object $dtoProcedimento - objeto DTO do procedimento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function procedimentoAtualizarFim($dtoProcedimento){
            $dados = $dtoProcedimento->getArrayBanco();
            $this->procedimentoAtualizarPrecos($dtoProcedimento->getCdnProcedimento());
            return $this->atualizar('procedimento', $dados, array('cdnProcedimento' => $dtoProcedimento->getCdnProcedimento()));
        }

        /**
         * Método responsável por retornar um select de procedimentos
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento para selecionar de início (opcional)
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @param Boolean $label - label a ser colocada. Padrão: Procedimento.
         * @param Array $arrProcedimentos - array de procedimentos que devem ser mostrados (opcional).
         * @param String $classe - classe do input. Padrão: iptCdnProcedimento.
         * @param String $nome - nome do input. Padrão: cdnProcedimento.
         * @return String - select de clientes
         *
        **/
        public function procedimentoRetornaSelect($cdnProcedimento = 0, $cdnAreaAtuacao, $label = 'Procedimento', $arrProcedimentos = false, $classe = 'iptCdnProcedimento', $nome = 'cdnProcedimento'){
            if($arrProcedimentos === false){
                $arrCond = array('indDesvinculado' => 0,
                                 'conscond1' => 'AND',
                                 'cdnAreaAtuacao' => $cdnAreaAtuacao);
                $arrProcedimentos = $this->consultar('procedimento', '*', $arrCond, 'nomProcedimento');
            }

            $select = '';
            $select .='<div class="form-group">
                           <label class="control-label" for="'.$nome.'">'.$label.'</label>';
            $select .= '
                <select id="'.$classe.'" name="'.$nome.'" class="form-control '.$classe.'">';
            foreach($arrProcedimentos as $arrProcedimento){

                if($arrProcedimento['cdnProcedimento'] == $cdnProcedimento)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option class="option" '.$selected.' value="'.$arrProcedimento['cdnProcedimento'].'">'.$arrProcedimento['nomProcedimento'].'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }

        public function procedimentoAtualizarPrecos($cdnProcedimento){
            foreach($_POST as $id => $preco){
                if(substr($id, 0, 3) == 'tab'){
                    $cdnTabelaPreco = substr($id, 3);
                    $arrCond = array('cdnTabelaPreco' => $cdnTabelaPreco,
                                     'conscond1' => 'AND',
                                     'cdnProcedimento' => $cdnProcedimento);
                    $valPreco = $this->transformacaoDecimal($preco);
                    if($this->validacaoDecimal($valPreco)){
                        $arrDados = array('cdnTabelaPreco' => $cdnTabelaPreco,
                                          'valPreco' => $valPreco,
                                          'cdnProcedimento' => $cdnProcedimento);
                        $this->deletar('tabelapreco_procedimento', $arrCond);
                        $this->inserir('tabelapreco_procedimento', $arrDados);
                    }
                }
                if(substr($id, 0, 3) == 'par'){
                    $cdnParceria = substr($id, 3);
                    $arrCond = array('cdnParceria' => $cdnParceria,
                                     'conscond1' => 'AND',
                                     'cdnProcedimento' => $cdnProcedimento);
                    $valPreco = $this->transformacaoDecimal($preco);
                    if($this->validacaoDecimal($valPreco)){
                        $arrDados = array('cdnParceria' => $cdnParceria,
                                          'valPreco' => $valPreco,
                                          'cdnProcedimento' => $cdnProcedimento);
                        $this->deletar('parceria_preco', $arrCond);
                        $this->inserir('parceria_preco', $arrDados);
                    }
                }
            }
        }
    }
