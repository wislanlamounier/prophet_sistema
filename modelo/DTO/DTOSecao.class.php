<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela secao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-16
	 *
	**/
	class DTOSecao{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnSecao;
		private $cdnProcedimento;
		private $nomSecao;
		private $desSecao;
		private $indAviso = 0;
		private $indDesvinculada = 0;

		/**
		 * Método responsável por setar o valor do código numérico do procedimento
		 *
		 * @param Integer $cdnProcedimento - código numérico do procedimento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnProcedimento($cdnProcedimento){
			if($this->validacaoNumero($cdnProcedimento)){
				$this->cdnProcedimento = $cdnProcedimento;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do procedimento
		 *
		 * @return Integer - código numérico do procedimento
		 *
		**/
		public function getCdnProcedimento(){
			return $this->cdnProcedimento;
		}

		/**
		 * Método responsável por setar o valor do código numérico da seção
		 *
		 * @param Integer $cdnSecao - código numérico da seção
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnSecao($cdnSecao){
			if($this->validacaoNumero($cdnSecao)){
				$this->cdnSecao = $cdnSecao;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da seção
		 *
		 * @return Integer - código numérico da seção
		 *
		**/
		public function getCdnSecao(){
			return $this->cdnSecao;
		}

        /**
         * Método responsável por setar o nome da seção.
         *
         * @param String $nomSecao - nome da seção
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function setNomSecao($nomSecao){
            if(trim($nomSecao) == '')
                return false;
            $this->nomSecao = $nomSecao;
            return true;
        }

        /**
         * Método responsável por retornar o nome da seção
         *
         * @return String - nome da seção
         *
        **/
        public function getNomSecao(){
            return $this->nomSecao;
        }

		/**
		 * Método responsável por setar a descrição da seção.
		 *
		 * @param String $desSecao - descrição da seção
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setDesSecao($desSecao){
			$this->desSecao = $desSecao;
			return true;
		}

		/**
		 * Método responsável por retornar a descrição da seção
		 *
		 * @return String - descrição da seção
		 *
		**/
		public function getDesSecao(){
			return $this->desSecao;
		}

		/**
		 * Método responsável por setar se deve avisar na hora da marcação da consulta
		 *
		 * @param Boolean $indAviso - avisar na consulta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndAviso($indAviso){
			$this->indAviso = $indAviso;
			return true;
		}

		/**
		 * Método responsável por retornar deve avisar na hora da marcação da consulta
		 *
		 * @param Boolean $indTransformar - transformar para Sim/Não
		 * @return Boolean - avisar na hora da marcação da consulta
		 *
		**/
		public function getIndAviso($indTransformar = false){
			if(!$indTransformar)
				return $this->indAviso;
			return $this->transformacaoSim($this->indAviso);
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
