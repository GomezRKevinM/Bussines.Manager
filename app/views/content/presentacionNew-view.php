<div class="container is-fluid mb-6">
	<h1 class="title">Presentación</h1>
	<h2 class="subtitle"><i class="bi bi-file-diff-fill"></i> &nbsp; Nueva presentación</h2>
</div>

<div class="container is-fluid">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/presentacionAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_presentacion" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="presentacion_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded"><i class="fas fa-paint-roller"></i> &nbsp; Limpiar</button>
			<button type="submit" class="button is-info is-rounded"><i class="far fa-save"></i> &nbsp; Guardar</button>
		</p>
	</form>
</div>