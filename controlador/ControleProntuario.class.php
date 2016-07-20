<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * dos prontuários de pacientes
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-30
     *
    **/
    class ControleProntuario extends Controlador{
        use Validacao;

        /** 
         * Método construtor
         *
        **/
        public function __construct(){
            $this->modelo = new Modelo();
            $this->visualizador = new Visualizador();

            $modClinica = new ModeloClinica(true);
            $dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);

            if(!$dtoClinica->getIndProntuario()){
                $_SESSION['erroPHP'] = 'Os prontuários não estão disponíveis.';
                $this->inicio();
                return;
            }
        }

        /**
         * Método responsável por mostrar a página de cadastro
         * de tratamento no prontuário do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioCadastrarTratamento($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);

                $modDentista = new ModeloDentista();
                $selectDentista = $modDentista->dentistaRetornaSelect(0, 'Dentista', 'iptCdnUsuario', 'cdnDentista');

                $this->visualizador->atribuirValor('selectDentista', $selectDentista);

                $this->visualizador->mostrarNaTela('cadastrarTratamento', 'Cadastrar Tratamento no Prontuário');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por cadastrar um tratamento no prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioCadastrarTratamentoFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProntuario = new ModeloProntuario();
                $arrValidacao = $modProntuario->prontuarioTratamentoPreparaDTO();
                $dtoProntuarioTratamento = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->prontuarioCadastrarTratamento($cdnPaciente);
                    return;
                }

                $dtoProntuarioTratamento->setCdnPaciente($cdnPaciente);

                if($modProntuario->prontuarioTratamentoCadastrarFim($dtoProntuarioTratamento)){

                    $cdnProntuarioTratamento = $modProntuario->ultimoInserido('prontuario_tratamento');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'prontuario_tratamento', $cdnProntuarioTratamento));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->prontuarioConsultarFim($cdnPaciente);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'prontuario_tratamento', $cdnPaciente));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->prontuarioTratamentoCadastrar();
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de atualização
         * de tratamento no prontuário do paciente
         *
         * @param Integer $cdnProntuarioTratamento - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioAtualizarTratamento($cdnProntuarioTratamento){
            if($this->modelo->checaExiste('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento)){
                $this->visualizador->atribuirValor('cdnProntuarioTratamento', $cdnProntuarioTratamento);

                $modProntuario = new ModeloProntuario();
                $dtoProntuarioTratamento = $modProntuario->getProntuarioTratamento($cdnProntuarioTratamento);

                $modDentista = new ModeloDentista();
                $selectDentista = $modDentista->dentistaRetornaSelect($dtoProntuarioTratamento->getCdnDentista(), 'Dentista', 'iptCdnUsuario', 'cdnDentista');

                $this->visualizador->atribuirValor('selectDentista', $selectDentista);
                
                $this->visualizador->atribuirValor('dtoProntuarioTratamento', $dtoProntuarioTratamento);
                $this->visualizador->mostrarNaTela('atualizarTratamento', 'Atualizar Tratamento em Prontuário');
                return;
            }
            $this->erroExistente();
            return;
        }


        /**
         * Método responsável por atualizar um tratamento no prontuário
         *
         * @param Integer $cdnProntuarioTratamento - código numérico do tratamento
         * @return Void.
         *
        **/
        public function prontuarioAtualizarTratamentoFim($cdnProntuarioTratamento){
            if($this->modelo->checaExiste('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento)){
                $modProntuario = new ModeloProntuario();
                $arrValidacao = $modProntuario->prontuarioTratamentoPreparaDTO($cdnProntuarioTratamento);
                $dtoProntuarioTratamento = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->prontuarioCadastrarTratamento($cdnPaciente);
                    return;
                }

                if($modProntuario->prontuarioTratamentoAtualizarFim($dtoProntuarioTratamento)){

                    // Geração de log
                    $this->log(array('sucesso', 'atualizacao', 'prontuario_tratamento', $cdnProntuarioTratamento));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->prontuarioConsultarFim($dtoProntuarioTratamento->getCdnPaciente());
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'prontuario_tratamento', $cdnProntuarioTratamento));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->prontuarioAtualizarTratamento($cdnProntuarioTratamento);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /** 
         * Método responsável por mostrar a página de consulta de prontuários
         *
         * @return Void.
         *
        **/
        public function prontuarioConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addJs('js/prontuarioConsultar.js');

            $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');
            $this->visualizador->atribuirValor('indProntuarioAntigo', $indProntuarioAntigo);
            
            $arrCond = array('indDesvinculado' => 0);
            $this->visualizador->atribuirValor('arrPacientes', $this->modelo->consultar('paciente', '*', $arrCond));
            $this->visualizador->mostrarNaTela('consultar', 'Lista de prontuários');
        }

        /**
         * Método responsável por mostrar a página de consulta de anamnese
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioConsultarFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $this->visualizador->atribuirValor('arrTratamentos', $this->modelo->consultar('prontuario_tratamento', '*', array('cdnPaciente' => $cdnPaciente)));

                $modPaciente = new ModeloPaciente();
                $modProntuario = new ModeloProntuario();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';

                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->atribuirValor('modProntuario', $modProntuario);
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);

                $this->visualizador->mostrarNaTela('consultarFim', 'Prontuário de '.$arrPaciente['nomPaciente']);

                $this->log(array('sucesso', 'consultar', 'prontuario', $arrPaciente['nomPaciente']));

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de tratamento
         *
         * @param Integer $cdnProntuarioTratamento - código numérico do tratamento
         * @return Void.
         *
        **/
        public function prontuarioDeletarTratamento($cdnProntuarioTratamento){
            if($this->modelo->checaExiste('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento)){
                $this->visualizador->atribuirValor('cdnProntuarioTratamento', $cdnProntuarioTratamento);

                $modProntuario = new ModeloProntuario();
                $dtoProntuarioTratamento = $modProntuario->getProntuarioTratamento($cdnProntuarioTratamento);
                $this->visualizador->atribuirValor('cdnPaciente', $dtoProntuarioTratamento->getCdnPaciente());

                $this->visualizador->mostrarNaTela('deletarTratamento', 'Deletar tratamento');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do tratamento
         *
         * @param Integer $cdnProntuarioTratamento - código numérico do tratamento
         * @return Void.
         *
        **/
        public function prontuarioDeletarTratamentoFim($cdnProntuarioTratamento){
            if($this->modelo->checaExiste('prontuario_tratamento', 'cdnProntuarioTratamento', $cdnProntuarioTratamento)){
                $modProntuario = new ModeloProntuario();
                $dtoProntuarioTratamento = $modProntuario->getProntuarioTratamento($cdnProntuarioTratamento);
                if($this->modelo->deletar('prontuario_tratamento', array('cdnProntuarioTratamento' => $cdnProntuarioTratamento))){

                    $this->log(array('erro', 'delecao', 'prontuario_tratamento', $dtoProntuarioTratamento->getDesProntuarioTratamento()));
                    $this->visualizador->setFlash('Tratamento deletado com sucesso.', 'sucesso');
                    $this->prontuarioConsultarFim($dtoProntuarioTratamento->getCdnPaciente());

                }else{

                    $this->log(array('erro', 'delecao', 'prontuario_tratamento', $dtoProntuarioTratamento->getDesProntuarioTratamento()));
                    $this->visualizador->setFlash('Um problema ocorreu na deleção. Por favor, tente novamente.', 'erro');
                    $this->prontuarioConsultarFim($dtoProntuarioTratamento->getCdnPaciente());
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de impressão de anamnese
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioImprimir($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->addCss('tema/css/plugins/daterangepicker/daterangepicker-bs3.css');
                $this->visualizador->addJs('tema/js/plugins/daterangepicker/daterangepicker.js');
                $this->visualizador->addJs('js/prontuarioImprimir.js');

                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $this->visualizador->atribuirValor('modProntuario', new ModeloProntuario());
                $this->visualizador->atribuirValor('arrHistoricos', $this->modelo->consultar('prontuario_historico', '*', array('cdnPaciente' => $cdnPaciente)));

                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $this->visualizador->mostrarNaTela('imprimir', 'Imprimir Prontuário');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável pela impressão do prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void
         *
        **/
        public function prontuarioImprimirFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProntuario = new ModeloProntuario();

                $this->log(array('sucesso', 'impressao', 'prontuario', $cdnPaciente));

                $modProntuario->prontuarioImprimirFim($cdnPaciente);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por verificar se há algum prontuário impresso nesta data
         *
         * @param String $datIntervalo - intervalo da data
         * @return Void.
         *
        **/
        public function prontuarioVerificaDatas($datIntervalo){
            $datIntervalo = explode('-', $datIntervalo);
            $cdnPaciente = $_GET['cdnPaciente'];
            if(count($datIntervalo) != 2){
                echo 1;
                return;
            }

            $datInicio = trim($datIntervalo[0]);
            $datInicio = explode('/', $datInicio);
            $datInicio = $datInicio[2].'-'.$datInicio[1].'-'.$datInicio[0];

            $datFim = trim($datIntervalo[1]);
            $datFim = explode('/', $datFim);
            $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];
            
            if(!$this->validacaoData($datInicio) or !$this->validacaoData($datFim)){
                echo 1;
                return;
            }

            $modProntuario = new ModeloProntuario();
            $modProntuario->prontuarioVerificaDatas($datInicio, $datFim, $cdnPaciente);

        }

        /**
         * Método responsável por realizar a verificação da necessidade de impressão de prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioAviso($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProntuario = new ModeloProntuario();
                $modProntuario->prontuarioAviso($cdnPaciente);
            }
        }

        /** 
         * Método responsável por mostrar os anexos do prontuário de um paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioVerAnexos($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);

                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);

                $arrAnexos = $this->modelo->consultar('prontuario_anexo', '*', array('cdnPaciente' => $cdnPaciente));
                $this->visualizador->atribuirValor('arrAnexos', $arrAnexos);

                $this->visualizador->atribuirValor('modProntuario', new ModeloProntuario());

                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $this->visualizador->mostrarNaTela('verAnexos', 'Anexos de '.$arrPaciente['nomPaciente']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de cadastro de anexo no prontuario
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioAnexo($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);

                $this->visualizador->mostrarNaTela('anexo', 'Anexo em prontuário - '.$arrPaciente['nomPaciente']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro de anexo em prontuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function prontuarioAnexoFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modProntuario = new ModeloProntuario();
                $arrValidacao = $modProntuario->prontuarioAnexoPreparaDTO($cdnPaciente);
                $dtoProntuarioAnexo = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($modProntuario->prontuarioAnexoFim($dtoProntuarioAnexo)){

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'prontuario_anexo', $cdnPaciente));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->prontuarioVerAnexos($cdnPaciente);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'prontuario_anexo', $cdnPaciente));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->prontuarioAnexo($cdnPaciente);
                    return;

                }

            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por abrir um anexo
         *
         * @param Integer $cdnProntuarioAnexo - código numérico do anexo
         * @return Void.
         *
        **/
        public function prontuarioAbrirAnexo($cdnProntuarioAnexo){
            if($this->modelo->checaExiste('prontuario_anexo', 'cdnProntuarioAnexo', $cdnProntuarioAnexo)){
                $arrAnexo = $this->modelo->consultar('prontuario_anexo', '*', array('cdnProntuarioAnexo' => $cdnProntuarioAnexo))[0];
                header('Location: '.BASE_URL.'/'.$arrAnexo['strDiretorio']);
                return;
            }
            $this->erroExistente();
            return;
        }


        /**
         * Método responsável por mostrar a página de deleção de anexo
         *
         * @param Integer $cdnProntuarioAnexo - código numérico do anexo
         * @return Void.
         *
        **/
        public function prontuarioDeletarAnexo($cdnProntuarioAnexo){
            if($this->modelo->checaExiste('prontuario_anexo', 'cdnProntuarioAnexo', $cdnProntuarioAnexo)){
                $this->visualizador->atribuirValor('cdnProntuarioAnexo', $cdnProntuarioAnexo);

                $modProntuario = new ModeloProntuario();
                $dtoProntuarioAnexo = $modProntuario->getProntuarioAnexo($cdnProntuarioAnexo);
                $this->visualizador->atribuirValor('cdnPaciente', $dtoProntuarioAnexo->getCdnPaciente());

                $this->visualizador->mostrarNaTela('deletarAnexo', 'Deletar anexo');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do anexo
         *
         * @param Integer $cdnProntuarioAnexo - código numérico do anexo
         * @return Void.
         *
        **/
        public function prontuarioDeletarAnexoFim($cdnProntuarioAnexo){
            if($this->modelo->checaExiste('prontuario_anexo', 'cdnProntuarioAnexo', $cdnProntuarioAnexo)){
                $modProntuario = new ModeloProntuario();
                $dtoProntuarioAnexo = $modProntuario->getProntuarioAnexo($cdnProntuarioAnexo);
                if($this->modelo->deletar('prontuario_anexo', array('cdnProntuarioAnexo' => $cdnProntuarioAnexo))){
                    unlink($dtoProntuarioAnexo->getStrDiretorio());
                    $this->log(array('erro', 'delecao', 'prontuario_anexo', $dtoProntuarioAnexo->getDesProntuarioAnexo()));
                    $this->visualizador->setFlash('Anexo deletado com sucesso.', 'sucesso');
                    $this->prontuarioConsultarFim($dtoProntuarioAnexo->getCdnPaciente());

                }else{

                    $this->log(array('erro', 'delecao', 'prontuario_anexo', $dtoProntuarioAnexo->getDesProntuarioAnexo()));
                    $this->visualizador->setFlash('Um problema ocorreu na deleção. Por favor, tente novamente.', 'erro');
                    $this->prontuarioConsultarFim($dtoProntuarioAnexo->getCdnPaciente());
                }
                return;
            }
            $this->erroExistente();
            return;
        }

    }