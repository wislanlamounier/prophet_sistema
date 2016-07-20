<?php

    /**
     * Arquivo de execução dos métodos
     *
     * */
    if (!$ajax) {
        if (!isset($_SESSION['erroPHP']))
            $_SESSION['erroPHP'] = '';
        if (!isset($_SESSION['flash']))
            $_SESSION['flash'] = '';

        $comp = strrchr($_SERVER['REQUEST_URI'], '?');
        $end = str_replace($comp, '', $_SERVER['REQUEST_URI']);
        $url = explode('/', $end);
        array_shift($url);

        if (trim($url[0]) == '')
            unset($url[0]);

        if (isset($url[0])) {
            if (isset($url[1])) {
                if (trim($url[1]) != '') {
                    $acao = lcfirst($url[0]) . ucFirst($url[1]);
                } else {
                    $acao = lcfirst($url[0]) . 'Consultar';
                }
            } else {
                $acao = lcfirst($url[0]) . 'Consultar';
            }
            if (!isset($controlador))
                $controlador = 'Controle' . ucfirst($url[0]);
        }else {
            $controlador = 'Controlador';
            $acao = 'inicio';
        }
        $params = '';
        if (isset($url[2])) {
            if (trim($url[2]) != '') {
                for ($i = 2; $i < count($url); $i++) {
                    if (trim($url[$i]) != '')
                        if (filter_var($url[$i], FILTER_VALIDATE_INT) or $url[$i] === 0)
                            $params .= '' . str_replace('%20', '-', $url[$i]) . ',';
                        else
                            $params .= '"' . str_replace('%20', '-', $url[$i]) . '",';
                }
            }
        }
        $params = trim($params, ',');
        if (class_exists($controlador)) {
            eval('$controlador = new ' . $controlador . '("' . $controlador . '","' . $acao . '");');
            $controlador = new $controlador($controlador, $acao);
            if (method_exists($controlador, $acao)) {
                eval('$controlador->' . $acao . '(' . $params . ');');
            } else {
                $_SESSION['erroPHP'] = 'Desculpe, não entendi.';
                $controlador->inicio();
            }
        } else {
            if ($controlador != '')
                $_SESSION['erroPHP'] = 'Desculpe, não entendi.';
            $controle = new Controlador();
            $controle->inicio();
        }
    }
