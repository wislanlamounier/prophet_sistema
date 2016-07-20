                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content p-md">
                            	<div class="row">
                            		<div class="col-md-12">
                            			Selecione os campos que irão ser impressos no questionário anamnese
                            		</div>
                            	</div>
                          		<div class="row" style="font-size: 22px;">
                          			<form action="<?php echo BASE_URL; ?>/questionario/visualizacaoAtualizar" method="post">
			                            <ul>
			                            	<li> Nome (obrigatório) </li><br>
			                            	<li> Telefone (obrigatório) </li><br>
			                            	<?php
			                            		if(ControleCampo::campoExiste('codCPf'))
			                            			echo '<li> CPF (obrigatório) </li><br>';
			                            		if(ControleCampo::campoExiste('codCnpj'))
			                            			echo '<li> CNPJ (obrigatório) </li><br>';
			                            		if(ControleCampo::campoExiste('codCpfCnpj'))
			                            			echo '<li> CPF/CNPJ (obrigatório) </li><br>';
			                            		if(ControleCampo::campoExiste('datNascimento'))
			                            			echo '<li> Data de Nascimento (obrigatório) </li><br>';


			                            		foreach($arrCampos as $arrCampo){
			                            			if($modelo->checaExiste('anamnese_campo', 'cdnCampo', $arrCampo['cdnCampo']))
			                            				$checked = 'checked ';
			                            			else
			                            				$checked = '';
			                            	?>
			                            	<li>
			                            		<input <?php echo $checked; ?> type="checkbox" name="<?php echo $arrCampo['cdnCampo']; ?>">
			                            		<?php echo $arrCampo['desLabel']; ?>
			                            	</li>
			                            	<?php
			                            		}
			                            	?>
			                           	</ul>
					                    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		                                    <button type="submit" class="btn btn-block btn-lg btn-success">
		                                        Editar
		                                    </button>
		                                </div>
			                        </form>
	                            </div>
                            </div>
                        </div>
                    </div>
