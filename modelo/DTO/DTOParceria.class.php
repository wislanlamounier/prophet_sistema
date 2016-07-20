<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela estilo
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-24
	 *
	**/
	class DTOParceria{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnIndicacao;
		private $indPaciente;
		private $cdnParceria;
		private $codCep;
		private $codCpfCnpj;
		private $codIe;
		private $codUf;
		private $datContrato;
		private $desParceria;
		private $indDesvinculada;
		private $indFisica;
		private $nomCidade;
		private $nomParceria;
		private $nomRepresentante;
		private $numContrato;
		private $numRepresentanteTelefone;
		private $numTelefone1;
		private $numTelefone2;
		private $strEmail;
		private $strEndereco;
		private $strRepresentanteEmail;

		/**
		 * Método responsável por setar o valor do código numérico da indicação
		 *
		 * @param Integer $cdnIndicacao - código numérico da indicação
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnIndicacao($cdnIndicacao){
			if($this->validacaoNumero($cdnIndicacao)){
				$this->cdnIndicacao = $cdnIndicacao;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da indicação
		 *
		 * @return Integer - código numérico da indicação
		 *
		**/
		public function getCdnIndicacao(){
			return $this->cdnIndicacao;
		}

		/** 
		 * Método responsável por setar se a indicação veio de um paciente ou funcionário
		 *
		 * @param Boolean - true se foi paciente, false se não
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndPaciente($indPaciente){
			$this->indPaciente = $indPaciente;
			return true;
		}

		/**
		 * Método responsável por retornar se a indicação veio se um paciente
		 *
		 * @return Boolean - true se foi paciente, false se não
		 *
		**/
		public function getIndPaciente(){
			return $this->indPaciente;
		}

		/**
		 * Método responsável por setar o código numérico da parceria
		 *
		 * @param Integer $cdnParceria - código numérico da parceria
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnParceria($cdnParceria){ 
			if($this->validacaoNumero($cdnParceria)){
				$this->cdnParceria = $cdnParceria; 
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico da parceria
		 * 
		 * @return Integer - código numérico da parceria
		 *
		**/
		public function getCdnParceria(){ 
			return $this->cdnParceria; 
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
		 * Método responsável por setar o código do CPF/CNPJ
		 *
		 * @param String $codCpfCnpj - código do CPF/CNPJ
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodCpfCnpj($codCpfCnpj){
			if($this->validacaoCpfCnpj($codCpfCnpj)){
				$this->codCpfCnpj = $codCpfCnpj;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código do CPF/CNPJ
		 *
		 * @return String - código do CPF/CNPJ
		 *
		**/
		public function getCodCpfCnpj(){
			return $this->codCpfCnpj;
		}

		/** 
		 * Método responsável por setar a inscrição estadual
		 *
		 * @param String $codIe - inscrição estadual
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodIe($codIe){ 
			$this->codIe = $codIe; 
			return true;
		}

		/** 
		 * Método responsável por retornar a inscrição estadual
		 * 
		 * @return String - inscrição estadual
		 *
		**/
		public function getCodIe(){ 
			return $this->codIe; 
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
		 * Método responsável por setar a data do contrato
		 *
		 * @param String $datContrato - data do contrato
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatContrato($datContrato){
			if($this->validacaoData($datContrato)){
				$this->datContrato = $datContrato; 
				return true;
			}else{
				$data = $datContrato;
				$data = explode('/', $data);
				if(count($data) == 3){
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					$this->datContrato = $data;
					return true;
				}
			}
			return false;
		}

		/**
		 * Método resposável por retornar a data do contrato
		 * 
		 * @param Boolean $indTransforma - transformar para padrão brasileiro (dd/mm/yyyy).
		 * @return String - data do contrato
		 *
		**/
		public function getDatContrato($indTransforma = false){
			if(!$indTransforma)
				return $this->datContrato; 
			return $this->transformacaoData($this->datContrato);
		}

		/** 
		 * Método responsável por setar observações da parceria
		 *
		 * @param String $desParceria - observações da parceria
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDesParceria($desParceria){
			$this->desParceria = $desParceria;
			return true;
		}

		/** 
		 * Método responsável por retornar observações da parceria
		 *
		 * @return String - observações da parceria
		 *
		**/
		public function getDesParceria(){
			return $this->desParceria;
		}

		/**
		 * Método responsável por setar se a clínica é uma pessoa física
		 *
		 * @param Boolean $indFisica - true se é, false se não.
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function setIndFisica($indFisica){
			$this->indFisica = $indFisica;
			return true;
		}

		/**
		 * Método responsável por retornar se a clínica é uma pessoa física
		 *
		 * @param Boolean $indTransforma - transformar para Sim/Não. Padrão: false.
		 * @return Boolean - true se é, false se não
		 *
		**/
		public function getIndFisica($indTransforma = false){
			if(!$indTransforma)
				return $this->indFisica;
			if($this->indFisica)
				return 'Sim';
			else
				return 'Não';
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
		 * Método responsável por setar o nome da parceria
		 * 
		 * @param String $nomParceria - nome da parceria
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomParceria($nomParceria){ 
			$this->nomParceria = $nomParceria; 
			return true;
		}

		/**
		 * Método responsável por retornar o nome da parceria
		 *
		 * @return String - nome da parceria
		 *
		**/
		public function getNomParceria(){ 
			return $this->nomParceria; 
		}

		        /**
         * Método responsável por setar o nome do representante
         *
         * @param String $nomRepresentante - nome do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomRepresentante($nomRepresentante){
            $this->nomRepresentante = $nomRepresentante;
            return true;
        }

        /**
         * Método responsável por retornar o nome do representante
         *
         * @return String - nome do representante
         *
        **/
        public function getNomRepresentante(){
            return $this->nomRepresentante;
        }

		/**
		 * Método repsonsável por setar o número do contrato
		 *
		 * @param String $numContrato - número do contrato
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumContrato($numContrato){ 
			$this->numContrato = $numContrato; 
			return true;
		}

		/** 
		 * Método responsável por retornar o número do contrato
		 *
		 * @return String $numContrato - número do contrato
		 *
		**/
		public function getNumContrato(){ 
			return $this->numContrato; 
		}

        /**
         * Método responsável por setar o telefone do representante
         *
         * @param String $numRepresentanteTelefone - telefone do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNumRepresentanteTelefone($numRepresentanteTelefone){
            $this->numRepresentanteTelefone = $numRepresentanteTelefone;
            return true;
        }

        /**
         * Método responsável por retornar o telefone do representante
         *
         * @return String - telefone do representante
         *
        **/
        public function getNumRepresentanteTelefone(){
            return $this->numRepresentanteTelefone;
        }

        /**
		 * Método responsável por setar o número de telefone 1
		 *
		 * @param String $numTelefone1 - número de telefone 1
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumTelefone1($numTelefone1){
			$this->numTelefone1 = $numTelefone1;
			return true;
		}

		/**
		 * Método responsável por retornar o número de telefone 1
		 *
		 * @return String - número de telefone 1
		 *
		**/
		public function getNumTelefone1(){
			return $this->numTelefone1;
		}

		/**
		 * Método responsável por setar o número de telefone 2
		 *
		 * @param String $numTelefone2 - número de telefone 2
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNumTelefone2($numTelefone2){
			$this->numTelefone2 = $numTelefone2;
			return true;
		}

		/**
		 * Método responsável por retornar o número de telefone 2
		 *
		 * @return String - número de telefone 2
		 *
		**/
		public function getNumTelefone2(){
			return $this->numTelefone2;
		}

        /**
         * Método responsável por setar o email da clínica radiológica
         *
         * @param String $strEmail - email da clínica radiológica
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrEmail($strEmail){
            if(trim($strEmail) != ''){
                if($this->validacaoEmail($strEmail)){
                    $this->strEmail = $strEmail;
                    return true;
                }
                return false;
            }
            return true;
        }

        /**
         * Método responsável por retornar o email do representante
         *
         * @return String - email do representante
         *
        **/
        public function getStrEmail(){
            return $this->strEmail;
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
         * Método responsável por setar o email do representante
         *
         * @param String $strRepresentanteEmail - email do representante
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrRepresentanteEmail($strRepresentanteEmail){
            if(trim($strRepresentanteEmail) != ''){
                if($this->validacaoEmail($strRepresentanteEmail)){
                    $this->strRepresentanteEmail = $strRepresentanteEmail;
                    return true;
                }
                return false;
            }
            return true;
        }

        /**
         * Método responsável por retornar o email do representante
         *
         * @return String - email do representante
         *
        **/
        public function getStrRepresentanteEmail(){
            return $this->strRepresentanteEmail;
        }

		/**
		 * Método responsável por setar o desvinculamento
		 *
		 * @param Boolean $indDesvinculada - oferta desvinculada do sistema
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndDesvinculada($indDesvinculada){
			$this->indDesvinculada = $indDesvinculada;
			return true;
		}

		/**
		 * Método responsável por retornar se a oferta está desvinculada
		 *
		 * @return Boolean - oferta desvinculada
		 *
		**/
		public function getIndDesvinculada(){
			return $this->indDesvinculada;
		}

    }
