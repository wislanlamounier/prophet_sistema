<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela clinica
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-11
	 *
	**/
	class DTOCronometro{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnCronometro;
		private $cdnConsulta;
		private $datCronometro;
		private $cdnPaciente;
		private $horaChegada;
		private $horaEntrada;
		private $horaSaida;

		/**
		 * Método responsável por setar o código numérico do cronômetro
		 *
		 * @param Integer $cdnCronometro - código numérico do cronômetro
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnCronometro($cdnCronometro){
			$this->cdnCronometro = $cdnCronometro;
			return true;
		}

		/** 
		 * Método responsável por retornar o código numérico do cronômetro
		 *
		 * @return Integer - código numérico do cronômetro
		 *
		**/
		public function getCdnCronometro(){
			return $this->cdnCronometro;
		}


		/**
		 * Método responsável por setar o código numérico da consulta
		 *
		 * @param Integer $cdnConsulta - código numérico da consulta
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnConsulta($cdnConsulta){
			$this->cdnConsulta = $cdnConsulta;
			return true;
		}

		/**
		 * Método responsável por retornar o código numérico da consulta
		 *
		 * @return Integer - código numérico da consulta
		 *
		**/
		public function getCdnConsulta(){
			return $this->cdnConsulta;
		}

		/**
		 * Método responsável por setar a data do cronometro
		 *
		 * @param String $datCronometro - data do cronometro
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatCronometro($datCronometro){
			if($this->validacaoData($datCronometro)){
				$this->datCronometro = $datCronometro;
				return true;
			}else{
				$data = $datCronometro;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datCronometro = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método resposável por retornar a data do cronometro
		 *
		 * @param Boolean $indTransforma - transformar para padrão brasileiro
		 * @return String - data do cronometro
		 *
		**/
		public function getDatCronometro($indTransforma = false){
			if(!$indTransforma)
				return $this->datCronometro;
			return $this->transformacaoData($this->datCronometro);
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
	 	 * Método responsável por setar a hora de chegada do paciente
	 	 *
	 	 * @param String $horaChegada - chora de chegada
	 	 * @return Boolean - true se sucesso, false se não
	 	 *
	 	**/
	 	public function setHoraChegada($horaChegada){
	 		if(trim($horaChegada) != ''){
		 		if($this->validacaoDatetime($horaChegada)){
		 			$this->horaChegada = $horaChegada;
		 			return true;
		 		}
		 		return false;
		 	}
		 	if(is_null($horaChegada))
		 		return false;
	 	}

	 	/**
	 	 * Método responsável por retornar a hora de chegada do paciente
	 	 *
	 	 * @return String - hora de chegada
	 	 *
	 	**/
	 	public function getHoraChegada(){
	 		return $this->horaChegada;
	 	}

		/** 
	 	 * Método responsável por setar a hora de entrada em consultório do paciente
	 	 *
	 	 * @param String $horaEntrada - chora de entrada em consultório
	 	 * @return Boolean - true se sucesso, false se não
	 	 *
	 	**/
	 	public function setHoraEntrada($horaEntrada){
		 	if(is_null($horaEntrada)){
	 			$this->horaEntrada = $horaEntrada;
	 			return true;
		 	}
		 		
	 		if(trim($horaEntrada) != ''){
		 		if($this->validacaoDatetime($horaEntrada)){
		 			$this->horaEntrada = $horaEntrada;
		 			return true;
		 		}
		 		return false;
		 	}
	 	}

	 	/**
	 	 * Método responsável por retornar a hora de entrada em consultório do paciente
	 	 *
	 	 * @return String - hora de entrada em consultório
	 	 *
	 	**/
	 	public function getHoraEntrada(){
	 		return $this->horaEntrada;
	 	}

		/** 
	 	 * Método responsável por setar a hora de saída de consultorio do paciente
	 	 *
	 	 * @param String $horaSaida - chora de saída de consultorio
	 	 * @return Boolean - true se sucesso, false se não
	 	 *
	 	**/
	 	public function setHoraSaida($horaSaida){
	 		if(trim($horaSaida) != ''){
		 		if($this->validacaoDatetime($horaSaida)){
		 			$this->horaSaida = $horaSaida;
		 			return true;
		 		}
		 		return false;
		 	}
		 	if(is_null($horaSaida))
		 		return true;
	 	}

	 	/**
	 	 * Método responsável por retornar a hora de saída de consultorio do paciente
	 	 *
	 	 * @return String - hora de saída de consultorio
	 	 *
	 	**/
	 	public function getHoraSaida(){
	 		return $this->horaSaida;
	 	}

	 }