<?php


    class User{
        private $FieldsValidation = array(
        );
        private $FieldsMasks = array(
        );
        public $FieldsErrors = array(
        );
        public $FieldsForm = array(
        );
        use Validation;
        use DTO;
        private $cdnUsuario;
        private $strEmail;
        private $strSenha;
        private $nomUsuario;
        private $cdnClinica;

    }
