<?php

	/**
	 * Classe utilizada para importar um arquivo Excel
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-11-04
	 *
	**/
	class Importacao {
		private $PHPExcel;
		private $objExcel;
		private $diretorio;
		private $ultimaLetra;

		/**
		 * Método construtor.
		 *
		 * @param String $dir - diretório do arquivo a ser importado (opcional)
		 * @param String $ultimaLetra - última coluna que os dados estão posicionados.
		 * @return Boolean - true se importou com sucesso, false se não
		 *
		**/
		public function __construct($dir = false, $ultimaLetra){
			$this->PHPExcel = new PHPExcel();
			$this->ultimaLetra = $ultimaLetra;

			if($dir != false)
				return $this->importar($dir);

			return true;
		}

		/**
		 * Método destrutor
		 *
		 * @return Void.
		 *
		**/
		public function __destruct(){
			if(!is_null($this->diretorio))
				unlink($this->diretorio);
		}

		/**
		 * Método utilizado para importar um arquivo excel
		 *
		 * @param String $dir - diretório do arquivo a ser importado
		 * @return Boolean - true se importou com sucesso, false se não
		 *
		**/
		public function importar($dir = false){
			if($dir != false)
				$this->diretorio = $dir;
			else
				$dir = $this->diretorio;


			if(!file_exists($dir))
				return false;


			$this->objExcel = PHPExcel_IOFactory::load($dir);
			return true;
		}

		/**
		 * Método utilizado para varrer um arquivo excel e disponibilizar um array
		 *
		 * @return Array - array das células
		 *
		**/
		public function getArray(){
			$first = false;
			foreach ($this->objExcel->getWorksheetIterator() as $worksheet) {
				if(!$first){
					$first = true;
				    $worksheetTitle     = $worksheet->getTitle();
				    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
				    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				    $highestColumnIndex = ord(strtoupper($this->ultimaLetra)) - 64;
				    // echo $this->ultimaLetra;
				    $nrColumns = ord($highestColumn) - 64;
				    // echo "<br>The worksheet ".$worksheetTitle." has ";
				    // echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
				    // echo ' and ' . $highestRow . ' row.';
				    // echo '<br>Data: <table border="1"><tr>';
				    $array = array();
				    for ($row = 3; $row <= $highestRow; ++ $row) {
				        if(!isset($array[$row]))
				        	$array[$row] = array();
				        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
				            $cell = $worksheet->getCellByColumnAndRow($col, $row);
				            $val = $cell->getValue();
				        	$array[$row][$col] = $val;
				            // $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
				            // echo '<td>' . $val . '<br>(Type ' . $dataType . ')</td>';
				        }
				        // echo '</tr>';
				    }
				    // echo '</table>';
				}
			}
			return $array;
		}

		/**
		 * Método responsável por copiar o arquivo para a pasta "arquivos_importacao/upload"
		 *
		 * @return Boolean - true se sucesso, false se não.
		 *
		**/
		public function upload(){
			if(!isset($_FILES['fileExcel']))
				return false;

			$arquivo = new Arquivo('arquivos_importacao/upload', 'fileExcel');
			$this->diretorio = $arquivo->finalizar();
			$this->importar();
			return true;
		}

		/**
		 * Método responsável por cadastrar no banco uma linha da importação
		 *
		 * @param Array $colunas - colunas da tabela
		 * @param String $dtoStr - nome do DTO
		 * @param String $modStr - nome do modelo
		 * @param String $nomFuncao - funcao de cadastro do modelo
		 * @return Mixed - Array se falhou, booleano (true) se sucesso
		 *
		**/
		public function finalizar($colunas, $dtoStr, $modStr, $nomFuncao){
			$array = $this->getArray();
			$erros = array();
			eval('$modelo = new '.$modStr.'();');
			foreach($array as $linha=>$dados){
				eval('$dto = new '.$dtoStr.'();');
				for($i = 0; $i < count($colunas); $i++){
					$funcao = 'set'.ucfirst($colunas[$i]);
					$dto->{$funcao}($dados[$i]);
				}
				if(!$modelo->{$nomFuncao}($dto))
					$erros[] = $linha;
			}
		}

	}