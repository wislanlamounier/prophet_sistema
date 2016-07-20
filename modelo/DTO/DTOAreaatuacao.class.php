<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela areaatuacao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-15
	 *
	**/
	class DTOAreaatuacao{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnAreaAtuacao;
		private $nomAreaAtuacao;
		private $desAreaAtuacao;
		private $indDesvinculada = 0;

		/**
		 * Método responsável por setar o valor do código numérico da area de atuação
		 *
		 * @param Integer $cdnAreaAtuacao - código numérico da area de atuação
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnAreaAtuacao($cdnAreaAtuacao){
			if($this->validacaoNumero($cdnAreaAtuacao)){
				$this->cdnAreaAtuacao = $cdnAreaAtuacao;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da area de atuação
		 *
		 * @return Integer - código numérico da area de atuação
		 *
		**/
		public function getCdnAreaAtuacao(){
			return $this->cdnAreaAtuacao;
		}

        /**
         * Método responsável por setar o nome da area de atuação.
         *
         * @param String $nomAreaAtuacao - nome da área de atuação
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function setNomAreaAtuacao($nomAreaAtuacao){
            if(trim($nomAreaAtuacao) == '')
                return false;
            $this->nomAreaAtuacao = $nomAreaAtuacao;
            return true;
        }

        /**
         * Método responsável por setar o nome da area de atuação
         *
         * @return String - nome da area de atuação
         *
        **/
        public function getNomAreaAtuacao(){
            return $this->nomAreaAtuacao;
        }

		/**
		 * Método responsável por setar a descrição da area de atuação.
		 *
		 * @param String $desAreaAtuacao - descrição de atuação
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setDesAreaAtuacao($desAreaAtuacao){
			$this->desAreaAtuacao = $desAreaAtuacao;
			return true;
		}

		/**
		 * Método responsável por setar a descrição da area de atuação
		 *
		 * @return String - descrição da area de atuação
		 *
		**/
		public function getDesAreaAtuacao(){
			return $this->desAreaAtuacao;
		}

		/**
		 * Método responsável por setar o desvinculamento
		 *
		 * @param Boolean $indDesvinculada - oferta desvinculada do sistema
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndDesvinculada($indDesvinculada){
			$this->indDesvinculada = $indDesvinculada;
			return true;
		}

		/**
		 * Método responsável por retornar se a oferta está desvinculada
		 *
		 * @return Boolean - oferta desvinculada
		 *
		**/
		public function getIndDesvinculada(){
			return $this->indDesvinculada;
		}
    }
