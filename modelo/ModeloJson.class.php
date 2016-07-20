<?php

    /**
     * Classe que realiza a montagem do JSON das datatables
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-12-03
     *
    **/
    class ModeloJson extends Modelo{
    	private $enc;
        private $SSP;
        use Transformacao;

        /**
         * Método construtor
         *
        **/
        public function __construct(){
            parent::__construct();
            if(LOCAL == 'localhost'){
                $this->enc = 'windows-1252';
            }else{
                $this->enc = 'UTF-8';
            }
            $this->SSP = new SSP();
    	}

    	/**
    	 * Método responsável por finalizar a geração do JSON
    	 *
    	 * @param String $tabela - nome da tabela
    	 * @param String $chavePrimaria - nome da chave primaria
    	 * @param Array $colunas - colunas que serão exibidas
    	 * @param String $where - condições da consulta
    	 * @param String $extras - colunas extras
    	 * @return String - json requisitado
    	 *
    	**/
    	public function jsonFinalizar($tabela, $chavePrimaria, $colunas, $where = null, $extras = null, $join = ''){
            $sql_details = array(
                'user' => USUARIO_BANCO,
                'pass' => SENHA_BANCO,
                'db'   => BANCO,
                'host' => HOST
            );

            if(!is_null($where)){
            	$json = SSP::complex($_GET, $sql_details, $tabela, $chavePrimaria, $colunas, null, $where, $extras, $join);
            }else{
            	$json = SSP::simple($_GET, $sql_details, $tabela, $chavePrimaria, $colunas, $extras);
            }

            return json_encode($json);
    	}

        /**
         * Método responsável por montar o json das consultas
         *
         * @param String $tipo - tipo de visualização de consultas
         * @return Void.
         *
        **/
        public function jsonConsultas($tipo){

            $sqlDesmarques = 'SELECT cdnConsulta FROM desmarque';

            switch ($tipo) {
                case 'ativas':
                    $where = 'cdnConsulta NOT IN ('.$sqlDesmarques.') AND datConsulta >= "'.date('Y-m-d').'"';
                    break;

                case 'passadas_ativas':
                    $where = 'cdnConsulta NOT IN ('.$sqlDesmarques.')';
                    break;

                case 'desmarcadas':
                    $where = 'cdnConsulta IN ('.$sqlDesmarques.')';
                    break;

                default:
                    $where = '';
                    break;
            }


            if(Modelo::dentista($_SESSION['cdnUsuario'])){
                if(!Modelo::masterStatic($_SESSION['cdnUsuario'])){
                    if($where != '')
                        $where .= ' AND ';
                    $where .= 'cdnDentista = '.$_SESSION['cdnUsuario'];
                }
            }

            // DB table to use
            $table = 'consulta';

            // Table's primary key
            $primaryKey = 'cdnConsulta';

            $columns = array();

            // Nome do paciente
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 0,
                               'formatter' =>
                                    function($d, $row){
                                        $modPaciente = new ModeloPaciente();
                                        $arrPaciente = $modPaciente->getPaciente($d, true);
                                        $nomPaciente = utf8_encode($arrPaciente['nomPaciente']);
                                        $d = '<a href="'.BASE_URL.'/paciente/consultarFim/'.$d.'">
                                             '.$nomPaciente.'</a>';
                                        return $d;
                                    }
                              );

            // Nro do prontuário
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 1,
                               'formatter' =>
                                    function($d, $row){
                                        $indProntuarioAntigo = ControleCampo::campoExiste('numProntuarioAntigo');
                                        if($indProntuarioAntigo){
                                            $modPaciente = new ModeloPaciente();
                                            $arrPaciente = $modPaciente->getPaciente($d, true);
                                            $d .= ' - '.$arrPaciente['numProntuarioAntigo'];
                                        }
                                        $d = '<a href="'.BASE_URL.'/consulta/consultarFim/'.$row['cdnConsulta'].'">'.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Data
            $columns[] = array('db' => 'datConsulta',
                               'dt' => 2,
                               'formatter' =>
                                    function($d, $row){
                                        $d = $this->transformacaoData($d);
                                        $d = '<a href="'.BASE_URL.'/consulta/consultarFim/'.$row['cdnConsulta'].'">'.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Horário
            $columns[] = array('db' => 'horaConsulta',
                   'dt' => 3,
                   'formatter' =>
                        function($d, $row){
                            $d = '<a href="'.BASE_URL.'/consulta/consultarFim/'.$row['cdnConsulta'].'">'.$d.'</a>';
                            return $d;
                        }
                  );

            // Botões
            $columns[] = array('db' => 'cdnConsulta',
                               'dt' => 4,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '  <a href="'.BASE_URL.'/consulta/consultarFim/'.$row['cdnConsulta'].'">
                                                    <button type="button" class="btn btn-primary">
                                                        Visualizar
                                                    </button>
                                                </a>
                                                <a href="'.BASE_URL.'/consulta/remarcar/'.$row['cdnConsulta'].'">
                                                    <button type="button" class="btn btn-primary">
                                                        Remarcar
                                                    </button>
                                                </a>';
                                        return $d;
                                    });

			return $this->jsonFinalizar($table, $primaryKey, $columns, $where);
		}

        /**
         * Método responsável por montar o json das parcerias
         *
         * @return String - json das parcerias.
         *
        **/
        public function jsonParcerias(){
        	$modParceria = new ModeloParceria();

            // DB table to use
            $table = 'parceria';

            // Table's primary key
            $primaryKey = 'cdnParceria';

            $columns = array();

            // Número
            $columns[] = array('db' => 'cdnParceria',
                               'dt' => 0,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '<a href="'.BASE_URL.'/parceria/consultarFim/'.$d.'">
                                             '.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Nome
            $columns[] = array('db' => 'nomParceria',
                               'dt' => 1,
                               'formatter' =>
                                    function($d, $row){
                                    	$d = utf8_encode($d);
                                        $d = '<a href="'.BASE_URL.'/parceria/consultarFim/'.$row['cdnParceria'].'">'.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Telefones
            $columns[] = array('db' => 'numTelefone1',
                               'dt' => 2,
                               'formatter' =>
                                    function($d, $row){
                                    	$modParceria = new ModeloParceria();
                                    	$dtoParceria = $modParceria->getParceria($row['cdnParceria']);
                                        $d = '<a href="'.BASE_URL.'/consulta/consultarFim/'.$row['cdnParceria'].'">'.$d.'/'.$dtoParceria->getNumTelefone2().'</a>';
                                        return $d;
                                    }
                              );

            // Botões
            $columns[] = array('db' => 'cdnParceria',
                               'dt' => 3,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '  <a href="'.BASE_URL.'/parceria/consultarFim/'.$row['cdnParceria'].'">
                                                    <button type="button" class="btn btn-success">
                                                        <span class="fa fa-hand-o-right"></span>
                                                    </button>
                                                </a>
                                                <a href="'.BASE_URL.'/parceria/atualizar/'.$row['cdnParceria'].'">
                                                    <button type="button" class="btn btn-success">
                                                        <span class="fa fa-edit"></span>
                                                    </button>
                                                </a>';
                                        return $d;
                                    });

			return $this->jsonFinalizar($table, $primaryKey, $columns, 'indDesvinculada = 0');
        }

        /**
         * Método responsável por montar o json dos pacientes
         *
         * @param String $tipo - tipo do json
         * @return String - json das parcerias.
         *
        **/
        public function jsonPacientes($tipo){
            // DB table to use
            $table = 'paciente';

            // Table's primary key
            $primaryKey = 'cdnPaciente';

            $columns = array();

            $extras = array();
            if(ControleCampo::campoExiste('nomSobrenome'))
            	$extras[] = 'nomSobrenome';
            if(ControleCampo::campoExiste('numProntuarioAntigo'))
            	$extras[] = 'numProntuarioAntigo';


            if($tipo == 'modal'){
                // Id
                $columns[] = array(
                    'db' => 'cdnPaciente',
                    'dt' => 0
                );
            }


            $this->tipo = $tipo;

            // Nome
            $columns[] = array('db' => 'nomPaciente',
                               'dt' => $tipo == 'consultar' ? 0 : 1,
                               'formatter' =>
                                    function($d, $row){
                                        if(isset($row['nomSobrenome']))
                                            $d = utf8_encode($d.' '.$row['nomSobrenome']);
                                        else
                                            $d = utf8_encode($d);
                                        if($this->tipo == 'consultar'){
                                            $d = '<a href="'.BASE_URL.'/paciente/consultarFim/'.$row['cdnPaciente'].'">
                                                 '.$d.'</a>';
                                            return $d;
                                        }else{
                                            return $d;
                                        }
                                    }
                              );

            if($tipo == 'consultar'){
                // Prontuário
                $columns[] = array('db' => 'cdnPaciente',
                                   'dt' => 1,
                                   'formatter' =>
                                      function($d, $row){
                                          if(isset($row['numProntuarioAntigo']))
                                            $d.= ' - '.$row['numProntuarioAntigo'];
                                            $d = '<a href="'.BASE_URL.'/paciente/consultarFim/'.$row['cdnPaciente'].'">'.$d.'</a>';
                                            return $d;
                                        }
                                  );
                // Botões
                $columns[] = array('db' => 'cdnPaciente',
                                   'dt' => 2,
                                   'formatter' =>
                                        function($d, $row){
                                            $d = '  <a href="'.BASE_URL.'/paciente/consultarFim/'.$row['cdnPaciente'].'">
                                                        <button type="button" class="btn btn-success">
                                                            Visualizar
                                                        </button>
                                                    </a>
                                                    <a href="'.BASE_URL.'/paciente/atualizar/'.$row['cdnPaciente'].'">
                                                        <button type="button" class="btn btn-success">
                                                            Editar
                                                        </button>
                                                    </a>';
                                            return $d;
                                        });
            }

			return $this->jsonFinalizar($table, $primaryKey, $columns, 'indDesvinculado = 0', $extras);
        }

        /**
         * Método responsável por montar o json dos prontuários
         *
         * @return String - json dos prontuários
         *
        **/
        public function jsonProntuarios(){
            // DB table to use
            $table = 'paciente';

            // Table's primary key
            $primaryKey = 'cdnPaciente';

            $columns = array();

            $extras = array();
            if(ControleCampo::campoExiste('nomSobrenome'))
                $extras[] = 'nomSobrenome';
            if(ControleCampo::campoExiste('numProntuarioAntigo'))
                $extras[] = 'numProntuarioAntigo';

            // Nome
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 0,
                               'formatter' =>
                                    function($d, $row){
                                        if(isset($row['numProntuarioAntigo']))
                                            $d.= ' - '.$row['numProntuarioAntigo'];
                                        $d = '<a href="'.BASE_URL.'/prontuario/consultarFim/'.$row['cdnPaciente'].'">'.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Número
            $columns[] = array('db' => 'nomPaciente',
                               'dt' => 1,
                               'formatter' =>
                                    function($d, $row){
                                        if(isset($row['nomSobrenome']))
                                            $d = utf8_encode($d.' '.$row['nomSobrenome']);
                                        else
                                            $d = utf8_encode($d);
                                        $d = '<a href="'.BASE_URL.'/prontuario/consultarFim/'.$row['cdnPaciente'].'">
                                             '.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Botões
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 2,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '  <a href="'.BASE_URL.'/prontuario/consultarFim/'.$row['cdnPaciente'].'">
                                                    <button type="button" class="btn btn-success">
                                                        Visualizar
                                                    </button>
                                                </a>';
                                        return $d;
                                    });

            return $this->jsonFinalizar($table, $primaryKey, $columns, 'indDesvinculado = 0', $extras);
        }

        /**
         * Método responsável por montar o json dos questionários anamneses
         *
         * @return String - JSON dos questionários anamnese
         *
        **/
        public function jsonAnamneses(){
            // DB table to use
            $table = 'paciente';

            // Table's primary key
            $primaryKey = 'cdnPaciente';

            $columns = array();

            $extras = array();
            if(ControleCampo::campoExiste('nomSobrenome'))
                $extras[] = 'nomSobrenome';
            if(ControleCampo::campoExiste('numProntuarioAntigo'))
                $extras[] = 'numProntuarioAntigo';

            // Nome
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 0,
                               'formatter' =>
                                    function($d, $row){
                                        if(isset($row['numProntuarioAntigo']))
                                            $d.= ' - '.$row['numProntuarioAntigo'];
                                        $d = '<a href="'.BASE_URL.'/anamnese/consultarFim/'.$row['cdnPaciente'].'">'.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Número
            $columns[] = array('db' => 'nomPaciente',
                               'dt' => 1,
                               'formatter' =>
                                    function($d, $row){
                                        if(isset($row['nomSobrenome']))
                                            $d = utf8_encode($d.' '.$row['nomSobrenome']);
                                        else
                                            $d = utf8_encode($d);
                                        $d = '<a href="'.BASE_URL.'/anamnese/consultarFim/'.$row['cdnPaciente'].'">
                                             '.$d.'</a>';
                                        return $d;
                                    }
                              );

            // Botões
            $columns[] = array('db' => 'cdnPaciente',
                               'dt' => 2,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '  <a href="'.BASE_URL.'/anamnese/consultarFim/'.$row['cdnPaciente'].'">
                                                    <button type="button" class="btn btn-success">
                                                        Visualizar
                                                    </button>
                                                </a>';
                                        return $d;
                                    });

            return $this->jsonFinalizar($table, $primaryKey, $columns, null, $extras);
        }

        /**
         * Método responsável por montar o json das tabelas de preço
         *
         * @return String - JSON das tabelas de preço
         *
        **/
        public function jsonTabelasPreco(){
            // DB table to use
            $table = 'tabelapreco';

            // Table's primary key
            $primaryKey = 'cdnTabelaPreco';

            $columns = array();

            // Nome
            $columns[] = array('db' => 'nomTabelaPreco',
                               'dt' => 0,
                               'formatter' =>
                                   function($d, $row){
                                       $d = utf8_encode($d);
                                       return utf8_encode($d);
                                   });

            // Botões
            $columns[] = array('db' => 'cdnTabelaPreco',
                               'dt' => 1,
                               'formatter' =>
                                    function($d, $row){
                                        $d = '  <a href="'.BASE_URL.'/tabelaPreco/consultarFim/'.$row['cdnTabelaPreco'].'">
                                                    <button type="button" class="btn btn-success">
                                                        Visualizar
                                                    </button>
                                                </a>';
                                        return $d;
                                    });

            return $this->jsonFinalizar($table, $primaryKey, $columns);
        }

        public function jsonOrcamentos($tipo){
            // DB table to use
            $table = 'orcamento';

            // Table's primary key
            $primaryKey = 'cdnOrcamento';

            $columns = array();

            $extras = array();

            $extras[] = 'p.nomPaciente';
            $extras[] = 'p.cdnPaciente';
            if(ControleCampo::campoExiste('nomSobrenome'))
                $extras[] = 'p.nomSobrenome';

            // Id
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 0
            );


            $this->tipo = $tipo;

            // Nome
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 1,
                'formatter' =>
                    function($d, $row){
                        $d = $row['nomPaciente'];
                        if(isset($row['nomSobrenome']))
                            $d = utf8_encode($d.' '.$row['nomSobrenome']);
                        else
                            $d = utf8_encode($d);
                        return $d;
                    }
            );

            // Prontuário
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 2,
                'formatter' =>
                    function($d, $row){
                        $d = $row['cdnPaciente'];
                        return $d;
                    }
            );

            $join = 'inner join paciente p on orcamento.cdnPaciente = p.cdnPaciente';

            return $this->jsonFinalizar($table, $primaryKey, $columns, 'indAprovado = 1', $extras, $join);
        }

        public function jsonProcedimentos($cdnOrcamento){

            $modMain = new ModeloMain(true);
            $GLOBALS['modMain'] = $modMain;

            // DB table to use
            $table = 'orcamento_procedimento';

            // Table's primary key
            $primaryKey = 'cdnOrcamento';

            $columns = array();

            $extras = array();

            $extras[] = 'a.nomAreaAtuacao';
            $extras[] = 'p.nomProcedimento';
            $extras[] = 'p.cdnProcedimento';
            $extras[] = 'a.cdnAreaAtuacao';
            $extras[] = 'orcamento_procedimento.cdnProcedimento';
            $extras[] = '(orcamento_procedimento.numQuantidade - orcamento_procedimento.numQuantidadeRealizado) as soma';
            // Id
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 0,
                'formatter' =>
                    function($d, $row){
                        $d = $row['cdnProcedimento'];
                        return $d;
                    }
            );

            // Procedimento
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 1,
                'formatter' =>
                    function($d, $row){
                        $d = $row['nomProcedimento'];
                        $d = utf8_encode($d);
                        return $d;
                    }
            );

            // Área de atuação
            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 2,
                'formatter' =>
                    function($d, $row){
                        $d = $row['nomAreaAtuacao'].' - '.$row['cdnAreaAtuacao'];
                        $d = utf8_encode($d);
                        return $d;
                    }
            );

            // Dentista
            $columns[] = array(
                'db' => 'cdnDentista',
                'dt' => 3,
                'formatter' =>
                    function($d, $row){
                        $modMain = new ModeloMain(true);
                        $arrUsuario = $modMain->getUsuario($d);
                        $nomUsuario = utf8_encode($arrUsuario['nomUsuario']);
                        $d = $nomUsuario.' - '.$arrUsuario['cdnUsuario'];
                        return $d;
                    }
            );

            // Quantidade
            $columns[] = array(
                'db' => 'numQuantidade',
                'dt' => 4
            );

            $columns[] = array(
                'db' => 'cdnOrcamento',
                'dt' => 5,
                'formatter' =>
                    function($d, $row){
                        $d = $row['soma'];
                        return $d;
                    }
            );

            $join = 'inner join procedimento p on p.cdnProcedimento = orcamento_procedimento.cdnProcedimento ';
            $join .= 'inner join areaatuacao a on a.cdnAreaAtuacao = orcamento_procedimento.cdnAreaAtuacao';

            $where = 'cdnOrcamento = '.$cdnOrcamento.' AND numQuantidade > numQuantidadeRealizado';

            return $this->jsonFinalizar($table, $primaryKey, $columns, $where, $extras, $join);
        }
    }
