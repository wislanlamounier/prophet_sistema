<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela orcamento_parcela
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-11-11
	 *
	**/
	class DTOOrcamento_parcela{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnOrcamento;
		private $numParcela;
		private $valParcela;
		private $datVencimento;
		private $indPaga = 0;

		/**
		 * Método responsável por setar o código numérico do orçamento
		 * 
		 * @param Integer $cdnOrcamento - código numérico do orçamento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnOrcamento($cdnOrcamento){
			if($this->validacaoNumero($cdnOrcamento)){
				$this->cdnOrcamento = $cdnOrcamento;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do orçamento
		 *
		 * @return Integer - código numérico do orçamento
		 *
		**/
		public function getCdnOrcamento(){
			return $this->cdnOrcamento;
		}

		/**
		 * Método responsável por setar o número da parcela
		 *
		 * @param Integer $numParcela - número da parcela
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumParcela($numParcela){
			if(!$this->validacaoNumero($numParcela)){
				return false;
			}
			$this->numParcela = $numParcela;
		}

		/**
		 * Método responsável por retornar o número da parcela
		 * 
		 * @return Integer - número da parcela
		 *
		**/
		public function getNumParcela(){
			return $this->numParcela;
		}

		/**
		 * Método responsável por setar o valor da parcela
		 *
		 * @param Decimal $valParcela - valor da parcela
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setValParcela($valParcela){
			if(trim($valParcela) != ''){
				if(!$this->validacaoDecimal($valParcela))
					$valParcela = $this->transformacaoDecimal($valParcela);
				
				if($this->validacaoDecimal($valParcela)){
					$this->valParcela = $valParcela;
					return true;
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o valor da parcela
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Decimal/String - valor da parcela
		 *
		**/
		public function getValParcela($indTransforma = false){
			if(!$indTransforma)
				return $this->valParcela;
			return $this->transformacaoMonetario($this->valParcela);
		}

		/**
		 * Método responsável por setar a data de vencimento
		 *
		 * @param String $datVencimento - data de vencimento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatVencimento($datVencimento){
			if($this->validacaoData($datVencimento)){
				$this->datVencimento = $datVencimento;
				return true;
			}else{
				$data = $datVencimento;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datVencimento = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data de vencimento
		 *
		 * @param Boolean $indTransforma - transformar para padrão brasileiro (dd/mm/aaaa).
		 * @return String - data do orçamento
		 *
		**/
		public function getDatVencimento($indTransforma = false){
			if(!$indTransforma)
				return $this->datVencimento;
			return $this->transformacaoData($this->datVencimento);
		}	

		/**
		 * Método responsável por setar se a parcela foi paga
		 *
		 * @param Boolean $indPaga - parcela foi paga
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndPaga($indPaga){
			$this->indPaga = $indPaga;
			return true;			
		}

		/**
		 * Método responsável por retornar se a parcela foi paga
		 *
		 * @param Boolean $indTransformar - transformar para Sim/Não
		 * @return Boolean/Text - parcela foi paga
		 *
		**/
		public function getIndPaga($indTransformar = false){
			if(!$indTransformar)
				return $this->indPaga;
			return $this->transformacaoSim($this->indPaga);
		}

	}