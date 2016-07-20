<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela configuracoes
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-28
     *
     * */
    class DTOConfiguracoes {

        use DTO;

        use Validacao;

        use Transformacao;

        private $cdnClinica;
        private $numMinutosAvisoPrevio = 15;
        private $strAvisoConsulta;
        private $strPesquisa;
        private $indPesquisa;
        private $indTipoPesquisa;
        private $strDatasFestivas;
        private $indDatasFestivas;
        private $strAniversario;
        private $indAniversario;
        private $valJurosOrcamento;
        

        /**
         * Método responsável por setar o valor do código numérico da clínica
         *
         * @param Integer $cdnClinica - código numérico da clinica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnClinica($cdnClinica) {
            if ($this->validacaoNumero($cdnClinica)) {
                $this->cdnClinica = $cdnClinica;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico do clínica
         *
         * @return Integer - código numérico do clínica
         *
         * */
        public function getCdnClinica() {
            return $this->cdnClinica;
        }

        /**
         * Método responsável por setar quantos minutos devem existir de aviso prévio (consulta)
         *
         * @param Integer $numMinutosAvisoPrevio - quantidade de minutos
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumMinutosAvisoPrevio($numMinutosAvisoPrevio) {
            if ($this->validacaoNumero($numMinutosAvisoPrevio)) {
                $this->numMinutosAvisoPrevio = $numMinutosAvisoPrevio;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar quantos minutos devem existir de aviso prévio (consulta)
         *
         * @return Integer - quantidade de minutos
         *
         * */
        public function getNumMinutosAvisoPrevio() {
            return $this->numMinutosAvisoPrevio;
        }

        public function getStrAvisoConsulta() {
            return $this->strAvisoConsulta;
        }

        public function getStrPesquisa() {
            return $this->strPesquisa;
        }

        public function getIndPesquisa() {
            return $this->indPesquisa;
        }

        public function getIndTipoPesquisa() {
            return $this->indTipoPesquisa;
        }

        public function setStrAvisoConsulta($strAvisoConsulta) {
            if ($this->validacaoPalavrasChave($strAvisoConsulta, 'consulta')) {
                $this->strAvisoConsulta = $strAvisoConsulta;
                return true;
            }
            return false;
        }

        public function setStrPesquisa($strPesquisa) {
            if ($this->validacaoPalavrasChave($strPesquisa, 'pesquisa')) {
                $this->strPesquisa = $strPesquisa;
                return true;
            }
            return false;
        }

        public function setIndPesquisa($indPesquisa) {
            $this->indPesquisa = $indPesquisa;
        }

        public function setIndTipoPesquisa($indTipoPesquisa) {
            $this->indTipoPesquisa = $indTipoPesquisa;
        }

        public function getStrDatasFestivas() {
            return $this->strDatasFestivas;
        }

        public function getIndDatasFestivas() {
            return $this->indDatasFestivas;
        }

        public function setStrDatasFestivas($strDatasFestivas) {
            if ($this->validacaoPalavrasChave($strDatasFestivas, 'dataFestiva')) {
                $this->strDatasFestivas = $strDatasFestivas;
                return true;
            }
            return false;
        }

        public function setIndDatasFestivas($indDatasFestivas) {
            $this->indDatasFestivas = $indDatasFestivas;
        }
        
        public function getStrAniversario() {
            return $this->strAniversario;
        }

        public function getIndAniversario() {
            return $this->indAniversario;
        }

        public function setStrAniversario($strAniversario) {
            if ($this->validacaoPalavrasChave($strAniversario, 'aniversario')) {
                $this->strAniversario = $strAniversario;
                return true;
            }
            return false;
        }

        public function setIndAniversario($indAniversario) {
            $this->indAniversario = $indAniversario;
        }

        public function getValJurosOrcamento($indTransformar = false) {
            if(!$indTransformar)
                return $this->valJurosOrcamento;
            return $this->transformacaoDecimalPorcentagem($this->valJurosOrcamento);
        }

        public function setValJurosOrcamento($valJurosOrcamento) {
            $valJurosOrcamento = $this->transformacaoPorcentagemDecimal($valJurosOrcamento);
            if($this->validacaoPorcentagem($valJurosOrcamento, 0, 100)) {
                $this->valJurosOrcamento = $valJurosOrcamento;
                return true;
            }
            return false;
        }


    
    }
    