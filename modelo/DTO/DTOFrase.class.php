<?php

/**
 * Classe responsável pelo mantimento de dados de transição com o banco
 * envolvendo a tabela areaatuacao
 *
 * @autor Rafael de Paula - <rafael@bentonet.com.br>
 * @version 1.0.0 - 2015-08-15
 *
 * */
class DTOFrase {

    use DTO;

    use Validacao;

    use Transformacao;

    private $cdnFrase;
    private $cdnUsuario;
    private $strFrase;
    private $indAtiva = 0;

    /**
     * Método responsável por setar o código numérico da frase
     *
     * @param Integer $cdnFrase - código numérico da frase
     * @return Boolean - true se sucesso, false se não
     *
     * */
    public function setCdnFrase($cdnFrase) {
        if ($this->validacaoNumero($cdnFrase)) {
            $this->cdnFrase = $cdnFrase;
            return true;
        }
        return false;
    }

    /**
     * Método responsável por retornar o código numérico da frase
     *
     * @return Integer - código numérico da frase
     *
     * */
    public function getCdnFrase() {
        return $this->cdnFrase;
    }

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
     * Método responsável por setar a frase
     *
     * @param String - frase
     * @return Boolean - true se sucesso, false se não
     *
     * */
    public function setStrFrase($strFrase) {
        if ($this->validacaoVazio($strFrase)) {
            $this->strFrase = $strFrase;
            return true;
        }
        return false;
    }

    /**
     * Método responsável por retornar a frase
     * 
     * @return String - frase
     *
     * */
    public function getStrFrase() {
        return $this->strFrase;
    }

    /**
     * Método responsável por star se a frase está ativa
     *
     * @param Boolean - true se está, false se não
     * @return Boolean - true se sucesso, false se não
     * */
    public function setIndAtiva($indAtiva) {
        $this->indAtiva = $indAtiva;
        return true;
    }

    /**
     * Método responsável por retornar se a frase está ativa
     *
     * @param Boolean - true se deve transformar para Sim/Não
     * @return Mixed - está ativa ou não
     *
     * */
    public function getIndAtiva($indTransformar = false) {
        if (!$indTransformar)
            return $this->indAtiva;
        return $this->transformacaoSim($this->indAtiva);
    }

}
