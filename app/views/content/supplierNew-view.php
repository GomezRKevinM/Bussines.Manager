<div class="container is-fluid mb-6">
	<h1 class="title">Proveedores</h1>
	<h2 class="subtitle"><i class="fas fa-male fa-fw"></i> &nbsp; Nuevo Proveedor</h2>
</div>

<div class="container is-fluid">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/supplierAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_supplier" value="registrar">

		<div class="columns">

		  	<div class="column">

		    	<div class="control">
					<label>Nombre del provedor <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="240" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Representante <strong>(opcional)</strong></label>
				  	<input class="input" type="text" name="supplier_representante" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="60" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Estado, provincia o departamento <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_provincia" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ciudad o pueblo <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_ciudad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Calle o dirección de provedor <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_direccion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Teléfono</label>
				  	<input class="input" type="text" name="supplier_telefono" pattern="[0-9()+]{8,20}" maxlength="20" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="supplier_email" maxlength="70" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded"><i class="fas fa-paint-roller"></i> &nbsp; Limpiar</button>
			<button type="submit" class="button is-info is-rounded"><i class="far fa-save"></i> &nbsp; Guardar</button>
		</p>
		<p class="has-text-centered pt-6">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
	</form>
</div>