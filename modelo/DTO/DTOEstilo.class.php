<?php

	/**
	 * Classe responsável pelo mantimento de dados de transição com o banco
	 * envolvendo a tabela estilo
	 *
	 * @autor Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-08-24
	 *
	**/
	class DTOEstilo{
		use DTO;
		use Validacao;
		use Transformacao;
		private $cdnUsuario;
		private $nomSkin = null;
		private $nomFundoConteudo = 'gray-bg';
		private $nomFundoHeader = 'navy-bg';
		private $nomBotaoPrimario = '';
		private $nomBotaoSucesso = '';

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
		 * Método responsável por setar o nome da skin utilizada
		 *
		 * @param String $nomSkin - nome da skin (null, skin-1, skin-3)
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomSkin($nomSkin){
			$this->nomSkin = $nomSkin;
			return true;
		}

		/**
		 * Método responsável por retornar a skin utilizada
		 *
		 * @return String - nome da skin
		 *
		**/
		public function getNomSkin(){
			return $this->nomSkin;
		}

		/**
		 * Método responsável por setar o nome da classe do fundo do conteúdo
		 *
		 * @param String $nomFundoConteudo - nome da classe do fundo do conteúdo
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomFundoConteudo($nomFundoConteudo){
			$this->nomFundoConteudo = $nomFundoConteudo;
			return true;
		}

		/**
		 * Método responsável por retornar o nome da classe do fundo do conteúdo
		 *
		 * @return String - nome da classe do fundo do conteúdo
		 *
		**/
		public function getNomFundoConteudo(){
			return $this->nomFundoConteudo;
		}

		/**
		 * Método responsável por setar o nome da classe do header do conteúdo
		 *
		 * @param String $nomFundoHeader - nome da classe do header do conteúdo
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomFundoHeader($nomFundoHeader){
			$this->nomFundoHeader = $nomFundoHeader;
			return true;
		}

		/**
		 * Método responsável por retornar o nome da classe do fundo do header do conteúdo
		 *
		 * @return String - nome da classe do fundo do header do conteúdo
		 *
		**/
		public function getNomFundoHeader(){
			return $this->nomFundoHeader;
		}

		/**
		 * Método responsável por setar o nome da classe do botão primário
		 *
		 * @param String $nomBotaoPrimario - nome da classe do botão primario
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomBotaoPrimario($nomBotaoPrimario){
			$this->nomBotaoPrimario = $nomBotaoPrimario;
			return true;
		}

		/**
		 * Método responsável por retornar o nome da classe do botão primário
		 *
		 * @return String - nome da classe do fundo do botão primário
		 *
		**/
		public function getNomBotaoPrimario(){
			return $this->nomBotaoPrimario;
		}

		/**
		 * Método responsável por setar o nome da classe do botão Sucesso
		 *
		 * @param String $nomBotaoSucesso - nome da classe do botão Sucesso
		 * @return Boolean - true se sucesso, false se não
		 *
		**/
		public function setNomBotaoSucesso($nomBotaoSucesso){
			$this->nomBotaoSucesso = $nomBotaoSucesso;
			return true;
		}

		/**
		 * Método responsável por retornar o nome da classe do botão Sucesso
		 *
		 * @return String - nome da classe do fundo do botão Sucesso
		 *
		**/
		public function getNomBotaoSucesso(){
			return $this->nomBotaoSucesso;
		}

    }
