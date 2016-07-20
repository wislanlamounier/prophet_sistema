			
			<div class="col-md-12 page-header">
				<h2>Copiar valores de tabela já existente</h2>
			</div>

			<form action="<?php echo BASE_URL; ?>/parceria/precoCopiar/<?php echo $cdnParceria; ?>" method="post">
				<div class="col-sm-4 col-sm-offset-2 form-group text-center">
					<label class="control-label">Copiar de parceria</label><br>
					<input name="copiar" type="radio" value="parceria" class="form-control copiar">
				</div>
				<div class="col-sm-4 form-group text-center">
					<label class="control-label">Copiar de tabelas</label><br>
					<input name="copiar" type="radio" value="tabela" class="form-control copiar">
				</div>
				<div id="divParcerias" class="col-md-12 form-group" style="display: none;">
					<label for="cdnParceria" class="control-label">Parceria</label>
					<select name="cdnParceria" class="form-control">
						<?php
							foreach($arrParcerias as $arrParceria){
						?>
						<option value="<?php echo $arrParceria['cdnParceria']; ?>"><?php echo $arrParceria['nomParceria']; ?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div id="divTabelas" class="col-md-12 form-group" style="display: none;">
					<label for="cdnTabelaPreco" class="control-label">Tabelas de preço</label>
					<select name="cdnTabelaPreco" class="form-control">
						<?php
							foreach($arrTabelasPreco as $arrTabelaPreco){
						?>
						<option value="<?php echo $arrTabelaPreco['cdnTabelaPreco']; ?>"><?php echo $arrTabelaPreco['nomTabelaPreco']; ?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<button type="submit" class="btn btn-lg btn-primary btn-block">
							Copiar
						</button>
					</div>
				</div>

			</form>

			<div class="col-md-12 page-header">
				<h2>Preços cadastrados para <?php echo $dtoParceria->getNomParceria(); ?></h2>
			</div>
			<form action="<?php echo BASE_URL; ?>/parceria/precoFim/<?php echo $cdnParceria; ?>" method="post">
				<?php
					$cdnAreaAtuacao = 0;
					foreach($arrProcedimentos as $arrProcedimento){
						if($cdnAreaAtuacao != $arrProcedimento['cdnAreaAtuacao']){
							$cdnAreaAtuacao = $arrProcedimento['cdnAreaAtuacao'];
							$dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($cdnAreaAtuacao);
				?>
					<div class="col-md-12 page-header">
						<h2><?php echo $dtoAreaAtuacao->getNomAreaAtuacao(); ?></h2>
					</div>
				<?php
						}
						$dtoProcedimento = $modProcedimento->getProcedimento($arrProcedimento['cdnProcedimento']);
						$arrCond = array('cdnProcedimento' => $dtoProcedimento->getCdnProcedimento(),
										 'conscond1' => 'AND',
										 'cdnParceria' => $cdnParceria);
						$arrPrecos = $modParceria->consultar('parceria_preco', '*', $arrCond);
						if(count($arrPrecos) > 0){
							$arrPreco = $arrPrecos[0];
                            $preco = 'R$'.$dtoProcedimento->transformacaoMonetario($arrPreco['valPreco']);
						}else{
                            $preco = '';
                        }

				?>
					<div class="col-md-4 form-group">
						<label for="<?php echo $dtoProcedimento->getCdnProcedimento(); ?>" class="control-label"><?php echo $dtoProcedimento->getNomProcedimento(); ?></label>
						<input value="<?php echo $preco; ?>" required type="text" class="form-control mask-money" name="<?php echo $arrProcedimento['cdnProcedimento']; ?>" >
					</div>
				<?php
					}
				?>
					<div class="row">
                        <div class="col-sm-12">
                            <hr>
                        </div>
						<div class="col-sm-4 col-md-offset-2">
							<button type="submit" class="btn btn-lg btn-primary btn-block">
								Cadastrar
							</button>
						</div>
                        <div class="col-sm-4 col-sm-offset-right-2">
                            <a target="_blank" href="<?php echo BASE_URL; ?>/tabelaPreco/imprimir/<?php echo $cdnParceria; ?>/1">
                                <button class="btn btn-lg btn-primary btn-block">
                                    Imprimir
                                </button>
                            </a>
                        </div>
					</div>
			</form>