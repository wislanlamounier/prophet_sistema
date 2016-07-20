<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela dentista_dias
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-14
	 *
	**/
	class Dentista_fechado{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnFechado;
		private $cdnDentista;
		private $datFechado;
		private $desFechado;
		private $indAllDay;
		private $horaInicio;
		private $horaFinal;

		/**
		 * Método responsável por setar o código numérico da data
		 *
		 * @param Integer $cdnFechado - código numérico da data
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnFechado($cdnFechado){
			$this->cdnFechado = $cdnFechado;
			return true;
		}

		/**
		 * Método responsável por setar o código numérico da data
		 *
		 * @return Integer - código numérico da data
		 *
		**/
		public function getCdnFechado(){
			return $this->cdnFechado;
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

		/**
		 * Método responsável por setar a data que o dentista não estará disponível
		 *
		 * @param String - data
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatFechado($datFechado){
			if($this->validacaoData($datFechado)){
				$this->datFechado = $datFechado;
				return true;
			}else{
				$data = $datFechado;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datFechado = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data que o dentista não estará disponível
		 *
		 * @param Boolean $indTransforma - transformar para padrão brasileiro DD/MM/YYYY
		 * @return String - data
		 *
		**/
		public function getDatFechado($indTransforma = false){
			if(!$indTransforma)
				return $this->datFechado;
			return $this->transformacaoData($this->datFechado);
		}

		/**
		 * Método responsável por setar a observação da data
		 *
		 * @param String $desFechado - observação da data
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDesFechado($desFechado){
			$this->desFechado = $desFechado;
			return true;
		}

		/**
		 * Método responsável por retornar a descrição da data
		 *
		 * @return String - descrição da data
		 *
		**/
		public function getDesFechado(){
			return $this->desFechado;
		}

		public function setIndAllDay($indAllDay){
			$this->indAllDay = $indAllDay;
		}

		public function getIndAllDay($indTransforma = false){
			if(!$indTransforma)
				return $this->indAllDay;
			return $this->transformacaoSim($this->indAllDay);
		}

		public function setHoraInicio($horaInicio){
			if($this->validacaoHorario($horaInicio)){
				$this->horaInicio = $horaInicio;
				return true;
			}
			return false;
		}

		public function getHoraInicio(){
			return $this->horaInicio;
		}

		public function setHoraFinal($horaFinal){
			if($this->validacaoHorario($horaFinal)){
				$this->horaFinal = $horaFinal;
				return true;
			}
			return false;
		}

		public function getHoraFinal(){
			return $this->horaFinal;
		}
	}