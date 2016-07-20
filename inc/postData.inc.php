<?php

    /**
     * Arquivo utilizado para realizar as transformações e nas datas enviadas por formulário
     *
    **/
    foreach($_POST as $nome => $valor){
        if(substr($nome, 0, 3) == 'dat'){
            $valor = explode('/', $valor);
            if(count($valor) == 3){
                $valor = $valor[2].'-'.$valor[1].'-'.$valor[0];
                $_POST[$nome] = $valor;
            }
        }
    }