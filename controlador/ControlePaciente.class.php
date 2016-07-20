<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * do paciente
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-25
     *
    **/
    class ControlePaciente extends Controlador{

        /**
         * Método responsável por mostrar a página de cadastro do paciente
         *
         * @return Void.
         *
        **/
        public function pacienteCadastrar(){
            $modPaciente = new ModeloPaciente();
            $this->visualizador->atribuirValor('formulario', $modPaciente->pacienteFormulario(0));
            $this->visualizador->addJs('js/pacienteVerificacoes.js');
            $this->visualizador->mostrarNaTela('cadastrar', 'Cadastrar Paciente');
            return;
        }

        /**
         * Método responsável por finalizar o cadastro do paciente
         *
         * @return Void.
         *
        **/
        public function pacienteCadastrarFim(){
            $modPaciente = new ModeloPaciente();

            $mesErro = $modPaciente->pacienteValidacao();
            if($mesErro != ''){
                $this->visualizador->setFlash($mesErro, 'erro');
                $this->pacienteCadastrar();
                return;
            }

            $arrPaciente = $modPaciente->pacientePreparaArray(0);

            if($modPaciente->pacienteCadastrarFim($arrPaciente)){

                $cdnPaciente = $modPaciente->ultimoInserido('paciente');

                // Geração de log
                $this->log(array('sucesso', 'cadastro', 'paciente', $cdnPaciente));

                $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                $this->pacienteConsultarFim($cdnPaciente);
                return;

            }else{

                // Geração de log
                $this->log(array('erro', 'cadastro', 'paciente', $_POST['nomPaciente']));

                $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                $this->pacienteCadastrar();
                return;

            }
        }

        /**
         * Método responsável por mostrar a página de atualização de paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteAtualizar($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $this->visualizador->atribuirValor('formulario', $modPaciente->pacienteFormulario($cdnPaciente));
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);

                $this->visualizador->addJs('js/pacienteVerificacoes.js');
                $this->visualizador->mostrarNaTela('atualizar', 'Atualizar paciente '.$arrPaciente['nomPaciente']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a atualização do paciente
         *
         * @param Integer $cdnPaciente - código numérico de paciente
         * @return Void.
         *
        **/
        public function pacienteAtualizarFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();

                $mesErro = $modPaciente->pacienteValidacao($cdnPaciente);
                if($mesErro != ''){
                    $this->visualizador->setFlash($mesErro, 'erro');
                    $this->pacienteAtualizar($cdnPaciente);
                    return;
                }

                $arrPaciente = $modPaciente->pacientePreparaArray($cdnPaciente);


                if($modPaciente->pacienteAtualizarFim($arrPaciente)){

                    $atualizarResponsavel = $modPaciente->pacienteAtualizaResponsavel($cdnPaciente);
                    if($atualizarResponsavel === true){

                        // Geração de log
                        $this->log(array('sucesso', 'atualizacao', 'paciente', $cdnPaciente));

                        $this->visualizador->setFlash(SUCESSO_CADASTRO, 'sucesso');
                        $this->pacienteConsultarFim($cdnPaciente);
                        return;

                    }else{

                        $this->visualizador->setFlash($atualizarResponsavel, 'erro');
                        $this->pacienteAtualizar($cdnPaciente);
                        return;

                    }

                }else{

                    // Geração de log
                    $this->log(array('erro', 'atualizacao', 'paciente', $cdnPaciente));

                    $this->visualizador->setFlash(ERRO_CADASTRO, 'erro');
                    $this->pacienteAtualizar($cdnPaciente);
                    return;

                }
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de consulta de pacientes
         *
         * @return Void.
         *
        **/
        public function pacienteConsultar(){
            $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
            $this->visualizador->addJs('plugins/datatables_new/datatables.min.js');
            $this->visualizador->addJs('js/pacienteConsultar.js');

            $this->visualizador->mostrarNaTela('consultar', 'Pacientes');
        }

        /**
         * Método reponsável por mostrar a página de perfil do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteConsultarFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $this->visualizador->addCss('plugins/datatables/dataTables.bootstrap.css');
                $this->visualizador->addJs('plugins/datatables/jquery.dataTables.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.bootstrap.js');
                $this->visualizador->addJs('plugins/datatables/dataTables.init.js');

                $verOutros = true;
                if(Modelo::dentista($_SESSION['cdnUsuario'])){
                    if(!Modelo::masterStatic($_SESSION['cdnUsuario'])){
                        $verOutros = false;
                    }else{
                        $verOutros = true;
                    }
                }else{
                    $verOutros = true;
                }

                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $this->visualizador->addJs('js/disableinput.js');
                $this->visualizador->atribuirValor('formulario', $modPaciente->pacienteFormulario($cdnPaciente, true));

                $this->visualizador->atribuirValor('arrDependentes', $this->modelo->consultar('dependente', '*', array('cdnResponsavel' => $cdnPaciente)));

                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);

                $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';
                $sql = 'SELECT * FROM consulta c WHERE c.cdnConsulta NOT IN ('.$sqlDesmarques.') AND
                        cdnPaciente = '.$cdnPaciente;
                if(!$verOutros)
                    $sql .= ' AND cdnDentista = '.$_SESSION['cdnUsuario'];

                $arrConsultas = $modPaciente->query($sql);
                $this->visualizador->atribuirValor('arrConsultas', $arrConsultas);
                $this->visualizador->atribuirValor('modConsulta', new ModeloConsulta());

                $sql = $sql = 'SELECT * FROM consulta c WHERE c.cdnConsulta IN ('.$sqlDesmarques.') AND
                        cdnPaciente = '.$cdnPaciente;
                if(!$verOutros)
                    $sql .= ' AND cdnDentista = '.$_SESSION['cdnUsuario'];
                $arrDesmarques = $modPaciente->query($sql);
                $this->visualizador->atribuirValor('arrDesmarques', $arrDesmarques);

                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);

                $this->visualizador->addJs('js/pacienteVerificacoes.js');

                $this->visualizador->mostrarNaTela('consultarFim', $arrPaciente['nomPaciente']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por mostrar a página de deleção de paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteDeletar($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $this->visualizador->atribuirValor('cdnPaciente', $cdnPaciente);
                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->mostrarNaTela('deletar', 'Deletar paciente '.$arrPaciente['nomPaciente']);
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por finalizar a deleção do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteDeletarFim($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                $arrPaciente['indDesvinculado'] = 1;
                $modPaciente->pacienteAtualizarFim($arrPaciente);
                // Geração de log
                $this->log(array('sucesso', 'delecao', 'paciente', $cdnPaciente));
                $this->visualizador->setFlash('Paciente deletado com sucesso.', 'sucesso');
                $this->pacienteConsultar();
                return;
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por retornar o select de pacientes
         *
         * @param Integer $cdnPaciente - código numérico do paciente para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Paciente.
         * @param Boolean $darEcho - dar echo ou não. Padrão: true
         * @param Array $arrPacientes - array de pacientes a serem mostrados
         * @param String $classe - classe do input. Padrão: iptCdnPaciente.
         * @param String $nome - nome do input. Padrão: cdnPaciente.
         * @return String - select de pacientes
         *
        **/
        public function pacienteRetornaSelect($cdnPaciente = 0, $label = 'Paciente', $darEcho = true, $arrPacientes = false, $classe = 'iptCdnPaciente', $nome = 'cdnPaciente'){
            $modPaciente = new ModeloPaciente();
            $select = $modPaciente->pacienteRetornaSelect($cdnPaciente, $label, $arrPacientes, $classe, $nome);
            if($darEcho)
                echo $select;
            return $select;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesmo CPF no sistema
         *
         * @param String $codCpf - código CPF.
         * @return Void.
         *
        **/
        public function pacienteVerificaCpf($codCpf){
            if(trim($codCpf) == '')
                echo 0;

            $cdnPaciente = isset($_GET['cdnPaciente']) ? $_GET['cdnPaciente'] : 0;

            $modPaciente = new ModeloPaciente();
            $retorno = $modPaciente->pacienteVerificaCpf($codCpf, $cdnPaciente);
            echo $retorno === 0 ? 0 : json_encode($retorno);
            return;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesmo CNPJ no sistema
         *
         * @param String $codCnpj - código CNPJ.
         * @return Void.
         *
        **/
        public function pacienteVerificaCnpj($codCnpj){
            if(trim($codCnpj) == '')
                echo 0;

            $cdnPaciente = isset($_GET['cdnPaciente']) ? $_GET['cdnPaciente'] : 0;

            $modPaciente = new ModeloPaciente();
            $retorno = $modPaciente->pacienteVerificaCnpj($codCnpj, $cdnPaciente);
            echo $retorno === 0 ? 0 : json_encode($retorno);
            return;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesma data de nascimento no sistema
         *
         * @param String $datNascimento - data de nascimento.
         * @return Void.
         *
        **/
        public function pacienteVerificaNascimento($datNascimento){
            if(trim($datNascimento) == '')
                echo 0;

            $cdnPaciente = isset($_GET['cdnPaciente']) ? $_GET['cdnPaciente'] : 0;

            $modPaciente = new ModeloPaciente();
            $retorno = $modPaciente->pacienteVerificaNascimento($datNascimento, $cdnPaciente);
            echo $retorno === 0 ? 0 : json_encode($retorno);
            return;
        }

        /**
         * Método responsável por montar o formulário de responsável legal
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Boolean $visualizando - visualizando ou não
         *
        **/
        public function pacienteFormularioRespLegal($cdnPaciente, $visualizando = 0){
            $modPaciente = new ModeloPaciente();
            if($this->modelo->checaExiste('paciente_responsavel', 'cdnPaciente', $cdnPaciente)){
                $dtoResponsavel = $modPaciente->getRegistro('paciente_responsavel', 'cdnPaciente', $cdnPaciente);
            }else{
                $dtoResponsavel = new DTOPaciente_responsavel();
            }

            if(isset($_GET['visualizando'])){
                if($_GET['visualizando'] == 1)
                    $disabled = 'disabled ';
                else
                    $disabled = '';
            }else{
                $disabled = '';
            }

            if($visualizando and !isset($_GET['visualizando'])){
                $disabled = 'disabled ';
            }else{
                if(!isset($_GET['visualizando']))
                    $disabled = '';
            }


            $form = '<div class="col-md-12">
                        <h3 class="page-header">Dados do responsável legal</h3>
                    </div>';

            $form .=
                '<div class="row"><div class="col-md-4 form-group">' .
                   '<label for="nomResponsavel_Legal" class="control-label">Nome do responsável</label>'.
                   '<input '.$disabled.' value="'.$dtoResponsavel->getNomResponsavel().'" name="nomResponsavel_Legal" class="form-control">' .
                '</div>';
            $form .=
               '<div class="col-md-4 form-group">' .
                   '<label for="strEndereco_Legal" class="control-label">Endereço do responsável</label>'.
                   '<input '.$disabled.' value="'.$dtoResponsavel->getStrEndereco().'" name="strEndereco_Legal" class="form-control">' .
               '</div>';

            $form .=
               '<div class="col-md-4 form-group">' .
                   '<label for="numTelefones_Legal" class="control-label">Telefone(s) do responsável</label>' .
                   '<input '.$disabled.' value="'.$dtoResponsavel->getNumTelefones().'" name="numTelefones_Legal" class="form-control">' .
               '</div></div>';

            $form .=
               '<div class="row"><div class="col-md-4 form-group">' .
                   '<label for="nomCidade_Legal" class="control-label">Cidade do responsável</label>' .
                   '<input '.$disabled.' value="'.$dtoResponsavel->getNomCidade().'" name="nomCidade_Legal" class="form-control">' .
               '</div>';

            $form .=
               '<div class="col-md-4 form-group">' .
                   '<label for="codCep_Legal" class="control-label">CEP do responsável</label>' .
                   '<input '.$disabled.' value="'.$dtoResponsavel->getCodCep().'" name="codCep_Legal" class="form-control mask-cep">' .
               '</div>';

            $form .=
               '<div class="col-md-4 form-group">' .
                   '<label for="codUf_Legal" class="control-label">Estado do responsável</label>
                    <select '.$disabled.' class="form-control" name="codUf_Legal">
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ac" ? "selected" : "";
            $form .= ' value="ac">Acre</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "al" ? "selected" : "";
            $form .= ' value="al">Alagoas</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ap" ? "selected" : "";
            $form .= ' value="ap">Amapá</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "am" ? "selected" : "";
            $form .= ' value="am">Amazonas</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ba" ? "selected" : "";
            $form .= ' value="ba">Bahia</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ce" ? "selected" : "";
            $form .= ' value="ce">Ceará</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "df" ? "selected" : "";
            $form .= ' value="df">Distrito Federal</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "es" ? "selected" : "";
            $form .= ' value="es">Espirito Santo</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "go" ? "selected" : "";
            $form .= ' value="go">Goiás</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ma" ? "selected" : "";
            $form .= ' value="ma">Maranhão</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ms" ? "selected" : "";
            $form .= ' value="ms">Mato Grosso do Sul</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "mt" ? "selected" : "";
            $form .= ' value="mt">Mato Grosso</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "mg" ? "selected" : "";
            $form .= ' value="mg">Minas Gerais</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "pa" ? "selected" : "";
            $form .= ' value="pa">Pará</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "pb" ? "selected" : "";
            $form .= ' value="pb">Paraíba</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "pr" ? "selected" : "";
            $form .= ' value="pr">Paraná</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "pe" ? "selected" : "";
            $form .= ' value="pe">Pernambuco</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "pi" ? "selected" : "";
            $form .= ' value="pi">Piauí</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "rj" ? "selected" : "";
            $form .= ' value="rj">Rio de Janeiro</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "rn" ? "selected" : "";
            $form .= ' value="rn">Rio Grande do Norte</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "rs" ? "selected" : "";
            $form .= ' value="rs">Rio Grande do Sul</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "ro" ? "selected" : "";
            $form .= ' value="ro">Rondônia</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "rr" ? "selected" : "";
            $form .= ' value="rr">Roraima</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "sc" ? "selected" : "";
            $form .= ' value="sc">Santa Catarina</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "sp" ? "selected" : "";
            $form .= ' value="sp">São Paulo</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "se" ? "selected" : "";
            $form .= ' value="se">Sergipe</option>
                        <option ';
            $form .= strtolower($dtoResponsavel->getCodUf()) == "to" ? "selected" : "";
            $form .= ' value="to">Tocantins</option>
                    </select>
               </div></div>';

            $form .=
               '<div class="row"><div class="col-md-4 form-group">' .
                   '<label for="codCpf_Legal" class="control-label">CPF do responsável</label>' .
                   '<input '.$disabled.' value="'.$dtoResponsavel->getCodCpf().'" name="codCpf_Legal" class="form-control mask-cpf">' .
               '</div></div>';

            echo $form;
        }

        /**
         * Método responsável por verificar se um paciente está com o cadastro completo
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteVerificaCadastro($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);

                $arrCampos = $modPaciente->getCampos(0);

                $indIncompleto = false;

                foreach($arrCampos as $arrCampo){
                    if(trim($arrPaciente[$arrCampo['nomCampo']]) == ''){
                        $indIncompleto = true;
                    }
                }
                if($indIncompleto){
                    $link = $this->visualizador->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($cdnPaciente));
                    echo '<b>'.$link.' está com o seu cadastro incompleto.';
                }
            }else{
                echo '<b>Paciente inválido.</b>';
            }
        }
        
        public static function pacienteVerificaTelefone($cdnPaciente, $echo = true){

            if(!ControleCampo::campoExiste('numTelefone1')){
                if($echo)
                    echo 'Telefone não está configurado no sistema!!';
                return 'Telefone não está configurado no sistema!!';
            }

            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
            if($arrPaciente['numTelefone1'] == ''){
                if($echo)
                    echo 'Telefone não está configurado para este paciente!!';
                return 'Telefone não está configurado para este paciente!!';
            }else{
                $numTelefone = $arrPaciente['numTelefone1'];
                if(strlen($numTelefone) != 10){
                    $numTelefone = str_replace(' ', '', $numTelefone);
                    $numTelefone = str_replace('(', '', $numTelefone);
                    $numTelefone = str_replace(')', '', $numTelefone);
                    $numTelefone = str_replace('-', '', $numTelefone);
                    if(strlen($numTelefone) != 10){
                        if($echo)
                            echo 'Verifique se o número do paciente contém o DDD local.';
                        return 'Verifique se o número do paciente contém o DDD local.';
                    }
                }
            }
            return true;
        }

        /**
         * Método responsável por retornar uma característica de um paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteRetornaCaracteristica($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $caracteristica = $_GET['caracteristica'];
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
                if(isset($arrPaciente[$caracteristica]))
                    echo $arrPaciente[$caracteristica];
                else
                    echo '';
                return;
            }
            $this->erroExistente();
            return;

        }

        /**
         * Método responsável por montar um select dos dependentes de um paciente, se houver
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteDependentes($cdnPaciente){
            if($this->modelo->checaExiste('dependente', 'cdnPaciente', $cdnPaciente)){
                $arrDependentes = $this->modelo->consultar('dependente', '*', array('cdnPaciente' => $cdnPaciente));
                $sql = 'SELECT p.* FROM paciente p INNER JOIN dependente d ON p.cdnPaciente = d.cdnResponsavel WHERE
                        d.cdnPaciente = '.$cdnPaciente;

                $arrDependentes = $this->modelo->query($sql);

                $this->pacienteRetornaSelect(0, 'Titular', true, $arrDependentes, 'iptCdnTitular select2', 'cdnTitular');
            }
        }

        /**
         * Método responsável por montar o forulário de cadastro de paciente via sweet alert
         *
         * @return Void.
         *
        **/
        public function pacienteCadastrarSwal(){
            $modCampo = new ModeloCampo();
            $html = '
                <div class="col-md-12 form-group">
                    <label for="nomPaciente" class="control-label">Nome</label>
                    <input type="text" name="nomPaciente" id="nomPacienteSwal" class="form-control">
                </div>
            ';

            if($modCampo->campoUtilizaSobrenome()){
                $html .= '
                    <div class="col-md-12 form-group">
                        <label for="nomSobrenome" class="control-label">Sobrenome</label>
                        <input type="text" name="nomSobrenome" id="nomSobrenomeSwal" class="form-control">
                    </div>
                ';
            }

            if(ControleCampo::campoExiste('numTelefone1')){
                $html .= '
                    <div class="col-md-12 form-group">
                        <label for="numTelefone1" class="control-label">Telefone</label>
                        <input type="text" name="numTelefone1" id="numTelefone1Swal" class="form-control">
                    </div>
                ';
            }

            echo $html;
            return;

        }

        /**
         * Método responsável por criar um novo paciente via sweetalert
         *
         * @return Void.
         *
        **/
        public function pacienteCadastrarSwalFim(){
            if(!isset($_GET['nomPaciente'])){
                echo 0;
                return 0;
            }
            if(ControleCampo::campoExiste('nomSobrenome')){
                if(!isset($_GET['nomSobrenome'])){
                    echo 0;
                    return 0;
                }
            }
            if(ControleCampo::campoExiste('numTelefone1')){
                if(!isset($_GET['numTelefone'])){
                    echo 0;
                    return 0;
                }
            }

            $arrPaciente = array();
            $arrPaciente['nomPaciente'] = $_GET['nomPaciente'];

            $modCampo = new ModeloCampo();
            if($modCampo->campoUtilizaSobrenome()){
                $arrPaciente['nomSobrenome'] = $_GET['nomSobrenome'];
            }

            if(ControleCampo::campoExiste('numTelefone1')){
                $arrPaciente['numTelefone1'] = $_GET['numTelefone'];
            }

            $modPaciente = new ModeloPaciente();

            if($modPaciente->pacienteCadastrarFim($arrPaciente)){
                // Geração de log
                $this->log(array('sucesso', 'cadastrar', 'paciente', $arrPaciente['nomPaciente']));
                $cdnPaciente = $modPaciente->ultimoInserido('paciente');
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                echo json_encode($arrPaciente);
            }else{
                // Geração de log
                $this->log(array('erro', 'cadastrar', 'paciente'));
                echo 0;
            }
        }

        /**
         * Método responsável por montar um select das tabelas de preço que este paciente utiliza
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Void.
         *
        **/
        public function pacienteTabelasPreco($cdnPaciente){
            if($this->modelo->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $select = '<label for="cdnTabelaPreco" class="control-label">Tabela de preço</label>
                            <select id="selectTabelaPreco" name="cdnTabelaPreco" class="form-control">';
                if(ControleCampo::campoExiste('cdnParceria')){
                    if($this->modelo->checaExiste('parceria', 'cdnParceria', $arrPaciente['cdnParceria'])){
                        $modParceria = new ModeloParceria();
                        $dtoParceria = $modParceria->getParceria($arrPaciente['cdnParceria']);
                        $select .= '<option selected value="parceria'.$arrPaciente['cdnParceria'].'">'.$dtoParceria->getNomParceria().'</option>';
                    }
                }
                foreach($this->modelo->consultar('tabelapreco') as $arrTabelaPreco){
                    $select .= '<option value="'.$arrTabelaPreco['cdnTabelaPreco'].'">'.$arrTabelaPreco['nomTabelaPreco'].'</option>';
                }
                $select .= '</select>';
                echo $select;
            }
            return;
        }

        public function pacienteRetornaTelefone($cdnPaciente){
            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($cdnPaciente);
            $numTelefone1 = isset($arrPaciente['numTelefone1']) ? $arrPaciente['numTelefone1'] : '';
            echo $numTelefone1;
        }
    }
