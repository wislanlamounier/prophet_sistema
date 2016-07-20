<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela colaborador
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-10
	 *
	**/
	class DTOColaborador{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnUsuario;
		private $codCep;
		private $codCpf;
		private $codUf;
		private $datNascimento;
		private $datAdmissao;
		private $desColaborador;
		private $indDesativado = 0;
		private $indPorcentagem;
		private $nomCidade;
		private $numTelefone1;
		private $numTelefone2;
		private $strEndereco;
		private $valRemuneracao;

		/**
		 * Método responsável por setar o valor do código numérico do usuário
		 *
		 * @param Integer $cdnUsuario - código numérico do usuário
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnUsuario($cdnUsuario){
			if($this->validacaoNumero($cdnUsuario)){
				$this->cdnUsuario = $cdnUsuario;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do usuário
		 *
		 * @return Integer - código numérico do usuário
		 *
		**/
		public function getCdnUsuario(){
			return $this->cdnUsuario;
		}

		/**
		 * Método responsável por retornar o CEP do colaborador
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
		 * Método responsável por retornar o CEP do colaborador
		 *
		 * @return String - código CEP
		 *
		**/
		public function getCodCep(){
			return $this->codCep;
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

		/**
		 * Método responsável por setar o código do UF
		 *
		 * @param String $codUf - código UF
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCodUf($codUf){
			if(trim($codUf) != ''){
				if($this->validacaoUf($codUf)){
					$this->codUf = $codUf;
					return true;
				}
			}else{
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
		 * Método responsável por setar a data de nascimento
		 *
		 * @param Date $datNascimento - data de nascimento. Formato yyyy-mm-dd
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatNascimento($datNascimento){
			if(trim($datNascimento) != ''){
				if($this->validacaoData($datNascimento)){
					$this->datNascimento = $datNascimento;
					return true;
				}else{
					$data = $datNascimento;
					$data = explode('/', $data);
					if(count($data) == 3){
						$data = $data[2].'-'.$data[1].'-'.$data[0];
						$this->datNascimento = $data;
						return true;
					}
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data de nascimento.
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Date - data de nascimento
		 *
		**/
		public function getDatNascimento($indTransforma = false){
			if(!$indTransforma)
				return $this->datNascimento;
			return $this->transformacaoData($this->datNascimento);
		}

		/**
		 * Método responsável por setar a data de admissão
		 *
		 * @param Date $datAdmissao - data de admissao. Formato yyyy-mm-dd
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDatAdmissao($datAdmissao){
			if(trim($datAdmissao) != ''){
				if($this->validacaoData($datAdmissao)){
					$this->datAdmissao = $datAdmissao;
					return true;
				}else{
					$data = $datAdmissao;
					$data = explode('/', $data);
					if(count($data) == 3){
						$data = $data[2].'-'.$data[1].'-'.$data[0];
						$this->datAdmissao = $data;
						return true;
					}
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar a data de admissão.
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Date - data de admissão
		 *
		**/
		public function getDatAdmissao($indTransforma = false){
			if(!$indTransforma)
				return $this->datAdmissao;
			return $this->transformacaoData($this->datAdmissao);
		}

		/**
		 * Método responsável por setar as observações do colaborador
		 *
		 * @param String $desColaborador - observações do colaborador
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setDesColaborador($desColaborador){
			$this->desColaborador = $desColaborador;
			return true;
		}

		/**
		 * Método responsável por retornar as observações do colaborador
		 *
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function getDesColaborador(){
			return $this->desColaborador;
		}

		/**
		 * Método responsável por setar se o colaborador possui acesso ao sistema
		 *
		 * @param Boolean $indDesativado - possui acesso ao sistema
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndDesativado($indDesativado){
			$this->indDesativado = $indDesativado;
			return true;
		}

		/**
		 * Método responsável por retornar se o colaborador possui acesso ao sistema
		 *
		 * @param Boolean $indTransforma - transformar para Sim/Não. Padrão: false.
		 * @return Boolean - possui acesso ao sistema
		 *
		**/
		public function getIndDesativado($indTransforma = false){
			if(!$indTransforma)
				return $this->indDesativado;
			return $this->transformacaoSim($this->indDesativado);
		}

		/**
		 * Método responsável por setar a se o colaborador possui uma porcentagem sobre as vendas
		 * que ele realizou
		 *
		 * @param Boolean $indPorcentagem - possui porcentagem
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setIndPorcentagem($indPorcentagem){
			$this->indPorcentagem = $indPorcentagem;
			return true;
		}

		/**
		 * Método responsável por retornar se o colaborador possui porcentagem sobre as vendas
		 * que ele realizou
		 *
		 * @param Boolean $indTransforma - transformar para Sim/Não. Padrão = false.
		 * @return Boolean - possui porcentagem
		 *
		**/
		public function getIndPorcentagem($indTransforma = false){
			if(!$indTransforma)
				return $this->indPorcentagem;
			return $this->transformacaoSim($this->indPorcentagem);
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
		 * Método responsável por setar o valor de remuneração
		 *
		 * @param Decimal $valRemuneracao - valor de remuneração
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setValRemuneracao($valRemuneracao){
			if(trim($valRemuneracao) != ''){
				if(!$this->validacaoDecimal($valRemuneracao))
					$valRemuneracao = $this->transformacaoDecimal($valRemuneracao);
				if($this->validacaoDecimal($valRemuneracao)){
					$this->valRemuneracao = $valRemuneracao;
					return true;
				}
			}else{
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o valor de remuneração
		 *
		 * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
		 * @return Decimal/String - valor de remuneração
		 *
		**/
		public function getValRemuneracao($indTransforma = false){
			if(!$indTransforma)
				return $this->valRemuneracao;
			return $this->transformacaoMonetario($this->valRemuneracao);
		}

	}
