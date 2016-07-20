<?php
    /**
     * Classe responsável por lidar com movimentação de arquivo
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-10
     *
    **/
    class Arquivo{

        private $pasta;
        private $nome;
        private $extensao;
        private $caminhoFinal;
        private $caminhoTemp;
        private $tamanho;

        /**
         * Método construtor
         *
         * @param String $pasta - nome da pasta
         * @param String $post - nome do post
         * @param Integer $posicao - posicao no array de files (opcional)
         *
        **/
        public function __construct($pasta, $post, $posicao = null){
            if(is_null($posicao)){
                $this->nome = $_FILES[$post]['name'];
                $this->caminhoTemp = $_FILES[$post]['tmp_name'];
                $this->tamanho = $_FILES[$post]['size'];
            }else{
                $this->nome = $_FILES[$post]['name'][$posicao];
                $this->caminhoTemp = $_FILES[$post]['tmp_name'][$posicao];
                $this->tamanho = $_FILES[$post]['size'][$posicao];
            }

            if(rtrim($pasta, '/') == $pasta)
                $pasta .= '/';
            $this->pasta = $pasta;


            $this->extensao = $this->getExtensao();


            $this->retiraExtensao();
            $this->retiraAcento();
            $this->retiraEspacos();

        }

        /**
         * Método responsável por finalizar a cópia do arquivo
         *
         * @param String $subpasta - nome de uma subpasta que o arquivo deve ser enviado (opcional)
         * @return String - caminho final do arquivo
         *
        **/
        public function finalizar($subpasta = null){
            if(!is_null($subpasta))
                $this->pasta .= $subpasta.'/';
            $this->verificaPastaExiste();
            $this->caminhoFinal = $this->geraDestino();
            move_uploaded_file($this->caminhoTemp, $this->caminhoFinal);
            return $this->getCaminhoFinal();
        }

        /**
         * Método responsável por retornar o caminho final do arquivo
         *
        **/
        public function getCaminhoFinal(){
            return $this->caminhoFinal;
        }

        /**
         * Método responsável por retirar a extensão de um nome
         *
         * @return String - nome do arquivo sem acento
         *
        **/
        public function retiraExtensao(){
            $nome = explode('.', $this->nome);
            $qtdPontos = count($nome);
            $nomeNovo = '';
            for($i = 0; $i < $qtdPontos - 1; $i++){
                $nomeNovo .= $nome[$i];
            }
            $this->nome = $nomeNovo;
            return $nomeNovo;
        }

        /**
         * Método reponsável por retornar a extensão de um nome de arquivo
         *
         * @return String - extensão do arquivo
         *
        **/
        public function getExtensao(){
            $extensao = explode('.', $this->nome);
            $extensao = strtolower($extensao[count($extensao)-1]);
            return $extensao;
        }

        /**
         * Método responsável por verificar a existência de outros arquivos
         * de mesmo nome na pasta desejada
         *
         * @return String - destino do arquivo
         *
        **/
        public function geraDestino(){
            $destino = $this->pasta.$this->nome.'.'. $this->extensao ;
            if(file_exists($destino)){
                $existe = true;
                $i = 0;
                while($existe){
                    $i++;
                    $destino = $this->pasta.$this->nome.'('.$i.')'.'.'. $this->extensao;
                    $existe = file_exists($destino);
                }
            }
            return $destino;
        }

        /**
         * Método responsável por verificar se a pasta desejada existe e,
         * se não existir, cria.
         *
        **/
        public function verificaPastaExiste(){
            if(!is_dir($this->pasta)){
                mkdir($this->pasta, 0775, true);
            }
        }

        /**
         * Método responsável por retirar os espaços do nome do arquivo
         *
         * @return String - nome sem espaços
         *
        **/
        public function retiraEspacos(){
            $this->nome = str_replace(" ", "_", $this->nome);
            return $this->nome;
        }

        /**
         * Método responsável por retirar os acentos do nome do arquivo
         *
         * @return String - nome sem acentos
         *
        **/
        public function retiraAcento(){
            $enc = 'UTF-8';
            $acentos = array(
                'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
                'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
                'C' => '/&Ccedil;/',
                'c' => '/&ccedil;/',
                'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
                'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
                'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
                'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
                'N' => '/&Ntilde;/',
                'n' => '/&ntilde;/',
                'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
                'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
                'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
                'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
                'Y' => '/&Yacute;/',
                'y' => '/&yacute;|&yuml;/',
                'a.' => '/&ordf;/',
                'o.' => '/&ordm;/'
            );

            $this->nome =  preg_replace($acentos,array_keys($acentos),htmlentities($this->nome,ENT_NOQUOTES, $enc));
            return $this->nome;
        }

        /**
         * Método utilizado para retornar o tamanho do arquivo
         *
        **/
        public function tamanho(){
            return $this->tamanho;
        }

    }
