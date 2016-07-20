<?php

/**
 * Classe que realiza o intermédio entre
 * banco de dados (Modelo.class.php) e
 * visualizações (Visualizador.class.php)
 * do tipo evento
 *
 * @author Rafael de Paula - <rafael@bentonet.com.br>
 * @version 1.0.0 - 2015-08-14
 *
 * */
class ControleAgendaTipoEvento extends Controlador {

    /**
     * Método responsável por mostrar a página de cadastro do tipo evento
     *
     * @return Void.
     *
     * */
    public function agendaTipoEventoCadastrar() {
        $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Tipo de Evento');
        return;
    }

    /**
     * Método responsável por finalizar o cadastro do tipo evento.
     *
     * @return Void.
     *
     * */
    public function agendaTipoEventoCadastrarFim() {
        $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
        $arrValidacao = $modAgendaTipoEvento->agendaTipoEventoPreparaDTO();
        $dtoAgendaTipoEvento = $arrValidacao[0];
        $mesErro = $arrValidacao[1];

        if ($mesErro != '') {
            $this->visualizador->setFlash($mesErro, 'erro');
            $this->agendaTipoEventoCadastrar();
            return;
        }
        
        if ($modAgendaTipoEvento->agendaTipoEventoCadastrarFim($dtoAgendaTipoEvento)) {

            $cdnTipoEvento = $modAgendaTipoEvento->ultimoInserido('agenda_tipoevento');

            // Geração de log
            $this->log(array('sucesso', 'cadastro', 'agenda_tipoevento', $cdnTipoEvento));

            $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
            $ctrlAgenda = new ControleAgenda();
            $ctrlAgenda->agendaCalendario();
            return;
        } else {

            // Geração de log
            $this->log(array('erro', 'cadastro', 'agenda_tipoevento', $_POST['nomTipoEvento']));

            $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
            $this->agendaTipoEventoCadastrar();
            return;
        }
    }

    /**
     * Método utilizado para mostrar a página de atualizar
     * os dados de umo tipo evento.
     *
     * @param Integer $cdnTipoEvento - código numérico do tipo evento
     * @return Void.
     *
     */
    public function agendaTipoEventoAtualizar($cdnTipoEvento) {
        $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
        if ($modAgendaTipoEvento->checaExiste('agenda_tipoevento', 'cdnTipoEvent-o', $cdnTipoEvento)) {
            $dtoAgendaTipoEvento = $modAgendaTipoEvento->getAgendaTipoEvento($cdnTipoEvento);
            if ($dtoAgendaTipoEvento->getCdnUsuario() == $_SESSION['cdnUsuario']) {
                $this->visualizador->atribuirValor('dtoAgendaTipoEvento', $dtoAgendaTipoEvento);
                $this->visualizador->mostrarNaTela('atualizar', 'Atualizar ' . $dtoAgendaTipoEvento->getNomAgendaTipoEvento());
                return;
            }
            $this->erroPermissao();
            return;
        }
        $this->erroExistente();
        return;
    }

    /**
     * Método utilizado para finalizar ação de atualizar
     * o tipo evento
     *
     * @param Integer $cdnTipoEvento - código numérico do tipo evento
     * @return Void.
     *
     * */
    public function agendaTipoEventoAtualizarFim($cdnTipoEvento) {
        $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
        if ($modAgendaTipoEvento->checaExiste('agenda_tipoevento', 'cdnTipoEvento', $cdnTipoEvento)) {
            $arrValidacao = $modAgendaTipoEvento->agendaTipoEventoPreparaDTO($cdnTipoEvento);
            $dtoAgendaTipoEvento = $arrValidacao[0];
            if ($dtoAgendaTipoEvento->getCdnUsuario() == $_SESSION['cdnUsuario']) {
                $mesErro = $arrValidacao[1];

                if ($mesErro != '') {
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->agendaTipoEventoAtualizar($cdnTipoEvento);
                    return;
                }


                if ($modAgendaTipoEvento->agendaTipoEventoAtualizarFim($dtoAgendaTipoEvento)) {

                    // Geração de log
                    $this->log(array('sucesso', 'atualizacao', 'agenda_tipoevento', $cdnTipoEvento));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO);
                    $ctrlAgenda = new ControleAgenda();
                    $ctrlAgenda->agendaCalendario();
                    return;
                } else {

                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'agenda_tipoevento', $cdnTipoEvento));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
                    $this->agendaTipoEventoAtualizar($cdnTipoEvento);
                    return;
                }
            }
            $this->erroPermissao();
            return;
        }
        $this->erroExistente();
        return;
    }

    /**
     * Método responsável por mostrar a lista do tipo eventos do sistema
     *
     * @return Void
     *
     * */
    public function agendaTipoEventoConsultar() {
        $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
        $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
        $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
        $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
        $this->visualizador->atribuirValor('modAgendaTipoEvento', $modAgendaTipoEvento);
        $this->visualizador->atribuirValor('arrTiposEventos', $modAgendaTipoEvento->consultar('agenda_tipoevento', '*', array('cdnUsuario' => $_SESSION['cdnUsuario'])));
        $this->visualizador->mostrarNaTela('consultar', 'Lista de Tipos de Evento');
        return;
    }

    /**
     * Método responsável por mostrar a página de deleção do tipo evento
     *
     * @param Integer $cdnTipoEvento - código numérico do tipo evento
     * @return Void.
     *
     * */
    public function agendaTipoEventoDeletar($cdnTipoEvento) {
        if ($this->modelo->checaExiste('agenda_tipoevento', 'cdnTipoEvento', $cdnTipoEvento)) {
            $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
            $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($cdnTipoEvento);
            if ($dtoAgendaTipoEvento->getCdnUsuario() == $_SESSION['cdnUsuario']) {
                $this->visualizador->atribuirValor('dtoAgendaTipoEvento', $dtoAgendaTipoEvento);
                $this->visualizador->atribuirValor('cdnTipoEvento', $cdnTipoEvento);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar ' . $dtoAgendaTipoEvento->getNomTipoEvento());

                return;
            }
            $this->erroPermissao();
            return;
        }
        $this->erroExistente();
        return;
    }

    /**
     * Método responsável por finalizar a deleção do tipo evento
     *
     * @param Integer $cdnTipoEvento - código numérico do tipo evento
     * @return Void.
     *
     * */
    public function agendaTipoEventoDeletarFim($cdnTipoEvento) {
        if ($this->modelo->checaExiste('agenda_tipoevento', 'cdnTipoEvento', $cdnTipoEvento)) {
            $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
            $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($cdnTipoEvento);
            if ($dtoAgendaTipoEvento->getCdnUsuario() == $_SESSION['cdnUsuario']) {
                $dtoAgendaTipoEvento->setIndDesvinculado(1);
                if ($modAgendaTipoEvento->agendaTipoEventoAtualizarFim($dtoAgendaTipoEvento)) {
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'tipo evento', $cdnTipoEvento));
                    $this->visualizador->setFlash('Tipo de evento deletado.', 'sucesso');
                    $ctrlAgenda = new ControleAgenda();
                    $ctrlAgenda->agendaCalendario();
                } else {
                    // Geração de log
                    $this->log(array('erro', 'delecao', 'tipo evento', $cdnTipoEvento));
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $ctrlAgenda = new ControleAgenda();
                    $ctrlAgenda->agendaCalendario();
                }
                return;
            }
            $this->erroPermissao();
            return;
        }
        $this->erroExistente();
        return;
    }

}
