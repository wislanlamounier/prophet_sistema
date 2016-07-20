<?php

	class DTODentista_aberto{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnAberto;
		private $cdnDentista;
		private $horaManha;
		private $horaTarde;
		private $datAberto;

		public function setCdnAberto($cdnAberto){
			$this->cdnAberto = $cdnAberto;
		}

		public function getCdnAberto(){
			return $this->cdnAberto;
		}

		public function setCdnDentista($cdnDentista){
			if($this->validacaoNumero($cdnDentista)){
				$this->cdnDentista = $cdnDentista;
				return true;
			}
			return false;
		}

		public function getCdnDentista(){
			return $this->cdnDentista;
		}

		public function setHoraManha($horaManha){
			if(is_null($horaManha)){
				$this->horaManha = $horaManha;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaManha)){
				$this->horaManha = $horaManha;
				return true;
			}
			return false;
		}

		public function getHoraManha(){
			return $this->horaManha;
		}

		public function setHoraTarde($horaTarde){
			if(is_null($horaTarde)){
				$this->horaTarde = $horaTarde;
				return true;
			}
			if($this->validacaoIntervaloHorario($horaTarde)){
				$this->horaTarde = $horaTarde;
				return true;
			}
			return false;
		}

		public function getHoraTarde(){
			return $this->horaTarde;
		}

		public function setDatAberto($datAberto){
			if($this->validacaoData($datAberto)){
				$this->datAberto = $datAberto;
				return true;
			}else{
				$data = $datAberto;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datAberto = $data;
					return true;
				}
			}
			return false;
		}

		public function getDatAberto($indTransforma = false){
			if(!$indTransforma)
				return $this->datAberto;
			return $this->transformacaoData($this->datAberto);
		}

	}