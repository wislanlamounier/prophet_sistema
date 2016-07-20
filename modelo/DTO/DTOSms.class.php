<?php

    class DTOSms {

        use DTO;

        use Validacao;

        use Transformacao;

        private $cdnPaciente;
        private $cdnSms;
        private $cdnUsuario;
        private $datEnvio;
        private $strTexto;
        private $numTelefone;
        private $numIdZenvia;

        public function setCdnPaciente($cdnPaciente) {
            if ($this->validacaoNumero($cdnPaciente)) {
                if ($this->validacaoPaciente($cdnPaciente)) {
                    $this->cdnPaciente = $cdnPaciente;
                    return true;
                }
            }
            return false;
        }

        public function getCdnPaciente() {
            return $this->cdnPaciente;
        }

        public function setCdnSms($cdnSms) {
            if (is_null($cdnSms)) {
                $this->cdnSms = $cdnSms;
                return true;
            }
            if ($this->validacaoNumero($cdnSms)) {
                $this->cdnSms = $cdnSms;
                return true;
            }
            return false;
        }

        public function getCdnSms() {
            return $this->cdnSms;
        }

        public function setCdnUsuario($cdnUsuario) {
            $this->cdnUsuario = $cdnUsuario;
        }

        public function getCdnUsuario() {
            return $this->cdnUsuario;
        }

        public function setDatEnvio($datEnvio) {
            if ($this->validacaoDatetime($datEnvio)) {
                $this->datEnvio = $datEnvio;
                return true;
            }
            return false;
        }

        public function getDatEnvio($indTransforma = false) {
            if (!$indTransforma)
                return $this->datEnvio;
            return $this->transformacaoDatetime($this->datEnvio);
        }

        public function setStrTexto($strTexto) {
            $this->strTexto = $this->transformacaoTiraAcento($strTexto);
        }

        public function getStrTexto() {
            return $this->strTexto;
        }

        public function setNumTelefone($numTelefone) {
            $numTelefone = str_replace(' ', '', $numTelefone);
            $numTelefone = str_replace('(', '', $numTelefone);
            $numTelefone = str_replace(')', '', $numTelefone);
            $numTelefone = str_replace('-', '', $numTelefone);
            $numTelefone = '55' . $numTelefone;
            if (substr($numTelefone, 0, 5) == '55555') {
                $numTelefone = substr($numTelefone, 2);
            }
            $this->numTelefone = $numTelefone;
        }

        public function getNumTelefone() {
            return $this->numTelefone;
        }

        public function setNumIdZenvia($numIdZenvia) {
            $this->numIdZenvia = $numIdZenvia;
            return true;
        }

        public function getNumIdZenvia() {
            return $this->numIdZenvia;
        }

    }
    