<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a clinica.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-11
     *
    **/
    class ModeloClinica extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da clínica requisitada
         *
         * @param Integer $cdnClinica - código numérico da clinica
         * @return Object - objeto DTO da clínica
         *
        **/
        public function getClinica($cdnClinica){
            return $this->getRegistro('clinica', 'cdnClinica', $cdnClinica);
        }

        /**
         * Método utilizado para atualizar as informações da clinica
         *
         * @param Object $dtoClinica - objeto DTO da clinica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function clinicaAtualizarFim(DTOClinica $dtoClinica){

			$dados = $dtoClinica->getArrayBanco();
            $_SESSION['nomClinica'] = $dtoClinica->getNomClinica();
            return $this->atualizar('clinica', $dados, array('cdnClinica' => $dtoClinica->getCdnClinica()));

        }

        /**
         * Método utilizado para preencher o DTO da clinica para cadastro.
         *
         * @param Boolean $cdnClinica - código numérico do usuário (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function clinicaPreparaDTO($cdnClinica = 0){
            $modMain = new ModeloMain(true);
            $mesErro = '';
        	if($cdnClinica == 0){
                // está cadastrando
        		$dtoClinica = new DTOClinica();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('clinica', 'cdnClinica', $cdnClinica))
                    return array(new DTOClinica(), 'Registro não existente.');

    			$dtoClinica = $this->getClinica($cdnClinica);
        	}

            $arrValidacao = array(
        		'codCep' => '',
        		'codCpfCnpj' => array('Informe um CPF/CNPJ válido.'),
        		'codUf' => 'Inorme um estado válido.',
        		'desClinica' => '',
        		'nomCidade' => '',
        		'nomClinica' => array('Informe o nome da clínica.'),
        		'nomFacebook' => '',
        		'numTelefone1' => '',
        		'numTelefone2' => '',
        		'numWhatsapp' => '',
        		'strEmail' => 'Informe um e-mail válido.',
        		'strEndereco' => '',
        		'strSite' => ''
            );

            $dtoClinica->setIndFisica(isset($_POST['indFisica']));


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
            	if(!$dtoClinica->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoClinica, $mesErro);
        }
    }
