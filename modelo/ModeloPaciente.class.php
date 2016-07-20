<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o paciente
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-25
     *
     * */
    class ModeloPaciente extends Modelo {

        use Validacao;

        use Transformacao;

        /**
         * Método responsável por retornar a lista dos campos existentes
         * na tabela do paciente
         *
         * @param Boolean $indMostrar - booleano que indica se deve mostrar os campos que devem
         *                                                                aparecer na tela ou todos os campos.
         * @return Array - array dos campos
         *
         * */
        public function getCampos($indMostrar) {
            $arrCond = array('nomTabela' => 'paciente',
                             'conscond1' => 'AND',
                             'cdnPai'    => 0);

            if ($indMostrar) {
                $arrCond['conscond2'] = 'AND';
                $arrCond['indMostrar'] = 1;
            }

            $arrCampos = $this->consultar('schema_campo', '*', $arrCond, 'codSequencial');

            return $arrCampos;
        }

        /**
         * Método responsável por pegar os campos filhos de um pai
         *
         * @param Integer $cdnCampo - código numérico do campo
         * @return Array - array dos campos
         *
         * */
        public function getFilhos($cdnCampo) {
            $arrCond = array('cdnPai' => $cdnCampo);
            $arrCampos = $this->consultar('schema_campo', '*', $arrCond, 'codSequencial');

            return $arrCampos;
        }

        /**
         * Método responsável por retornar o paciente desejado
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @param Boolean $indTransformar - juntar nome+sobrenome. Padrão: false
         * @return Array - array do paciente
         *
         * */
        public function getPaciente($cdnPaciente, $indTransformar = false) {
            $arrCond = array('cdnPaciente' => $cdnPaciente);
            $arrPaciente = $this->consultar('paciente', '*', $arrCond)[0];

            if ($indTransformar)
                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' ' . $arrPaciente['nomSobrenome'] : '';

            return $arrPaciente;
        }

        /**
         * Método responsável por criar o formulário de cadastro
         *
         * @param Integer $cdnPaciente - código numérico do paciente (opcional);
         * @param Boolean $indVisualizando - se esstá apenas visualizando. Padrão: false.
         * @return String - HTML do formulário pronto
         *
         * */
        public function pacienteFormulario($cdnPaciente = 0, $indVisualizando = false) {
            $action = BASE_URL . '/paciente/';
            $action .= $cdnPaciente == 0 ? 'cadastrarFim' : 'atualizarFim/' . $cdnPaciente;

            $formulario = new Formulario($action, 'post', true, $cdnPaciente);


            $arrCampos = $this->getCampos(true);

            if ($cdnPaciente != 0)
                $arrPaciente = $this->getPaciente($cdnPaciente);


            $arrCheckboxes = array();
            $arrTextareas = array();

            $qtdCampos = 0;
            $qtdReal = 0;
            $formulario->addFree('<div class="row">');
            $formulario->addFree('<div class="col-md-12"><h4 class="page-header">Informações mais importantes</h4></div>');

            if ($cdnPaciente != 0) {
                $qtdCampos++;
                $qtdReal++;
                $formulario->addInput(4, 'text', 'cdnPaciente', 'iptCdnPaciente', 300, 'Prontuário', '', '', $cdnPaciente, false, true);
            }


            foreach ($arrCampos as $arrCampo) {

                $value = isset($arrPaciente[$arrCampo['nomCampo']]) ? $arrPaciente[$arrCampo['nomCampo']] : '';
                $label = $arrCampo['desLabel'];
                $placeholder = '';
                $name = $arrCampo['nomCampo'];
                $id = 'ipt' . ucfirst($name);
                $type = $arrCampo['indTipo'];
                $required = $arrCampo['indRequired'];
                $maxlength = $arrCampo['numLimite'];

                if ($type == 'checkbox') {
                    $arrCheckboxes[] = $arrCampo;
                    continue;
                }
                if ($type == 'textarea') {
                    $arrTextareas[] = $arrCampo;
                    continue;
                }

                $classes = $formulario->getClasses($type);
                if ($type == 'select') {
                    $options = $formulario->getOptions($this->getFilhos($arrCampo['cdnCampo']));

                    $formulario->addSelect(4, $classes, $id, $name, $label, $options, $required, $value);
                } else {
                    if ($type == 'file') {
                        if ($indVisualizando) {
                            if ($value != '') {
                                $html = '<div class="col-md-4 ">
                                            <label class="control-label">' . $label . '</label> <br>
                                            <a href="' . BASE_URL . '/' . $value . '" target="_blank">
                                                <input class="form-control" type="text" value="Visualizar">
                                            </a>
                                         </div>';
                            } else {
                                $html = '<div class="col-md-4 form-group">
                                            <label class="control-label">' . $label . '</label> <br>
                                            <input class="form-control" type="text" value="Dado não informado">.
                                         </div>';
                            }
                            $formulario->addFree($html);
                            continue;
                        } else {
                            $formulario->addInput(4, $type, $name, $id, $maxlength, $label, $placeholder, $classes, $value, $required);
                        }
                    } else {
                        $formulario->addInput(4, $type, $name, $id, $maxlength, $label, $placeholder, $classes, $value, $required);
                    }
                }
                $qtdCampos++;
                $qtdReal++;
                if ($qtdCampos == 3) {
                    $formulario->addFree('</div><div class="row">');
                    $qtdCampos = 0;
                }
                if ($qtdReal == 6) {
                    $formulario->addFree('<div class="col-md-12"><h4 class="page-header">Informações adicionais</h4></div>');
                }
            }
            if ($qtdCampos != 0) {
                $formulario->addFree('</div>');
            }

            foreach ($arrCheckboxes as $arrCampo) {
                $checked = isset($arrPaciente[$arrCampo['nomCampo']]) ? $arrPaciente[$arrCampo['nomCampo']] : false;
                $label = $arrCampo['desLabel'];
                $name = $arrCampo['nomCampo'];
                $id = 'ipt' . ucfirst($name);
                $formulario->addCheckbox(4, $name, $id, $label, '', $checked);
            }

            foreach ($arrTextareas as $arrCampo) {
                $value = isset($arrPaciente[$arrCampo['nomCampo']]) ? $arrPaciente[$arrCampo['nomCampo']] : '';
                $label = $arrCampo['desLabel'];
                $placeholder = $label . ' do paciente';
                $name = $arrCampo['nomCampo'];
                $id = 'ipt' . ucfirst($name);
                $type = $arrCampo['indTipo'];
                $required = $arrCampo['indRequired'];
                $formulario->addTextarea(4, $id, $name, $label, $placeholder, '', $required, $value);
            }

            // if($indVisualizando or $cdnPaciente == 0)
            $formulario->addFree('<div class="row">');
            $arrParcerias = $this->consultar('parceria', '*', array('indDesvinculada' => 0), 'nomParceria');
            $arrOptions = array(null => 'Nenhum');
            foreach ($arrParcerias as $arrParceria) {
                $arrOptions[$arrParceria['cdnParceria']] = $arrParceria['nomParceria'];
            }
            $value = isset($arrPaciente['cdnParceria']) ? $arrPaciente['cdnParceria'] : null;
            $formulario->addSelect(8, '', 'iptCdnParceria select2', 'cdnParceria', 'Convênio com parceria', $arrOptions, false, $value);

            // if($indVisualizando)
            $formulario->addFree('</div>');

            $formulario->addFree('<div id="divresplegal"></div>');

            if (!$indVisualizando) {
                if ($cdnPaciente == 0)
                    $formulario->addBotaoFim('Cadastrar', 'primary');
                else
                    $formulario->addBotaoFim('Editar', 'success');
            }


            return $formulario->fimForm();
        }

        /**
         * Método responsável por validar os dados do POST.
         *
         * @param Integer $cdnPaciente - código numérico do paciente (opcional)
         * @return String - mensagem de erro.
         * */
        public function pacienteValidacao($cdnPaciente = 0) {
            $arrCampos = $this->getCampos(true);
            $mesErro = '';

            foreach ($arrCampos as $arrCampo) {
                if ($arrCampo['indTipo'] == 'file') {
                    // se é um arquivo
                    // não foi informado e é required
                    if (!isset($_FILES[$arrCampo['nomCampo']])) {
                        if ($arrCampo['indRequired']) {
                            $mesErro .= 'Informe ' . $arrCampo['desLabel'] . '<br>';
                        }
                        continue;
                    }

                    // se está vazio e não é required, não faz nada.
                    if (trim($_FILES[$arrCampo['nomCampo']]['name']) == '') {
                        if (!$arrCampo['indRequired'])
                            continue;
                    }

                    $valCampo = $_FILES[$arrCampo['nomCampo']]['name'];
                } else {
                    // se é um input comum
                    // não foi informado e é required
                    if (!isset($_POST[$arrCampo['nomCampo']])) {
                        if ($arrCampo['indRequired']) {
                            $mesErro .= 'Informe ' . $arrCampo['desLabel'] . '<br>';
                        }
                        continue;
                    }

                    // se está vazio e não é required, não faz nada.
                    if (trim($_POST[$arrCampo['nomCampo']]) == '') {
                        if (!$arrCampo['indRequired'])
                            continue;
                    }

                    $valCampo = $_POST[$arrCampo['nomCampo']];
                }


                // validações na trait
                $arrValidacoes = explode(',', $arrCampo['strValidacoes']);
                if (count($arrValidacoes) > 0) {
                    foreach ($arrValidacoes as $validacao) {
                        $nomFuncao = 'validacao' . ucFirst($validacao);

                        if (method_exists($this, $nomFuncao)) {
                            if (!$this->{$nomFuncao}($valCampo))
                                $mesErro .= 'Campo "' . $arrCampo['desLabel'] . '" inválido.<br>';
                        }
                    }
                }
            }

            // verificações de duplicidade de dados
            if ($cdnPaciente = 0) {
                if (isset($_POST['codCpf'])) {
                    $codCpf = $_POST['codCpf'];
                    if (trim($codCpf) != '') {
                        if ($this->validacaoCpf($codCpf)) {
                            if ($this->checaExiste('schema_campo', 'nomCampo', 'codCpf')) {
                                $sql = 'SELECT * FROM paciente WHERE codCpf = "' . $codCpf . '" AND indDesvinculado = 0
                                        AND cdnPaciente != ' . $cdnPaciente;
                                $arrPacientes = $this->query($sql);

                                if (count($arrPacientes) > 0) {
                                    $mesErro .= 'Paciente já cadastrado com este CPF.<br>';
                                }
                            }
                        }
                    }
                }
                if (isset($_POST['codCnpj'])) {
                    $codCnpj = $_POST['codCnpj'];
                    if (trim($codCnpj) != '') {
                        if ($this->validacaoCnpj($codCnpj)) {
                            if ($this->checaExiste('schema_campo', 'nomCampo', 'codCnpj')) {
                                $sql = 'SELECT * FROM paciente WHERE codCnpj = "' . $codCnpj . '" AND indDesvinculado = 0
                                        AND cdnPaciente != ' . $cdnPaciente;
                                $arrPacientes = $this->query($sql);

                                if (count($arrPacientes) > 0) {
                                    $mesErro .= 'Paciente já cadastrado com este CNPJ.<br>';
                                }
                            }
                        }
                    }
                }
                if (isset($_POST['codCpfCnpj'])) {
                    $codCpfCnpj = $_POST['codCpfCnpj'];
                    if (trim($codCpfCnpj) != '') {
                        if ($this->validacaoCpfCnpj($codCpfCnpj)) {
                            if ($this->checaExiste('schema_campo', 'nomCampo', 'codCpfCnpj')) {
                                $sql = 'SELECT * FROM paciente WHERE codCpfCnpj = "' . $codCpfCnpj . '" AND indDesvinculado = 0
                                        AND cdnPaciente != ' . $cdnPaciente;
                                $arrPacientes = $this->query($sql);

                                if (count($arrPacientes) > 0) {
                                    $mesErro .= 'Paciente já cadastrado com este CPF/CNPJ.<br>';
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['cdnParceria'])) {
                $cdnParceria = $_POST['cdnParceria'];
                if (!is_null($cdnParceria) and $cdnParceria != '') {
                    if (!$this->checaExiste('parceria', 'cdnParceria', $cdnParceria)) {
                        $mesErro .= 'Informe um convênio válido.<br>';
                    }
                }
            }


            $mesErro = trim($mesErro, '<br>');

            return $mesErro;
        }

        /**
         * Método responsável por preparar o array de inserção no banco
         * a partir do POST.
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Array - array do paciente
         *
         * */
        public function pacientePreparaArray($cdnPaciente = 0) {
            $arrCampos = $this->getCampos(false);
            if ($cdnPaciente != 0) {
                $arrPaciente = $this->getPaciente($cdnPaciente);
            } else {
                $arrPaciente = array();
                foreach ($arrCampos as $arrCampo) {
                    $arrPaciente[$arrCampo['nomCampo']] = '';
                }
            }

            $mesErro = '';
            foreach ($_POST as $nomCampo => $valCampo) {
                if ($this->checaExiste('schema_campo', 'nomCampo', $nomCampo)) {
                    if (trim($valCampo) == '')
                        $valCampo = null;
                    $arrPaciente[$nomCampo] = $valCampo;
                }
            }

            foreach ($_FILES as $nomCampo => $arrArquivo) {
                if ($this->checaExiste('schema_campo', 'nomCampo', $nomCampo)) {
                    if (trim($arrArquivo['name']) == '') {
                        $valCampo = null;
                    } else {
                        $arquivo = new Arquivo('arquivos_clinicas/' . $_SESSION['cdnClinica'], $nomCampo);
                        $valCampo = $arquivo->finalizar();
                    }
                    if ($valCampo != '')
                        $arrPaciente[$nomCampo] = $valCampo;
                }
            }

            if ($cdnPaciente == 0)
                $arrPaciente['indDesvinculado'] = 0;

            $arrPaciente = $this->pacienteCapitalizar($arrPaciente);

            $arrPaciente['cdnParceria'] = isset($_POST['cdnParceria']) ? $_POST['cdnParceria'] : null;

            return $arrPaciente;
        }

        /**
         * Método responsável por atualizar o responsável legal do paciente
         *
         * @param Integer $cdnPaciente - código numérico do paciente
         *
         * */
        public function pacienteAtualizaResponsavel($cdnPaciente) {
            if (isset($_POST['datNascimento'])) {
                $datNascimento = $_POST['datNascimento'];
                if ($this->pacienteCalculaIdade($datNascimento) < 18) {
                    if ($this->checaExiste('paciente_responsavel', 'cdnPaciente', $cdnPaciente)) {
                        $dtoResponsavel = $this->getRegistro('paciente_responsavel', 'cdnPaciente', $cdnPaciente);
                    } else {
                        $dtoResponsavel = new DTOPaciente_responsavel();
                        $dtoResponsavel->setCdnPaciente($cdnPaciente);
                    }
                    $mesErro = '';

                    if (isset($_POST['cdnPacienteResponsavel'])) {
                        if (trim($_POST['cdnPacienteResponsavel']) != '') {
                            $dtoResponsavel->setCdnPacienteResponsavel($_POST['cdnPacienteResponsavel']);
                        }
                    }

                    $arrValidacao = array(
                        'codCep'         => '',
                        'codCpf'         => 'Informe um CPF válido para o responsável.',
                        'codUf'          => 'Informe um estado válido para o responsável.',
                        'numTelefones'   => '',
                        'strEndereco'    => '',
                        'nomResponsavel' => '',
                        'nomCidade'      => '',
                    );

                    foreach ($arrValidacao as $nomCampo => $mesValidacao) {
                        $nomFuncao = 'set' . ucfirst($nomCampo);


                        if (!isset($_POST[$nomCampo . '_Legal']) or trim($_POST[$nomCampo . '_Legal']) == '') {
                            if (is_array($mesValidacao))
                                $mesErro .= $mesValidacao[0] . '<br>';
                            continue;
                        }

                        if (is_array($mesValidacao))
                            $mesValidacao = $mesValidacao[0];

                        $valCampo = $_POST[$nomCampo . '_Legal'];
                        if (!$dtoResponsavel->{$nomFuncao}($valCampo)) {
                            $mesErro .= $mesValidacao . '<br>';
                        }
                    }

                    if ($mesErro != '')
                        return $mesErro;


                    $this->deletar('paciente_responsavel', array('cdnPaciente' => $cdnPaciente));
                    $arrDados = $dtoResponsavel->getArrayBanco();

                    $this->inserir('paciente_responsavel', $arrDados);

                    return true;
                }
            }

            return true;
        }

        /**
         * Método responsável por retornar a idade do paciente
         *
         * @param String $datNascimento - data de nascimento
         * @return Integer - idade do paciente
         *
         * */
        public function pacienteCalculaIdade($datNascimento) {
            $datNascimento = explode('-', $datNascimento);
            if (count($datNascimento) > 2) {
                $datHoje = getdate();
                $numAno = $datNascimento[0];
                $numMes = $datNascimento[1];
                $numDia = $datNascimento[2];

                $numIdade = $datHoje['year'] - $numAno;
                if ($datHoje['mon'] < $numMes || ($datHoje['mon'] == $numMes && $datHoje['mday'] < $numDia)) {
                    $numIdade -= 1;
                }

                return $numIdade;
            }

            return 18;
        }

        /**
         * Método responsável por cadastrar o paciente no banco de dados
         *
         * @param Array $arrPaciente - array do paciente
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function pacienteCadastrarFim($arrPaciente) {
            if(isset($arrPaciente['cdnParceria'])){
                if($arrPaciente['cdnParceria'] == 0)
                    $arrPaciente['cdnParceria'] = null;
            }
            return $this->inserir('paciente', $arrPaciente);
        }

        /**
         * Método responsável por atualizar o paciente no banco de dados
         *
         * @param Array $arrPaciente - array do paciente
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function pacienteAtualizarFim($arrPaciente) {
            if(isset($arrPaciente['cdnParceria'])){
                if($arrPaciente['cdnParceria'] == 0)
                    $arrPaciente['cdnParceria'] = null;
            }
            return $this->atualizar('paciente', $arrPaciente, array('cdnPaciente' => $arrPaciente['cdnPaciente']));
        }

        /**
         * Método responsável por retornar um select de pacientes
         *
         * @param Integer $cdnPaciente - código numérico do paciente para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Paciente.
         * @param Array $arrPacientes - array de pacientes que devem ser mostrados (opcional).
         * @param String $classe - classe do input. Padrão: iptCdnPaciente.
         * @param String $nome - nome do input. Padrão: cdnPaciente.
         * @return String - select de clientes
         *
         * */
        public function pacienteRetornaSelect($cdnPaciente = 0, $label = 'Paciente', $arrPacientes = false, $classe = 'iptCdnPaciente', $nome = 'cdnPaciente') {
            if ($arrPacientes === false) {
                $arrPacientes = $this->consultar('paciente', '*', array('indDesvinculado' => 0), 'nomPaciente');
            }

            $select = '';
            $select .= '<div class="form-group">
                           <label class="control-label" for="' . $nome . '">' . $label . '</label>';
            $select .= '
                <select name="' . $nome . '" class="form-control ' . $classe . '">';
            foreach ($arrPacientes as $arrPaciente) {

                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' ' . $arrPaciente['nomSobrenome'] : '';

                if ($arrPaciente['cdnPaciente'] == $cdnPaciente)
                    $selected = 'selected';
                else
                    $selected = '';

                $select .= '<option ' . $selected . ' value="' . $arrPaciente['cdnPaciente'] . '">' . $arrPaciente['nomPaciente'] . '</option>';
            }
            $select .= '</select>';
            if ($label)
                $select .= '</div>';

            return $select;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesmo CPF no sistema
         *
         * @param String $codCpf - código CPF.
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Mixed.
         *
         * */
        public function pacienteVerificaCpf($codCpf, $cdnPaciente) {

            if ($this->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)) {
                $arrPaciente = $this->getPaciente($cdnPaciente);
                if ($this->checaExiste('schema_campo', 'nomCampo', 'codCpf')) {
                    if ($codCpf == $arrPaciente['codCpf'])
                        return 0;
                }
                if ($this->checaExiste('schema_campo', 'nomCampo', 'codCpfCnpj')) {
                    if ($codCpf == $arrPaciente['codCpfCnpj'])
                        return 0;
                }
            }

            $arrCond = array('codCpf'          => $codCpf,
                             'conscond1'       => 'AND',
                             'indDesvinculado' => 0);
            $arrPacientes = $this->consultar('paciente', '*', $arrCond, 'nomPaciente');

            return count($arrPacientes) > 0 ? $arrPacientes : 0;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesmo CNPJ no sistema
         *
         * @param String $codCnpj - código CNPJ.
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Mixed.
         *
         * */
        public function pacienteVerificaCnpj($codCnpj, $cdnPaciente) {

            if ($this->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)) {
                $arrPaciente = $this->getPaciente($cdnPaciente);
                if ($this->checaExiste('schema_campo', 'nomCampo', 'codCnpj')) {
                    if ($codCnpj == $arrPaciente['codCnpj'])
                        return 0;
                }
                if ($this->checaExiste('schema_campo', 'nomCampo', 'codCpfCnpj')) {
                    if ($codCnpj == $arrPaciente['codCpfCnpj'])
                        return 0;
                }
            }

            $arrCond = array('codCnpj'         => $codCnpj,
                             'conscond1'       => 'AND',
                             'indDesvinculado' => 0);
            $arrPacientes = $this->consultar('paciente', '*', $arrCond, 'nomPaciente');

            return count($arrPacientes) > 0 ? $arrPacientes : 0;
        }

        /**
         * Método responsável por verificar a existência de um paciente de mesma data
         * de nascimento no sistema
         *
         * @param String $datNascimento - data de nascimento.
         * @param Integer $cdnPaciente - código numérico do paciente
         * @return Mixed.
         *
         * */
        public function pacienteVerificaNascimento($datNascimento, $cdnPaciente) {

            $sql = 'SELECT * from paciente WHERE datNascimento = "' . $datNascimento . '" and
                    indDesvinculado = 0';

            if ($this->checaExiste('paciente', 'cdnPaciente', $cdnPaciente)) {
                $sql .= ' AND cdnPaciente != ' . $cdnPaciente;
            }

            $arrPacientes = $this->query($sql);

            return count($arrPacientes) > 0 ? $arrPacientes : 0;
        }

        /**
         * Método responsável por capitalizar os nomes do paciente
         *
         * @param Array $arrPaciente - array do paciente
         * @return Array - array do paciente
         *
         * */
        public function pacienteCapitalizar($arrPaciente) {
            $nomPaciente = $arrPaciente['nomPaciente'];
            $nomPaciente = explode(' ', $nomPaciente);
            $nomFinal = '';
            foreach ($nomPaciente as $palavra) {
                if (strlen($palavra) > 2) {
                    $palavra = strtolower($palavra);
                    $palavra = ucfirst($palavra);
                } else {
                    $palavra = strtolower($palavra);
                }
                $nomFinal .= $palavra . ' ';
            }
            $arrPaciente['nomPaciente'] = trim($nomFinal);

            if (isset($arrPaciente['nomSobrenome'])) {
                $nomSobrenome = $arrPaciente['nomSobrenome'];
                $nomSobrenome = explode(' ', $nomSobrenome);
                $nomFinal = '';
                foreach ($nomSobrenome as $palavra) {
                    if (strlen($palavra) > 2) {
                        $palavra = strtolower($palavra);
                        $palavra = ucfirst($palavra);
                    }
                    $nomFinal .= $palavra . ' ';
                }
                $arrPaciente['nomSobrenome'] = trim($nomFinal);
            }

            return $arrPaciente;
        }

    }
