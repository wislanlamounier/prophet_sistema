<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a área de atuação.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class ModeloAreaAtuacao extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da área de atuação requisitada
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Object - objeto DTO da área de atuação
         *
        **/
        public function getAreaAtuacao($cdnAreaAtuacao){
            return $this->getRegistro('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao);
        }

        /**
         * Método utilizado para atualizar as informações da área de atuação
         *
         * @param Object $dtoAreaAtuacao - objeto DTO da área de atuação
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function areaAtuacaoAtualizarFim(DTOAreaatuacao $dtoAreaAtuacao){
            $dados = $dtoAreaAtuacao->getArrayBanco();
            return $this->atualizar('areaatuacao', $dados, array('cdnAreaAtuacao' => $dtoAreaAtuacao->getCdnAreaAtuacao()));
        }

        /**
         * Método utilizado para preencher o DTO da área de atuação para cadastro.
         *
         * @param Boolean $cdnAreaAtuacao - código numérico da área de atuação (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function areaAtuacaoPreparaDTO($cdnAreaAtuacao = 0){
            $mesErro = '';
        	if($cdnAreaAtuacao == 0){
                // está cadastrando
        		$dtoAreaAtuacao = new DTOAreaatuacao();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('areaatuacao', 'cdnAreaAtuacao', $cdnAreaAtuacao))
                    return array(new DTOAreaatuacao(), 'Registro não existente.');
                $dtoAreaAtuacao = $this->getAreaAtuacao($cdnAreaAtuacao);
        	}

            $arrValidacao = array(
                'nomAreaAtuacao' => array('Informe o nome da área de atuação.'),
                'desAreaAtuacao' => ''
            );

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao)){
                        $mesErro .= $mesValidacao[0].'<br>';
                        continue;
                    }
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoAreaAtuacao->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoAreaAtuacao, $mesErro);
        }

        /**
         * Método utilizado para registrar a área de atuação
         * no banco de dados
         *
         * @param Object $dtoAreaAtuacao - objeto DTO da área de atuação
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function areaAtuacaoCadastrarFim(DTOAreaatuacao $dtoAreaAtuacao){

            $dadosFinais = $dtoAreaAtuacao->getArrayBanco();
            return $this->inserir('areaatuacao', $dadosFinais);
        }

        /**
         * Método responsável por retornar um select de áreas de atuação.
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área para selecionar de início (opcional)
         * @param Boolean $label - colocar a label ou não. Padrão: true.
         * @param String $classe - classe do input. Padrão: iptCdnAreaAtuacao.
         * @param String $nome - nome do input. Padrão: cdnAreaAtuacao.
         * @return String - select de clientes
         *
        **/
        public function areaAtuacaoRetornaSelect($cdnAreaAtuacao = 0, $label = 'Área de Atuação', $arrAreasAtuacoes = false, $classe = 'iptCdnAreaAtuacao', $nome = 'cdnAreaAtuacao'){
            if($arrAreasAtuacoes === false){
                $arrAreasAtuacoes = $this->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'nomAreaAtuacao');
            }

            $select = '';
            $select .='<div class="form-group">';
            if($label)
               $select .= '<label class="control-label" for="'.$nome.'">'.$label.'</label>';
            else
               $select .= '<label class="control-label" for="'.$nome.'">Área de Atuação</label>';

            $select .= '<select required name="'.$nome.'" class="form-control '.$classe.'">';
            if($label)
                $select .= '<option id="optPadrao" value="">'.$label.'</option>'.PHP_EOL;

            foreach($arrAreasAtuacoes as $arrAreaAtuacao){

                if($arrAreaAtuacao['cdnAreaAtuacao'] == $cdnAreaAtuacao)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option '.$selected.' value="'.$arrAreaAtuacao['cdnAreaAtuacao'].'">'.$arrAreaAtuacao['nomAreaAtuacao'].'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }
    }
