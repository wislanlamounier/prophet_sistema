<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela paciente_responsavel
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-01
	 *
	**/
	class DTOPaciente_responsavel{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnPaciente;
		private $cdnPacienteResponsavel;
		private $nomResponsavel;
		private $strEndereco;
		private $codCep;
		private $nomCidade;
		private $codUf;
		private $numTelefones;
		private $codCpf;

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
		 * Método responsável por setar o código numérico do paciente responsável
		 * 
		 * @param Integer $cdnPacienteResponsavel - código numérico do paciente responsável
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnPacienteResponsavel($cdnPacienteResponsavel){
			if($this->validacaoNumero($cdnPacienteResponsavel)){
				$this->cdnPacienteResponsavel = $cdnPacienteResponsavel; 
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por setar o código numérico do paciente responsável
		 *
		 * @return Integer - código númerico do paciente responsável
		 *
		**/
		public function getCdnPacienteResponsavel(){ 
			return $this->cdnPacienteResponsavel; 
		}

		/**
		 * Método responsável por setar o nome do responsável
		 *
		 * @param String $nomResponsavel - nome do responsável
		 * @return Boolean - true se sucesso
		 *
		**/
		public function setNomResponsavel($nomResponsavel){
			$this->nomResponsavel = $nomResponsavel;
			return true;
		}

		/**
		 * Método responsável por retornar o nome do responsável
		 *
		 * @return String - nome do responsável
		 *
		**/
		public function getNomResponsavel(){
			return $this->nomResponsavel;
		}

        /**
         * Método responsável por setar o endereço
         *
         * @param String $strEndereco - endereço
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrEndereco($strEndereco){
            $this->strEndereco = $strEndereco;
            return true;
        }

        /**
         * Método responsável por retornar o endereço
         *
         * @return String - endereço
         *
        **/
        public function getStrEndereco(){
            return $this->strEndereco;
        }

		/**
		 * Método responsável por retornar o CEP
		 *
		 * @param String $codCep - código CEP
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodCep($codCep){
			$this->codCep = $codCep;
			return true;
		}

		/**
		 * Método responsável por retornar o CEP
		 *
		 * @return String - código CEP
		 *
		**/
		public function getCodCep(){
			return $this->codCep;
		}

		/**
		 * Método responsável por setar o nome da cidade
		 *
		 * @param String $nomCidade - nome da cidade
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomCidade($nomCidade){
			$this->nomCidade = $nomCidade;
			return true;
		}

		/**
		 * Método responsável por retornar o nome da cidade
		 *
		 * @return String - nome da cidade
		 *
		**/
		public function getNomCidade(){
			return $this->nomCidade;
		}


		/**
		 * Método responsável por setar o código do UF
		 *
		 * @param String $codUf - código UF
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodUf($codUf){
			if($this->validacaoUf($codUf)){
				$this->codUf = $codUf;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código do UF
		 *
		 * @param Boolean $indTransforma - transformar para nome completo. Padrão: false
		 * @return String - estado
		 *
		**/
		public function getCodUf($indTransforma = false){
			if(!$indTransforma)
				return $this->codUf;
			return $this->transformacaoUf($this->codUf);
		}

		/** 
		 * Método responsável por setar o número dos telefones do responsável
		 *
		 * @param String $numTelefones - número dos telefones
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumTelefones($numTelefones){
			$this->numTelefones = $numTelefones;
			return true;
		}

		/**
		 * Método responsável por retornar os telefones do responsável
		 *
		 * @return String - número dos telefones
		 *
		**/
		public function getNumTelefones(){
			return $this->numTelefones;
		}

		/**
		 * Método responsável por setar o código do CPF
		 *
		 * @param String $codCpf - código do CPF
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodCpf($codCpf){
			if(trim($codCpf) != ''){
				if($this->validacaoCpf($codCpf)){
					$this->codCpf = $codCpf;
					return true;
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código do CPF
		 *
		 * @return String - código do CPF
		 *
		**/
		public function getCodCpf(){
			return $this->codCpf;
		}
	}