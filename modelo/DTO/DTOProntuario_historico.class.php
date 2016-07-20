<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela prontuario_historico
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-30
	 *
	**/
	class DTOProntuario_historico{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnProntuarioHistorico;
		private $cdnPaciente;
		private $datInicio;
		private $datFim;

		/** 
		 * Método responsável por setar o código numérico do histórico
		 *
		 * @param Integer $cdnProntuarioHistorico - código numérico do histórico
		 * @return Boolean - true se sucesso
		 *
		**/
		public function setCdnProntuarioHistorico($cdnProntuarioHistorico){
			if($this->validacaoNumero($cdnProntuarioHistorico)){
				$this->cdnProntuarioHistorico = $cdnProntuarioHistorico;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do histórico
		 *
		 * @return Integer - código numérico do histórico
		 *
		**/
		public function getCdnProntuarioHistorico(){
			return $this->cdnProntuarioHistorico;
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
		 * Método responsável por setar a data de início do relatório
		 *
		 * @param String $datInicio - data de início
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatInicio($datInicio){
			if($this->validacaoData($datInicio)){
				$this->datInicio = $datInicio;
				return true;
			}else{
				$data = $datInicio;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datInicio = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data de início do relatório
		 *
		 * @param Boolean $indTransformar - transformar para o padrão brasileiro (DD/MM/AAAA).
		 * @return String - data de início do relatório
		 *
		**/
		public function getDatInicio($indTransformar = false){
			if(!$indTransformar)
				return $this->datInicio;
			return $this->transformacaoData($this->datInicio);
		}

		/**
		 * Método responsável por setar a data de fim do relatório
		 *
		 * @param String $datFim - data de fim
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatFim($datFim){
			if($this->validacaoData($datFim)){
				$this->datFim = $datFim;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data de fim do relatório
		 *
		 * @param Boolean $indTransformar - transformar para o padrão brasileiro (DD/MM/AAAA).
		 * @return String - data de fim do relatório
		 *
		**/
		public function getDatFim($indTransformar = false){
			if(!$indTransformar)
				return $this->datFim;
			return $this->transformacaoData($this->datFim);
		}
	}