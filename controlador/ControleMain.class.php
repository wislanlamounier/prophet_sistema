<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do main
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-07
     *
     * */
    class ControleMain extends Controlador {

        /**
         * Método construtor
         *
         * */
        public function __construct() {
            parent::__construct();
            $this->modelo = new Modelo(true);
            $this->visualizador = new Visualizador();
        }

        /**
         * Método utilizado para mostrar a página de login ao usuário
         *
         * @return Void.
         * */
        public function mainLogin($ref = 'inicio') {
            if (isset($_SESSION['cdnUsuario'])) {
                $this->inicio();
                return;
            }
            switch ($ref) {
                case 'cad':
                    $this->visualizador->atribuirValor('ref', 'configuracoes');
                    break;

                default:
                    $this->visualizador->atribuirValor('ref', 'inicio');
                    break;
            }
            $this->visualizador->mostrarNaTela('login', 'Entrar no sistema', false);
            return;
        }

        /**
         * Método utilizado para finalizar o login do usuário
         *
         * @param String $ref - para onde vai após o login
         * @return Void.
         *
         * */
        public function mainLoginFim($ref = 'inicio') {
            $modMain = new ModeloMain(true);
            $ret = $modMain->mainLoginFim();
            if ($ret === true) {
                $this->log(array('sucesso', 'login', 'main', $_POST['strEmail']));

                switch($ref){
                    case 'configuracoes':
                        $this->visualizador->setFlash('Este é o seu primeiro acesso, seja bem-vindo! Abaixo, você pode preencher dados adicionais de sua clínica.', 'sucesso');
                        $clinica = new ControleClinica();
                        $clinica->clinicaConsultarFim();
                        break;
                    default:
                        $this->visualizador->setFlash('Bem-vindo!', 'sucesso');
                        $this->inicio();
                        break;
                }
            } else {

                $this->log(array('erro', 'login', 'main', $_POST['strEmail']));

                $this->visualizador->setFlash($ret, 'erro');
                $this->mainLogin($ref);
            }
            return;
        }

        /**
         * Método utilizado para finalizar a sessão do usuário
         *
         * @return Void.
         *
         */
        public function mainSairFim() {
            session_destroy();
            session_start();
            $this->visualizador->setFlash('Até logo!', 'mensagem');
            $this->inicio();
            return;
        }

        /**
         * Método responsável por retornar o select de usuários
         *
         * @param Integer $cdnUsuario - código numérico do usuário para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Usuário.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param String $classe - classe do input. Padrão: iptCdnUsuario.
         * @param String $nome - nome do input. Padrão: cdnUsuario.
         * @return String - select de clientes
         *
         * */
        public function mainRetornaSelect($cdnUsuario = 0, $label = 'Usuario', $darEcho = true, $classe = 'iptCdnUsuario', $nome = 'cdnUsuario') {
            $modMain = new ModeloMain(true);
            $select = $modMain->mainRetornaSelect($cdnUsuario, $label, $classe, $nome);
            if ($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por finalizar a sessão por idle time
         *
         * @return Void.
         *
         * */
        public function mainIdle() {
            $strEmail = $_SESSION['strEmail'];
            session_destroy();
            session_start();
            setcookie('strEmail', $strEmail, time() + 60 * 60 * 24 * 30);
            return;
        }

        /**
         * Método responsável por refazer o login após o idle time
         *
         * @param String $strSenha - senha do usuário
         * @return Void.
         *
         * */
        public function mainLoginIdle($strSenha) {
            $_POST['strEmail'] = $_COOKIE['strEmail'];
            setcookie('strEmail', null, 1);

            $_POST['strSenha'] = crypt($strSenha, '$2a$12$jALKAJSeqwnaSEnxcjayeE$');

            $modMain = new ModeloMain(true);
            if ($modMain->mainloginFim()) {
                echo 1;
            } else {
                echo 0;
            }

            return;
        }

        /**
         * Método responsável por realizar o logout após o idle time
         *
         * */
        public function mainSairIdle() {
            session_destroy();
            session_start();
            $this->visualizador->setFlash('Dados não conferem.', 'erro');
            $this->mainLogin();
            return;
        }

        /**
         * Método responsável por mostrar a página de configurações
         *
         *
         * */
        public function mainConfiguracoes() {
            $modMain = new ModeloMain(true);
            if ($this->modelo->checaExiste('configuracoes', 'cdnClinica', $_SESSION['cdnClinica'])) {
                $dtoConfiguracoes = $modMain->getConfiguracoes();
            } else {
                $dtoConfiguracoes = new DTOConfiguracoes();
            }
            $modBoleto = new ModeloBoleto(true);
            $configuracoes = $modBoleto->getConfiguracao();
            if (isset($configuracoes['banco']))
                $codBanco = $configuracoes['banco'];
            else
                $codBanco = '041';
            $this->visualizador->atribuirValor('codBanco', $codBanco);
            $this->visualizador->addJs('js/clinicaConfiguracoes.js');
            $this->visualizador->atribuirValor('dtoConfiguracoes', $dtoConfiguracoes);
            $this->visualizador->mostrarNaTela('configuracoes', 'Configurações');
        }

        /**
         * Método responsável por mudar as configurações
         *
         * */
        public function mainConfiguracoesFim() {
            $modMain = new ModeloMain(true);
            $arrValidacao = $modMain->mainConfiguracoesFim();
            $mesErro = $arrValidacao[1];
            $arrValidacao = $arrValidacao[0];

            if ($mesErro == '') {
                $this->log(array('sucesso', 'configuracoes', 'main'));

                $this->visualizador->setFlash('Configurações alteradas com sucesso.', 'sucesso');
                $this->inicio();
            } else {
                $this->log(array('erro', 'configuracoes', 'main'));

                $this->visualizador->setFlash($mesErro, 'erro');
                $this->mainConfiguracoes();
            }
        }

        /**
         * Método responsável por redirecionar o usuário para o perfil correto
         *
         * @param Integer $cdnUsuario - código númerico do usuário
         * @return void.
         *
         * */
        static function mainPerfil($cdnUsuario) {
            $modMain = new ModeloMain(true);
            if ($modMain->checaExiste('usuario', 'cdnUsuario', $cdnUsuario)) {
                $modelo = new Modelo();
                if ($modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {
                    $ctrlDentista = new ControleDentista();
                    return $ctrlDentista->dentistaConsultarFim($cdnUsuario);
                } elseif ($modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)) {
                    $ctrlColaborador = new ControleColaborador();
                    return $ctrlColaborador->colaboradorConsultarFim($cdnUsuario);
                } else {
                    $ctrlUsuario = new ControleUsuario();
                    return $ctrlUsuario->usuarioConsultarFim($cdnUsuario);
                }
            }
            $controlador = new Controlador();
            $controlador->erroExistente();
            return;
        }

        /**
         * Método responsável por transformar um usuário em usuário master
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function mainMaster($cdnUsuario) {
            if ($this->modelo->dono()) {
                if ($this->modelo->checaExiste('usuario', 'cdnUsuario', $cdnUsuario)) {
                    $modUsuario = new ModeloUsuario();
                    $dtoUsuario = new DTOUsuario();
                    $dtoUsuario->setCdnUsuario($cdnUsuario);

                    if ($modUsuario->usuarioMasterFim($dtoUsuario)) {
                        $this->log(array('sucesso', 'master', 'main'));

                        $this->visualizador->setFlash('Permissões de usuário master concebidas.', 'sucesso');

                        return ControleMain::mainPerfil($cdnUsuario);
                    } else {

                        $this->log(array('erro', 'master', 'main'));

                        $this->visualizador->setFlash('Um problema ocorreu. Por favor, tente novamente.', 'erro');

                        return ControleMain::mainPerfil($cdnUsuario);
                    }
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        /**
         * Método responsável por retirar o usuário de master
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Void.
         *
         * */
        public function mainDesfazerMaster($cdnUsuario) {
            if ($this->modelo->dono()) {
                if ($this->modelo->checaExiste('usuario', 'cdnUsuario', $cdnUsuario)) {
                    $modelo = new Modelo();
                    if ($modelo->checaExiste('dentista', 'cdnUsuario', $cdnUsuario)) {

                        $modelo->deletar('usuario_master', array('cdnUsuario' => $cdnUsuario));

                        $this->log(array('sucesso', 'desfazer_master', 'main'));

                        $this->visualizador->setFlash('Usuário retirado da categoria master.', 'sucesso');

                        return ControleMain::mainPerfil($cdnUsuario);
                    } elseif ($modelo->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario)) {

                        $modelo->deletar('usuario_master', array('cdnUsuario' => $cdnUsuario));

                        $this->log(array('sucesso', 'desfazer_master', 'main'));

                        $this->visualizador->setFlash('Usuário retirado da categoria master.', 'sucesso');

                        return ControleMain::mainPerfil($cdnUsuario);
                    } else {
                        $this->visualizador->setFlash('Este usuário não pode ser removido.', 'erro');
                        ControleMain::mainPerfil($cdnUsuario);
                    }
                }
                $this->erroExistente();
                return;
            }
            $this->erroPermissao();
            return;
        }

        public function mainBackup() {
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');


            $modMain = new ModeloMain(true);
            $sql = 'SELECT * FROM backup WHERE cdnClinica = ' . $_SESSION['cdnClinica'] . ' OR cdnClinica = 0 ORDER BY cdnUsuario DESC, datBackup DESC LIMIT 2';
            $arrBackups = $modMain->query($sql);


            $ultimoBackup = 'SELECT * FROM backup WHERE cdnClinica = ' . $_SESSION['cdnClinica'] . ' OR cdnClinica = 0 ORDER BY datBackup DESC LIMIT 1';
            $arrUltimo = $modMain->query($ultimoBackup);
            if (count($arrUltimo) > 0) {
                $dtoUltimo = $modMain->getBackup($arrUltimo[0]['cdnBackup']);
                $this->visualizador->atribuirValor('dtoUltimo', $dtoUltimo);
            }


            $this->visualizador->atribuirValor('arrBackups', $arrBackups);
            $this->visualizador->mostrarNaTela('backup', 'Segurança da informação');
            return;
        }

        public function mainBackupFim() {
            // mudar max execution time
            set_time_limit(0);
            $dbhost = HOST;
            $dbuser = USUARIO_BANCO;
            $dbpass = SENHA_BANCO;
            $db = BANCO;

            if ($db == 'prophet_main') {
                $this->erroPermissao();
                return;
            }
            $ds = DIRECTORY_SEPARATOR;

            if (!is_dir('backups'))
                mkdir('backups', 777, true);

            $backup_file = 'backups' . $ds . $_SESSION['cdnClinica'] . '.sql';

            if (LOCAL == 'web') {
                $command = "/usr/bin/mysqldump ";
            } else {
                $command = "c:" . $ds . "xampp" . $ds . "mysql" . $ds . "bin" . $ds . "mysqldump ";
            }

            if ($dbpass != '')
                $command .= "--opt -h $dbhost -u $dbuser -p$dbpass $db > " . __DIR__ . "/../$backup_file";
            else
                $command .= "--opt -h $dbhost -u $dbuser $db > $backup_file";

            system($command);
            $modMain = new ModeloMain(true);
            $modMain->mainSalvarBackup($backup_file);
            // Geração de log
            $this->log(array('sucesso', 'backup', 'backup'));
            $this->visualizador->setFlash('Backup realizado com sucesso.', 'sucesso');
            $this->mainBackup();
            return;
        }

        public function mainDownloadBackup($cdnBackup) {
            $modMain = new ModeloMain(true);
            if ($modMain->checaExiste('backup', 'cdnBackup', $cdnBackup)) {
                $dtoBackup = $modMain->getBackup($cdnBackup);
                if ($dtoBackup->getCdnClinica() != 0) {
                    $nomArquivo = $dtoBackup->getNomArquivo();
                    $arquivo = fopen($nomArquivo, 'r');
                    $size = filesize($nomArquivo);
                    $password = 'sdf23qwersdfg34awesr1312321ewe';
                    $arquivo = uniqid() . '.zip';
                    system('zip -P ' . $password . ' ' . $arquivo . ' ' . $nomArquivo);

                    header("Content-type: application/zip");
                    header("Content-Disposition: attachment; filename=$arquivo");
                    header("Content-length: " . filesize($arquivo));
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    readfile("$arquivo");
                    unlink($arquivo);
                } else {
                    $this->erroPermissao();
                    return;
                }
            } else {
                $this->erroExistente();
                return;
            }
        }

        public function mainPermissao() {
            if(!isset($_GET['controlador']) || !isset($_GET['funcao']))
                echo 0;
            $controlador = $_GET['controlador'];
            $funcao = $controlador.ucfirst($_GET['funcao']);

            include('inc/funcoes.inc.php');
            if (isset($_SESSION['cdnUsuario'])) {
                if (!in_array($funcao, $liberadas)) {
                    $key = array_search($funcao, $bloqueadas);
                    if ($key) {
                        $modPermissao = new ModeloPermissao(true);
                        $dtoPermissao = $modPermissao->getPermissao($_SESSION['cdnUsuario']);
                        $strPermissao = $dtoPermissao->getStrPermissao();
                        $strPermissao = explode('|', $strPermissao);
                        if (!in_array($key, $strPermissao)) {
                            if (!Modelo::donoStatic()) {
                                echo 'erro';
                            }
                        }
                    }
                }
            } else {
                if (!in_array($funcao, $liberadas)) {
                    if (!Modelo::donoStatic()) {
                        echo 'erro';
                    }
                }
            }
        }

        public function mainLogs(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            
            $modMain = new ModeloMain(false);
            $sql = $modMain->mainMontaSqlLogs();

            $arrLogs = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrLogs', $arrLogs);

            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);
            $this->visualizador->atribuirValor('usuario', isset($_POST['usuario']) ? $_POST['usuario'] : null);

            $sql = 'SELECT * FROM prophet_main.usuario WHERE cdnClinica = '.$_SESSION['cdnClinica'];
            $arrUsuarios = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrUsuarios', $arrUsuarios);

            $this->visualizador->mostrarNaTela('logs', 'Logs de ações');
        }


    }
