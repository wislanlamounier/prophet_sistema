<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o estilo.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-24
     *
    **/
    class ModeloEstilo extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do estilo requisitado
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getEstilo($cdnUsuario = 0){
            if($cdnUsuario == 0)
                $cdnUsuario = $_SESSION['cdnUsuario'];
            return $this->getRegistro('estilo', 'cdnUsuario', $cdnUsuario);
        }

        /**
         * Método utilizado para atualizar as informações do estilo
         *
         * @param Object $dtoEstilo - objeto DTO do estilo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function estiloAtualizarFim(DTOEstilo $dtoEstilo){

            $dados = $dtoEstilo->getArrayBanco();
            if($this->atualizar('estilo', $dados, array('cdnUsuario' => $dtoEstilo->getCdnUsuario()))){
                $_SESSION['dtoEstilo'] = serialize($dtoEstilo);
                return true;
            }
            return false;

        }

        /**
         * Método utilizado para preencher o DTO do estilo para cadastro.
         *
         * @param Boolean $cdnUsuario - código numérico do usuário (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function estiloPreparaDTO($cdnUsuario = 0){
            $mesErro = '';
        	if($cdnUsuario == 0){
                // está cadastrando
        		$dtoEstilo = new DTOEstilo();
        	}else{
                // está atualizando
        		if(!$this->checaExiste('estilo', 'cdnUsuario', $cdnUsuario))
                    return array(new DTOEstilo(), 'Registro não existente.');
                $dtoEstilo = $this->getEstilo($cdnUsuario);
        	}

            $arrValidacao = array(
                'nomSkin' => '',
                'nomFundoConteudo' => '',
                'nomFundoHeader' => '',
                'nomBotaoPrimario' => '',
                'nomBotaoSucesso' => ''
            );

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
            	$nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo])){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoEstilo->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

            $dtoEstilo->setCdnUsuario($_SESSION['cdnUsuario']);

			return array($dtoEstilo, $mesErro);
        }

        /**
         * Método utilizado para registrar o estilo
         * no banco de dados
         *
         * @param Object $dtoEstilo - objeto DTO do estilo
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function estiloCadastrarFim(DTOEstilo $dtoEstilo){

                $dadosFinais = $dtoEstilo->getArrayBanco();
                if($this->inserir('estilo', $dadosFinais)){
                    $_SESSION['dtoEstilo'] = serialize($dtoEstilo);
                    return true;
                }
                return false;

        }
    }
