<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela orcamento
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-10
     *
     **/
    class DTOOrcamento {
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnOrcamento;
        private $cdnTabelaPreco;
        private $cdnPaciente;
        private $datOrcamento;
        private $datValidade;
        private $valOrcamento;
        private $indAprovado = null;
        private $indFinalizado = 0;
        private $indDesativado = 0;
        private $desOrcamento;
        private $valEntrada;
        private $indTipoDesconto;
        private $valDesconto;
        private $valFinal;
        private $cdnUsuarioAprovou;
        private $datAprovacao;
        private $indCobrarJuros = 1;
        private $strJustificativa = "";
        private $datDesativado = null;

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
         * Método responsável por setar o código numérico da tabela de preço
         *
         * @param Integer $cdnTabelaPreco - código numérico da tabela de preço
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setCdnTabelaPreco($cdnTabelaPreco) {
            $this->cdnTabelaPreco = $cdnTabelaPreco;

            return true;
        }

        /**
         * Método responsável por retornar o código numérico da tabela de preço
         *
         * @return Integer - código numérico da tabela de preço
         *
         **/
        public function getCdnTabelaPreco() {
            return $this->cdnTabelaPreco;
        }


        /**
         * Método responsável por setar o código numérico do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setCdnPaciente($cdnPaciente) {
            if ($this->validacaoNumero($cdnPaciente)) {
                if ($this->validacaoPaciente($cdnPaciente)) {
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
        public function getCdnPaciente() {
            return $this->cdnPaciente;
        }

        /**
         * Método responsável por setar a data do orçamento
         *
         * @param String $datOrcamento - data do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDatOrcamento($datOrcamento) {
            if ($this->validacaoData($datOrcamento)) {
                $this->datOrcamento = $datOrcamento;

                return true;
            } else {
                $data = $datOrcamento;
                $data = explode('/', $data);
                if (count($data) == 3) {
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $this->datOrcamento = $data;

                    return true;
                }
            }

            return false;
        }

        /**
         * Método responsável por retornar a data do orçamento
         *
         * @param Boolean $indTransforma - transformar para padrão brasileiro (dd/mm/aaaa).
         * @return String - data do orçamento
         *
         **/
        public function getDatOrcamento($indTransforma = false) {
            if (!$indTransforma)
                return $this->datOrcamento;

            return $this->transformacaoData($this->datOrcamento);
        }

        /**
         * Método responsável por setar a data de validade
         *
         * @param String $datValidade - data de validade
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDatValidade($datValidade) {
            if ($this->validacaoData($datValidade)) {
                $this->datValidade = $datValidade;

                return true;
            } else {
                $data = $datValidade;
                $data = explode('/', $data);
                if (count($data) == 3) {
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $this->datValidade = $data;

                    return true;
                }
            }

            return false;
        }

        /**
         * Método responsável por retornar a data de validade
         *
         * @param Boolean $indTransforma - transformar para padrão brasileiro (dd/mm/aaaa).
         * @return String - data do orçamento
         *
         **/
        public function getDatValidade($indTransforma = false) {
            if (!$indTransforma)
                return $this->datValidade;

            return $this->transformacaoData($this->datValidade);
        }

        /**
         * Método responsável por setar o valor do orçamento
         *
         * @param Decimal $valOrcamento - valor do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setValOrcamento($valOrcamento) {
            if (trim($valOrcamento) != '') {
                if (!$this->validacaoDecimal($valOrcamento))
                    $valOrcamento = $this->transformacaoDecimal($valOrcamento);

                if ($this->validacaoDecimal($valOrcamento)) {
                    $this->valOrcamento = $valOrcamento;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o valor do orçamento
         *
         * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
         * @return Decimal/String - valor do orçamento
         *
         **/
        public function getValOrcamento($indTransforma = false) {
            if (!$indTransforma)
                return $this->valOrcamento;

            return $this->transformacaoMonetario($this->valOrcamento);
        }

        /**
         * Método responsável por setar se o orçamento foi aprovado
         *
         * @param Boolean $indAprovado - orçamento aprovado
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setIndAprovado($indAprovado) {
            $this->indAprovado = $indAprovado;

            return true;
        }

        /**
         * Método responsável por retornar se o orçamento foi aprovado
         *
         * @param Boolean $indTransformar - transformar para Sim/Não
         * @return Boolean/String - orçamento aprovado
         *
         **/
        public function getIndAprovado($indTransformar = false) {
            if (!$indTransformar)
                return $this->indAprovado;

            return $this->transformacaoSim($this->indAprovado);
        }

        /**
         * Método responsável por setar se o orçamento foi pago completamente
         *
         * @param Boolean $indFinalizado - orçamento finalizado
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setIndFinalizado($indFinalizado) {
            $this->indFinalizado = $indFinalizado;

            return true;
        }

        /**
         * Método responsável por retornar se o orçamento foi finalizado
         *
         * @param Boolean $indTransformar - transformar para Sim/Não
         * @return Boolean/String - orçamento finalizado
         *
         **/
        public function getIndFinalizado($indTransformar = false) {
            if (!$indTransformar)
                return $this->indFinalizado;

            return $this->transformacaoSim($this->indFinalizado);
        }

        /**
         * Método responsável por setar observações do orçamento
         *
         * @param String $desOrcamento - observações
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setDesOrcamento($desOrcamento) {
            $this->desOrcamento = $desOrcamento;

            return true;
        }

        /**
         * Método responsável por retornar as observações do orçamento
         *
         * @return String - observações do orçamento
         *
         **/
        public function getDesOrcamento() {
            return $this->desOrcamento;
        }

        /**
         * Método responsável por setar o valor de entrada
         *
         * @param Decimal $valEntrada - valor de entrada
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function setValEntrada($valEntrada) {
            if (trim($valEntrada) != '') {
                if (!$this->validacaoDecimal($valEntrada))
                    $valEntrada = $this->transformacaoDecimal($valEntrada);

                if ($this->validacaoDecimal($valEntrada)) {
                    $this->valEntrada = $valEntrada;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o valor de entrada
         *
         * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
         * @return Decimal/String - valor do orçamento
         *
         **/
        public function getValEntrada($indTransforma = false) {
            if (!$indTransforma)
                return $this->valEntrada;

            return $this->transformacaoMonetario($this->valEntrada);
        }

        public function setIndTipoDesconto($indTipoDesconto) {
            switch ($indTipoDesconto) {
                case 'prc':
                    $this->indTipoDesconto = $indTipoDesconto;

                    return true;
                    break;
                case 'qtd':
                    $this->indTipoDesconto = $indTipoDesconto;

                    return true;
                    break;

                default:
                    return false;
                    break;
            }
        }

        public function getIndTipoDesconto($indTransforma = false) {
            if (!$indTransforma)
                return $this->indTipoDesconto;

            return $this->transformacaoTipoDesconto($this->indTipoDesconto);
        }

        public function setValDesconto($valDesconto) {
            $this->valDesconto = $valDesconto;

            return true;
        }

        public function getValDesconto() {
            return $this->valDesconto;
        }

        public function setValFinal($valFinal) {
            if (trim($valFinal) != '') {
                if (!$this->validacaoDecimal($valFinal))
                    $valFinal = $this->transformacaoDecimal($valFinal);

                if ($this->validacaoDecimal($valFinal)) {
                    $this->valFinal = $valFinal;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        public function getValFinal($indTransforma = false) {
            if (!$indTransforma)
                return $this->valFinal;

            return $this->transformacaoMonetario($this->valFinal);
        }

        public function setCdnUsuarioAprovou($cdnUsuarioAprovou) {
            $this->cdnUsuarioAprovou = $cdnUsuarioAprovou;

            return true;
        }

        public function getCdnUsuarioAprovou() {
            return $this->cdnUsuarioAprovou;
        }

        public function setDatAprovacao($datAprovacao) {
            $this->datAprovacao = $datAprovacao;

            return true;
        }

        public function getDatAprovacao($indTransforma = false) {
            if (!$indTransforma)
                return $this->datAprovacao;

            return $this->transformacaoDatetime($this->datAprovacao);
        }

        public function getIndCobrarJuros() {
            return $this->indCobrarJuros;
        }

        public function setIndCobrarJuros($indCobrarJuros) {
            $this->indCobrarJuros = $indCobrarJuros;
            return true;
        }
        
        public function setIndDesativado($indDesativado) {
            $this->indDesativado = $indDesativado;
            return true;
        }
        
        public function getIndDesativado() {
            return $this->indDesativado;
        }
        
        public function getStrJustificativa(){
            return $this->strJustificativa;
        }
        
        public function setStrJustificativa($strJustificativa){
            $this->strJustificativa = $strJustificativa;
            return true;
        }
        
        public function getDatDesativado(){
            return $this->datDesativado;
        }
        
        public function setDatDesativado($datDesativado){
            $this->datDesativado = $datDesativado;
            return true;
        }


    }
