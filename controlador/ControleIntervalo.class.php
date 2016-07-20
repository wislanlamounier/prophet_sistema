<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do intervalo
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2016-02-01
     *
    **/
    class ControleIntervalo extends Controlador{

        public function intervaloCadastrar($cdnDentista){
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');


                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($cdnDentista);
                $this->visualizador->atribuirValor('cdnDentista', $cdnDentista);

                $this->visualizador->addJs('js/intervaloCadastrar.js');
                $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar intervalo para '.$arrUsuario['nomUsuario']);
                return;
            }
            $this->erroExistente();
            return;
        }

        public function intervaloCadastrarFim($cdnDentista){
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $modIntervalo = new ModeloIntervalo();
                $arrValidacao = $modIntervalo->intervaloPreparaDTO();
                $dtoIntervalo = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->intervaloCadastrar($cdnDentista);
                    return;
                }

                $dtoIntervalo->setCdnDentista($cdnDentista);

                if($modIntervalo->intervaloCadastrarFim($dtoIntervalo)){

                    $cdnIntervalo = $modIntervalo->ultimoInserido('dentista_intervalo');

                    // Geração de log
                    $this->log(array('sucesso', 'cadastro', 'intervalo', $cdnIntervalo));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->intervaloConsultar($cdnDentista);
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'cadastro', 'intervalo', $cdnDentista));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->intervaloCadastrar($cdnDentista);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        public function intervaloAtualizar($cdnIntervalo){
            if($this->modelo->checaExiste('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo)){
                $this->visualizador->addCss('tema/css/plugins/datapicker/datepicker3.css');
                $this->visualizador->addJs('tema/js/plugins/fullcalendar/moment.min.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.js');
                $this->visualizador->addJs('tema/js/plugins/datapicker/bootstrap-datepicker.pt-BR.js');


                $modIntervalo = new ModeloIntervalo();
                $dtoIntervalo = $modIntervalo->getIntervalo($cdnIntervalo);
                $this->visualizador->atribuirValor('dtoIntervalo', $dtoIntervalo);

                $this->visualizador->addJs('js/intervaloCadastrar.js');
                $this->visualizador->mostrarNaTela('atualizar', 'Atualizar intervalo');
                return;
            }
            $this->erroExistente();
            return;
        }

        public function intervaloAtualizarFim($cdnIntervalo){
            if($this->modelo->checaExiste('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo)){
                $modIntervalo = new ModeloIntervalo();
                $arrValidacao = $modIntervalo->intervaloPreparaDTO($cdnIntervalo);
                $dtoIntervalo = $arrValidacao[0];
                $mesErro = $arrValidacao[1];

                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->intervaloAtualizar($cdnIntervalo);
                    return;
                }

                if($modIntervalo->intervaloAtualizarFim($dtoIntervalo)){

                    // Geração de log
                    $this->log(array('sucesso', 'atualizar', 'intervalo', $cdnIntervalo));

                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->intervaloConsultar($dtoIntervalo->getCdnDentista());
                    return;

                }else{

                    // Geração de log
                    $this->log(array('erro', 'atualizar', 'intervalo', $cdnIntervalo));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->intervaloAtualizar($cdnIntervalo);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        public function intervaloConsultar($cdnDentista){
            if($this->modelo->checaExiste('dentista', 'cdnUsuario', $cdnDentista)){
                $arrIntervalos = $this->modelo->consultar('dentista_intervalo', '*', array('cdnDentista' => $cdnDentista), 'indPermanente DESC');
                $modIntervalo = new ModeloIntervalo();
                $this->visualizador->atribuirValor('arrIntervalos', $arrIntervalos);
                $this->visualizador->atribuirValor('modIntervalo', $modIntervalo);
                
                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($cdnDentista);
                $this->visualizador->atribuirValor('cdnDentista', $cdnDentista);
                $this->visualizador->mostrarNaTela('consultar', 'Intervalos de '.$arrUsuario['nomUsuario']);
                return;
            }
            $this->erroExistente();
            return;
        }

        public function intervaloDeletar($cdnIntervalo){
            if($this->modelo->checaExiste('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo)){
                $modIntervalo = new ModeloIntervalo();
                $dtoIntervalo = $modIntervalo->getIntervalo($cdnIntervalo);
                $this->visualizador->atribuirValor('dtoIntervalo', $dtoIntervalo);

                $modMain = new ModeloMain(true);
                $arrUsuario = $modMain->getUsuario($dtoIntervalo->getCdnDentista());
                $this->visualizador->atribuirValor('arrUsuario', $arrUsuario);

                $this->visualizador->mostrarNaTela('deletar', 'Deletar intervalo');
            }
        }

        public function intervaloDeletarFim($cdnIntervalo){
            if($this->modelo->checaExiste('dentista_intervalo', 'cdnIntervalo', $cdnIntervalo)){
                $modIntervalo = new ModeloIntervalo();
                $dtoIntervalo = $modIntervalo->getIntervalo($cdnIntervalo);

                if($modIntervalo->intervaloDeletarFim($cdnIntervalo)){
                    $this->log(array('sucesso', 'deletar', 'intervalo', $dtoIntervalo->getCdnDentista()));

                    $this->visualizador->setFlash('Intervalo deletado com sucesso.', 'sucesso');

                    $this->intervaloConsultar($dtoIntervalo->getCdnDentista());
                }else{
                    $this->log(array('erro', 'deletar', 'intervalo', $cdnIntervalo));

                    $this->visualizador->setFlash('Algum problema ocorreu.', 'erro');

                    $this->intervaloDeletar($cdnIntervalo);

                }
                return;
            }
            $this->erroExistente();
            return;
        }

    }