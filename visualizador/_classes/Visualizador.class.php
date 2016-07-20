<?php

    /**
     * Classe que realiza as operações
     * envolvendo a interface gráfica
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.1 - 2015-06-10
     *
    **/
    class Visualizador {
        private $variaveis = array();
        private $css;
        private $js;
        private $called;
        use Transformacao;

		/**
		 * Método construtor da classe
		 *
		**/
        public function __construct() {
            $this->atribuirValor('css', '');
            $this->atribuirValor('js', '');
        }

		/**
		 * Método responsável por dar include no HTML
		 *
		 * @param String $pagina - nome da página
		 * @param String $titulo - String responsável pelo TITLE do html
		 * @param Boolean $verificacao - true se a página deve solicitar login,
		 * 								 false se não.
		 *
		**/
        public function mostrarNaTela($pagina, $titulo, $verificacao = true){
            if(is_array($this->js)){
                $js = implode(PHP_EOL, $this->js);
                $this->atribuirValor('js', $js);
            }
            if(is_array($this->css)){
                $css = implode(PHP_EOL, $this->css);
                $this->atribuirValor('css', $css);
            }
            $this->atribuirValor('titulo', $titulo);
            $this->atribuirValor('verificacao', $verificacao);
            foreach($this->variaveis as $var =>$valor){
                global $$var;
                $$var = $valor;
            }

            $pasta = $this->getCalled(debug_backtrace());
            $this->called = $pasta;

            if($verificacao)
            	include('inc/logado.inc.php');

            // include('inc/active.inc.php');
            
            if($pagina != 'login' and $pagina != 'senha')
                include('visualizador/cabecalho.php');
    		echo PHP_EOL;
            if(file_exists('visualizador/'.$pasta.'/'.$pagina.'.php')){
                include ('visualizador/'.$pasta.'/'.$pagina.'.php');
            }else{
                include ('visualizador/404.php');
            }
    		echo PHP_EOL;
            if($pagina != 'login' and $pagina != 'senha')
                include('visualizador/rodape.php');
        }


		/**
		 * Método responsável por incluir nas variáveis globais
		 * um novo valor
		 *
		 * @param String $variavel - nome da variável
		 * @param Mixed $valor - valor que a variável deve receber
		 *
		**/
        public function atribuirValor($variavel, $valor){
            $this->variaveis[$variavel] = $valor;
        }

		/**
		 * Método responsável por adicionar um arquivo CSS na página
		 *
		 * @param String $arquivoCSS - nome do arquivo CSS
		 *
		**/
        public function addCSS($arquivoCSS){
            $this->css[] = '<link href="'.$arquivoCSS.'" rel="stylesheet"/>';
        }


		/**
		 * Método responsável por adicionar um arquivo JS na página
		 *
		 * @param String $arquivoJs - nome do arquivo JS
		 *
		**/
        public function addJS($arquivoJs){
            $this->js[] = '<script type="text/javascript" src="'.$arquivoJs.'"></script>';
        }


		/**
		 * Método responsável por setar um flash para visualização
		 * na página HTML
		 *
		 * @param String $mensagem - mensagem a ser mostrada na paǵina
         * @param String $tipo - tipo do flash. Padrão: mensagem. Opções: erro
         *                                                                aviso
         *                                                                sucesso
		 *
		**/
        public function setFlash($mensagem, $tipo = 'mensagem'){
            if(is_null($mensagem))
                $_SESSION['flash'] = null;
            if($tipo == 'erro')
                $this->addJs('js/erro.js');
        	$_SESSION['flash'][$tipo] = $mensagem;
        }


        /**
         * Método responsável por recuperar o valor do flash
         *
         * @return String - mensagem contida no flash.
         *
        **/
        public function getFlash(){
        	return $_SESSION['flash'];
        }


        /**
         * Método responsável por transformar o nome da classe
         * que está chamando o método "mostrarNaTela"
         *
         * @param Array $backtrace - debug_backtrace() da classe
         * @return String - nome da classe transformado
         *
        **/
        public function getCalled($backtrace){
        	$called = str_replace("\\","/",$backtrace[0]['file']);
            $called = explode('/', $called);
            $called = $called[count($called) - 1];
            $called = explode('.', $called);
            $called = $called[0];
        	return lcfirst(substr($called, 8));
        }

        /**
         * Método responsável por adicionar um link na tela
         *
         * @param String $controlador
         * @param String $acao
         * @param String $descrição
         * @param Array $parametros - opcional
         * @param String $target - opcional
         * @return String - link
         *
        **/
        public function link($controlador, $acao, $descricao, $parametros = array(), $target = '_self', $classes = ''){
            $param = '/';
            foreach($parametros as $parametro){
                $param .= $parametro.'/';
            }
            return '<a class="'.$classes.'" target="'.$target.'" href="'.BASE_URL.'/'.$controlador.'/'.$acao.$param.'">'.$descricao.'</a>';
        }


    }
