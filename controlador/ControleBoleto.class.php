<?php
    class ControleBoleto extends Controlador{
        // Banrisul : 041


        public function boletoGerar(){
            if(func_num_args() < 3){
                return $this->erroExistente();
        	}

            $valor = func_get_args()[0];
        	$origem = func_get_args()[1];
        	$cdnPaciente = func_get_args()[2];
            $arrPaciente = $this->modelo->consultar('paciente', '*', array('cdnPaciente' => $cdnPaciente));
            if(count($arrPaciente) == 0){
                return $this->erroExistente();
            }
            $arrPaciente = $arrPaciente[0];
            if(isset($arrPaciente['nomSobrenome']))
                $arrPaciente['nomPaciente'] .= ' '.$arrPaciente['nomSobrenome'];

            $argumentos = array();
            $argumentosUrl = '';
        	for($i = 3; $i < func_num_args(); $i++){
                $argumentos[] = func_get_args()[$i];
                $argumentosUrl .= '/'.func_get_args()[$i];
        	}
            $this->visualizador->atribuirValor('argumentos', $argumentos);
            $this->visualizador->atribuirValor('argumentosUrl', $argumentosUrl);

            $this->visualizador->atribuirValor('origem', $origem);
            $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
            $this->visualizador->atribuirValor('valorBoleto', $valor);
            return $this->visualizador->mostrarNaTela('gerar', 'Geração de boleto');
        }

        public function boletoGerarFim(){
            if(func_num_args() < 3){
        		return false;
        	}
            $valor = func_get_args()[0];
        	$tipo = func_get_args()[1];
        	$cdnPaciente = func_get_args()[2];
            $argumentos = array();
        	for($i = 3; $i < func_num_args(); $i++){
                $argumentos[] = func_get_args()[$i];
        	}

            $modBoleto = new ModeloBoleto();
            $retorno = $modBoleto->boletoGerarFim($valor, $tipo, $cdnPaciente, $argumentos);
            if(!is_array($retorno)){
                $this->log(array('sucesso', 'geracao', 'boleto', $cdnPaciente.' - '.$tipo));
            }else{
                $this->log(array('erro', 'geracao', 'boleto', $cdnPaciente.' - '.$tipo));
                $this->visualizador->setFlash($retorno[1], 'erro');
                return $this->inicio();
            }
        }

        public function boletoMontaFormulario($banco){
            $modBoleto = new ModeloBoleto(true);
            $modBoleto->boletoMontaFormulario($banco);
        }

        public function boletoHistorico($cdnPaciente = null){
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addCss('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
            $this->visualizador->addJs('js/pacienteSelect.js');
            $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

            $modBoleto = new ModeloBoleto();
            $sql = $modBoleto->boletoMontaSql($cdnPaciente, true);

            $arrBoletos = $this->modelo->query($sql);
            $this->visualizador->atribuirValor('arrBoletos', $arrBoletos);

            $this->visualizador->atribuirValor('origem', isset($_POST['origem']) ? $_POST['origem'] : null);
            $this->visualizador->atribuirValor('datas', isset($_POST['datas']) ? $_POST['datas'] : null);

            // Define a variável para o filtro de SMS saber qual função está sendo executada
            // visualizador/sms/filtro.inc.php
            $this->visualizador->atribuirValor('tipoFiltro', 'historico');

            $this->visualizador->mostrarNaTela('historico', 'Histórico de boletos');
        }


    }
