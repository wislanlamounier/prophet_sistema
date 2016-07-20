<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela usuario_master
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-10
	 *
	**/
	class DTOUsuario{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnUsuario;

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
	}
