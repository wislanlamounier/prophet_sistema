<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela prontuario_tratamento
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-30
	 *
	**/
	class DTOProntuario_tratamento{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnProntuarioTratamento;
		private $datProntuarioTratamento;
		private $desProntuarioTratamento;
		private $cdnPaciente;
		private $numDente;
		private $cdnDentista;

		/**
		 * Método responsável por setar o código numérico do tratamento
		 *
		 * @param Integer $cdnProntuarioTratamento - código numérico do tratamento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnProntuarioTratamento($cdnProntuarioTratamento){
			if($this->validacaoNumero($cdnProntuarioTratamento)){
				$this->cdnProntuarioTratamento = $cdnProntuarioTratamento;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do tratamento
		 *
		 * @return Integer - código numérico do tratamento
		 *
		**/
		public function getCdnProntuarioTratamento(){
			return $this->cdnProntuarioTratamento;
		}

		/**
		 * Método responsável por setar a data do tratamento
		 * 
		 * @param String $datProntuarioTratamento - data do tratamento
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatProntuarioTratamento($datProntuarioTratamento){
			if($this->validacaoData($datProntuarioTratamento)){
				$this->datProntuarioTratamento = $datProntuarioTratamento;
				return true;
			}else{
				$data = $datProntuarioTratamento;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datProntuarioTratamento = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data do tratamento
		 *
		 * @param Boolean $indTransforma - transformar para o padrão brasileiro (DD/MM/AAAA).
		 * @return String - data do tratamento
		 *
		**/
		public function getDatProntuarioTratamento($indTransforma = false){
			if(!$indTransforma)
				return $this->datProntuarioTratamento;
			return $this->transformacaoData($this->datProntuarioTratamento);
		}

		/** 
		 * Método responsável por setar a descrição do tratamento
		 *
		 * @param String $desProntuarioTratamento - descrição do tratamento
		 * @return Boolean - true se sucesso, false se nao
		 *
		**/
		public function setDesProntuarioTratamento($desProntuarioTratamento){
			$this->desProntuarioTratamento = $desProntuarioTratamento;
			return true;
		}

		/** 
		 * Método responsável por retornar a descrição do tratamento
		 *
		 * @return String - descrição do tratamento
		 *
		**/
		public function getDesProntuarioTratamento(){
			return $this->desProntuarioTratamento;
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
		 * Método responsável por setar o número do dente
		 *
		 * @param String $numDente - número do dente
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumDente($numDente){
			$this->numDente = $numDente;
			return true;
		}

		/** 
		 * Método responsável por retornar o número do dente
		 *
		 * @return String - número do dente
		 *
		**/
		public function getNumDente(){
			return $this->numDente;
		}

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
	}