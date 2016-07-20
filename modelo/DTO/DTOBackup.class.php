<?php

	class DTOBackup{
		use DTO;
		use Validacao;
		use Transformacao;

		private $cdnBackup;
		private $cdnClinica;
		private $cdnUsuario;
		private $datBackup;
		private $nomArquivo;

		public function setCdnBackup($cdnBackup) {
			$this->cdnBackup = $cdnBackup; 
		}

		public function getCdnBackup() { 
			return $this->cdnBackup; 
		}

		public function setCdnClinica($cdnClinica) {
			$this->cdnClinica = $cdnClinica; 
		}

		public function getCdnClinica() { 
			return $this->cdnClinica; 
		}

		public function setCdnUsuario($cdnUsuario) {
			$this->cdnUsuario = $cdnUsuario; 
		}

		public function getCdnUsuario() { 
			return $this->cdnUsuario; 
		}

		public function setDatBackup($datBackup) {
			$this->datBackup = $datBackup; 
		}

		public function getDatBackup($indTransformar = false) { 
			if(!$indTransformar)
				return $this->datBackup; 
			return $this->transformacaoDatetime($this->datBackup);
		}

		public function setNomArquivo($nomArquivo) {
			$this->nomArquivo = $nomArquivo; 
		}

		public function getNomArquivo() { 
			return $this->nomArquivo; 
		}


	}