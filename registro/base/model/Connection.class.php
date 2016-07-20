<?php

    /**
     * Class used to take care of the database connection
     *
    **/

    class Connection{

        protected static $pdo;

        /**
         * Constructo method
         *
         * @param Boolean $debug - set debug option. Default: true.
         * @param String $database - database name
         * @param String $user - database user
         * @param String $password - database password
        **/
        private function __construct($debug = true, $database = _DATABASE, $user = _DATABASE_USER, $password = _DATABASE_PASSWORD, $host = _HOST) {
            
            $this->debug = $debug;

            try{
                self::$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $user, $password);

                if($debug)
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                self::$pdo->query("SET NAMES 'utf8'");
                self::$pdo->query('SET character_set_connection=utf8');
                self::$pdo->query('SET character_set_client=utf8');
                self::$pdo->query('SET character_set_results=utf8');
            }
            catch (PDOException $e){
                if($this->debug)
                    echo _PDO_ERROR.$e->getMessage();
                return false;
            }
        }

        public static function getConnection($debug = true, $database = _DATABASE, $user = _DATABASE_USER, $password = _DATABASE_PASSWORD, $host = _HOST) {
            if (!self::$pdo)
                new Connection($debug, $database, $user, $password, $host);
            return self::$pdo;
        }

        public static function closeConnection(){
            self::$pdo = null;
        }

        public static function restartConnection(){
            self::$pdo = null;
            new Connection();
        }
    }
