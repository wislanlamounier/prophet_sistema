<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo a pergunta.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-31
     *
    **/
    class ModeloPergunta extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * da pergunta requisitada
         *
         * @param Integer $cdnPergunta - código numérico da pergunta
         * @return Object - objeto DTO da pergunta
         *
        **/
        public function getPergunta($cdnPergunta){
            return $this->getRegistro('pergunta', 'cdnPergunta', $cdnPergunta);
        }

        /**
         * Método utilizado para retornar o objeto DTO
         * da opção requisitada
         *
         * @param Integer $cdnOpcao - código numérico da opção
         * @return Object - objeto DTO da opção
         *
        **/
        public function getOpcao($cdnOpcao){
            return $this->getRegistro('pergunta_opcao', 'cdnOpcao', $cdnOpcao);
        }


        /**
         * Método utilizado para atualizar as informações da pergunta
         *
         * @param Object $dtoPergunta - objeto DTO da pergunta
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function perguntaAtualizarFim(DTOPergunta $dtoPergunta){

            $dados = $dtoPergunta->getArrayBanco();
            return $this->atualizar('pergunta', $dados, array('cdnPergunta' => $dtoPergunta->getCdnPergunta()));

        }

        /**
         * Método utilizado para atualizar as informações da opção
         *
         * @param Object $dtoOpcao - objeto DTO da opção
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function perguntaOpcaoAtualizarFim(DTOPergunta_opcao $dtoOpcao){

            $dados = $dtoOpcao->getArrayBanco();
            return $this->atualizar('pergunta_opcao', $dados, array('cdnOpcao' => $dtoOpcao->getCdnOpcao()));

        }

        /**
         * Método utilizado para preencher o DTO da pergunta para cadastro.
         *
         * @param Boolean $cdnPergunta - código numérico da pergunta (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function perguntaPreparaDTO($cdnPergunta = 0){
            $mesErro = '';
            if($cdnPergunta == 0){
                // está cadastrando
                $dtoPergunta = new DTOPergunta();
            }else{
                // está atualizando
                if(!$this->checaExiste('pergunta', 'cdnPergunta', $cdnPergunta))
                    return array(new DTOPergunta(), 'Registro não existente.');
                $dtoPergunta = $this->getPergunta($cdnPergunta);
            }

            $arrValidacao = array(
                'strPergunta' => array('Informe a pergunta.')
            );

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
                $nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

                $valCampo = $_POST[$nomCampo];
                if(!$dtoPergunta->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            return array($dtoPergunta, $mesErro);
        }

        /**
         * Método utilizado para preencher o DTO da opção para cadastro.
         *
         * @param Boolean $cdnOpcao - código numérico da opção (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function perguntaOpcaoPreparaDTO($cdnOpcao = 0){
            $mesErro = '';
            if($cdnOpcao == 0){
                // está cadastrando
                $dtoOpcao = new DTOPergunta_opcao();
            }else{
                // está atualizando
                if(!$this->checaExiste('pergunta_opcao', 'cdnOpcao', $cdnOpcao))
                    return array(new DTOPergunta_opcao(), 'Registro não existente.');
                $dtoOpcao = $this->getOpcao($cdnOpcao);
            }

            $arrValidacao = array(
                'strOpcao' => array('Informe a opção.')
            );

            foreach($arrValidacao as $nomCampo=>$mesValidacao){
                $nomFuncao = 'set'.ucfirst($nomCampo);

                if(!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == ''){
                    if(is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0].'<br>';
                    continue;
                }

                if(is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];

                $valCampo = $_POST[$nomCampo];
                if(!$dtoOpcao->{$nomFuncao}($valCampo)){
                    $mesErro .= $mesValidacao.'<br>';
                }
            }

            return array($dtoOpcao, $mesErro);
        }

        /**
         * Método utilizado para registrar a pergunta
         * no banco de dados
         *
         * @param Object $dtoPergunta - objeto DTO da pergunta
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function perguntaCadastrarFim(DTOPergunta $dtoPergunta){

            $dadosFinais = $dtoPergunta->getArrayBanco();
            return $this->inserir('pergunta', $dadosFinais);

        }

        /**
         * Método utilizado para registrar a opção
         * no banco de dados
         *
         * @param Object $dtoOpcao - objeto DTO da opção
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function perguntaOpcaoCadastrarFim(DTOPergunta_opcao $dtoOpcao){

            $dadosFinais = $dtoOpcao->getArrayBanco();
            return $this->inserir('pergunta_opcao', $dadosFinais);

        }

        /**
         * Método responsável por imprimir o questionário
         *
        **/
        public function perguntaImprimirQuestionario(){
            $pdfQuestionario = new PDFQuestionario('P', 'mm');
            $modPaciente = new ModeloPaciente();
            
            $pdfQuestionario->AddPage();
            $pdfQuestionario->AliasNbPages();


            $arrPerguntas = $this->consultar('pergunta');
            $arrComOpcao = array();
            $numContagem = 0;

            foreach($arrPerguntas as $arrPergunta){
                if(!$this->checaExiste('pergunta_opcao', 'cdnPergunta', $arrPergunta['cdnPergunta'])){
                    $pdfQuestionario->SetBorders(array('B'));
                    $numContagem++;
                    $pdfQuestionario->PutRow(array($numContagem.' - '.$arrPergunta['strPergunta']), true);

                }else{
                    $arrComOpcao[] = $arrPergunta;
                }
            }

            foreach($arrComOpcao as $arrPergunta){
                $arrOpcoes = $this->consultar('pergunta_opcao', '*', array('cdnPergunta' => $arrPergunta['cdnPergunta']));
                $pdfQuestionario->SetBorders(array(''));
                $numContagem++;
                $pdfQuestionario->PutRow(array($numContagem.' - '.$arrPergunta['strPergunta']), true);
                $strOpcoes = '';
                foreach($arrOpcoes as $arrOpcao){
                    $strOpcoes .= '(  ) '.$arrOpcao['strOpcao'].'  ';
                }
                $pdfQuestionario->SetBorders(array('B'));
                $pdfQuestionario->PutRow(array($strOpcoes), true);
            }


            $pdfQuestionario->OutPut();
        }
    }
