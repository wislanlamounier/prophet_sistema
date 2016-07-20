<?php

    /**
     * Arquivo responsável por interpretar o GET via ajax.
     *
    **/
    if(isset($_GET['controle']) and isset($_GET['acao'])){
        eval('$controle = new Controle'.ucfirst($_GET['controle']).'();');
        if(isset($_GET['param']))
            $controle->{$_GET['acao']}($_GET['param']);
        else
            $controle->{$_GET['acao']}();
        $ajax = true;
    }else{
        $ajax = false;
    }
