<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da falta
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-21
     *
    **/
    class ControleFalta extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de falta
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function faltaCadastrar($cdnPaciente, $cdnConsulta){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente) and
               $this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta) and
              !$this->modelo->checaExiste('falta', 'cdnConsulta', $cdnConsulta)){

                $modPaciente = new ModeloPaciente();
                $modConsulta = new ModeloConsulta();

                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);

                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->atribuirValor('dtoConsulta', $dtoConsulta);

                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->mostrarNaTela('cadastrar', 'Marcar Falta');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da falta.
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function faltaCadastrarFim($cdnPaciente, $cdnConsulta){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente) and
               $this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta) and
              !$this->modelo->checaExiste('falta', 'cdnConsulta', $cdnConsulta)){
                $modFalta = new ModeloFalta();
                $dtoFalta = new DTOFalta();

                $dtoFalta->setCdnPaciente($cdnPaciente);
                $dtoFalta->setCdnConsulta($cdnConsulta);

                if($modFalta->faltaCadastrarFim($dtoFalta)){
                    
                    $modConsulta = new ModeloConsulta();
                    $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                    $modConsulta->consultaCancelarSms($dtoConsulta);

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'falta', $cdnConsulta));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');

                    $ctrlConsulta = new ControleConsulta();
                    $ctrlConsulta->consultaConsultarFim($cdnConsulta);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'falta', $cdnConsulta));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->faltaCadastrar($cdnPaciente, $cdnConsulta);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por desfazer a falta
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function faltaDesmarcar($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){
                $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);
                $this->visualizador->mostrarNaTela('desmarcar', 'Desmarcar falta');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a ação de desfazer a falta
         *
         * @param Integer $cdnConsulta - código numérico da consulta
         * @return Void.
         *
        **/
        public function faltaDesmarcarFim($cdnConsulta){
            if($this->modelo->checaExiste('consulta', 'cdnConsulta', $cdnConsulta)){

                $modConsulta = new ModeloConsulta();
                $dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
                $modConsulta->consultaCadastrarSms($dtoConsulta);

                // Geração de log
                $this->log(array('sucesso', 'desfazer falta', 'falta', $cdnConsulta));

                $this->modelo->deletar('falta', array('cdnConsulta' => $cdnConsulta));
                $this->visualizador->setFlash('Falta desmarcada com sucesso.', 'sucesso');
                $ctrlConsulta = new ControleConsulta();
                $ctrlConsulta->consultaConsultarFim($cdnConsulta);
                return;
            }
            $this->erroExistente();
            return;
        }

    }
