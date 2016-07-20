<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela dentista
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-11
     *
     * */
    class DTODentista {

        use DTO;

        use Validacao;

        use Transformacao;

        private $cdnUsuario;
        private $codCro;
        private $codCep;
        private $codCpf;
        private $codUf;
        private $datNascimento;
        private $datAdmissao;
        private $desDentista;
        private $strContaBancaria;
        private $strOutrosTrabalhos;
        private $indDesativado = 0;
        private $nomCidade;
        private $numTelefone1;
        private $numTelefone2;
        private $numTempoConsulta;
        private $strEndereco;
        private $cdnConsultorio;
        private $numNotaSatisfacao;

        /**
         * Método responsável por setar o valor do código numérico do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnUsuario($cdnUsuario) {
            if ($this->validacaoNumero($cdnUsuario)) {
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
         * */
        public function getCdnUsuario() {
            return $this->cdnUsuario;
        }

        /**
         * Método responsável por setar o valor do código CRO do dentista
         *
         * @param Integer $codCro - código CRO do dentista
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodCro($codCro) {
            if ($this->validacaoNumero($codCro)) {
                $this->codCro = $codCro;

                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o código CRO do dentista
         *
         * @return Integer - código CRO do dentista
         *
         * */
        public function getCodCro() {
            return $this->codCro;
        }

        /**
         * Método responsável por retornar o CEP do dentista
         *
         * @param String $codCep - código CEP
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodCep($codCep) {
            $this->codCep = $codCep;

            return true;
        }

        /**
         * Método responsável por retornar o CEP do dentista
         *
         * @return String - código CEP
         *
         * */
        public function getCodCep() {
            return $this->codCep;
        }

        /**
         * Método responsável por setar o código do CPF
         *
         * @param String $codCpf - código do CPF
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodCpf($codCpf) {
            if (trim($codCpf) != '') {
                if ($this->validacaoCpf($codCpf)) {
                    $this->codCpf = $codCpf;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o código do CPF
         *
         * @return String - código do CPF
         *
         * */
        public function getCodCpf() {
            return $this->codCpf;
        }

        /**
         * Método responsável por setar o código do UF
         *
         * @param String $codUf - código UF
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodUf($codUf) {
            if (trim($codUf) != '') {
                if ($this->validacaoUf($codUf)) {
                    $this->codUf = $codUf;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o código do UF
         *
         * @param Boolean $indTransforma - transformar para nome completo. Padrão: false
         * @return String - estado
         *
         * */
        public function getCodUf($indTransforma = false) {
            if (!$indTransforma)
                return $this->codUf;

            return $this->transformacaoUf($this->codUf);
        }

        /**
         * Método responsável por setar a data de nascimento
         *
         * @param Date $datNascimento - data de nascimento. Formato yyyy-mm-dd
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDatNascimento($datNascimento) {
            if (trim($datNascimento) != '') {
                if ($this->validacaoData($datNascimento)) {
                    $this->datNascimento = $datNascimento;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar a data de nascimento.
         *
         * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
         * @return Date - data de nascimento
         *
         * */
        public function getDatNascimento($indTransforma = false) {
            if (!$indTransforma)
                return $this->datNascimento;

            return $this->transformacaoData($this->datNascimento);
        }

        /**
         * Método responsável por setar a data de admissão
         *
         * @param Date $datAdmissao - data de admissao. Formato yyyy-mm-dd
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDatAdmissao($datAdmissao) {
            if (trim($datAdmissao) != '') {
                if ($this->validacaoData($datAdmissao)) {
                    $this->datAdmissao = $datAdmissao;

                    return true;
                }
            } else {
                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar a data de admissão.
         *
         * @param Boolean $indTransforma - transformar para formato brasileiro. Padrão: false.
         * @return Date - data de admissão
         *
         * */
        public function getDatAdmissao($indTransforma = false) {
            if (!$indTransforma)
                return $this->datAdmissao;

            return $this->transformacaoData($this->datAdmissao);
        }

        /**
         * Método responsável por setar as observações do dentista
         *
         * @param String $desDentista - observações do dentista
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDesDentista($desDentista) {
            $this->desDentista = $desDentista;

            return true;
        }

        /**
         * Método responsável por retornar as observações do dentista
         *
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function getDesDentista() {
            return $this->desDentista;
        }

        /**
         * Método responsável por setar a conta bancária do dentista
         *
         * @param String $strContaBancaria - conta bancária
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrContaBancaria($strContaBancaria) {
            $this->strContaBancaria = $strContaBancaria;

            return true;
        }

        /**
         * Método responsável por retornar a conta bancária do dentista
         *
         * @return String - conta bancária do dentista
         *
         * */
        public function getStrContaBancaria() {
            return $this->strContaBancaria;
        }

        /**
         * Método responsável por setar as observações dos outros trabalhos do dentista
         *
         * @param String $strOutrosTrabalhos - observações dos outros trabalhos do dentista
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrOutrosTrabalhos($strOutrosTrabalhos) {
            $this->strOutrosTrabalhos = $strOutrosTrabalhos;

            return true;
        }

        /**
         * Método responsável por retornar as observações dos outros trabalhos do dentista
         *
         * @return String - observções dos outros trabalhos do dentista
         *
         * */
        public function getStrOutrosTrabalhos() {
            return $this->strOutrosTrabalhos;
        }

        /**
         * Método responsável por setar se o dentista possui acesso ao sistema
         *
         * @param Boolean $indDesativado - possui acesso ao sistema
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setIndDesativado($indDesativado) {
            $this->indDesativado = $indDesativado;

            return true;
        }

        /**
         * Método responsável por retornar se o dentista possui acesso ao sistema
         *
         * @param Boolean $indTransforma - transformar para Sim/Não. Padrão: false.
         * @return Boolean - possui acesso ao sistema
         *
         * */
        public function getIndDesativado($indTransforma = false) {
            if (!$indTransforma)
                return $this->indDesativado;

            return $this->transformacaoSim($this->indDesativado);
        }

        /**
         * Método responsável por setar o nome da cidade
         *
         * @param String $nomCidade - nome da cidade
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNomCidade($nomCidade) {
            $this->nomCidade = $nomCidade;

            return true;
        }

        /**
         * Método responsável por retornar o nome da cidade
         *
         * @return String - nome da cidade
         *
         * */
        public function getNomCidade() {
            return $this->nomCidade;
        }

        /**
         * Método responsável por setar o número de telefone 1
         *
         * @param String $numTelefone1 - número de telefone 1
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumTelefone1($numTelefone1) {
            $this->numTelefone1 = $numTelefone1;

            return true;
        }

        /**
         * Método responsável por retornar o número de telefone 1
         *
         * @return String - número de telefone 1
         *
         * */
        public function getNumTelefone1() {
            return $this->numTelefone1;
        }

        /**
         * Método responsável por setar o número de telefone 2
         *
         * @param String $numTelefone2 - número de telefone 2
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumTelefone2($numTelefone2) {
            $this->numTelefone2 = $numTelefone2;

            return true;
        }

        /**
         * Método responsável por retornar o número de telefone 2
         *
         * @return String - número de telefone 2
         *
         * */
        public function getNumTelefone2() {
            return $this->numTelefone2;
        }

        /**
         * Mètodo responsável por setar o tempo de consulta do dentista
         *
         * @param String $numTempoConsulta - tempo de consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumTempoConsulta($numTempoConsulta) {
            if (trim($numTempoConsulta) != '') {
                if ($this->validacaoHorario($numTempoConsulta)) {
                    $this->numTempoConsulta = $numTempoConsulta;

                    return true;
                }

                return false;
            }

            return true;
        }

        /**
         * Método responsável por retornar o tempo de consulta
         *
         * @return String - tempo de consulta
         *
         * */
        public function getNumTempoConsulta() {
            return $this->numTempoConsulta;
        }

        /**
         * Método responsável por setar o endereço
         *
         * @param String $strEndereco - endereço
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrEndereco($strEndereco) {
            $this->strEndereco = $strEndereco;

            return true;
        }

        /**
         * Método responsável por retornar o endereço
         *
         * @return String - endereço
         *
         * */
        public function getStrEndereco() {
            return $this->strEndereco;
        }

        /**
         * Método responsável por setar o valor do código numérico do consultório
         *
         * @param Integer $cdnConsultorio - código numérico do consultorio
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnConsultorio($cdnConsultorio) {
            if (is_null($cdnConsultorio) or $cdnConsultorio == '')
                return true;
            if ($this->validacaoConsultorio($cdnConsultorio)) {
                $this->cdnConsultorio = $cdnConsultorio;

                return true;
            }

            return false;
        }

        /**
         * Método responsável por retornar o código numérico do consultório
         *
         * @return Integer - código numérico do consultório
         *
         * */
        public function getCdnConsultorio() {
            return $this->cdnConsultorio;
        }

        public function getNumNotaSatisfacao() {
            return $this->numNotaSatisfacao;
        }

        public function setNumNotaSatisfacao($numNotaSatisfacao) {
            $this->numNotaSatisfacao = $numNotaSatisfacao;

            return true;
        }

    }
