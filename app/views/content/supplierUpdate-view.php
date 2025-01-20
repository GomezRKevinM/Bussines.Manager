<div class="container is-fluid mb-6">
	<h1 class="title">Proveedores</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar Proveedor</h2>
</div>

<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$id=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","provedor","supplier_id",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['supplier_nombre']." REPRESENTANTE: ".$datos['supplier_representante']; ?></h2>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/supplierAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_supplier" value="actualizar">
		<input type="hidden" name="supplier_id" value="<?php echo $datos['supplier_id']; ?>">

		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre del Proveedor <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_nombre" value="<?php echo $datos['supplier_nombre']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Representante <strong>(opcional)</strong></label>
				  	<input class="input" type="text" name="supplier_representante" value="<?php echo $datos['supplier_representante']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Estado, provincia o departamento <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_provincia" value="<?php echo $datos['supplier_provincia']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ciudad o pueblo <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_ciudad" value="<?php echo $datos['supplier_ciudad']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" maxlength="30" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Calle o dirección de casa <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="supplier_direccion" value="<?php echo $datos['supplier_direccion']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Teléfono</label>
				  	<input class="input" type="text" name="supplier_telefono" value="<?php echo $datos['supplier_telefono']; ?>" pattern="[0-9()+]{8,20}" maxlength="20" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="supplier_email" value="<?php echo $datos['supplier_email']; ?>" maxlength="70" >
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