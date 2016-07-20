<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela procedimento_areaatuacao
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-15
	 *
	**/
	class Procedimento_AreaAtuacao{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnProcedimento;
		private $cdnAreaAtuacao;

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
    }
