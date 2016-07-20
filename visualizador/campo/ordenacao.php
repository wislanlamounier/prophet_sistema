                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content p-md">
                          		<div class="row" style="font-size: 22px;">
		                            <ul class="sortable">
		                            	<?php
		                            		foreach($arrCamposPais as $arrCampo){
		                            	?>
		                            	<li codSequencial="<?php echo $arrCampo['codSequencial']; ?>" 
		                            	    cdnCampo     ="<?php echo $arrCampo['cdnCampo']; ?>"
		                            	    class		 ="campoPai">
	                            	    	<?php 
	                            	    		echo $arrCampo['desLabel']; 
	                            	    		if(isset($arrCamposFilhos[$arrCampo['cdnCampo']])){
	                            	    	?>
	                            	    		<ul class="sortable">
	                            	    			<?php
	                            	    				$arrFilho = $arrCamposFilhos[$arrCampo['cdnCampo']];
	                            	    				foreach($arrFilho as $arrCampoFilho){
	                            	    			?>
	                            	    			<li codSequencial="<?php echo $arrCampoFilho[1]; ?>"
	                            	    				cdnCampo     ="<?php echo $arrCampoFilho[0]; ?>"
	                            	    				cdnPai		 ="<?php echo $arrCampo['cdnCampo']; ?>">
	                            	    				<?php echo $arrCampoFilho[2]; ?>
	                            	    			</li>
	                            	    			<?php
	                            	    				}
	                            	    			?>
	                            	    		</ul>
                            	    		<?php
                            	    			}
                            	    		?>
		                            	</li>
		                            	<?php
		                            		}
		                            	?>
		                           	</ul>
	                            </div>
                            </div>
                        </div>
                    </div>
