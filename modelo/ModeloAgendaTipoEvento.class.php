<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o tipo de evento.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-30
     *
    **/
    class ModeloAgendaTipoEvento extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do tipo de evento requisitado
         *
         * @param Integer $cdnTipoEvento - código numérico do tipo de evento
         * @return Object - objeto DTO do tipo de evento
         *
        **/
        public function getTipoEvento($cdnTipoEvento){
            return $this->getRegistro('agenda_tipoevento', 'cdnTipoEvento', $cdnTipoEvento);
        }

        /**
         * Método utilizado para atualizar as informações do tipo de evento
         *
         * @param Object $dtoAgendaTipoEvento - objeto DTO do tipo de evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function agendaTipoEventoAtualizarFim(DTOAgenda_tipoevento $dtoAgendaTipoEvento){

            $dados = $dtoAgendaTipoEvento->getArrayBanco();
            return $this->atualizar('agenda_tipoevento', $dados, array('cdnTipoEvento' => $dtoAgendaTipoEvento->getCdnTipoEvento()));

        }

        /**
         * Método utilizado para preencher o DTO do tipo de evento para cadastro.
         *
         * @param Boolean $cdnTipoEvento - código numérico do tipo de evento (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function agendaTipoEventoPreparaDTO($cdnTipoEvento = 0){
            $mesErro = '';
        	if($cdnTipoEvento == 0){
                // está cadastrando
        		$dtoAgendaTipoEvento = new DTOAgenda_tipoevento();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('agenda_tipoevento', 'cdnTipoEvento', $cdnTipoEvento))
                    return array(new DTOAgenda_tipoevento(), 'Registro não existente.');
                $dtoAgendaTipoEvento = $this->getTipoEvento($cdnTipoEvento);
        	}

            $arrValidacao = array(
                'nomTipoEvento' => array('Informe o nome do tipo de evento.'),
                'codCor' => array('Informe a cor deste evento.')
            );

            $dtoAgendaTipoEvento->setCdnUsuario($_SESSION['cdnUsuario']);

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoAgendaTipoEvento->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoAgendaTipoEvento, $mesErro);
        }

        /**
         * Método utilizado para registrar o tipo de evento
         * no banco de dados
         *
         * @param Object $dtoAgendaTipoEvento - objeto DTO do tipo de evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function agendaTipoEventoCadastrarFim(DTOAgenda_tipoevento $dtoAgendaTipoEvento){

                $dadosFinais = $dtoAgendaTipoEvento->getArrayBanco();
                return $this->inserir('agenda_tipoevento', $dadosFinais);

        }
        
    }
