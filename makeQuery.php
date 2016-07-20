<?php

    
    if(isset($_POST['make'])){
        ini_set('max_execution_time', 0);
        require_once 'inc/autoload.inc.php';
        require_once 'inc/locales.inc.php';

        // define('HOST', '93.188.167.166');
        // define('USUARIO_BANCO', 'backup');
        // define('SENHA_BANCO', 'bentonet2412');
        // define('BANCO', 'teste');

        define('HOST', 'localhost');
        define('USUARIO_BANCO', 'root');
        if($_SERVER['HTTP_HOST'] == 'localhost:8083'){
            define('SENHA_BANCO', '');
        }else{
            define('SENHA_BANCO', 'bentonet2412');
        }

        $ds = DIRECTORY_SEPARATOR;
        $modMain = new Modelo(false, true, 'prophet_main', USUARIO_BANCO, SENHA_BANCO);
        $arrClinicas = $modMain->consultar('clinica');
        
        $query = $_POST['query'];
        $final = '';
        foreach($arrClinicas as $arrClinica){
            $final .= PHP_EOL.'use prophet_'.$arrClinica['nomBanco'].';'.PHP_EOL.$query.PHP_EOL;
        }
        
        $final .= PHP_EOL.'use prophet_model; '.PHP_EOL.$query.PHP_EOL;
        
        file_put_contents('query.sql', $final);
        $arquivo = 'query.sql';
        
        header("Content-type: application/sql");
        header("Content-Disposition: attachment; filename=$arquivo");
        header("Content-length: " . filesize($arquivo));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$arquivo");
        unlink($arquivo);
    }else{
    
?>
    
<form action="#" method="post">
    <textarea name="query"></textarea>
    <input type="submit" name="make">
</form>
<?php
    }
?>