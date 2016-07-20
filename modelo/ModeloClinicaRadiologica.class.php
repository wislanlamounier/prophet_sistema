<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a clínica radiológica.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-14
     *
    **/
    class ModeloClinicaRadiologica extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da clínica radiológica requisitada
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Object - objeto DTO da clínica
         *
        **/
        public function getClinicaRadiologica($cdnClinicaRadiologica){
            return $this->getRegistro('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica);
        }

        /** 
         * Método utilizado para atualizar as informações da clínica radiológica
         *
         * @param Object $dtoClinicaRadiologica - objeto DTO da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function clinicaRadiologicaAtualizarFim(DTOClinicaradiologica $dtoClinicaRadiologica){

            $dados = $dtoClinicaRadiologica->getArrayBanco();
            return $this->atualizar('clinicaradiologica', $dados, array('cdnClinicaRadiologica' => $dtoClinicaRadiologica->getCdnClinicaRadiologica()));

        }

        /**
         * Método utilizado para preencher o DTO da clínica radiológica para cadastro.
         *
         * @param Boolean $cdnClinicaRadiologica - código numérico da clínica radiológica (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function clinicaRadiologicaPreparaDTO($cdnClinicaRadiologica = 0){
            $mesErro = '';
            if($cdnClinicaRadiologica == 0){
                // está cadastrando
                $dtoClinicaRadiologica = new DTOClinicaradiologica();
            }else{
                // está atualizando
                if(!$this->checaExiste('clinicaradiologica', 'cdnClinicaRadiologica', $cdnClinicaRadiologica))
                    return array(new DTOClinicaradiologica(), 'Registro não existente.');
                $dtoClinicaRadiologica = $this->getClinicaRadiologica($cdnClinicaRadiologica);
            }

            $arrValidacao = array(
                'nomClinicaRadiologica' => array('Informe o nome da clínica radiológica.'),
                'numWhatsapp' => '',
                'numTelefone1' => '',
                'numTelefone2' => '',
                'strEndereco' => '',
                'nomCidade' => '',
                'strEmail' => 'Informe um e-mail válido.',
                'strSite' => '',
                'desClinicaRadiologica' => ''
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
                if(!$dtoClinicaRadiologica->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            return array($dtoClinicaRadiologica, $mesErro);
        }

        /**
         * Método utilizado para registrar a clínica radiológica
         * no banco de dados
         *
         * @param Object $dtoClinicaRadiologica - objeto DTO da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function clinicaRadiologicaCadastrarFim(DTOClinicaradiologica $dtoClinicaRadiologica){

            $dadosFinais = $dtoClinicaRadiologica->getArrayBanco();
            return $this->inserir('clinicaradiologica', $dadosFinais);

        }
    }
