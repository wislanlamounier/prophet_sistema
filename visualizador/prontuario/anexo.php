				<div class="col-md-12">
					<form action="<?php echo BASE_URL; ?>/prontuario/anexoFim/<?php echo $cdnPaciente; ?>" method="post" enctype="multipart/form-data">
						<div class="col-md-12 form-group">
							<label for="strDiretorio" class="control-label">Arquivo (imagens ou PDF)</label>
							<input type="file" name="strDiretorio" class="form-control">
						</div>
						<div class="col-md-12 form-group">
							<label for="desProntuarioAnexo" class="control-label">Descrição</label>
							<textarea name="desProntuarioAnexo" class="form-control"></textarea>
                        <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                            <button type="submit" class="btn btn-block btn-lg btn-primary">
                                Cadastrar
                            </button>
                        </div>
					</form>
				</div>