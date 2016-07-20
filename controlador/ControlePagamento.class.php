<?php

    /**
     * Classe que realiza o intermédio entre
     * banco de dados (Modelo.class.php) e
     * visualizações (Visualizador.class.php)
     * de consultório
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-22
     *
    **/
    class ControlePagamento extends Controlador{

        /**
         * Método responsável por mostrar a página de registrar o pagamento de uma parcela/orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @param Integer $numParcela - número da parcela (opcional)
         * @return Void.
         *
        **/
        public function pagamentoCadastrar($cdnOrcamento, $numParcela = 0){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();

                if($numParcela != 0){
                    $dtoParcela = $modOrcamento->getOrcamentoParcela($cdnOrcamento, $numParcela);
                    if(is_null($dtoParcela->getCdnOrcamento())){
                        $this->erroExistente();
                        return;
                    }
                    $this->visualizador->atribuirValor('dtoParcela', $dtoParcela);
                }
                $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);

                $arrPaciente = new ModeloPaciente();
                $arrPaciente = $arrPaciente->getPaciente($dtoOrcamento->getCdnPaciente());

                $dtoOrcamentoFormaPagamento = $modOrcamento->getOrcamentoFormaPagamento($cdnOrcamento);
                $this->visualizador->atribuirValor('dtoOrcamentoFormaPagamento', $dtoOrcamentoFormaPagamento);

                $this->visualizador->atribuirValor('arrPaciente', $arrPaciente);
                $this->visualizador->atribuirValor('dtoOrcamento', $dtoOrcamento);

                $this->visualizador->mostrarNaTela('cadastrar', 'Registrar pagamento para '.$arrPaciente['nomPaciente']);
            }
            $this->erroExistente();
            return;
        }

        /**
         * Método responsável por registar o pagamento de uma parcela ou orçamento
         *
         * @param Integer $cdnOrcamento - código numércico do orçamento
         * @param Integer $numParcela - número da parcela
         * @return Void.
         *
        **/
        public function pagamentoCadastrarFim($cdnOrcamento, $numParcela = 0){
            if($this->modelo->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento)){
                $modOrcamento = new ModeloOrcamento();

                if($numParcela != 0){
                    $dtoParcela = $modOrcamento->getOrcamentoParcela($cdnOrcamento, $numParcela);
                    if(is_null($dtoParcela->getCdnOrcamento())){
                        $this->erroExistente();
                        return;
                    }
                    $dtoParcela->setIndPaga(1);
                    $modOrcamento->orcamentoParcelaAtualizarFim($dtoParcela);

                    $arrCond = array('cdnOrcamento' => $cdnOrcamento,
                                     'conscond1' => 'AND',
                                     'indPaga' => 0);
                    $arrParcelas = $this->modelo->consultar('orcamento_parcela', '*', $arrCond);
                    if(count($arrParcelas) == 0){
                        $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                        $dtoOrcamento->setIndFinalizado(1);
                        $modOrcamento->orcamentoAtualizarFim($dtoOrcamento);
                    }
                }else{
                    $dtoOrcamento = $modOrcamento->getOrcamento($cdnOrcamento);
                    $dtoOrcamento->setIndFinalizado(1);
                    $modOrcamento->orcamentoAtualizarFim($dtoOrcamento);
                }

                $this->visualizador->setFlash('Pagamento registrado com sucesso.', 'sucesso');
                $ctrlOrcamento = new ControleOrcamento();
                return $ctrlOrcamento->orcamentoConsultarFim($cdnOrcamento);

            }
            $this->erroExistente();
            return;
        }

    }