<?php

    session_start();

    // Dir config
    include_once('config/dirList.php');
    
    // Password hasher
    include_once(_CONFIG_ROOT_DIR.'password.inc.php');

    // Constants
    include_once(_CONFIG_ROOT_DIR.'constants.inc.php');

    // Autoload
    include_once(_CONFIG_ROOT_DIR.'exec/autoload.inc.php');

    // Database connection_status
    include_once(_CONFIG_ROOT_DIR.'database/dbConnection.inc.php');

    // Errors handler
    include_once(_CONFIG_ROOT_DIR.'errors/errorHandler.inc.php');

    // Error messages
    include_once(_CONFIG_ROOT_DIR.'errors/messagesLocales.inc.php');

    // Code execution
    include_once(_CONFIG_ROOT_DIR.'exec/exec.inc.php');
