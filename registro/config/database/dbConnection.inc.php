<?php

/**
 * Database connection config
 *
 * */
if ($_SERVER['HTTP_HOST'] == 'localhost:8090') {
    define('_HOST', 'localhost');
    define('_DATABASE', 'prophet_main');
    define('_DATABASE_USER', 'root');
    define('_DATABASE_PASSWORD', '');
} else {
    define('_HOST', 'localhost');
    define('_DATABASE', 'prophet_main');
    define('_DATABASE_USER', 'root');
    define('_DATABASE_PASSWORD', 'bentonet2412');
}
