
			<div class="col-md-12">
				<h3>
		            <?php
		            	if(!isset($dtoClinica)){
		            		if(!isset($modClinica))
		            			$modClinica = new ModeloClinica(true);
		            		$dtoClinica = $modClinica->getClinica($_SESSION['cdnClinica']);
		            	}

		            	if($dtoClinica->getIndProntuario()){
		            ?>
		            <b>ATENÇÃO: </b>os prontuários estão disponíveis. Se deseja fechá-los,
		            <?php
		            	}else{
		            ?>
		            <b>ATENÇÃO: </b>os prontuários estão fechados. Se deseja abrí-los,
		            <?php
		            	}
		            ?>
		            <?php echo $this->link('clinica', 'disponivel', 'clique aqui.'); ?>
	            </h3>
	        </div>
