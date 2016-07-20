<?php

    /**
     * DTO class for errors
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-07-03
     * @param String $error - error description
     * @param String $file - error file
     * @param Integer $line - error line
     * @param Datetime $date - date of the error
     *
    **/
    class Error {
        use DTO;
        private $error;
        private $file;
        private $line;
        private $date;

        /**
         * Setter of error description
         *
         * @param String $error - error description
         *
        **/
        public function setError($error){
            $this->error = $error;
        }

        /**
         * Getter of error description
         *
         * @return String - error description
         *
        **/
        public function getError(){
            return $this->error;
        }

        /**
         * Setter of error file
         *
         * @param String $file - error file
         *
        **/
        public function setFile($file){
            $this->file = $file;
        }

        /**
         * Getter of error file
         *
         * @return String - error file
         *
        **/
        public function getFile(){
            return $this->file;
        }

        /**
         * Setter of error line
         *
         * @param Integer $line - error line
         *
        **/
        public function setLine($line){
            $this->line = $line;
        }

        /**
         * Getter of error line
         *
         * @return Integer - error line
         *
        **/
        public function getLine(){
            return $this->line;
        }

        /**
         * Setter of error date
         *
         * @param Datetime $date - error date
         *
        **/
        public function setDate($date){
            $this->date = $date;
        }

        /**
         * Getter of error date
         *
         * @return Datetime - error date
         *
        **/
        public function getDate(){
            return $this->date;
        }
    }
