<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela orcamento_parcela
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-11
     *
     **/
    class DTOPagamento {
        use DTO;
        use Validacao;
        use Transformacao;

        private $cdnPagamento;
        private $cdnOrcamento;
        private $numParcela;
        private $valPagamento;
        private $numNotaFiscal;

        /**
         * Método responsável por setar o código numérico do orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setCdnOrcamento($cdnOrcamento) {
            if ($this->validacaoNumero($cdnOrcamento)) {
                $this->cdnOrcamento = $cdnOrcamento;

                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o código numérico do orçamento
         *
         * @return Integer - código numérico do orçamento
         *
         **/
        public function getCdnOrcamento() {
            return $this->cdnOrcamento;
        }

        /**
         * Método responsável por setar o número da parcela
         *
         * @param Integer $numParcela - número da parcela
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setNumParcela($numParcela) {
            if (!$this->validacaoNumero($numParcela)) {
                return false;
            }
            $this->numParcela = $numParcela;
        }

        /**
         * Método responsável por retornar o número da parcela
         *
         * @return Integer - número da parcela
         *
         **/
        public function getNumParcela() {
            return $this->numParcela;
        }

        /**
         * Método responsável por setar o valor da parcela
         *
         * @param Decimal $valPagamento - valor da parcela
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setValPagamento($valPagamento) {
            if (trim($valPagamento) != '') {
                if (!$this->validacaoDecimal($valPagamento))
                    $valPagamento = $this->transformacaoDecimal($valPagamento);

                if ($this->validacaoDecimal($valPagamento)) {
                    $this->valPagamento = $valPagamento;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o valor da parcela
         *
         * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
         * @return Decimal/String - valor da parcela
         *
         **/
        public function getValPagamento($indTransforma = false) {
            if (!$indTransforma)
                return $this->valPagamento;

            return $this->transformacaoMonetario($this->valPagamento);
        }

        public function getCdnPagamento() {
            return $this->cdnPagamento;
        }

        public function setCdnPagamento($cdnPagamento) {
            $this->cdnPagamento = $cdnPagamento;
            return true;
        }

        public function getNumNotaFiscal() {
            return $this->numNotaFiscal;
        }

        public function setNumNotaFiscal($numNotaFiscal) {
            $this->numNotaFiscal = $numNotaFiscal;
            return true;
        }



    }