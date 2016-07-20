<?php

    class ControleRetorno extends Controlador{
        public function retornoConsultar(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modRetorno = new ModeloRetorno();
            $sql = $modRetorno->retornoMontaSql();
            
            $arrConsultas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrConsultas', $arrConsultas);
            
            $this->visualizador->atribuirValor('ano', isset($_POST['ano']) ? $_POST['ano'] : date('Y'));
            $this->visualizador->atribuirValor('mes', isset($_POST['mes']) ? $_POST['mes'] : date('m'));
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'tela');
            
            $where = '';
            if(ModeloUsuario::dentista($_SESSION['cdnUsuario'])){
                if(!ModeloUsuario::masterStatic($_SESSION['cdnUsuario'])){
                    $where = ' d.cdnDentista = '.$_SESSION['cdnUsuario'];
                }
            }
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario '.$where;
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);

            $this->visualizador->mostrarNaTela('consultar', 'Relatório de retornos');
        }
        
        public function retornoImprimir(){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');
            
            $this->visualizador->atribuirValor('ano', isset($_POST['ano']) ? $_POST['ano'] : date('Y'));
            $this->visualizador->atribuirValor('mes', isset($_POST['mes']) ? $_POST['mes'] : date('m'));
            $this->visualizador->atribuirValor('dentista', isset($_POST['dentista']) ? $_POST['dentista'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'pdf');
            
            $where = '';
            if(ModeloUsuario::dentista($_SESSION['cdnUsuario'])){
                if(!ModeloUsuario::masterStatic($_SESSION['cdnUsuario'])){
                    $where = ' d.cdnDentista = '.$_SESSION['cdnUsuario'];
                }
            }
            
            $sql = 'select * from dentista d join prophet_main.usuario u on d.cdnUsuario = u.cdnUsuario '.$where;
            $arrDentistas = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrDentistas', $arrDentistas);
            
            $this->visualizador->mostrarNaTela('imprimir', 'Imprimir relatório de de retornos');
        }
        
        public function retornoImprimirFim(){
            $modRetorno = new ModeloRetorno();
            $sql = $modRetorno->retornoMontaSql();
            
            $arrConsultas = $this->modelo->query($sql);
            // Geração de log
            $this->log(array('sucesso', 'impressao', 'retornos'));
            return $modRetorno->retornoImprimirFim($arrConsultas);
        }
    }