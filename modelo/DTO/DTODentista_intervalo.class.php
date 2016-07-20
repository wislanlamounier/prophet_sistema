<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela dentista_intervalo
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-02-01
	 *
	**/
	class DTODentista_intervalo{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnDentista;
		private $cdnIntervalo;
		private $datIntervalo;
		private $horaFinal;
		private $horaInicio;
		private $indPermanente;
		private $indDomingo;
		private $indSegunda;
		private $indTerca;
		private $indQuarta;
		private $indQuinta;
		private $indSexta;
		private $indSabado;

		public function setCdnDentista($cdnDentista) {
			if($this->validacaoDentista($cdnDentista)){
				$this->cdnDentista = $cdnDentista; 
				return true;
			}
			return false;
		}

		public function getCdnDentista() { 
			return $this->cdnDentista; 
		}

		public function setCdnIntervalo($cdnIntervalo) {
			$this->cdnIntervalo = $cdnIntervalo; 
		}

		public function getCdnIntervalo() { 
			return $this->cdnIntervalo; 
		}

		public function setDatIntervalo($datIntervalo) {
			if(trim($datIntervalo) != ''){
				if($this->validacaoData($datIntervalo)){
					$this->datIntervalo = $datIntervalo;
					return true;
				}else{
					$data = $datIntervalo;
					$data = explode('/', $data);
					if(count($data) == 3){
						$data = $data[2].'-'.$data[1].'-'.$data[0];
						$this->datIntervalo = $data;
						return true;
					}
				}
			}else{
				return true;
			}
			return false;
		}

		public function getDatIntervalo($indTransforma = false) { 
			if(!$indTransforma)
				return $this->datIntervalo;
			return $this->transformacaoData($this->datIntervalo);
		}

		public function setHoraFinal($horaFinal) {
			if($this->validacaoHorario($horaFinal)){
				$this->horaFinal = $horaFinal; 
				return true;
			}
			return false;
		}

		public function getHoraFinal() { 
			return $this->horaFinal; 
		}

		public function setHoraInicio($horaInicio) {
			if($this->validacaoHorario($horaInicio)){
				$this->horaInicio = $horaInicio; 
				return true;
			}
			return false;
		}

		public function getHoraInicio() { 
			return $this->horaInicio; 
		}

		public function setIndPermanente($indPermanente) {
			$this->indPermanente = $indPermanente; 
		}
		public function getIndPermanente($indTransforma = false) { 
			if(!$indTransforma)
				return $this->indPermanente; 
			return $this->transformacaoSim($this->indPermanente);
		}

/**
		 * Método responsável por setar o domingo
		 *
		 * @param Boolean $indDomingo - trabalha no domingo
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndDomingo($indDomingo){
			$this->indDomingo = $indDomingo;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha no domingo
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no domingo
		 *
		**/
		public function getIndDomingo($indTransforma = false){
			if(!$indTransforma)
				return $this->indDomingo;
			return $this->transformacaoSim($this->indDomingo);
		}

		/**
		 * Método responsável por setar a segunda
		 *
		 * @param Boolean $indSegunda - trabalha na segunda
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndSegunda($indSegunda){
			$this->indSegunda = $indSegunda;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha na segunda
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no segunda
		 *
		**/
		public function getIndSegunda($indTransforma = false){
			if(!$indTransforma)
				return $this->indSegunda;
			return $this->transformacaoSim($this->indSegunda);
		}

		/**
		 * Método responsável por setar a terça
		 *
		 * @param Boolean $indTerca - trabalha na terça
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndTerca($indTerca){
			$this->indTerca = $indTerca;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha na terça
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no terça
		 *
		**/
		public function getIndTerca($indTransforma = false){
			if(!$indTransforma)
				return $this->indTerca;
			return $this->transformacaoSim($this->indTerca);
		}

		/**
		 * Método responsável por setar a quarta
		 *
		 * @param Boolean $indQuarta - trabalha na quarta
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndQuarta($indQuarta){
			$this->indQuarta = $indQuarta;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha na quarta
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha na quarta
		 *
		**/
		public function getIndQuarta($indTransforma = false){
			if(!$indTransforma)
				return $this->indQuarta;
			return $this->transformacaoSim($this->indQuarta);
		}

		/**
		 * Método responsável por setar a quinta
		 *
		 * @param Boolean $indQuinta - trabalha na quinta
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndQuinta($indQuinta){
			$this->indQuinta = $indQuinta;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha na quinta
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no quinta
		 *
		**/
		public function getIndQuinta($indTransforma = false){
			if(!$indTransforma)
				return $this->indQuinta;
			return $this->transformacaoSim($this->indQuinta);
		}

		/**
		 * Método responsável por setar a sexta
		 *
		 * @param Boolean $indSexta - trabalha na sexta
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndSexta($indSexta){
			$this->indSexta = $indSexta;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha na sexta
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no sexta
		 *
		**/
		public function getIndSexta($indTransforma = false){
			if(!$indTransforma)
				return $this->indSexta;
			return $this->transformacaoSim($this->indSexta);
		}

				/**
		 * Método responsável por setar o sábado
		 *
		 * @param Boolean $indSabado - trabalha no sábado
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndSabado($indSabado){
			$this->indSabado = $indSabado;
			return true;
		}

		/**
		 * Método responsável por retornar se trabalha no sábado
		 *
		 * @param Boolean $indTransforma - transformar para sim/não.
		 * @return Boolean - trabalha no sábado
		 *
		**/
		public function getIndSabado($indTransforma = false){
			if(!$indTransforma)
				return $this->indSabado;
			return $this->transformacaoSim($this->indSabado);
		}

	}