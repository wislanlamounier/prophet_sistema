<?php
    
    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o orçamento.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-11-10
     *
     **/
    class ModeloOrcamento extends Modelo {
        use Validacao;
        
        /**
         * Método utilizado para retornar o objeto DTO
         * do orçamento requisitado
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Object - objeto DTO do orçamento
         *
         **/
        public function getOrcamento($cdnOrcamento) {
            return $this->getRegistro('orcamento', 'cdnOrcamento', $cdnOrcamento);
        }
        
        /**
         * Método utilizado para retornar o objeto DTO
         * da forma de pagamento de um orçamento desejado
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Object - objeto DTO da forma de pagamento
         *
         **/
        public function getOrcamentoFormaPagamento($cdnOrcamento) {
            return $this->getRegistro('orcamento_formapagamento', 'cdnOrcamento', $cdnOrcamento);
        }
        
        /**
         * Método responsável por retornar DTOs de parcelas de um orçamento desejado.
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @param Integer $numParcela - número da parcela (opcional).
         * @return Array/Object - parcelas de um orçamento
         *
         **/
        public function getOrcamentoParcela($cdnOrcamento, $numParcela = false) {
            if (!$numParcela) {
                $arrParcelas = $this->consultar('orcamento_parcela', '*', array('cdnOrcamento' => $cdnOrcamento));
                $arrDtos = array();
                foreach ($arrParcelas as $arrParcela) {
                    $arrDtos[] = serialize($this->getOrcamentoParcela($cdnOrcamento, $arrParcela['numParcela']));
                }
                
                return $arrDtos;
            } else {
                $arrCond = array('cdnOrcamento' => $cdnOrcamento,
                                 'conscond1'    => 'AND',
                                 'numParcela'   => $numParcela);
                $arrParcela = $this->consultar('orcamento_parcela', '*', $arrCond);
                $dtoOrcamentoParcela = new DTOOrcamento_parcela();
                if (count($arrParcela) > 0) {
                    $arrParcela = $arrParcela[0];
                    foreach ($dtoOrcamentoParcela->getArrayDados() as $nomCampo => $valCampo) {
                        $nomFuncao = 'set' . ucfirst($nomCampo);
                        $dtoOrcamentoParcela->{$nomFuncao}($arrParcela[$nomCampo]);
                    }
                }
                
                return $dtoOrcamentoParcela;
            }
        }
        
        /**
         * Método utilizado para atualizar as informações do orçamento
         *
         * @param Object $dtoOrcamento - objeto DTO do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoAtualizarFim(DTOOrcamento $dtoOrcamento) {
            
            $dados = $dtoOrcamento->getArrayBanco();
            
            return $this->atualizar('orcamento', $dados, array('cdnOrcamento' => $dtoOrcamento->getCdnOrcamento()));
            
        }
        
        /**
         * Método utilizado para atualizar as informações da forma de pagamento do orçamento
         *
         * @param Object $dtoOrcamentoFormaPagamento - objeto DTO da forma de pagamento do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoFormaPagamentoAtualizarFim(DTOOrcamento_formapagamento $dtoOrcamentoFormaPagamento) {
            
            $dados = $dtoOrcamentoFormaPagamento->getArrayBanco();
            
            return $this->atualizar('orcamento_formapagamento', $dados, array('cdnOrcamento' => $dtoOrcamentoFormaPagamento->getCdnOrcamento()));
            
        }
        
        /**
         * Método utilizado para preencher o DTO do orçamento para cadastro.
         *
         * @param Boolean $cdnOrcamento - código numérico do orçamento (opcional)
         * @return Array - DTO(0) e mensagem de erro(1)
         *
         **/
        public function orcamentoPreparaDTO($cdnOrcamento = 0) {
            $mesErro = '';
            
            if ($cdnOrcamento == 0) {
                // está cadastrando
                $dtoOrcamento = new DTOOrcamento();
            } else {
                // está atualizando
                if (!$this->checaExiste('orcamento', 'cdnOrcamento', $cdnOrcamento))
                    return array(new DTOOrcamento(), 'Registro não existente.');
                $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            }
            
            if (!isset($_POST['cdnPaciente'])) {
                $mesErro .= 'Informe o paciente.<br>';
            } else {
                if (!$this->checaExiste('paciente', 'cdnPaciente', $_POST['cdnPaciente'])) {
                    $mesErro .= 'Informe um paciente válido.<br>';
                } else {
                    $dtoOrcamento->setCdnPaciente($_POST['cdnPaciente']);
                }
            }
            
            $arrValidacao = array(
                'datOrcamento'       => 'Informe uma data válida para o orçamento.',
                'datValidade'        => 'Informe uma data válida para a validade do orçamento.',
                'valOrcamento'       => array('Informe um valor válido para o orçamento.'),
                'desOrcamento'       => '',
                'cdnTabelaPreco'     => array('Informe a tabela de preço.'),
                'indCobrarJuros'     => '',
                'numVezesOferecidas' => array('Informe um número válido de vezes.'),
            );
            
            foreach ($arrValidacao as $nomCampo => $mesValidacao) {
                $nomFuncao = 'set' . ucfirst($nomCampo);
                
                if (!isset($_POST[$nomCampo]) or trim($_POST[$nomCampo]) == '') {
                    if (is_array($mesValidacao))
                        $mesErro .= $mesValidacao[0] . '<br>';
                    continue;
                }
                
                if (is_array($mesValidacao))
                    $mesValidacao = $mesValidacao[0];
                
                $valCampo = $_POST[$nomCampo];
                if (!$dtoOrcamento->{$nomFuncao}($valCampo)) {
                    $mesErro .= $mesValidacao . '<br>';
                }
            }
            
            if (strtotime($dtoOrcamento->getDatOrcamento()) > strtotime($dtoOrcamento->getDatValidade())) {
                $mesErro .= 'A data de validade deve ser maior que a data do orçamento.<br>';
            }
            
            if ($cdnOrcamento == 0) {
                $dtoOrcamento->setIndAprovado(null);
            }
            
            return array($dtoOrcamento, $mesErro);
        }
        
        /**
         * Método responsável por montar o DTO da forma de pagamento do orçamento
         *
         * @return Array - DTO(0) e mensagem de erro(1)
         *
         **/
        public function orcamentoPreparaFormaPagamentoDTO() {
            
            $dtoOrcamentoFormaPagamento = new DTOOrcamento_formapagamento();
            
            $forma = 'aVista';
            if ($_POST['quantidade'] > 1)
                $forma = 'parcelado';
            if (!$dtoOrcamentoFormaPagamento->setIndForma($forma)) {
                return false;
            }
            if (!isset($_POST['tipo'])) {
                return false;
            }
            if (!$dtoOrcamentoFormaPagamento->setIndVia($_POST['tipo'])) {
                return false;
            }
            
            if ($_POST['tipo'] == 'carne' and $forma != 'parcelado') {
                return false;
            }
            
            if ($_POST['tipo'] == 'cartao') {
                if (!isset($_POST['datVencimentoCartao'])) {
                    return false;
                }
                $dtoOrcamentoFormaPagamento->setDatVencimentoCartao($_POST['datVencimentoCartao']);
            }
            
            if (isset($_POST['cdnTabelaPreco']))
                $dtoOrcamentoFormaPagamento->setCdnTabelaPreco($_POST['cdnTabelaPreco']);
            
            if ($forma == 'parcelado') {
                if (!isset($_POST['quantidade']))
                    return false;
                if ($_POST['quantidade'] < 2)
                    return false;
                
                if (!$dtoOrcamentoFormaPagamento->setNumVezes($_POST['quantidade']))
                    return false;
                
                if (!isset($_POST['diaVencimento']))
                    return false;
                if (!$dtoOrcamentoFormaPagamento->setNumDiaVencimento($_POST['diaVencimento']))
                    return false;
            }
            
            
            if (isset($_POST['datInicioPagamento'])) {
                if ($_POST['datInicioPagamento'] == '')
                    return false;
                $datInicioPagamento = $_POST['datInicioPagamento'];
                $segInicioPagamento = strtotime($datInicioPagamento);
                $hoje = strtotime(date('Y-m-d'));
                
                if ($segInicioPagamento < $hoje)
                    return false;
                
                if ($dtoOrcamentoFormaPagamento->setDatInicioPagamento($datInicioPagamento))
                    true;
                else
                    return false;
            } else {
                return false;
            }
            
            
            if (!isset($_POST['porcentagem'])) {
                $dtoOrcamentoFormaPagamento->setNumPorcentagem(0);
            } else {
                $dtoOrcamentoFormaPagamento->setNumPorcentagem($_POST['porcentagem']);
            }
            
            
            return $dtoOrcamentoFormaPagamento;
            
            
        }
        
        /**
         * Método responsável por preparar os DTOs das parcelas
         *
         * @return Array - DTOs das parcelas
         *
         **/
        public function orcamentoPreparaParcelas($dtoOrcamento) {
            $this->deletar('orcamento_parcela', array('cdnOrcamento' => $dtoOrcamento->getCdnOrcamento()));
            $cdnOrcamento = $dtoOrcamento->getCdnOrcamento();
            $arrParcelas = array();
            
            $soma = 0;
            
            $forma = $this->getOrcamentoFormaPagamento($dtoOrcamento->getCdnOrcamento());
            
            $valor = $dtoOrcamento->getValFinal();
            
            $vezes = $forma->getNumVezes();
            
            $continuar = true;
            
            for ($i = 1; $i < $vezes; $i++) {
                $valorMes = $valor / $vezes;
                $valorMes = round($valorMes, 2);
                
                $soma = $soma + $valorMes;
                $soma = round($soma, 2);
                $dtoOrcamentoParcela = new DTOOrcamento_parcela();
                $dtoOrcamentoParcela->setNumParcela($i);
                $dtoOrcamentoParcela->setValParcela($valorMes);
                $dtoOrcamentoParcela->setCdnOrcamento($cdnOrcamento);
                
                $arrDados = $dtoOrcamentoParcela->getArrayBanco();
                if ($continuar) {
                    if (!$this->inserir('orcamento_parcela', $arrDados)) {
                        $this->deletar('orcamento_parcela', array('cdnOrcamento' => $cdnOrcamento));
                        $continuar = false;
                    }
                }
            }
            
            if ($continuar) {
                $valorMes = $valor - $soma;
                $valorMes = round($valorMes, 2);
                $dtoOrcamentoParcela = new DTOOrcamento_parcela();
                $dtoOrcamentoParcela->setValParcela($valorMes);
                $dtoOrcamentoParcela->setNumParcela($vezes);
                $dtoOrcamentoParcela->setCdnOrcamento($cdnOrcamento);
                $arrDados = $dtoOrcamentoParcela->getArrayBanco();
                if (!$this->inserir('orcamento_parcela', $arrDados)) {
                    $this->deletar('orcamento_parcela', array('cdnOrcamento' => $cdnOrcamento));
                    $continuar = false;
                }
            }
            
            return $continuar;
        }
        
        /**
         * Método utilizado para setar o código do orçamento nas parcelas
         *
         * @param Array $arrParcelas - array de DTOs de parcelas
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Array - array das parcelas
         *
         **/
        public function orcamentoParcelasCodigo($arrParcelas, $cdnOrcamento) {
            for ($i = 0; $i < count($arrParcelas); $i++) {
                $dtoOrcamentoParcela = unserialize($arrParcelas[$i]);
                $dtoOrcamentoParcela->setCdnOrcamento($cdnOrcamento);
                $arrParcelas[$i] = serialize($dtoOrcamentoParcela);
            }
            
            return $arrParcelas;
        }
        
        /**
         * Método utilizado para registrar o orçamento
         * no banco de dados
         *
         * @param Object $dtoOrcamento - objeto DTO do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoCadastrarFim(DTOOrcamento $dtoOrcamento) {
            $dadosFinais = $dtoOrcamento->getArrayBanco();
            if ($this->inserir('orcamento', $dadosFinais)) {
                $cdnOrcamento = $this->ultimoInserido('orcamento');
                $retorno = $this->orcamentoCadastrarProcedimentos($cdnOrcamento);
                if ($retorno === true) {
                    return true;
                } else {
                    $this->deletar('orcamento_procedimento', array('cdnOrcamento' => $cdnOrcamento));
                    $this->deletar('orcamento', array('cdnOrcamento' => $cdnOrcamento));
                    
                    return $retorno;
                }
            } else {
                return 'Ocorreu um problema ao registrar os dados do orçamento. Por favor, tente novamente.';
            }
        }
        
        /**
         * Método responsável por cadastrar os procedimentos no orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Boolean/String - true se sucesso, string de erro se não.
         **/
        public function orcamentoCadastrarProcedimentos($cdnOrcamento) {
            $areas = isset($_POST['cdnAreaAtuacao1']) ? 1 : 0;
            if ($areas) {
                while (true) {
                    if (isset($_POST['cdnAreaAtuacao' . $areas]))
                        $areas++;
                    else
                        break;
                }
            }
            $areas;
            
            $mesErro = '';
            $arrProcedimentos = array();
            
            $ctrlProcedimento = new ControleProcedimento();
            
            if ($areas > 0) {
                for ($i = 1; $i < $areas; $i++) {
                    
                    $dtoOrcamentoProcedimento = new DTOOrcamento_procedimento();
                    if (!$dtoOrcamentoProcedimento->setCdnDentista($_POST['cdnDentista' . $i])) {
                        $mesErro .= 'Informe um dentista válido para o procedimento ' . $i . '.<br>';
                    }
                    if (!$dtoOrcamentoProcedimento->setCdnAreaAtuacao($_POST['cdnAreaAtuacao' . $i])) {
                        $mesErro .= 'Informe uma área de atuação válida para o procedimento ' . $i . '.<br>';
                    }
                    if (!$dtoOrcamentoProcedimento->setCdnProcedimento($_POST['cdnProcedimento' . $i])) {
                        $mesErro .= 'Informe um procedimento válido para o procedimento ' . $i . '.<br>';
                    }
                    if (!$dtoOrcamentoProcedimento->setNumQuantidade($_POST['numQuantidade' . $i])) {
                        $mesErro .= 'Informe uma quantidade válida para o procedimento ' . $i . '<br>';
                    }
                    if (isset($_POST['numDente' . $i]))
                        $dtoOrcamentoProcedimento->setNumDente($_POST['numDente' . $i]);
                    
                    if (!isset($_POST['valProcedimento' . $i]))
                        $valProcedimento = $ctrlProcedimento->procedimentoValor($dtoOrcamentoProcedimento->getCdnProcedimento(),
                            $_POST['cdnTabelaPreco'], false);
                    else
                        $valProcedimento = $dtoOrcamentoProcedimento->transformacaoDecimal($_POST['valProcedimento' . $i]);
                    $dtoOrcamentoProcedimento->setValUnitario($valProcedimento);
                    $dtoOrcamentoProcedimento->setCdnOrcamento($cdnOrcamento);
                    
                    if ($mesErro == '') {
                        $arrProcedimentos[] = serialize($dtoOrcamentoProcedimento);
                    }
                }
            } else {
                return 'Informe um procedimento para o orçamento.';
            }
            
            if ($mesErro == '') {
                foreach ($arrProcedimentos as $dtoOrcamentoProcedimento) {
                    $dtoOrcamentoProcedimento = unserialize($dtoOrcamentoProcedimento);
                    $arrDados = $dtoOrcamentoProcedimento->getArrayBanco();
                    if (!$this->inserir('orcamento_procedimento', $arrDados)) {
                        $mesErro = 'Ocorreu um problema ao registrar os procedimentos deste orçamento. Por favor, tente novamente.';
                    }
                }
                
                if ($mesErro != '') {
                    return $mesErro;
                } else {
                    return true;
                }
            } else {
                return $mesErro;
            }
            
        }
        
        /**
         * Método responsável por atualizar a parcela no banco de dados
         *
         * @param Array $dtoOrcamentoParcela - DTO da parcela
         * @param Boolean $cadastro - está em processo de cadastro
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoParcelaAtualizarFim($dtoOrcamentoParcela, $cadastro = true) {
            if (!$cadastro) {
                if (isset($_POST['datVencimento'])) {
                    if (!$dtoOrcamentoParcela->setDatVencimento($_POST['datVencimento']))
                        return false;
                }
            }
            
            $cdnOrcamento = $dtoOrcamentoParcela->getCdnOrcamento();
            $numParcela = $dtoOrcamentoParcela->getNumParcela();
            $arrDados = $dtoOrcamentoParcela->getArrayBanco();
            
            $arrCond = array('cdnOrcamento' => $cdnOrcamento,
                             'conscond1'    => 'AND',
                             'numParcela'   => $numParcela);
            
            return $this->atualizar('orcamento_parcela', $arrDados, $arrCond);
        }
        
        /**
         * Método utilizado para registrar a forma de pagamento do orçamento
         * no banco de dados
         *
         * @param Object $dtoOrcamentoFormaPagamento - objeto DTO da forma de pagamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoFormaPagamentoCadastrarFim(DTOOrcamento_formapagamento $dtoOrcamentoFormaPagamento) {
            
            $dadosFinais = $dtoOrcamentoFormaPagamento->getArrayBanco();
            
            return $this->inserir('orcamento_formapagamento', $dadosFinais);
            
        }
        
        /**
         * Método responsável por cadastrar as parcelas de um orçamento no banco de dados
         *
         * @param Array $arrParcelas - array de parcelas
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoParcelasCadastrarFim($arrParcelas) {
            foreach ($arrParcelas as $dtoOrcamentoParcela) {
                $dtoOrcamentoParcela = unserialize($dtoOrcamentoParcela);
                $dadosFinais = $dtoOrcamentoParcela->getArrayBanco();
                if (!$this->inserir('orcamento_parcela', $dadosFinais))
                    return false;
            }
            
            return true;
        }
        
        /**
         * Método responsável por retornar um select de orçamento.
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento para selecionar de início (opcional)
         * @param Boolean $label - colocar a label ou não. Padrão: true.
         * @param String $classe - classe do input. Padrão: iptCdnOrcamento.
         * @param String $nome - nome do input. Padrão: cdnOrcamento.
         * @return String - select de clientes
         *
         **/
        public function orcamentoRetornaSelect($cdnOrcamento = 0, $label = true, $classe = 'iptCdnOrcamento', $nome = 'cdnOrcamento') {
            $arrAreasAtuacoes = $this->consultar('orcamento', '*', array('indDesvinculado' => 0), 'nomOrcamento');
            $select = '';
            if ($label) {
                $select .= '<div class="form-group">
                               <label class="control-label" for="' . $nome . '">Consultório</label>';
            }
            $select .= '
                <select name="' . $nome . '" class="form-control ' . $classe . '">
                <option id="optPadrao" value="">Selecione o orçamento</option>' . PHP_EOL;
            foreach ($arrAreasAtuacoes as $arrOrcamento) {
                $dtoOrcamento = $this->getOrcamento($arrOrcamento['cdnOrcamento']);
                if ($dtoOrcamento->getCdnOrcamento() == $cdnOrcamento)
                    $selected = 'selected';
                else
                    $selected = '';
                
                $select .= '<option ' . $selected . ' value="' . $dtoOrcamento->getCdnOrcamento() . '">' . $dtoOrcamento->getCodOrcamento() . '</option>';
            }
            $select .= '</select>';
            if ($label)
                $select .= '</div>';
            
            return $select;
        }
        
        /**
         * Método responsável por deletar o orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoDeletarFim($cdnOrcamento) {
            $this->deletar('orcamento', array('cdnOrcamento' => $cdnOrcamento));
            $this->deletar('orcamento_formapagamento', array('cdnOrcamento' => $cdnOrcamento));
            $this->deletar('orcamento_parcela', array('cdnOrcamento' => $cdnOrcamento));
            
        }
        
        /**
         * Método responsável por atualizar as datas de vencimento de um orçamento a ser aprovado
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         *
         **/
        public function orcamentoAprovarFim($dtoOrcamento) {
            $cdnOrcamento = $dtoOrcamento->getCdnOrcamento();
            
            if ($dtoOrcamento->getIndAprovado()) {
                return true;
            }
            if (strtotime($dtoOrcamento->getDatValidade()) < strtotime(date('Y-m-d'))) {
                return false;
            }
            $dtoOrcamento->setIndAprovado(1);
            $dtoOrcamento->setCdnUsuarioAprovou($_SESSION['cdnUsuario']);
            $dtoOrcamento->setDatAprovacao(date('Y-m-d H:i:s'));
            
            $arrParcelas = $this->getOrcamentoParcela($cdnOrcamento);
            $dtoOrcamentoFormaPagamento = $this->getOrcamentoFormaPagamento($cdnOrcamento);
            $datInicioPagamento = $dtoOrcamentoFormaPagamento->getDatInicioPagamento();
            if ($dtoOrcamentoFormaPagamento->getIndForma() == 'parcelado') {
                
                $dtoOrcamentoParcela = unserialize($arrParcelas[0]);
                $dtoOrcamentoParcela->setDatVencimento($datInicioPagamento);
                $this->orcamentoParcelaAtualizarFim($dtoOrcamentoParcela);
                
                $datVencimento = $datInicioPagamento;
                
                for ($i = 1; $i < $dtoOrcamentoFormaPagamento->getNumVezes(); $i++) {
                    $dtoOrcamentoParcela = unserialize($arrParcelas[$i]);
                    $datVencimento = date('Y-m-d', strtotime('+1 month', strtotime($datVencimento)));
                    $dtoOrcamentoParcela->setDatVencimento($datVencimento);
                    $this->orcamentoParcelaAtualizarFim($dtoOrcamentoParcela);
                }
                
            } else {
                $dtoOrcamentoFormaPagamento->setDatVencimento($datInicioPagamento);
                $this->orcamentoFormaPagamentoAtualizarFim($dtoOrcamentoFormaPagamento);
            }
            
            return $this->orcamentoAtualizarFim($dtoOrcamento);
            
        }
        
        /**
         * Método responsável por gerar a nota promissória
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @param Integer $numParcela - número da parcela
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoNotaPromissoria($cdnOrcamento, $numParcela = 0) {
            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            $dtoParcela = $numParcela != 0 ? $this->getOrcamentoParcela($cdnOrcamento, $numParcela) : null;
            $pdfNota = new PDFOrcamento('P', 'mm');
            
            
            if (is_object($dtoParcela)) {
                if (is_null($dtoParcela->getValParcela()))
                    return false;
                $pdfNota->SetIndParcela(true);
                $pdfNota->SetDtoParcela($dtoParcela);
            } else {
                $pdfNota->SetIndParcela(false);
            }
            
            $pdfNota->SetDtoOrcamento($dtoOrcamento);
            
            $pdfNota->AddPage();
            
            $pdfNota->GerarNotaPromissoria();
            
            $pdfNota->OutPut();
            
            
        }
        
        public function orcamentoAutorizacaoDesconto($cdnOrcamento, $numParcela = null) {
            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            $dtoParcela = !is_null($numParcela) ? $this->getOrcamentoParcela($cdnOrcamento, $numParcela) : null;
            $pdf = new PDFOrcamento('P', 'mm');
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', '12');
            
            if (is_object($dtoParcela)) {
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
                
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($arrPaciente['cdnParceria']);
                
                $mes = explode('-', $dtoParcela->getDatVencimento())[1];
                
                $pdf->AddParcelaAutorizacao($cdnOrcamento, $numParcela, $dtoParceria->getNomParceria(), $dtoParcela->getDatVencimento(true),
                    $arrPaciente['cdnPaciente'].' - '.$arrPaciente['nomPaciente'], $dtoParcela->getValParcela(true), $dtoParcela->transformacaoNomeMes($mes));
                
                $pdf->Ln(20);
                
                $pdf->AddParcelaAutorizacao($cdnOrcamento, $numParcela, $dtoParceria->getNomParceria(), $dtoParcela->getDatVencimento(true),
                    $arrPaciente['cdnPaciente'].' - '.$arrPaciente['nomPaciente'], $dtoParcela->getValParcela(true), $dtoParcela->transformacaoNomeMes($mes));
            } else {
                $dtoForma = $this->getOrcamentoFormaPagamento($cdnOrcamento);
                
                $modPaciente = new ModeloPaciente();
                $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
    
                $modParceria = new ModeloParceria();
                $dtoParceria = $modParceria->getParceria($arrPaciente['cdnParceria']);
    
                $mes = explode('-', $dtoForma->getDatVencimento())[1];
    
                $pdf->AddParcelaAutorizacao($cdnOrcamento, $numParcela, $dtoParceria->getNomParceria(), $dtoForma->getDatVencimento(true),
                    $arrPaciente['cdnPaciente'].' - '.$arrPaciente['nomPaciente'], $dtoOrcamento->getValFinal(true), $dtoOrcamento->transformacaoNomeMes($mes));
    
                $pdf->Ln(20);
    
                $pdf->AddParcelaAutorizacao($cdnOrcamento, $numParcela, $dtoParceria->getNomParceria(), $dtoForma->getDatVencimento(true),
                    $arrPaciente['cdnPaciente'].' - '.$arrPaciente['nomPaciente'], $dtoOrcamento->getValFinal(true), $dtoOrcamento->transformacaoNomeMes($mes));
            }
            
            
            $pdf->OutPut();
            
            
        }
        
        /**
         * Método responsável por gerar um carnê de um orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         * @return Boolean - true se sucesso, false se não
         *
         **/
        public function orcamentoCarne($cdnOrcamento) {
            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            
            $arrParcelas = $this->getOrcamentoParcela($cdnOrcamento);
            
            $pdfCarne = new PDFOrcamento('P', 'mm');
            $pdfCarne->SetMargins(0, 0, 0);
            $pdfCarne->SetAutoPageBreak(false);
            
            $pdfCarne->SetDtoOrcamento($dtoOrcamento);
            $pdfCarne->SetArrParcelas($arrParcelas);
            
            $pdfCarne->AddPage();
            
            $pdfCarne->GerarCarne();
            
            $pdfCarne->OutPut();
            
        }
        
        /**
         * Método responsável por imprimir um orçamento
         *
         * @param Integer $cdnOrcamento - código numérico do orçamento
         *
         **/
        public function orcamentoImprimir($cdnOrcamento) {
            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            
            $dtoOrcamentoFormaPagamento = $this->getOrcamentoFormaPagamento($cdnOrcamento);
            if (is_null($dtoOrcamentoFormaPagamento->getNumVezes())) {
                $arrParcelas = array();
                $numVezes = $dtoOrcamentoFormaPagamento->getNumVezes();
                $aVista = array(
                    'numVezes'     => 'A VISTA',
                    'valOrcamento' => $dtoOrcamento->getValFinal(true),
                    'valTaxas'     => '0,00',
                );
                $arrParcelas[] = $aVista;
                if ($numVezes > 1) {
                    $taxa = $dtoOrcamentoFormaPagamento->getNumPorcentagem();
                    
                    for ($i = 2; $i <= $numVezes; $i++) {
                        $valor = $dtoOrcamento->getValFinal();
                        $valor = floatval($valor) * pow((1 + floatval($taxa) / 100), intval($i));
                        $valor = round($valor, 2);
                        $arrParcelas[] = array(
                            'numVezes'     => $i,
                            'valOrcamento' => number_format($valor, 2, ',', '.'),
                            'valTaxas'     => number_format($valor - $dtoOrcamento->getValFinal(), 2, ',', '.'),
                        );
                    }
                }
            } else {
                $arrParcelas = $this->getOrcamentoParcela($cdnOrcamento);
            }
            
            $pdfOrcamento = new PDFOrcamento('P', 'mm');
            $pdfOrcamento->tipo = 'orcamento';
            $pdfOrcamento->SetAutoPageBreak(false);
            $pdfOrcamento->SetDtoOrcamento($dtoOrcamento);
            $pdfOrcamento->SetArrParcelas($arrParcelas);
            $pdfOrcamento->SetDtoFormaPagamento($dtoOrcamentoFormaPagamento);
            
            $pdfOrcamento->AddPage();
            
            $pdfOrcamento->ImprimirOrcamento();
            
            $pdfOrcamento->OutPut();
        }
        
        public function orcamentoVerificaPago($cdnOrcamento, $numParcela) {
            if ($numParcela != 0) {
                $dtoParcela = $this->getOrcamentoParcela($cdnOrcamento, $numParcela);
                
                return $dtoParcela->getIndPaga();
            } else {
                $orcamento = $this->getOrcamento($cdnOrcamento);
                
                return $orcamento->getIndFinalizado();
            }
        }
        
        public function orcamentoValidaPagamento($cdnOrcamento, $numParcela) {
            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
            $dtoFormaPagamento = $this->getOrcamentoFormaPagamento($cdnOrcamento);
            $arrRetorno = array(true, $dtoOrcamento, $dtoFormaPagamento);
            
            if ($dtoOrcamento->getIndAprovado() == 0)
                return array(false);
            
            if ($dtoFormaPagamento->getNumVezes() != 1) {
                if ($numParcela == 0)
                    return array(false);
                
                $dtoParcela = $this->getOrcamentoParcela($cdnOrcamento, $numParcela);
                if (is_null($dtoParcela->getNumParcela()))
                    return array(false);
                
                $arrRetorno[] = $dtoParcela;
            } else {
                if ($numParcela != 0)
                    return array(false);
            }
            if ($this->orcamentoVerificaPago($cdnOrcamento, $numParcela))
                return array(false);
            
            return $arrRetorno;
            
            
        }
        
        public function orcamentoRegistrarPagamentoFim($cdnOrcamento, $numParcela) {
            if (!$this->orcamentoValidaPagamento($cdnOrcamento, $numParcela))
                return false;
            if ($numParcela == 0) {
                $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
                $dtoOrcamento->setIndFinalizado(1);
                
                return $this->orcamentoAtualizarFim($dtoOrcamento);
            } else {
                
                $dtoParcela = $this->getOrcamentoParcela($cdnOrcamento, $numParcela);
                $dtoParcela->setIndPaga(1);
                if ($this->orcamentoParcelaAtualizarFim($dtoParcela, false)) {
                    $sql = 'SELECT COUNT(numParcela) as qtd FROM orcamento_parcela WHERE
                            cdnOrcamento = ' . $cdnOrcamento . ' AND indPaga = 1';
                    
                    $arrParcelas = $this->query($sql);
                    if (count($arrParcelas) > 0) {
                        $qtd = $arrParcelas[0]['qtd'];
                        $dtoFormaPagamento = $this->getOrcamentoFormaPagamento($cdnOrcamento);
                        if ($dtoFormaPagamento->getNumVezes() == $qtd) {
                            $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
                            $dtoOrcamento->setIndFinalizado(1);
                            if (!$this->orcamentoAtualizarFim($dtoOrcamento)) {
                                $dtoParcela->setIndPaga(0);
                                $this->orcamentoParcelaAtualizarFim($dtoParcela, false);
                                
                                return false;
                            }
                            
                            return true;
                        }
                    }
                    
                    return true;
                }
                
                return false;
            }
            
        }
        
        public function orcamentoDesfazerPagamento($cdnOrcamento, $numParcela) {
            if ($this->orcamentoVerificaPago($cdnOrcamento, $numParcela)) {
                if ($numParcela == 0) {
                    $dtoOrcamento = $this->getOrcamento($cdnOrcamento);
                    $dtoOrcamento->setIndFinalizado(0);
                    
                    return $this->orcamentoAtualizarFim($dtoOrcamento);
                } else {
                    $dtoParcela = $this->getOrcamentoParcela($cdnOrcamento, $numParcela);
                    $dtoParcela->setIndPaga(0);
                    
                    return $this->orcamentoParcelaAtualizarFim($dtoParcela, false);
                }
            }
        }
        
        public function orcamentoCadastrarFormaPagamento($dtoOrcamento) {
            $dtoOrcamentoFormaPagamento = new DTOOrcamento_formapagamento();
            $numVezes = $_POST['numVezes'];
            
            if ($numVezes < 1) {
                return false;
            }
            $dtoOrcamentoFormaPagamento->setNumVezes($_POST['numVezes']);
            
            
            if (isset($_POST['datInicioPagamento'])) {
                if ($_POST['datInicioPagamento'] == '')
                    return false;
                $datInicioPagamento = $_POST['datInicioPagamento'];
                $segInicioPagamento = strtotime($datInicioPagamento);
                $hoje = strtotime(date('Y-m-d'));
                
                if ($segInicioPagamento < $hoje)
                    return false;
                
                if ($dtoOrcamentoFormaPagamento->setDatInicioPagamento($datInicioPagamento))
                    true;
                else
                    return false;
            } else {
                return false;
            }
            
            if(isset($_POST['numDiaVencimento'])) {
                $dtoOrcamentoFormaPagamento->setNumDiaVencimento($_POST['numDiaVencimento']);
            }else{
                $dtoOrcamentoFormaPagamento->setNumDiaVencimento($datInicioPagamento);
            }
            
            if ($numVezes == 1) {
                $dtoOrcamentoFormaPagamento->setIndForma('aVista');
                $dtoOrcamentoFormaPagamento->setDatVencimento($dtoOrcamentoFormaPagamento->getDatInicioPagamento());
                $forma = 'aVista';
            } else {
                $dtoOrcamentoFormaPagamento->setIndForma('parcelado');
                $forma = 'parcelado';
            }
            
            if (!isset($_POST['tipo'])) {
                return false;
            }
            if (!$dtoOrcamentoFormaPagamento->setIndVia($_POST['tipo'])) {
                return false;
            }
            
            if ($_POST['tipo'] == 'carne' and $forma != 'parcelado') {
                return false;
            }
            
            if ($dtoOrcamento->getIndCobrarJuros()) {
                $modMain = new ModeloMain(true);
                $dtoConfiguracoes = $modMain->getConfiguracoes();
                $dtoOrcamentoFormaPagamento->setNumPorcentagem($dtoConfiguracoes->getValJurosOrcamento());
            } else {
                $dtoOrcamentoFormaPagamento->setNumPorcentagem(0);
            }
            
            $dtoOrcamentoFormaPagamento->setCdnOrcamento($dtoOrcamento->getCdnOrcamento());
            
            return $this->orcamentoFormaPagamentocadastrarFim($dtoOrcamentoFormaPagamento);
            
            
        }
        
        public function orcamentoCalcularValorFinal($dtoOrcamento) {
            $valEntrada = $_POST['valEntrada'];
            $valDesconto = $_POST['valDesconto'];
            $tipo = $_POST['indTipoDesconto'];
            
            $vezes = $_POST['numVezes'];
            $valor = $dtoOrcamento->getValOrcamento();
            if ($dtoOrcamento->getIndCobrarJuros()) {
                if ($vezes > 1) {
                    $modMain = new ModeloMain(true);
                    $dtoConfiguracoes = $modMain->getConfiguracoes();
                    $taxa = $dtoConfiguracoes->getValJurosOrcamento();
                    $valor = floatval($valor) * pow((1 + floatval($taxa) / 100), $vezes);
                    $valor = round($valor, 2);
                }
            }
            
            $valEntrada = $dtoOrcamento->transformacaoDecimal($valEntrada);
            if ($tipo == 'qtd') {
                $valDesconto = $dtoOrcamento->transformacaoDecimal($valDesconto);
                if ($valor < $valDesconto) {
                    return array(false);
                }
                $valor -= $valEntrada;
                if ($valor < $valDesconto)
                    return array(false);
                
                $valor -= $valDesconto;
                $dtoOrcamento->setValFinal($valor);
                $dtoOrcamento->setValDesconto($valDesconto);
                $dtoOrcamento->setIndTipoDesconto('qtd');
                
                return array(true, $dtoOrcamento);
            } else {
                $valDesconto = $valDesconto / 100;
                $valor = $valor - ($valor * $valDesconto);
                if ($valor < 0)
                    return array(false);
                $dtoOrcamento->setValFinal($valor);
                $dtoOrcamento->setValDesconto($valDesconto);
                $dtoOrcamento->setIndTipoDesconto('prc');
                
                return array(true, $dtoOrcamento);
            }
        }
        
        public function orcamentoRelatorioPreparaCampos() {
            if (!isset($_POST['forma'])) {
                $forma = 'todas';
            } else {
                if ($this->validacaoOrcamentoVia($_POST['forma']))
                    $forma = $_POST['forma'];
                else
                    $forma = 'todas';
            }
            
            if (!isset($_POST['datas'])) {
                $datas = array(date('Y-m-01'), date('Y-m-t'));
                $_POST['datas'] = date('01/m/Y') . ' - ' . date('t/m/Y');
            } else {
                $datas = $_POST['datas'];
                $datas = explode('-', $datas);
                if (count($datas) != 2) {
                    $datas = array(date('Y-m-01'), date('Y-m-t'));
                    $_POST['datas'] = date('01/m/Y') . ' - ' . date('t/m/Y');
                } else {
                    $datas[0] = trim($datas[0]);
                    $datas[1] = trim($datas[1]);
                    $datas[0] = explode('/', $datas[0]);
                    $datas[1] = explode('/', $datas[1]);
                    if (count($datas[0]) != 3 || count($datas[1]) != 3) {
                        $datas = array(date('Y-m-01'), date('Y-m-t'));
                        $_POST['datas'] = date('01/m/Y') . ' - ' . date('t/m/Y');
                    } else {
                        $datas[0] = $datas[0][2] . '-' . $datas[0][1] . '-' . $datas[0][0];
                        $datas[1] = $datas[1][2] . '-' . $datas[1][1] . '-' . $datas[1][0];
                        if (!$this->validacaoData(trim($datas[0])) || !$this->validacaoData(trim($datas[1]))) {
                            $datas = array(date('01/m/Y'), date('t/m/Y'));
                            $_POST['datas'] = date('01/m/Y') . ' - ' . date('t/m/Y');
                        }
                    }
                }
            }
            
            return array($forma, $datas);
        }
        
        public function orcamentoRelatorioAprovados() {
            $campos = $this->orcamentoRelatorioPreparaCampos();
            $sql = 'SELECT * FROM orcamento o
                    JOIN orcamento_formapagamento f ON o.cdnOrcamento = f.cdnOrcamento
                    JOIN paciente p ON p.cdnPaciente = o.cdnPaciente
                    JOIN prophet_main.usuario u ON u.cdnUsuario = o.cdnUsuarioAprovou
                    WHERE o.indAprovado = 1 AND
                          o.datAprovacao >= "' . $campos[1][0] . '" AND
                          o.datAprovacao <= "' . $campos[1][1] . '"
            ';
            if ($campos[0] != 'todas') {
                $sql .= ' AND f.indVia = "' . $campos[0] . '"';
            }
            $arrOrcamentos = $this->query($sql);
            
            $pdfRelatorio = new PDFOrcamento('P', 'mm');
            $pdfRelatorio->SetCabecalho('aprovados');
            $pdfRelatorio->periodo = $_POST['datas'];
            $pdfRelatorio->tipo = 'aprovados';
            $pdfRelatorio->AliasNbPages();
            
            $pdfRelatorio->AddPage();
            
            $pdfRelatorio->RelatorioAprovados($arrOrcamentos, $_POST['datas']);
            
            $pdfRelatorio->OutPut();
            
        }
        
        public function orcamentoRelatorioReprovados() {
            $campos = $this->orcamentoRelatorioPreparaCampos();
            $sql = 'SELECT * FROM orcamento o
                    JOIN orcamento_formapagamento f ON o.cdnOrcamento = f.cdnOrcamento
                    JOIN paciente p ON p.cdnPaciente = o.cdnPaciente
                    JOIN prophet_main.usuario u ON u.cdnUsuario = o.cdnUsuarioAprovou
                    WHERE o.indAprovado = 0 AND
                          o.datOrcamento >= "' . $campos[1][0] . '" AND
                          o.datOrcamento <= "' . $campos[1][1] . '"
            ';
            if ($campos[0] != 'todas') {
                $sql .= ' AND f.indVia = "' . $campos[0] . '"';
            }
            
            $arrOrcamentos = $this->query($sql);
            
            $pdfRelatorio = new PDFOrcamento('P', 'mm');
            $pdfRelatorio->SetCabecalho('reprovados');
            $pdfRelatorio->periodo = $_POST['datas'];
            $pdfRelatorio->tipo = 'reprovados';
            $pdfRelatorio->AliasNbPages();
            
            $pdfRelatorio->AddPage();
            
            $pdfRelatorio->RelatorioReprovados($arrOrcamentos, $_POST['datas']);
            
            $pdfRelatorio->OutPut();
            
        }
        
    }
