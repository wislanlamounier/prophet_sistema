<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da agenda
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-08
     *
    **/
    class ControleAgenda extends Controlador{
        use Transformacao;

        /**
         * Método responsável por mostrar a página de calendário
         *
         * @return Void.
         *
        **/
        public function agendaCalendario(){
            //  fullCalendar 2.2.5
            $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
            $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js"');

            $arrCond = array('cdnUsuario' => $_SESSION['cdnUsuario'],
                             'conscond1'  => 'AND',
                             'indDesvinculado' => 0);

            $this->visualizador->atribuirValor('arrTipoEventos', $this->modelo->consultar('agenda_tipoevento', '*', $arrCond));
            $this->visualizador->atribuirValor('modAgendaTipoEvento', new ModeloAgendaTipoEvento());

            $this->visualizador->addJs('js/agendaCalendario.js');

            $this->visualizador->mostrarNaTela('calendario', 'Agenda Pessoal');
            return;
        }

        /**
         * Método responsável por mostrar a página de consulta de agenda de consultórios
         * e da agenda geral da clínica
         *
        **/
        public function agendaConsulta(){
            //  fullCalendar 2.2.5
            $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
            $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js"');

            $this->visualizador->addJs('js/agendaConsulta.js');
            $this->visualizador->mostrarNaTela('consulta', 'Ver agenda');
        }


        /**
         * Método utilizado para retornar o JSON dos eventos
         *
         * @param Integer $cdnDentista - código numérico do dentista (opcional)
         * @return JSON - json dos eventos.
         *
        **/
        public function agendaConsultaJson($cdnDentista = 0, $echo = true, $pessoal = false){
            $dates = $_GET['dates'];
            $inicioData = trim($dates[0]);
            $fimData = trim($dates[1]);

            if($cdnDentista == '')
                $cdnDentista = 0;


            // Consultas
            $modConsulta = new ModeloConsulta();
            $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';
            if(ControleCampo::campoExiste('nomSobrenome'))
                $nomSobrenome = ', nomSobrenome,';
            else
                $nomSobrenome = ',';
            $sql = 'SELECT c.cdnConsulta, p.nomPaciente '.$nomSobrenome.' s.numTelefone as telefone, 
                           c.datConsulta, c.horaConsulta, c.horaFinalizada, r.cdnConsultaOriginal FROM consulta c 
                    LEFT JOIN paciente p on p.cdnPaciente = c.cdnPaciente
                    LEFT JOIN sms_aviso_consulta s ON s.cdnConsulta = c.cdnConsulta 
                    LEFT JOIN retorno r ON r.cdnConsultaRetorno = c.cdnCOnsulta
                    WHERE c.cdnConsulta NOT IN ('.$sqlDesmarques.') 
                    AND datConsulta >= "'.$inicioData.'" 
                    AND datConsulta <= "'.$fimData.'" ';
            
            $sqlFechado = 'SELECT * FROM dentista_fechado WHERE
                           datFechado >= "'.$inicioData.'" AND datFechado <= "'.$fimData.'"';

            $verOutros = true;
            if(Modelo::dentista($_SESSION['cdnUsuario']) || $pessoal){
                if(!Modelo::masterStatic($_SESSION['cdnUsuario']) || $pessoal){
                    $sql .= ' AND cdnDentista = '.$_SESSION['cdnUsuario'];
                    $sqlFechado .= ' AND cdnDentista = '.$_SESSION['cdnUsuario'];
                    $arrCond = array('cdnDentista' => $_SESSION['cdnUsuario']);
                    $verOutros = false;
                }else{
                    if($cdnDentista != 0){
                        $sql .= ' AND cdnDentista = '.$cdnDentista;
                        $sqlFechado .= ' AND cdnDentista = '.$cdnDentista;
                        $arrCond = array('cdnDentista' => $cdnDentista);
                    }else{
                        $arrCond = false;
                    }
                }
            }else{
                if($cdnDentista != 0){
                    $sql .= ' AND cdnDentista = '.$cdnDentista;
                    $sqlFechado .= ' AND cdnDentista = '.$cdnDentista;
                    $arrCond = array('cdnDentista' => $cdnDentista);
                }else{
                    $arrCond = false;
                }
            }

            // echo $sql;
            $arrConsultas = $modConsulta->query($sql);
            $json = array();

            $modPaciente = new ModeloPaciente();
            //print_r($arrConsultas);
            foreach($arrConsultas as $arrConsulta){
                $bg = '#009933';
                $indAllDay = false;

                $start = $arrConsulta['datConsulta'].' '.$arrConsulta['horaConsulta'];
                if(!is_null($arrConsulta['horaFinalizada'])){
                    $end = $arrConsulta['datConsulta'].' '.$arrConsulta['horaFinalizada'];
                }else{
                    $end = $start;
                }


                if(isset($arrConsulta['nomSobrenome']))
                    $arrConsulta['nomPaciente'] .= ' '.$arrConsulta['nomSobrenome'];
                
                $bg = '#093';
                if(!is_null($arrConsulta['telefone']))
                    $bg = '#993';
                if(!is_null($arrConsulta['cdnConsultaOriginal']))
                    $bg = '#dd0';
                
                $json[] = array('title' => $arrConsulta['nomPaciente'],
                                'start' => $start,
                                'end' => $end,
                                'allDay' => $indAllDay,
                                'backgroundColor' => $bg,
                                'borderColor' => $bg,
                                'id' => 'CONS'.$arrConsulta['cdnConsulta']
                            );
            }

            $modDentista = new ModeloDentista();
            // if($cdnDentista != 0){
            //     $arrCond = array('cdnDentista' => $cdnDentista);
            // }else{
            //     $arrCond = false;
            // }

            $arrFechados = $this->modelo->query($sqlFechado);

            // $arrFechados = $this->modelo->consultar('dentista_fechado', '*', $arrCond);
            foreach($arrFechados as $arrFechado){
                $dtoFechado = $modDentista->getDentistaFechado($arrFechado['cdnFechado']);
                $start = $dtoFechado->getDatFechado();
                $end = $dtoFechado->getDatFechado();
                $allDay = 1;
                if(!$dtoFechado->getIndAllDay()){
                    $start .= ' '.$dtoFechado->getHoraInicio();
                    $end .= ' '.$dtoFechado->getHoraFinal();
                    $allDay = 0;
                }
                $json[] = array('title'  => $dtoFechado->getDesFechado(),
                                'start'  => $start,
                                'end'    => $end,
                                'allDay' => $allDay,
                                'backgroundColor' => '#000099',
                                'borderColor' => '#009',
                                'id' => 'FECH'.$dtoFechado->getCdnFechado(),
                                );
            }

            if($cdnDentista != 0 and $cdnDentista == $_SESSION['cdnUsuario'] || $verOutros){
                $dtoDentista = $modDentista->getDentista($cdnDentista);
                $numTempoConsulta = $dtoDentista->getNumTempoConsulta();
                if(!is_null($numTempoConsulta) and $numTempoConsulta != '' and $numTempoConsulta != '__:__'){
                    $numTempoConsulta .= ':00';
                    $numTempoConsulta = $dtoDentista->transformacaoTempoSegundo($numTempoConsulta);
                }else{
                    unset($numTempoConsulta);
                }

                $ctrlDentista = new ControleDentista();
                $semana = array('Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo');
                // Start date
                $date = date('Y-m-d', strtotime($inicioData));
                // End date
                $end_date = date('Y-m-d', strtotime($fimData));

                $datas = array();
                if(isset($numTempoConsulta)){
                    while (strtotime($date) <= strtotime($end_date)) {
                        $condicao = array(
                            'cdnDentista' => $cdnDentista,
                            'conscond1' => 'AND',
                            'datFechado' => $date,
                            'conscond2' => 'AND',
                            'indAllDay' => 1
                        );

                        $diaFechado = count($arrFechados) > 0;
                        foreach ($arrFechados as $arrFechado) {
                            if($arrFechado['datFechado'] == $date && $arrFechado['indAllDay'] == 1 &&
                               $arrFechado['cdnDentista'] == $cdnDentista)
                                $diaFechado = true;
                            else
                                $diaFechado = false;
                        }

                        // $fechado = $this->modelo->consultar('dentista_fechado', '*', $condicao);
                        if(!$diaFechado){
                            $weekDay = $semana[date('N', strtotime($date)) - 1];
                            $horarios = $ctrlDentista->dentistaMontaHorarios($cdnDentista, false, $date, $end_date);
                            $intervalo = false;
                            if(isset($horarios[$weekDay])){
                                foreach($horarios[$weekDay] as $horario){
                                    if(is_array($horario)){
                                        $fimIntervalo = $horario[2];
                                        $horario = $horario[1];
                                        $intervalo = true;
                                    }
                                    if(isset($numTempoConsulta)){
                                        $horario = $dtoDentista->transformacaoTempoSegundo($horario);
                                        $horarioFim = $horario + $numTempoConsulta;
                                        $horarioFim = $dtoDentista->transformacaoSegundoTempo($horarioFim);
                                        $horario = $dtoDentista->transformacaoSegundoTempo($horario);
                                    }else{
                                        $horarioFim = $horario;
                                    }
                                    if($intervalo){
                                        $json[] = array('title'  => 'Intervalo',
                                                    'start'  => $date.' '.$horario,
                                                    'end'    => $date.' '.$fimIntervalo,
                                                    'allDay' => 0,
                                                    'backgroundColor' => '#b8b800',
                                                    'borderColor' => '#b8b800',
                                                    'id' => 'INTE'.$date,
                                                    );
                                        $intervalo = false;
                                        continue;
                                    }
                                    $json[] = array('title'  => 'Horário livre',
                                                    'start'  => $date.' '.$horario,
                                                    'end'    => $date.' '.$horarioFim,
                                                    'allDay' => 0,
                                                    'backgroundColor' => '#900',
                                                    'borderColor' => '#009',
                                                    'id' => 'LIVR'.$date,
                                                    );
                                }
                            }
                        }

                        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                    }
                }
            }

            if($echo)
                echo json_encode($json);
            return json_encode($json);
        }

        /**
         * Método responsável por visualizar um evento na agenda geral
         *
         * @param String $codEvento - código do evento
         * @return Void.
         *
        **/
        public function agendaConsultaVisualizar($codEvento){
            $prefixo = substr($codEvento, 0, 4);
            $codEvento = substr($codEvento, 4);
            if($prefixo == 'CONS'){
                $modConsulta = new ModeloConsulta();
                if($modConsulta->checaExiste('consulta', 'cdnConsulta', $codEvento)){
                    $dtoConsulta = $modConsulta->getConsulta($codEvento);
                    $modPaciente = new ModeloPaciente();
                    $modMain = new ModeloMain(true);
                    $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                    $arrUsuario = $modMain->getUsuario($dtoConsulta->getCdnDentista());
                    $modConsultorio = new ModeloConsultorio();
                    $dtoConsultorio = $modConsultorio->getConsultorio($dtoConsulta->getCdnConsultorio());

                    $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');

                    $html = '
                        <div class="col-md-12 text-center">
                            <h3>Consulta - '.$dtoConsulta->getDatConsulta(true).'</h3>
                        </div>
                        <div class="col-md-6 text-justify">
                            <b>Horário</b>: '.$dtoConsulta->getHoraConsulta().'
                        </div>
                    ';
                    if(!is_null($dtoConsulta->getHoraFinalizada())){
                        $html .= '
                        <div class="col-md-6 text-justify">
                            <b>Fim</b>: '.$dtoConsulta->getHoraFinalizada().'
                        </div>';
                    }else{
                        $html .= '<div class="col-md-6">&nbsp;</div>';
                    }
                    $html .= '
                        <div class="col-md-12 text-justify">
                            <b>Paciente:</b> '.$arrPaciente['nomPaciente'].'
                        </div>';

                    if(ControleCampo::campoExiste('numTelefone1')){
                        $html .= '
                            <div class="col-md-12 text-justify">
                                <b>Telefone:</b> '.$arrPaciente['numTelefone1'].'
                            </div>';
                    }

                    $html .= '
                        <div class="col-md-12 text-justify">
                            <b>Prontuário novo:</b> '.$arrPaciente['cdnPaciente'].'
                        </div>';
                    if($indProntuarioAntigo){
                        $html .= '
                            <div class="col-md-12 text-justify">
                                <b>Prontuário antigo:</b> '.$arrPaciente['numProntuarioAntigo'].'
                            </div>';
                    }
                    $html .= '
                        <div class="col-md-12 text-justify">
                            <b>Dentista:</b> '.$arrUsuario['nomUsuario'].'
                        </div>
                        <div class="col-md-12 text-justify">
                            <b>Consultório:</b> '.$dtoConsultorio->getNumConsultorio().'
                        </div>
                        <div class="col-xs-12 text-center">
                            <a target="_blank" href="'.BASE_URL.'/consulta/consultarFim/'.$dtoConsulta->getCdnConsulta().'">
                                Visualizar consulta
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="'. BASE_URL.'/falta/cadastrar/'. $dtoConsulta->getCdnPaciente().'/'.$dtoConsulta->getCdnConsulta().'">
                                    <button type="button" class="btn btn-block btn-lg btn-primary">
                                        Marcar falta
                                    </button>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="'. BASE_URL.'/desmarque/cadastrar/'. $dtoConsulta->getCdnPaciente().'/'.$dtoConsulta->getCdnConsulta().'">
                                    <button type="button" class="btn btn-block btn-lg btn-success">
                                        Desmarcar consulta
                                    </button>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="'. BASE_URL.'/consulta/remarcar/'. $dtoConsulta->getCdnConsulta().'">
                                    <button type="button" class="btn btn-block btn-lg btn-warning">
                                        Remarcar
                                    </button>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="'.BASE_URL.'/consulta/cadastrar/'.$dtoConsulta->getCdnConsulta().'">
                                    <button type="button" class="btn btn-block btn-lg btn-danger">
                                        Marcar retorno
                                    </button>
                                </a>
                            </div>
                        </div>
                    ';
                }else{
                    $html = '<h1>Evento inválido!</h1>';
                }
            }elseif($prefixo == 'FECH'){
                $modDentista = new ModeloDentista();
                if($modDentista->checaExiste('dentista_fechado', 'cdnFechado', $codEvento)){
                    $modMain = new ModeloMain(true);
                    $dtoFechado = $modDentista->getDentistaFechado($codEvento);
                    $arrUsuario = $modMain->getUsuario($dtoFechado->getCdnDentista());
                    $html = '
                        <div class="col-md-12 text-center">
                            <h3>Agenda fechada - '.$arrUsuario['nomUsuario'].'</h3>
                        </div>
                        <div class="col-md-12 text-justify">
                            <b>Data:</b> '.$dtoFechado->getDatFechado(true).'
                        </div>
                        <div class="col-md-12 text-justify">
                            <b>Descrição:</b> '.$dtoFechado->getDesFechado().'
                        </div>
                    ';
                    if(!$dtoFechado->getIndAllDay()){
                        $html .= '
                            <div class="col-md-12 text-justify">
                                <b>Horário:</b> '.$dtoFechado->getHoraInicio().' - '.$dtoFechado->getHoraFinal().'
                            </div>
                        ';
                    }
                }else{
                    $html = '<h1>Evento inválido!</h1>';
                }
            }elseif($prefixo == 'LIVR'){
                $html = '<h1>Horário livre</h1>';
            }elseif($prefixo == 'INTE'){
                $html = '<h1>Intervalo</h1>';
            }else{
                $html = '<h1>Evento inválido!</h1>';
            }

            echo $html;
            return;
        }

        /**
         * Método responsável por mostrar a genda por consultório, na tela
         *
         * @return Void.
         *
        **/
        public function agendaConsultorio(){
            $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
            $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js"');

            $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0));
            $this->visualizador->atribuirValor('arrConsultorios', $arrConsultorios);

            $this->visualizador->addJs('js/agendaConsultorio.js');
            $this->visualizador->mostrarNaTela('consultorio', 'Agenda por consultório');
            return;
        }

        /**
         * Método responsável por montar o JSON das consultas de um consultório
         *
         * @param Integer $cdnConsultorio - código numérico do consultório
         * @return Void.
         *
        **/
        public function agendaConsultorioJson($cdnConsultorio){
            if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
                $dates = $_GET['dates'];
                $inicioData = trim($dates[0]);
                $fimData = trim($dates[1]);
                // Consultas
                $modConsulta = new ModeloConsulta();
                $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';
                $sql = 'SELECT * FROM consulta c WHERE c.cdnConsulta NOT IN ('.$sqlDesmarques.')
                        AND cdnConsultorio = '.$cdnConsultorio.' AND datConsulta >= "'.$inicioData.'" AND datConsulta <= "'.$fimData.'"';
                if(Modelo::dentista($_SESSION['cdnUsuario'])){
                    if(!Modelo::masterStatic($_SESSION['cdnUsuario']))
                        $sql .= ' AND cdnDentista = '.$_SESSION['cdnUsuario'];
                }

                $arrConsultas = $modConsulta->query($sql);
                $json = array();
                $modPaciente = new ModeloPaciente();

                foreach($arrConsultas as $arrConsulta){
                    $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                    $bg = '#009933';
                    $indAllDay = false;

                    $start = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta();
                    if(!is_null($dtoConsulta->getHoraFinalizada())){
                        $end = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraFinalizada();
                    }else{
                        $end = $start;
                    }

                    $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);

                    $json[] = array('title' => $arrPaciente['nomPaciente'],
                                    'start' => $start,
                                    'end' => $end,
                                    'allDay' => $indAllDay,
                                    'backgroundColor' => '#093',
                                    'borderColor' => $bg,
                                    'id' => 'CONS'.$dtoConsulta->getCdnConsulta()
                                );
                }

                echo json_encode($json);
                return json_encode($json);
            }
            return;
        }

        /**
         * Método responsável por mostrar a página de impressão de agenda por consultório
         *
         * @return Void.
         *
        **/
        public function agendaConsultorioImprimir(){
            if(!isset($_POST['datConsulta'])){
                $datConsulta = date('d/m/Y');
                $datConsultaIni = date('Y-m-d');
                $datConsultaFim = date('Y-m-d');
            }else{
                $datConsulta = $_POST['datConsulta'];
                if(trim($datConsulta) != ''){
                    $datConsultaArr = explode('-', $datConsulta);

                    $datConsultaIni = trim($datConsultaArr[0]);
                    $datConsultaIni = explode('/', $datConsultaIni);
                    $datConsultaIni = $datConsultaIni[2].'-'.$datConsultaIni[1].'-'.$datConsultaIni[0];

                    $datConsultaFim = trim($datConsultaArr[1]);
                    $datConsultaFim = explode('/', $datConsultaFim);
                    $datConsultaFim = $datConsultaFim[2].'-'.$datConsultaFim[1].'-'.$datConsultaFim[0];
                }else{
                    $datConsulta = date('d/m/Y');
                    $datConsultaIni = date('Y-m-d');
                    $datConsultaFim = date('Y-m-d');
                }
            }
            if(!isset($_POST['cdnConsultorio']))
                $_POST['cdnConsultorio'] = '';

            if($_POST['cdnConsultorio'] != ''){
                if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $_POST['cdnConsultorio'])){
                    $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('cdnConsultorio' => $_POST['cdnConsultorio']));
                }else{
                    $arrConsultorios = $this->modelo->consultar('consultorio');
                }
            }else{
                $arrConsultorios = $this->modelo->consultar('consultorio');
            }
            $arrFinal = array();
            foreach($arrConsultorios as $arrConsultorio){
                $desmarcadas = 'SELECT cdnConsulta FROM desmarque';
                $sql = 'SELECT * FROM consulta WHERE datConsulta >= "'.$datConsultaIni.'" AND datConsulta <= "'.$datConsultaFim.'"
                        AND cdnConsultorio = '.$arrConsultorio['cdnConsultorio'].' AND cdnConsulta NOT IN ('.$desmarcadas.')
                        ORDER BY cdnDentista, datConsulta, horaConsulta';
                $arrFinal[$arrConsultorio['cdnConsultorio']] = array();
                $arrConsultas = $this->modelo->query($sql);
                foreach($arrConsultas as $arrConsulta){
                    $arrFinal[$arrConsultorio['cdnConsultorio']][] = $arrConsulta['cdnConsulta'];
                }
            }

            $modConsultorio = new ModeloConsultorio();
            $modConsulta = new ModeloConsulta();
            $this->visualizador->atribuirValor('modConsultorio', $modConsultorio);
            $this->visualizador->atribuirValor('modConsulta', $modConsulta);

            $modMain = new ModeloMain(true);
            $modPaciente = new ModeloPaciente();
            $this->visualizador->atribuirValor('modMain', $modMain);
            $this->visualizador->atribuirValor('modPaciente', $modPaciente);


            $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0));
            $this->visualizador->atribuirValor('arrConsultorios', $arrConsultorios);

            $this->visualizador->atribuirValor('cdnConsultorio', $_POST['cdnConsultorio']);

            $this->visualizador->atribuirValor('datConsultaIni', $datConsultaIni);
            $this->visualizador->atribuirValor('datConsultaFim', $datConsultaFim);
            $this->visualizador->atribuirValor('datConsulta', $datConsulta);
            $this->visualizador->atribuirValor('arrFinal', $arrFinal);
            $this->visualizador->mostrarNaTela('consultorioImprimir', 'Agenda por consultório');
            return;
        }

        /**
         * Método responsável por imprimir a agenda por consultório
         *
         * @param String $datConsultaIni - data de inicio das consultas
         * @param String $datConsultaFim - data final das consultas
         * @param Integer $cdnConsultorio - código numérico do consultorio (opcional)
         * @return Void.
         *
        **/
        public function agendaConsultorioImprimirFim($datConsultaIni, $datConsultaFim, $cdnConsultorio = 0){
            $pdfAgenda = new PDFAgendaConsultorio('P', 'mm');
            $pdfAgenda->setDatConsulta(date('d/m/Y', strtotime($datConsultaIni)).' - '.date('d/m/Y', strtotime($datConsultaFim)));
            $pdfAgenda->AliasNbPages();
            $pdfAgenda->AddPage();

            $modConsultorio = new ModeloConsultorio();
            $modConsulta = new ModeloConsulta();
            $modPaciente = new ModeloPaciente();
            $modMain = new ModeloMain(true);

            if($cdnConsultorio != 0){
                if($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $cdnConsultorio)){
                    $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('cdnConsultorio' => $cdnConsultorio));
                }else{
                    $arrConsultorios = $this->modelo->consultar('consultorio');
                }
            }else{
                $arrConsultorios = $this->modelo->consultar('consultorio');
            }
            foreach($arrConsultorios as $arrConsultorio){
                $pdfAgenda->Ln(3);
                $desmarcadas = 'SELECT cdnConsulta from desmarque';
                $sql = 'SELECT * FROM consulta WHERE datConsulta >= "'.$datConsultaIni.'" AND datConsulta <= "'.$datConsultaFim.'"
                        AND cdnConsultorio = '.$arrConsultorio['cdnConsultorio'].' AND cdnConsulta NOT IN ('.$desmarcadas.')
                        ORDER BY cdnDentista, datConsulta, horaConsulta';
                $arrConsultas = $this->modelo->query($sql);
                if(count($arrConsultas) > 0){
                    $dtoConsultorio = $modConsultorio->getConsultorio($arrConsultorio['cdnConsultorio']);
                    $pdfAgenda->SetWidths(array(0));
                    $pdfAgenda->SetAligns(array('L'));
                    $pdfAgenda->SetFont('Arial', 'B', 12);
                    $pdfAgenda->SetBorders('B');
                    $pdfAgenda->PutRow(array('Consultório: '.$dtoConsultorio->getNumConsultorio()), true);

                    $pdfAgenda->SetWidths(array(22, 18, 85, 30, 35));
                    $pdfAgenda->SetAligns(array('L', 'L', 'L', 'L', 'L'));
                    $pdfAgenda->SetFont('Arial', 'B', 11);
                    $pdfAgenda->SetBorders(array('B', 'B', 'B', 'B', 'B'));
                    $pdfAgenda->PutRow(array('Data', 'Horário', 'Paciente - Telefone', 'Prontuário', 'Dentista'), true);
                }
                $pdfAgenda->SetBorders(array('', '', '', ''));
                $pdfAgenda->SetFont('Arial', '', 11);

                $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');

                foreach($arrConsultas as $arrConsulta){
                    $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                    $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                    $arrUsuario = $modMain->getUsuario($dtoConsulta->getCdnDentista());

                    $nomPaciente = $arrPaciente['nomPaciente'];
                    if(ControleCampo::campoExiste('numTelefone1')){
                        if(trim($arrPaciente['numTelefone1']) != '')
                            $nomPaciente = $arrPaciente['nomPaciente'].' - '.$arrPaciente['numTelefone1'];
                    }

                    $prontuario = $arrPaciente['cdnPaciente'];
                    $prontuario .= $indProntuarioAntigo ? ' - '.$arrPaciente['numProntuarioAntigo'] : '';

                    $pdfAgenda->PutRow(array($dtoConsulta->getDatConsulta(true), $dtoConsulta->getHoraConsulta(), $nomPaciente, $prontuario, $arrUsuario['nomUsuario']), true);
                }
            }

            // Geração de log
            $this->log(array('sucesso', 'impressao', 'agenda-consultorio'));
            $pdfAgenda->Output();
            return;
        }

        /**
         * Método responsável por mostrar a genda por dentista, na tela
         *
         * @return Void.
         *
        **/
        public function agendaDentista(){
            $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
            $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js"');

            $modMain = new ModeloMain(true);
            $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
            $arrUsuarios = array();
            foreach($arrDentistas as $arrDentista){
                $arrUsuarios[] = $modMain->getUsuario($arrDentista['cdnUsuario']);
            }
            $arrDentistas = $arrUsuarios;
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            $this->visualizador->addJs('js/consultaAgenda.js');
            $this->visualizador->mostrarNaTela('dentista', 'Agenda por dentista');
            return;
        }

        /**
         * Método responsável por montar o JSON das consultas de um dentista
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @return Void.
         *
        **/
        public function agendaDentistaJson($cdnDentista){
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $this->agendaConsultaJson($cdnDentista);
            }
            return;
        }

        /**
         * Método responsável por gerar a agenda por dentista
         *
         * @return Void.
         *
        **/
        public function agendaDentistaImprimir(){
            if(!isset($_POST['datConsulta'])){
                $datConsulta = date('d/m/Y');
                $datConsultaIni = date('Y-m-d');
                $datConsultaFim = date('Y-m-d');
            }else{
                $datConsulta = $_POST['datConsulta'];
                if(trim($datConsulta) != ''){
                    $datConsultaArr = explode('-', $datConsulta);

                    $datConsultaIni = trim($datConsultaArr[0]);
                    $datConsultaIni = explode('/', $datConsultaIni);
                    $datConsultaIni = $datConsultaIni[2].'-'.$datConsultaIni[1].'-'.$datConsultaIni[0];

                    $datConsultaFim = trim($datConsultaArr[1]);
                    $datConsultaFim = explode('/', $datConsultaFim);
                    $datConsultaFim = $datConsultaFim[2].'-'.$datConsultaFim[1].'-'.$datConsultaFim[0];
                }else{
                    $datConsulta = date('d/m/Y');
                    $datConsultaIni = date('Y-m-d');
                    $datConsultaFim = date('Y-m-d');
                }
            }

            if(!isset($_POST['cdnDentista']))
                $_POST['cdnDentista'] = '';

            if(Modelo::dentista($_SESSION['cdnUsuario'])){
                if(!Modelo::masterStatic($_SESSION['cdnUsuario'])){
                    $arrDentistas = $this->modelo->consultar('dentista', '*', array('cdnUsuario' => $_SESSION['cdnUsuario']));
                }
            }

            if(!isset($arrDentistas)){
                if($_POST['cdnDentista'] != ''){
                    if($this->modelo->checaExiste('dentista', 'cdnUsuario', $_POST['cdnDentista'])){
                        $arrDentistas = $this->modelo->consultar('dentista', '*', array('cdnUsuario' => $_POST['cdnDentista']));
                    }else{
                        $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
                    }
                }else{
                    $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
                }
            }

            $arrFinal = array();
            foreach($arrDentistas as $arrDentista){
                $desmarcadas = 'SELECT cdnConsulta FROM desmarque';
                $sql = 'SELECT * FROM consulta WHERE datConsulta >= "'.$datConsultaIni.'" AND datConsulta <= "'.$datConsultaFim.'"
                        AND cdnDentista = '.$arrDentista['cdnUsuario'].' AND cdnConsulta NOT IN ('.$desmarcadas.')
                        ORDER BY datConsulta, horaConsulta';
                $arrFinal[$arrDentista['cdnUsuario']] = array();
                $arrConsultas = $this->modelo->query($sql);
                foreach($arrConsultas as $arrConsulta){
                    $arrFinal[$arrDentista['cdnUsuario']][] = $arrConsulta['cdnConsulta'];
                }
            }

            $modConsultorio = new ModeloConsultorio();
            $modConsulta = new ModeloConsulta();
            $this->visualizador->atribuirValor('modConsultorio', $modConsultorio);
            $this->visualizador->atribuirValor('modConsulta', $modConsulta);

            $modMain = new ModeloMain(true);
            $modPaciente = new ModeloPaciente();
            $this->visualizador->atribuirValor('modMain', $modMain);
            $this->visualizador->atribuirValor('modPaciente', $modPaciente);


            $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            $this->visualizador->atribuirValor('cdnDentista', $_POST['cdnDentista']);


            $this->visualizador->atribuirValor('datConsultaIni', $datConsultaIni);
            $this->visualizador->atribuirValor('datConsultaFim', $datConsultaFim);
            $this->visualizador->atribuirValor('datConsulta', $datConsulta);
            $this->visualizador->atribuirValor('arrFinal', $arrFinal);
            $this->visualizador->mostrarNaTela('dentistaImprimir', 'Agenda por dentista');
            return;
        }


        /**
         * Método responsável por imprimir a agenda por dentista
         *
         * @param String $datConsultaIni - data de inicio das consultas
         * @param String $datConsultaFim - data final das consultas
         * @param Integer $cdnDentista - código numérico do consultório (opcional)
         * @return Void.
         *
        **/
        public function agendaDentistaImprimirFim($datConsultaIni, $datConsultaFim, $cdnDentista = 0){
            $pdfAgenda = new PDFAgendaDentista('P', 'mm');
            $pdfAgenda->setDatConsulta(date('d/m/Y', strtotime($datConsultaIni)).' - '.date('d/m/Y', strtotime($datConsultaFim)));
            $pdfAgenda->AliasNbPages();
            $pdfAgenda->AddPage();

            $modConsultorio = new ModeloConsultorio();
            $modConsulta = new ModeloConsulta();
            $modPaciente = new ModeloPaciente();
            $modMain = new ModeloMain(true);

            if(Modelo::dentista($_SESSION['cdnUsuario'])){
                if(!Modelo::masterStatic($_SESSION['cdnUsuario']))
                    $cdnDentista = $_SESSION['cdnUsuario'];
            }

            if($cdnDentista != 0){
                if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                    $arrDentistas = $this->modelo->consultar('dentista', '*', array('cdnUsuario' => $cdnDentista));
                }else{
                    $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
                }
            }else{
                $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
            }

            $ctrlDentista = new ControleDentista();

            $modDentista = new ModeloDentista();

            foreach($arrDentistas as $arrDentista){
                $pdfAgenda->Ln(3);
                $desmarcadas = 'SELECT cdnConsulta FROM desmarque';
                $sql = 'SELECT * FROM consulta WHERE datConsulta >= "'.$datConsultaIni.'" AND datConsulta <= "'.$datConsultaFim.'"
                        AND cdnDentista = '.$arrDentista['cdnUsuario'].' AND cdnConsulta NOT IN ('.$desmarcadas.')
                        ORDER BY datConsulta, horaConsulta';
                $arrConsultas = $this->modelo->query($sql);
                    $arrUsuario = $modMain->getUsuario($arrDentista['cdnUsuario']);
                    $pdfAgenda->SetWidths(array(0));
                    $pdfAgenda->SetAligns(array('L'));
                    $pdfAgenda->SetFont('Arial', 'B', 12);
                    $pdfAgenda->SetBorders('B');
                    $pdfAgenda->PutRow(array('Dentista: '.$arrUsuario['nomUsuario']), true);

                    $pdfAgenda->SetWidths(array(22, 18, 85, 30, 35));
                    $pdfAgenda->SetAligns(array('L', 'L', 'L', 'L', 'L'));
                    $pdfAgenda->SetFont('Arial', 'B', 11);
                    $pdfAgenda->SetBorders(array('B', 'B', 'B', 'B', 'B'));
                    $pdfAgenda->PutRow(array('Data', 'Horário', 'Paciente - Telefone', 'Prontuário', 'Consultório'), true);
                $pdfAgenda->SetBorders(array('', '', ''));
                $pdfAgenda->SetFont('Arial', '', 11);

                $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');

                if($datConsultaIni == $datConsultaFim){
                    $arrFinal = array();

                    $data = $datConsultaIni;
                    $horarios = $ctrlDentista->dentistaMontaHorarios($arrDentista['cdnUsuario'], false, $data);

                    $semana = array('Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo');
                    $weekDay = $semana[date('N', strtotime($data)) - 1];

                    foreach($arrConsultas as $arrConsulta){
                        $arrFinal[$arrConsulta['cdnConsulta']] = $this->transformacaoTempoSegundo($arrConsulta['horaConsulta']);
                    }

                    if(isset($horarios[$weekDay])){
                        foreach($horarios[$weekDay] as $horario){
                            if(is_array($horario))
                                continue;
                            $arrFinal[$horario] = $this->transformacaoTempoSegundo($horario);
                        }
                    }


                    asort($arrFinal);
                    if(count($arrFinal) == 0){
                        if($modDentista->dentistaVerificaFechado($arrDentista['cdnUsuario'], $datConsultaIni)){
                            $pdfAgenda->PutRow(array(
                                '',
                                '',
                                'Agenda Fechada',
                                '',
                                ''
                            ), true);
                        }
                    }

                    foreach($arrFinal as $cdnConsulta => $horaConsulta){
                        if($modDentista->dentistaVerificaFechado($arrDentista['cdnUsuario'], $datConsultaIni)){
                            $pdfAgenda->PutRow(array(
                                '',
                                '',
                                'Agenda Fechada',
                                '',
                                ''
                            ), true);
                            break;
                        }
                        if(strpos($cdnConsulta, ':')){
                            $horario = $this->transformacaoSegundoTempo($horaConsulta);
                            $pdfAgenda->PutRow(array(
                                date('d/m/Y', strtotime($datConsultaIni)),
                                $this->transformacaoSegundoTempo($horaConsulta),
                                ' ',
                                '0',
                                '0'
                            ), true);
                        }else{
                            $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                            $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                            $dtoConsultorio = $modConsultorio->getConsultorio($dtoConsulta->getCdnConsultorio());

                            $prontuario = $arrPaciente['cdnPaciente'];
                            $prontuario .= $indProntuarioAntigo ? ' - '.$arrPaciente['numProntuarioAntigo'] : '';

                            $nomPaciente = $arrPaciente['nomPaciente'];
                            if(ControleCampo::campoExiste('numTelefone1')){
                                if(trim($arrPaciente['numTelefone1']) != '')
                                    $nomPaciente = $arrPaciente['nomPaciente'].' - '.$arrPaciente['numTelefone1'];
                            }

                            $pdfAgenda->PutRow(array($dtoConsulta->getDatConsulta(true), $dtoConsulta->getHoraConsulta(), $nomPaciente, $prontuario, $dtoConsultorio->getNumConsultorio()), true);
                        }
                    }

                }else{
                    foreach($arrConsultas as $arrConsulta){
                        $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                        $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                        $dtoConsultorio = $modConsultorio->getConsultorio($dtoConsulta->getCdnConsultorio());

                        $prontuario = $arrPaciente['cdnPaciente'];
                        $prontuario .= $indProntuarioAntigo ? ' - '.$arrPaciente['numProntuarioAntigo'] : '';

                        $nomPaciente = $arrPaciente['nomPaciente'];
                        if(ControleCampo::campoExiste('numTelefone1')){
                            if(trim($arrPaciente['numTelefone1']) != '')
                                $nomPaciente = $arrPaciente['nomPaciente'].' - '.$arrPaciente['numTelefone1'];
                        }

                        $pdfAgenda->PutRow(array($dtoConsulta->getDatConsulta(true), $dtoConsulta->getHoraConsulta(), $nomPaciente, $prontuario, $dtoConsultorio->getNumConsultorio()), true);
                    }
                }
            }

            // Geração de log
            $this->log(array('sucesso', 'impressao', 'agenda-dentista'));

            $pdfAgenda->Output();
            return;
        }

    }
