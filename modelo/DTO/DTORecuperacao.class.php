<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela recuperacao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-12-01
	 *
	**/
	class DTORecuperacao{
		use DTO;
		use Validacao;
		use Transformacao;

		private $cdnUsuario;
		private $numIp;
		private $datRecuperacao = date('Y-m-d h:i:s');
		private $codExterno;
		private $indFinalizado = 0;


		/**
		 * Método responsável por setar o valor do código numérico do usuário
		 *
		 * @param Integer $cdnUsuario - código numérico do usuário
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnUsuario($cdnUsuario){
			if($this->validacaoNumero($cdnUsuario)){
				$this->cdnUsuario = $cdnUsuario;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do usuário
		 *
		 * @return Integer - código numérico do usuário
		 *
		**/
		public function getCdnUsuario(){
			return $this->cdnUsuario;
		}

		/**
		 * Método responsável por setar o IP do usuário
		 *
		 * @param String $numIp - número do up
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumIp($numIp){
			$this->numIp = $numIp;
			return true;
		}

		/** 
		 * Método responsável por retornar o número de ip do usuário
		 *
		 * @return String - número de ip do usuário
		 *
		**/
		public function getNumIp(){
			return $this->numIp;
		}

		/**
		 * Método responsável por retornar a data da recuperação
		 *
		 * @return String - data da recuperação
		 *
		**/
		public function getDatRecuperacao(){
			return $this->datRecuperacao;
		}

		/**
		 * Método responsável por setar o código externo
		 *
		 * @param String $codexterno - código externo
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodExterno($codExterno){
			$this->codExterno = $codExterno;
			return true;
		}

		/**
		 * Método responsável por retornar o código externo
		 *
		 * @return String - código externo
		 *
		**/
		public function getCodExterno(){
			return $this->codExterno;

		}

		/**
		 * Método responsável por setar se a recuperação foi finalizada
		 *
		 * @param Boolean $indFinalizada - recuperação foi finalizada
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndFinalizada($indFinalizada){
			$this->indFinalizada = $indFinalizada;
			return true;
		}

		/**
		 * Método responsável por retornar se a recuperação foi finalizada
		 * 
		 * @return Boolean - recuperação foi finalizada
		 *
		**/
		public function getIndFinalizada(){
			return $this->indFinalizada;
		}

	}