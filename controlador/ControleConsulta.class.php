<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * das consultas
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-15
     *
    **/
    class ControleConsulta extends Controlador{
        use Transformacao;

        /**
         * Método responsável por mostrar a página de cadastro de consulta
         *
         * @param Integer $cdnConsulta - código numérico da consulta original.
         *                               Utilizado para retornos.
         * @return Void.
         *
        **/
        public function consultaCadastrar($cdnConsulta = 0){
            $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
            $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
            $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js');


            $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
            $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');


            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');


            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('js/orcamentoSelect.js');
            $this->visualizador->addJs('js/consultaCadastrar.js');
            $this->visualizador->addJs('js/consultaAgenda.js');

            $this->visualizador->atribuirValor('arrAreasAtuacao', $this->modelo->consultar('areaatuacao', '*', array('indDesvinculada' => 0)));
            $this->visualizador->atribuirValor('arrConsultorios', $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0)));
            
            $this->visualizador->atribuirValor('cdnDentista', null);

            $modMain = new ModeloMain(true);

            $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
            $arrUsuarios = array();
            foreach($arrDentistas as $arrDentista){
                $arrUsuarios[] = $modMain->getUsuario($arrDentista['cdnUsuario']);
            }

            $arrDentistas = $arrUsuarios;
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);
            
            if($cdnConsulta != 0){
                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $dtoConsulta->getCdnPaciente()))[0];
                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
            }

            $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);

            $this->visualizador->mostrarNaTela('cadastrar', 'Marcar Consulta');
            return;
        }

        /**
         * Metodo responsável por finalizar a marcação da consulta
         *
         * @param Integer $cdnConsulta - código numérico da consulta original.
         *                               Utilizado para retornos.
         * @return Void.
         *
        **/
        public function consultaCadastrarFim($cdnConsulta = 0){
            $modConsulta = new ModeloConsulta();
            $arrValidacao = $modConsulta->consultaPreparaDTO();
            $dtoConsulta = $arrValidacao[0];
            $mesErro = $arrValidacao[1];
            if($mesErro != ''){
                $this->visualizador->setFlash($mesErro, 'erro');
                $this->consultaCadastrar($cdnConsulta);
                return;
            }

            if(isset($_POST['indEnviarSms'])){
                if(!isset($_POST['numSegAntecedencia'])){
                    $this->visualizador->setFlash('Informe a antecedencia do SMS.', 'error');
                    return $this->consultaCadastrar($cdnConsulta);
                }
                $numSegAntecedencia = $_POST['numSegAntecedencia'];
                switch ($numSegAntecedencia) {
                    case '1hora':
                        $numSegAntecedencia = 60 * 60;
                        break;

                    case '2horas':
                        $numSegAntecedencia = 60 * 60 * 2;
                        break;

                    case '3horas':
                        $numSegAntecedencia = 60 * 60 * 3;
                        break;

                    case '1dia':
                        $numSegAntecedencia = 60 * 60 * 24;
                        break;

                    case '2dias':
                        $numSegAntecedencia = 60 * 60 * 24 * 2;
                        break;

                    case '1semana':
                        $numSegAntecedencia = 60 * 60 * 24 * 7;
                        break;

                    default:
                        $numSegAntecedencia = null;
                        break;
                }
                $dtoConsulta->setNumSegAntecedencia($numSegAntecedencia);
            }

            //$arrProcedimento = $arrValidacao[2];

            if($modConsulta->consultaCadastrarFim($dtoConsulta)){

                $cdnConsultaUltima = $modConsulta->ultimoInserido('consulta');
                $dtoConsulta->setCdnConsulta($cdnConsultaUltima);
                $modConsulta->consultaCadastrarSms($dtoConsulta);
                
                // ignorar
                if(false){
                    if(is_array($arrProcedimento)){
                        $cdnOrcamento = $arrProcedimento['cdnOrcamento'];
                        $cdnAreaAtuacao = $arrProcedimento['cdnAreaAtuacao'];
                        $cdnProcedimento = $arrProcedimento['cdnProcedimento'];
                        $cdnDentista = $arrProcedimento['cdnDentista'];
                        $arrCond = array(
                            'cdnOrcamento' => $cdnOrcamento,
                            'conscond1' => 'AND',
                            'cdnAreaAtuacao' => $cdnAreaAtuacao,
                            'conscond2' => 'AND',
                            'cdnProcedimento' => $cdnProcedimento,
                            'conscond3' => 'AND',
                            'cdnDentista' => $cdnDentista,
                        );
                        if(!$this->modelo->atualizar('orcamento_procedimento', $arrProcedimento, $arrCond)){
                            $this->modelo->deletar('consulta', array('cdnConsulta' => $cdnConsultaUltima));
                            // Geração de log
                            $this->log(array('erro', 'cadastro', 'consulta', 'paciente - '.$_POST['cdnPaciente']));

                            $this->visualizador->setFlash('Não foi possível ligar a consulta ao orçamento.', 'erro');
                            $this->consultaCadastrar($cdnConsulta);
                            return;
                        }
                    }
                }

                // Se é um retorno, guarda na tabela retorno.
                if($cdnConsulta != 0){
                    if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                        $dtoRetorno = new DTORetorno();
                        $dtoRetorno->setCdnConsultaOriginal($cdnConsulta);
                        $dtoRetorno->setCdnConsultaRetorno($cdnConsultaUltima);
                        $arrDados = $dtoRetorno->getArrayBanco();
                        if(!$this->modelo->inserir('retorno', $arrDados)){
                            $this->modelo->deletar('consulta', array('cdnConsulta' => $cdnConsultaUltima));

                            // Geração de log
                            $this->log(array('erro', 'cadastro', 'consulta', 'paciente - '.$_POST['cdnPaciente']));

                            $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                            $this->consultaCadastrar($cdnConsulta);
                            return;

                        }
                    }
                }

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'consulta', $cdnConsultaUltima));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->consultaConsultarFim($cdnConsultaUltima);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'consulta', 'paciente - '.$_POST['cdnPaciente']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->consultaCadastrar($cdnConsulta);
                return;

            }
        }

        /**
         * Método responsável por mostrar a página de consultas desmarcadas
         *
         * @return Void.
         *
        **/
        public function consultaDesmarcadas(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';
            $sql = 'SELECT * FROM consulta WHERE cdnConsulta IN ('.$sqlDesmarques.')';

            $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');
            $this->visualizador->atribuirValor('indProntuarioAntigo', $indProntuarioAntigo);

            $this->visualizador->atribuirValor('modConsulta', new ModeloConsulta());
            $this->visualizador->atribuirValor('modPaciente', new ModeloPaciente());
            $this->visualizador->atribuirValor('arrConsultas', $this->modelo->query($sql));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Consultas Desmarcadas');
            return;
        }

        /**
         * Método responsável por mostrar a página de consultas
         *
         * @return Void.
         *
        **/
        public function consultaConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');

            $this->visualizador->addJs('js/consultaConsultar.js');

            $this->visualizador->mostrarNaTela('consultar', 'Lista de Consultas');
            return;
        }

        /**
         * Método responsável por mostrar a consulta na tela
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void
         *
        **/
        public function consultaConsultarFim($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                // $modProcedimento = new ModeloProcedimento();
                // $dtoProcedimento = $modProcedimento->getProcedimento($dtoConsulta->getCdnProcedimento());
                // $this->visualizador->atribuirValor('nomProcedimento', $dtoProcedimento->getNomProcedimento());

                $modAreaAtuacao = new ModeloAreaAtuacao();
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($dtoConsulta->getCdnAreaAtuacao());
                $this->visualizador->atribuirValor('nomAreaAtuacao', $dtoAreaAtuacao->getNomAreaAtuacao());

                // $modSecao = new ModeloSecao();
                // if($dtoConsulta->getCdnSecao() != ''){
                //     $dtoSecao = $modSecao->getSecao($dtoConsulta->getCdnSecao());
                //     $this->visualizador->atribuirValor('nomSecao', $dtoSecao->getNomSecao());
                // }else{
                //     $this->visualizador->atribuirValor('nomSecao', '');
                // }

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                $this->visualizador->atribuirValor('nomPaciente', $arrPaciente['nomPaciente']);

                $modConsultorio = new ModeloConsultorio();
                $dtoConsultorio = $modConsultorio->getConsultorio($dtoConsulta->getCdnConsultorio());
                $this->visualizador->atribuirValor('numConsultorio', $dtoConsultorio->getNumConsultorio());

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($dtoConsulta->getCdnDentista());
                $this->visualizador->atribuirValor('nomDentista', $arrUsuario['nomUsuario']);


                if($this->modelo->checaExiste('falta', 'cdnConsulta', $cdnConsulta))
                    $this->visualizador->atribuirValor('falta', true);

                if($this->modelo->checaExiste('desmarque', 'cdnConsulta', $cdnConsulta))
                    $this->visualizador->atribuirValor('desmarque', true);

                if($this->modelo->checaExiste('retorno', 'cdnConsultaOriginal', $cdnConsulta)){
                    $arrRetornos = $this->modelo->consultar('retorno', '*', array('cdnConsultaOriginal' => $cdnConsulta));
                    $this->visualizador->atribuirValor('arrRetornos', $arrRetornos);
                }

                if($this->modelo->checaExiste('retorno', 'cdnConsultaRetorno', $cdnConsulta)){
                    $arrRetorno = $this->modelo->consultar('retorno', '*', array('cdnConsultaRetorno' => $cdnConsulta))[0];
                    $this->visualizador->atribuirValor('arrRetorno', $arrRetorno);
                }

                if($this->modelo->checaExiste('sms_aviso_consulta', 'cdnConsulta', $cdnConsulta)){
                    $dtoAviso = $this->modelo->getRegistro('sms_aviso_consulta', 'cdnConsulta', $cdnConsulta);
                    $this->visualizador->atribuirValor('dtoAviso', $dtoAviso);
                }

                $this->visualizador->atribuirValor('modConsulta', $modConsulta);

                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);

                $this->visualizador->mostrarNaTela('consultarFim', 'Consulta');

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por consultar as consultas de um determinado dia com um dentista
         *
         * @return Void.
         *
        **/
        public function consultaVerificaData(){
            if(isset($_GET['cdnDentista'])){
                $cdnDentista = $_GET['cdnDentista'];
                $datConsulta = $_GET['datConsulta'];
                if(trim($datConsulta) == ''){
                    echo 'Informe o dia.';
                }else{
                    $datConsulta = explode('/', $datConsulta);
                    $datConsulta = $datConsulta[2].'-'.$datConsulta[1].'-'.$datConsulta[0];
                    if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                        $modConsulta = new ModeloConsulta();
                        $modConsulta->consultaVerificaData($cdnDentista, $datConsulta);
                    }else{
                        echo 'Dentista inválido.';
                    }
                }
            }
            return;
        }

        /**
         * Método responsável por mostrar a página do atestado da consulta
         *
         * @param Integer $cdnConsulta - código numérico da consulta (opcional)
         * @return Void.
        **/
        public function consultaAtestado($cdnConsulta = 0){
            $dtoConsulta = new DTOConsulta();
            $ctrlPaciente = new ControlePaciente();
            $ctrlDentista = new ControleDentista();
            $selectPaciente = $ctrlPaciente->pacienteRetornaSelect(0, 'Paciente', false, false);
            $selectDentista = $ctrlDentista->dentistaRetornaSelect(0, 'Dentista', false, false);
            $rg = '';
            $endereco = '';
            $horario = '';
            $data = '';
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente());
                $selectPaciente = $ctrlPaciente->pacienteRetornaSelect($dtoConsulta->getCdnPaciente(), 'Paciente', false, false);

                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($dtoConsulta->getCdnDentista());
                $selectDentista = $ctrlDentista->dentistaRetornaSelect($dtoConsulta->getCdnDentista(), 'Dentista', false, false);

                if(isset($arrPaciente['codRg']))
                    $rg = $arrPaciente['codRg'];

                if(isset($arrPaciente['nomBairro']))
                    $endereco .= $arrPaciente['nomBairro'].' - ';

                if(isset($arrPaciente['nomRua']))
                    $endereco .= $arrPaciente['nomRua'].' ';

                if(isset($arrPaciente['numCasa']))
                    $endereco .= ', '.$arrPaciente['numCasa'];

                $horaConsulta = $dtoConsulta->getHoraConsulta();
                $horaConsulta = substr($horaConsulta, 0, 5);

                $horaFinalizada = $dtoConsulta->getHoraFinalizada();
                if(!is_null($horaFinalizada))
                    $horaFinalizada = substr($horaFinalizada, 0, 5);
                else
                    $horaFinalizada = '';

                $horario = $horaConsulta.' - '.$horaFinalizada;

                $data = $dtoConsulta->getDatConsulta();

            }

            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            $this->visualizador->atribuirValor('local', $dtoClinica->getNomCidade());


            $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);

            $this->visualizador->atribuirValor('rg', $rg);
            $this->visualizador->atribuirValor('endereco', $endereco);
            $this->visualizador->atribuirValor('horario', $horario);
            $this->visualizador->atribuirValor('data', $data);

            $this->visualizador->addJs('js/consultaAtestado.js');
            $this->visualizador->atribuirValor('selectPaciente', $selectPaciente);
            $this->visualizador->atribuirValor('selectDentista', $selectDentista);
            $this->visualizador->mostrarNaTela('atestado', 'Atestado/comunicação');
            return;

         }

        /**
         * Método responsável por mostrar a página do atestado da consulta
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
        **/
        public function consultaAtestadoFim(){
            $modConsulta = new ModeloConsulta();
            // Geração de log
            $this->log(array('sucesso', 'atestado', 'consulta'));
            $modConsulta->consultaAtestadoFim();
         }

         /**
          * Método responsável por mostrar a página de remarcar consulta
          *
          * @param Integer $cdnConsulta - código numérico da consulta
          * @return Void.
          *
        **/
         public function consultaRemarcar($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $this->visualizador->addJs('https://code.jquery.com/ui/1.11.1/jquery-ui.min.js');
                $this->visualizador->addJs('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/fullcalendar.min.js');
                $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.css');
                $this->visualizador->addCss('tema/css/plugins/fullcalendar/fullcalendar.print.css" media="print" type="text/css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/pt-br.js"');

                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');

                $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
                $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');


                $this->visualizador->addJs('js/pacienteSelect.js');
                $this->visualizador->addJs('js/consultaRemarcar.js');
                $this->visualizador->addJs('js/consultaAgenda.js');

                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                $arrPacientes = $this->modelo->consultar('paciente', '*', array('indDesvinculado' => 0), 'nomPaciente');
                $this->visualizador->atribuirValor('arrPacientes', $arrPacientes);

                $ctrlAreaAtuacao = new ControleAreaAtuacao();
                $selectAreaAtuacao = $ctrlAreaAtuacao->areaAtuacaoRetornaSelect($dtoConsulta->getCdnAreaAtuacao(),
                                                                                'Área de Atuação', false, false, 'iptCdnAreaAtuacao select2');
                $this->visualizador->atribuirValor('selectAreaAtuacao', $selectAreaAtuacao);


                $modMain = new ModeloMain(true);

                $arrDentistas = $this->modelo->consultar('dentista', '*', array('indDesativado' => 0));
                $arrUsuarios = array();
                foreach($arrDentistas as $arrDentista){
                    $arrUsuarios[] = $modMain->getUsuario($arrDentista['cdnUsuario']);
                }

                $arrDentistas = $arrUsuarios;
                $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

                $this->visualizador->atribuirValor('arrConsultorios', $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0)));

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);

                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);
                $this->visualizador->mostrarNaTela('remarcar', 'Remarcar Consulta');
                return;
            }
            $this->erroExistente();
            return;
         }

         /**
          * Método responsável por finalizar a ação de remarcar a consulta
          *
          * @param Integer $cdnConsulta - código numérico da consulta
          * @return Void.
          *
        **/
        public function consultaRemarcarFim($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $modConsulta = new ModeloConsulta();
                $arrValidacao = $modConsulta->consultaPreparaDTO($cdnConsulta);
                $dtoConsulta = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->consultaRemarcar($cdnConsulta);
                    return;
                }

                if($modConsulta->consultaRemarcarFim($dtoConsulta)){

                    
                    $modConsulta->consultaAtualizarSms($dtoConsulta);

                    // Geração de log
                    $this->log(array('sucesso', 'remarcar', 'consulta', $cdnConsulta));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->consultaConsultarFim($cdnConsulta);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'remarcar', 'consulta', $cdnConsulta));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->consultaRemarcar($cdnConsulta);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por verificar se existe alguma consulta em uma data para um dentista
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @param String $horaConsulta - horário da consulta
         * @param String $datConsulta - data da consulta
         * @return Boolean - true se o horário está disponivel, false se está ocupado
         *
        **/
        public function consultaVerificaExistente($cdnDentista = null, $horaConsulta = null, $datConsulta = null, $cdnConsulta = null){
            $cdnDentista = $_GET['cdnDentista'];
            $horaConsulta = $_GET['horaConsulta'].':00';
            $datConsulta = $_GET['datConsulta'];
            $datConsulta = explode('/', $_GET['datConsulta']);
            $datConsulta = $datConsulta[2].'-'.$datConsulta[1].'-'.$datConsulta[0];

            if(isset($_GET['cdnConsulta']))
                $cdnConsulta = $_GET['cdnConsulta'];
            else
                $cdnConsulta = 0;
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';
                $where = 'horaConsulta <= "'.$horaConsulta.'" AND
                          horaFinalizada > "'.$horaConsulta.'" AND
                          datConsulta = "'.$datConsulta.'" AND cdnDentista = '.$cdnDentista.' AND
                          consulta.cdnConsulta NOT IN ('.$sqlDesmarques.') AND
                          consulta.cdnConsulta != '.$cdnConsulta;

                $sql = 'SELECT * FROM consulta WHERE '.$where;

                $arrConsultas = $this->modelo->query($sql);
                if(count($arrConsultas) > 0){
                    foreach($arrConsultas as $arrConsulta){
                        if($arrConsulta['indBloquear']){
                            echo 'bloqueado';
                            return false;
                        }
                    }
                    echo 'ndisponivel';
                    return false;
                }
            }
            return true;
        }
        
        public function consultaJsonGraficoInicio() {
            $modelo = new Modelo();
            $labels = array();
            $data = array();
            $finalData = array('consultas' => array(), 'desmarques' => array(), 'faltas' => array(), 'desmarques' => array());
            $sqlDesmarque = 'SELECT * FROM desmarque';
            $sqlFalta = 'SELECT * FROM falta';
            $sql = 'SELECT COUNT(cdnConsulta) as consultas, datConsulta as data
                    FROM consulta
                    WHERE datConsulta >= "' . date('Y-m-01') . '" AND datConsulta <= "' . date('Y-m-t') . '"
                          AND cdnConsulta NOT IN ("' . $sqlDesmarque . '") 
                          AND cdnConsulta NOT IN ("' . $sqlFalta . '")
                    GROUP BY datConsulta
                    ORDER BY datConsulta';
            $consultas = $modelo->query($sql);
            
            $sql = 'SELECT COUNT(cdnConsulta) as remarques, datRemarque as data
                    FROM consulta
                    WHERE datRemarque >= "' . date('Y-m-01') . '" AND datRemarque <= "' . date('Y-m-t') . '"
                          AND cdnConsulta NOT IN ("' . $sqlDesmarque . '") 
                          AND cdnConsulta NOT IN ("' . $sqlFalta . '") 
                          AND datRemarque IS NOT NULL
                    GROUP BY datConsulta
                    ORDER BY datConsulta';
            $remarques = $modelo->query($sql);
            
            $sql = 'SELECT COUNT(d.cdnConsulta) as desmarques, c.datConsulta as data
                    FROM desmarque d
                    JOIN consulta c ON d.cdnConsulta = c.cdnConsulta
                    WHERE c.datConsulta >= "' . date('Y-m-01') . '" AND c.datConsulta <= "' . date('Y-m-t') . '"
                    GROUP BY c.datConsulta
                    ORDER BY c.datConsulta';
            $desmarques = $modelo->query($sql);

            $sql = 'SELECT COUNT(f.cdnConsulta) as faltas, c.datConsulta as data
                FROM falta f
                JOIN consulta c ON f.cdnConsulta = c.cdnConsulta
                WHERE c.datConsulta >= "' . date('Y-m-01') . '" AND c.datConsulta <= "' . date('Y-m-t') . '"
                GROUP BY c.datConsulta
                ORDER BY c.datConsulta';
            $faltas = $modelo->query($sql);
            
            for($i = 1; $i <= date("t"); $i++){
                if($i <= 9){
                    $dt = date("Y-m-0") . $i;
                } else{
                    $dt = date("Y-m-") . $i;
                }
                
                $labels[] = $dt;
                $data[$dt]['consultas'] = 0;
                $data[$dt]['desmarques'] = 0;
                $data[$dt]['faltas'] = 0;
                $data[$dt]['remarques'] = 0;
            }
            
            foreach ($consultas as $consulta) {
                if (!in_array($consulta['data'], $labels))
                    $labels[] = $consulta['data'];

                if (!isset($data[$consulta['data']]))
                    $data[$consulta['data']] = array();

                $data[$consulta['data']]['consultas'] = $consulta['consultas'];
                $data[$consulta['data']]['desmarques'] = 0;
                $data[$consulta['data']]['faltas'] = 0;
                $data[$consulta['data']]['remarques'] = 0;
            }
            
            foreach ($remarques as $remarque) {
                if (!in_array($remarque['data'], $labels))
                    $labels[] = $remarque['data'];

                if (!isset($data[$remarque['data']])) {
                    $data[$remarque['data']] = array();
                    $data[$remarque['data']]['consultas'] = 0;
                    $data[$remarque['data']]['faltas'] = 0;
                    $data[$remarque['data']]['desmarques'] = 0;
                }

                $data[$remarque['data']]['remarques'] = $remarque['remarques'];
            }

            foreach ($desmarques as $desmarque) {
                if (!in_array($desmarque['data'], $labels))
                    $labels[] = $desmarque['data'];

                if (!isset($data[$desmarque['data']])) {
                    $data[$desmarque['data']] = array();
                    $data[$desmarque['data']]['consultas'] = 0;
                    $data[$desmarque['data']]['faltas'] = 0;
                    $data[$desmarque['data']]['remarques'] = 0;
                }

                $data[$desmarque['data']]['desmarques'] = $desmarque['desmarques'];
            }

            foreach ($faltas as $falta) {
                if (!in_array($falta['data'], $labels))
                    $labels[] = $falta['data'];

                if (!isset($data[$falta['data']])) {
                    $data[$falta['data']] = array();
                    $data[$falta['data']]['consultas'] = 0;
                    $data[$falta['data']]['desmarques'] = 0;
                    $data[$falta['data']]['remarques'] = 0;
                }

                $data[$falta['data']]['faltas'] = $falta['faltas'];
            }

            foreach ($data as $dia => $dados) {
                $finalData['consultas'][] = $dados['consultas'];
                $finalData['desmarques'][] = $dados['desmarques'];
                $finalData['faltas'][] = $dados['faltas'];
                $finalData['remarques'][] = $dados['remarques'];
            }

            foreach ($labels as $num => $data) {
                $data = date('d/m/Y', strtotime($data));
                $labels[$num] = $data;
            }

            $finalData['labels'] = $labels;
            
            echo json_encode($finalData);
        }

        public function consultaCadastrarAviso($cdnConsulta){

            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                if(strtotime($dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta()) < strtotime(date('Y-m-d H:i:s'))){
                    $this->visualizador->setFlash('Esta consulta já foi realizada.', 'erro');
                    return $this->consultaConsultarFim($cdnConsulta);
                }

                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);
                $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $dtoConsulta->getCdnPaciente()))[0];

                $this->visualizador->atribuirValor('cdnPaciente', $arrPaciente['cdnPaciente']);
                $ret = ControlePaciente::pacienteVerificaTelefone($arrPaciente['cdnPaciente'], false);
                if($ret === true){
                    $this->visualizador->atribuirValor('numTelefone1', $arrPaciente['numTelefone1']);
                }else{
                    if(isset($arrPaciente['numTelefone1']))
                        $this->visualizador->atribuirValor('numTelefone1', $arrPaciente['numTelefone1']);
                    $this->visualizador->setFlash($ret, 'aviso');
                }
                $this->visualizador->atribuirValor('nomPaciente', $arrPaciente['nomPaciente']);

                $opts = array(
                    '1hora' => array('1 hora', 60 * 60),
                    '2horas' => array('2 horas', 60 * 60 * 2),
                    '3horas' => array('3 horas', 60 * 60 * 3),
                    '1dia' => array('1 dia', 60 * 60 * 24),
                    '2dias' => array('2 dias', 60 * 60 * 24 * 2),
                    '1semana' => array('1 semana', 60 * 60 * 24 * 7),
                );

                $segHoraConsulta = strtotime($dtoConsulta->getHoraConsulta());
                foreach($opts as $key=>$value) {
                    $value = strtotime('H:i:s') - $value[1];
                    if ($segHoraConsulta < $value)
                        unset($opts[$key]);
                }
                $optsFim = '';
                foreach($opts as $key=>$value){
                    $optsFim .= '<option value="'.$key.'">'.$value[0].'</option>';
                }
                $this->visualizador->atribuirValor('options', $optsFim);

                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->mostrarNaTela('cadastrarAviso', 'Cadastrar aviso de SMS');
                return;
            }
            return $this->erroExistente();
        }

        public function consultaCadastrarAvisoFim($cdnConsulta){
            $modConsulta = new ModeloConsulta();
            $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
            $numSegAntecedencia = $_POST['numSegAntecedencia'];
            switch ($numSegAntecedencia) {
                case '1hora':
                    $numSegAntecedencia = 60 * 60;
                    break;

                case '2horas':
                    $numSegAntecedencia = 60 * 60 * 2;
                    break;

                case '3horas':
                    $numSegAntecedencia = 60 * 60 * 3;
                    break;

                case '1dia':
                    $numSegAntecedencia = 60 * 60 * 24;
                    break;

                case '2dias':
                    $numSegAntecedencia = 60 * 60 * 24 * 2;
                    break;

                case '1semana':
                    $numSegAntecedencia = 60 * 60 * 24 * 7;
                    break;

                default:
                    $numSegAntecedencia = null;
                    break;
            }
            $dtoConsulta->setNumSegAntecedencia($numSegAntecedencia);
            $modConsulta->atualizar('consulta', $dtoConsulta->getArrayBanco(), array('cdnConsulta' => $cdnConsulta));
            if($modConsulta->consultaCadastrarSms($dtoConsulta, false)){
                // Geração de log
                $this->log(array('sucesso', 'cadastrar aviso', 'consulta', $cdnConsulta));
                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                return $this->consultaConsultarFim($cdnConsulta);
            }else{
                // Geração de log
                $this->log(array('erro', 'cadastrar aviso', 'consulta', $cdnConsulta));
                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                return $this->consultaCadastrarAviso($cdnConsulta);
            }

        }

        public function consultaMudarAviso($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $dtoAviso = $this->modelo->getRegistro('sms_aviso_consulta', 'cdnConsulta', $cdnConsulta);

                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                if(strtotime($dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta()) < strtotime(date('Y-m-d H:i:s'))){
                    $this->visualizador->setFlash('Esta consulta já foi realizada.', 'erro');
                    return $this->consultaConsultarFim($cdnConsulta);
                }

                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);
                $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $dtoConsulta->getCdnPaciente()))[0];
                $this->visualizador->atribuirValor('nomPaciente', $arrPaciente['nomPaciente']);

                $numTelefone1 = substr($dtoAviso->getNumTelefone(), 2);
                $this->visualizador->atribuirValor('numTelefone1', $numTelefone1);

                $opts = array(
                    '1hora' => array('1 hora', 60 * 60),
                    '2horas' => array('2 horas', 60 * 60 * 2),
                    '3horas' => array('3 horas', 60 * 60 * 3),
                    '1dia' => array('1 dia', 60 * 60 * 24),
                    '2dias' => array('2 dias', 60 * 60 * 24 * 2),
                    '1semana' => array('1 semana', 60 * 60 * 24 * 7),
                );

                $segHoraConsulta = strtotime($dtoConsulta->getHoraConsulta());
                foreach($opts as $key=>$value) {
                    $value = strtotime('Y-m-d H:i:s') - $value[1];
                    if ($segHoraConsulta < $value)
                        unset($opts[$key]);
                }
                $optsFim = '';
                foreach($opts as $key=>$value){
                    $segAviso = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta();
                    $segAviso = strtotime($segAviso) - $value[1];
                    if($segAviso == strtotime($dtoAviso->getDatAviso()))
                        $selected = 'selected';
                    else
                        $selected = '';
                    $optsFim .= '<option '.$selected.' value="'.$key.'">'.$value[0].'</option>';
                }
                $this->visualizador->atribuirValor('options', $optsFim);

                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->atribuirValor('dtoAviso', $dtoAviso);

                $this->visualizador->mostrarNaTela('mudarAviso', 'Alterar horário de envio de SMS');
                return;
            }
            return $this->erroExistente();
        }

        public function consultaMudarAvisoFim($cdnConsulta){
            $modConsulta = new ModeloConsulta();
            $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
            $numSegAntecedencia = $_POST['numSegAntecedencia'];
            switch ($numSegAntecedencia) {
                case '1hora':
                    $numSegAntecedencia = 60 * 60;
                    break;

                case '2horas':
                    $numSegAntecedencia = 60 * 60 * 2;
                    break;

                case '3horas':
                    $numSegAntecedencia = 60 * 60 * 3;
                    break;

                case '1dia':
                    $numSegAntecedencia = 60 * 60 * 24;
                    break;

                case '2dias':
                    $numSegAntecedencia = 60 * 60 * 24 * 2;
                    break;

                case '1semana':
                    $numSegAntecedencia = 60 * 60 * 24 * 7;
                    break;

                default:
                    $numSegAntecedencia = null;
                    break;
            }
            $dtoConsulta->setNumSegAntecedencia($numSegAntecedencia);
            $modConsulta->atualizar('consulta', $dtoConsulta->getArrayBanco(), array('cdnConsulta' => $cdnConsulta));
            if($modConsulta->consultaAtualizarSms($dtoConsulta)){
                // Geração de log
                $this->log(array('sucesso', 'mudar aviso', 'consulta', $cdnConsulta));
                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->consultaConsultarFim($cdnConsulta);
                return;
            }else{
                // Geração de log
                $this->log(array('erro', 'mudar aviso', 'consulta', $cdnConsulta));
                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->consultaMudarAviso($cdnConsulta);
                return;
            }
        }

        public function consultaConsultaMapa(){
            $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
            $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');
            $this->visualizador->addJs('js/consultaMapa.js');
            
            $consultorios = $this->modelo->consultar('consultorio', '*'); 
            $consultas = $this->modelo->consultar('consulta', '*', array("datConsulta" => date("Y-m-d")));
            
            $modMain = new ModeloMain(true);
            
            if(!empty($consultas) && !empty($consultorios)){
                foreach($consultas as $consulta){
                    foreach($consultorios as $i => $consultorio){
                        if($consulta["cdnConsultorio"] == $consultorio["cdnConsultorio"]){
                            $usuario = $modMain->getUsuario($consulta["cdnDentista"]);
                            $consulta["nomDentista"] = $usuario["nomUsuario"];
                            $consultorios[$i]["consultas"][] = $consulta;
                        }
                    }
                }
            }
            
            $this->visualizador->atribuirValor('arrConsultorios', $consultorios);
            $this->visualizador->mostrarNaTela('consultaMapa', 'Mapa de Consultório');
            
            return;
        }

        public function consultaConsultaMapaData($data){    
            $arrData = explode("/", $data);
            $data = $arrData[2] . "-" . $arrData[1] . "-" . $arrData[0];
            
            $consultorios = $this->modelo->consultar('consultorio', '*'); 
            $consultas = $this->modelo->consultar('consulta', '*', array("datConsulta" => $data));
            
            $modMain = new ModeloMain(true);
            
            if(!empty($consultas) && !empty($consultorios)){
                foreach($consultas as $consulta){
                    foreach($consultorios as $i => $consultorio){
                        if($consulta["cdnConsultorio"] == $consultorio["cdnConsultorio"]){
                            $usuario = $modMain->getUsuario($consulta["cdnDentista"]);
                            $consulta["nomDentista"] = $usuario["nomUsuario"];
                            $consultorios[$i]["consultas"][] = $consulta;
                        }
                    }
                }
            }
            
            echo json_encode($consultorios);
            
            return;
        }
    }

