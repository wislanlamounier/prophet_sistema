<?php

    class DTODentista_satisfacao{
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnDentista;
        private $cdnPaciente;
        private $datSatisfacao;
        private $numNota;
        private $cdnSatisfacao;
        
        public function getCdnDentista() {
            return $this->cdnDentista;
        }

        public function getCdnPaciente() {
            return $this->cdnPaciente;
        }

        public function getDatSatisfacao($indTransformar = false) {
            if(!$indTransformar)
                return $this->datSatisfacao;
            return $this->transformacaoData($this->datSatisfacao);
        }

        public function getNumNota() {
            return $this->numNota;
        }

        public function getCdnSatisfacao() {
            return $this->cdnSatisfacao;
        }

        public function setCdnDentista($cdnDentista) {
            if($this->validacaoDentista($cdnDentista)){
                $this->cdnDentista = $cdnDentista;
                return true;
            }
            return false;
        }

        public function setCdnPaciente($cdnPaciente) {
            if($this->validacaoPaciente($cdnPaciente)){
                $this->cdnPaciente = $cdnPaciente;
                return true;
            }
            return false;
        }

        public function setDatSatisfacao($datSatisfacao) {
            if($this->validacaoData($datSatisfacao)){
                $this->datSatisfacao = $datSatisfacao;
                return true;
            }
            return false;
        }

        public function setNumNota($numNota) {
            if($this->validacaoNumero($numNota)){
                $this->numNota = $numNota;
                return true;
            }
            return false;
        }

        public function setCdnSatisfacao($cdnSatisfacao) {
            $this->cdnSatisfacao = $cdnSatisfacao;
        }

    }
