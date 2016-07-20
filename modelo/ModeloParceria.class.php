<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a parceria.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-26
     *
    **/
    class ModeloParceria extends Modelo{
        use Transformacao;
        use Validacao;

        /**
         * Método utilizado para retornar o objeto DTO
         * da parceria requisitada
         *
         * @param Integer $cdnParceria - código numérico da parceria
         * @return Object - objeto DTO da parceria
         *
        **/
        public function getParceria($cdnParceria){
            return $this->getRegistro('parceria', 'cdnParceria', $cdnParceria);
        }

        /**
         * Método utilizado para atualizar as informações da parceria
         *
         * @param Object $dtoParceria - objeto DTO da parceria
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function parceriaAtualizarFim(DTOParceria $dtoParceria){

            $dados = $dtoParceria->getArrayBanco();
            return $this->atualizar('parceria', $dados, array('cdnParceria' => $dtoParceria->getCdnParceria()));

        }

        /**
         * Método utilizado para preencher o DTO da parceria para cadastro.
         *
         * @param Boolean $cdnParceria - código numérico da parceria (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function parceriaPreparaDTO($cdnParceria = 0){
            $mesErro = '';
        	if($cdnParceria == 0){
                // está cadastrando
        		$dtoParceria = new DTOParceria();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('parceria', 'cdnParceria', $cdnParceria))
                    return array(new DTOParceria(), 'Registro não existente.');
                $dtoParceria = $this->getParceria($cdnParceria);
        	}

            $arrValidacao = array(
                    'codCep' => '',
                    'codCpfCnpj' => 'Informe um CPF/CNPJ válido.',
                    'codIe' => '',
                    'codUf' => 'Informe um estado válido.',
                    'datContrato' => 'Informe uma data de contrato válida.',
                    'desParceria' => '',
                    'indFisica' => '',
                    'nomCidade' => '',
                    'nomParceria' => array('Informe o nome da parceria.'),
                    'nomRepresentante' => '',
                    'numContrato' => '',
                    'numRepresentanteTelefone' => '',
                    'numTelefone1' => '',
                    'numTelefone2' => '',
                    'strEmail' => 'Informe um e-mail válido.',
                    'strEndereco' => '',
                    'strRepresentanteEmail' => 'Informe um e-mail válido para o representante.'
            );

            if(isset($_POST['indPaciente'])){
                if($_POST['indPaciente']){
                    if(isset($_POST['cdnPaciente'])){
                        if($_POST['cdnPaciente'] != ''){
                            if(!$this->checaExiste('paciente', 'cdnPaciente', $_POST['cdnPaciente'])){
                                $mesErro .= 'Informe um indicador válido para a parceria.<br>';
                            }
                            $dtoParceria->SetCdnIndicacao($_POST['cdnPaciente']);
                        }
                    }
                }else{
                    if(isset($_POST['cdnUsuario'])){
                        if($_POST['cdnUsuario'] != ''){
                            $modMain = new ModeloMain(true);
                            if(!$modMain->checaExiste('usuario', 'cdnUsuario', $_POST['cdnUsuario'])){
                                $mesErro .= 'Informe um indicador válido para a parceria.<br>';
                            }
                            $dtoParceria->SetCdnIndicacao($_POST['cdnUsuario']);
                        }
                    }
                }
                $dtoParceria->SetIndPaciente($_POST['indPaciente']);
            }

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoParceria->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

            if($cdnParceria == 0){
                $dtoParceria->setIndDesvinculada(0);
            }

			return array($dtoParceria, $mesErro);
        }

        /**
         * Método utilizado para registrar a parceria
         * no banco de dados
         *
         * @param Object $dtoParceria - objeto DTO da parceria
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function parceriaCadastrarFim(DTOParceria $dtoParceria){

                $dadosFinais = $dtoParceria->getArrayBanco();
                return $this->inserir('parceria', $dadosFinais);

        }

        /**
         * Método responsável por cadastrar a tabela de preço na parceria
         *
         * @param Integer $cdnParceria - código numérico da parceria.
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function parceriaPrecoFim($cdnParceria){
            $novo = !$this->checaExiste('parceria_preco', 'cdnParceria', $cdnParceria);
            if(!$novo)
                $arrPrecos = $this->consultar('parceria_preco', '*', array('cdnParceria' => $cdnParceria));

            $finalizou = true;
            foreach($_POST as $cdnProcedimento=>$valPreco){
                $valPreco = $this->transformacaoDecimal($valPreco);
                if($this->validacaoDecimal($valPreco)){

                    $arrCond = array('cdnProcedimento' => $cdnProcedimento,
                                     'conscond1' => 'AND',
                                     'cdnParceria' => $cdnParceria);

                    $arrPrecos = $this->consultar('parceria_preco', '*', $arrCond);

                    $arrDados = array('cdnParceria' => $cdnParceria,
                                      'cdnProcedimento' => $cdnProcedimento,
                                      'valPreco' => $valPreco);
                    if(count($arrPrecos) > 0){
                        if(!$this->atualizar('parceria_preco', $arrDados, array('cdnPreco' => $arrPrecos[0]['cdnPreco'])))
                            $finalizou = false;
                    }else{
                        if(!$this->inserir('parceria_preco', $arrDados))
                            $finalizou = false;
                    }
                }else{
                    $finalizou = false;
                }

            }
            if(!$finalizou){
                $this->deletar('parceria_preco', array('cdnParceria' => $cdnParceria));
                if(!$novo){
                    foreach($arrPrecos as $arrPreco){
                        $this->inserir('parceria_preco', $arrPreco);
                    }
                }
                return false;
            }
            return true;
        }
    }
