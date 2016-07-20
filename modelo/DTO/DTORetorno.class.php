<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela retorno
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-10
	 *
	**/
	class DTORetorno{
		use DTO;
		private $cdnConsultaRetorno;
		private $cdnConsultaOriginal;

		/**
		 * Método responsável por setar o código numérico da consulta retorno
		 *
		 * @param Integer $cdnConsultaRetorno - código numérico da consulta retorno
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnConsultaRetorno($cdnConsultaRetorno){
			$this->cdnConsultaRetorno = $cdnConsultaRetorno;
			return true;
		}

		/**
		 * Método responsável por retornar o código numérico da consulta retorno
		 *
		 * @return Integer - código numérico da consulta retorno
		 *
		**/
		public function getCdnConsultaRetorno(){
			return $this->cdnConsultaRetorno;
		}

		/**
		 * Método responsável por setar o código numérico da consulta original
		 *
		 * @param Integer $cdnConsultaOriginal - código numérico da consulta original
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setCdnConsultaOriginal($cdnConsultaOriginal){
			$this->cdnConsultaOriginal = $cdnConsultaOriginal;
			return true;
		}

		/**
		 * Método responsável por retornar o código numérico da consulta original
		 *
		 * @return Integer - código numérico da consulta original
		 *
		**/
		public function getCdnConsultaOriginal(){
			return $this->cdnConsultaOriginal;
		}

	}