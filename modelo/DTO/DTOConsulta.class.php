<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela clinica
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-11
     *
     * */
    class DTOConsulta {

        use DTO;

        use Validacao;

        use Transformacao;

        private $cdnConsulta;
        private $cdnPaciente;
        private $cdnProcedimento;
        // private $cdnSecao;
        private $cdnAreaAtuacao;
        private $cdnDentista;
        private $datConsulta;
        private $numHorarios;
        private $horaConsulta;
        private $horaFinalizada;
        private $desConsulta;
        private $indEncaixe = 0;
        private $indFinalizada = 0;
        private $cdnConsultorio;
        private $indBloquear = 0;
        private $cdnOrcamento;
        private $numSegAntecedencia;
        private $datRemarque;

        /**
         * Método responsável por setar o código numérico da consulta
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnConsulta($cdnConsulta) {
            $this->cdnConsulta = $cdnConsulta;
            return true;
        }

        /**
         * Método responsável por retornar o código numérico da consulta
         *
         * @return Integer - código numérico da consulta
         *
         * */
        public function getCdnConsulta() {
            return $this->cdnConsulta;
        }

        /**
         * Método responsável por setar o código numérico do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Boolean - true se sucesso, false se não
         *
         * */
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
         * */
        public function getCdnPaciente() {
            return $this->cdnPaciente;
        }

        public function setCdnAreaAtuacao($cdnAreaAtuacao) {
            if ($this->validacaoAreaAtuacao($cdnAreaAtuacao)) {
                $this->cdnAreaAtuacao = $cdnAreaAtuacao;
                return true;
            }
            return false;
        }

        public function getCdnAreaAtuacao() {
            return $this->cdnAreaAtuacao;
        }

        /**
         * Método responsável por setar o valor do código numérico do procedimento
         *
         * @param Integer $cdnProcedimento - código numérico do procedimento
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnProcedimento($cdnProcedimento) {
            if ($this->validacaoNumero($cdnProcedimento)) {
                if ($this->validacaoProcedimento($cdnProcedimento)) {
                    $this->cdnProcedimento = $cdnProcedimento;
                    return true;
                }
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico do procedimento
         *
         * @return Integer - código numérico do procedimento
         *
         * */
        public function getCdnProcedimento() {
            return $this->cdnProcedimento;
        }

        /**
         * Método responsável por setar o valor do código numérico da seção
         *
         * @param Integer $cdnSecao - código numérico da seção
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnSecao($cdnSecao) {
            if ($this->validacaoNumero($cdnSecao)) {
                if ($this->validacaoSecao($cdnSecao)) {
                    $this->cdnSecao = $cdnSecao;
                    return true;
                }
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico da seção
         *
         * @return Integer - código numérico da seção
         *
         * */
        public function getCdnSecao() {
            return $this->cdnSecao;
        }

        /**
         * Método responsável por setar o valor do código numérico do dentista
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnDentista($cdnDentista) {
            if ($this->validacaoNumero($cdnDentista)) {
                if ($this->validacaoDentista($cdnDentista)) {
                    $this->cdnDentista = $cdnDentista;
                    return true;
                }
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico do dentista
         *
         * @return Integer - código numérico do dentista
         *
         * */
        public function getCdnDentista() {
            return $this->cdnDentista;
        }

        /**
         * Método responsável por setar a data da consulta
         *
         * @param String $datConsulta - data da consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDatConsulta($datConsulta) {
            if ($this->validacaoData($datConsulta)) {
                $this->datConsulta = $datConsulta;
                return true;
            } else {
                $data = $datConsulta;
                $data = explode('/', $data);
                if (count($data) == 3) {
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $this->datConsulta = $data;
                    return true;
                }
            }
            return false;
        }

        /**
         * Método responsável por retornar a data da consulta
         *
         * @param Boolean $indTransformar - transformar para padrão brasileiro (DD/MM/AAAA).
         * @return String - data da consulta
         *
         * */
        public function getDatConsulta($indTransformar = false) {
            if (!$indTransformar)
                return $this->datConsulta;
            return $this->transformacaoData($this->datConsulta);
        }

        /**
         * Método responsável por setar a quantidade de horários que a consulta ocupa
         *
         * @param Integer $numHorarios - número de horários
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumHorarios($numHorarios) {
            if ($this->validacaoNumero($numHorarios)) {
                $this->numHorarios = $numHorarios;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o número de horários que a consulta ocupa
         *
         * @return Integer - número de horários
         *
         * */
        public function getNumHorarios() {
            return $this->numHorarios;
        }

        /**
         * Método responsável por setar a hora da consulta
         *
         * @param String $horaConsulta - hora da consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setHoraConsulta($horaConsulta) {
            $this->horaConsulta = $horaConsulta;
            return true;
        }

        /**
         * Método responsável por retornar a hora da consulta
         *
         * @return String - hora da consulta
         *
         * */
        public function getHoraConsulta() {
            return $this->horaConsulta;
        }

        /**
         * Método responsável por setar a hora do término da consulta
         *
         * @param String $horaFinalizada - hora do término da consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setHoraFinalizada($horaFinalizada) {
            $this->horaFinalizada = $horaFinalizada;
            return true;
        }

        /**
         * Método responsável por retornar a hora do término da consulta
         *
         * @return String - hora do término da consulta
         *
         * */
        public function getHoraFinalizada() {
            return $this->horaFinalizada;
        }

        /**
         * Método responsável por setar a descrição da consulta
         *
         * @param String $desConsulta - descrição da consulta
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDesConsulta($desConsulta) {
            $this->desConsulta = $desConsulta;
            return true;
        }

        /**
         * Método responsável por retornar a descrição da consulta
         *
         * @return String - descrição da consulta
         *
         * */
        public function getDesConsulta() {
            return $this->desConsulta;
        }

        /**
         * Método responsável por setar se a consulta é um encaixa
         *
         * @param Boolean - consulta é um encaixe
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setIndEncaixe($indEncaixe) {
            $this->indEncaixe = $indEncaixe;
            return true;
        }

        /**
         * Método responsável por retornar se a consulta é um encaixe
         *
         * @param Boolean $indTransformar - transformar para Sim/Não
         * @return Mixed - string se transformado, boolean se não.
         *
         * */
        public function getIndEncaixe($indTransformar = false) {
            if (!$indTransformar)
                return $this->indEncaixe;
            return $this->transformacaoSim($this->indEncaixe);
        }

        /**
         * Método responsável por setar se a consulta foi finalizada
         *
         * @param Boolean - consulta finalizada
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setIndFinalizada($indFinalizada) {
            $this->indFinalizada = $indFinalizada;
            return true;
        }

        /**
         * Método responsável por retornar se a consulta foi finalizada
         *
         * @param Boolean $indTransformar - transformar para sim/não.
         * @return Mixed - string se transformar, boolean se não
         *
         * */
        public function getIndFinalizada($indTransformar = false) {
            if (!$indTransformar)
                return $this->indFinalizada;
            return $this->transformacaoSim($this->indFinalizada);
        }

        /**
         * Método responsável por setar o valor do código numérico do consultório
         *
         * @param Integer $cdnConsultorio - código numérico do consultorio
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnConsultorio($cdnConsultorio) {
            if ($this->validacaoNumero($cdnConsultorio)) {
                if ($this->validacaoConsultorio($cdnConsultorio)) {
                    $this->cdnConsultorio = $cdnConsultorio;
                    return true;
                }
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

        public function setIndBloquear($indBloquear) {
            $this->indBloquear = $indBloquear;
            return true;
        }

        public function getIndBloquear($indTransformar = false) {
            if (!$indTransformar)
                return $this->indBloquear;
            return $this->transformacaoSim($this->indBloquear);
        }

        /**
         * Método responsável por setar o código do orçamento
         *
         * @param Integer $cdnOrcamento - código numéricdo do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnOrcamento($cdnOrcamento) {
            if ($this->validacaoOrcamento($cdnOrcamento)) {
                $this->cdnOrcamento = $cdnOrcamento;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código do orçamento
         *
         * @return Integer - código numérico do orçamento
         *
         * */
        public function getCdnOrcamento() {
            return $this->cdnOrcamento;
        }

        public function setNumSegAntecedencia($numSegAntecedencia) {
            if ($this->validacaoNumero($numSegAntecedencia)) {
                $this->numSegAntecedencia = $numSegAntecedencia;
                return true;
            }
            return false;
        }

        public function getNumSegAntecedencia() {
            return $this->numSegAntecedencia;
        }

        public function getDatRemarque($indTransformar = false) {
            if(!$indTransformar)
                return $this->datRemarque;
            return $this->transformacaoData($this->datRemarque);
        }

        public function setDatRemarque($datRemarque) {
            if($this->validacaoData($datRemarque))
            $this->datRemarque = $datRemarque;
        }

            
    }
    