<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela consultorio
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-15
	 *
	**/
	class DTOConsultorio{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnConsultorio;
		private $numConsultorio;
		private $indDesvinculado = 0;

		/**
		 * Método responsável por setar o valor do código numérico do consultório
		 *
		 * @param Integer $cdnConsultorio - código numérico do consultorio
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnConsultorio($cdnConsultorio){
			if($this->validacaoNumero($cdnConsultorio)){
				$this->cdnConsultorio = $cdnConsultorio;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do consultório
		 *
		 * @return Integer - código numérico do consultório
		 *
		**/
		public function getCdnConsultorio(){
			return $this->cdnConsultorio;
		}

        /**
         * Método responsável por setar o número do consultório.
         *
         * @param String $numConsultorio - número do consultório
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function setNumConsultorio($numConsultorio){
            if(trim($numConsultorio) == '')
                return false;
            $this->numConsultorio = $numConsultorio;
            return true;
        }

        /**
         * Método responsável por setar o número do consultório
         *
         * @return String - número do consultório
         *
        **/
        public function getNumConsultorio(){
            return $this->numConsultorio;
        }

		/**
		 * Método responsável por setar o desvinculamento
		 *
		 * @param Boolean $indDesvinculado - oferta desvinculada do sistema
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndDesvinculado($indDesvinculado){
			$this->indDesvinculado = $indDesvinculado;
			return true;
		}

		/**
		 * Método responsável por retornar se a oferta está desvinculada
		 *
		 * @return Boolean - oferta desvinculada
		 *
		**/
		public function getIndDesvinculado(){
			return $this->indDesvinculado;
		}
    }
