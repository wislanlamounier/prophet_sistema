<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * das questionários anamnese de pacientes
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-30
     *
    **/
    class ControleAnamnese extends Controlador{

        /** 
         * Método responsável por mostrar a página de consulta de questionários anamnese
         *
         * @return Void.
         *
        **/
        public function anamneseConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addJs('js/anamneseConsultar.js');

            $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');
            $this->visualizador->atribuirValor('indProntuarioAntigo', $indProntuarioAntigo);
            
            $arrCond = array('indDesvinculado' => 0);
            $this->visualizador->atribuirValor('arrPacientes', $this->modelo->consultar('paciente', '*', $arrCond));
            $this->visualizador->mostrarNaTela('consultar', 'Questionários anamneses');
        }

        /**
         * Método responsável por mostrar a página de consulta de anamnese
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function anamneseConsultarFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $this->visualizador->atribuirValor('arrCampos', $this->modelo->consultar('anamnese_campo'));

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';
                
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);


                if($this->modelo->checaExiste('resposta', 'cdnPaciente', $cdnPaciente)){
                    $arrRespostas = $this->modelo->consultar('resposta', '*', array('cdnPaciente' => $cdnPaciente));
                    $this->visualizador->atribuirValor('arrRespostas', $arrRespostas);
                    $this->visualizador->atribuirValor('modPergunta', new ModeloPergunta());
                }

                if($this->modelo->checaExiste('dependente', 'cdnPaciente', $cdnPaciente)){
                    $this->visualizador->atribuirValor('strTipo', 'Dependente');
                    $arrDependentes = $this->modelo->consultar('dependente', '*', array('cdnPaciente' => $cdnPaciente));
                    $strParcerias = '';
                    foreach($arrDependentes as $arrDependente){
                        $arrParcerias = $this->modelo->consultar('parceria', '*', array('cdnParceria' => $arrDependente['cdnResponsavel']));
                        foreach($arrParcerias as $arrParceria){
                            $strParcerias .= $arrParceria['nomParceria'].', ';
                        }
                    }
                    $strParcerias = trim($strParcerias, ', ');
                    $this->visualizador->atribuirValor('strParceria', $strParcerias);
                }else{
                    $this->visualizador->atribuirValor('strTipo', 'Titular');
                    $this->visualizador->atribuirValor('strParceria', 'Particular');
                }

                if($this->modelo->checaExiste('paciente_responsavel', 'cdnPaciente', $cdnPaciente)){
                    $this->visualizador->atribuirValor('responsavel', 'true');
                }

                $this->visualizador->mostrarNaTela('consultarFim', 'Anamnese de '.$arrPaciente['nomPaciente']);

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
        public function anamneseImprimir($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modAnamnese = new ModeloAnamnese();
                $modAnamnese->anamneseImprimir($cdnPaciente);
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
        public function anamneseImprimirFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modAnamnese = new ModeloAnamnese();
                $modAnamnese->anamneseImprimirFim($cdnPaciente);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de resposta de perguntas ao usuário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function anamneseResponder($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $this->visualizador->atribuirValor('arrPerguntas', $this->modelo->consultar('pergunta'));
                $this->visualizador->atribuirValor('modPergunta', new ModeloPergunta());
                $this->visualizador->mostrarNaTela('responder', 'Responder Questionário');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro de respostas de questionário
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function anamneseResponderFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modAnamnese = new ModeloAnamnese();
                $modAnamnese->anamneseResponderFim($cdnPaciente);

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->anamneseConsultarFim($cdnPaciente);
                return;
            }
            $this->erroExistente();
            return;
        }


    }