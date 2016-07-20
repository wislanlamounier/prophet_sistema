<?php

    if(date('d') != 1)
        die;

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


    // Base
    $ds = DIRECTORY_SEPARATOR;
    $modMain = new ModeloMain(false, true, 'prophet_main', USUARIO_BANCO, SENHA_BANCO);

    // Todas clinicas
    $arrClinicas = $modMain->consultar('clinica');

    // Varrendo clinica por clinica
    foreach ($arrClinicas as $arrClinica) {

        $arrClinica['numEnviosSms'] = 0;
        $arrClinica['numRecebimentosSms'] = 0;
        $modMain->atualizar('clinica', $arrClinica, array('cdnClinica' => $arrClinica['cdnClinica']));
    }
    