<?php

    class ModeloSms extends Modelo{
        use Transformacao;
        public function smsMontaSql($cdnPaciente = null, $join = false){
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
            $datas = isset($_POST['datas']) ? $_POST['datas'] : null;
            $dentista = isset($_POST['dentista']) ? $_POST['dentista'] : null;
            
            if(is_null($cdnPaciente)){
                $cdnPaciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            }

            switch ($tipo) {
                case 'aviso_consulta':
                    $sql  = 'SELECT * FROM sms_aviso_consulta a LEFT JOIN sms s ON s.cdnSms = a.cdnSms ';
                    $sql .= ' JOIN consulta c ON c.cdnConsulta = a.cdnConsulta ';
                    $sql .= ' JOIN dentista d ON c.cdnDentista = d.cdnUsuario ';
                    break;
                case 'satisfacao':
                    $sql  = 'SELECT * FROM sms_satisfacao a LEFT JOIN sms s ON s.cdnSms = a.cdnSms ';
                    $sql .= ' JOIN consulta c ON c.cdnConsulta = a.cdnConsulta ';
                    $sql .= ' JOIN dentista d ON c.cdnDentista = d.cdnUsuario ';
                    break;
                default:
                    if(ControleCampo::campoExiste('nomSobrenome')){
                        $sql  = 'SELECT s.cdnSms, a.cdnConsulta, s.numTelefone, s.strTexto, '
                            . 'sa.cdnConsulta, c.cdnConsulta,'
                            . 'd.cdnUsuario,d.cdnUsuario,s.datEnvio,'
                            . 's.cdnPaciente,p.nomPaciente,p.nomSobrenome,u.nomUsuario  FROM sms s ';
                    }else{
                        $sql  = 'SELECT s.cdnSms, a.cdnConsulta, s.numTelefone, s.strTexto, '
                            . 'sa.cdnConsulta, c.cdnConsulta,'
                            . 'd.cdnUsuario,d.cdnUsuario,s.datEnvio,'
                            . 's.cdnPaciente,p.nomPaciente,u.nomUsuario  FROM sms s ';
                    }
                    $sql .= ' LEFT JOIN sms_aviso_consulta a ON a.cdnSms = s.cdnSms ';
                    $sql .= ' LEFT JOIN sms_satisfacao sa ON sa.cdnSms = s.cdnSms ';
                    $sql .= ' LEFT JOIN consulta c ON a.cdnConsulta = c.cdnConsulta OR sa.cdnConsulta = c.cdnConsulta ';
                    $sql .= ' LEFT JOIN dentista d ON c.cdnDentista = d.cdnUsuario ';
                    break;
            }

            $sql .= ' JOIN paciente p on s.cdnPaciente = p.cdnPaciente ';
            $sql .= ' JOIN prophet_main.usuario u ON u.cdnUsuario = d.cdnUsuario ';
            
            
            if(!is_null($dentista) and trim($dentista) != ''){
                if($tipo == 'todos'){
                    $sql .= ' WHERE ';
                    $sql .= ' d.cdnUsuario = '.$dentista.' AND ';
                }else{
                    $sql .= 'WHERE d.cdnUsuario = '.$dentista.' AND ';
                }
            }else{
                $sql .= 'WHERE ';
            }
            
            if(!is_null($datas) and trim($datas) != ''){
                $datas = explode('-', $datas);
                $datIni = trim($datas[0]);
                $datFim = trim($datas[1]);
                if($datIni == $datFim){
                    $sql .= 's.datEnvio = '.$datIni.' AND ';
                }else{
                    $datIni = explode('/', $datIni);
                    $datIni = $datIni[2].'-'.$datIni[1].'-'.$datIni[0];

                    $datFim = explode('/', $datFim);
                    $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

                    if(strtotime($datIni) < strtotime($datFim)){
                        $sql .= 's.datEnvio >= "'.$datIni.' 00:00:00" AND s.datEnvio <= "'.$datFim.' 00:00:00" AND ';
                    }
                }
            }

            if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                $sql .= 's.cdnPaciente = '.$cdnPaciente;
            }
            
            
            return trim($sql, 'WHERE AND');

        }
        
        public function smsMontaSqlResposta(){
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
            $datas = isset($_POST['datas']) ? $_POST['datas'] : null;
            $dentista = isset($_POST['dentista']) ? $_POST['dentista'] : null;
            $cdnPaciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            
            if(ControleCampo::campoExiste('nomSobrenome'))
                $nomSobrenome = ', p.nomSobrenome, ';
            else
                $nomSobrenome = ',';
            
            if($tipo == 'satisfacao'){
                $sql = '
                SELECT ss.cdnConsulta, p.cdnPaciente, c.cdnDentista, p.nomPaciente '.$nomSobrenome.' u.nomUsuario, 
                       u.cdnUsuario, d.datSatisfacao as datResposta, d.numNota as strResposta, c.datConsulta, c.horaConsulta,
                       ss.numTelefone
                FROM sms_satisfacao ss
                JOIN consulta c ON c.cdnConsulta = ss.cdnConsulta 
                JOIN dentista_satisfacao d ON d.cdnSatisfacao = ss.cdnSatisfacao AND d.cdnDentista = c.cdnDentista
                JOIN paciente p ON p.cdnPaciente = ss.cdnPaciente
                JOIN prophet_main.usuario u ON u.cdnUsuario = c.cdnDentista 
                WHERE ';
                
                if(!is_null($dentista) and trim($dentista) != ''){
                    $sql .= 'c.cdnDentista = '.$dentista.' AND ';
                }
                
                if(!is_null($datas) and trim($datas) != ''){
                    $datas = explode('-', $datas);
                    $datIni = trim($datas[0]);
                    $datFim = trim($datas[1]);
                    if($datIni == $datFim){
                        $sql .= 'd.datSatisfacao = '.$datIni.' AND ';
                    }else{
                        $datIni = explode('/', $datIni);
                        $datIni = $datIni[2].'-'.$datIni[1].'-'.$datIni[0];

                        $datFim = explode('/', $datFim);
                        $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

                        if(strtotime($datIni) < strtotime($datFim)){
                            $sql .= 'd.datSatisfacao >= "'.$datIni.'" AND d.datSatisfacao <= "'.$datFim.'" AND ';
                        }
                    }
                }
                
                if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                    $sql .= 'c.cdnPaciente = '.$cdnPaciente;
                }
            
            
                $sql = trim($sql, 'WHERE AND');
                
                
                $sql = trim($sql, 'WHERE AND');
                $sql .= '
                    ORDER BY d.datSatisfacao DESC
                ';
            }else{
                $sql = '
                SELECT sr.cdnConsulta, s.cdnConsulta, p.cdnPaciente, p.nomPaciente '.$nomSobrenome.' c.cdnDentista, 
                       u.cdnUsuario, sr.datResposta, sr.indVisualizado, sr.strResposta, sr.cdnConsulta, u.nomUsuario, 
                       c.datConsulta, c.horaConsulta, s.numTelefone 
                FROM sms_aviso_consulta_resposta sr
                JOIN sms_aviso_consulta s ON s.cdnConsulta = sr.cdnConsulta
                JOIN paciente p ON p.cdnPaciente = s.cdnPaciente
                JOIN consulta c ON c.cdnConsulta = s.cdnConsulta 
                JOIN prophet_main.usuario u ON u.cdnUsuario = c.cdnDentista 
                WHERE ';
                
                if(!is_null($dentista) and trim($dentista) != ''){
                    $sql .= 'c.cdnDentista = '.$dentista.' AND ';
                }
                
                if(!is_null($datas) and trim($datas) != ''){
                    $datas = explode('-', $datas);
                    $datIni = trim($datas[0]);
                    $datFim = trim($datas[1]);
                    if($datIni == $datFim){
                        $sql .= 'sr.datResposta = '.$datIni.' AND ';
                    }else{
                        $datIni = explode('/', $datIni);
                        $datIni = $datIni[2].'-'.$datIni[1].'-'.$datIni[0];

                        $datFim = explode('/', $datFim);
                        $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

                        if(strtotime($datIni) < strtotime($datFim)){
                            $sql .= 'sr.datResposta >= "'.$datIni.' 00:00:00" AND sr.datResposta <= "'.$datFim.' 00:00:00" AND ';
                        }
                    }
                }
                
                if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                    $sql .= 'c.cdnPaciente = '.$cdnPaciente;
                }
            
            
                $sql = trim($sql, 'WHERE AND');
            
                $sql .= ' 
                    ORDER BY sr.indVisualizado ASC, sr.datResposta DESC
                ';
            }
            
            return $sql;

        }

        public function getSms($cdnSms){
            return $this->getRegistro('sms', 'cdnSms', $cdnSms);
        }

        public function smsEnviarFim($dtoSms, $cron = false){
            $arrPaciente = $this->consultar('paciente', '*', array('cdnPaciente' => $dtoSms->getCdnPaciente()))[0];

            if($cron)
                include_once(__DIR__.'/../plugins/zenvia/human_gateway_client_api/HumanClientMain.php');
            else
                include_once('plugins/zenvia/human_gateway_client_api/HumanClientMain.php');

            $humanMultipleSend = new HumanMultipleSend('odontoassist.api', 'UBSlA8Rnw6');
            $tipo = HumanMultipleSend::TYPE_C;
            $callback = HumanMultipleSend::CALLBACK_INACTIVE;

            $msg = $dtoSms->getNumTelefone().';'.$dtoSms->getStrTexto().';'.$dtoSms->getNumIdZenvia();

            $responses = $humanMultipleSend->sendMultipleList($tipo, $msg, $callback);
            $response = $responses[0];
            $codRetorno = $response->getCode();
            //file_put_contents(__DIR__.'/Cron/relatorio.txt', $codRetorno);
            switch ($codRetorno) {
                case 000:
                    return true;
                    break;
                case 200:
                    return true;
                    break;
                default:
                    return array(false, $codRetorno);
                    break;
            }

        }

        public function smsCadastrarFim($tipo, $cdnPaciente, $argumentos){
            switch ($tipo) {
                case 'aviso_consulta':
                    /**
                     * Ordem dos argumentos:
                     * [0] - cdnConsulta
                    **/
                    $cdnConsulta = $argumentos[0];
                    if(!$this->checaExiste('consulta', 'cdnConsulta', $cdnConsulta))
                        return false;

                    // Variáveis padrões (devem estar em todos cases)
                    $dtoTipo = $this->getRegistro('sms_aviso_consulta', 'cdnConsulta', $cdnConsulta);
                    $tabelaTipo = 'sms_aviso_consulta';
                    $campoTipo = 'cdnConsulta';
                    $valorTipo = $cdnConsulta;
                    break;

                default:
                    return false;
                    break;
            }
            $dtoSms = new DTOSms();
            $dtoSms->setDatEnvio(date('Y-m-d H:i:s'));
            $dtoSms->setCdnUsuario($_SESSION['cdnUsuario']);
            $dtoSms->setCdnPaciente($cdnPaciente);
            $dtoSms->setNumTelefone($_POST['numTelefone']);
            $dtoSms->setStrTexto($_POST['strTexto']);
            $dtoSms->setNumIdZenvia(uniqid(rand()));

            if($this->inserir('sms', $dtoSms->getArrayBanco())){
                $cdnSms = $this->ultimoInserido('sms');
                $dtoSms->setCdnSms($cdnSms);
                $dtoTipo->setCdnSms($cdnSms);
                if(!$this->atualizar($tabelaTipo, $dtoTipo->getArrayBanco(), array($campoTipo => $valorTipo))){
                    $this->deletar('sms', $cdnSms);
                    return array(false);
                }
                return array(true, $dtoSms);
            }else{
                return array(false);
            }
        }

        public function smsMontarTxt($arrSms, $respostas = false){
            $arrPacientes = array();
            $arrUsuarios = array();
            
            $arquivo = uniqid().'.txt';

            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
            $datas = isset($_POST['datas']) ? $_POST['datas'] : null;
            $cdnPaciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            $dentista = isset($_POST['dentista']) ? $_POST['dentista'] : null;
            
            $cabecalho = '';
            if(!is_null($tipo)){
                $cabecalho .= 'TIPO DE SMS: '.$tipo.' - ';
            }
            if(!is_null($datas) && trim($datas) != ''){
                $cabecalho .= ' - DATA DOS SMS: '.$datas;
                $cabecalho = trim($cabecalho, '- ');
            }
            if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($cdnPaciente, true);
                $cabecalho .= ' - PACIENTE: '.$arrPaciente['nomPaciente'];
                $cabecalho = trim($cabecalho, '- ');
                $arrPacientes[$cdnPaciente] = $arrPaciente['nomPaciente'];
            }
            $cabecalho .= 'RELATÓRIO GERADO EM: '.date('d/m/Y H:i:s');
            
            if(!is_null($dentista) && trim($dentista) != ''){
                if(count($arrSms)){
                    $nomDentista = $arrSms[0]['nomUsuario'];
                    $cabecalho .= ' - DENTISTA: '.$nomDentista.' - ';
                }
            }
            
            if($respostas){
                $cabecalho .= PHP_EOL.'###### RELATÓRIO DE RESPOSTAS ######';
            }else{
                $cabecalho .= PHP_EOL.'###### RELATÓRIO DE ENVIOS ######';
            }
            
            $cabecalho = trim($cabecalho, '- ').PHP_EOL;
            
            $diretorio = 'arquivos_clinicas/'.$_SESSION['cdnClinica'].'/'.$arquivo;
            file_put_contents($diretorio, $cabecalho);
            $separador = PHP_EOL.'------------------------------------------------------'.PHP_EOL;

            foreach($arrSms as $sms){
                /**if(!isset($arrPacientes[$sms['cdnPaciente']])){
                    $modPaciente = !isset($modPaciente) ? new ModeloPaciente() : $modPaciente;
                    $arrPaciente = $modPaciente->getPaciente($sms['cdnPaciente']);
                    $arrPacientes[$sms['cdnPaciente']] = $arrPaciente;
                }
                $arrPaciente = $arrPacientes[$sms['cdnPaciente']];

                if(!isset($arrUsuarios[$sms['cdnUsuario']])){
                    $modMain = !isset($modMain) ? new ModeloMain(true) : $modMain;
                    $arrUsuario = $modMain->getUsuario($sms['cdnUsuario']);
                    $arrUsuarios[$sms['cdnUsuario']] = $arrUsuario;
                }
                $arrUsuario = $arrUsuarios[$sms['cdnUsuario']]; **/

                if(isset($sms['nomSobrenome'])){
                    $sms['nomPaciente'] .= ' '.$sms['nomSobrenome'];
                }
                
                if($respostas){
                    $data = $sms['datResposta'];
                    $txt = $sms['strResposta'];
                }else{
                    $data = $sms['datEnvio'];
                    $txt = $sms['strResposta'];
                }
                
                file_put_contents($diretorio, $separador, FILE_APPEND);
                $texto  = 'PACIENTE - NUMERO: '.$sms['nomPaciente'].' - '.$sms['numTelefone'].PHP_EOL;
                $texto .= 'DATA: '.$data.PHP_EOL;
                $texto .= 'DENTISTA: '.$sms['nomUsuario'].PHP_EOL;
                $texto .= 'TEXTO:'.PHP_EOL;
                $texto .= $txt.PHP_EOL;
                file_put_contents($diretorio, $texto, FILE_APPEND);
                file_put_contents($diretorio, $separador, FILE_APPEND);
            }

            $contagem = 'SMS NO RELATÓRIO: '.count($arrSms).PHP_EOL;
            if($respostas){
                $todos = $this->query('
                   SELECT 
                       (SELECT count(cdnSatisfacao) FROM dentista_satisfacao) as qtdPesq, 
                       (SELECT count(cdnResposta) FROM sms_aviso_consulta_resposta) as qtdAviso
                ');
                $todos = $todos[0];
                $todos = $todos['qtdPesq'] + $todos['qtdAviso'];
                $contagem .= 'TOTAL DE SMS RECEBIDOS DESDE O INÍCIO: '.$todos;
            }else{
                $todos = $this->query('SELECT count(cdnSms) as cont FROM sms')[0]['cont'];
                $contagem .= 'TOTAL DE SMS ENVIADOS DESDE O INÍCIO: '.$todos;
            }
            file_put_contents($diretorio, $contagem, FILE_APPEND);

            $harquivo = fopen($diretorio, 'r');
            $size = filesize($diretorio);

            header("Content-type: application/octet-stream");
            header("Content-Disposition: filename=\"".$arquivo."\"");
            header('Content-length: '.$size);
            header('Cache-control: private');
            while(!feof($harquivo)) {
                $buffer = fread($harquivo, 2048);
                echo $buffer;
            }
            fclose($harquivo);
            unlink($diretorio);
            exit;

        }
        
        public function smsConfiguracoesFim(){
            $modMain = new ModeloMain(true);
            $dtoConfiguracoes = $modMain->getConfiguracoes();
            
            $mesErro = '';
            
            $strAvisoConsulta = isset($_POST['strAvisoConsulta']) ? $_POST['strAvisoConsulta'] : null;
            if(!$dtoConfiguracoes->setStrAvisoConsulta($strAvisoConsulta)){
                $mesErro .= 'Parece que você usou tags inválidas para o aviso de consulta. <br>';
            }
            
            $strPesquisa = isset($_POST['strPesquisa']) ? $_POST['strPesquisa'] : null;
            if(!$dtoConfiguracoes->setStrPesquisa($strPesquisa)){
                $mesErro .= 'Parece que você usou tags inválidas para o aviso de pesquisa de satisfação. <br>';
            }
            
            $indPesquisa = isset($_POST['indPesquisa']);
            $dtoConfiguracoes->setIndPesquisa($indPesquisa);
            if($indPesquisa){
                $indTipoPesquisa = isset($_POST['indTipoPesquisa']) ? $_POST['indTipoPesquisa'] : null;
                if(is_null($indTipoPesquisa)){
                    $mesErro .= 'Informe a frequência da pesquisa de satisfação.<br>';
                }
                $dtoConfiguracoes->setIndTipoPesquisa($indTipoPesquisa);
            }
            
            $indDatasFestivas = isset($_POST['indDatasFestivas']);
            $dtoConfiguracoes->setIndDatasFestivas($indDatasFestivas);
            
            $strDatasFestivas = isset($_POST['strDatasFestivas']) ? $_POST['strDatasFestivas'] : null;
            if(!$dtoConfiguracoes->setStrDatasFestivas($strDatasFestivas)){
                $mesErro .= 'Parece que você usou tags inválidas para os SMS de datas festivas. <br>';
            }
            
            $indAniversario = isset($_POST['indAniversario']);
            $dtoConfiguracoes->setIndAniversario($indAniversario);
            
            $strAniversario = isset($_POST['strAniversario']) ? $_POST['strAniversario'] : null;
            if(!$dtoConfiguracoes->setStrAniversario($strAniversario)){
                $mesErro .= 'Parece que você usou tags inválidas para os SMS de aniversário. <br>';
            }
            
            $arrDados = $dtoConfiguracoes->getArrayBanco();
            
            if($mesErro == '')
                
            
            if($mesErro == ''){
                if(!$modMain->atualizar('configuracoes', $arrDados, array('cdnClinica' => $_SESSION['cdnClinica'])))
                    return ERRO_CADASTRO;
                else
                    return true;
            }else{
                return $mesErro;
            }
        }
        
        public function smsCadastrarPesquisa($cdnConsulta, $datConsulta, $horaFimConsulta, $numTelefone, $cdnPaciente){
            $dtoSatisfacao = new DTOSms_satisfacao();
            $datSatisfacao = $datConsulta.' '.$horaFimConsulta;
            
            if(!$dtoSatisfacao->setCdnConsulta($cdnConsulta))
                return false;
            if(!$dtoSatisfacao->setDatSatisfacao($datSatisfacao))
                return false;
            if(!$dtoSatisfacao->setNumTelefone($numTelefone)){
                return false;
            }
            if(!$dtoSatisfacao->setCdnPaciente($cdnPaciente))
                return false;
            
            return $this->inserir('sms_satisfacao', $dtoSatisfacao->getArrayBanco());
        }
    }
