<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a recuperação
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-12-01
     *
    **/
    class ModeloRecuperacao extends Modelo{


        /**
         * Método utilizado para retornar o objeto DTO
         * da recuperação requisitada
         *
         * @param Integer $codExterno - código externo da recuperação
         * @return Object - objeto DTO da recuperação
         *
        **/
        public function getRecuperacao($codExterno){
            return $this->getRegistro('recuperacao', 'codExterno', $codExterno);
        }

        /**
         * Método responsável por guardar no banco a recuperação
         *
         * @param Object $dtoRecuperacao - objeto dto da recuperação
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function recuperacaoCadastrarFim($dtoRecuperacao){
            $dadosFinais = $dtoRecuperacao->getArrayBanco();
            return $this->inserir('recuperacao', $dadosFinais);
        }

        /** 
         * Método utilizado para atualizar as informações da recuperação
         *
         * @param Object $dtoRecuperacao - objeto DTO da recuperação
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function recuperacaoAtualizarFim(DTORecuperacao $dtoRecuperacao){

            $dados = $dtoRecuperacao->getArrayBanco();
            return $this->atualizar('recuperacao', $dados, array('codExterno' => $dtoRecuperacao->getCodExterno()));

        }

        /**
         * Método responsável por enviar o e-mail de recuperação
         *
         * @param Array $arrUsuario - array do usuário que vai ser recuperado
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function recuperacaoSenhaFim($arrUsuario){
        	$dtoRecuperacao = new DTORecuperacao();
        	$dtoRecuperacao->setCdnUsuario($arrUsuario['cdnUsuario']);
        	$dtoRecuperacao->setNumIp($_SERVER['HTTP_X_FORWARDED_FOR'].' - '.$_SERVER['REMOTE_ADDR']);
        	$dtoRecuperacao->setCodRecuperacao(md5($arrUsuario['cdnUsuario'].$arrUsuario['strEmail'].date('Y-m-d h:i:s').uniqid()));
            $dtoRecuperacao->setDatRecuperacao(date('Y-m-d h:i:s'));

	    	$email = new PHPMailer;

            $email->SMTPDebug = 4;                               // Enable verbose debug output

            $email->isSMTP();                                      // Set mailer to use SMTP
            $email->Host = 'mx2.weblink.com.br';                   // Specify main and backup SMTP servers
            $email->SMTPAuth = true;                               // Enable SMTP authentication
            $email->Username = $_SESSION['banco'].'@bncloud.com.br';                 // SMTP username
            $email->Password = $_SESSION['senhaBanco'];                           // SMTP password
            $email->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $email->Port = 465;                                    // TCP port to connect to
            $email->SetLanguage("br");
            $email->From = $_SESSION['banco'].'@bncloud.com.br';
            $email->FromName = 'Sistema Prophet';
            $email->isHTML(true);                                  // Set email format to HTML

            $email->Subject = '[PROPHET] Recuperação de senha';
            include('visualizador/recuperacao/corpo.php');
            $email->CharSet = 'UTF-8';

        	$email->AddAddress($arrUsuario['strEmail'], $arrUsuario['nomUsuario']);
        	if($email->send()){
                $this->recuperacaoCadastrarFim($dtoRecuperacao);
                return true;
            }
            return false;

        }

        /**
         * Método responsável por enviar a nova senha ao usuário
         *
         * @param Object $dtoRecuperacao - objeto dto da recuperação
         * @return Void.
         *
        **/
        public function recuperacaoEnviarSenha($dtoRecuperacao){

            $modMain = new ModeloMain(true);
            $arrUsuario = $modMain->getUsuario($dtoRecuperacao->getCdnUsuario());

            $email = new PHPMailer;

            $email->SMTPDebug = 4;                               // Enable verbose debug output

            $email->isSMTP();                                      // Set mailer to use SMTP
            $email->Host = 'mx2.weblink.com.br';                   // Specify main and backup SMTP servers
            $email->SMTPAuth = true;                               // Enable SMTP authentication
            $email->Username = $_SESSION['banco'].'@bncloud.com.br';                 // SMTP username
            $email->Password = $_SESSION['senhaBanco'];                           // SMTP password
            $email->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $email->Port = 465;                                    // TCP port to connect to
            $email->SetLanguage("br");
            $email->From = $_SESSION['banco'].'@bncloud.com.br';
            $email->FromName = 'Sistema Prophet';
            $emails = array();
            $email->isHTML(true);                                  // Set email format to HTML

            $email->Subject = '[PROPHET] Recuperação de senha';
            $novaSenha = $this->recuperacaoGeraSenha();
            $email->Body = 'A sua nova senha é: '.$novaSenha;
            $email->CharSet = 'UTF-8';

            $email->AddAddress($arrUsuario['strEmail'], $arrUsuario['nomUsuario']);
            if($email->send()){
                $dtoRecuperacao->setIndFinalizado(1);
                $arrUsuario['strSenha'] = crypt($novaSenha, '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
                $this->atualizar('usuario', $arrUsuario, array('cdnUsuario' => $arrUsuario['cdnUsuario']));
                $this->recuperacaoAtualizarFim($dtoRecuperacao);
            }
            return;
        }

        /**
        * Função para gerar senhas aleatórias
        *
        * @author    Thiago Belem <contato@thiagobelem.net>
        *
        * @param integer $tamanho Tamanho da senha a ser gerada
        * @param boolean $maiusculas Se terá letras maiúsculas
        * @param boolean $numeros Se terá números
        * @param boolean $simbolos Se terá símbolos
        *
        * @return string A senha gerada
        *
        **/
        function recuperacaoGeraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
            $lmin = 'abcdefghijklmnopqrstuvwxyz';
            $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $num = '1234567890';
            $simb = '!@#$%*-';
            $retorno = '';
            $caracteres = '';
            $caracteres .= $lmin;
            if ($maiusculas) $caracteres .= $lmai;
            if ($numeros) $caracteres .= $num;
            if ($simbolos) $caracteres .= $simb;
            $len = strlen($caracteres);
            for ($n = 1; $n <= $tamanho; $n++) {
                $rand = mt_rand(1, $len);
                $retorno .= $caracteres[$rand-1];
            }
            return $retorno;
        }

    }