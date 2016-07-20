<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela pergunta
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-31
	 *
	**/
	class DTOPergunta{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnPergunta;
		private $strPergunta;

		/**
		 * Método responsável por setar o código numérico da pergunta
		 *
		 * @param Integer $cdnPergunta - código numérico da pergunta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnPergunta($cdnPergunta){
			if($this->validacaoNumero($cdnPergunta)){
				$this->cdnPergunta = $cdnPergunta;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da pergunta
		 *
		 * @return Integer - código numérico da pergunta
		 *
		**/
		public function getCdnPergunta(){
			return $this->cdnPergunta;
		}

		/**
		 * Método responsável por setar o texto da pergunta
		 * 
		 * @param String $strPergunta - texto da pergunta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setStrPergunta($strPergunta){
			if($this->validacaoVazio($strPergunta)){
				$this->strPergunta = $strPergunta;
				return true;
			}
			return false;
		}

		/** 
		 * Método responsável por retornar o texto da pergunta
		 * 
		 * @return String - texto da pergunta
		 *
		**/
		public function getStrPergunta(){
			return $this->strPergunta;
		}

	}