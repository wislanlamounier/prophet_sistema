<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela estilo
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-24
	 *
	**/
	class DTODependente{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnDependente;
		private $cdnPaciente;
		private $cdnResponsavel;

		/**
		 * Método responsável por setar o código numérico do dependente
		 *
		 * @param Integer $cdnDependente - código numérico do dependente
		 * @return Boolean - true se suceso, false se não
		 *
		**/
		public function setCdnDependente($cdnDependente){
			if($this->validacaoNumero($cdnDependente)){
				$this->cdnDependente = $cdnDependente; 
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do dependente
		 * 
		 * @return Integer - código numérico do dependente
		 *
		**/
		public function getCdnDependente(){
			return $this->cdnDependente;
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
		 * Método responsável por setar o valor do código numérico do responsável
		 *
		 * @param Integer $cdnResponsavel - código numérico do responsável
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnResponsavel($cdnResponsavel){
			if($this->validacaoNumero($cdnResponsavel)){
				$this->cdnResponsavel = $cdnResponsavel;
				return true;
			}
			return false;
		}

		/**
		 * Método responsável por retornar o código numérico do responsável
		 *
		 * @return Integer - código numérico do responsável
		 *
		**/
		public function getCdnResponsavel(){
			return $this->cdnResponsavel;
		}

    }
