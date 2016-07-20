<?php
    include_once(__DIR__.'/../../plugins/zenvia/human_gateway_client_api/HumanClientMain.php');
    $msgs = file_get_contents('serialize.txt');
    $msgs = unserialize($msgs);
    
    print_r($msgs);
    
    $msg = $msgs[0];
    $from = $msg->getFrom();
    $date = $msg->getSchedule();
    $date = explode(' ', $date);
    $dia = explode('/', $date[0]);
    $dia = $dia[2].'-'.$dia[1].'-'.$dia[0];
    $date = $dia.' '.$date[1];
    $sql = 'SELECT * FROM sms_aviso_consulta s WHERE s.numTelefone = "'.$from.'" AND
                        s.datAviso < "'.$date.'" AND cdnSms IS NOT NULL
                         ORDER BY s.datAviso DESC LIMIT 1';
    echo $sql;

