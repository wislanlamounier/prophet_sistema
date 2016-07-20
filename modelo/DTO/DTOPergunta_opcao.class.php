<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela pergunta_opcao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-31
	 *
	**/
	class DTOPergunta_opcao{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnOpcao;
		private $cdnPergunta;
		private $strOpcao;

		/**
		 * Método responsável por setar o código numérico da opção
		 *
		 * @param Integer $cdnOpcao - código numérico da pergunta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnOpcao($cdnOpcao){
			if($this->validacaoNumero($cdnOpcao)){
				$this->cdnOpcao = $cdnOpcao;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da opção
		 *
		 * @return Integer - código numérico da opção
		 *
		**/
		public function getCdnOpcao(){
			return $this->cdnOpcao;
		}

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
		 * @param String $strOpcao - texto da pergunta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setStrOpcao($strOpcao){
			if($this->validacaoVazio($strOpcao)){
				$this->strOpcao = $strOpcao;
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
		public function getStrOpcao(){
			return $this->strOpcao;
		}

	}