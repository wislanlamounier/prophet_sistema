<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o fornecedor.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ModeloFornecedor extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do fornecedor requisitado
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Object - objeto DTO do fornecedor
         *
        **/
        public function getFornecedor($cdnFornecedor){
            return $this->getRegistro('fornecedor', 'cdnFornecedor', $cdnFornecedor);
        }

        /**
         * Método utilizado para atualizar as informações do fornecedor
         *
         * @param Object $dtoFornecedor - objeto DTO do fornecedor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function fornecedorAtualizarFim(DTOFornecedor $dtoFornecedor){

            $dados = $dtoFornecedor->getArrayBanco();
            return $this->atualizar('fornecedor', $dados, array('cdnFornecedor' => $dtoFornecedor->getCdnFornecedor()));

        }

        /**
         * Método utilizado para preencher o DTO do fornecedor para cadastro.
         *
         * @param Boolean $cdnFornecedor - código numérico do fornecedor (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function fornecedorPreparaDTO($cdnFornecedor = 0){
            $mesErro = '';
        	if($cdnFornecedor == 0){
                // está cadastrando
        		$dtoFornecedor = new DTOFornecedor();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('fornecedor', 'cdnFornecedor', $cdnFornecedor))
                    return array(new DTOFornecedor(), 'Registro não existente.');
                $dtoFornecedor = $this->getFornecedor($cdnFornecedor);
        	}

            $arrValidacao = array(
                'nomFornecedor' => array('Informe o nome do fornecedor.'),
                'numTelefone1' => '',
                'numTelefone2' => '',
                'numWhatsapp' => '',
                'nomFacebook' => '',
                'nomRepresentante' => '',
                'numRepresentanteTelefone' => '',
                'strRepresentanteEmail' => 'Informe um e-mail válido.',
                'desFornecedor' => '',
                'strEndereco' => '',
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
            	if(!$dtoFornecedor->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoFornecedor, $mesErro);
        }

        /**
         * Método utilizado para registrar o fornecedor
         * no banco de dados
         *
         * @param Object $dtoFornecedor - objeto DTO do fornecedor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function fornecedorCadastrarFim(DTOFornecedor $dtoFornecedor){

                $dadosFinais = $dtoFornecedor->getArrayBanco();
                return $this->inserir('fornecedor', $dadosFinais);

        }
    }
