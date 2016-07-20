				<?php
					if(isset($erros)){
				?>
				<div class="col-md-12 alert alert-error text-justify">
					Me parece que a importação não ocorreu com 100% de sucesso! As seguintes linhas de sua planilha estão preenchidas
					incorretamente e não puderam ser importadas:
					<ul>
						<?php 
							foreach($erros as $linha){
								echo '<li>'.$linha.'</li>'; 
							} 
						?>
					</ul>
					As linhas restantes obtiveram sucesso no cadastro. Por favor, verifique estas linhas.
					<b>ATENÇÃO:</b> ao realizar a importação do arquivo, certifique-se de deletar todas as linhas que já obtiveram
					sucesso no cadastro para evitar a duplicidade de dados.
				</div>
				<?php
					}
				?>


				<div class="col-md-12">

					<div class="col-md-12 page-header">
						<h3>Instruções</h3>
					</div>

					<div class="col-md-12 text-justify">
						Selecione o arquivo correspondente aos fornecedores, aos moldes projetados para a importação
						no sistema Prophet. <b>Caso você não possua este arquivo, por favor, baixe-o clicando aqui.</b>
					</div>

				</div>

				<br>

				<div class="col-md-12 alert alert-warning text-center">
					<b>ATENÇÃO:</b> arquivos que não estiverem dentro dos padrões exigidos, podem sofrer
					erros na importação.
				</div>

				<div class="col-md-12">

					<form action="<?php echo BASE_URL; ?>/importacao/fornecedorFim" method="post" enctype="multipart/form-data">

						<div class="col-md-12 form-group">
							<label for="fileExcel" class="control-label">Arquivo Excel:</label>
							<input type="file" name="fileExcel" class="form-control">
						</div>

						<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
							<button type="submit" class="btn btn-lg btn-block btn-primary">
								Importar
							</button>
						</div>
					</form>

				</div>