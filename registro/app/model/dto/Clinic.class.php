<?php

    class Clinic {

        private $FieldsValidation = array();
        private $FieldsMasks = array();
        public $FieldsErrors = array();
        public $FieldsForm = array();

        use Validation;

        use DTO;

        private $cdnClinica;
        private $cdnUsuario;
        private $codCep;
        private $codCpfCnpj;
        private $codUf;
        private $desClinica;
        private $indFisica;
        private $nomBanco;
        private $nomCidade;
        private $nomClinica;
        private $nomFacebook;
        private $numTelefone1;
        private $numTelefone2;
        private $numWhatsapp;
        private $strEmail;
        private $strEndereco;
        private $strSite;
        private $indProntuario = 1;
        private $numEnviosSms = 0;
        private $numRecebimentosSms = 0;
        private $datCadastro;
        private $numLimiteSms = 100;
        private $indDesativada = 0;
        private $codCroPrimeiro;
        private $desTamanhoClinica;

        public function __construct() {
            $this->datCadastro = date('Y-m-d');
        }

    }
