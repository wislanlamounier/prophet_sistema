			<div class="col-md-12">
				<form action="<?php echo BASE_URL; ?>/main/configuracoesFim" method="post">
                    
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="numMinutosAvisoPrevio" class="control-label">Minutos de aviso prévio de consulta</label>
							<input class="form-control" type="number" name="numMinutosAvisoPrevio" value="<?php echo $dtoConfiguracoes->getNumMinutosAvisoPrevio(); ?>">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<b>Boleto bancário</b>
						</div>
						<div class="col-md-12 form-group">
							<label for="banco" class="control-label">Banco</label>
							<select id="banco" class="form-control select2" name="banco">
								<option value="041">
									Banrisul
								</option>
							</select>
							<input type="hidden" id="bancoInicio" value="<?php echo $codBanco; ?>">
						</div>
					</div>
					<div id="formulario">

					</div>
					<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<button type="submit" class="btn btn-block btn-lg btn-primary">
							Aplicar
						</button>
					</div>
				</form>
			</div>
