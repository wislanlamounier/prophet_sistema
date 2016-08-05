<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a consulta.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-09-16
     *
    **/
    class ModeloConsulta extends Modelo{
        use Transformacao;


        /**
         * Método utilizado para retornar o objeto DTO
         * da consulta requisitada
         *
         * @param Integer $cdnConsulta - código numérico consulta
         * @return Object - objeto DTO da consulta
         *
        **/
        public function getConsulta($cdnConsulta){
            return $this->getRegistro('consulta', 'cdnConsulta', $cdnConsulta);
        }

        /**
         * Método utilizado para atualizar as informações da consulta
         *
         * @param Object $dtoConsulta - objeto DTO da consulta
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function consultaRemarcarFim(DTOConsulta $dtoConsulta){
            $dtoConsulta->setDatRemarque(date('Y-m-d'));
            $dados = $dtoConsulta->getArrayBanco();
            return $this->atualizar('consulta', $dados, array('cdnConsulta' => $dtoConsulta->getCdnConsulta()));

        }

        /**
         * Método utilizado para preencher o DTO da consulta para cadastro.
         *
         * @param Boolean $cdnConsulta - código numérico da consulta (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function consultaPreparaDTO($cdnConsulta = 0){
            $mesErro = '';
            if($cdnConsulta == 0){
                // está cadastrando
                $dtoConsulta = new DTOConsulta();
            }else{
                // está atualizando
                if(!$this->checaExiste('consulta', 'cdnConsulta', $cdnConsulta))
                    return array(new DTOConsulta(), 'Registro não existente.');
                $dtoConsulta = $this->getConsulta($cdnConsulta);
            }

            // if(isset($_POST['datConsulta'])){
            //     $datConsulta = $_POST['datConsulta'];
            //     echo $datConsulta;
            //     die;
            //     $datConsulta = explode('/', $datConsulta);

            //     $datConsulta = $datConsulta[2].'-'.$datConsulta[1].'-'.$datConsulta[0];
            //     $_POST['datConsulta'] = $datConsulta;
            // }

            $arrValidacao = array(
                'cdnAreaAtuacao' => array('Informe uma área de atuação válida.'),
                'cdnPaciente' => array('Informe um paciente válido.'),
                'cdnDentista' => array('Informe um dentista válido.'),
                'datConsulta' => array('Informe uma data válida.'),
                'horaConsulta' => array('Informe um horário válido.'),
                'numHorarios' => 'Informe uma quantidade de horários valida.',
                'cdnConsultorio' => array('Informe um consultório válido.'),
                'desConsulta' => ''
            );

            $dtoConsulta->setIndEncaixe(isset($_POST['indEncaixe']));
            $dtoConsulta->setIndBloquear(isset($_POST['indBloquear']));

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
                if(!$dtoConsulta->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            if($mesErro == ''){
                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($dtoConsulta->getCdnDentista());
                $numTempoConsulta = $dtoDentista->getNumTempoConsulta();
                $numHorarios = $dtoConsulta->getNumHorarios();
                $horaConsulta = $dtoConsulta->getHoraConsulta();
                if($numTempoConsulta != '' and $numHorarios != 0){

                    $timestamp = strtotime( "1970-01-01" );
                    $numTempoConsulta .= ':00';
                    $formato24 = date('H:i:s', strtotime($numTempoConsulta));
                    $segundos = strtotime("$formato24", $timestamp) * $numHorarios;

                    $formato24 = date('H:i:s', strtotime($horaConsulta));
                    $segundosFim = strtotime("$formato24", $timestamp);

                    $segundosFim += $segundos - (10800 * $numHorarios);

                    $dtoConsulta->setHoraFinalizada(date('H:i:s', $segundosFim));


                    $date = $dtoConsulta->getDatConsulta();
                    $semana = array('Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo');
                    $weekDay = $semana[date('N', strtotime($date)) - 1];
                    $coluna = 'ind'.$weekDay;
                    $sql = 'SELECT * FROM dentista_intervalo
                            WHERE cdnDentista = '.$dtoConsulta->getCdnDentista().' AND
                                  ((datIntervalo = "'.$dtoConsulta->getDatConsulta().'") OR ('.$coluna.' = 1)) AND
                                   (("'.$dtoConsulta->getHoraFinalizada().'" >= horaInicio AND
                                    "'.$dtoConsulta->getHoraFinalizada().'" <= horaFinal OR
                                    "'.$dtoConsulta->getHoraFinalizada().'" = horaInicio) OR
                                    ("'.$dtoConsulta->getHoraFinalizada().'" >= horaFinal AND
                                     "'.$dtoConsulta->getHoraConsulta().'" <= horaInicio))
                    ';
                    $arrIntervalos = $this->query($sql);
                    if(count($arrIntervalos) > 0){
                        $dtoConsulta->setHoraFinalizada($arrIntervalos[0]['horaInicio']);
                    }

                }
            }

            $arrProcedimento = false;
            if($arrProcedimento){
                if($cdnConsulta == 0){
                    $cdnOrcamentoProcedimento = $_POST['cdnOrcamentoProcedimento'];
                    if($cdnOrcamentoProcedimento != ''){
                        if($_POST['cdnOrcamento'] == ''){
                            $mesErro .= 'Informe o orçamento corretamente. <br />';
                        }else{
                            $cdnOrcamento = $_POST['cdnOrcamento'];
                            $arrCond = array(
                                'cdnOrcamento' => $cdnOrcamento,
                                'conscond1' => 'AND',
                                'cdnAreaAtuacao' => $dtoConsulta->getCdnAreaAtuacao(),
                                'conscond2' => 'AND',
                                'cdnProcedimento' => $cdnOrcamentoProcedimento,
                                'conscond3' => 'AND',
                                'cdnDentista' => $dtoConsulta->getCdnDentista()
                            );
                            $arrProcedimento = $this->consultar('orcamento_procedimento', '*', $arrCond);
                            if(count($arrProcedimento) == 0){
                                $mesErro .= 'Informe o orçamento corretamente. <br />';
                            }else{
                                $arrProcedimento = $arrProcedimento[0];
                                if($arrProcedimento['numQuantidade'] < $arrProcedimento['numQuantidadeRealizado']){
                                    $mesErro .= 'Informe o orçamento corretamente. <br />';
                                }else{
                                    $arrProcedimento['numQuantidadeRealizado']++;
                                }
                            }

                            $dtoOrcamento = $this->getRegistro('orcamento', 'cdnOrcamento', $cdnOrcamento);
                            if($dtoOrcamento->getCdnPaciente() != $dtoConsulta->getCdnPaciente()){
                                $mesErro .= 'Informe o orçamento corretamente. <br />';
                            }

                            if(!$dtoConsulta->setCdnOrcamento($cdnOrcamento))
                                $mesErro .= 'Informe o orçamento corretamente. <br />';

                            $dtoConsulta->setCdnProcedimento($cdnOrcamentoProcedimento);

                        }
                    }
                }
            }

            return array($dtoConsulta, $mesErro, $arrProcedimento);
        }

        /**
         * Método utilizado para registrar a consulta
         * no banco de dados
         *
         * @param Object $dtoConsulta - objeto DTO da consulta
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function consultaCadastrarFim(DTOConsulta $dtoConsulta){

            $modDentista = new ModeloDentista();
            if($modDentista->dentistaVerificaFechado($dtoConsulta->getCdnDentista(), $dtoConsulta->getDatConsulta()))
                return false;
            if($modDentista->dentistaVerificaIntervalo($dtoConsulta))
                return false;
            $dadosFinais = $dtoConsulta->getArrayBanco();
            return $this->inserir('consulta', $dadosFinais);

        }

        /**
         * Método responsável por retornar as consultas de um dentista em um determinado dia
         *
         * @param Integer $cdnDentista - código numérico do dentista
         * @param String $datConsulta - data da consulta
         *
        **/
        public function consultaVerificaData($cdnDentista, $datConsulta){
            $desmarque = 'SELECT cdnConsulta FROM desmarque';
            $sql = 'SELECT * FROM consulta WHERE cdnDentista = '.$cdnDentista.' AND datConsulta = "'.$datConsulta.'" AND
                    consulta.cdnConsulta NOT IN ('.$desmarque.') ORDER BY horaConsulta';
            $arrConsultas = $this->query($sql);
            if(count($arrConsultas) > 0){
                $modPaciente = new ModeloPaciente();

                echo '<b>Horários já agendados:</b>';
                echo '<ul>';
                foreach($arrConsultas as $arrConsulta){
                    $dtoConsulta = $this->getConsulta($arrConsulta['cdnConsulta']);
                    $arrPaciente = $modPaciente->getPaciente($arrConsulta['cdnPaciente'], true);
                    $link = '<a target="_blank" href="'.BASE_URL.'/paciente/consultarFim/'.$arrPaciente['cdnPaciente'].'">'.
                                $arrPaciente['nomPaciente'].'</a>';

                    echo '<li>'.$dtoConsulta->getDatConsulta(true).' - '.$dtoConsulta->getHoraConsulta().' - '.$link.'</li>';
                }
                echo '</ul>';

            }
        }

        /**
         * Método responsável por gerar o atestado
         *
        **/
        public function consultaAtestadoFim(){

            $modPaciente = new ModeloPaciente();
            if($this->checaExiste('paciente', 'cdnPaciente', $_POST['cdnPaciente'])){
                $arrPaciente = $modPaciente->getPaciente($_POST['cdnPaciente']);
                $arrPaciente['nomPaciente'] .= isset($arrPaciente['nomSobrenome']) ? ' '.$arrPaciente['nomSobrenome'] : '';
                $nomPaciente = $arrPaciente['nomPaciente'];
            }else{
                $nomPaciente = 'SELECIONE O PACIENTE';
            }

            if($this->checaExiste('dentista', 'cdnUsuario', $_POST['cdnDentista'])){
                $modMain = new ModeloMain(true);
                $modDentista = new ModeloDentista();
                $dtoDentista = $modDentista->getDentista($_POST['cdnDentista']);
                $arrUsuario = $modMain->getUsuario($_POST['cdnDentista']);
                $nomDentista = $arrUsuario['nomUsuario'];
                $codCro = $dtoDentista->getCodCro();
            }else{
                $nomDentista = 'DENTISTA INVÁLIDO';
                $codCro = 'DENTISTA INVÁLIDO';
            }


            $fins = $_POST['fins'];
            $rg = $_POST['rg'];
            $horario = $_POST['horario'];
            $horario = str_replace('-', 'às', $horario);
            $data = $_POST['data'];
            $data = explode('-', $data);
            $data = $data[2].'/'.$data[1].'/'.$data[0];

            $observacoes = $_POST['observacoes'];
            if(isset($_POST['repouso'])){
                if(filter_var($_POST['repouso'], FILTER_VALIDATE_INT) or $_POST['repouso'] === 0){
                    $repouso = $_POST['repouso'];
                    $extenso = $this->transformacaoNumeroExtenso($repouso);
                }else{
                    $repouso = 'TEMPO INVÁLIDO';
                    $extenso = 'TEMPO INVÁLIDO';
                }
            }

            $hoje = $_POST['hoje'];
            $hoje = explode('-', $hoje);

            $cid = $_POST['cid'];

            $nomeMes = $this->transformacaoNomeMes($hoje[1]);

            $local = $_POST['local'];


            $pdfAtestado = new PDFAtestado('P', 'mm');

            $pdfAtestado->AddPage();

            for($i = 0; $i <= 1; $i++){
                $pdfAtestado->SetFont('Arial', 'B', 12);
                $pdfAtestado->SetAligns(array('C'));
                if($_POST['tipo'] == 'atestado'){
                    $pdfAtestado->PutRow(array('ATESTADO ODONTOLÓGICO'), true);
                    $pdfAtestado->SetBorders(array('B'));
                    $pdfAtestado->SetFont('Arial', '', 10);
                    $pdfAtestado->PutRow(array('(Regulamentado pelas Leis nº5.081, de 24/08/1966 e nº6.215, de 30/06/1975)'), true);
                }else{
                    $pdfAtestado->SetBorders(array('B'));
                    $pdfAtestado->PutRow(array('COMUNICAÇÃO'), true);
                }

                $pdfAtestado->SetAligns(array('R'));
                $pdfAtestado->SetBorders(array());
                $pdfAtestado->SetFont('Arial', '', 11);
                $pdfAtestado->PutRow(array($nomDentista), true);
                $pdfAtestado->PutRow(array('CRO: '.$codCro), true);
                $pdfAtestado->SetFont('Arial', 'B', 11);
                $pdfAtestado->PutRow(array(($i + 1).'ª via'), true);
                $pdfAtestado->SetFont('Arial', '', 11);
                $pdfAtestado->PutRow(array('Prontuário nº '.$arrPaciente['cdnPaciente']), true);
                $pdfAtestado->Ln(3);
                $pdfAtestado->SetFont('Arial', '', 12);
                $pdfAtestado->setAligns('J');

                if($_POST['tipo'] == 'atestado')
                    $inicio = 'Atesto';
                else
                    $inicio = 'Comunico';

                $pdfAtestado->PutRow(array($inicio.' para fins de '.$fins.' a pedido, que '.$nomPaciente.' R.G nº '.$rg.' esteve sob tratamento odontológico neste consultório, no período das '.$horario.' horas do dia '.$data.', necessitando o(a) mesmo(a) de '.$repouso.' ('.$extenso.') dias de repouso.'), true);
                $pdfAtestado->Ln(3);
                $pdfAtestado->PutRow(array('Obs: '.$observacoes), true);
                $pdfAtestado->PutRow(array('CID - '.$cid), true);
                $pdfAtestado->PutRow(array($local.', '.$hoje[2].' de '.$nomeMes.' de '.$hoje[0]));

                $pdfAtestado->Ln(5);
                $yIni = $pdfAtestado->GetY();

                $pdfAtestado->Line(40, $yIni, $pdfAtestado->w - 40, $yIni);
                $pdfAtestado->SetAligns(array('C'));
                $pdfAtestado->SetFont('Arial', '', 11);
                $pdfAtestado->PutRow(array($nomDentista), true);

                if($i == 0){
                    $pdfAtestado->Ln(10);

                    $y = $pdfAtestado->GetY();

                    $pdfAtestado->Line(3, $y, 10, $y);
                    $pdfAtestado->Line(15, $y, 25, $y);
                    $pdfAtestado->Line(30, $y, 40, $y);
                    $pdfAtestado->Line(45, $y, 55, $y);
                    $pdfAtestado->Line(60, $y, 70, $y);
                    $pdfAtestado->Line(75, $y, 85, $y);
                    $pdfAtestado->Line(90, $y, 100, $y);
                    $pdfAtestado->Line(105, $y, 115, $y);
                    $pdfAtestado->Line(120, $y, 130, $y);
                    $pdfAtestado->Line(135, $y, 145, $y);
                    $pdfAtestado->Line(150, $y, 160, $y);
                    $pdfAtestado->Line(165, $y, 175, $y);
                    $pdfAtestado->Line(180, $y, 190, $y);
                    $pdfAtestado->Line(195, $y, 205, $y);
                    $pdfAtestado->Line(210, $y, 220, $y);

                    $pdfAtestado->Ln(10);
                }
            }


            $pdfAtestado->Output();
        }


        public function alterar(){
            $consultas = $this->consultar('consulta');
            $modProcedimento = new ModeloProcedimento();
            foreach($consultas as $consulta){
                $dtoConsulta = $this->getConsulta($consulta['cdnConsulta']);
                $dtoProcedimento = $modProcedimento->getProcedimento($dtoConsulta->getCdnProcedimento());
                $dtoConsulta->setCdnAreaAtuacao($dtoProcedimento->getCdnAreaAtuacao());
                $this->consultaRemarcarFim($dtoConsulta);
            }
        }

        public function consultaCadastrarSms($dtoConsulta, $pesquisa = true){
            if(!isset($_POST['numTelefone'])){
                $sql = 'select * from sms_aviso_consulta where cdnPaciente = '.$dtoConsulta->getCdnPaciente().
                       ' ORDER BY datAviso DESC LIMIT 1';
                $cons = $this->query($sql);
                if(count($cons) > 0){
                    $cons = $cons[0];   
                }
                $numTelefone = substr($cons['numTelefone'], 2);
            }else{
                $numTelefone = $_POST['numTelefone'];
            }
            // Aviso
            $dtoAviso = new DTOSms_aviso_consulta();
            $dtoAviso->setCdnConsulta($dtoConsulta->getCdnConsulta());
            $dtoAviso->setCdnPaciente($dtoConsulta->getCdnPaciente());

            $numSegAntecedencia = $dtoConsulta->getNumSegAntecedencia();
            $datConsulta = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta();
            $datAviso = date('Y-m-d H:i:s', (strtotime($datConsulta) - $numSegAntecedencia));
            $dtoAviso->setDatAviso($datAviso);


            if($dtoAviso->setNumTelefone($numTelefone)){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoAviso->getCdnPaciente());
                if(isset($arrPaciente['numTelefone1'])){
                    if($arrPaciente['numTelefone1'] != $numTelefone && trim($numTelefone) != ''){
                        $arrPaciente['numTelefone1'] = $numTelefone;
                        $modPaciente->pacienteAtualizarFim($arrPaciente);
                    }
                }
                if(isset($_POST['indEnviarSms']) || count($_POST) == 0){
                    $ret = $this->inserir('sms_aviso_consulta', $dtoAviso->getArrayBanco());
                    if(!$pesquisa)
                        return $ret;
                }
            }else{
                $numTelefone = isset($arrPaciente['numTelefone1']) ? $arrPaciente['numTelefone1'] : '';
            }
            
            
            
            // Pesquisa
            if($pesquisa) {
                $modMain = new ModeloMain(true);
                $dtoConfiguracao = $modMain->getConfiguracoes();
                if ($dtoConfiguracao->getIndPesquisa()) {
                    $cdnPaciente = $dtoConsulta->getCdnPaciente();
                    $realizar = false;
                    if ($dtoConfiguracao->getIndTipoPesquisa() == 'todas') {
                        $realizar = true;
                    } else {
                        $sql = 'SELECT COUNT(cdnConsulta) as qtd FROM consulta '
                            . 'WHERE cdnPaciente = ' . $cdnPaciente;
                        $qtd = $this->query($sql)[0]['qtd'];
                        if ($dtoConfiguracao->getIndTipoPesquisa() == 'primeira') {
                            if ($qtd == 1) {
                                $realizar = true;
                            }
                        }
                        if ($dtoConfiguracao->getIndTipoPesquisa() == 'tres') {
                            if ($qtd % 3 == 0) {
                                $realizar = true;
                            }
                        }
                    }
                    if ($realizar) {
                        $modSms = new ModeloSms();
                        $modSms->smsCadastrarPesquisa($dtoConsulta->getCdnConsulta(),
                            $dtoConsulta->getDatConsulta(),
                            $dtoConsulta->getHoraFinalizada(),
                            $numTelefone,
                            $cdnPaciente);
                    }
                }
            }
        }
        
        public function consultaAtualizarSms($dtoConsulta){
            if($this->checaExiste('sms_aviso_consulta', 'cdnConsulta', $dtoConsulta->getCdnConsulta())){
                $dtoAviso = $this->getRegistro('sms_aviso_consulta', 'cdnConsulta', $dtoConsulta->getCdnConsulta());
                $datConsulta = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraConsulta(); 
                $numSegAntecedencia = $dtoConsulta->getNumSegAntecedencia();
                $datAviso = date('Y-m-d H:i:s', (strtotime($datConsulta) - $numSegAntecedencia));
                $dtoAviso->setDatAviso($datAviso);
                $dtoAviso->setCdnSms(null);
                $ret = $this->atualizar('sms_aviso_consulta', $dtoAviso->getArrayBanco(), array('cdnConsulta' => $dtoAviso->getCdnConsulta()));
            }
            
            if($this->checaExiste('sms_satisfacao', 'cdnConsulta', $dtoConsulta->getCdnConsulta())){
                $dtoPesquisa = $this->getRegistro('sms_satisfacao', 'cdnConsulta', $dtoConsulta->getCdnConsulta());
                if($dtoConsulta->getHoraFinalizada() == '' || is_null($dtoConsulta->getHoraFinalizada())){
                    $horaFinalizada = strtotime($dtoConsulta->getHoraConsulta()) + 60 * 30;
                    $dtoConsulta->setHoraFinalizada(date('H:i:s', $horaFinalizada));
                }
                $datFim = $dtoConsulta->getDatConsulta().' '.$dtoConsulta->getHoraFinalizada();
                $dtoPesquisa->setDatSatisfacao($datFim);
                $dtoPesquisa->setCdnSms(null);
                $this->atualizar('sms_satisfacao', $dtoPesquisa->getArrayBanco(), array('cdnSatisfacao' => $dtoPesquisa->getCdnSatisfacao()));
            }
            return $ret;
        }
        
        public function consultaCancelarSms($dtoConsulta){
            $this->deletar('sms_aviso_consulta', array('cdnConsulta' => $dtoConsulta->getCdnConsulta()));
            $this->deletar('sms_satisfacao', array('cdnConsulta' => $dtoConsulta->getCdnConsulta()));
        }

        public function consultaCadastrarAvisoFim($dtoConsulta){

        }
    }
