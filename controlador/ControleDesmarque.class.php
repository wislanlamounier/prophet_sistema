<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do desmarque
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-21
     *
    **/
    class ControleDesmarque extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de desmarque
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function desmarqueCadastrar($cdnPaciente, $cdnConsulta){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente) and
               $this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta) and
              !$this->modelo->checaExiste('desmarque', 'cdnConsulta', $cdnConsulta)){

                $modPaciente = new ModeloPaciente();
                $modConsulta = new ModeloConsulta();

                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);

                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->mostrarNaTela('cadastrar', 'Desmarcar consulta');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do desmarque.
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function desmarqueCadastrarFim($cdnPaciente, $cdnConsulta){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente) and
               $this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta) and
              !$this->modelo->checaExiste('desmarque', 'cdnConsulta', $cdnConsulta)){
                $modDesmarque = new ModeloDesmarque();
                $dtoDesmarque = new DTODesmarque();

                $dtoDesmarque->setCdnPaciente($cdnPaciente);
                $dtoDesmarque->setCdnConsulta($cdnConsulta);

                if($modDesmarque->desmarqueCadastrarFim($dtoDesmarque)){

                    $modConsulta = new ModeloConsulta();
                    $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                    $modConsulta->consultaCancelarSms($dtoConsulta);
                
                    // ignorar
                    if(false){
                        $arrCond = array(
                            'cdnOrcamento' => $dtoConsulta->getCdnOrcamento(),
                            'conscond1' => 'AND',
                            'cdnAreaAtuacao' => $dtoConsulta->getCdnAreaAtuacao(),
                            'conscond2' => 'AND',
                            'cdnProcedimento' => $dtoConsulta->getCdnProcedimento(),
                            'conscond3' => 'AND',
                            'cdnDentista' => $dtoConsulta->getCdnDentista()
                        );
                        $arrProcedimento = $this->modelo->consultar('orcamento_procedimento', '*', $arrCond);
                        if(count($arrProcedimento) > 0){
                            $arrProcedimento = $arrProcedimento[0];
                            $arrProcedimento['numQuantidadeRealizado']--;
                            if(!$this->modelo->atualizar('orcamento_procedimento', $arrProcedimento, $arrCond)){
                                $this->modelo->deletar('desmarque', array('cdnPaciente' => $cdnPaciente, 'conscond1' => 'AND', 'cdnConsulta' => $cdnConsulta));
                                // Geração de log
                                $this->log(array('erro', 'cadastro', 'desmarque', $cdnConsulta));

                                $this->visualizador->setFlash('Não foi possível desfazer a ligação com o orçamento.', 'erro');
                                $this->desmarqueCadastrar($cdnPaciente, $cdnConsulta);
                                return;
                            }
                        }
                    }
                    
                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'desmarque', $cdnConsulta));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');

                    $ctrlConsulta = new ControleConsulta();
                    $ctrlConsulta->consultaConsultarFim($cdnConsulta);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'desmarque', $cdnConsulta));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->desmarqueCadastrar($cdnPaciente, $cdnConsulta);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por desfazer o desmarque
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function desmarqueCancelar($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->mostrarNaTela('cancelar', 'Cancelar desmarque');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a ação de desfazer o desmarque
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function desmarqueCancelarFim($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                
                // ignorar
                if(false){
                    $arrCond = array(
                        'cdnOrcamento' => $dtoConsulta->getCdnOrcamento(),
                        'conscond1' => 'AND',
                        'cdnAreaAtuacao' => $dtoConsulta->getCdnAreaAtuacao(),
                        'conscond2' => 'AND',
                        'cdnProcedimento' => $dtoConsulta->getCdnProcedimento(),
                        'conscond3' => 'AND',
                        'cdnDentista' => $dtoConsulta->getCdnDentista()
                    );
                    $arrProcedimento = $this->modelo->consultar('orcamento_procedimento', '*', $arrCond);
                    if(count($arrProcedimento) > 0){
                        $arrProcedimento = $arrProcedimento[0];
                        if($arrProcedimento['numQuantidadeRealizado'] == $arrProcedimento['numQuantidade']){
                            $this->log(array('erro', 'desfazer', 'desmarque', $cdnConsulta));

                            $this->visualizador->setFlash('Não foi possível refazer a ligação com o orçamento. Outra consulta já foi registrada no lugar desta.', 'erro');
                            $this->desmarqueCancelar($cdnConsulta);
                            return;
                        }
                    }
                }
                
                if($this->modelo->deletar('desmarque', array('cdnConsulta' => $cdnConsulta))){

                    if(false){
                        if(count($arrProcedimento) > 0){
                            $arrProcedimento['numQuantidadeRealizado']++;
                            if(!$this->modelo->atualizar('orcamento_procedimento', $arrProcedimento, $arrCond)){

                                $dtoDesmarque = new DTODesmarque();
                                $dtoDesmarque->setCdnConsulta($cdnConsulta);
                                $dtoDesmarque->setCdnPaciente($dtoConsulta->getCdnPaciente());
                                $this->modelo->inserir('desmarque', $dtoDesmarque->getArrayBanco());

                                // Geração de log
                                $this->log(array('erro', 'desfazer', 'desmarque', $cdnConsulta));

                                $this->visualizador->setFlash('Não foi possível refazer a ligação com o orçamento. Tente novamente.', 'erro');
                                $this->desmarqueCancelar($cdnPaciente, $cdnConsulta);
                                return;
                            }
                        }
                    }
                    
                    $modConsulta = new ModeloConsulta();
                    $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                    $modConsulta->consultaCadastrarSms($dtoConsulta);

                    // Geração de log
                    $this->log(array('sucesso', 'desfazer', 'desmarque', $cdnConsulta));

                    $this->visualizador->setFlash('Desmarque cancelado com sucesso.', 'sucesso');
                    $ctrlConsulta = new ControleConsulta();
                    $ctrlConsulta->consultaConsultarFim($cdnConsulta);
                }else{
                    // Geração de log
                    $this->log(array('erro', 'desfazer', 'desmarque', $cdnConsulta));
                    $this->visualizador->setFlash('Não foi possível cancelar o desmarque.', 'erro');
                    $this->desmarqueCancelar($cdnConsulta);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por avisar quantos desmarques um paciente possui
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function desmarqueAviso($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                if($this->modelo->checaExiste('falta', 'cdnPaciente', $cdnPaciente))
                    $qtdFaltas = $this->modelo->contar('desmarque', array('cdnPaciente' => $cdnPaciente));

                if($this->modelo->checaExiste('desmarque', 'cdnPaciente', $cdnPaciente)){
                    $qtdDesmarques = $this->modelo->contar('desmarque', array('cdnPaciente' => $cdnPaciente));
                    echo 'Possui '.$qtdDesmarques.' desmarques';
                    echo isset($qtdFaltas) ? ' e '.$qtdFaltas.' faltas.' : '.';
                }else{
                    echo isset($qtdFaltas) ? 'Possui '.$qtdFaltas.' faltas.' : '';
                }
            }
        }

    }
