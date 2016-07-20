<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela dentista_dias
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-14
	 *
	**/
	class Dentista_dias{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnDentista;
		private $indDomingo;
		private $indSegunda;
		private $indTerca;
		private $indQuarta;
		private $indQuinta;
		private $indSexta;
		private $indSabado;
		private $horaDomingoManha;
		private $horaSegundaManha;
		private $horaTercaManha;
		private $horaQuartaManha;
		private $horaQuintaManha;
		private $horaSextaManha;
		private $horaSabadoManha;
		private $horaDomingoTarde;
		private $horaSegundaTarde;
		private $horaTercaTarde;
		private $horaQuartaTarde;
		private $horaQuintaTarde;
		private $horaSextaTarde;
		private $horaSabadoTarde;
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


		public function setHoraDomingoManha($horaDomingoManha){
			if(is_null($horaDomingoManha)){
				$this->horaDomingoManha = $horaDomingoManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaDomingoManha)){
				$this->horaDomingoManha = $horaDomingoManha;
				return true;
			}
			return false;
		}

		public function getHoraDomingoManha(){
			return $this->horaDomingoManha;
		}

		public function setHoraSegundaManha($horaSegundaManha){
			if(is_null($horaSegundaManha)){
				$this->horaSegundaManha = $horaSegundaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaSegundaManha)){
				$this->horaSegundaManha = $horaSegundaManha;
				return true;
			}
			return false;
		}

		public function getHoraSegundaManha(){
			return $this->horaSegundaManha;
		}

		public function setHoraTercaManha($horaTercaManha){
			if(is_null($horaTercaManha)){
				$this->horaTercaManha = $horaTercaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaTercaManha)){
				$this->horaTercaManha = $horaTercaManha;
				return true;
			}
			return false;
		}

		public function getHoraTercaManha(){
			return $this->horaTercaManha;
		}

		public function setHoraQuartaManha($horaQuartaManha){
			if(is_null($horaQuartaManha)){
				$this->horaQuartaManha = $horaQuartaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaQuartaManha)){
				$this->horaQuartaManha = $horaQuartaManha;
				return true;
			}
			return false;
		}

		public function getHoraQuartaManha(){
			return $this->horaQuartaManha;
		}

		public function setHoraQuintaManha($horaQuintaManha){
			if(is_null($horaQuintaManha)){
				$this->horaQuintaManha = $horaQuintaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaQuintaManha)){
				$this->horaQuintaManha = $horaQuintaManha;
				return true;
			}
			return false;
		}

		public function getHoraQuintaManha(){
			return $this->horaQuintaManha;
		}

		public function setHoraSextaManha($horaSextaManha){
			if(is_null($horaSextaManha)){
				$this->horaSextaManha = $horaSextaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaSextaManha)){
				$this->horaSextaManha = $horaSextaManha;
				return true;
			}
			return false;
		}

		public function getHoraSextaManha(){
			return $this->horaSextaManha;
		}

		public function setHoraSabadoManha($horaSabadoManha){
			if(is_null($horaSabadoManha)){
				$this->horaSabadoManha = $horaSabadoManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaSabadoManha)){
				$this->horaSabadoManha = $horaSabadoManha;
				return true;
			}
			return false;
		}

		public function getHoraSabadoManha(){
			return $this->horaSabadoManha;
		}
		public function setHoraDomingoTarde($horaDomingoTarde){
			if(is_null($horaDomingoTarde)){
				$this->horaDomingoTarde = $horaDomingoTarde;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaDomingoTarde)){
				$this->horaDomingoTarde = $horaDomingoTarde;
				return true;
			}
			return false;
		}

		public function getHoraDomingoTarde(){
			return $this->horaDomingoTarde;
		}

		public function setHoraSegundaTarde($horaSegundaTarde){
			if(is_null($horaSegundaTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaSegundaTarde)){
				$this->horaSegundaTarde = $horaSegundaTarde;
				return true;
			}
			return false;
		}

		public function getHoraSegundaTarde(){
			return $this->horaSegundaTarde;
		}

		public function setHoraTercaTarde($horaTercaTarde){
			if(is_null($horaTercaTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaTercaTarde)){
				$this->horaTercaTarde = $horaTercaTarde;
				return true;
			}
			return false;
		}

		public function getHoraTercaTarde(){
			return $this->horaTercaTarde;
		}

		public function setHoraQuartaTarde($horaQuartaTarde){
			if(is_null($horaQuartaTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaQuartaTarde)){
				$this->horaQuartaTarde = $horaQuartaTarde;
				return true;
			}
			return false;
		}

		public function getHoraQuartaTarde(){
			return $this->horaQuartaTarde;
		}

		public function setHoraQuintaTarde($horaQuintaTarde){
			if(is_null($horaQuintaTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaQuintaTarde)){
				$this->horaQuintaTarde = $horaQuintaTarde;
				return true;
			}
			return false;
		}

		public function getHoraQuintaTarde(){
			return $this->horaQuintaTarde;
		}

		public function setHoraSextaTarde($horaSextaTarde){
			if(is_null($horaSextaTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaSextaTarde)){
				$this->horaSextaTarde = $horaSextaTarde;
				return true;
			}
			return false;
		}

		public function getHoraSextaTarde(){
			return $this->horaSextaTarde;
		}

		public function setHoraSabadoTarde($horaSabadoTarde){
			if(is_null($horaSabadoTarde))
				return true;
			if($this->validacaoIntervaloHorario($horaSabadoTarde)){
				$this->horaSabadoTarde = $horaSabadoTarde;
				return true;
			}
			return false;
		}

		public function getHoraSabadoTarde(){
			return $this->horaSabadoTarde;
		}
	}