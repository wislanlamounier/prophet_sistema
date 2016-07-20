<?php

/**
 * Handles the normal errors
 *
 * @param String $errno - type
 * @param String $errstr - error type
 * @param String $errfile - file
 * @param String $errline - line
 *
 * */
function errorHandler($errno, $errstr, $errfile, $errline) {
    if (!strpos($errstr, 'deprecated') > 0) {
        $model = new Model();
        include_once('Error.class.php');
        echo $errstr.' '.$errfile.' '.$errline;
        $error = new Error($errstr, $errfile, $errLine, date('Y-m-d H:i:s'));
        // $model->insert('error', $error);
        $_SESSION['phpError'] = _PHP_ERROR;
    }
}

/**
 * Handle the fatal errors
 *
 * */
function fatalErrorHandler() {
    $lastError = error_get_last();
    if ($lastError['type'] === E_ERROR) {
        errorHandler(E_ERROR, $lastError['message'], $lastError['file'], $lastError['line']);
        Controller::siteIndex();
    }
}

if ($_SERVER['HTTP_HOST'] == 'localhost:8090') {
    set_error_handler("errorHandler");
    register_shutdown_function('fatalErrorHandler');
}
