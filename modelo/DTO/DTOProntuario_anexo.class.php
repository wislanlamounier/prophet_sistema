<?php

    /**
    * Classe responsável pelo mantimento de dados de transição com o banco
    * envolvendo a tabela prontuario_anexo
    *
    * @autor Rafael de Paula - <rafael@bentonet.com.br>
    * @version 1.0.0 - 2015-10-17
    *
    **/
    class DTOProntuario_anexo{
        use DTO;
        use Validacao;
        use Transformacao;
        private $cdnProntuarioAnexo;
        private $cdnPaciente;
        private $desProntuarioAnexo;
        private $strDiretorio;
        private $valTamanho;

        /**
         * Método responsável por setar o código numérico do anexo
         *
         * @param Integer $cdnProntuarioAnexo - código numérico do anexo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnProntuarioAnexo($cdnProntuarioAnexo){
            if($this->validacaoNumero($cdnProntuarioAnexo)){
                $this->cdnProntuarioAnexo = $cdnProntuarioAnexo;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o código numérico do anexo
         *
         * @return Integer - código numérico do anexo
         *
        **/
        public function getCdnProntuarioAnexo(){
            return $this->cdnProntuarioAnexo;
        }


        /**
         * Método responsável por setar o código numérico do paciente
         * 
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnPaciente($cdnPaciente){
            if($this->validacaoNumero($cdnPaciente)){
                if($this->validacaoPaciente($cdnPaciente)){
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
        public function getCdnPaciente(){ 
            return $this->cdnPaciente; 
        }

        /**
         * Método responsável por setar o diretório do anexo
         *
         * @param String $strDiretorio - diretório do anexo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setStrDiretorio($strDiretorio){
            if($this->validacaoArquivo($strDiretorio, array('imagem', 'pdf'))){
                $this->strDiretorio = $strDiretorio;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por setar a descrição do anexo
         *
         * @param String $desProntuarioAnexo - descrição do anexo
         * @return Void.
         *
        **/
        public function setDesProntuarioAnexo($desProntuarioAnexo){
            $this->desProntuarioAnexo = $desProntuarioAnexo;
            return true;
        }

        /**
         * Método responsável por retornar a descrição do anexo
         *
         * @return String - descrição do anexo
         *
        **/
        public function getDesProntuarioAnexo(){
            return $this->desProntuarioAnexo;
        }

        /**
         * Método responsável por retornar o diretório do anexo
         *
         * @return String - diretório do anexo
         *
        **/
        public function getStrDiretorio(){
            return $this->strDiretorio;
        }

        /**
         * Método responsável por setar o tamanho do anexo
         *
         * @param Float $valTamanho - tamanho do anexo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setValTamanho($valTamanho){
            if($this->validacaoNumero($valTamanho)){
                $this->valTamanho = $valTamanho;
                return true;
            }
            return false;
        }

        /**
         * Método responsável por retornar o tamanho do anexo
         *
         * @param Boolean $indModo - transformar para: b, kb, mb, gb, auto (automatico). Padrão: b
         * @return Float - tamanho do anexo
         *
        **/
        public function getValTamanho($indModo = 'b'){
            return $this->transformacaoTamanho($this->valTamanho, $indModo);
        }

    }