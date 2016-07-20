<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o colaborador.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-10
     *
    **/
    class ModeloColaborador extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do usuário requisitado
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getColaborador($cdnUsuario){
            return $this->getRegistro('colaborador', 'cdnUsuario', $cdnUsuario);
        }

        /**
         * Método utilizado para atualizar as informações do colaborador
         *
         * @param Object $dtoColaborador - objeto DTO do colaborador
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function colaboradorAtualizarFim(DTOColaborador $dtoColaborador){

            $modMain = new ModeloMain(true);
            if($modMain->mainAtualizarUsuario($dtoColaborador->getCdnUsuario())){
                $dados = $dtoColaborador->getArrayBanco();
                return $this->atualizar('colaborador', $dados, array('cdnUsuario' => $dtoColaborador->getCdnUsuario()));
            }else{
                return false;
            }

        }

        /**
         * Método utilizado para preencher o DTO do colaborador para cadastro.
         *
         * @param Boolean $cdnUsuario - código numérico do usuário (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function colaboradorPreparaDTO($cdnUsuario = 0){
            $modMain = new ModeloMain(true);
            $mesErro = '';
        	if($cdnUsuario == 0){
                // está cadastrando
        		$dtoColaborador = new DTOColaborador();
                if($modMain->mainChecaExisteEmail())
                    $mesErro .= 'Este e-mail já está cadastrado no sistema.<br>';
        	}else{
                // está atualizando
        		if(!$this->checaExiste('colaborador', 'cdnUsuario', $cdnUsuario))
                    return array(new DTOColaborador(), 'Registro não existente.');

    			$dtoColaborador = $this->getColaborador($cdnUsuario);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                if($_POST['strEmail'] != $arrUsuario['strEmail']){
                    if($modMain->mainChecaExisteEmail())
                        $mesErro .= 'Este e-mail já está cadastrado no sistema.<br>';
                }
        	}


            $arrValidacao = array(
                'codCep' => '',
                'codCpf' => 'Informe um CPF válido.',
                'codUf' => 'Informe um estado válido.',
                'datNascimento' => 'Informe uma data de nascimento válida.',
                'datAdmissao' => 'Informe uma data de admissão válida.',
                'desColaborador' => '',
                'indPorcentagem' => '',
                'nomCidade' => '',
                'numTelefone1' => '',
                'numTelefone2' => '',
                'strEndereco' => '',
                'valRemuneracao' => 'Informe uma remuneração válida.'
            );

            if(isset($_POST['strSenha'])){
                if(!isset($_POST['confSenha'])){
                    $mesErro .= 'Senhas não conferem.';
                }else{
                    if(trim($_POST['strSenha']) != '' or trim($_POST['confSenha']) != ''){
                        if($_POST['strSenha'] != $_POST['confSenha'])
                            $mesErro .= 'Senhas não conferem. <br>';
                    }else{
                        if($cdnUsuario == 0)
                            $mesErro .= 'Informe a senha. <br>';
                    }
                }
            }

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if($nomCampo == 'indPorcentagem'){
                    $dtoColaborador->setIndPorcentagem(isset($_POST['indPorcentagem']));
                    continue;
                }

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoColaborador->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoColaborador, $mesErro);
        }

        /**
         * Método utilizado para registrar o colaborador
         * no banco de dados
         *
         * @param Object $dtoColaborador - objeto DTO do colaborador
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function colaboradorCadastrarFim(DTOColaborador $dtoColaborador){

            $modMain = new ModeloMain(true);
            $cdnUsuarioMain = $modMain->mainCadastrarUsuario();
            if($cdnUsuarioMain !== false){
                $dtoColaborador->setCdnUsuario($cdnUsuarioMain);
                $dadosFinais = $dtoColaborador->getArrayBanco();
                if($this->inserir('colaborador', $dadosFinais)){
                    return true;
                }else{
                    $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuarioMain));
                    return false;
                }
            }
            return false;

        }
    }
