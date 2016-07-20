			<div class="col-md-12">
				<form action="<?php echo BASE_URL; ?>/main/configuracoesFim" method="post">
                    
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="valJurosOrcamento" class="control-label">Taxa de juros para orçamento</label>
							<input class="form-control mask-percentage" type="text" name="valJurosOrcamento" value="<?php echo $dtoConfiguracoes->getValJurosOrcamento(); ?>%">
						</div>
					</div>

					<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<button type="submit" class="btn btn-block btn-lg btn-primary">
							Aplicar
						</button>
					</div>
				</form>
			</div>
