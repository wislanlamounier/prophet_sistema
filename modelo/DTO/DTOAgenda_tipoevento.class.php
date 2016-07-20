<?php

    /**
    * Classe responsável pelo mantimento de dados de transição com o banco
    * envolvendo a tabela agenda_tipoevento
    *
    * @autor Rafael de Paula - <rafael@bentonet.com.br>
    * @version 1.0.0 - 2015-09-04
    *
    **/
    class DTOAgenda_tipoevento{
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnTipoEvento;
        private $cdnUsuario;
        private $codCor;
        private $nomTipoEvento;

        /**
         * Método responsável por setar o código numérico do tipo de evento
         *
         * @param Integer $cdnTipoEvento - código numérico do tipo de evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnTipoEvento($cdnTipoEvento){
        	if($this->validacaoNumero($cdnTipoEvento)){
        		$this->cdnTipoEvento = $cdnTipoEvento;
        		return true;
        	}
        	return false;
        }

        /** 
         * Método responsável por retornar o código numérico do tipo de evento
         *
         * @return Integer - código numérico do tipo de evento
         *
        **/
        public function getCdnTipoEvento(){
        	return $this->cdnTipoEvento;
        }

        /**
         * Método responsável por setar o código numérico do usuário
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
         * Método responsável por setar o código da cor
         *
         * @param String $codCod - código da cor
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCodCor($codCor){
            $this->codCor = $codCor;
            return true;
        }

        /**
         * Método responsável por retornar o código da cor
         *
         * @return String - código da cor
         *
        **/
        public function getCodCor(){
            return $this->codCor;
        }

        /**
         * Método responsável por setar o nome do tipo de evento
         *
         * @param String $nomTipoEvento - nome do tipo de evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomTipoEvento($nomTipoEvento){
            if($this->validacaoVazio($nomTipoEvento)){
                $this->nomTipoEvento = $nomTipoEvento;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o nome do tipo de evento
         *
         * @return String - nome do tipo de evento
         *
        **/
        public function getNomTipoEvento(){
            return $this->nomTipoEvento;
        }

        /**
         * Método responsável por setar o desvinculamento
         *
         * @param Boolean $indDesvinculado - oferta desvinculada do sistema
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setIndDesvinculado($indDesvinculado){
            $this->indDesvinculado = $indDesvinculado;
            return true;
        }

        /**
         * Método responsável por retornar se a oferta está desvinculada
         *
         * @return Boolean - oferta desvinculada
         *
        **/
        public function getIndDesvinculado(){
            return $this->indDesvinculado;
        }

    }