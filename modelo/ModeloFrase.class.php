<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a frase.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-09
     *
    **/
    class ModeloFrase extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da frase requisitado
         *
         * @param Integer $cdnFrase - código numérico da frase
         * @return Object - objeto DTO da frase
         *
        **/
        public function getFrase($cdnFrase){
            return $this->getRegistro('frase', 'cdnFrase', $cdnFrase);
        }

        /**
         * Método utilizado para atualizar as informações da frase
         *
         * @param Object $dtoFrase - objeto DTO da frase
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function fraseAtualizarFim(DTOFrase $dtoFrase){

            $dados = $dtoFrase->getArrayBanco();
            return $this->atualizar('frase', $dados, array('cdnFrase' => $dtoFrase->getCdnFrase()));

        }

        /**
         * Método utilizado para preencher o DTO da frase para cadastro.
         *
         * @param Boolean $cdnFrase - código numérico da frase (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function frasePreparaDTO($cdnFrase = 0){
            $mesErro = '';
        	if($cdnFrase == 0){
                // está cadastrando
        		$dtoFrase = new DTOFrase();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('frase', 'cdnFrase', $cdnFrase))
                    return array(new DTOFrase(), 'Registro não existente.');
                $dtoFrase = $this->getFrase($cdnFrase);
        	}

            $arrValidacao = array(
                'strFrase' => array('Informe a frase.'),
            );

            $dtoFrase->setIndAtiva(isset($_POST['indAtiva']));

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
            	if(!$dtoFrase->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

            if($cdnFrase == 0){
                $dtoFrase->setCdnUsuario($_SESSION['cdnUsuario']);
            }

			return array($dtoFrase, $mesErro);
        }

        /**
         * Método utilizado para registrar a frase
         * no banco de dados
         *
         * @param Object $dtoFrase - objeto DTO da frase
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function fraseCadastrarFim(DTOFrase $dtoFrase){

                $dadosFinais = $dtoFrase->getArrayBanco();
                return $this->inserir('frase', $dadosFinais);

        }
    }
