<?php

    // Arquivos necessários
    include_once(__DIR__ . '/../../plugins/zenvia/human_gateway_client_api/HumanClientMain.php');
    include_once(__DIR__ . '/../../inc/locales.inc.php');
    include_once(__DIR__ . '/../trait/Transformacao.trait.php');
    include_once(__DIR__ . '/../trait/Validacao.trait.php');
    include_once(__DIR__ . '/../DTO/DTO.trait.php');
    include_once(__DIR__ . '/../Modelo.class.php');
    include_once(__DIR__ . '/../ModeloMain.class.php');
    include_once(__DIR__ . '/../ModeloSms.class.php');
    include_once(__DIR__ . '/../ModeloPaciente.class.php');
    include_once(__DIR__ . '/../DTO/DTOSms.class.php');
    include_once(__DIR__ . '/../DTO/DTOSms_aviso_consulta.class.php');
    include_once(__DIR__ . '/../DTO/DTOSms_satisfacao.class.php');
    include_once(__DIR__ . '/../DTO/DTODentista_satisfacao.class.php');
    include_once(__DIR__ . '/../DTO/DTOConfiguracoes.class.php');
    include_once(__DIR__ . '/../DTO/DTOSms_contagem_paciente.class.php');

    // Conexão banco
    define('HOST', 'localhost');
    define('USUARIO_BANCO', 'root');
    if ($_SERVER['HTTP_HOST'] == 'localhost:8083') {
        define('SENHA_BANCO', '');
    } else {
        define('SENHA_BANCO', 'bentonet2412');
    }
    define('BANCO', 'prophet_main');

    // Conexão zenvia
    $account = "odontoassist.api";
    $password = "UBSlA8Rnw6";
    $sender = new HumanQueryMessage($account, $password);
    $messages = $sender->listReceivedSMS();
    // $messages = file_get_contents('serialize.txt');
    // $messages = unserialize($messages);
    // Base
    $ds = DIRECTORY_SEPARATOR;
    $modMain = new ModeloMain(false, true, 'prophet_main', USUARIO_BANCO, SENHA_BANCO);

    // Todas clinicas
    $arrClinicas = $modMain->consultar('clinica');
    file_put_contents('relatorio.txt', 'Início: ' . date('Y-m-d H:i:s') . PHP_EOL);
    // Varrendo clinica por clinica
    foreach ($arrClinicas as $arrClinica) {

        $totalSms = $arrClinica['numEnviosSms'] + $arrClinica['numRecebimentosSms'];

        logs('Clinica: ' . $arrClinica['nomClinica']);

        // Calcular a pesquisa de satisfação ou não
        $calcularSatisfacao = false;

        // Pega as configurações da clínica
        $configuracoes = $modMain->getConfiguracoes($arrClinica['cdnClinica']);

        // Conecta com o banco dessa clínica
        $modClinica = new ModeloSms(false, true, 'prophet_' . $arrClinica['nomBanco'], USUARIO_BANCO, SENHA_BANCO);

        // Intervalo de tempo de 5 minutos
        $inicio = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 5) + 1);
        $fim = date('Y-m-d H:i:s');
        if($totalSms <= $arrClinica['numLimiteSms']) {
            // SQL pra ver se tem que avisar algum paciente
            $sql = '
                SELECT * FROM sms_aviso_consulta s
                JOIN consulta c ON c.cdnConsulta = s.cdnConsulta
                JOIN paciente p ON p.cdnPaciente = s.cdnPaciente
                JOIN prophet_main.usuario u ON c.cdnDentista = u.cdnUsuario
                WHERE s.cdnSms IS NULL AND "' . $inicio . '" <= s.datAviso AND "' . $fim . '" >= s.datAviso
                ORDER BY c.horaConsulta
            ';

            $arrAvisosConsulta = $modClinica->query($sql);
    
            // Se precisar avisar pacientes...
            if (count($arrAvisosConsulta)) {
                logs('Encontrou avisos...');

                foreach ($arrAvisosConsulta as $arrAvisoConsulta) {
                    logs('Realizando montagem de SMS...');
                    // Monta DTO do SMS
                    $dtoAviso = $modClinica->getRegistro('sms_aviso_consulta', 'cdnConsulta', $arrAvisoConsulta['cdnConsulta']);
                    $dtoSms = new DTOSms();
                    $dtoSms->setDatEnvio(date('Y-m-d H:i:s'));
                    $dtoSms->setCdnUsuario(0);
                    $dtoSms->setCdnPaciente($arrAvisoConsulta['cdnPaciente']);
                    $dtoSms->setNumTelefone($dtoAviso->getNumTelefone());
                    // Este ID deve ser único para todos SMS de todas clínicas
                    $dtoSms->setNumIdZenvia(uniqid(rand()));

                    // Pega as informações para as tags
                    $nomPaciente = $arrAvisoConsulta['nomPaciente'];
                    $nomSobrenome = isset($arrAvisoConsulta['nomSobrenome']) ? $arrAvisoConsulta['nomSobrenome'] : '';
                    $nomCompleto = trim($nomPaciente . ' ' . $nomSobrenome);
                    $horarioConsulta = $arrAvisoConsulta['horaConsulta'];
                    $datConsulta = $dtoSms->transformacaoData($arrAvisoConsulta['datConsulta']);
                    $nomClinica = $arrClinica['nomClinica'];
                    $nomUsuario = $arrAvisoConsulta['nomUsuario'];

                    // Monta o texto
                    $texto = $configuracoes->getStrAvisoConsulta();
                    $tags = array(
                        '%paciente%'         => $nomPaciente,
                        '%pacienteCompleto%' => $nomCompleto,
                        '%horario%'          => $horarioConsulta,
                        '%dataConsulta%'     => $datConsulta,
                        '%clinica%'          => $nomClinica,
                        '%profissional%'     => $nomUsuario,
                        '%data%'             => date('d/m/Y'),
                    );
                    foreach ($tags as $tag => $valor) {
                        $texto = str_replace($tag, $valor, $texto);
                    }
                    $dtoSms->setStrTexto($texto);
                    logs('Setou texto: ' . $texto);

                    // Se conseguiu gravar o SMS no banco...
                    if ($modClinica->inserir('sms', $dtoSms->getArrayBanco())) {
                        logs('Gravou no banco.');
                        // GRAVAR O CONTADOR AQUI
                        // Realiza a associação do SMS cadastrado agora no banco
                        // com o registro de aviso da tabela sms_aviso_consulta banco
                        $cdnSms = $modClinica->ultimoInserido('sms');
                        $dtoSms->setCdnSms($cdnSms);
                        $dtoAviso->setCdnSms($cdnSms);
                        if (!$modClinica->atualizar('sms_aviso_consulta', $dtoAviso->getArrayBanco(), array('cdnConsulta' => $dtoAviso->getCdnConsulta()))) {
                            logs('!!!!!!!!!Não conseguiu linkar o aviso com o SMS!!!!!!!!!');
                            $modClinica->deletar('sms', array('cdnSms' => $cdnSms));
                            registraErro($dtoAviso, $modClinica);
                            continue;
                        }
                        $retorno = $modClinica->smsEnviarFim($dtoSms, true);
                        if (is_array($retorno)) {
                            logs('!!!!!!!!!Não conseguiu enviar o SMS, erro ZENVIA!!!!!!!!!');
                            $modClinica->deletar('sms', array('cdnSms' => $cdnSms));
                            registraErro($dtoAviso, $modClinica, $retorno[1]);
                            continue;
                        }

                        // Guarda a contagem de SMS enviados/recebidos no banco
                        // facilita os cálculos posteriormente
                        contaPaciente($dtoSms, $modClinica);

                        if (is_null($arrClinica['numEnviosSms'])) {
                            $arrClinica['numEnviosSms'] = 1;
                        } else {
                            $arrClinica['numEnviosSms'] = $arrClinica['numEnviosSms'] + 1;
                        }

                        logs('SMS Enviado com sucesso.');
                    } else {
                        logs('!!!!!!!!!Não gravou SMS no banco!!!!!!!!!');
                        // Se não gravou...
                        registraErro($dtoAviso, $modClinica);
                        continue;
                    }
                }
            }
    
    
            // SQL pra ver se tem que enviar pesquisa de satisfação
            if ($configuracoes->getIndPesquisa()) {
                logs('Pesquisa de satisfação ativada');
                $sql = '
                    SELECT * FROM sms_satisfacao s
                    JOIN consulta c ON c.cdnConsulta = s.cdnConsulta
                    JOIN paciente p ON p.cdnPaciente = s.cdnPaciente
                    JOIN prophet_main.usuario u ON c.cdnDentista = u.cdnUsuario
                    WHERE s.cdnSms IS NULL AND "' . $inicio . '" <= s.datSatisfacao AND "' . $fim . '" >= s.datSatisfacao
                    ORDER BY c.horaConsulta
                ';
                $arrPesquisas = $modClinica->query($sql);
                foreach ($arrPesquisas as $arrPesquisa) {
                    logs('Montando pesquisa...');
                    // Monta DTO do SMS
                    $dtoSatisfacao = $modClinica->getRegistro('sms_satisfacao', 'cdnConsulta', $arrPesquisa['cdnConsulta']);
                    $dtoSms = new DTOSms();
                    $dtoSms->setDatEnvio(date('Y-m-d H:i:s'));
                    $dtoSms->setCdnUsuario(0);
                    $dtoSms->setCdnPaciente($arrPesquisa['cdnPaciente']);
                    $dtoSms->setNumTelefone($arrPesquisa['numTelefone']);
                    // Este ID deve ser único para todos SMS de todas clínicas
                    $dtoSms->setNumIdZenvia(uniqid(rand()));

                    // Pega as informações para as tags
                    $nomPaciente = $arrPesquisa['nomPaciente'];
                    $nomSobrenome = isset($arrAvisoConsulta['nomSobrenome']) ? $arrPesquisa['nomSobrenome'] : '';
                    $nomCompleto = trim($nomPaciente . ' ' . $nomSobrenome);
                    $horarioConsulta = $arrPesquisa['horaConsulta'];
                    $datConsulta = $dtoSms->transformacaoData($arrPesquisa['datConsulta']);
                    $nomClinica = $arrClinica['nomClinica'];
                    $nomUsuario = $arrPesquisa['nomUsuario'];

                    // Monta o texto
                    $texto = $configuracoes->getStrPesquisa();
                    $tags = array(
                        '%paciente%'         => $nomPaciente,
                        '%pacienteCompleto%' => $nomCompleto,
                        '%horario%'          => $horarioConsulta,
                        '%dataConsulta%'     => $datConsulta,
                        '%clinica%'          => $nomClinica,
                        '%profissional%'     => $nomUsuario,
                        '%data%'             => date('d/m/Y'),
                    );
                    foreach ($tags as $tag => $valor) {
                        $texto = str_replace($tag, $valor, $texto);
                    }
                    $dtoSms->setStrTexto($texto);
                    logs('Setou texto: ' . $texto);
                    // Se conseguiu gravar o SMS no banco...
                    if ($modClinica->inserir('sms', $dtoSms->getArrayBanco())) {
                        logs('Gravou no banco.');

                        // Realiza a associação do SMS cadastrado agora no banco
                        // com o registro de aviso da tabela sms_satisfacao banco
                        $cdnSms = $modClinica->ultimoInserido('sms');
                        $dtoSms->setCdnSms($cdnSms);
                        $dtoSatisfacao->setCdnSms($cdnSms);
                        if (!$modClinica->atualizar('sms_satisfacao', $dtoSatisfacao->getArrayBanco(), array('cdnConsulta' => $dtoSatisfacao->getCdnConsulta()))) {
                            logs('!!!!!!!!!Não conseguiu linkar a pesquisa com o SMS!!!!!!!!!');
                            $modClinica->deletar('sms', array('cdnSms' => $cdnSms));
                            registraErro($dtoSatisfacao, $modClinica, 1, 'satisfacao');
                            continue;
                        }
                        $retorno = $modClinica->smsEnviarFim($dtoSms, true);
                        if (is_array($retorno)) {
                            logs('!!!!!!!!!Não conseguiu enviar o sms, erro ZENVIA!!!!!!!!!');
                            $modClinica->deletar('sms', array('cdnSms' => $cdnSms));
                            registraErro($dtoSatisfacao, $modClinica, $retorno[1], 'satisfacao');
                            continue;
                        }

                        // Guarda a contagem de SMS enviados/recebidos no banco
                        // facilita os cálculos posteriormente
                        contaPaciente($dtoSms, $modClinica);

                        if (is_null($arrClinica['numEnviosSms'])) {
                            $arrClinica['numEnviosSms'] = 1;
                        } else {
                            $arrClinica['numEnviosSms'] = $arrClinica['numEnviosSms'] + 1;
                        }

                        logs('Pesquisa enviada com sucesso.');
                    } else {
                        logs('!!!!!!!!!Não gravou no banco!!!!!!!!!');
                        // Se não gravou...
                        registraErro($dtoSatisfacao, $modClinica, 1, 'satisfacao');
                        continue;
                    }
                }
            }

        }


        // Se existe alguma resposta no servidor da Zenvia
        if (is_array($messages) && count($messages) > 0) {
            logs('Existem respostas no servidor');

            foreach ($messages as $message) {
                $from = $message->getFrom();
                // Varre a tabela sms_aviso_consulta para saber se
                // foi enviado algum aviso para o paciente que enviou o SMS
                // comparando o número do paciente com os números da tabela.
                $date = $message->getSchedule();
                $date = explode(' ', $date);
                $dia = explode('/', $date[0]);
                $dia = $dia[2] . '-' . $dia[1] . '-' . $dia[0];
                $date = $dia . ' ' . $date[1];
                $sqlRespostas = 'SELECT cdnConsulta FROM sms_aviso_consulta_resposta';
                $sql = 'SELECT * FROM sms_aviso_consulta s WHERE s.numTelefone = "' . $from . '" AND
                        s.datAviso < "' . $date . '" AND cdnSms IS NOT NULL AND s.cdnConsulta NOT IN (' . $sqlRespostas . ')
                         ORDER BY s.datAviso DESC LIMIT 1';
                $arrSms = $modClinica->query($sql);

                // Se o número do paciente que está enviando SMS bate com algum
                // aviso, registra a resposta dele.
                if (count($arrSms) > 0) {
                    logs('Resposta de aviso detectada.');
                    $arrSms = $arrSms[0];

                    // Montando o array para salvar no banco
                    $datResposta = $message->getSchedule();
                    $datResposta = explode(' ', $datResposta);
                    $data = $datResposta[0];
                    $data = explode('/', $data);
                    $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                    $datResposta[0] = $data;
                    $datResposta = implode(' ', $datResposta);
                    $arrResposta = array(
                        'cdnConsulta' => $arrSms['cdnConsulta'],
                        'strResposta' => $message->getBody(),
                        'datResposta' => $datResposta,
                    );
                    $modClinica->inserir('sms_aviso_consulta_resposta', $arrResposta);
                    // Guarda a contagem de SMS enviados/recebidos no banco
                    // facilita os cálculos posteriormente
                    contaPaciente($arrSms, $modClinica, false);

                    if (is_null($arrClinica['numRecebimentosSms'])) {
                        $arrClinica['numRecebimentosSms'] = 1;
                    } else {
                        $arrClinica['numRecebimentosSms'] = $arrClinica['numRecebimentosSms'] + 1;
                    }
                }

                if ($configuracoes->getIndPesquisa()) {
                    // Mesmo esquema dos avisos, mas agora com a pesquisa de satisfação
                    $date = $message->getSchedule();
                    $date = explode(' ', $date);
                    $dia = explode('/', $date[0]);
                    $dia = $dia[2] . '-' . $dia[1] . '-' . $dia[0];
                    $date = $dia . ' ' . $date[1];
                    $sql = 'SELECT * FROM sms_satisfacao s 
                            JOIN consulta c ON s.cdnConsulta = c.cdnConsulta
                            JOIN prophet_main.usuario u ON c.cdnDentista = u.cdnUsuario
                            WHERE s.numTelefone = "' . $from . '" AND
                            s.datSatisfacao < "' . $date . '" AND cdnSms IS NOT NULL
                             ORDER BY s.datSatisfacao DESC LIMIT 1';
                    $arrSms = $modClinica->query($sql);
                    if (count($arrSms) > 0) {
                        logs('Resposta de pesquisa de satisfação detectada.');
                        // Filtra o texto para ver se é uma nota e não um texto
                        // Se for um texto, tenta pegar a parte inteira
                        $texto = $message->getBody();

                        if (!is_numeric($texto)) {
                            $texto = filter_var($texto, FILTER_SANITIZE_NUMBER_INT);
                            if ($texto == '') {
                                continue;
                            } else {
                                if ($texto > 10)
                                    $texto = 10;
                                if ($texto < 0)
                                    $texto = 0;
                            }
                        } else {
                            if ($texto > 10)
                                $texto = 10;
                            if ($texto < 0)
                                $texto = 0;
                        }

                        $arrSms = $arrSms[0];

                        // Montando o DTO para salvar no banco
                        $dtoSatisfacao = new DTODentista_satisfacao();
                        $datResposta = $message->getSchedule();
                        $datResposta = explode(' ', $datResposta);
                        $data = $datResposta[0];
                        $data = explode('/', $data);
                        $data = $data[2] . '-' . $data[1] . '-' . $data[0];
                        $dtoSatisfacao->setDatSatisfacao($data);
                        $dtoSatisfacao->setCdnDentista($arrSms['cdnUsuario']);
                        $dtoSatisfacao->setCdnPaciente($arrSms['cdnPaciente']);
                        $dtoSatisfacao->setNumNota($texto);
                        $dtoSatisfacao->setCdnSatisfacao($arrSms['cdnSatisfacao']);
                        $modClinica->inserir('dentista_satisfacao', $dtoSatisfacao->getArrayBanco());
                        $calcularSatisfacao = true;
                        // Guarda a contagem de SMS enviados/recebidos no banco
                        // facilita os cálculos posteriormente
                        contaPaciente($arrSms, $modClinica, false);

                        if (is_null($arrClinica['numRecebimentosSms'])) {
                            $arrClinica['numRecebimentosSms'] = 1;
                        } else {
                            $arrClinica['numRecebimentosSms'] = $arrClinica['numRecebimentosSms'] + 1;
                        }
                    }
                }
            }
        }

        if ($calcularSatisfacao) {
            logs('Calculando média de satisfação de dentistas...');
            $sql = "SELECT AVG(numNota) as media, cdnDentista FROM dentista_satisfacao GROUP BY cdnDentista";

            $notas = $modClinica->query($sql);

            foreach ($notas as $nota) {
                $sql = 'UPDATE dentista SET numNotaSatisfacao = ' . $nota['media'] . ' WHERE cdnUsuario = ' . $nota['cdnDentista'];
                $modClinica->sql($sql);
            }
        }

        if($modMain->atualizar('clinica', $arrClinica, array('cdnClinica' => $arrClinica['cdnClinica'])))
            echo 'ok';
        else
            echo 'not okay';
    }

    function registraErro($dto, $modSms, $codErro = 1, $tipo = 'aviso_consulta') {
        // Salva um código de erro na tabela de aviso/satisfação.
        // O codErro é padrão "1" pois o resto dos números é reservados para
        // os erros de envio da própria Zenvia.
        // Quando o codErro == 1, significa que foi erro de gravação no banco
        // do próprio prophet.
        $dto->setCodErro($codErro);
        $arrData = $dto->getArrayBanco();
        $modSms->atualizar('sms_' . $tipo, $arrData, array('cdnConsulta' => $dto->getCdnConsulta()));
    }

    function logs($mensagem) {
        file_put_contents('relatorio.txt', $mensagem . PHP_EOL, FILE_APPEND);
    }

    function contaPaciente($dtoSms, $modClinica, $envio = true) {
        if(is_array($dtoSms)){
            $cdnPaciente = $dtoSms['cdnPaciente'];
        }else{
            $cdnPaciente = $dtoSms->getCdnPaciente();
        }
        if ($modClinica->checaExiste('sms_contagem_paciente', 'cdnPaciente', $cdnPaciente)) {
            $dtoCont = $modClinica->getRegistro('sms_contagem_paciente', 'cdnPaciente', $cdnPaciente);
            if ($envio)
                $dtoCont->setNumEnvios($dtoCont->getNumEnvios() + 1);
            else
                $dtoCont->setNumRecebimentos($dtoCont->getNumRecebimentos() + 1);
            $modClinica->atualizar('sms_contagem_paciente', $dtoCont->getArrayBanco(), array('cdnPaciente' => $cdnPaciente));
        } else {
            $dtoCont = new DTOSms_contagem_paciente();
            $dtoCont->setCdnPaciente($cdnPaciente);
            if ($envio) {
                $dtoCont->setNumEnvios(1);
                $dtoCont->setNumRecebimentos(0);
            } else {
                $dtoCont->setNumEnvios(0);
                $dtoCont->setNumRecebimentos(1);
            }
            $modClinica->inserir('sms_contagem_paciente', $dtoCont->getArrayBanco());
        }
    }
    