<html>
    <header>
        <title>Prophet | <?php echo $title; ?></title>
        <meta charset="utf-8">
        <base href="<?php echo _BASE_URL; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?= _APP_ROOT_DIR; ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= _APP_ROOT_DIR; ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="plugins/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
        
        <link href="<?= _APP_ROOT_DIR; ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?= _APP_ROOT_DIR; ?>assets/css/style.css" rel="stylesheet">

    </header>

    <body class="gray-bg">

        <div class="loginColumns animated fadeInDown">
            <?php include_once(_CONFIG_ROOT_DIR . 'check/getMessages.inc.php'); ?>