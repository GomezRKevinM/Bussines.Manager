<div class="container is-fluid mb-6">
	<h1 class="title">Servicio</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar servicio</h2>
</div>

<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$id=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","servicio","servicio_id",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>
	
	<div class="columns is-flex is-justify-content-center">
    	<figure class="full-width mb-3" style="max-width: 170px;">
    		<?php
    			if(is_file("./app/views/servicios/".$datos['servicio_foto'])){
    				echo '<img class="img-responsive" src="'.APP_URL.'app/views/servicios/'.$datos['servicio_foto'].'">';
    			}else{
    				echo '<img class="img-responsive" src="'.APP_URL.'app/views/servicios/default.jpg">';
    			}
    		?>
		</figure>
  	</div>

	<h2 class="title has-text-centered"><?php echo $datos['servicio_nombre']; ?></h2>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/saddAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_producto" value="actualizar">
		<input type="hidden" name="producto_id" value="<?php echo $datos['servicio_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="producto_codigo" value="<?php echo $datos['servicio_codigo']; ?>" pattern="[a-zA-Z0-9- ]{1,77}" maxlength="77" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="producto_nombre" value="<?php echo $datos['servicio_nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio de venta <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="producto_precio_venta" value="<?php echo $datos['servicio_precio']; ?>" pattern="[0-9.]{1,25}" maxlength="25" value="0.00" required >
				</div>
		  	</div>
		  	<div class="column">
				<label>Categoría <?php echo CAMPO_OBLIGATORIO; ?></label><br>
		    	<div class="select">
				  	<select name="producto_categoria" >
				    	<?php
                            $datos_categorias=$insLogin->seleccionarDatos("Normal","categoria WHERE company_id=".$_SESSION['company'],"*",0);

                            $cc=1;
                            while($campos_categoria=$datos_categorias->fetch()){
                            	if($campos_categoria['categoria_id']==$datos['categoria_id']){
                            		echo '<option value="'.$campos_categoria['categoria_id'].'" selected="" >'.$cc.' - '.$campos_categoria['categoria_nombre'].' (Actual)</option>';
                            	}else{
                                	echo '<option value="'.$campos_categoria['categoria_id'].'">'.$cc.' - '.$campos_categoria['categoria_nombre'].'</option>';
                            	}
                                $cc++;
                            }
                        ?>
				  	</select>
				</div>
		</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar</button>
		</p>
		<p class="has-text-centered pt-6">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
	</form>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>