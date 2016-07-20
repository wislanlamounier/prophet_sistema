<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a secao.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-17
     *
    **/
    class ModeloSecao extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da secao requisitada
         *
         * @param Integer $cdnSecao - código numérico da seção
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getSecao($cdnSecao){
            return $this->getRegistro('secao', 'cdnSecao', $cdnSecao);
        }

        /**
         * Método utilizado para preencher o DTO da secao para cadastro.
         *
         * @param Boolean $cdnSecao - código numérico da secao (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function secaoPreparaDTO($cdnSecao = 0){
            $mesErro = '';
        	if($cdnSecao == 0){
                // está cadastrando
        		$dtoSecao = new DTOSecao();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('secao', 'cdnSecao', $cdnSecao))
                    return array(new DTOSecao(), 'Registro não existente.');
                $dtoSecao = $this->getSecao($cdnSecao);
        	}

            $dtoSecao->setIndAviso(isset($_POST['indAviso']));

            $arrValidacao = array(
                'nomSecao' => array('Informe o nome da secao.'),
                'desSecao' => '',
            );

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
            	if(!$dtoSecao->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoSecao, $mesErro);
        }

        /**
         * Método utilizado para registrar a secao
         * no banco de dados
         *
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function secaoCadastrarFim(DTOSecao $dtoSecao){

            $dadosFinais = $dtoSecao->getArrayBanco();
            return $this->inserir('secao', $dadosFinais);

        }

        /**
         * Método responsável por finalizar a atualização do procediento
         *
         * @param Object $dtoSecao - objeto DTO da secao
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function secaoAtualizarFim($dtoSecao){
            $dados = $dtoSecao->getArrayBanco();
            return $this->atualizar('secao', $dados, array('cdnSecao' => $dtoSecao->getCdnSecao()));
        }

        /**
         * Método responsável por retornar um select de seções
         *
         * @param Integer $cdnSecao - código numérico do procedimento para selecionar de início (opcional)
         * @param Integer $cdnProcedimento - código numérico do procedimento.
         * @param Boolean $label - label a ser colocada. Padrão: Seção.
         * @param Array $arrSecoes - array de seções que devem ser mostrados (opcional).
         * @param String $classe - classe do input. Padrão: iptCdnSecao.
         * @param String $nome - nome do input. Padrão: cdnSecao.
         * @return String - select de clientes
         *
        **/
        public function secaoRetornaSelect($cdnSecao = 0, $cdnProcedimento, $label = 'Seção', $arrSecoes = false, $classe = 'iptCdnSecao', $nome = 'cdnSecao'){
            if($arrSecoes === false){
                $arrCond = array('indDesvinculada' => 0,
                                 'conscond1' => 'AND',
                                 'cdnProcedimento' => $cdnProcedimento);
                $arrSecoes = $this->consultar('secao', '*', $arrCond, 'nomSecao');
            }

            $select = '';
            $select .='<div class="form-group">
                           <label class="control-label" for="'.$nome.'">'.$label.'</label>';
            $select .= '
                <select id="'.$classe.'" name="'.$nome.'" class="form-control '.$classe.'">';
            foreach($arrSecoes as $arrSecao){

                if($arrSecao['cdnSecao'] == $cdnSecao)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option '.$selected.' value="'.$arrSecao['cdnSecao'].'">'.$arrSecao['nomSecao'].'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }

    }
