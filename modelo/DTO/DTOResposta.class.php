<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela resposta
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-01
	 *
	**/
	class DTOResposta{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnResposta;
		private $cdnPaciente;
		private $cdnPergunta;
		private $cdnOpcao;
		private $strResposta;

		/**
		 * Método responsável por setar o código numérico da resposta
		 *
		 * @param Integer $cdnResposta - código numérico da resposta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnResposta($cdnResposta){
			if($this->validacaoNumero($cdnResposta)){
				$this->cdnResposta = $cdnResposta;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da resposta
		 *
		 * @return Integer - código numérico da resposta
		 *
		**/
		public function getCdnResposta(){
			return $this->cdnResposta;
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
		 * Método responsável por setar o código numérico do paciente
		 * 
		 * @param Integer $cdnPaciente - código numérico do paciente
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnPaciente($cdnPaciente){
			if($this->validacaoNumero($cdnPaciente)){
				$this->cdnPaciente = $cdnPaciente; 
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por setar o código numérico do paciente
		 *
		 * @return Integer - código númerico do paciente
		 *
		**/
		public function getCdnPaciente(){ 
			return $this->cdnPaciente; 
		}

		/** 
		 * Método responsável por setar a resposta
		 *
		 * @param String $strResposta - resposta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setStrResposta($strResposta){
			$this->strResposta = $strResposta;
			return true;
		}

		/**
		 * Método responsável por retornar a resposta
		 *
		 * @return String - resposta
		 *
		**/
		public function getStrResposta(){
			return $this->strResposta;
		}

	}