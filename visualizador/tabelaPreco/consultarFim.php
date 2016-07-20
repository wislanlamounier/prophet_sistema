            <div class="col-md-12">
                <a class="pull-right" href="<?php echo BASE_URL; ?>/tabelaPreco/cadastrar/">
                    <button class="btn btn-success">
                        Cadastrar nova tabela
                    </button>
                </a>
            </div>
			<div class="col-md-12 form-group">
				<label for="nomTabelaPreco" class="control-label">Nome da tabela de preço</label>
				<input disabled type="text" name="nomTabelaPreco" class="form-control" value="<?php echo $dtoTabelaPreco->getNomTabelaPreco(); ?>">
			</div>
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
					$arrCond = array(
						'cdnTabelaPreco' => $dtoTabelaPreco->getCdnTabelaPreco(),
						'conscond1' => 'AND',
						'cdnProcedimento' => $dtoProcedimento->getCdnProcedimento()
					);

					$arrPreco = $modProcedimento->consultar('tabelapreco_procedimento', '*', $arrCond);
                    if(count($arrPreco) > 0)
                        $arrPreco = $arrPreco[0];
                    else
                        continue;
					$arrPreco['valPreco'] = $dtoProcedimento->transformacaoMonetario($arrPreco['valPreco']);
			?>
				<div class="col-md-4 form-group">
					<label for="<?php echo $dtoProcedimento->getCdnProcedimento(); ?>" class="control-label"><?php echo $dtoProcedimento->getNomProcedimento(); ?></label>
					<input disabled type="text" class="form-control mask-money" name="<?php echo $arrProcedimento['cdnProcedimento']; ?>" value="R$<?php echo $arrPreco['valPreco']; ?>">
				</div>
			<?php
				}
			?>
				<div class="row">
                    <div class="col-sm-12">
                        <hr>
                    </div>
					<div class="col-sm-4 col-sm-offset-2">
						<a href="<?php echo BASE_URL; ?>/tabelaPreco/atualizar/<?php echo $dtoTabelaPreco->getCdnTabelaPreco(); ?>">
							<button class="btn btn-lg btn-primary btn-block">
								Editar
							</button>
						</a>
					</div>
                    <div class="col-sm-4">
                        <a target="_blank" href="<?php echo BASE_URL; ?>/tabelaPreco/imprimir/<?php echo $dtoTabelaPreco->getCdnTabelaPreco(); ?>">
                            <button class="btn btn-lg btn-primary btn-block">
                                Imprimir
                            </button>
                        </a>
                    </div>
				</div>