<?php

    class DTOBoleto{
    	use DTO;
    	use Validacao;
    	use Transformacao;
        private $cdnBoleto;
        private $valBoleto;
        private $desOrigem;
        private $cdnPaciente;
        private $numNossoNumero;

        public function setCdnBoleto($cdnBoleto){
            $this->cdnBoleto = $cdnBoleto;
            return true;
        }

        public function getCdnBoleto(){
            return $this->cdnBoleto;
        }

        public function setValBoleto($valBoleto){
            if(!$this->validacaoDecimal($valBoleto))
                $valBoleto = $this->transformacaoDecimal($valBoleto);

            if($this->validacaoDecimal($valBoleto)){
                $this->valBoleto = $valBoleto;
                return true;
            }
            return false;
        }

        public function getValBoleto($indTransforma = false){
            if(!$indTransforma)
                return $this->valBoleto;
            return $this->transformacaoMonetario($this->valBoleto);
        }

        public function setDesOrigem($desOrigem){
            $this->desOrigem = $desOrigem;
            return true;
        }

        public function getDesOrigem(){
            return $this->desOrigem;
        }

        public function setCdnPaciente($cdnPaciente){
            if($this->validacaoPaciente($cdnPaciente)){
                $this->cdnPaciente = $cdnPaciente;
                return true;
            }
            return false;
        }

        public function getCdnPaciente(){
            return $this->cdnPaciente;
        }

        public function setNumNossoNumero($numNossoNumero){
            $this->numNossoNumero = $numNossoNumero;
            return true;
        }

        public function getNumNossoNumero(){
            return $this->numNossoNumero;
        }

        public function setCdnUsuario($cdnUsuario){
            $this->cdnUsuario = $cdnUsuario;
            return true;
        }

        public function getCdnUsuario(){
            return $this->cdnusuario;
        }

        public function setDatGerado($datGerado){
            if($this->validacaoDatetime($datGerado)){
                $this->datGerado = $datGerado;
                return true;
            }
            return false;
        }

        public function getDatGerado($indTransforma = false){
            if(!$indTransforma)
                return $this->datGerado;
            return $this->transformacaoDatetime($this->datGerado);
        }
	}
