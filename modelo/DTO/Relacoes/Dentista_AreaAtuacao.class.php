<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela dentista_areaatuacao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-15
	 *
	**/
	class Dentista_AreaAtuacao{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnDentista;
		private $cdnAreaAtuacao;

		/**
		 * Método responsável por setar o valor do código numérico do dentista
		 *
		 * @param Integer $cdnDentista - código numérico do dentista
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnDentista($cdnDentista){
			if($this->validacaoNumero($cdnDentista)){
				$this->cdnDentista = $cdnDentista;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do dentista
		 *
		 * @return Integer - código numérico do dentista
		 *
		**/
		public function getCdnDentista(){
			return $this->cdnDentista;
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
    }
