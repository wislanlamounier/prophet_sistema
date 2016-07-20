<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do cronometro
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-11
     *
    **/
    class ControleCronometro extends Controlador{

        /**
         * Método responsável por mostrar a página da sala de espera
         *
         * @return Void.
         *
        **/
        public function cronometroSalaEspera(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $sql = 'SELECT * FROM cronometro WHERE
                    ISNULL(horaEntrada) AND ISNULL(horaSaida)';
            $arrCronometros = $this->modelo->query($sql);

            $this->visualizador->atribuirValor('arrCronometros', $arrCronometros);
            $this->visualizador->atribuirValor('modCronometro', new ModeloCronometro());

            $this->visualizador->mostrarNaTela('salaEspera', 'Sala de espera');
            return;
        }

        /**
         * Método responsável por mostrar a página da sala de espera
         *
         * @return Void.
         *
        **/
        public function cronometroConsultorio(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $sql = 'SELECT * FROM cronometro WHERE
                    !ISNULL(horaEntrada) AND ISNULL(horaSaida)';
            $arrCronometros = $this->modelo->query($sql);

            $this->visualizador->atribuirValor('arrCronometros', $arrCronometros);
            $this->visualizador->atribuirValor('modCronometro', new ModeloCronometro());

            $this->visualizador->mostrarNaTela('consultorio', 'Em atendimento');
            return;
        }

        /**
         * Método responsável por mostrar a página de cadastro de chegada de paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente (opcional)
         * @param Integer $cdnConsulta - código numérico da consulta (opcional)
         * @return Void.
         *
        **/
        public function cronometroChegada($cdnPaciente = 0, $cdnConsulta = 0){
            if(!$this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente))
                $cdnPaciente = 0;
            $ctrlPaciente = new ControlePaciente();
            $selectPaciente = $ctrlPaciente->pacienteRetornaSelect($cdnPaciente, 'Paciente', false);

            $this->visualizador->atribuirValor('selectPaciente', $selectPaciente);

            $this->visualizador->atribuirValor('cdnConsulta', $cdnConsulta);

            $this->visualizador->mostrarNaTela('chegada', 'Registrar Chegada');
            return;
        }

        /**
         * Método responsável por finalizar a ação de registrar a chegada
         *
         * @param Integer $cdnConsulta - código numérico da consulta (opcional).
         * @return Void.
         *
        **/
        public function cronometroChegadaFim($cdnConsulta = 0){
            $modCronometro = new ModeloCronometro();
            $dtoCronometro = $modCronometro->cronometroChegadaDTO($cdnConsulta);
            $mesErro = $dtoCronometro[1];
            $dtoCronometro = $dtoCronometro[0];

            if($mesErro != ''){
                $this->visualizador->setFlash($mesErro, 'erro');
                $this->cronometroChegada();
                return;
            }

            if($modCronometro->cronometroCadastrarFim($dtoCronometro)){

                $this->log(array('sucesso', 'cadastro', 'chegada', $dtoCronometro->getHoraChegada()));

                $this->visualizador->setFlash('Chegada registrada com sucesso.', 'sucesso');
                $this->cronometroSalaEspera();
                return;

            }else{
                $this->log(array('erro', 'cadastro', 'chegada', $dtoCronometro->getHoraChegada()));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->cronometroChegada();
                return;
            }
        }

        /**
         * Método responsável por mostrar a página de confirmação de entrada em consultório
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroEntrada($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $this->visualizador->atribuirValor('cdnCronometro', $cdnCronometro);
                $this->visualizador->mostrarNaTela('entrada', 'Confirmação de entrada em consultório');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a ação de confirmação de entrada em consultório
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroEntradaFim($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $modCronometro = new ModeloCronometro();
                $dtoCronometro = $modCronometro->cronometroEntradaDTO($cdnCronometro);

                if($modCronometro->cronometroAtualizarFim($dtoCronometro)){

                    $this->log(array('sucesso', 'cadastro', 'entrada', $dtoCronometro->getHoraEntrada()));

                    $this->visualizador->setFlash('Entrada em consultório registrada com sucesso.', 'sucesso');
                    $this->cronometroSalaEspera();
                    return;

                }else{
                    $this->log(array('erro', 'cadastro', 'entrada', $dtoCronometro->getHoraEntrada()));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->cronometroEntrada($cdnCronometro);
                    return;
                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por registrar a saída do consultório do cronômetro
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroSaida($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $this->visualizador->atribuirValor('cdnCronometro', $cdnCronometro);
                $this->visualizador->mostrarNaTela('saida', 'Confirmação de saída de consultório');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a ação de confirmação de entrada em consultório
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroSaidaFim($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $modCronometro = new ModeloCronometro();
                $dtoCronometro = $modCronometro->cronometroSaidaDTO($cdnCronometro);
                
                if($modCronometro->cronometroAtualizarFim($dtoCronometro)){

                    $this->log(array('sucesso', 'cadastro', 'entrada', $dtoCronometro->getHoraSaida()));

                    $this->visualizador->setFlash('Saída de consultório registrada com sucesso.', 'sucesso');
                    $this->cronometroConsultorio();
                    return;

                }else{
                    $this->log(array('erro', 'cadastro', 'entrada', $dtoCronometro->getHoraSaida()));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->cronometroSaida($cdnCronometro);
                    return;
                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por deletar o cronometro
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroDeletar($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $this->visualizador->atribuirValor('cdnCronometro', $cdnCronometro);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar registro');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do cronometro
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroDeletarFim($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $this->modelo->deletar('cronometro', array('cdnCronometro' => $cdnCronometro));
                $this->visualizador->setFlash(SUCESSO_DELETAR, 'sucesso');
                $this->cronometroSalaEspera();
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de confirmação de volta para sala de espera
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroVoltar($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $this->visualizador->atribuirValor('cdnCronometro', $cdnCronometro);
                $this->visualizador->mostrarNaTela('voltar', 'Voltar para sala de espera');
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por voltar um paciente de atendimento para a sala de espera
         *
         * @param Integer $cdnCronometro - código numérico do cronometro
         * @return Void.
         *
        **/
        public function cronometroVoltarFim($cdnCronometro){
            if($this->modelo->checaExiste('cronometro', 'cdnCronometro', $cdnCronometro)){
                $modCronometro = new ModeloCronometro();
                if($modCronometro->cronometroVoltarFim($cdnCronometro)){
                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');

                    $this->log(array('sucesso', 'voltar', 'cronometro', $cdnCronometro));
                    $this->cronometroConsultorio();
                    return;
                }else{
                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');

                    $this->log(array('erro', 'voltar', 'cronometro', $cdnCronometro));
                    $this->cronometroConsultorio();
                    return;
                }
            }
            $this->erroExistente();
            return;
        }
 
    }