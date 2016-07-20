<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do usuario
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-07
     *
     * */
    class ControleUsuario extends Controlador {

        /**
         * Método responsável por verificar se o usuário atual que está tentando
         * executar os métodos é um usuário master.
         *
         * @return Void.
         *
         * */
        public function __construct() {
            $this->modelo = new Modelo();
            $this->visualizador = new Visualizador();

            if (!$this->modelo->master() and ! $this->modelo->dono())
                $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por mostrar a página inicial do usuário
         *
         * @return Void.
         *
         * */
        public function usuarioInicio() {
            if ($this->modelo->checaExiste('dentista', 'cdnUsuario', $_SESSION['cdnUsuario'])) {
                $ctrlDentista = new ControleDentista();
                return $ctrlDentista->dentistaInicio();
            }
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
            $this->visualizador->addJs('js/init.graficoInicio.js');

            $this->visualizador->mostrarNaTela('inicio', 'Início');
            return;
        }

        /**
         * Método responsável por mostrar a página de cadastro de usuário
         *
         * @return Void.
         *
         * */
        public function usuarioCadastrar() {
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Usuário');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do usuário.
         *
         * @return Void.
         *
         * */
        public function usuarioCadastrarFim() {
            $modUsuario = new ModeloUsuario();
            $arrValidacao = $modUsuario->usuarioPreparaDTO();
            $dtoUsuario = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if ($mesErro != '') {
                $this->visualizador->setFlash($mesErro, 'erro');
                $this->usuarioCadastrar();
                return;
            }

            if ($modUsuario->usuarioCadastrarFim($dtoUsuario)) {

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'usuario', $_POST['strEmail']));
                $cdnUsuario = $modUsuario->ultimoInserido('usuario_master');

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->usuarioConsultarFim($cdnUsuario);
                return;
            } else {

                // Geração de log
                $this->log(array('erro', 'cadastro', 'usuario', $_POST['strEmail']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->usuarioCadastrar();
                return;
            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um usuário.
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         */
        public function usuarioAtualizar($cdnUsuario) {
            $modUsuario = new ModeloUsuario();
            if ($modUsuario->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario)) {
                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);
                $this->visualizador->mostrarNaTela('atualizar', 'Atualizar meus dados');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function usuarioAtualizarFim($cdnUsuario) {
            $modUsuario = new ModeloUsuario();
            if ($modUsuario->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario)) {
                $arrValidacao = $modUsuario->usuarioPreparaDTO($cdnUsuario);
                $dtoUsuario = $arrValidacao[0];
                $dtoUsuario->setCdnUsuario($cdnUsuario);

                $mesErro = $arrValidacao[1];

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($cdnUsuario);

                if ($_POST['strEmail'] != $arrUsuario['strEmail']) {
                    $modMain = new ModeloMain(true);
                    if ($modMain->mainChecaExisteEmail()) {
                        $mesErro .= 'E-mail já cadastrado no sistema.';
                    }
                }

                if ($mesErro != '') {
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->usuarioAtualizar($cdnUsuario);
                    return;
                }


                if ($modUsuario->usuarioAtualizarFim($dtoUsuario)) {

                    // Geração de log
                    $this->log(array('sucesso', 'atualizacao', 'usuario', $cdnUsuario));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO);
                    $this->usuarioConsultarFim($cdnUsuario);
                    return;
                } else {

                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'usuario', $cdnUsuario));

                    $this->visualizador->setFlash(ERRO_CADASTRO);
                    $this->usuarioAtualizar($cdnUsuario);
                    return;
                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de usuários do sistema
         *
         * @return Void
         *
         * */
        public function usuarioConsultar() {
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modMain = new ModeloMain(true);
            $this->visualizador->atribuirValor('modUsuario', new ModeloUsuario());
            $this->visualizador->atribuirValor('modMain', $modMain);
            $this->visualizador->atribuirValor('arrUsuarios', $this->modelo->consultar('usuario_master'));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Usuários');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * usuário.
         *
         * @param Integer $cdnUsuario - código numérico do usuario
         * @return Void.
         *
         */
        public function usuarioConsultarFim($cdnUsuario) {
            if ($this->modelo->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario)) {
                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);

                $this->visualizador->mostrarNaTela('consultarFim', $arrUsuario['nomUsuario']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function usuarioDeletar($cdnUsuario) {
            if ($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono()) {
                $modMain = new ModeloMain(true);
                if ($this->modelo->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario)) {
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
         * Método responsável por finalizar a deleção do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function usuarioDeletarFim($cdnUsuario) {
            if ($_SESSION['cdnUsuario'] == $cdnUsuario or $this->modelo->dono()) {
                $modMain = new ModeloMain(true);
                if ($this->modelo->checaExiste('usuario_master', 'cdnUsuario', $cdnUsuario)) {
                    $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuario));
                    $this->modelo->deletar('usuario_master', array('cdnUsuario' => $cdnUsuario));
                    if ($_SESSION['cdnUsuario'] == $cdnUsuario) {
                        $ctrlMain = new ControleMain();
                        $ctrlMain->mainSairFim();
                        return;
                    }
                    // Geração de log
                    $this->log(array('sucesso', 'delecao', 'user', $cdnUsuario));

                    $this->visualizador->setFlash('Usuario deletado.', 'sucesso');
                    $this->usuarioConsultar();
                    return;
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }


    }
    