<?php

class DTOSms_contagem_paciente {

    use DTO;

    use Validacao;

    use Transformacao;

    private $cdnPaciente;
    private $numEnvios;
    private $numRecebimentos;
    
    public function getCdnPaciente() {
        return $this->cdnPaciente;
    }

    public function getNumEnvios() {
        return $this->numEnvios;
    }

    public function getNumRecebimentos() {
        return $this->numRecebimentos;
    }

    public function setCdnPaciente($cdnPaciente) {
        $this->cdnPaciente = $cdnPaciente;
    }

    public function setNumEnvios($numEnvios) {
        $this->numEnvios = $numEnvios;
    }

    public function setNumRecebimentos($numRecebimentos) {
        $this->numRecebimentos = $numRecebimentos;
    }
}