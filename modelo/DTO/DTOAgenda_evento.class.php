<?php

    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela agenda_evento
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-15
     *
    **/
    class DTOAgenda_evento{
    	use DTO;
    	use Validacao;
    	use Transformacao;
        private $cdnUsuario;
        private $cdnEvento;
        private $cdnTipoEvento;
        private $datFim;
        private $datInicio;
        private $desEvento;
        private $indAllDay;
        private $indAviso;
        private $numDiasAviso;

        /**
         * Método responsável por setar o código numérico do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnUsuario($cdnUsuario){
        	if($this->validacaoNumero($cdnUsuario)){
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
        **/
        public function getCdnUsuario(){
        	return $this->cdnUsuario;
        }

        /**
         * Método responsável por setar o código numérico do evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnEvento($cdnEvento){
        	if($this->validacaoNumero($cdnEvento)){
        		$this->cdnEvento = $cdnEvento;
        		return true;
        	}
        	return false;
        }

        /** 
         * Método responsável por retornar o código numérico do evento
         *
         * @return Integer - código numérico do evento
         *
        **/
        public function getCdnEvento(){
        	return $this->cdnEvento;
        }

        /**
         * Método responsável por setar o código numérico do tipo de evento
         *
         * @param Integer $cdnTipoEvento - código numérico do tipo de evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setCdnTipoEvento($cdnTipoEvento){
        	if($this->validacaoNumero($cdnTipoEvento)){
        		$this->cdnTipoEvento = $cdnTipoEvento;
        		return true;
        	}
        	return false;
        }

        /** 
         * Método responsável por retornar o código numérico do tipo de evento
         *
         * @return Integer - código numérico do tipo de evento
         *
        **/
        public function getCdnTipoEvento(){
        	return $this->cdnTipoEvento;
        }

        /**
         * Método responsável por setar a descrição do evento
         *
         * @param String $desEvento - descrição do evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setDesEvento($desEvento){
        	$this->desEvento = $desEvento;
        }

        /**
         * Método responsável por retornar a descrição do evento
         *
         * @return String - descrição do evento
         *
        **/
        public function getDesEvento(){
        	return $this->desEvento;
        }

        /**
         * Método responsável por setar a data de início do evento
         *
         * @param String $datInicio - início do evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setDatInicio($datInicio){
        	if($this->validacaoDatetime($datInicio)){
        		$this->datInicio = $datInicio;
        		return true;
        	}else{
                $data = $datInicio;
                $data = explode('/', $data);
                if(count($data) == 3){
                    $data = $data[2].'-'.$data[1].'-'.$data[0];
                    $this->datInicio = $data;
                    return true;
                }
            }
        	return false;
        }

        /**
         * Método responsável por retornar a data de inicio
         *
         * @param Boolean $indTransformar - transofmar para padrão brasileiro (DD/MM/YYYY).
         * @return String - data de início do evento
         *
        **/
        public function getDatInicio($indTransformar = false){
        	if(!$indTransformar)
        		return $this->datInicio;
        	return $this->transformacaoData($this->datInicio);
        }

        /**
         * Método responsável por setar a data de término do evento
         *
         * @param String $datFim - término do evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setDatFim($datFim){
        	if($this->validacaoDatetime($datFim)){
        		$this->datFim = $datFim;
        		return true;
        	}
        	return false;
        }

        /**
         * Método responsável por retornar a data de término
         *
         * @param Boolean $indTransformar - transofmar para padrão brasileiro (DD/MM/YYYY).
         * @return String - data de término do evento
         *
        **/
        public function getDatFim($indTransformar = false){
        	if(!$indTransformar)
        		return $this->datFim;
        	return $this->transformacaoData($this->datFim);
        }

        /** 
         * Método responsável por setar se o evento será o dia todo
         *
         * @param Boolean $indAllDay - evento de dia todo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setIndAllDay($indAllDay){
        	$this->indAllDay = $indAllDay;
        	return true;
        }

        /** 
         * Método responsável por retornar se o evento é um evento de dia todo
         * 
         * @return Boolean - true se é, false se não
         *
        **/
        public function getIndAllDay(){
        	return $this->indAllDay;
        }

        /**
         * Método responsável por indicar se deve aparecer um aviso na tela inicial ou não
         *
         * @param Boolean - aparecer na tela inicial ou não
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setIndAviso($indAviso){
        	$this->indAviso = $indAviso;
        	return true;
        }

        /** 
         * Método reponsável por retornar se deve avisar ou não na tela inicial
         *
         * @return Boolean - true se deve, false se não
         *
        **/
        public function getIndAviso(){
            return $this->indAviso;
        }

        /** 
         * Método responsável por setar o número de dias que devem aparecer o aviso antes do evento
         * ocorrer.
         *
         * @param Integer $numDiasAviso - número de dias de antecedência
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function setNumDiasAviso($numDiasAviso){
        	if($this->validacaoNumero($numDiasAviso)){
        		$this->numDiasAviso = $numDiasAviso;
        		return true;
        	}
        	return false;
        }

        /**
         * Método responsável por retornar o número de antecedência que deve aparecer na tela inicial
         *
         * @return Integer - número de dias
         *
        **/
        public function getNumDiasAviso(){
            return $this->numDiasAviso;
        }


	}