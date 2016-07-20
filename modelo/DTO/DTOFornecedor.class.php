<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela fornecedor
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-14
	 *
	**/
	class DTOFornecedor{
		use DTO;
		use Validacao;
		use Transformacao;
        private $cdnFornecedor;
        private $nomFornecedor;
        private $numTelefone1;
        private $numTelefone2;
        private $numWhatsapp;
        private $nomFacebook;
        private $strEndereco;
        private $nomRepresentante;
        private $numRepresentanteTelefone;
        private $strRepresentanteEmail;
		private $desFornecedor;

        /**
         * Método responsável por setar o código numérico do fornecedor
         *
         * @param Integer $cdnFornecedor - código numérico do fornecedor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnFornecedor($cdnFornecedor){
            if($this->validacaoNumero($cdnFornecedor)){
                $this->cdnFornecedor = $cdnFornecedor;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico do fornecedor
         *
         * @return Integer - código numérico do fornecedor
         *
        **/
        public function getCdnFornecedor(){
            return $this->cdnFornecedor;
        }

        /**
         * Método responsável por setar o nome do fornecedor
         *
         * @param String $nomFornecedor - nome do fornecedor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomFornecedor($nomFornecedor){
            if(trim($nomFornecedor) == ''){
                return false;
            }
            $this->nomFornecedor = $nomFornecedor;
            return true;
        }

        /**
         * Método responsável por retornar o nome do fornecedor
         *
         * @return String - nome do fornecedor
         *
        **/
        public function getNomFornecedor(){
            return $this->nomFornecedor;
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
		 * Método responsável por setar o nome do facebook da clínica
		 *
		 * @param String $nomFacebook - facebook da clinica
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomFacebook($nomFacebook){
			$this->nomFacebook = $nomFacebook;
			return true;
		}

		/**
		 * Método responsável por retornar o nome do facebook da clínica
		 *
		 * @return String - facebook da clínica
		 *
		**/
		public function getNomFacebook(){
			return $this->nomFacebook;
		}

        /**
         * Método responsável por setar o endereço do fornecedor
         *
         * @param String $strEndereco - endereço do fornecedor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrEndereco($strEndereco){
            $this->strEndereco = $strEndereco;
            return true;
        }

        /**
         * Método responsável por retornar o endereço do fornecedor
         *
         * @return String - endereço do fornecedor
         *
        **/
        public function getStrEndereco(){
            return $this->strEndereco;
        }

        /**
         * Método responsável por setar o nome do representante
         *
         * @param String $nomRepresentante - nome do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomRepresentante($nomRepresentante){
            $this->nomRepresentante = $nomRepresentante;
            return true;
        }

        /**
         * Método responsável por retornar o nome do representante
         *
         * @return String - nome do representante
         *
        **/
        public function getNomRepresentante(){
            return $this->nomRepresentante;
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
         * Método responsável por setar o email do representante
         *
         * @param String $strRepresentanteEmail - email do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrRepresentanteEmail($strRepresentanteEmail){
            if(trim($strRepresentanteEmail) != ''){
                if($this->validacaoEmail($strRepresentanteEmail)){
                    $this->strRepresentanteEmail = $strRepresentanteEmail;
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
        public function getStrRepresentanteEmail(){
            return $this->strRepresentanteEmail;
        }

		/**
		 * Método responsável por setar a descrição do fornecedor
		 *
		 * @param String $desFornecedor - descrição do fornecedor
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDesFornecedor($desFornecedor){
			$this->desFornecedor = $desFornecedor;
			return true;
		}

		/**
		 * Método responsável por retornar a descrição do fornecedor
		 *
		 * @return String - descrição do fornecedor
		 *
		**/
		public function getDesFornecedor(){
			return $this->desFornecedor;
		}
    }
