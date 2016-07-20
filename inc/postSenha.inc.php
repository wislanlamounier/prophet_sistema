<?php

    /**
     * Arquivo utilizado para realizar as transformações e encriptações nas senhas
     * sempre quando um formulário for submetido.
     *
    **/
    if(isset($_POST['strSenha'])){
        if(trim($_POST['strSenha']) != '')
            $_POST['strSenha'] = crypt($_POST['strSenha'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }
    if(isset($_POST['confSenha'])){
        if(trim($_POST['confSenha']) != '')
            $_POST['confSenha'] = crypt($_POST['confSenha'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }
