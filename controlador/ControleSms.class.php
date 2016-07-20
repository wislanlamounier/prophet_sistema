<?php

    class ControleSms extends Controlador{

        public function smsEnviar(){
        	if(func_num_args() < 2){
        		return $this->erroExistente();
        	}
        	$tipo = func_get_args()[0];
        	$cdnPaciente = func_get_args()[1];
            $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $cdnPaciente));
            if(count($arrPaciente) == 0){
                return $this->erroExistente();
            }
            $arrPaciente = $arrPaciente[0];


            $this->visualizador->atribuirValor('tipoSms', $tipo);
            $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
            $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);

            $argumentos = array();
            $argumentosUrl = '';
        	for($i = 2; $i < func_num_args(); $i++){
                $argumentos[] = func_get_args()[$i];
                $argumentosUrl .= '/'.func_get_args()[$i];
        	}
            $this->visualizador->atribuirValor('argumentos', $argumentos);
            $this->visualizador->atribuirValor('argumentosUrl', $argumentosUrl);

            $this->visualizador->mostrarNaTela('enviar', 'Confirmação de envio');
        }

        public function smsEnviarFim(){
            if(func_num_args() < 2){
                return $this->erroExistente();
            }
            $tipo = func_get_args()[0];
            $cdnPaciente = func_get_args()[1];
            $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $cdnPaciente));
            if(count($arrPaciente) == 0){
                return $this->erroExistente();
            }

            $argumentos = array();
        	for($i = 2; $i < func_num_args(); $i++){
                $argumentos[] = func_get_args()[$i];
        	}

            $modSms = new ModeloSms();
            $arrRetorno = $modSms->smsCadastrarFim($tipo, $cdnPaciente, $argumentos);

            if($arrRetorno[0]){
                $dtoSms = $arrRetorno[1];
                $cdnSms = $dtoSms->getCdnSms();
                $retorno = $modSms->smsEnviarFim($dtoSms);
                if(!is_array($retorno)){
                    $this->log(array('sucesso', 'envio', 'sms', $cdnPaciente.' - '.$tipo));
                    $this->visualizador->setFlash('SMS enviado com sucesso!', 'sucesso');
                    return $this->inicio();
                }else{
                    $this->log(array('erro', 'envio', 'sms', $cdnPaciente.' - '.$tipo.' - '.$retorno[1]));
                    $this->visualizador->setFlash('O SMS não foi enviado. Código do erro: '.$retorno[1], 'erro');
                    $this->modelo->deletar('sms', array('cdnSms' => $cdnSms));
                    $dtoAviso = $this->modelo->getRegistro('sms_aviso_consulta', 'cdnSms', $cdnSms);
                    $dtoAviso->setCdnSms(null);
                    $this->modelo->atualizar('sms_aviso_consulta', $dtoAviso->getArrayBanco(), array('cdnSms' => $cdnSms));
                    return $this->inicio();
                }
            }else{
                $this->log(array('erro', 'envio', 'sms', $cdnPaciente.' - '.$tipo));
                $this->visualizador->setFlash('O SMS não foi enviado.', 'erro');
                return $this->inicio();
            }
        }

        public function smsHistorico($cdnPaciente = null){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modSms = new ModeloSms();
            $sql = $modSms->smsMontaSql($cdnPaciente, true);
            
            $arrSms = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrSms', $arrSms);
            
            $this->visualizador->atribuirValor('tipo2', isset($_POST['tipo']) ? $_POST['tipo'] : null);
            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'historico');
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario';
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            $this->visualizador->mostrarNaTela('historico', 'Histórico de SMS');
        }

        public function smsConsultarFim($cdnSms){
            if($this->modelo->checaExiste('sms', 'cdnSms', $cdnSms)){
                $sql = 'SELECT * FROM sms s JOIN paciente p ON p.cdnPaciente = s.cdnPaciente WHERE cdnSms = '.$cdnSms;
                $arrSms = $this->modelo->query($sql)[0];
                if(isset($arrSms['nomSobrenome']))
                    $arrSms['nomPaciente'] .= ' '.$arrSms['nomSobrenome'];
                $this->visualizador->atribuirValor('arrSms', $arrSms);
                $this->visualizador->mostrarNaTela('consultarFim', 'Visualizar SMS');
                return;
            }
            return $this->erroExistente();
        }

        public function smsBaixarHistorico(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            
            $this->visualizador->atribuirValor('tipo2', isset($_POST['tipo']) ? $_POST['tipo'] : null);
            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'baixar');
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario';
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            return $this->visualizador->mostrarNaTela('baixarHistorico', 'Baixar arquivo de histórico');
        }

        public function smsBaixarHistoricoFim(){
            $modSms = new ModeloSms();
            $sql = $modSms->smsMontaSql();
            
            $arrSms = $this->modelo->query($sql);

            // Geração de log
            $this->log(array('sucesso', 'baixar historico', 'sms'));

            return $modSms->smsMontarTxt($arrSms);
        }

        public function smsRespostas(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modSms = new ModeloSms();
            $sql = $modSms->smsMontaSqlResposta();
            $arrRespostas = $this->modelo->query($sql);
            
            $this->visualizador->atribuirValor('arrRespostas', $arrRespostas);
            
            
            $this->visualizador->atribuirValor('tipo2', isset($_POST['tipo']) ? $_POST['tipo'] : null);
            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'respostas');
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario';
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);
            
            $this->visualizador->addJs('js/pacienteSelect.js');
            
            $this->visualizador->mostrarNaTela('respostas', 'Respostas de SMS');
            $sql = 'UPDATE sms_aviso_consulta_resposta SET indVisualizado = 1 WHERE indVisualizado = 0';
            $this->modelo->sql($sql);
            return;
        }
        
        public function smsBaixarRespostas(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            
            $this->visualizador->atribuirValor('tipo2', isset($_POST['tipo']) ? $_POST['tipo'] : null);
            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'baixar');
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario';
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            return $this->visualizador->mostrarNaTela('baixarRespostas', 'Baixar arquivo de respostas');
        }

        public function smsBaixarRespostasFim(){
            $modSms = new ModeloSms();
            $sql = $modSms->smsMontaSqlResposta();
            
            $arrSms = $this->modelo->query($sql);

            // Geração de log
            $this->log(array('sucesso', 'baixar respostas', 'sms'));

            return $modSms->smsMontarTxt($arrSms, true);
        }
        
        public function smsConfiguracoes(){
            $modMain = new ModeloMain(true);
            $dtoConfiguracoes = $modMain->getConfiguracoes();
            $this->visualizador->atribuirValor('dtoConfiguracoes', $dtoConfiguracoes);
            $this->visualizador->addJs('js/smsConfiguracoes.js');
            $this->visualizador->mostrarNaTela('configuracoes', 'Configurações');
            return;
        }
        
        public function smsConfiguracoesFim(){
            $modSms = new ModeloSms();
            $retorno = $modSms->smsConfiguracoesFim();
            if($retorno === true){
                $this->visualizador->setFlash('Configurações alteradas com sucesso.', 'sucesso');
                $this->log(array('sucesso', 'configuracoes', 'sms'));
            }else{
                $this->visualizador->setFlash($retorno, 'erro');
                $this->log(array('erro', 'configuracoes', 'sms'));
            }
            return $this->smsConfiguracoes();
        }

    }
