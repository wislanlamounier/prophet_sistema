<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela orcamento
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-11-10
	 *
	**/
	class DTOOrcamento_procedimento{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnOrcamento;
		private $cdnAreaAtuacao;
		private $cdnProcedimento;
		private $cdnDentista;
		private $numQuantidade;
		private $numQuantidadeRealizado = 0;
		private $valUnitario;
		private $numDente;

		/**
		 * Método responsável por setar o código do orçamento
		 *
		 * @param Integer $cdnOrcamento - código numéricdo do orçamento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnOrcamento($cdnOrcamento){
			if($this->validacaoOrcamento($cdnOrcamento)){
				$this->cdnOrcamento = $cdnOrcamento;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código do orçamento
		 *
		 * @return Integer - código numérico do orçamento
		 *
		**/
		public function getCdnOrcamento(){
			return $this->cdnOrcamento;
		}

		/**
		 * Método responsável por setar o código numérico da área de atuação
		 *
		 * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnAreaAtuacao($cdnAreaAtuacao){
			if($this->validacaoAreaAtuacao($cdnAreaAtuacao)){
				$this->cdnAreaAtuacao = $cdnAreaAtuacao;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código da área de atuação
		 *
		 * @return Integer - código numérico da área de atuação
		 *
		**/
		public function getCdnAreaAtuacao(){
			return $this->cdnAreaAtuacao;
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
		 * Método responsável por setar o código numérico do dentista
		 *
		 * @param Integer $cdnDentista - código numérico do dentista
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnDentista($cdnDentista){
			if($this->validacaoDentista($cdnDentista)){
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
		 * Método responsável por setar a quantidade
		 *
		 * @param Integer $numQuantidade - quantidade do procedimento
		 * @return Boolean - true se sucesso, false se não
		 *
		 *
		**/
		public function setNumQuantidade($numQuantidade){
			if($this->validacaoNumero($numQuantidade)){
				$this->numQuantidade = $numQuantidade;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar a quantidade do procedimento
		 *
		 * @return Integer - quantidade do procedimento
		 *
		**/
		public function getNumQuantidade(){
			return $this->numQuantidade;
		}

		public function setNumQuantidadeRealizado($numQuantidadeRealizado){
			if($this->validacaoNumero($numQuantidadeRealizado)){
				$this->numQuantidadeRealizado = $numQuantidadeRealizado;
				return true;
			}
			return false;
		}

		public function getNumQuantidadeRealizado(){
			return $this->numQuantidadeRealizado;
		}

		/**
		 * Método responsável por setar o valor de remuneração
		 *
		 * @param Decimal $valUnitario - valor de remuneração
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setValUnitario($valUnitario){
			if(trim($valUnitario) != ''){
				if(!$this->validacaoDecimal($valUnitario))
					$valUnitario = $this->transformacaoDecimal($valUnitario);
				if($this->validacaoDecimal($valUnitario)){
					$this->valUnitario = $valUnitario;
					return true;
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o valor de remuneração
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Decimal/String - valor de remuneração
		 *
		**/
		public function getValUnitario($indTransforma = false){
			if(!$indTransforma)
				return $this->valUnitario;
			return $this->transformacaoMonetario($this->valUnitario);
		}

		public function setNumDente($numDente){
			$this->numDente = $numDente;
			return true;
		}

		public function getNumDente(){
			return $this->numDente;
		}

	}
