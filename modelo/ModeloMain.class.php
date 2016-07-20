<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o usuário.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-07
     *
    **/
    class ModeloMain extends Modelo{
        use Validacao;

        /**
         * Método responsável por retornar o array do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Array - array do usuário
         *
        **/
        public function getUsuario($cdnUsuario){
            $arrCond = array('cdnUsuario' => $cdnUsuario);
            return $this->consultar('usuario', '*', $arrCond)[0];
        }

        /**
         * Método responsável por retornar o DTO das configurações
         *
         * @return Object - DTO das configurações
         *
        **/
        public function getConfiguracoes($cdnClinica = 0){
            if($cdnClinica == 0)
                $cdnClinica = $_SESSION['cdnClinica'];
            return $this->getRegistro('configuracoes', 'cdnClinica', $cdnClinica);
        }

        public function getBackup($cdnBackup){
            return $this->getRegistro('backup', 'cdnBackup', $cdnBackup);
        }

        /**
         * Método utilizado para registrar o usuário
         * no banco de dados
         *
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function mainCadastrarUsuario(){

            if(!$this->mainVerificacao())
                return false;

            $dados = array();
            $dados['cdnClinica'] = $_SESSION['cdnClinica'];
            $dados['strEmail'  ] = $_POST['strEmail'];
            $dados['strSenha'  ] = $_POST['strSenha'];
            $dados['nomUsuario'] = $_POST['nomUsuario'];

            if($this->inserir('usuario', $dados)){
                $cdnUsuario = $this->ultimoInserido('usuario');
                $dados = array();
                $dados['cdnUsuario'] = $cdnUsuario;
                $dados['strPermissao'] = '';
                $this->inserir('usuario_permissao', $dados);


                return $cdnUsuario;
            }else{
                return false;
            }

        }

        /**
         * Método utilizado para registrar o usuário
         * no banco de dados
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function mainAtualizarUsuario($cdnUsuario){

            if(!$this->mainVerificacao($cdnUsuario))
                return false;

            $dados = $this->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
            $dados['strEmail'] = $_POST['strEmail'];
            if(isset($_POST['strSenha'])){
                if(trim($_POST['strSenha']) != '')
                    $dados['strSenha'] = $_POST['strSenha'];
            }
            $dados['nomUsuario'] = $_POST['nomUsuario'];

            if($_SESSION['cdnUsuario'] == $cdnUsuario){
                $_SESSION['nomUsuario'] = $dados['nomUsuario'];
                $_SESSION['strEmail'  ] = $dados['strEmail'];
            }

            return $this->atualizar('usuario', $dados, array('cdnUsuario' => $cdnUsuario));

        }

        /**
         * Método responsável por realizar a verificação dos dados para inserção/atualização
         *
         * @param Integer $cdnUsuario - código numérico do usuário. Não informar em caso de cadastro.
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function mainVerificacao($cdnUsuario = 0){

            if($cdnUsuario != 0)
                if(!$this->checaExiste('usuario', 'cdnUsuario', $cdnUsuario))
                    return false;

            if(!$this->validacaoEmail($_POST['strEmail']))
                return false;

            if(!$this->validacaoEspeciais($_POST['strSenha']))
                return false;

            if(!$this->validacaoEspeciais($_POST['nomUsuario']))
                return false;

            return true;
        }

        /**
         * Método responsável por verificar se o e-mail selecionado já existe no sistema
         *
        **/
        public function mainChecaExisteEmail(){
            if(filter_var($_POST['strEmail'], FILTER_VALIDATE_EMAIL))
                return $this->checaExiste('usuario', 'strEmail', $_POST['strEmail']);
            else
                return false;
        }

        /**
         * Método utilizado para verificação do login do usuário
         *
         * @return Boolean - true se sucesso, false se não.
         *
        **/
        public function mainLoginFim(){
            $false = 'Dados não conferem.';
            if(!isset($_POST['strSenha']))
                return $false;
            if(!isset($_POST['strEmail']))
                return $false;


            $condicao = array('strEmail'  => $_POST['strEmail'],
                              'conscond1' => 'AND',
                              'strSenha'  => $_POST['strSenha']);
            $consulta = $this->consultar('usuario', '*', $condicao);
            if(count($consulta) == 1){
                $modClinica = new ModeloClinica(true);
                $dtoClinica = $modClinica->getClinica($consulta[0]['cdnClinica']);


                $_SESSION['cdnUsuario'] = $consulta[0]['cdnUsuario'];
                $_SESSION['strEmail'  ] = $_POST['strEmail'];
                $_SESSION['cdnClinica'] = $consulta[0]['cdnClinica'];
                $_SESSION['nomUsuario'] = $consulta[0]['nomUsuario'];
                $_SESSION['nomBanco'] = $dtoClinica->getNomBanco();
                $_SESSION['nomClinica'] = $dtoClinica->getNomClinica();


                if($dtoClinica->getIndDesativada()){
                    unset($_SESSION['cdnUsuario']);
                    unset($_SESSION['strEmail']);
                    unset($_SESSION['cdnClinica']);
                    unset($_SESSION['nomUsuario']);
                    unset($_SESSION['nomBanco']);
                    unset($_SESSION['nomClinica']);
                    return 'Esta clínica foi desativada.';
                }


                $modelo = new Modelo(false, true, 'prophet_'.$_SESSION['nomBanco']);
                $usuAtual = $modelo->usuarioAtual($consulta[0]['cdnUsuario']);

                $modEstilo = new ModeloEstilo(true);
                $_SESSION['dtoEstilo'] = serialize($modEstilo->getEstilo($_SESSION['cdnUsuario']));

                if($usuAtual == 'master') {
                    if(Modelo::dentista($_SESSION['cdnUsuario']))
                        $usuAtual = 'dentista';
                    elseif(Modelo::colaborador($_SESSION['cdnUsuario']))
                        $usuAtual = 'colaborador';
                    
                    $_SESSION['master'] = true;
                }

                if($usuAtual == 'colaborador'){
                    $modColaborador = new ModeloColaborador(false, true, 'prophet_'.$_SESSION['nomBanco']);
                    $dtoColaborador = $modColaborador->getColaborador($consulta[0]['cdnUsuario']);
                    if($dtoColaborador->getIndDesativado())
                        return $false;
                }

                if($usuAtual == 'dentista'){
                    $modDentista = new ModeloDentista(false, true, 'prophet_'.$_SESSION['nomBanco']);
                    $dtoDentista = $modDentista->getDentista($consulta[0]['cdnUsuario']);
                    if($dtoDentista->getIndDesativado())
                        return $false;
                }

                $usuAtual = $usuAtual == 'master' ? 'usuario' : $usuAtual;
                $_SESSION['usuAtual'] = $usuAtual;


                return true;
            }
            return $false;
        }


        /**
         * Método responsável por retornar um select de usuários
         *
         * @param Integer $cdnUsuario - código numérico do usuário para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Usuário.
         * @param String $classe - classe do input. Padrão: iptCdnUsuario.
         * @param String $nome - nome do input. Padrão: cdnUsuario.
         * @return String - select de usuário
         *
        **/
        public function mainRetornaSelect($cdnUsuario = 0, $label = 'Usuario', $classe = 'iptCdnUsuario', $nome = 'cdnUsuario'){
            $arrUsuarios = $this->consultar('usuario', '*', array('cdnClinica' => $_SESSION['cdnClinica']), 'nomUsuario');
            $select = '';
            $select .='<div class="form-group">
                           <label class="control-label" for="'.$nome.'">'.$label.'</label>';
            $select .= '
                <select name="'.$nome.'" class="form-control '.$classe.'">
                <option id="optPadrao" value="">'.$label.'</option>'.PHP_EOL;
            foreach($arrUsuarios as $arrUsuario){
                if($arrUsuario['cdnUsuario'] == $cdnUsuario)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option '.$selected.' value="'.$arrUsuario['cdnUsuario'].'">'.$arrUsuario['nomUsuario'].'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }

        /**
         * Método responsável por alterar as configurações
         *
        **/
        public function mainConfiguracoesFim(){
            $mesErro = '';

            // Ignorar até fazer os boletos
            if(false) {
                $modBoleto = new ModeloBoleto(true);
                if (!$modBoleto->boletoAtualizarConfiguracoes()) {
                    $mesErro = 'Não foi possível atualizar as configurações de boleto bancário.';
                }
            }
            
            $atualizar = false;
            if($this->checaExiste('configuracoes', 'cdnClinica', $_SESSION['cdnClinica'])){
                $dtoConfiguracoes = $this->getConfiguracoes();
                $atualizar = true;
            }else{
                $dtoConfiguracoes = new DTOConfiguracoes();
                $dtoConfiguracoes->setCdnClinica($_SESSION['cdnClinica']);
            }

            $arrValidacao = array(
                'valJurosOrcamento' => array('Informe a taxa de juros para os orcamentos.')
            );


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
                if(!$dtoConfiguracoes->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            if($mesErro != '')
                return array($dtoConfiguracoes, $mesErro);

            $arrDados = $dtoConfiguracoes->getArrayBanco();

            if($atualizar)
                return array($this->atualizar('configuracoes', $arrDados, array('cdnClinica' => $_SESSION['cdnClinica'])), $mesErro);
            else
                return array($this->inserir('configuracoes', $arrDados), $mesErro);
        }

        public function mainSalvarBackup($nomArquivo){
            $dtoBackup = new DTOBackup();
            $dtoBackup->setCdnClinica($_SESSION['cdnClinica']);
            $dtoBackup->setCdnUsuario($_SESSION['cdnUsuario']);
            $dtoBackup->setDatBackup(date('Y-m-d H:i:s'));
            $dtoBackup->setNomArquivo($nomArquivo);


            if($this->checaExiste('backup', 'cdnClinica', $_SESSION['cdnClinica'])){
                $arrBackup = $this->consultar('backup', '*', array('cdnClinica' => $_SESSION['cdnClinica']));
                $dtoBackup->setCdnBackup($arrBackup[0]['cdnBackup']);
                $arrDados = $dtoBackup->getArrayBanco();
                return $this->atualizar('backup', $arrDados, array('cdnBackup' => $dtoBackup->getCdnBackup()));
            }else{
                $arrDados = $dtoBackup->getArrayBanco();
                return $this->inserir('backup', $arrDados);
            }
        }

        public function mainMontaSqlLogs(){
            $datas = isset($_POST['datas']) ? $_POST['datas'] : null;
            $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;

            $sql = '
                SELECT * FROM prophet_'.$_SESSION['nomBanco'].'.log l 
                JOIN prophet_main.usuario u ON u.cdnUsuario = l.cdnUsuario WHERE ';

            if(!is_null($usuario) and trim($usuario) != ''){
                $sql .= 'l.cdnUsuario = '.$usuario.' AND ';
            }

            if(!is_null($datas) and trim($datas) != ''){
                $datas = explode('-', $datas);
                $datIni = trim($datas[0]);
                $datFim = trim($datas[1]);
                $datIni = explode('/', $datIni);
                $datIni = $datIni[2].'-'.$datIni[1].'-'.$datIni[0];

                $datFim = explode('/', $datFim);
                $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

                if(strtotime($datIni) < strtotime($datFim)){
                    $sql .= 'l.datLog >= "'.$datIni.' 00:00:00" AND d.datSatisfacao <= "'.$datFim.' 23:59:59" AND ';
                }
            }

            $sql = trim($sql, ' WHERE AND ');
            $sql .= '
                ORDER BY l.datLog DESC
            ';
            return $sql;
        }
    }
