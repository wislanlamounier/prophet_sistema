<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela clinicaradiologica
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-26
	 *
	**/
	class DTOClinicaradiologica{
		use DTO;
		use Validacao;
		use Transformacao;
        private $cdnClinicaRadiologica;
        private $nomClinicaRadiologica;
        private $numWhatsapp;
        private $numTelefone1;
        private $numTelefone2;
        private $strEndereco;
        private $nomCidade;
        private $strEmail;
        private $strSite;
        private $desClinicaRadiologica;


        /**
         * Método responsável por setar o código numérico da clínica radiológica
         *
         * @param Integer $cdnClinicaRadiologica - código numérico da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnClinicaRadiologica($cdnClinicaRadiologica){
            if($this->validacaoNumero($cdnClinicaRadiologica)){
                $this->cdnClinicaRadiologica = $cdnClinicaRadiologica;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico da clínica radiológica
         *
         * @return Integer - código numérico da clínica radiológica
         *
        **/
        public function getCdnClinicaRadiologica(){
            return $this->cdnClinicaRadiologica;
        }

        /**
         * Método responsável por setar o nome da clínica radiológica
         *
         * @param String $nomClinicaRadiologica - nome da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomClinicaRadiologica($nomClinicaRadiologica){
            if(trim($nomClinicaRadiologica) == ''){
                return false;
            }
            $this->nomClinicaRadiologica = $nomClinicaRadiologica;
            return true;
        }

        /**
         * Método responsável por retornar o nome da clínica radiológica
         *
         * @return String - nome da clínica radiológica
         *
        **/
        public function getNomClinicaRadiologica(){
            return $this->nomClinicaRadiologica;
        }

        /**
         * Método responsável por setar o número do whatsapp
         *
         * @param String $numWhatsapp - número do whatsapp
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNumWhatsapp($numWhatsapp){
            $this->numWhatsapp = $numWhatsapp;
            return true;
        }

        /**
         * Método responsável por retornar o número do whatsapp
         *
         * @return String - número do whatsapp
         *
        **/
        public function getNumWhatsapp(){
            return $this->numWhatsapp;
        }

        /**
		 * Método responsável por setar o número de telefone 1
		 *
		 * @param String $numTelefone1 - número de telefone 1
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumTelefone1($numTelefone1){
			$this->numTelefone1 = $numTelefone1;
			return true;
		}

		/**
		 * Método responsável por retornar o número de telefone 1
		 *
		 * @return String - número de telefone 1
		 *
		**/
		public function getNumTelefone1(){
			return $this->numTelefone1;
		}

		/**
		 * Método responsável por setar o número de telefone 2
		 *
		 * @param String $numTelefone2 - número de telefone 2
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumTelefone2($numTelefone2){
			$this->numTelefone2 = $numTelefone2;
			return true;
		}

		/**
		 * Método responsável por retornar o número de telefone 2
		 *
		 * @return String - número de telefone 2
		 *
		**/
		public function getNumTelefone2(){
			return $this->numTelefone2;
		}

        /**
         * Método responsável por setar o endereço
         *
         * @param String $strEndereco - endereço
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrEndereco($strEndereco){
            $this->strEndereco = $strEndereco;
            return true;
        }

        /**
         * Método responsável por retornar o endereço
         *
         * @return String - endereço
         *
        **/
        public function getStrEndereco(){
            return $this->strEndereco;
        }

        /**
         * Método responsável por setar o nome da cidade
         *
         * @param String $nomCidade - nome da cidade
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomCidade($nomCidade){
            $this->nomCidade = $nomCidade;
            return true;
        }

        /**
         * Método responsável por retornar o nome da cidade
         *
         * @return String - nome da cidade
         *
        **/
        public function getNomCidade(){
            return $this->nomCidade;
        }

        /**
         * Método responsável por setar o telefone do representante
         *
         * @param String $numRepresentanteTelefone - telefone do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNumRepresentanteTelefone($numRepresentanteTelefone){
            $this->numRepresentanteTelefone = $numRepresentanteTelefone;
            return true;
        }

        /**
         * Método responsável por retornar o telefone do representante
         *
         * @return String - telefone do representante
         *
        **/
        public function getNumRepresentanteTelefone(){
            return $this->numRepresentanteTelefone;
        }

        /**
         * Método responsável por setar o email da clínica radiológica
         *
         * @param String $strEmail - email da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrEmail($strEmail){
            if(trim($strEmail) != ''){
                if($this->validacaoEmail($strEmail)){
                    $this->strEmail = $strEmail;
                    return true;
                }
                return false;
            }
            return true;
        }

        /**
         * Método responsável por retornar o email do representante
         *
         * @return String - email do representante
         *
        **/
        public function getStrEmail(){
            return $this->strEmail;
        }

        /**
         * Método responsável por setar os site da clínica radiológica
         *
         * @param String $strSite - site da clínica radiológica
         * @param Boolean - true se sucesso, false se não
         *
        **/
        public function setStrSite($strSite){
            $this->strSite = $strSite;
            return true;
        }

        /**
         * Método responsável por retornar o site da clínica
         *
         * @return String - site da clínica
         *
        **/
        public function getStrSite(){
            return $this->strSite;
        }

        /**
         * Método responsável por setar as observações da clínica
         *
         * @param String $desClinicaRadiologica - observações da clínica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setDesClinicaRadiologica($desClinicaRadiologica){
            $this->desClinicaRadiologica = $desClinicaRadiologica;
            return true;
        }

        /**
         * Método responsável por retornar as observações da clínica
         *
         * @return String - observações da clínica
         *
        **/
        public function getDesClinicaRadiologica(){
            return $this->desClinicaRadiologica;
        }
    }
