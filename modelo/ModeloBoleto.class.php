<?php

    class ModeloBoleto extends Modelo{
        use Validacao;
        private $campos = array(
            'agencia' => array(
                'name' => 'agencia',
                'label' => 'Agência'
            ),

            'conta' => array(
                'name' => 'conta',
                'label' => 'Conta'
            ),

            'codigoCedente' => array(
                'name' => 'codigoCedente',
                'label' => 'Código Cedente',
            ),

            'carteira' => array(
                'name' => 'carteira',
                'label' => 'Carteira'
            ),

            'razaoSocial' => array(
                'name' => 'razaoSocial',
                'label' => 'Razão Social',
                'maxlength' => 100,
            ),

            'cpfCnpj' => array(
                'name' => 'cpfCnpj',
                'label' => 'CPF/CNPJ',
                'class' => 'mask-cpfcnpj',
            ),

            'endereco' => array(
                'name' => 'endereco',
                'label' => 'Endereço',
                'maxlength' => 100,
            ),

            'email' => array(
                'name' => 'email',
                'label' => 'E-mail',
                'maxlength' => 100
            ),
        );

        private $bancos = array(
            '041' => array(
                'nome' => 'Banrisul',
                'campos' => array('agencia', 'conta', 'codigoCedente', 'carteira', 'razaoSocial', 'cpfCnpj', 'endereco', 'email'),
                'funcaoGerar' => 'boletoGerarBanrisul'
            )
        );

        public function boletoMontaSql($cdnPaciente = null, $join = false){
            $origem = isset($_POST['origem']) ? $_POST['origem'] : null;
            $datas = isset($_POST['datas']) ? $_POST['datas'] : null;
            if(is_null($cdnPaciente)){
                $cdnPaciente = isset($_POST['cdnPaciente']) ? $_POST['cdnPaciente'] : null;
            }
            switch ($origem) {
                case 'orcamento_parcela':
                    $sql = 'SELECT * FROM boleto b ';
                    if($join){
                        $sql .= 'JOIN paciente p on b.cdnPaciente = p.cdnPaciente JOIN prophet_main.usuario u ON u.cdnUsuario = b.cdnUsuario ';
                    }
                    $sql .= 'WHERE b.desOrigem LIKE "ORCAMENTO%" AND b.desOrigem LIKE "%PARCELA%" AND ';
                    break;
                case 'orcamento':
                    $sql = 'SELECT * FROM boleto b ';
                    if($join){
                        $sql .= 'JOIN paciente p on b.cdnPaciente = p.cdnPaciente JOIN prophet_main.usuario u ON u.cdnUsuario = b.cdnUsuario ';
                    }
                    $sql .= 'WHERE b.desOrigem LIKE "ORCAMENTO%" AND NOT b.desOrigem LIKE "%PARCELA%" AND ';
                    break;
                default:
                    $sql = 'SELECT * FROM boleto b ';
                    if($join){
                        $sql .= 'JOIN paciente p on b.cdnPaciente = p.cdnPaciente JOIN prophet_main.usuario u ON u.cdnUsuario = b.cdnUsuario ';
                    }
                    break;
            }

            if(!is_null($datas) and trim($datas) != ''){
                $datas = explode('-', $datas);
                $datIni = trim($datas[0]);
                $datFim = trim($datas[1]);
                if($datIni == $datFim){
                    $sql .= 'b.datGerado = '.$datIni.' AND ';
                }else{
                    $datIni = explode('/', $datIni);
                    $datIni = $datIni[2].'-'.$datIni[1].'-'.$datIni[0];

                    $datFim = explode('/', $datFim);
                    $datFim = $datFim[2].'-'.$datFim[1].'-'.$datFim[0];

                    if(strtotime($datIni) < strtotime($datFim)){
                        $sql .= 'b.datGerado >= "'.$datIni.' 00:00:00" AND b.datGerado <= "'.$datFim.' 00:00:00" AND ';
                    }
                }
            }

            if(!is_null($cdnPaciente) and trim($cdnPaciente) != ''){
                $sql .= 'b.cdnPaciente = '.$cdnPaciente;
            }

            return trim($sql, 'WHERE AND');

        }

        public function getConfiguracao(){
            $arrConf = $this->consultar('clinica_conf_boleto', '*', array('cdnClinica' => $_SESSION['cdnClinica']));
            if(count($arrConf) > 0)
                return $arrConf[0];
            return array();
        }

        public function boletoMontaFormulario($banco){
            $configuracao = $this->getConfiguracao();
            $final = '<div class="row">';
            $esqueleto = '
                <div class="col-sm-4 form-group">
                    <label for="%nome%" class="control-label">%lbl%</label>
                    <input type="text" name="%nome%" class="form-control %classes%" %maxlength% value="%valor%"/>
                </div>
            ';

            $campos = $this->bancos[$banco]['campos'];

            foreach($campos as $nomCampo){
                $campo = $this->campos[$nomCampo];
                $div = str_replace('%nome%', $campo['name'], $esqueleto);
                $div = str_replace('%lbl%', $campo['label'], $div);
                if(!isset($campo['class']))
                    $campo['class'] = '';
                $div = str_replace('%classes%', $campo['class'], $div);
                if(!isset($campo['maxlength']))
                    $campo['maxlength'] = '';
                $div = str_replace('%maxlength%', 'maxlength="'.$campo['maxlength'].'"', $div);
                $valor = isset($configuracao[$campo['name']]) ? $configuracao[$campo['name']] : '';
                $div = str_replace('%valor%', $valor, $div);
                $final .= $div;
            }

            $final .= '</div>';
            echo $final;
        }

        public function boletoAtualizarConfiguracoes(){
            $banco = $_POST['banco'];
            $arrDados = array();
            foreach($this->bancos[$banco]['campos'] as $campo){
                $campo = $this->campos[$campo];
                $arrDados[$campo['name']] = $_POST[$campo['name']];
            }
            $arrDados['banco'] = $banco;
            $arrDados['cdnClinica'] = $_SESSION['cdnClinica'];
            if(!$this->checaExiste('clinica_conf_boleto', 'cdnClinica', $_SESSION['cdnClinica']))
                return $this->inserir('clinica_conf_boleto', $arrDados);
            else
                return $this->atualizar('clinica_conf_boleto', $arrDados, array('cdnClinica' => $_SESSION['cdnClinica']));
        }

        public function boletoGerarFim($valor, $tipo, $cdnPaciente, $argumentos){
            $dtoBoleto = new DTOBoleto();
            if(!$dtoBoleto->setValBoleto($valor)){
                return array(false, 'Informe um valor válido para o boleto.');
            }
            
            if(!$dtoBoleto->setCdnPaciente($cdnPaciente)){
                return array(false, 'Informe um paciente valido.');
            }
            switch ($tipo) {
                case 'orcamento':
                    $cdnOrcamento = $argumentos[0];
                    $tipo = 'ORCAMENTO NÚMERO: '.$cdnOrcamento;
                    break;

                case 'orcamento_parcela':
                    $cdnOrcamento = $argumentos[0];
                    $numParcela = $argumentos[1];
                    $tipo = 'ORCAMENTO NÚMERO: '.$cdnOrcamento.' - PARCELA NÚMERO: '.$numParcela;
                    break;

                default:
                    return array(false, 'Tipo de boleto inválido.');
                    break;
            }
            $dtoBoleto->setDesOrigem($tipo);

            $numNossoNumero = $this->ultimoInserido('boleto');
            $numNossoNumero++;
            $dtoBoleto->setNumNossoNumero($numNossoNumero);
            $dtoBoleto->setDatGerado(date('Y-m-d H:i:s'));
            $dtoBoleto->setCdnUsuario($_SESSION['cdnUsuario']);

            if($this->boletoCadastrarFim($dtoBoleto)){
                $configuracoes = new ModeloBoleto(true);
                $configuracoes = $configuracoes->getConfiguracao();
                $banco = $configuracoes['banco'];
                $funcao = $this->bancos[$banco]['funcaoGerar'];
                $this->{$funcao}($dtoBoleto, $configuracoes);
                return true;
            }else{
                return false;
            }

        }

        public function boletoCadastrarFim(DTOBoleto $dtoBoleto){
            $arrDados = $dtoBoleto->getArrayBanco();
            return $this->inserir('boleto', $arrDados);
        }

        public function boletoGerarBanrisul(DTOBoleto $dtoBoleto, $configuracoes){
            // $url = 'https://ww8.banrisul.com.br/brb/link/Brbw2Lhw_Bloqueto_Titulos_Internet.aspx?'.
            //         'Origem=EX&'.
            //         'CodCedente='.$configuracoes['codigoCedente'].'&'.
            //         'Valor='.$dtoBoleto->getValBoleto().'&'.
            //         'SeuNumero='.$dtoBoleto->getNumNossoNumero();
            // header('location: '.$url);
            // die;
            header('Content-type: text/html; charset=utf-8');
            include 'plugins/objectboleto/OB_init.php';

            $ob = new OB('041');

            $ob->Vendedor
                    ->setAgencia($configuracoes['agencia'])
                    ->setConta($configuracoes['conta'])
                    ->setCodigoCedente($configuracoes['codigoCedente'])
                    ->setCarteira($configuracoes['carteira'])
                    ->setRazaoSocial($configuracoes['razaoSocial'])
                    ->setEndereco($configuracoes['endereco'])
                    ->setEmail($configuracoes['email'])
                ;
            if($this->validacaoCpf($configuracoes['cpfCnpj']))
                $ob->Vendedor->setCpf($configuracoes['cpfCnpj']);
            else
                $ob->Vendedor->setCnpj($configuracoes['cpfCnpj']);


            $ob->Configuracao->setLocalPagamento('Pagável em qualquer banco até o vencimento');


            $ob->Template
                    ->setTitle(uniqid())
                    ->setTemplate('html5')
                ;

            $modPaciente = new ModeloPaciente();
            $arrPaciente = $modPaciente->getPaciente($dtoBoleto->getCdnPaciente(), true);

            $ob->Cliente
                    ->setNome($arrPaciente['nomPaciente'])
                ;
            $ob->Boleto
                    ->setValor(1)
                    ->setDiasVencimento(5)
                    // ->setVencimento(4,7,2000)
                    ->setNossoNumero($dtoBoleto->getNumNossoNumero())
                ;

            $ob->render(); /**/

        }

    }
