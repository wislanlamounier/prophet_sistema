<?php

	/**
	 * Classe utilizada para importar um arquivo Excel de fornecedores
	 *
	 * @author Rafael de Paula - <rafael@bentonet.com.br>
	 * @version 1.0.0 - 2015-11-04
	 *
	**/
	class ImportacaoFornecedor extends Importacao{


		/**
		 * Método utilizado para finalizar a importacao dos fornecedores
		 *
		 * @return Array - linhas que houveram falhas na importação
		 *
		**/
		public function importacaoFornecedorFim(){
			$colunas = array(
				'nomFornecedor',
				'numTelefone1',
				'numTelefone2',
				'numWhatsapp',
				'nomFacebook',
				'strEndereco',
				'nomRepresentante',
				'numRepresentanteTelefone',
				'strRepresentanteEmail',
				'desFornecedor'
			);
			$dtoStr = 'DTOFornecedor';
			$modStr = 'ModeloFornecedor';
			$nomFuncao = 'fornecedorCadastrarFim';

			$erros = $this->finalizar($colunas, $dtoStr, $modStr, $nomFuncao);

		}
	}