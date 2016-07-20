<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * da parceria
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-26
     *
    **/
    class ControleParceria extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro de parceria
         *
         * @return Void.
         *
        **/
        public function parceriaCadastrar(){
            $ctrlPaciente = new ControlePaciente();
            $ctrlMain = new ControleMain();
            
            $this->visualizador->atribuirValor('selectPaciente', $ctrlPaciente->pacienteRetornaSelect(0, 'Indicação de', false));
            $this->visualizador->atribuirValor('selectUsuario', $ctrlMain->mainRetornaSelect(0, 'Indicação de', false));
            $this->visualizador->addJs('js/parceriaVerificacoes.js');
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Parceria');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro da parceria.
         *
         * @return Void.
         *
        **/
        public function parceriaCadastrarFim(){
            $modParceria = new ModeloParceria();
			$arrValidacao = $modParceria->parceriaPreparaDTO();
            $dtoParceria = $arrValidacao[0];
            $mesErro = $arrValidacao[1];

            if($mesErro != ''){
            	$this->visualizador->setFlash($mesErro, 'erro');
            	$this->parceriaCadastrar();
            	return;
            }

            if($modParceria->parceriaCadastrarFim($dtoParceria)){

                $cdnParceria = $modParceria->ultimoInserido('parceria');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'parceria', $cdnParceria));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->parceriaConsultarFim($cdnParceria);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'parceria', $_POST['nomParceria']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->parceriaCadastrar();
                return;

            }
        }

        /**
         * Método utilizado para mostrar a página de atualizar
         * os dados de um parceria.
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        */
        public function parceriaAtualizar($cdnParceria){
            $modParceria = new ModeloParceria();
            if($modParceria->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                $dtoParceria = $modParceria->getParceria($cdnParceria);
                $ctrlPaciente = new ControlePaciente();
                $ctrlMain = new ControleMain();
                $this->visualizador->atribuirValor('selectPaciente', $ctrlPaciente->pacienteRetornaSelect($dtoParceria->getCdnIndicacao(), 'Indicação de', false));
                $this->visualizador->atribuirValor('selectUsuario', $ctrlMain->mainRetornaSelect($dtoParceria->getCdnIndicacao(), 'Indicação de', false));

                $this->visualizador->addJs('js/parceriaVerificacoes.js');
                $this->visualizador->atribuirValor('dtoParceria', $dtoParceria);
    			$this->visualizador->mostrarNaTela('atualizar', 'Atualizar '.$dtoParceria->getNomParceria());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método utilizado para finalizar ação de atualizar
         * parceria
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaAtualizarFim($cdnParceria){
            $modParceria = new ModeloParceria();
            if($modParceria->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
				$arrValidacao = $modParceria->parceriaPreparaDTO($cdnParceria);
	            $dtoParceria = $arrValidacao[0];

	            $mesErro = $arrValidacao[1];

	            if($mesErro != ''){
	            	$this->visualizador->setFlash($mesErro, 'erro');
	            	$this->parceriaAtualizar($cdnParceria);
	            	return;
	            }


	            if($modParceria->parceriaAtualizarFim($dtoParceria)){

	                // Geração de log
	                $this->log(array('sucesso', 'atualizacao', 'parceria', $cdnParceria));

	                $this->visualizador->setFlash(SUCESSO_CADASTRO);
	                $this->parceriaConsultarFim($cdnParceria);
                    return;

	            }else{

	                // Geração de log
	                $this->log(array('erro', 'atualizacao', 'parceria', $cdnParceria));

	                $this->visualizador->setFlash(ERRO_CADASTRO);
	                $this->parceriaAtualizar($cdnParceria);
                    return;

	            }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a lista de parceriaes do sistema
         *
         * @return Void
         *
        **/
        public function parceriaConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addJs('js/parceriaConsultar.js');
            
            $this->visualizador->mostrarNaTela('consultar', 'Lista de Parcerias');
            return;
        }

        /**
         * Método responsável por mostrar o perfil de um
         * parceria.
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        */
        public function parceriaConsultarFim($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
            	$modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($cdnParceria);

                $ctrlPaciente = new ControlePaciente();
                $this->visualizador->atribuirValor('selectPaciente', $ctrlPaciente->pacienteRetornaSelect($dtoParceria->getCdnIndicacao(), 'Indicação de', false));

                $ctrlMain = new ControleMain();
                $this->visualizador->atribuirValor('selectUsuario', $ctrlMain->mainRetornaSelect($dtoParceria->getCdnIndicacao(), 'Indicação de', false));

                $this->visualizador->atribuirValor('dtoParceria', $dtoParceria);
                $this->visualizador->atribuirValor('modParceria', $modParceria);

                $this->visualizador->atribuirValor('arrDependentes', $this->modelo->consultar('dependente', '*', array('cdnResponsavel' => $cdnParceria)));

                $this->visualizador->addJs('js/disableinput.js');
                $this->visualizador->addJs('js/parceriaVerificacoes.js');
                $this->visualizador->mostrarNaTela('consultarFim', $dtoParceria->getNomParceria());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de parceria
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaDeletar($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($cdnParceria);
                $this->visualizador->atribuirValor('dtoParceria', $dtoParceria);
                $this->visualizador->atribuirValor('cdnParceria', $cdnParceria);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar '.$dtoParceria->getNomParceria());

                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção da parceria
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaDeletarFim($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($cdnParceria);
                $dtoParceria->setIndDesvinculada(1);
                if($modParceria->parceriaAtualizarFim($dtoParceria)){
                    $this->visualizador->setFlash('Parceria deletada.', 'sucesso');
                    $this->log(array('sucesso', 'deletar', 'parceria', $cdnParceria));
                    $this->parceriaConsultar();
                }else{
                    $this->visualizador->setFlash('Um erro ocorreu, por favor tente novemente.', 'aviso');
                    $this->log(array('erro', 'deletar', 'parceria', $cdnParceria));
                    $this->parceriaConsultarFim($cdnParceria);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de tabela de preço da parceria
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaPreco($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($cdnParceria);
                $this->visualizador->atribuirValor('dtoParceria', $dtoParceria);

                $arrProcedimentos = array();
                $this->visualizador->atribuirValor('existe', $this->modelo->checaExiste('parceria_preco', 'cdnParceria', $cdnParceria));
                $arrConsulta = $this->modelo->consultar('procedimento', '*', array('indDesvinculado' => 0), 'cdnAreaAtuacao');
                foreach($arrConsulta as $arrProcedimento){
                    $arrProcedimentos[] = $arrProcedimento;
                }
                $this->visualizador->atribuirValor('arrProcedimentos', $arrProcedimentos);

                $sql = 'select * from parceria pa inner join parceria_preco pe on pa.cdnParceria = pe.cdnParceria 
                        where pa.cdnParceria != '.$cdnParceria.' group by pa.cdnParceria';
                $arrParcerias = $modParceria->query($sql);

                $arrTabelasPreco = $modParceria->consultar('tabelapreco');

                $this->visualizador->atribuirValor('arrParcerias', $arrParcerias);
                $this->visualizador->atribuirValor('arrTabelasPreco', $arrTabelasPreco);
                $this->visualizador->atribuirValor('modAreaAtuacao', new ModeloAreaAtuacao());
                $this->visualizador->atribuirValor('modProcedimento', new ModeloProcedimento());
                $this->visualizador->atribuirValor('modParceria', $modParceria);
                $this->visualizador->atribuirValor('cdnParceria', $cdnParceria);
                $this->visualizador->atribuirValor('dtoParceria', $dtoParceria);

                $this->visualizador->addJs('js/parceriaPreco.js');

                $this->visualizador->mostrarNaTela('preco', 'Tabela de preço para '.$dtoParceria->getNomParceria());
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por montar uma tabela de preço
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaPrecoFim($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                $modParceria = new ModeloParceria();
                if($modParceria->parceriaPrecoFim($cdnParceria)){
                    $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                    $this->log(array('sucesso', 'preco', 'parceria', $cdnParceria));
                    $this->parceriaPreco($cdnParceria);
                }else{
                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->log(array('erro', 'preco', 'parceria', $cdnParceria));
                    $this->parceriaPreco($cdnParceria);
                }
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por copiar uma tabela de preço
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Void.
         *
        **/
        public function parceriaPrecoCopiar($cdnParceria){
            if($this->modelo->checaExiste('parceria', 'cdnParceria', $cdnParceria)){
                if(!isset($_POST['copiar'])){
                    $this->visualizador->setFlash('Informe a origem da cópia.', 'erro');
                    $this->parceriaPreco($cdnParceria);
                    return;
                }

                if($_POST['copiar'] == 'parceria'){
                    if(!isset($_POST['cdnParceria'])){
                        $this->visualizador->setFlash('Informe uma parceria válida.', 'erro');
                        $this->parceriaPreco($cdnParceria);
                        return;
                    }
                    if(!$this->modelo->checaExiste('parceria', 'cdnParceria', $_POST['cdnParceria'])){
                        $this->visualizador->setFlash('Informe uma parceria válida.', 'erro');
                        $this->parceriaPreco($cdnParceria);
                        return;
                    }
                    if(!$this->modelo->checaExiste('parceria_preco', 'cdnParceria', $_POST['cdnParceria'])){
                        $this->visualizador->setFlash('Informe uma parceria válida.', 'erro');
                        $this->parceriaPreco($cdnParceria);
                        return;
                    }
                    $this->modelo->deletar('parceria_preco', array('cdnParceria' => $cdnParceria));
                    $precos = $this->modelo->consultar('parceria_preco', '*', array('cdnParceria' => $_POST['cdnParceria']));
                    foreach($precos as $preco){
                        $arrParceriaPreco = array(
                            'cdnParceria' => $cdnParceria,
                            'cdnProcedimento' => $preco['cdnProcedimento'],
                            'valPreco' => $preco['valPreco']
                        );
                        $this->modelo->inserir('parceria_preco', $arrParceriaPreco);
                    }

                }else{
                    if(!isset($_POST['cdnTabelaPreco'])){
                        $this->visualizador->setFlash('Informe uma tabela válida.', 'erro');
                        $this->parceriaPreco($cdnParceria);
                        return;
                    }
                    if(!$this->modelo->checaExiste('tabelapreco', 'cdnTabelaPreco', $_POST['cdnTabelaPreco'])){
                        $this->visualizador->setFlash('Informe uma tabela válida.', 'erro');
                        $this->parceriaPreco($cdnParceria);
                        return;
                    }
                    $this->modelo->deletar('parceria_preco', array('cdnParceria' => $cdnParceria));
                    $precos = $this->modelo->consultar('tabelapreco_procedimento', '*', array('cdnTabelaPreco' => $_POST['cdnTabelaPreco']));
                    foreach($precos as $preco){
                        $arrParceriaPreco = array(
                            'cdnParceria' => $cdnParceria,
                            'cdnProcedimento' => $preco['cdnProcedimento'],
                            'valPreco' => $preco['valPreco']
                        );
                        $this->modelo->inserir('parceria_preco', $arrParceriaPreco);
                    }
                }
                $this->visualizador->setFlash('Tabela copiada com sucesso.', 'sucesso');
                $this->parceriaPreco($cdnParceria);
                return;
            }
            $this->erroExistente();
            return;
        }
    }
