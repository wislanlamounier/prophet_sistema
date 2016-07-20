<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela orcamento_formapagamento
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-10
     *
     **/
    class DTOOrcamento_formapagamento {
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnOrcamento;
        private $indForma;
        private $indVia;
        private $numVezes;
        private $numPorcentagem;
        private $numDiaVencimento;
        private $datInicioPagamento;
        private $datVencimento;


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
         * Método responsável por setar a forma de pagamento
         *
         * @param String $indForma - forma de pagamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setIndForma($indForma) {
            if ($this->validacaoOrcamentoForma($indForma)) {
                $this->indForma = $indForma;

                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar a forma de pagamento
         *
         * @param Boolean $indTransformar - transformar para texto
         * @return String - forma de pagamento
         *
         **/
        public function getIndForma($indTransformar = false) {
            if (!$indTransformar)
                return $this->indForma;

            return $this->transformacaoOrcamentoForma($this->indForma);
        }

        /**
         * Método responsável por setar a via do pagamento
         *
         * @param String $indVia - via do pagamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setIndVia($indVia) {
            if ($this->validacaoOrcamentoVia($indVia)) {
                $this->indVia = $indVia;

                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar a via do pagamento
         *
         * @param Boolean $indTransformar - transformar para texto
         * @return String - via do pagamento
         *
         **/
        public function getIndvia($indTransformar = false) {
            if (!$indTransformar)
                return $this->indVia;

            return $this->transformacaoOrcamentoVia($this->indVia);
        }

        /**
         * Método responsável por setar o número de parcelas
         *
         * @param Integer $numVezes - número de parcelas
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setNumVezes($numVezes) {
            if ($numVezes != '' or !is_null($numVezes)) {
                if ($this->validacaoNumero($numVezes)) {
                    $this->numVezes = $numVezes;

                    return true;
                }

                return false;
            }

            return true;
        }

        /**
         * Método responsável por retornar o número de parcelas
         *
         * @return Integer - número de parcelas
         *
         **/
        public function getNumVezes() {
            return $this->numVezes;
        }

        /**
         * Método responsável por setar a porcentagem da taxa
         *
         * @param Float $numPorcentagem - porcentagem da taxa
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setNumPorcentagem($numPorcentagem) {
            $this->numPorcentagem = $numPorcentagem;

            return true;
        }

        /**
         * Método responsável por retornar a porcentagem da taxa
         *
         * @return Float - porcentagem da taxa
         *
         **/
        public function getNumPorcentagem() {
            return $this->numPorcentagem;
        }

        /**
         * Método responsável por setar o dia de vencimento de cada mês
         *
         * @param Integer $numDiaVencimento - dia de vencimnto de cada mês
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setNumDiaVencimento($numDiaVencimento) {
            if ($this->validacaoNumero($numDiaVencimento)) {
                if ($numDiaVencimento > 1 and $numDiaVencimento < 31) {
                    $this->numDiaVencimento = $numDiaVencimento;

                    return true;
                }
            }

            return false;
        }

        /**
         * Método responsável por retornar o dia de vencimento de cada mês
         *
         * @return Integer - dia de vencimento de cada mês
         *
         **/
        public function getNumDiaVencimento() {
            return $this->numDiaVencimento;
        }

        /**
         * Método responsável por setar a data de inicio de pagamento
         *
         * @param String $datInicioPagamento - data de início do pagamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDatInicioPagamento($datInicioPagamento) {
            if ($this->validacaoData($datInicioPagamento)) {
                $this->datInicioPagamento = $datInicioPagamento;

                return true;
            } else {
                $data = $datInicioPagamento;
                $data = explode('/', $data);
                if (count($data) == 3) {
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $this->datInicioPagamento = $data;

                    return true;
                }
            }

            return false;
        }

        /**
         * Método responsável por retornar a data de início do pagamento
         *
         * @param Boolean $indTransforma - transformar para padrão brasileiro
         * @return String - data de início do pagamento
         *
         **/
        public function getDatInicioPagamento($indTransforma = false) {
            if (!$indTransforma)
                return $this->datInicioPagamento;

            return $this->transformacaoData($this->datInicioPagamento);
        }

        /**
         * Método responsável por setar a data de vencimento
         *
         * @param String $datVencimento - data de vencimento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDatVencimento($datVencimento) {
            if ($this->validacaoData($datVencimento)) {
                $this->datVencimento = $datVencimento;

                return true;
            } else {
                $data = $datVencimento;
                $data = explode('/', $data);
                if (count($data) == 3) {
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $this->datVencimento = $data;

                    return true;
                }
            }

            return false;
        }

        /**
         * Método responsável por retornar a data de vencimento
         *
         * @param Boolean $indTransforma - transformar para padrão brasileiro (dd/mm/aaaa).
         * @return String - data do orçamento
         *
         **/
        public function getDatVencimento($indTransforma = false) {
            if (!$indTransforma)
                return $this->datVencimento;

            return $this->transformacaoData($this->datVencimento);
        }

        /**
         * Método responsável por setar a data de vencimento do cartão de crédito
         *
         * @param String $datVencimentoCartao - data de vencimento do cartão de crédito
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDatVencimentoCartao($datVencimentoCartao) {
            $this->datVencimentoCartao = $datVencimentoCartao;

            return true;
        }

        /**
         * Método responsável por retornar a data de vencimento do cartão de crédito
         *
         * @return String - data de vencimento do cartão de crédito
         *
         **/
        public function getDatVencimentoCartao() {
            return $this->datVencimentoCartao;
        }

        /**
         * Método responsável por setar o número de parcelasEscolhido
         *
         * @param Integer $numVezesEscolhido - número de parcelasEscolhido
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setNumVezesEscolhido($numVezesEscolhido) {
            if ($numVezesEscolhido != '' or !is_null($numVezesEscolhido)) {
                if ($this->validacaoNumero($numVezesEscolhido)) {
                    $this->numVezesEscolhido = $numVezesEscolhido;

                    return true;
                }

                return false;
            }

            return true;
        }

        /**
         * Método responsável por retornar o número de parcelasEscolhido
         *
         * @return Integer - número de parcelasEscolhido
         *
         **/
        public function getNumVezesEscolhido() {
            return $this->numVezesEscolhido;
        }

        public function setValFinalTaxas($valFinalTaxas) {
            if (trim($valFinalTaxas) != '') {
                if (!$this->validacaoDecimal($valFinalTaxas))
                    $valFinalTaxas = $this->transformacaoDecimal($valFinalTaxas);

                if ($this->validacaoDecimal($valFinalTaxas)) {
                    $this->valFinalTaxas = $valFinalTaxas;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        public function getValFinalTaxas($indTransforma = false) {
            if (!$indTransforma)
                return $this->valFinalTaxas;

            return $this->transformacaoMonetario($this->valFinalTaxas);
        }
    }