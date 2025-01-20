<div class="container is-fluid mb-6">
	<h1 class="title">Codigo</h1>
	<h2 class="subtitle"><i class="bi bi-upc"></i> &nbsp; Generar Nuevo codigo de barra</h2>
</div>

<div class="container is-fluid">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/codeAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_code" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre del codigo o articulo <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="nombreCode"  maxlength="100" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded"><i class="fas fa-paint-roller"></i> &nbsp; Limpiar</button>
			<button type="submit" class="button is-info is-rounded"><i class="far fa-save"></i> &nbsp; Guardar Codigo</button>
		</p>
	</form>
</div>