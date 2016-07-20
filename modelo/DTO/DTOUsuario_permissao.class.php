<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela agenda_evento
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class DTOUsuario_permissao{
    	use DTO;
    	use Validacao;
    	use Transformacao;
        private $cdnUsuario;
        private $strPermissao;

        /**
         * Método repsonsável por setar o código numérico do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnUsuario($cdnUsuario){
            if($this->validacaoNUmero($cdnUsuario)){
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
         * Método responsável por setar a permissão do usuário
         *
         * @param String $strPermissao - permissão do usuário
         * @return Boolean - true se sucesso, false se não
        **/
        public function setStrPermissao($strPermissao){
            $this->strPermissao = $strPermissao;
            return true;
        }

        /**
         * Método responsável por retornar a permissão do usuário
         *
         * @return String - permissão do usuário
         *
        **/
        public function getStrPermissao(){
            return $this->strPermissao;
        }

    }