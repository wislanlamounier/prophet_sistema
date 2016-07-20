<?php

    class DTOSms_aviso_consulta{
    	use DTO;
    	use Validacao;
    	use Transformacao;
        private $cdnConsulta;
        private $cdnPaciente;
        private $cdnSms;
        private $datAviso;
        private $indModificou = 0;
        private $numTelefone;
        private $codErro;

        public function setCdnConsulta($cdnConsulta){
            $this->cdnConsulta = $cdnConsulta;
            return true;
        }

        public function getCdnConsulta(){
            return $this->cdnConsulta;
        }

        public function setCdnPaciente($cdnPaciente){
            if($this->validacaoNumero($cdnPaciente)){
                if($this->validacaoPaciente($cdnPaciente)){
                    $this->cdnPaciente = $cdnPaciente;
                    return true;
                }
            }
            return false;
        }

        public function getCdnPaciente(){
            return $this->cdnPaciente;
        }

        public function setCdnSms($cdnSms) {
            if($this->validacaoNumero($cdnSms) || is_null($cdnSms)){
                $this->cdnSms = $cdnSms;
                return true;
            }
            return false;
        }

        public function getCdnSms() {
            return $this->cdnSms;
        }

        public function setDatAviso($datAviso) {
            if($this->validacaoDatetime($datAviso)){
                $this->datAviso = $datAviso;
                return true;
            }
            return false;
        }

        public function getDatAviso($indTransforma = false) {
            if(!$indTransforma)
                return $this->datAviso;
            return $this->transformacaoDatetime($this->datAviso);
        }

        public function setIndModificou($indModificou) {
            $this->indModificou = $indModificou;
        }

        public function getIndModificou() {
            return $this->indModificou;
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

    }
