<div class="container is-fluid mb-6">
	<h1 class="title">Presentación</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar presentación</h2>
</div>

<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$id=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","presentacion","presentacion_id",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['presentacion_nombre']; ?></h2>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/presentacionAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_presentacion" value="actualizar">
		<input type="hidden" name="presentacion_id" value="<?php echo $datos['presentacion_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="presentacion_nombre" value="<?php echo $datos['presentacion_nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required >
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