<?php

    /**
     *  Crypt the password when a post variable is detected
     */
    if(isset($_POST['strSenha'])){
        if(trim($_POST['strSenha']) != '')
            $_POST['strSenha'] = crypt($_POST['strSenha'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }
    if(isset($_POST['confSenha'])){
        if(trim($_POST['confSenha']) != '')
            $_POST['confSenha'] = crypt($_POST['confSenha'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }
    
    if(isset($_POST['password'])){
        if(trim($_POST['password']) != '')
            $_POST['password'] = crypt($_POST['password'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }
    if(isset($_POST['passwordConfirm'])){
        if(trim($_POST['passwordConfirm']) != '')
            $_POST['passwordConfirm'] = crypt($_POST['passwordConfirm'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
    }