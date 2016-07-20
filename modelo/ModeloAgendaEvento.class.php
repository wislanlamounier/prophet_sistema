<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o evento
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-04-30
     *
    **/
    class ModeloAgendaEvento extends Modelo{


        /**
         * Método utilizado para retornar o objeto DTO
         * do evento requisitado
         *
         * @param Integer $id - id do evento
         * @return Object - objeto DTO do evento
         *
        **/
        public function getEvento($id){
            return $this->getRegistro('agenda_evento', 'cdnEvento', $id);
        }

        /**
         * Método utilizado para salvar o evento no
         * banco de dados
         *
         * @param Object $dtoAgendaEvento - objeto DTO do evento
         *
        **/
        public function salvar(DTOAgenda_evento $dtoAgendaEvento){
            $dadosFinais = $dtoAgendaEvento->getArrayBanco();
            return $this->inserir('agenda_evento', $dadosFinais);
        }

        /**
         * Método utilizado para deletar o evento
         * do banco de dados
         *
         * @param Object $cdnEvento - código numérico do evento
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function agendaEventoDeletarFim($cdnEvento){
            return $this->deletar('agenda_evento', array('cdnEvento'=>$cdnEvento));
        }

        /**
         * Método utilizado para salvar o evento no banco
         *
         * @param Object $dtoAgendaEvento - objeto DTO do evento
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function agendaEventoCadastrarFim(DTOAgenda_evento $dtoAgendaEvento){
            return $this->salvar($dtoAgendaEvento);
        }

        /**
         * Método responsável por atualizar o evento
         * no banco de dados
         *
         * @param Object $dtoAgendaEvento - objeto DTO do evento
         * @return Boolean - true se sucesso, false se não
         *
         *
        **/
        public function agendaEventoAtualizarFim(DTOAgenda_evento $dtoAgendaEvento){

            $dados = $dtoAgendaEvento->getArrayBanco();
            $cdnEvento = $dtoAgendaEvento->getCdnEvento();

            return $this->atualizar('agenda_evento', $dados, array('cdnEvento' => $cdnEvento));
        }

    }
