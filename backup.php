<?php

    ini_set('max_execution_time', 0);
    require_once 'inc/autoload.inc.php';
    require_once 'inc/locales.inc.php';

    // define('HOST', '93.188.167.166');
    // define('USUARIO_BANCO', 'backup');
    // define('SENHA_BANCO', 'bentonet2412');
    // define('BANCO', 'teste');

    define('HOST', 'localhost');
    define('USUARIO_BANCO', 'root');
    if ($_SERVER['HTTP_HOST'] == 'localhost:8083') {
        define('SENHA_BANCO', '');
    } else {
        define('SENHA_BANCO', 'bentonet2412');
    }

    $ds = DIRECTORY_SEPARATOR;
    $modMain = new Modelo(false, true, 'prophet_main', USUARIO_BANCO, SENHA_BANCO);
    $arrClinicas = $modMain->consultar('clinica');

    $nomBackup = date('Y-m-d');
    $dir = 'backups/geral/' . $nomBackup;
    $data = date('Y-m-d');

    if (!is_dir($dir))
        mkdir($dir, 777, true);

    $dbpass = SENHA_BANCO;
    $dbuser = 'root';
    $dbhost = HOST;

    foreach ($arrClinicas as $arrClinica) {
        $modClinica = new Modelo(false, true, 'prophet_' . $arrClinica['nomBanco'], USUARIO_BANCO, SENHA_BANCO);

        $backup_file = $dir . $ds . $arrClinica['cdnClinica'] . '.sql';

        $db = 'prophet_' . $arrClinica['nomBanco'];

        // LEMBRAR DE TROCAR ISSO AQUI
        // if(LOCAL == 'web'){
        //     $command = "mysqldump ";
        // }else{
        $command = "c:" . $ds . "xampp" . $ds . "mysql" . $ds . "bin" . $ds . "mysqldump ";
        // }

        if ($dbpass != '')
            $command .= "--opt -h $dbhost -u $dbuser -p $dbpass $db > $backup_file";
        else
            $command .= "--opt -h $dbhost -u $dbuser $db > $backup_file";

        system($command, $ret);
    }


    // LEMBRAR DE TROCAR ISSO AQUI
    // if(LOCAL == 'web'){
    //     $command = "mysqldump ";
    // }else{
    $command = "c:" . $ds . "xampp" . $ds . "mysql" . $ds . "bin" . $ds . "mysqldump ";
    // }

    if ($dbpass != '')
        $command .= "--opt -h $dbhost -u $dbuser -p $dbpass prophet_main > " . $dir . "/main.sql";
    else
        $command .= "--opt -h $dbhost -u $dbuser prophet_main > " . $dir . "/main.sql";

    system($command, $ret);


    $arrBackup = array(
        'cdnClinica' => 0,
        'cdnUsuario' => null,
        'datBackup' => date('Y-m-d H:i:s'),
        'nomArquivo' => 'backups/' . $data . '/' . $data . '.zip'
    );
    $modMain->inserir('backup', $arrBackup);

    $zip = new ZipArchive();
    $zip->open($dir . '.zip', ZipArchive::CREATE);

    $rootPath = $dir;
    $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
    );
    $filesToDelete = array();
    foreach ($files as $name => $file) {
        // Skip directories (they would be added automatically)
        if (!$file->isDir()) {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);

            // Add current file to "delete list"
            // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
            if ($file->getFilename() != 'important.txt') {
                $filesToDelete[] = $filePath;
            }
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();

    // Delete all files from "delete list"
    foreach ($filesToDelete as $file) {
        unlink($file);
    }

    rename($dir . '.zip', $dir . '/' . $data . '.zip');


    echo 'Processo finalizado!';
    