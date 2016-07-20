<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela desmarque
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-09-21
	 *
	**/
	class DTODesmarque{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnConsulta;
		private $cdnPaciente;

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
		 * Método responsável por setar o código numérico do paciente
		 * 
		 * @param Integer $cdnPaciente - código numérico do paciente
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnPaciente($cdnPaciente){
			if($this->validacaoNumero($cdnPaciente)){
				if($this->validacaoPaciente($cdnPaciente)){
					$this->cdnPaciente = $cdnPaciente; 
					return true;
				}
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

	}