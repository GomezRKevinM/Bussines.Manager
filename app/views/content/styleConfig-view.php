<div class="container is-fluid mb-6">
	<h1 class="title">Style Config</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar tu diseño</h2>
</div>

<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$id=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","diseño","diseño_id",1);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();


	?>
	
	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/diseñoAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_diseño" value="actualizar">
		<input type="hidden" name="diseño_id" value="<?php echo $datos['diseño_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Color principal<?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="color" name="navBG" value="<?php echo $datos['nav_color']; ?>" pattern="[a-zA-Z0-9- ]{1,77}" maxlength="77" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Color de titulos<?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="color" name="tituloColor" value="<?php echo $datos['titulo_color']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>

		</div>
		</div><br>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar</button>
		</p>
	</form>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>