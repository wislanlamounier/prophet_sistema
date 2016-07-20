<?php
    
    /**
     * Classe responsável pelo mantimento de dados de transição com o banco
     * envolvendo a tabela clinica
     *
     * @autor Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-11
     *
     * */
    class DTOClinica {
        
        use DTO;
        
        use Validacao;
        
        use Transformacao;
        
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
        private $indProntuario;
        private $numEnviosSms;
        private $numRecebimentosSms;
        private $datCadastro;
        private $numLimiteSms;
        private $indDesativada;
        private $codCroPrimeiro;
        private $desTamanhoClinica;

        /**
         * Método responsável por setar o valor do código numérico da clínica
         *
         * @param Integer $cdnClinica - código numérico da clinica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnClinica($cdnClinica) {
            if ($this->validacaoNumero($cdnClinica)) {
                $this->cdnClinica = $cdnClinica;
                
                return true;
            }
            
            return false;
        }
        
        /**
         * Método responsável por retornar o código numérico do clínica
         *
         * @return Integer - código numérico do clínica
         *
         * */
        public function getCdnClinica() {
            return $this->cdnClinica;
        }
        
        /**
         * Método responsável por setar o valor do código numérico do usuário
         *
         * @param Integer $cdnUsuario - código numérico do usuário
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCdnUsuario($cdnUsuario) {
            if ($this->validacaoNumero($cdnUsuario)) {
                $this->cdnUsuario = $cdnUsuario;
                
                return true;
            }
            
            return false;
        }
        
        /**
         * Método responsável por retornar o código numérico do usuário
         *
         * @return Integer - código numérico do usuário
         *
         * */
        public function getCdnUsuario() {
            return $this->cdnUsuario;
        }
        
        /**
         * Método responsável por retornar o CEP do dentista
         *
         * @param String $codCep - código CEP
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodCep($codCep) {
            $this->codCep = $codCep;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o CEP do dentista
         *
         * @return String - código CEP
         *
         * */
        public function getCodCep() {
            return $this->codCep;
        }
        
        /**
         * Método responsável por setar o código do CPF/CNPJ
         *
         * @param String $codCpfCnpj - código do CPF/CNPJ
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodCpfCnpj($codCpfCnpj) {
            if ($this->validacaoCpfCnpj($codCpfCnpj)) {
                $this->codCpfCnpj = $codCpfCnpj;
                
                return true;
            }
            
            return false;
        }
        
        /**
         * Método responsável por retornar o código do CPF/CNPJ
         *
         * @return String - código do CPF/CNPJ
         *
         * */
        public function getCodCpfCnpj() {
            return $this->codCpfCnpj;
        }
        
        /**
         * Método responsável por setar o código do UF
         *
         * @param String $codUf - código UF
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setCodUf($codUf) {
            if ($this->validacaoUf($codUf)) {
                $this->codUf = $codUf;
                
                return true;
            }
            
            return false;
        }
        
        /**
         * Método responsável por retornar o código do UF
         *
         * @param Boolean $indTransforma - transformar para nome completo. Padrão: false
         * @return String - estado
         *
         * */
        public function getCodUf($indTransforma = false) {
            if (!$indTransforma)
                return $this->codUf;
            
            return $this->transformacaoUf($this->codUf);
        }
        
        /**
         * Método responsável por setar observações da clínica
         *
         * @param String $desClinica - obserações da clínica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setDesClinica($desClinica) {
            $this->desClinica = $desClinica;
            
            return true;
        }
        
        /**
         * Método responsável por retornar observações da clínica
         *
         * @return String - observações
         *
         * */
        public function getDesClinica() {
            return $this->desClinica;
        }
        
        /**
         * Método responsável por setar se a clínica é uma pessoa física
         *
         * @param Boolean $indFisica - true se é, false se não.
         * @return Boolean - true se sucesso, false se não.
         *
         * */
        public function setIndFisica($indFisica) {
            $this->indFisica = $indFisica;
            
            return true;
        }
        
        /**
         * Método responsável por retornar se a clínica é uma pessoa física
         *
         * @param Boolean $indTransforma - transformar para Sim/Não. Padrão: false.
         * @return Boolean - true se é, false se não
         *
         * */
        public function getIndFisica($indTransforma = false) {
            if (!$indTransforma)
                return $this->indFisica;
            if ($this->indFisica)
                return 'Sim';
            else
                return 'Não';
        }
        
        /**
         * Método responsável por setar o nome do banco da clínica
         *
         * @param String $nomBanco - nome do banco
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNomBanco($nomBanco) {
            $this->nomBanco = $nomBanco;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o nome do banco
         *
         * @return String - nome do banco
         *
         * */
        public function getNomBanco() {
            return $this->nomBanco;
        }
        
        /**
         * Método responsável por setar o nome da cidade
         *
         * @param String $nomCidade - nome da cidade
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNomCidade($nomCidade) {
            $this->nomCidade = $nomCidade;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o nome da cidade
         *
         * @return String - nome da cidade
         *
         * */
        public function getNomCidade() {
            return $this->nomCidade;
        }
        
        /**
         * Método responsável por setar o nome da clínica
         *
         * @param String $nomClinica - nome da clínica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNomClinica($nomClinica) {
            if (trim($nomClinica) == '')
                return false;
            $this->nomClinica = $nomClinica;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o nome da clínica
         *
         * @return String - nome da clínica
         *
         * */
        public function getNomClinica() {
            return $this->nomClinica;
        }
        
        /**
         * Método responsável por setar o nome do facebook da clínica
         *
         * @param String $nomFacebook - facebook da clinica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNomFacebook($nomFacebook) {
            $this->nomFacebook = $nomFacebook;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o nome do facebook da clínica
         *
         * @return String - facebook da clínica
         *
         * */
        public function getNomFacebook() {
            return $this->nomFacebook;
        }
        
        /**
         * Método responsável por setar o número de telefone 1
         *
         * @param String $numTelefone1 - número de telefone 1
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumTelefone1($numTelefone1) {
            $this->numTelefone1 = $numTelefone1;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o número de telefone 1
         *
         * @return String - número de telefone 1
         *
         * */
        public function getNumTelefone1() {
            return $this->numTelefone1;
        }
        
        /**
         * Método responsável por setar o número de telefone 2
         *
         * @param String $numTelefone2 - número de telefone 2
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumTelefone2($numTelefone2) {
            $this->numTelefone2 = $numTelefone2;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o número de telefone 2
         *
         * @return String - número de telefone 2
         *
         * */
        public function getNumTelefone2() {
            return $this->numTelefone2;
        }
        
        /**
         * Método responsável por setar o número do whatsapp
         *
         * @param String $numWhatsapp - número do whatsapp
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setNumWhatsapp($numWhatsapp) {
            $this->numWhatsapp = $numWhatsapp;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o número do whatsapp
         *
         * @return String - número do whatsapp
         *
         * */
        public function getNumWhatsapp() {
            return $this->numWhatsapp;
        }
        
        /**
         * Método responsável por setar o email da clínica
         *
         * @param String $strEmail - email da clínica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrEmail($strEmail) {
            if ($this->validacaoEmail($strEmail)) {
                $this->strEmail = $strEmail;
                
                return true;
            }
            
            return false;
        }
        
        /**
         * Método responsável por retornar o email da clínica
         *
         * @return String - email da clínica
         *
         * */
        public function getStrEmail() {
            return $this->strEmail;
        }
        
        /**
         * Método responsável por setar o endereço
         *
         * @param String $strEndereco - endereço
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrEndereco($strEndereco) {
            $this->strEndereco = $strEndereco;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o endereço
         *
         * @return String - endereço
         *
         * */
        public function getStrEndereco() {
            return $this->strEndereco;
        }
        
        /**
         * Método responsável por setar o site da clinica
         *
         * @param String $strSite - site da clínica
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setStrSite($strSite) {
            $this->strSite = $strSite;
            
            return true;
        }
        
        /**
         * Método responsável por retornar o site da clínica
         *
         * @return String - site da clínica
         *
         * */
        public function getStrSite() {
            return $this->strSite;
        }
        
        /**
         * Método responsável por setar se os prontuários estão disponíveis
         *
         * @param Boolean $indProntuario - prontuário disponíveis
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function setIndProntuario($indProntuario) {
            $this->indProntuario = $indProntuario;
            
            return true;
        }
        
        /**
         * Método responsável por retornar se os prontuários estão disponíveis
         *
         * @return Boolean - true se sucesso, false se não
         *
         * */
        public function getIndProntuario() {
            return $this->indProntuario;
        }
        
        public function getNumEnviosSms() {
            return $this->numEnviosSms;
        }
        
        public function getNumRecebimentosSms() {
            return $this->numRecebimentosSms;
        }
        
        public function setNumEnviosSms($numEnviosSms) {
            $this->numEnviosSms = $numEnviosSms;
        }
        
        public function setNumRecebimentosSms($numRecebimentosSms) {
            $this->numRecebimentosSms = $numRecebimentosSms;
        }

        public function getDatCadastro() {
            return $this->datCadastro;
        }

        public function setDatCadastro($datCadastro) {
            $this->datCadastro = $datCadastro;
        }

        public function getNumLimiteSms() {
            return $this->numLimiteSms;
        }

        public function setNumLimiteSms($numLimiteSms) {
            $this->numLimiteSms = $numLimiteSms;
        }

        public function getIndDesativada() {
            return $this->indDesativada;
        }

        public function setIndDesativada($indDesativada) {
            $this->indDesativada = $indDesativada;
        }

        public function getCodCroPrimeiro() {
            return $this->codCroPrimeiro;
        }

        public function setCodCroPrimeiro($codCroPrimeiro) {
            $this->codCroPrimeiro = $codCroPrimeiro;
        }

        public function getDesTamanhoClinica() {
            return $this->desTamanhoClinica;
        }

        public function setDesTamanhoClinica($desTamanhoClinica) {
            $this->desTamanhoClinica = $desTamanhoClinica;
        }

        
        
    }
