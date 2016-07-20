<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela tabelapreco
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-12-21
     *
    **/
    class DTOTabelapreco{
    	use DTO;
    	use Validacao;
    	use Transformacao;
        private $cdnTabelaPreco;
        private $nomTabelaPreco;

        /**
         * Método responsável por setar o código numérico da tabela de preço
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnTabelaPreco($cdnTabelaPreco){
            if($this->validacaoNumero($cdnTabelaPreco)){
                $this->cdnTabelaPreco = $cdnTabelaPreco;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico da tabela de preço
         *
         * @return Integer - código numérico da tabela de preço
         *
        **/
        public function getCdnTabelaPreco(){
            return $this->cdnTabelaPreco;
        }

        /**
         * Método responsável por setar o nome da tabela de preço
         *
         * @param String $nomTabelaPreco - nome da tabela de preço
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNomTabelaPreco($nomTabelaPreco){
            if($this->validacaoVazio($nomTabelaPreco)){
                $this->nomTabelaPreco = $nomTabelaPreco;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o nome da tabela de preço
         *
         * @return String - nome da tabela de preço
         *
        **/
        public function getNomTabelaPreco(){
            return $this->nomTabelaPreco;
        }

    }