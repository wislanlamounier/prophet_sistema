<?php

    class DTOSms_satisfacao{
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnSatisfacao;
        private $cdnSms;
        private $datSatisfacao;
        private $cdnConsulta;
        private $numTelefone;
        private $codErro;
        private $cdnPaciente;
        
        public function getCdnSatisfacao() {
            return $this->cdnSatisfacao;
        }

        public function getCdnSms() {
            return $this->cdnSms;
        }

        public function getDatSatisfacao($indTransformar = false) {
            if(!$indTransformar)
                return $this->datSatisfacao;
            return $this->transformacaoDatetime($this->datSatisfacao);
        }

        public function getCdnConsulta() {
            return $this->cdnConsulta;
        }

        public function setCdnSatisfacao($cdnSatisfacao) {
            $this->cdnSatisfacao = $cdnSatisfacao;
            return $this;
        }

        public function setCdnSms($cdnSms) {
            $this->cdnSms = $cdnSms;
            return true;
        }

        public function setDatSatisfacao($datSatisfacao) {
            if($this->validacaoDatetime($datSatisfacao)){
                $this->datSatisfacao = $datSatisfacao;
                return true;
            }
            return false;
        }

        public function setCdnConsulta($cdnConsulta) {
            if($this->validacaoConsulta($cdnConsulta)){
                $this->cdnConsulta = $cdnConsulta;
                return true;
            }
            return false;
        }

        public function setNumTelefone($numTelefone){
            $numTelefone = str_replace(' ', '', $numTelefone);
            $numTelefone = str_replace('(', '', $numTelefone);
            $numTelefone = str_replace(')', '', $numTelefone);
            $numTelefone = str_replace('-', '', $numTelefone);
            $numTelefone = str_replace('_', '', $numTelefone);
            $numTelefone = '55'.$numTelefone;
            if(substr($numTelefone, 0, 5) == '55555'){
                $numTelefone = substr($numTelefone, 2);
            }
            if(is_numeric($numTelefone)){
                if(strlen($numTelefone) == 12){
                    $this->numTelefone = $numTelefone;
                    return true;
                }
            }
            return false;
        }

        public function getNumTelefone(){
            return $this->numTelefone;
        }
        
        public function setCodErro($codErro){
            $this->codErro = $codErro;
        }

        public function getCodErro(){
            return $this->codErro;
        }
        
        public function getCdnPaciente() {
            return $this->cdnPaciente;
        }

        public function setCdnPaciente($cdnPaciente) {
            if($this->validacaoPaciente($cdnPaciente)){
                $this->cdnPaciente = $cdnPaciente;
                return true;
            }
            return false;
        }



    }