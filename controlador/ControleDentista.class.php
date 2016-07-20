<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do dentista
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-10
     *
     * */
    class ControleDentista extends Controlador {

        use Transformacao;

        /**
         * Método responsável por mostrar a página inicial do dentista
         *
         * @return Void
         *
         * */
        public function dentistaInicio() {
            $arrFrase = $this->modelo->consultar('frase', '*', array('indAtiva' => 1));
            if (count($arrFrase) > 0) {
                $arrFrase = $arrFrase[0];
                $arrUsuario = new ModeloMain(true);
                $arrUsuario = $arrUsuario->getUsuario($arrFrase['cdnUsuario']);
                $this->visualizador->atribuirValor('strFrase', $arrFrase['strFrase']);
                $this->visualizador->atribuirValor('nomAutor', $arrUsuario['nomUsuario']);
            } else {
                $this->visualizador->atribuirValor('strFrase', '');
                $this->visualizador->atribuirValor('nomAutor', '');
            }


            // Cálculo de SMS
            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
            $numLimiteSms = $dtoClinica->getNumLimiteSms();
            $numSmsEnviados = $dtoClinica->getNumEnviosSms();
            $numSmsRecebidos = $dtoClinica->getNumRecebimentosSms();
            $numSms = $numSmsEnviados + $numSmsRecebidos;
            if(($numLimiteSms - $numSms) < 30){
                $this->visualizador->atribuirValor('avisoSms', true);
            }


            $this->visualizador->addJs('tema/js/plugins/chartJs/Chart.min.js');
            $this->visualizador->addJs('js/graficoInicio.js');
            $this->visualizador->addJs('js/dentistaInicio.js');

            $this->visualizador->mostrarNaTela('inicio', 'Início');
            return;
        }

        /**
         * Método responsável por mostrar a página de cadastro de dentista
         *
         * @return Void.
         *
         * */
        public function dentistaCadastrar() {
            if ($this->modelo->master() or $this->modelo->dono()) {
                $this->visualizador->addJs('js/dentistaCadastrar.js');

                $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0));
                $this->visualizador->atribuirValor('arrConsultorios', $arrConsultorios);

                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Dentista');
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do dentista.
         *
         * @return Void.
         *
         * */
        public function dentistaCadastrarFim() {
            if ($this->modelo->master() or $this->modelo->dono()) {
                $modDentista = new ModeloDentista();
                $arrValidacao = $modDentista->dentistaPreparaDTO();
                $dtoDentista = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if ($mesErro != '') {
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->dentistaCadastrar();
                    return;
                }

                if ($modDentista->dentistaCadastrarFim($dtoDentista)) {

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'dentista', $_POST['strEmail']));

                    $cdnDentista = $modDentista->ultimoInserido('dentista');

                    $dtoDias = $modDentista->dentistaDiasPreparaDTO($cdnDentista);
                    $this->modelo->deletar('dentista_dias', array('cdnDentista' => $cdnDentista));
                    if (!$modDentista->dentistaDiasCadastrarFim($dtoDias))
                        $this->visualizador->setFlash('Ocorreu um problema ao atualizar os dias trabalhados.', 'erro');

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->dentistaConsultarFim($cdnDentista);
                    return;
                }else {

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'dentista', $_POST['strEmail']));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');

                    $this->dentistaCadastrar();
                    return;
                }
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um dentista.
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         */
        public function dentistaAtualizar($cdnUsuario) {
            $modDentista = new ModeloDentista();
            if ($modDentista->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                $modMain = new ModeloMain(true);

                if ($modDentista->checaExiste('dentista_dias', 'cdnDentista', $cdnUsuario)) {
                    $dtoDias = $modDentista->getDentistaDias($cdnUsuario);
                } else {
                    $dtoDias = new Dentista_dias();
                }
                $this->visualizador->atribuirValor('dtoDias', $dtoDias);

                $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0));
                $this->visualizador->atribuirValor('arrConsultorios', $arrConsultorios);

                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);
                $this->visualizador->atribuirValor('dtoDentista', $modDentista->getDentista($cdnUsuario));
                $this->visualizador->addJs('js/dentistaAtualizar.js');
                $this->visualizador->mostrarNaTela('atualizar', 'Atualizar meus dados');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * dentista
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function dentistaAtualizarFim($cdnUsuario) {
            if ($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->master() or $this->modelo->dono()) {
                $modDentista = new ModeloDentista();
                if ($modDentista->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                    $arrValidacao = $modDentista->dentistaPreparaDTO($cdnUsuario);
                    $dtoDentista = $arrValidacao[0];
                    $dtoDentista->setCdnUsuario($cdnUsuario);

                    $mesErro = $arrValidacao[1];

                    if ($mesErro != '') {
                        $this->visualizador->setFlash($mesErro, 'erro');
                        $this->dentistaAtualizar($cdnUsuario);
                        return;
                    }


                    if ($modDentista->dentistaAtualizarFim($dtoDentista)) {


                        $dtoDias = $modDentista->dentistaDiasPreparaDTO($cdnUsuario);
                        $this->modelo->deletar('dentista_dias', array('cdnDentista' => $cdnUsuario));
                        if (!$modDentista->dentistaDiasCadastrarFim($dtoDias))
                            $this->visualizador->setFlash('Ocorreu um problema ao atualizar os dias trabalhados.', 'erro');

                        // Geração de log
                        $this->log(array('sucesso', 'atualizacao', 'dentista', $cdnUsuario));

                        $this->visualizador->setFlash(SUCESSO_CADASTRO);
                        $this->dentistaConsultarFim($cdnUsuario);
                        return;
                    }else {

                        // Geração de log
                        $this->log(array('erro', 'atualizacao', 'dentista', $cdnUsuario));

                        $this->visualizador->setFlash(ERRO_CADASTRO);
                        $this->dentistaAtualizar($cdnUsuario);
                        return;
                    }
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por mostrar a lista de dentistaes do sistema
         *
         * @return Void
         *
         * */
        public function dentistaConsultar() {
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $this->visualizador->atribuirValor('modDentista', new ModeloDentista());
            $this->visualizador->atribuirValor('modMain', new ModeloMain(true));
            $this->visualizador->atribuirValor('arrDentistas', $this->modelo->consultar('dentista', '*', array('indDesativado' => 0)));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Dentistas');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * dentista.
         *
         * @param Integer $cdnUsuario - código numérico do dentista
         * @return Void.
         *
         */
        public function dentistaConsultarFim($cdnUsuario) {
            if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($cdnUsuario);
                $this->visualizador->atribuirValor('dtoDentista', $dtoDentista);
                $this->visualizador->atribuirValor('modDentista', $modDentista);

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario));
                $nomUsuario = $arrUsuario[0]['nomUsuario'];
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario[0]);

                if ($modDentista->checaExiste('dentista_dias', 'cdnDentista', $cdnUsuario)) {
                    $dtoDias = $modDentista->getDentistaDias($cdnUsuario);
                } else {
                    $dtoDias = new Dentista_dias();
                }
                $this->visualizador->atribuirValor('dtoDias', $dtoDias);

                $arrConsultorios = $this->modelo->consultar('consultorio', '*', array('indDesvinculado' => 0));
                $this->visualizador->atribuirValor('arrConsultorios', $arrConsultorios);

                $this->visualizador->atribuirValor('arrRelacoes', $modDentista->consultar('dentista_areaatuacao', '*', array('cdnDentista' => $cdnUsuario)));

                $this->visualizador->mostrarNaTela('consultarFim', $nomUsuario);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de dentista
         *
         * @param Integer $cdnUsuario - código numérico do dentista
         * @return Void.
         *
         * */
        public function dentistaDeletar($cdnUsuario) {
            if ($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono() or $this->modelo->master()) {
                $modMain = new ModeloMain(true);
                if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                    $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);

                    $this->visualizador->mostrarNaTela('deletar', 'Deletar ' . $arrUsuario['nomUsuario']);

                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do dentista
         *
         * @param Integer $cdnUsuario - código numérico do dentista
         * @return Void.
         *
         * */
        public function dentistaDeletarFim($cdnUsuario) {
            if ($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono() or $this->modelo->master()) {
                $modMain = new ModeloMain(true);
                if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                    // $this->modelo->deletar('dentista', array('cdnUsuario' => $cdnUsuario));
                    // $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuario));
                    // $this->modelo->deletar('dentista_areaatuacao', array('cdnDentista' => $cdnUsuario));
                    // $this->modelo->deletar('dentista_dias', array('cdnDentista' => $cdnUsuario));
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                    //$arrUsuario['strEmail'] = '';
                    $arrUsuario['cdnClinica'] = '';
                    $dtoDentista = $this->modelo->getRegistro('dentista', 'cdnUsuario', $cdnUsuario);
                    $dtoDentista->setIndDesativado(1);
                    $dtoDentista->setCodCro(null);
                    $modMain->atualizar('usuario', $arrUsuario, array('cdnUsuario' => $cdnUsuario));
                    $this->modelo->atualizar('dentista', $dtoDentista->getArrayBanco(), array('cdnUsuario' => $cdnUsuario));

                    if ($_SESSION['cdnUsuario'] == $cdnUsuario) {
                        $ctrlMain = new ControleMain();
                        $ctrlMain->mainSairFim();
                        return;
                    }
                    $this->visualizador->setFlash('Dentista deletado.', 'sucesso');
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'dentista', $cdnUsuario));
                    $this->dentistaConsultar();
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por adicionar uma área de atuação na div de vínculo
         *
         * @param Integer $qtdAreas - quantidade de áreas que estão na div + 1
         *
         * */
        public function dentistaAdicionarArea($qtdAreas) {
            $modAreaAtuacao = new ModeloAreaAtuacao();
            $arrAreasAtuacao = $modAreaAtuacao->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'nomAreaAtuacao');

            $div = '<div class="area" id="area' . $qtdAreas . '">';

            $div .= '<div class="col-md-11 form-group">';
            $div .= '<label id="lblCdnAreaAtuacao' . $qtdAreas . '" for="cdnAreaAtuacao' . $qtdAreas . '" class="control-label">Área de atuação ' . $qtdAreas . '</label>';
            $div .= '<select id="iptCdnAreaAtuacao' . $qtdAreas . '" name="cdnAreaAtuacao' . $qtdAreas . '" class="form-control">';
            foreach ($arrAreasAtuacao as $arrAreaAtuacao) {
                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrAreaAtuacao['cdnAreaAtuacao']);
                $div .= '<option value="' . $dtoAreaAtuacao->getCdnAreaAtuacao() . '">' . $dtoAreaAtuacao->getNomAreaAtuacao() . '</option>';
            }
            $div .= '</select>';
            $div .= '</div>';

            $div .= '<div class="col-xs-1 col-md-1 form-group"><br>';
            $div .= '<button type="button" class="btn btn-default btn-lg btnRemover" id="' . $qtdAreas . '">';
            $div .= '<span class="fa fa-remove"></span>';
            $div .= '</button>';
            $div .= '</div>';

            $div .= '</div>';
            echo $div;
        }

        /**
         * Método responsável por mostrar a página de fechar agenda do dentista
         *
         * @return Void.
         *
         * */
        public function dentistaFecharAgenda($cdnDentista) {
            if ($cdnDentista != $_SESSION['cdnUsuario']) {
                if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                    return $this->erroPermissao();
                }
            }
            if (Modelo::dentista($cdnDentista)) {
                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');
                $this->visualizador->addJs('js/dentistaFecharAgenda.js');

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($cdnDentista);
                $this->visualizador->atribuirValor('cdnDentista', $cdnDentista);

                $sql = 'SELECT * FROM dentista_fechado WHERE cdnDentista = ' . $cdnDentista . ' AND
                        datFechado >= ' . date('Y-m-d') . ' ORDER BY datFechado';

                $arrFechados = $this->modelo->query($sql);
                $this->visualizador->atribuirValor('arrFechados', $arrFechados);
                $this->visualizador->atribuirValor('modDentista', new ModeloDentista());
                $this->visualizador->mostrarNaTela('fecharAgenda', 'Fechar agenda de ' . $arrUsuario['nomUsuario']);
                return;
            }
            return $this->erroPermissao();
        }

        /**
         * Método responsável pela finalização da ação de fechar a agenda
         *
         * @return Void.
         *
         * */
        public function dentistaFecharAgendaFim($cdnDentista) {
            if ($cdnDentista != $_SESSION['cdnUsuario']) {
                if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                    return $this->erroPermissao();
                }
            }
            if (Modelo::dentista($cdnDentista)) {
                $modDentista = new ModeloDentista();
                if ($modDentista->dentistaFecharAgendaFim($cdnDentista)) {
                    $this->visualizador->setFlash('Agenda fechada com sucesso.', 'sucesso');
                    if ($_SESSION['cdnUsuario'] == $cdnDentista) {
                        $ctrlAgenda = new ControleAgenda();
                        $ctrlAgenda->agendaCalendario();
                    } else {
                        $this->dentistaConsultarFim($cdnDentista);
                    }
                    $this->log(array('sucesso', 'cadastro', 'dentista_fechado', $cdnDentista));
                    return;
                } else {
                    $this->visualizador->setFlash('Um problema ocorreu ao fechar a agenda.', 'erro');
                    $this->dentistaFecharAgenda($cdnDentista);
                    $this->log(array('erro', 'cadastro', 'dentista_fechado', $cdnDentista));
                    return;
                }
            }
            return $this->erroPermissao();
        }

        public function dentistaDeletarFechado($cdnFechado) {
            if ($this->modelo->checaExiste('dentista_fechado', 'cdnFechado', $cdnFechado)) {
                $modDentista = new ModeloDentista();
                $dtoFechado = $modDentista->getDentistaFechado($cdnFechado);
                $cdnDentista = $dtoFechado->getCdnDentista();

                if ($cdnDentista != $_SESSION['cdnUsuario']) {
                    if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                        return $this->erroPermissao();
                    }
                }
                if (Modelo::dentista($cdnDentista)) {
                    $modMain = new ModeloMain(true);
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnDentista))[0];
                    $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);
                    $this->visualizador->atribuirValor('dtoFechado', $dtoFechado);
                    $this->visualizador->mostrarNaTela('deletarFechado', 'Desfazer fechamento de agenda');

                    return;
                }
                return $this->erroPermissao();
            }
            return $this->erroExistente();
        }

        public function dentistaDeletarFechadoFim($cdnFechado) {
            if ($this->modelo->checaExiste('dentista_fechado', 'cdnFechado', $cdnFechado)) {
                $modDentista = new ModeloDentista();
                $dtoFechado = $modDentista->getDentistaFechado($cdnFechado);
                $cdnDentista = $dtoFechado->getCdnDentista();

                if ($cdnDentista != $_SESSION['cdnUsuario']) {
                    if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                        return $this->erroPermissao();
                    }
                }
                if ($this->modelo->deletar('dentista_fechado', array('cdnFechado' => $cdnFechado))) {
                    // Geração de log

                    $this->visualizador->setFlash('Fechamento desfeito com sucesso.', 'sucesso');
                    $this->log(array('sucesso', 'deletar', 'dentista_fechado', $cdnDentista));
                } else {
                    $this->visualizador->setFlash('Um problema ocorreu. Por favor, tente novamente.', 'erro');
                    $this->log(array('erro', 'deletar', 'dentista_fechado', $cdnDentista));
                }
                return $this->dentistaFecharAgenda($cdnDentista);
            }
            return $this->erroExistente();
        }

        public function dentistaAbrirAgenda($cdnDentista) {
            if ($cdnDentista != $_SESSION['cdnUsuario']) {
                if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                    return $this->erroPermissao();
                }
            }
            if (Modelo::dentista($cdnDentista)) {
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');


                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($cdnDentista);
                $this->visualizador->atribuirValor('cdnDentista', $cdnDentista);

                $sql = 'SELECT * FROM dentista_aberto WHERE cdnDentista = ' . $cdnDentista . ' AND
                        datAberto >= ' . date('Y-m-d') . ' ORDER BY datAberto';

                $arrAbertos = $this->modelo->query($sql);
                $this->visualizador->atribuirValor('arrAbertos', $arrAbertos);
                $this->visualizador->atribuirValor('modDentista', new ModeloDentista());
                $this->visualizador->addJs('js/dentistaAbrirAgenda.js');
                $this->visualizador->mostrarNaTela('abrirAgenda', 'Abrir agenda para ' . $arrUsuario['nomUsuario']);
                return;
            }
            return $this->erroPermissao();
        }

        public function dentistaAbrirAgendaFim($cdnDentista) {
            if ($cdnDentista != $_SESSION['cdnUsuario']) {
                if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                    return $this->erroPermissao();
                }
            }
            if (Modelo::dentista($cdnDentista)) {
                $modDentista = new ModeloDentista();
                $retorno = $modDentista->dentistaAbrirAgendaFim($cdnDentista);
                if ($retorno === true) {
                    $this->visualizador->setFlash('Agenda aberta com sucesso.', 'sucesso');
                    $this->log(array('sucesso', 'cadastro', 'dentista_aberto', $cdnDentista));
                } else {
                    $this->visualizador->setFlash($retorno, 'erro');
                    $this->log(array('erro', 'cadastro', 'dentista_aberto', $cdnDentista));
                }
                $this->dentistaAbrirAgenda($cdnDentista);
                return;
            }
            return $this->erroPermissao();
        }

        public function dentistaDeletarAberto($cdnAberto) {
            if ($this->modelo->checaExiste('dentista_aberto', 'cdnAberto', $cdnAberto)) {
                $modDentista = new ModeloDentista();
                $dtoAberto = $modDentista->getDentistaAberto($cdnAberto);
                $cdnDentista = $dtoAberto->getCdnDentista();

                if ($cdnDentista != $_SESSION['cdnUsuario']) {
                    if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                        return $this->erroPermissao();
                    }
                }
                if (Modelo::dentista($cdnDentista)) {
                    $modMain = new ModeloMain(true);
                    $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnDentista))[0];
                    $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);
                    $this->visualizador->atribuirValor('dtoAberto', $dtoAberto);
                    $this->visualizador->mostrarNaTela('deletarAberto', 'Desfazer abertura de agenda');

                    return;
                }
                return $this->erroPermissao();
            }
            return $this->erroExistente();
        }

        public function dentistaDeletarAbertoFim($cdnAberto) {
            if ($this->modelo->checaExiste('dentista_aberto', 'cdnAberto', $cdnAberto)) {
                $modDentista = new ModeloDentista();
                $dtoAberto = $modDentista->getDentistaAberto($cdnAberto);
                $cdnDentista = $dtoAberto->getCdnDentista();

                if ($cdnDentista != $_SESSION['cdnUsuario']) {
                    if (!Modelo::masterStatic($_SESSION['cdnUsuario'])) {
                        return $this->erroPermissao();
                    }
                }
                if ($this->modelo->deletar('dentista_aberto', array('cdnAberto' => $cdnAberto))) {
                    $this->visualizador->setFlash('Abertura desfeita com sucesso.', 'sucesso');
                    $this->log(array('sucesso', 'deletar', 'dentista_aberto', $cdnDentista));
                } else {
                    $this->visualizador->setFlash('Um problema ocorreu. Por favor, tente novamente.', 'erro');
                    $this->log(array('erro', 'deletar', 'dentista_aberto', $cdnDentista));
                }
                return $this->dentistaAbrirAgenda($cdnDentista);
            }
            return $this->erroExistente();
        }

        /**
         * Método responsável por montar o array das datas já fechadas para o calendário
         *
         * */
        public function dentistaDiasFechadosArray() {
            $array = '[';
            $modDentista = new ModeloDentista();
            foreach ($this->modelo->consultar('dentista_fechado', '*', array('cdnDentista' => $_SESSION['cdnUsuario'])) as $arrFechado) {
                $dtoFechado = $modDentista->getDentistaFechado($arrFechado['cdnFechado']);
                $array .= '"' . $dtoFechado->getDatFechado(true) . '",';
            }
            $array = trim($array, ',');
            $array .= ']';
            echo $array;
        }

        /**
         * Método responsável por montar o array dos dias da semana que o dentista trabalha
         *
         * */
        public function dentistaDiasSemanaArray($cdnDentista) {
            if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)) {
                $array = '[';
                $modDentista = new ModeloDentista();
                $dtoDias = $modDentista->getDentistaDias($cdnDentista);

                if (!$dtoDias->getIndDomingo())
                    $array .= '0,';
                if (!$dtoDias->getIndSegunda())
                    $array .= '1,';
                if (!$dtoDias->getIndTerca())
                    $array .= '2,';
                if (!$dtoDias->getIndQuarta())
                    $array .= '3,';
                if (!$dtoDias->getIndQuinta())
                    $array .= '4,';
                if (!$dtoDias->getIndSexta())
                    $array .= '5,';
                if (!$dtoDias->getIndSabado())
                    $array .= '6,';

                $array = trim($array, ',');
                $array .= ']';
                echo $array;
            }
        }

        /**
         * Método responsável por retornar o select de dentistas
         *
         * @param Integer $cdnDentista - código numérico do dentista para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Dentista.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param Array $arrDentistas - array de dentistas a serem mostrados
         * @param String $classe - classe do input. Padrão: iptCdnDentista.
         * @param String $nome - nome do input. Padrão: cdnDentista.
         * @return String - select de dentistas
         *
         * */
        public function dentistaRetornaSelect($cdnDentista = 0, $label = 'Dentista', $darEcho = true, $arrDentistas = false, $classe = 'iptCdnDentista', $nome = 'cdnDentista') {
            $modDentista = new ModeloDentista();
            $select = $modDentista->dentistaRetornaSelect($cdnDentista, $label, $arrDentistas, $classe, $nome);
            if ($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por mostrar um select de dentistas de uma determinada área de atuação
         *
         * @param Integer $cdnAreaAtuacao - código numérico da área de atuação
         * @return Void.
         *
         * */
        public function dentistaArea($cdnAreaAtuacao) {
            if (isset($_GET['cdnDentista']))
                $cdnDentista = $_GET['cdnDentista'];
            else
                $cdnDentista = 0;
            $arrCond = array('cdnAreaAtuacao' => $cdnAreaAtuacao);

            $arrDentistas = $this->modelo->consultar('dentista_areaatuacao', '*', $arrCond);

            $arrSelect = array();
            foreach ($arrDentistas as $arrDentista) {
                $arrDentista = $this->modelo->consultar('dentista', '*', array('cdnUsuario' => $arrDentista['cdnDentista']));
                $arrSelect[] = $arrDentista[0];
            }

            $this->dentistaRetornaSelect($cdnDentista, 'Dentista', true, $arrSelect);
        }

        /**
         * Método responsável por calcular quando uma consulta irá terminar
         *
         * @param String $horaConsulta - horário de início
         *
         * */
        public function dentistaTempoConsulta($horaConsulta) {
            $cdnDentista = $_GET['cdnDentista'];
            $numHorarios = $_GET['numHorarios'];
            if (filter_var($numHorarios, FILTER_VALIDATE_INT)) {
                if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)) {
                    $modDentista = new ModeloDentista();
                    $dtoDentista = $modDentista->getDentista($cdnDentista);
                    $numTempoConsulta = $dtoDentista->getNumTempoConsulta();
                    if ($numTempoConsulta != '') {
                        $segundos = $this->transformacaoTempoSegundo($numTempoConsulta) * $numHorarios;
                        $segundosFim = $this->transformacaoTempoSegundo($horaConsulta);

                        $segundosFim += $segundos + (3600 * 3);

                        echo 'Final previsto: ' . date('H:i', $segundosFim);
                    } else {
                        echo 'Não foi possível prever o final desta consulta.';
                    }
                }
            }
        }

        /**
         * Método responsável por verificar se o dentista está com a agenda fechada em um dia
         *
         * */
        public function dentistaVerificaFechado($datFechado) {
            if (isset($_GET['cdnDentista'])) {
                $cdnDentista = $_GET['cdnDentista'];
                if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista) or $cdnDentista == '') {
                    if ($datFechado != '') {
                        $datFechado = explode('/', $datFechado);
                        $datFechado = $datFechado[2] . '-' . $datFechado[1] . '-' . $datFechado[0];

                        $arrCond = array('datFechado' => $datFechado,
                            'conscond1' => 'AND',
                            'cdnDentista' => $cdnDentista,
                            'conscond2' => 'AND',
                            'indAllDay' => 1);
                        $arrFechado = $this->modelo->consultar('dentista_fechado', '*', $arrCond);
                        if (count($arrFechado) > 0)
                            echo '<b>Dentista está com a agenda fechada neste dia.</b>';
                    }
                }
            }
        }

        /**
         * Método responsável por verificar o consultório que o dentista mais utiliza
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @return Void.
         *
         * */
        public function dentistaConsultorio($cdnDentista) {
            if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)) {
                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($cdnDentista);
                if (!is_null($dtoDentista->getCdnConsultorio())) {
                    if ($this->modelo->checaExiste('consultorio', 'cdnConsultorio', $dtoDentista->getCdnConsultorio())) {
                        $modConsultorio = new ModeloConsultorio();
                        $dtoConsultorio = $modConsultorio->getConsultorio($dtoDentista->getCdnConsultorio());
                        if (!$dtoConsultorio->getIndDesvinculado()) {
                            echo $dtoConsultorio->getCdnConsultorio();
                            return;
                        }
                    }
                }
            }
            echo 'nenhum';
            return;
        }

        /**
         * Método responsável por montar um select dos horários do dentista, caso
         * ele estiver configurado para tal
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @param Boolean $darEcho - boolean (default: true)
         * @param String $date - data para montar
         * @return Void.
         *
         * */
        public function dentistaMontaHorarios($cdnDentista, $darEcho = true, $date = null, $endDate = null) {
            if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)) {

                // echo $date;
                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($cdnDentista);
                $numTempoConsulta = $dtoDentista->getNumTempoConsulta();
                $segTempoConsulta = $this->transformacaoTempoSegundo($numTempoConsulta);
                $dtoDias = $modDentista->getDentistaDias($cdnDentista);
                $semana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
                $arrHorarios = array();

                if (isset($_GET['datConsulta'])) {
                    $datConsulta = explode('/', $_GET['datConsulta']);
                    $datConsulta = $datConsulta[2] . '-' . $datConsulta[1] . '-' . $datConsulta[0];
                } else {
                    if (!is_null($date))
                        $datConsulta = $date;
                    else
                        $datConsulta = '0000-00-00';
                }
                $arrCond = array(
                    'cdnDentista' => $cdnDentista,
                    'conscond1' => 'AND',
                    'datAberto' => $datConsulta
                );
                $arrAbertos = $this->modelo->consultar('dentista_aberto', '*', $arrCond);


                $sql = 'SELECT * FROM dentista_fechado
                        WHERE cdnDentista = ' . $cdnDentista . ' AND datFechado = "' . $datConsulta . '"
                ';
                $arrFechados = $this->modelo->query($sql);
                $diaFechado = count($arrFechados) > 0;
                foreach ($arrFechados as $arrFechado) {
                    if ($arrFechado['indAllDay'] == 1)
                        $diaFechado = true;
                    else
                        $diaFechado = false;
                }

                if (!$diaFechado) {

                    $diaSemana = $semana[date('w', strtotime($datConsulta))];
                    $coluna = 'ind' . $diaSemana;
                    $sql = 'SELECT * FROM dentista_intervalo
                            WHERE cdnDentista = ' . $cdnDentista . ' AND
                                  (datIntervalo = "' . $datConsulta . '" OR ' . $coluna . ' = 1)
                    ';
                    $arrIntervalos = $this->modelo->query($sql);

                    $cdnConsulta = isset($_GET['remarcar']) ? $_GET['remarcar'] : 0;
                    $sqlDesmarque = 'SELECT cdnConsulta FROM desmarque';
                    $sqlConsultas = 'SELECT * FROM consulta WHERE consulta.datConsulta = "' . $datConsulta . '" AND consulta.cdnConsulta != ' . $cdnConsulta . ' AND cdnDentista = ' . $cdnDentista . ' AND consulta.cdnConsulta NOT IN (' . $sqlDesmarque . ')';

                    $arrConsultas = $this->modelo->query($sqlConsultas);


                    // for($i = 0; $i < 7; $i++){

                    $funcaoDia = 'getInd' . $diaSemana;
                    for ($j = 0; $j <= 1; $j++) {
                        if ($j == 0)
                            $funcaoHora = 'getHora' . $diaSemana . 'Manha';
                        else
                            $funcaoHora = 'getHora' . $diaSemana . 'Tarde';
                        if (!is_null($dtoDias->{$funcaoHora}()) and $dtoDias->{$funcaoDia}()) {
                            if ($dtoDias->{$funcaoHora}() == '__:__ - __:__' || $dtoDias->{$funcaoHora}() == '')
                                continue;
                            $horaInicio = explode('-', $dtoDias->{$funcaoHora}())[0];
                            $horaFinal = explode('-', $dtoDias->{$funcaoHora}())[1];


                            $segHoraInicio = $this->transformacaoTempoSegundo($horaInicio);
                            $segHoraFinal = $this->transformacaoTempoSegundo($horaFinal);

                            $var = true;

                            $horario = $segHoraInicio;

                            $existeData = count($arrConsultas) > 0;

                            if (count($arrAbertos) > 0) {
                                $var = false;
                            }

                            while ($var) {

                                $somar = true;

                                $horarioFim = $horario + $segTempoConsulta;



                                if ($horarioFim >= $segHoraFinal or $horario >= $segHoraFinal) {
                                    $var = false;
                                }

                                $transformado = $this->transformacaoSegundoTempo($horario);
                                $continue = false;
                                if ($existeData) {

                                    foreach ($arrConsultas as $arrConsulta) {
                                        $transBdInicio = $this->transformacaoTempoSegundo($arrConsulta['horaConsulta']);
                                        $transBdFinal = $this->transformacaoTempoSegundo($arrConsulta['horaFinalizada']);
                                        if ((($horario >= $transBdInicio and $horario < $transBdFinal) OR
                                                $horario == $transBdInicio)) {
                                            $horario = $horarioFim;
                                            $continue = true;
                                        }
                                    }
                                }
                                if ($continue)
                                    continue;

                                foreach ($arrFechados as $arrFechado) {
                                    $transBdInicio = $this->transformacaoTempoSegundo($arrFechado['horaInicio']);
                                    $transBdFinal = $this->transformacaoTempoSegundo($arrFechado['horaFinal']);
                                    if ((($horario >= $transBdInicio and $horario < $transBdFinal) OR
                                            $horario == $transBdInicio) and ! $arrFechado['indAllDay']) {
                                        $horario = $horarioFim;
                                        $continue = true;
                                    }
                                }
                                if ($continue)
                                    continue;

                                foreach ($arrIntervalos as $arrIntervalo) {
                                    $transBdInicio = $this->transformacaoTempoSegundo($arrIntervalo['horaInicio']);
                                    $transBdFinal = $this->transformacaoTempoSegundo($arrIntervalo['horaFinal']);
                                    if ((($horario >= $transBdInicio and $horario < $transBdFinal) OR
                                            $horario == $transBdInicio)) {



                                        $horarioFimIntervalo = $arrIntervalo['horaFinal'];
                                        $transFimIntervalo = $this->transformacaoTempoSegundo($horarioFimIntervalo);
                                        $intervalo = array('INTERVALO', $this->transformacaoSegundoTempo($horario), $horarioFimIntervalo);

                                        $marcado = false;
                                        foreach ($arrConsultas as $arrConsulta) {
                                            $transBdInicio = $this->transformacaoTempoSegundo($arrConsulta['horaConsulta']);
                                            $transBdFinal = $this->transformacaoTempoSegundo($arrConsulta['horaFinalizada']);
                                            if ((($transFimIntervalo >= $transBdInicio and $transFimIntervalo < $transBdFinal) OR
                                                    $transFimIntervalo == $transBdInicio)) {
                                                $marcado = true;
                                            }
                                        }

                                        if ($marcado) {
                                            if (!in_array($intervalo, $arrHorarios[$diaSemana])) {
                                                $arrHorarios[$diaSemana][] = $intervalo;
                                            }
                                            $horario = $horarioFim;
                                        } else {
                                            if (!isset($arrHorarios[$diaSemana]))
                                                $arrHorarios[$diaSemana] = array();
                                            if (!in_array($horarioFimIntervalo, $arrHorarios[$diaSemana])) {
                                                $arrHorarios[$diaSemana][] = $intervalo;
                                                $arrHorarios[$diaSemana][] = $horarioFimIntervalo;
                                            }
                                            $horario = $horarioFim;
                                        }
                                        $continue = true;
                                    }
                                }
                                if ($continue) {
                                    continue;
                                }

                                if ($somar) {
                                    if (!isset($arrHorarios[$diaSemana]))
                                        $arrHorarios[$diaSemana] = array();

                                    $ultPos = count($arrHorarios[$diaSemana]);
                                    if ($ultPos > 0) {
                                        if ($arrHorarios[$diaSemana][$ultPos - 1] != $this->transformacaoSegundoTempo($horario))
                                            $arrHorarios[$diaSemana][] = $this->transformacaoSegundoTempo($horario);
                                    }else {
                                        $arrHorarios[$diaSemana][] = $this->transformacaoSegundoTempo($horario);
                                    }
                                }

                                if ($horarioFim >= $segHoraFinal) {
                                    $var = false;
                                } else {
                                    if ($somar)
                                        $horario = $horarioFim;
                                }

                                if (!$var) {

                                    break;
                                }
                            }
                        }
                    }
                }
                // }
                // Pega dias específicos que foram abertos
                $semana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
                if (count($arrAbertos) > 0) {

                    $dtoAberto = $modDentista->getDentistaAberto($arrAbertos[0]['cdnAberto']);

                    if (!isset($arrIntervalos)) {
                        $diaSemana = $semana[date('w', strtotime($datConsulta))];
                        $coluna = 'ind' . $diaSemana;
                        $sql = 'SELECT * FROM dentista_intervalo
                                WHERE cdnDentista = ' . $cdnDentista . ' AND
                                      (datIntervalo = "' . $datConsulta . '" OR ' . $coluna . ' = 1)
                        ';
                        $arrIntervalos = $this->modelo->query($sql);
                    }

                    if (!isset($arrConsultas)) {
                        $cdnConsulta = isset($_GET['remarcar']) ? $_GET['remarcar'] : 0;
                        $sqlDesmarque = 'SELECT cdnConsulta FROM desmarque';
                        $sqlConsultas = 'SELECT * FROM consulta WHERE consulta.datConsulta = "' . $datConsulta . '" AND consulta.cdnConsulta != ' . $cdnConsulta . ' AND cdnDentista = ' . $cdnDentista . ' AND consulta.cdnConsulta NOT IN (' . $sqlDesmarque . ')';

                        $arrConsultas = $this->modelo->query($sqlConsultas);
                    }

                    $existeData = count($arrConsultas) > 0;
                    for ($j = 0; $j <= 1; $j++) {
                        $funcao = 'getHora';
                        if ($j == 0)
                            $funcao .= 'Manha';
                        else
                            $funcao .= 'Tarde';

                        $horaFuncao = $dtoAberto->{$funcao}();
                        if (strlen($horaFuncao) > 0) {
                            $var = true;
                            $horaInicio = explode('-', $horaFuncao)[0];
                            $horaFinal = explode('-', $horaFuncao)[1];
                            $segHoraInicio = $this->transformacaoTempoSegundo($horaInicio);
                            $segHoraFinal = $this->transformacaoTempoSegundo($horaFinal);
                            $horario = $segHoraInicio;
                            while ($var) {

                                $horarioFim = $horario + $segTempoConsulta;
                                if ($horarioFim >= $segHoraFinal or $horario >= $segHoraFinal) {
                                    $var = false;
                                }

                                $transformado = $this->transformacaoSegundoTempo($horario);
                                $continue = false;
                                if ($existeData) {
                                    foreach ($arrConsultas as $arrConsulta) {
                                        $transBdInicio = $this->transformacaoTempoSegundo($arrConsulta['horaConsulta']);
                                        $transBdFinal = $this->transformacaoTempoSegundo($arrConsulta['horaFinalizada']);
                                        if ((($horario >= $transBdInicio and $horario < $transBdFinal) OR
                                                $horario == $transBdInicio)) {
                                            $horario = $horarioFim;
                                            $continue = true;
                                        }
                                    }
                                }
                                if ($continue)
                                    continue;

                                foreach ($arrIntervalos as $arrIntervalo) {
                                    $transBdInicio = $this->transformacaoTempoSegundo($arrIntervalo['horaInicio']);
                                    $transBdFinal = $this->transformacaoTempoSegundo($arrIntervalo['horaFinal']);
                                    if ((($horario >= $transBdInicio and $horario < $transBdFinal) OR
                                            $horario == $transBdInicio)) {

                                        $horarioFimIntervalo = $arrIntervalo['horaFinal'];
                                        $transFimIntervalo = $this->transformacaoTempoSegundo($horarioFimIntervalo);
                                        $intervalo = array('INTERVALO', $this->transformacaoSegundoTempo($horario), $horarioFimIntervalo);

                                        $marcado = false;
                                        foreach ($arrConsultas as $arrConsulta) {
                                            $transBdInicio = $this->transformacaoTempoSegundo($arrConsulta['horaConsulta']);
                                            $transBdFinal = $this->transformacaoTempoSegundo($arrConsulta['horaFinalizada']);
                                            if ((($transFimIntervalo >= $transBdInicio and $transFimIntervalo < $transBdFinal) OR
                                                    $transFimIntervalo == $transBdInicio)) {
                                                $marcado = true;
                                            }
                                        }

                                        if ($marcado) {
                                            if (!in_array($intervalo, $arrHorarios[$diaSemana])) {
                                                $arrHorarios[$diaSemana][] = $intervalo;
                                            }
                                            $horario = $horarioFim;
                                        } else {
                                            if (!in_array($horarioFimIntervalo, $arrHorarios[$diaSemana])) {
                                                $arrHorarios[$diaSemana][] = $horarioFimIntervalo;
                                                $arrHorarios[$diaSemana][] = $intervalo;
                                                $horario = $horarioFim;
                                            }
                                        }
                                        $continue = true;
                                    }
                                }
                                if ($continue) {
                                    continue;
                                }

                                if (!isset($arrHorarios[$diaSemana]))
                                    $arrHorarios[$diaSemana] = array();

                                $ultPos = count($arrHorarios[$diaSemana]);
                                if ($ultPos > 0) {
                                    if ($arrHorarios[$diaSemana][$ultPos - 1] != $this->transformacaoSegundoTempo($horario))
                                        $arrHorarios[$diaSemana][] = $this->transformacaoSegundoTempo($horario);
                                }else {
                                    $arrHorarios[$diaSemana][] = $this->transformacaoSegundoTempo($horario);
                                }


                                if ($horarioFim >= $segHoraFinal) {
                                    $var = false;
                                } else {
                                    $horario = $horarioFim;
                                }
                            }
                        }
                    }
                }

                if (count($arrHorarios) > 0) {
                    if ($darEcho)
                        echo json_encode($arrHorarios);
                    return $arrHorarios;
                }else {
                    if ($this->modelo->checaExiste('dentista_dias', 'cdnDentista', $cdnDentista)) {
                        if ($darEcho)
                            echo 'nenhum';
                        return 'nenhum';
                    }else {
                        if ($darEcho)
                            echo 'nconfigurado';
                        return 'nenhum';
                    }
                    // if($darEcho)
                    //     echo 'nenhum';
                    // return 'nenhum';
                }
            }
            if ($darEcho)
                echo 'nconfigurado';
            return 'nconfigurado';
        }

        public function dentistaJsonGrafico() {
            $modelo = new Modelo();
            $labels = array();
            $data = array();
            $finalData = array('consultas' => array(), 'desmarques' => array(), 'faltas' => array());
            $sqlDesmarque = 'SELECT * FROM desmarque';
            $sqlFalta = 'SELECT * FROM falta';
            $sql = 'SELECT COUNT(cdnConsulta) as consultas, datConsulta as data
                    FROM consulta
                    WHERE datConsulta >= "' . date('Y-m-01') . '" AND datConsulta <= "' . date('Y-m-t') . '"
                          AND cdnConsulta NOT IN ("' . $sqlDesmarque . '") AND cdnDentista = ' . $_SESSION['cdnUsuario'] . '
                          AND cdnConsulta NOT IN ("' . $sqlFalta . '") 
                    GROUP BY datConsulta
                    ORDER BY datConsulta';
            $consultas = $modelo->query($sql);
            
            $sql = 'SELECT COUNT(cdnConsulta) as remarques, datRemarque as data
                    FROM consulta
                    WHERE datRemarque >= "' . date('Y-m-01') . '" AND datRemarque <= "' . date('Y-m-t') . '"
                          AND cdnConsulta NOT IN ("' . $sqlDesmarque . '") AND cdnDentista = ' . $_SESSION['cdnUsuario'] . '
                          AND cdnConsulta NOT IN ("' . $sqlFalta . '") 
                          AND datRemarque IS NOT NULL
                    GROUP BY datConsulta
                    ORDER BY datConsulta';
            $remarques = $modelo->query($sql);
            
            $sql = 'SELECT COUNT(d.cdnConsulta) as desmarques, c.datConsulta as data
                    FROM desmarque d
                    JOIN consulta c ON d.cdnConsulta = c.cdnConsulta
                    WHERE c.datConsulta >= "' . date('Y-m-01') . '" AND c.datConsulta <= "' . date('Y-m-t') . '"
                          AND c.cdnDentista = ' . $_SESSION['cdnUsuario'] . '
                    GROUP BY c.datConsulta
                    ORDER BY c.datConsulta';
            $desmarques = $modelo->query($sql);

            $sql = 'SELECT COUNT(f.cdnConsulta) as faltas, c.datConsulta as data
                FROM falta f
                JOIN consulta c ON f.cdnConsulta = c.cdnConsulta
                WHERE c.datConsulta >= "' . date('Y-m-01') . '" AND c.datConsulta <= "' . date('Y-m-t') . '"
                      AND c.cdnDentista = ' . $_SESSION['cdnUsuario'] . '
                GROUP BY c.datConsulta
                ORDER BY c.datConsulta';
            $faltas = $modelo->query($sql);

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

    }
    