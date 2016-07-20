<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela estilo
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-24
	 *
	**/
	class DTOParceria{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnPreco;
		private $cdnParceria;
		private $cdnProcedimento;
		private $valPreco;

		/**
		 * Método responsável por setar o código numérico da parceria
		 *
		 * @param Integer $cdnParceria - código numérico da parceria
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnParceria($cdnParceria){ 
			if($this->validacaoParceria($cdnParceria)){
				$this->cdnParceria = $cdnParceria; 
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da parceria
		 * 
		 * @return Integer - código numérico da parceria
		 *
		**/
		public function getCdnParceria(){ 
			return $this->cdnParceria; 
		}

		/**
		 * Método responsável por setar o código numérico do procedimento
		 *
		 * @param Integer $cdnProcedimento - código numérico do procedimento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnProcedimento($cdnProcedimento){
			if($this->validacaoProcedimento($cdnProcedimento)){
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
		 * Método responsável por setar o valor do procedimento
		 *
		 * @param Decimal $valPreco - valor do procedimento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setValPreco($valPreco){
			if(trim($valPreco) != ''){
				if(!$this->validacaoDecimal($valPreco))
					$valPreco = $this->transformacaoDecimal($valPreco);
					
				if($this->validacaoDecimal($valPreco)){
					$this->valPreco = $valPreco;
					return true;
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o valor do procedimento
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Decimal/String - valor do procedimento
		 *
		**/
		public function getValPreco($indTransforma = false){
			if(!$indTransforma)
				return $this->valPreco;
			return $this->transformacaoMonetario($this->valPreco);
		}
    }
