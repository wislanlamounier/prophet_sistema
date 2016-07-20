<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela procedimento
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-16
	 *
	**/
	class DTOProcedimento{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnProcedimento;
		private $cdnAreaAtuacao;
		private $nomProcedimento;
		private $desProcedimento;
		private $indAviso = 0;
		private $indDesvinculado = 0;

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
         * Método responsável por setar o nome do procedimento.
         *
         * @param String $nomProcedimento - nome do procedimento
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function setNomProcedimento($nomProcedimento){
            if(trim($nomProcedimento) == '')
                return false;
            $this->nomProcedimento = $nomProcedimento;
            return true;
        }

        /**
         * Método responsável por setar o nome do procedimento
         *
         * @return String - nome do procedimento
         *
        **/
        public function getNomProcedimento(){
            return $this->nomProcedimento;
        }

		/**
         * Método responsável por setar a descrição do procedimento
         *
         * @param String $desProcedimento - descrição do procedimento
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function setDesProcedimento($desProcedimento){
            $this->desProcedimento = $desProcedimento;
            return true;
        }

        /**
         * Método responsável por setar a descrição do procedimento
         *
         * @return String - descrição do procedimento
         *
        **/
        public function getDesProcedimento(){
            return $this->desProcedimento;
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
		 * @param Boolean $indDesvinculado - oferta desvinculada do sistema
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndDesvinculado($indDesvinculado){
			$this->indDesvinculado = $indDesvinculado;
			return true;
		}

		/**
		 * Método responsável por retornar se o procedimento está desvinculado
		 *
		 * @return Boolean - oferta desvinculada
		 *
		**/
		public function getIndDesvinculado(){
			return $this->indDesvinculado;
		}
    }
