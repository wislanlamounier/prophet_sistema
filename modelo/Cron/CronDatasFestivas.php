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

    // Base
    $ds = DIRECTORY_SEPARATOR;
    $modMain = new ModeloMain(false, true, 'prophet_main', USUARIO_BANCO, SENHA_BANCO);

    // Todas clinicas
    $arrClinicas = $modMain->consultar('clinica');

    // Varrendo clinica por clinica
    foreach ($arrClinicas as $arrClinica) {

        // Pega as configurações da clínica
        $configuracoes = $modMain->getConfiguracoes($arrClinica['cdnClinica']);

        if (!$configuracoes->getIndAniversario())
            continue;

        // Conecta com o banco dessa clínica
        $modClinica = new ModeloSms(false, true, 'prophet_' . $arrClinica['nomBanco'], USUARIO_BANCO, SENHA_BANCO);

        $sqlCampo = 'SELECT * FROM schema_campo
                     WHERE nomCampo = "numTelefone1"';
        $existe = $modClinica->query($sqlCampo);
        if (count($existe) < 1)
            continue;

        $sqlCampo = 'SELECT * FROM schema_campo
                     WHERE nomCampo = "datNascimento"';
        $existe = $modClinica->query($sqlCampo);
        if (count($existe) < 1)
            continue;

        // SQL dos pacientes que frequentaram a clínica nos últimos 6 meses
        $inicio = date('Y-m-d', strtotime('-3 months'));
        $fim = date('Y-m-d');
        $sql = 'SELECT * FROM paciente p
                JOIN consulta c ON c.cdnPaciente = p.cdnPaciente 
                WHERE c.datConsulta >= "' . $inicio . '" AND c.datConsulta <= "' . $fim . '" AND p.numTelefone1 != "" 
                AND p.datNascimento = "' . date('Y-m-d') . '"
                GROUP BY p.cdnPaciente';
        $arrPacientes = $modClinica->query($sql);
        foreach ($arrPacientes as $arrPaciente) {
            $numTelefone = $arrPaciente['numTelefone1'];
            if (trim($numTelefone) != '') {
                $numTelefone = str_replace(' ', '', $numTelefone);
                $numTelefone = str_replace('(', '', $numTelefone);
                $numTelefone = str_replace(')', '', $numTelefone);
                $numTelefone = str_replace('-', '', $numTelefone);
                $numTelefone = '55' . $numTelefone;
                if (substr($numTelefone, 0, 5) == '55555') {
                    $numTelefone = substr($numTelefone, 2);
                }

                if ($numTelefone[4] == 3)
                    continue;

                if (count($numTelefone) >= 12) {
                    // Monta o DTO do SMS
                    $dtoSms = new DTOSms();
                    $dtoSms->setDatEnvio(date('Y-m-d H:i:s'));
                    $dtoSms->setCdnUsuario(0);
                    $dtoSms->setCdnPaciente($arrPaciente['cdnPaciente']);
                    $dtoSms->setNumTelefone($numTelefone);
                    // Este ID deve ser único para todos SMS de todas clínicas
                    $dtoSms->setNumIdZenvia(uniqid(rand()));

                    // Pega as informações para as tags
                    $nomPaciente = $arrPaciente['nomPaciente'];
                    $nomSobrenome = isset($arrPaciente['nomSobrenome']) ? $arrPaciente['nomSobrenome'] : '';
                    $nomCompleto = trim($nomPaciente . ' ' . $nomSobrenome);
                    $nomClinica = $arrClinica['nomClinica'];

                    // Monta o texto
                    $texto = $configuracoes->getStrDatasFestivas();
                    $tags = array(
                        '%paciente%' => $nomPaciente,
                        '%pacienteCompleto%' => $nomCompleto,
                        '%horario%' => $horarioConsulta,
                        '%dataFestiva%' => $subst,
                        '%data%' => date('d/m/Y'),
                    );
                    foreach ($tags as $tag => $valor) {
                        $texto = str_replace($tag, $valor, $texto);
                    }
                    $dtoSms->setStrTexto($texto);

                    // Se conseguiu gravar o SMS no banco...
                    if ($modClinica->inserir('sms', $dtoSms->getArrayBanco())) {
                        // Envia o sms
                        $retorno = $modClinica->smsEnviarFim($dtoSms, true);
                        if (is_array($retorno)) {
                            $modClinica->deletar('sms', array('cdnSms' => $cdnSms));
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
                    }
                }
            }
        }
    }

    /**
     * Calcula a data da Páscoa dado o Ano,
     * através do algoritmo de Meeus/Jones/Butcher:
     * (Algoritmo retirado da Wikipedia)
     *
     * @return Unix timestamp  Data da Páscoa
     */
    function calcDataPascoa() {

        $a = fmod(date('Y'), 19);
        $b = floor(date('Y') / 100);
        $c = fmod(date('Y'), 100);
        $d = floor($b / 4);
        $e = fmod($b, 4);
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = fmod((19 * $a + $b - $d - $g + 15), 30);
        $i = floor($c / 4);
        $k = fmod($c, 4);
        $l = fmod((32 + 2 * $e + 2 * $i - $h - $k), 7);
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $mes = floor(($h + $l - 7 * $m + 114) / 31);
        $dia = fmod(($h + $l - 7 * $m + 114), 31) + 1;
        return date('d/m', mktime(0, 0, 0, $mes, $dia, date('Y')));
    }

    function contaPaciente($dtoSms, $modClinica, $envio = true) {
        if ($modClinica->checaExiste('sms_contagem_paciente', 'cdnPaciente', $dtoSms->getCdnPaciente())) {
            $dtoCont = $modClinica->getRegistro('sms_contagem_paciente', 'cdnPaciente', $dtoSms->getCdnPaciente());
            if ($envio)
                $dtoCont->setNumEnvios($dtoCont->getNumEnvios() + 1);
            else
                $dtoCont->setNumRecebimentos($dtoCont->getNumRecebimentos() + 1);
            $modClinica->alterar('sms_contagem_paciente', $dtoCont->getArrayBanco(), array('cdnPaciente' => $dtoSms->getCdnPaciente()));
        } else {
            $dtoCont = new DTOSms_contagem_paciente();
            $dtoCont->setCdnPaciente($dtoSms->getCdnPaciente());
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
    