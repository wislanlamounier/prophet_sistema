<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o dentista.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-10
     *
    **/
    class ModeloDentista extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do usuário requisitado
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getDentista($cdnUsuario){
            return $this->getRegistro('dentista', 'cdnUsuario', $cdnUsuario);
        }

        /**
         * Método utilizado para retornar o objeto DTO
         * do usuário requisitado
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getDentistaDias($cdnDentista){
            return $this->getRegistro('dentista_dias', 'cdnDentista', $cdnDentista);
        }

        /**
         * Método utilizado para retornar o objeto DTO
         * do usuário requisitado
         *
         * @param Integer $cdnFechado - código numérico do dia
         * @return Object - objeto DTO do usuário
         *
        **/
        public function getDentistaFechado($cdnFechado){
            return $this->getRegistro('dentista_fechado', 'cdnFechado', $cdnFechado);
        }

        public function getDentistaAberto($cdnAberto){
            return $this->getRegistro('dentista_aberto', 'cdnAberto', $cdnAberto);
        }

        /**
         * Método utilizado para atualizar as informações do dentista
         *
         * @param Object $dtoDentista - objeto DTO do dentista
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function dentistaAtualizarFim(DTODentista $dtoDentista){

            $modMain = new ModeloMain(true);
            if($modMain->mainAtualizarUsuario($dtoDentista->getCdnUsuario())){
                $dados = $dtoDentista->getArrayBanco();
                if($this->atualizar('dentista', $dados, array('cdnUsuario' => $dtoDentista->getCdnUsuario()))){
                    $this->dentistaAtualizarAreaAtuacao($dtoDentista->getCdnUsuario());
                    return true;
                }
            }else{
                return false;
            }

        }

        /**
         * Método utilizado para preencher o DTO do dentista para cadastro.
         *
         * @param Boolean $cdnUsuario - código numérico do usuário (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function dentistaPreparaDTO($cdnUsuario = 0){
            $modMain = new ModeloMain(true);
            $mesErro = '';
        	if($cdnUsuario == 0){
                // está cadastrando
        		$dtoDentista = new DTODentista();
                if($modMain->mainChecaExisteEmail())
                    $mesErro .= 'Este e-mail já está cadastrado no sistema.<br>';
        	}else{
                // está atualizando
        		if(!$this->checaExiste('dentista', 'cdnUsuario', $cdnUsuario))
                    return array(new DTODentista(), 'Registro não existente.');

    			$dtoDentista = $this->getDentista($cdnUsuario);
                $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $cdnUsuario))[0];
                if($_POST['strEmail'] != $arrUsuario['strEmail']){
                    if($modMain->mainChecaExisteEmail())
                        $mesErro .= 'Este e-mail já está cadastrado no sistema.<br>';
                }
        	}


            $arrValidacao = array(
                'codCep' => '',
                'codCro' => 'Informe o CRO.',
                'codCpf' => 'Informe um CPF válido.',
                'codUf' => 'Informe um estado válido.',
                'datAdmissao' => 'Informe uma data de admissão válida.',
                'strOutrosTrabalhos' => '',
                'desDentista' => '',
                'indDesativado' => '',
                'nomCidade' => '',
                'numTelefone1' => '',
                'numTelefone2' => '',
                'strEndereco' => '',
                'numTempoConsulta' => 'Informe um tempo de consulta válido.',
                'strContaBancaria' => '',
                'cdnConsultorio' => 'Informe um consultório válido.',
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

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    else
                        $dtoDentista->{$nomFuncao}('');
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

        		$valCampo = $_POST[$nomCampo];
            	if(!$dtoDentista->{$nomFuncao}($valCampo)){
            		$mesErro .= $mesValidacao.'<br>';
            	}
            }

			return array($dtoDentista, $mesErro);
        }

        /**
         * Método utilizado para registrar o dentista
         * no banco de dados
         *
         * @param Object $dtoDentista - objeto DTO do dentista
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function dentistaCadastrarFim(DTODentista $dtoDentista){

            $modMain = new ModeloMain(true);
            $cdnUsuarioMain = $modMain->mainCadastrarUsuario();
            if($cdnUsuarioMain !== false){
                $dtoDentista->setCdnUsuario($cdnUsuarioMain);
                $dadosFinais = $dtoDentista->getArrayBanco();
                if($this->inserir('dentista', $dadosFinais)){

                    $areas = isset($_POST['cdnAreaAtuacao1']) ? 1 : 0;
                    if($areas){
                        while(true){
                            if(isset($_POST['cdnAreaAtuacao'.$areas]))
                                $areas++;
                            else
                                break;
                        }
                    }

                    if($areas > 0){
                        for($i = 1; $i < $areas; $i++){
                            if($this->checaExiste('areaatuacao', 'cdnAreaAtuacao', $_POST['cdnAreaAtuacao'.$i])){
                                $dtoRelacao = new Dentista_AreaAtuacao();
                                $dtoRelacao->setCdnDentista($cdnUsuarioMain);
                                $dtoRelacao->setCdnAreaAtuacao($_POST['cdnAreaAtuacao'.$i]);
                                $this->inserir('dentista_areaatuacao', $dtoRelacao);
                            }
                        }
                    }


                    return true;
                }else{
                    $modMain->deletar('usuario', array('cdnUsuario' => $cdnUsuarioMain));
                    return false;
                }
            }
            return false;

        }

        /**
         * Método responsável por atualizar as áreas de atuação de um dentista
         *
         * @param Integer $cdnUsuario - código numérico do dentista
         *
        **/
        public function dentistaAtualizarAreaAtuacao($cdnUsuario){
            $arrRelacoes = $this->consultar('dentista_areaatuacao', '*', array('cdnDentista' => $cdnUsuario));

            $areas = isset($_POST['cdnAreaAtuacao1']) ? 1 : 0;
            if($areas){
                while(true){
                    if(isset($_POST['cdnAreaAtuacao'.$areas]))
                        $areas++;
                    else
                        break;
                }
            }

            $this->deletar('dentista_areaatuacao', array('cdnDentista' => $cdnUsuario));

            if($areas > 0){
                for($i = 1; $i < $areas; $i++){
                    if($this->checaExiste('areaatuacao', 'cdnAreaAtuacao', $_POST['cdnAreaAtuacao'.$i])){
                        $dtoRelacao = new Dentista_AreaAtuacao();
                        $dtoRelacao->setCdnDentista($cdnUsuario);
                        $dtoRelacao->setCdnAreaAtuacao($_POST['cdnAreaAtuacao'.$i]);
                        $this->inserir('dentista_areaatuacao', $dtoRelacao);
                    }
                }
            }
        }

        /**
         * Método responsável por preparar o DTO dos dias que o dentista trabalha
         *
         * @param Integer $cdnDentista - código numérico do dentista
         *
        **/
        public function dentistaDiasPreparaDTO($cdnDentista){
            if($this->checaExiste('dentista_dias', 'cdnDentista', $cdnDentista)){
                $dtoDias = $this->getDentistaDias($cdnDentista);
            }else{
                $dtoDias = new Dentista_dias();
                $dtoDias->setCdnDentista($cdnDentista);
            }

            $dtoDias->setIndDomingo(isset($_POST['indDomingo']));
            $dtoDias->setIndSabado(isset($_POST['indSabado']));
            $dtoDias->setIndSegunda(isset($_POST['indSegunda']));
            $dtoDias->setIndTerca(isset($_POST['indTerca']));
            $dtoDias->setIndQuarta(isset($_POST['indQuarta']));
            $dtoDias->setIndQuinta(isset($_POST['indQuinta']));
            $dtoDias->setIndSexta(isset($_POST['indSexta']));
            $dtoDias->setIndSabado(isset($_POST['indSabado']));

            // for($i = 0; $i < count($_POST); $i++){
            //     echo $_POST[array_keys($_POST)[$i]].'<br>';
            //     if($_POST[array_keys($_POST)[$i]] == '__:__ - __:__ ')
            //         $_POST[array_keys($_POST)[$i]] = '';
            // }

            if($dtoDias->getIndDomingo()){
                $dtoDias->setHoraDomingoManha($_POST['horaDomingoManha'] != '' && $_POST['horaDomingoManha'] != '__:__ - __:__ ' ? $_POST['horaDomingoManha'] : null);
                $dtoDias->setHoraDomingoTarde($_POST['horaDomingoTarde'] != '' ? $_POST['horaDomingoTarde'] : null);
            }
            if($dtoDias->getIndSegunda()){
                $dtoDias->setHoraSegundaManha($_POST['horaSegundaManha'] != '' && $_POST['horaSegundaManha'] != '__:__ - __:__ ' ? $_POST['horaSegundaManha'] : null);
                $dtoDias->setHoraSegundaTarde($_POST['horaSegundaTarde'] != '' && $_POST['horaSegundaTarde'] != '__:__ - __:__ ' ? $_POST['horaSegundaTarde'] : null);
            }
            if($dtoDias->getIndTerca()){
                $dtoDias->setHoraTercaManha($_POST['horaTercaManha'] != '' && $_POST['horaTercaManha'] != '__:__ - __:__ ' ? $_POST['horaTercaManha'] : null);
                $dtoDias->setHoraTercaTarde($_POST['horaTercaTarde'] != '' && $_POST['horaTercaTarde'] != '__:__ - __:__ ' ? $_POST['horaTercaTarde'] : null);
            }
            if($dtoDias->getIndQuarta()){
                $dtoDias->setHoraQuartaManha($_POST['horaQuartaManha'] != '' && $_POST['horaQuartaManha'] != '__:__ - __:__ ' ? $_POST['horaQuartaManha'] : null);
                $dtoDias->setHoraQuartaTarde($_POST['horaQuartaTarde'] != '' && $_POST['horaQuartaTarde'] != '__:__ - __:__ ' ? $_POST['horaQuartaTarde'] : null);
            }
            if($dtoDias->getIndQuinta()){
                $dtoDias->setHoraQuintaManha($_POST['horaQuintaManha'] != '' && $_POST['horaQuintaManha'] != '__:__ - __:__ ' ? $_POST['horaQuintaManha'] : null);
                $dtoDias->setHoraQuintaTarde($_POST['horaQuintaTarde'] != '' && $_POST['horaQuintaTarde'] != '__:__ - __:__ ' ? $_POST['horaQuintaTarde'] : null);
            }
            if($dtoDias->getIndSexta()){
                $dtoDias->setHoraSextaManha($_POST['horaSextaManha'] != '' && $_POST['horaSextaManha'] != '__:__ - __:__ ' ? $_POST['horaSextaManha'] : null);
                $dtoDias->setHoraSextaTarde($_POST['horaSextaTarde'] != '' && $_POST['horaSextaTarde'] != '__:__ - __:__ ' ? $_POST['horaSextaTarde'] : null);
            }
            if($dtoDias->getIndSabado()){
                $dtoDias->setHoraSabadoManha($_POST['horaSabadoManha'] != '' && $_POST['horaSabadoManha'] != '__:__ - __:__ ' ? $_POST['horaSabadoManha'] : null);
                $dtoDias->setHoraSabadoTarde($_POST['horaSabadoTarde'] != '' && $_POST['horaSabadoTarde'] != '__:__ - __:__ ' ? $_POST['horaSabadoTarde'] : null);
            }

            return $dtoDias;
        }

        /**
         * Método responsável por inserir os dias de trabalho do dentista no banco
         *
         * @param Object $dtoDias - DTO dos dias que o dentista trabalha
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function dentistaDiasCadastrarFim($dtoDias){
            $arrBanco = $dtoDias->getArrayBanco();
            return $this->inserir('dentista_dias', $arrBanco);
        }

        /**
         * Método responsável por fechar a agenda do dentista
         *
        **/
        public function dentistaFecharAgendaFim($cdnDentista){
            $datDias = $_POST['datDias'];
            if(trim($datDias) == '')
                return false;

            $indGeral = isset($_POST['indGeral']);
            
            $datDias = explode(',', $datDias);
            if(count($datDias) == 1){
                $datDias[0] = date('d/m/Y', strtotime($datDias[0]));
            }
            foreach($datDias as $datDia){
                $dtoFechado = new Dentista_fechado();

                
                $nameDia = str_replace('/', '', $datDia);
                $datFechado = explode('/', $datDia);
                $datFechado = $datFechado[2].'-'.$datFechado[1].'-'.$datFechado[0];

                if(!$indGeral){
                    $desFechado = $_POST[$nameDia];
                    $indAllDay = isset($_POST['dia'.$nameDia]);
                    if(!isset($_POST['horaFechado']))
                        $_POST['horaFechado'] = '';
                    $horaFechado = $_POST['hora'.$nameDia];
                    if($horaFechado == '')
                        $horaFechado = '00:00 - 01:00';
                        
                    $horaFechado = explode('-', $horaFechado);
                    $horaInicio = trim($horaFechado[0]);
                    $horaFinal = trim($horaFechado[1]);

                }else{
                    $desFechado = $_POST['obsGeral'];
                    $indAllDay = isset($_POST['diaGeral']);
                    $horaFechado = $_POST['horaGeral'];
                    $horaFechado = explode('-', $horaFechado);
                    $horaInicio = trim($horaFechado[0]);
                    $horaFinal = trim($horaFechado[1]);
                }

                $dtoFechado->setCdnDentista($cdnDentista);
                $dtoFechado->setDatFechado($datFechado);
                $dtoFechado->setDesFechado($desFechado);
                $dtoFechado->setIndAllDay($indAllDay);
                $dtoFechado->setHoraInicio($horaInicio);
                $dtoFechado->setHoraFinal($horaFinal);

                $arrBanco = $dtoFechado->getArrayBanco();
                $this->inserir('dentista_fechado', $arrBanco);

            }

            return true;



        }

        /**
         * Método responsável por retornar um select de dentistas
         *
         * @param Integer $cdnDentista - código numérico do dentista para selecionar de início (opcional)
         * @param Boolean $label - label a ser colocada. Padrão: Dentista.
         * @param Array $arrDentistas - array de dentistas que devem ser mostrados (opcional).
         * @param String $classe - classe do input. Padrão: iptCdnDentista.
         * @param String $nome - nome do input. Padrão: cdnDentista.
         * @return String - select de clientes
         *
        **/
        public function dentistaRetornaSelect($cdnDentista = 0, $label = 'Dentista', $arrDentistas = false, $classe = 'iptCdnDentista', $nome = 'cdnDentista'){
            if($arrDentistas === false){
                $arrDentistas = $this->consultar('dentista', '*', array('indDesativado' => 0));
            }
            $modMain = new ModeloMain(true);

            $select = '';
            $select .='<div class="form-group">
                           <label class="control-label" for="'.$nome.'">'.$label.'</label>';
            $select .= '
                <select name="'.$nome.'" class="form-control '.$classe.'">';
            foreach($arrDentistas as $arrDentista){


                if($arrDentista['cdnUsuario'] == $cdnDentista)
                    $selected = 'selected';
                else
                    $selected = '';

                $arrUsuario = $modMain->getUsuario($arrDentista['cdnUsuario']);

                $select .= '<option '.$selected.' value="'.$arrDentista['cdnUsuario'].'">'.$arrUsuario['nomUsuario'].'</option>';
            }
            $select .= '</select>';
            if($label)
                $select .= '</div>';

            return $select;
        }

        public function dentistaVerificaFechado($cdnDentista, $datFechado){
            $condicao = array(
                'cdnDentista' => $cdnDentista,
                'conscond1' => 'AND',
                'datFechado' => $datFechado,
                'conscond2' => 'AND',
                'indAllDay' => 1
            );
            $fechado = $this->consultar('dentista_fechado', '*', $condicao);
            
            return count($fechado) > 0;
        }

        public function dentistaVerificaIntervalo($dtoConsulta){
            $semana = array('Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo');
            $dia = $semana[date('N', strtotime($dtoConsulta->getDatConsulta())) - 1];
            $coluna = 'ind'.$dia;
            $cdnDentista = $dtoConsulta->getCdnDentista();
            $datConsulta = $dtoConsulta->getDatConsulta();
            $transformado = $dtoConsulta->getHoraConsulta();
            $sql = 'SELECT * FROM dentista_intervalo 
                    WHERE cdnDentista = '.$cdnDentista.' AND 
                          ((datIntervalo = "'.$datConsulta.'") OR ('.$coluna.' = 1)) AND
                          ("'.$transformado.'" >= horaInicio AND
                           "'.$transformado.'" < horaFinal OR
                           "'.$transformado.'" = horaInicio)
            ';
            $arrIntervalos = $this->query($sql);
            return count($arrIntervalos) > 0;
        }

        public function dentistaAbrirAgendaFim($cdnDentista){
            $mesErro = '';
            $dtoAberto = new DTODentista_aberto();
            $dtoAberto->setCdnDentista($cdnDentista);

            $arrValidacao = array(
                'datAberto' => array('Informe a data de abertura corretamente.'),
                'horaManha' => 'Informe o horário da manhã corretamente.',
                'horaTarde' => 'Informe o horário da tarde corretamente.',
            );

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
                $nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    else
                        $dtoAberto->{$nomFuncao}('');
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

                $valCampo = $_POST[$nomCampo];
                if(!$dtoAberto->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            $arrCond = array(
                'cdnDentista' => $cdnDentista,
                'conscond1' => 'AND',
                'datAberto' => $dtoAberto->getDatAberto()
            );
            if(count($this->consultar('dentista_aberto', '*', $arrCond)) > 0)
                $mesErro .= 'Este dentista já possui horário aberto neste dia.<br>';

            $arrCond = array(
                'cdnDentista' => $cdnDentista,
                'conscond1' => 'AND',
                'datFechado' => $dtoAberto->getDatAberto(),
                'conscond2' => 'AND',
                'indAllDay' => 1
            );
            if(count($this->consultar('dentista_fechado', '*', $arrCond)) > 0)
                $mesErro .= 'Este dentista possui a agenda fechada neste dia.<br>';

            if($mesErro != '')
                return $mesErro;

            $arrDados = $dtoAberto->getArrayBanco();
            return $this->inserir('dentista_aberto', $arrDados);
        }
    }
