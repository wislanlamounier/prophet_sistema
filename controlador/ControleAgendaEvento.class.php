<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do evento
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-08
     *
     **/
    class ControleAgendaEvento extends Controlador{

        /**
         * Método responsável por finalizar o cadastro do evento
         *
         * @param String $datEvento - data do evento para cadastrar
         *
         **/
        public function agendaEventoCadastrarFim($datEvento){
            $dtoAgendaEvento = new DTOAgenda_evento();

            if($_GET['allDay'] == 'true'){
                $allDay = 1;
            }else{
                $allDay = 0;
            }


            $datInicio = date("Y-m-d H:i:s", strtotime($datEvento));
            if(!$allDay){
                $datFim = date("Y-m-d H:i:s", strtotime($datEvento)+7200);
            }else{
                $datFim = date("Y-m-d H:i:s", strtotime($datEvento)+86400);
            }

            $cdnTipoEvento = $_GET['cdnTipoEvento'];

            $dtoAgendaEvento->setDatInicio($datInicio);
            $dtoAgendaEvento->setDatFim($datFim);
            $dtoAgendaEvento->setIndAllDay($allDay);
            $dtoAgendaEvento->setCdnUsuario($_SESSION['cdnUsuario']);
            $dtoAgendaEvento->setCdnTipoEvento($cdnTipoEvento);

            $modAgendaEvento = new ModeloAgendaEvento();
            if($modAgendaEvento->agendaEventoCadastrarFim($dtoAgendaEvento)){

                // Geração de log
                $cdnEvento = $this->modelo->ultimoInserido('agenda_evento');
                $this->log(array('sucesso', 'cadastro', 'evento - '.$cdnEvento));

                echo $cdnEvento;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'evento'));

                echo 'erro';

            }
        }

        /**
         * Método utilizado para mostrar a página de cadastro de evento
         *
         * @param Integer $cdnTipoEvento - código numérico do tipo de evento
         *
         **/
        public function agendaEventoCadastrar($cdnTipoEvento){
            $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
            $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($cdnTipoEvento);

            $this->visualizador->atribuirValor('nomTipoEvento', $dtoAgendaTipoEvento->getNomTipoEvento());
            $this->visualizador->atribuirValor('cdnTipoEvento', $cdnTipoEvento);
            $this->visualizador->addJs('js/eventoCadastrar.js');
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Evento');
        }

        /**
         * Método utilizado para cadastrar o evento pela maneira secundária,
         * apenas clicando no tipo de evento na página do calendário.
         *
         * @param Integer $cdnTipoEvento - código numérico do tipo de evento
         *
         **/
        public function agendaEventoCadastrarFimMobile($cdnTipoEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            $dtoAgendaEvento = new DTOAgenda_evento();

            // validação da data de início
            $datInicio = $_POST['datInicio'];
            if($this->agendaEventoValidaData($datInicio)){
                if(count(explode('/', $datInicio)) == 3){
                    $datInicio = explode('/', $datInicio);
                    $datInicio = $datInicio[2].'-'.$datInicio[1].'-'.$datInicio[0];
                }
            }else{
                $this->visualizador->setFlash('Informe uma data de início válida.', 'erro');
                $this->agendaEventoCadastrar($cdnTipoEvento);
                return;
            }

            // validação do horário de início
            if(!isset($_POST['indAllDay'])){
                $horaInicio = $_POST['horaInicio'];
                if($this->agendaEventoValidaHorario($horaInicio)){
                    if(count(explode('e', $horaInicio)) == 2){
                        $horaInicio = explode('e', $horaInicio);
                        $horaInicio = $horaInicio[0].':'.$horaInicio[1];
                    }
                    $datInicio .= ' '.$horaInicio.':00';
                }else{
                    $this->visualizador->setFlash('Informe um horário de início válido.', 'erro');
                    $this->agendaEventoCadastrar($cdnTipoEvento);
                    return;
                }
            }else{
                $datInicio .= ' 00:00:00';
            }


            if(isset($_POST['indAviso'])){
                if($_POST['numDiasAviso'] == ''){
                    $this->visualizador->setFlash('Informe uma quantidade de dias de antecedência válida para o aviso.', 'erro');
                    $this->agendaEventoAtualizarMobile($cdnEvento);
                }else{
                    if(!filter_var($_POST['numDiasAviso'], FILTER_VALIDATE_INT) === 0 and !filter_var($_POST['numDiasAviso'], FILTER_VALIDATE_INT)){
                        $this->visualizador->setFlash('Informe uma quantidade de dias de antecedência válida para o aviso.', 'erro');
                        $this->agendaEventoAtualizarMobile($cdnEvento);
                    }
                }
                $dtoAgendaEvento->setIndAviso(1);
                $dtoAgendaEvento->setNumDiasAviso($_POST['numDiasAviso']);
            }


            // validação da data final
            if(!isset($_POST['indAllDay'])){
                $datFim = $_POST['datFim'];
                if($this->agendaEventoValidaData($datFim)){
                    if(count(explode('/', $datFim)) == 3){
                        $datFim = explode('/', $datFim);
                        $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];
                    }
                }else{
                    $this->visualizador->setFlash('Informe uma data final válida.', 'erro');
                    $this->agendaEventoCadastrar($cdnTipoEvento);
                    return;
                }

                // validação do horário final
                $horaFim = $_POST['horaFim'];
                if($this->agendaEventoValidaHorario($horaFim)){
                    if(count(explode('e', $horaFim)) == 2){
                        $horaFim = explode('e', $horaFim);
                        $horaFim = $horaFim[0].':'.$horaFim[1];
                    }
                    $datFim .= ' '.$horaFim.':00';
                }else{
                    $this->visualizador->setFlash('Informe um horário final válido.', 'erro');
                    $this->agendaEventoCadastrar($cdnTipoEvento);
                    return;
                }
            }else{
                $datInicio2 = strtotime($datInicio);
                $datFim = $datInicio2+86400;
                $datFim = date('Y-m-d H:i:s', $datFim);
            }

            $dtoAgendaEvento->setDatInicio($datInicio);
            $dtoAgendaEvento->setDatFim($datFim);
            $dtoAgendaEvento->setCdnTipoEvento($cdnTipoEvento);
            $dtoAgendaEvento->setIndAllDay(isset($_POST['indAllDay']) ? 1 : 0);
            $dtoAgendaEvento->setDesEvento($_POST['desEvento']);
            $dtoAgendaEvento->setCdnUsuario($_SESSION['cdnUsuario']);

            if($modAgendaEvento->agendaEventoCadastrarFim($dtoAgendaEvento)){

                // Geração de log
                $cdnEvento = $this->modelo->ultimoInserido('agenda_evento');
                $this->log(array('sucesso', 'cadastro', 'evento - '.$cdnEvento));

                $this->visualizador->setFlash('Evento cadastrado com sucesso.', 'sucesso');
                $this->agendaEventoCadastrar($cdnTipoEvento);
            }else{
                // Geração de log
                $this->log(array('erro', 'cadastro', 'evento'));

                $this->visualizador->setFlash('Ocorreu algum problema no cadastro.', 'erro');
                $this->agendaEventoCadastrar($cdnTipoEvento);

            }

        }

        /**
         * Método utilizado para validar a data do evento
         *
         * @param String $data - data no formato dd/mm/yyyy ou yyyy-mm-dd
         * @return boolean
         **/
        public function agendaEventoValidaData($data){
            if(count(explode('/', $data)) == 3){
                $arrData = explode('/', $data);
                if(!checkdate($arrData[1], $arrData[0], $arrData[2])){
                    return false;
                }else{
                    return true;
                }
            }else{
                if(count(explode('-', $data)) == 3){
                    $arrData = explode('-', $data);
                    if(!checkdate($arrData[1], $arrData[2], $arrData[0])){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
            }
        }

        /**
         * Método utilizado para validar o horário do evento
         *
         * @param String $horario - horário no formato hh:mm ou "hh e mm".
         *
         **/
        public function agendaEventoValidaHorario($horario){
            if(count(explode(':', $horario)) == 2){
                $arrHorario = explode(':', $horario);
                if((is_numeric($arrHorario[0]) || $arrHorario[0] == 0 || $arrHorario[0] == 00) &&
                    (is_numeric($arrHorario[1]) || $arrHorario[1] == 0 || $arrHorario[1] == 00)){
                    if($arrHorario[0] <= 24 && $arrHorario[1] <= 59){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                if(count(explode('e', $horario)) > 1){
                    $arrHorario = explode('e', $horario);
                    if(is_numeric($arrHorario[0]) &&
                        is_numeric($arrHorario[1])){
                        if($arrHorario[0] <= 24 && $arrHorario[1] <= 59){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }

        /**
         * Método utilizado por retornar o HTML da página de consulta do evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         * @return String - html da página
         *
         **/
        public function agendaEventoConsultarFim($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            if($modAgendaEvento->checaExiste('agenda_evento', 'cdnEvento', $cdnEvento)){

                $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);

                $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
                $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($dtoAgendaEvento->getCdnTipoEvento());

                $datInicio = strtotime($dtoAgendaEvento->getDatInicio());
                $datInicio = date('d/m/Y H:i:s', $datInicio);

                $datFim = strtotime($dtoAgendaEvento->getDatFim());
                $datFim = date('d/m/Y H:i:s', $datFim);

                if($dtoAgendaEvento->getDesEvento() != ''){
                    $desEvento = $dtoAgendaEvento->getDesEvento();
                }else{
                    $desEvento = 'Descrição não informada.';
                }

                $html = '
                <div class="col-md-12">
                    <h3>Tipo: '.$dtoAgendaTipoEvento->getNomTipoEvento().'</h3>
                </div>
                <div class="col-md-6 text-center">
                    <h4>Início: '.$datInicio.'</h4>
                </div>
                <div class="col-md-6 text-center">
                    <h4>Fim: '.$datFim.'</h4>
                </div>
                <div style="max-height: 100px; overflow-y: auto;" class="col-md-12">
                    <p style="text-align: justify !important;">'.nl2br($desEvento).'</p>
                </div>
                <div class="col-md-12 text-center">
                    <a href="'.BASE_URL.'/agenda/calendario">Sair</a>
                </div>';
                echo $html;
            }else{
                $cdnEvento = substr($cdnEvento, 4);
                if($this->modelo->checaExiste('dentista_fechado', 'cdnFechado', $cdnEvento)){
                    $modDentista = new ModeloDentista();
                    $dtoFechado = $modDentista->getDentistaFechado($cdnEvento);
                    echo '<h3>Razão do fechamento:</h3>';
                    echo '<p>'.$dtoFechado->getDesFechado().'</p>';
                    if(!$dtoFechado->getIndAllDay()){
                        echo '<p>'.$dtoFechado->getHoraInicio().' - '.$dtoFechado->getHoraFinal().'</p>';
                    }
                }else{
                    echo '<h3>Evento não encontrado.</h3>';
                }
            }

        }

        /**
         * Método utilizado para mostrar a página de atualização
         *
         * @param Integer $cdnEvento - código numérico do evento
         *
         **/
        public function agendaEventoAtualizar($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            if($modAgendaEvento->checaExiste('agenda_evento', 'cdnEvento', $cdnEvento)){
                $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);

                $modAgendaTipoEvento = new ModeloAgendaTipoEvento();

                $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($dtoAgendaEvento->getCdnTipoEvento());
                $tipos = $modAgendaEvento->consultar('agenda_tipoevento', '*', array('cdnUsuario' => $_SESSION['cdnUsuario']));
                $html = '
                <div class="col-md-12">
                    <a href="'.BASE_URL.'/agendaEvento/atualizarMobile/'.$cdnEvento.'">Mais informações</a>
                </div>
                <div class="col-md-12 form-group">
                    <label class="control-label" for="cdnTipoEvento">Tipo de evento</label>
                    <select id="cdnTipoEvento" name="cdnTipoEvento" class="form-control">
                ';
                foreach($tipos as $linha){
                    if($linha['cdnTipoEvento'] == $dtoAgendaEvento->getCdnTipoEvento())
                        $selected = 'selected';
                    else
                        $selected = '';
                    $html .= '<option '.$selected.' value="'.$linha['cdnTipoEvento'].'">'.$linha['nomTipoEvento'].'</option>';
                }
                $html .= '
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label class="control-label" for="desEvento">Descrição</label>
                    <textarea id="desEvento" name="desEvento" class="form-control" placeholder="Descrição do evento">'.$dtoAgendaEvento->getDesEvento().'</textarea>
                </div>';
                echo $html;
            }else{
                $cdnEvento = substr($cdnEvento, 4);
                if($this->modelo->checaExiste('dentista_fechado', 'cdnFechado', $cdnEvento)){
                    echo '<h3>Não é possível atualizar o fechamento da agenda.</h3>';
                }else{
                    echo '<h3>Evento não encontrado.</h3>';
                }
            }
        }

        /**
         * Método responsável por mostrar a tela de atualização de evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         *
         **/
        public function agendaEventoAtualizarMobile($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);

            $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
            $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($dtoAgendaEvento->getCdnTipoEvento());

            $datInicio = $dtoAgendaEvento->getDatInicio();
            $arrInicio = explode(' ', $datInicio);
            $datInicio = $arrInicio[0];
            $datInicio = date('Y-m-d', strtotime($datInicio));
            $horaInicio = $arrInicio[1];
            $horaInicio = explode(':', $horaInicio);
            $horaInicio = $horaInicio[0].':'.$horaInicio[1];

            $datFim = $dtoAgendaEvento->getDatFim();
            $arrFinal = explode(' ', $datFim);
            $datFim = $arrFinal[0];
            $datFim = date('Y-m-d', strtotime($datFim));
            $horaFim = $arrFinal[1];
            $horaFim = explode(':', $horaFim);
            $horaFim = $horaFim[0].':'.$horaFim[1];

            $this->visualizador->addJs('js/eventoCadastrar.js');
            $this->visualizador->atribuirValor('dtoAgendaTipoEvento', $dtoAgendaTipoEvento);
            $this->visualizador->atribuirValor('nomTipoEvento', $dtoAgendaTipoEvento->getNomTipoEvento());

            $this->visualizador->atribuirValor('dtoAgendaEvento', $dtoAgendaEvento);
            $this->visualizador->atribuirValor('cdnEvento', $cdnEvento);

            $this->visualizador->atribuirValor('horaInicio', $horaInicio);
            $this->visualizador->atribuirValor('datInicio', $datInicio);

            $this->visualizador->atribuirValor('horaFim', $horaFim);
            $this->visualizador->atribuirValor('datFim', $datFim);

            $this->visualizador->mostrarNaTela('atualizarMobile', 'Atualizar evento de '.$dtoAgendaTipoEvento->getNomTipoEvento());
        }

        /**
         * Método responsável por finalizar a atualização do evento.
         *
         * @param Integer $cdnEvento - código numérico do evento
         *
         **/
        public function agendaEventoAtualizarMobileFim($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);
            $cdnTipoEvento = $dtoAgendaEvento->getCdnTipoEvento();

            // validação da data de início
            $datInicio = $_POST['datInicio'];
            if($this->agendaEventoValidaData($datInicio)){
                if(count(explode('/', $datInicio)) == 3){
                    $datInicio = explode('/', $datInicio);
                    $datInicio = $datInicio[2].'-'.$datInicio[1].'-'.$datInicio[0];
                }
            }else{
                $this->visualizador->setFlash('Informe uma data de início válida.', 'erro');
                $this->agendaEventoAtualizarMobile($cdnEvento);
                return;
            }

            // validação do horário de início
            if(!isset($_POST['indAllDay'])){
                $horaInicio = $_POST['horaInicio'];
                if($this->agendaEventoValidaHorario($horaInicio)){
                    if(count(explode('e', $horaInicio)) == 2){
                        $horaInicio = explode('e', $horaInicio);
                        $horaInicio = $horaInicio[0].':'.$horaInicio[1];
                    }
                    $datInicio .= ' '.$horaInicio.':00';
                }else{
                    $this->visualizador->setFlash('Informe um horário de início válido.', 'erro');
                    $this->agendaEventoAtualizarMobile($cdnEvento);
                    return;
                }
            }else{
                $datInicio .= ' 00:00:00';
            }

            if(isset($_POST['indAviso'])){
                if($_POST['numDiasAviso'] == ''){
                    $this->visualizador->setFlash('Informe uma quantidade de dias de antecedência válida para o aviso.', 'erro');
                    $this->agendaEventoAtualizarMobile($cdnEvento);
                }else{
                    if(!filter_var($_POST['numDiasAviso'], FILTER_VALIDATE_INT) === 0 and !filter_var($_POST['numDiasAviso'], FILTER_VALIDATE_INT)){
                        $this->visualizador->setFlash('Informe uma quantidade de dias de antecedência válida para o aviso.', 'erro');
                        $this->agendaEventoAtualizarMobile($cdnEvento);
                    }
                }
                $dtoAgendaEvento->setIndAviso(1);
                $dtoAgendaEvento->setNumDiasAviso($_POST['numDiasAviso']);
            }else{
                $dtoAgendaEvento->setIndAviso(0);
                $dtoAgendaEvento->setNumDiasAviso(0);
            }


            // validação da data final
            if(!isset($_POST['indAllDay'])){
                $datFim = $_POST['datFim'];
                if($this->agendaEventoValidaData($datFim)){
                    if(count(explode('/', $datFim)) == 3){
                        $datFim = explode('/', $datFim);
                        $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];
                    }
                }else{
                    $this->visualizador->setFlash('Informe uma data final válida.', 'erro');
                    $this->agendaEventoAtualizarMobile($cdnEvento);
                    return;
                }

                // validação do horário final
                $horaFim = $_POST['horaFim'];
                if($this->agendaEventoValidaHorario($horaFim)){
                    if(count(explode('e', $horaFim)) == 2){
                        $horaFim = explode('e', $horaFim);
                        $horaFim = $horaFim[0].':'.$horaFim[1];
                    }
                    $datFim .= ' '.$horaFim.':00';
                }else{
                    $this->visualizador->setFlash('Informe um horário final válido.', 'erro');
                    $this->agendaEventoAtualizarMobile($cdnEvento);
                    return;
                }
            }else{
                $datInicio2 = strtotime($datInicio);
                $datFim = $datInicio2+86400;
                $datFim = date('Y-m-d H:i:s', $datFim);
            }


            $dtoAgendaEvento->setDatInicio($datInicio);
            $dtoAgendaEvento->setDatFim($datFim);
            $dtoAgendaEvento->setCdnTipoEvento($cdnTipoEvento);
            $dtoAgendaEvento->setIndAllDay(isset($_POST['indAllDay']) ? 1 : 0);
            $dtoAgendaEvento->setDesEvento($_POST['desEvento']);
            $dtoAgendaEvento->setCdnUsuario($_SESSION);

            if($modAgendaEvento->agendaEventoAtualizarFim($dtoAgendaEvento)){

                // Geração de log
                $this->log(array('sucesso', 'atualizacao', 'evento - '.$cdnEvento));

                $this->visualizador->setFlash('Evento atualizado com sucesso.', 'sucesso');
                $this->agendaEventoAtualizarMobile($cdnEvento);
            }else{
                // Geração de log
                $this->log(array('erro', 'atualizacao', 'evento - '.$cdnEvento));

                $this->visualizador->setFlash('Ocorreu algum problema na atualização.', 'erro');
                $this->agendaEventoAtualizarMobile($cdnEvento);

            }
        }

        /**
         * Método responsável por finalizar a ação de atualizar o evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         *
         **/
        public function agendaEventoAtualizarFim($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            if($modAgendaEvento->checaExiste('agenda_evento', 'cdnEvento', $cdnEvento)){
                $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);
                $dtoAgendaEvento->setDesEvento($_GET['desEvento']);
                $dtoAgendaEvento->setCdnTipoEvento($_GET['cdnTipoEvento']);
                if($modAgendaEvento->agendaEventoAtualizarFim($dtoAgendaEvento)){
                    $this->log(array('sucesso', 'atualizacao', 'evento - '.$cdnEvento));
                    echo 1;
                }else{
                    $this->log(array('erro', 'atualizacao', 'evento - '.$cdnEvento));
                    echo 'nao';
                }
            }else{
                echo 'nao';
            }
        }

        /**
         * Método responsável por atualizar o horário do evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         *
         **/
        public function agendaEventoAtualizarHorario($cdnEvento){
            $modAgendaEvento = new ModeloAgendaEvento();
            if($modAgendaEvento->checaExiste('agenda_evento', 'cdnEvento', $cdnEvento)){
                $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);
                $datInicio = $_GET['datInicio'];
                $datInicio = date("Y-m-d H:i:s", strtotime($datInicio));
                if($_GET['allDay'] == 'false'){
                    $datFim = $_GET['datFim'];
                    $datFim = date('Y-m-d H:i:s', strtotime($datFim));
                    $dtoAgendaEvento->setIndAllDay(0);
                }else{
                    $datFim = date("Y-m-d H:i:s", strtotime($datInicio)+86400);
                    $dtoAgendaEvento->setIndAllDay(1);
                }

                $dtoAgendaEvento->setDatInicio($datInicio);
                $dtoAgendaEvento->setDatFim($datFim);

                if($modAgendaEvento->agendaEventoAtualizarFim($dtoAgendaEvento)){
                    $this->log('sucesso', 'atualizacao', 'evento - '.$cdnEvento);
                    echo 1;
                }else{
                    $this-log('erro', 'atualizacao', 'evento - '.$cdnEvento);
                    echo 0;
                }
            }else{
                echo 'nao';
            }
        }

        /**
         * Método utilizado para finalizar ação de deletar evento
         *
         * @param Integer $cdnEvento - código numérico do evento
         */
        public function agendaEventoDeletarFim($cdnEvento){
            if($this->modelo->checaExiste('agenda_evento', 'cdnEvento', $cdnEvento)){
                $modAgendaEvento = new ModeloAgendaEvento();
                $dtoAgendaEvento = $modAgendaEvento->getEvento($cdnEvento);
                if($modAgendaEvento->agendaEventoDeletarFim($cdnEvento)){
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'evento - '.$cdnEvento));
                }else{
                    // Geração de log
                    $this->log(array('erro', 'delecao', 'evento - '.$cdnEvento));
                }
            }else{
                $cdnEvento = substr($cdnEvento, 4);
                if($this->modelo->checaExiste('dentista_fechado', 'cdnFechado', $cdnEvento)){
                    if($this->modelo->deletar('dentista_fechado', array('cdnFechado' => $cdnEvento))){
                        $this->log(array('sucesso', 'delecao', 'dentista_fechado'));
                    }else{
                        $this->log(array('erro', 'delecao', 'dentista_fechado'));
                    }
                }
            }
        }

        /**
         * Método utilizado para retornar o JSON dos eventos
         *
         * @return JSON - json dos eventos.
         *
         **/
        public function agendaEventoRetornaJson(){
            $modAgendaEvento = new ModeloAgendaEvento();
            $modAgendaTipoEvento = new ModeloAgendaTipoEvento();
            $consulta = $modAgendaEvento->consultar('agenda_evento', '*', array('cdnUsuario' => $_SESSION['cdnUsuario']));
            $ctrlAgenda = new ControleAgenda();
            $json = $ctrlAgenda->agendaConsultaJson($_SESSION['cdnUsuario'], false, true);
            $json = json_decode($json);
            foreach($consulta as $linha){
                $dtoAgendaEvento = $modAgendaEvento->getEvento($linha['cdnEvento']);
                $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($linha['cdnTipoEvento']);
                if($dtoAgendaTipoEvento->getCodCor() == 'blue')
                    $bg = '#0073b7';
                if($dtoAgendaTipoEvento->getCodCor() == 'red')
                    $bg = '#dd4b39';
                if($dtoAgendaTipoEvento->getCodCor() == 'yellow')
                    $bg = '#f39c12';
                if($dtoAgendaTipoEvento->getCodCor() == 'purple')
                    $bg = '#605ca8';
                if($dtoAgendaTipoEvento->getCodCor() == 'green')
                    $bg = '#00a65a';

                if($dtoAgendaEvento->getIndAllDay())
                    $indAllDay = true;
                else
                    $indAllDay = false;
                $json[] = array('title' => $dtoAgendaTipoEvento->getNomTipoEvento(),
                                'start' => $dtoAgendaEvento->getDatInicio(),
                                'end' => $dtoAgendaEvento->getDatFim(),
                                'allDay' => $indAllDay,
                                'backgroundColor' => $bg,
                                'borderColor' => $bg,
                                'id' => $dtoAgendaEvento->getCdnEvento()
                );
            }


            echo json_encode($json);
            return json_encode($json);
        }
    }
