<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    
    // Autoload de arquivos
    require_once 'inc/autoload.inc.php';

    // Handler dos erros
    require_once 'inc/errorHandler.inc.php';

    // Configuração do Banco
    require_once 'inc/config.inc.php';

    // Mensagens pré-definidas
    require_once 'inc/mensagens.inc.php';

    // Configurações locais
    require_once 'inc/locales.inc.php';

    // Formatação de data
    require_once 'inc/postData.inc.php';

    // Criptografia de senha
    require_once 'inc/postSenha.inc.php';

    // Arquivo de execução ajax
    require_once 'inc/ajaxExec.inc.php';

    // Execução
    require_once 'inc/exec.inc.php';
