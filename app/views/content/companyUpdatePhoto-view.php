<div class="container is-fluid mb-6">
	<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		if($id==$_SESSION['id']){ 
	?>
	<h1 class="title">Logo de Empresa</h1>
	<h2 class="subtitle"><i class="fas fa-camera"></i> &nbsp; Actualizar foto del logo</h2>
	<?php }else{ ?>
	<h1 class="title">Logo de Empresa</h1>
	<h2 class="subtitle"><i class="fas fa-camera"></i> &nbsp; Actualizar foto del logo</h2>
	<?php } ?>
</div>
<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","empresa","empresa_id",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered has-text-link"><?php echo $datos['empresa_nombre']?></h2>

	<div class="columns">
		<div class="column is-two-fifths">
			<h4 class="subtitle is-4 has-text-centered pb-6">Logo actual de la empresa</h4>
            <?php if(is_file("./app/views/fotos/".$datos['logo'])){ $logo=APP_URL."app/views/fotos/".$datos['logo']; ?>
			<figure class="image mb-6">
                <img id="preview" class="is-rounded is-photo" src="<?php echo $logo; ?>">
			</figure>
			
			<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" autocomplete="off" >

				<input type="hidden" name="modulo_empresa" value="eliminarFoto">
				<input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded"><i class="far fa-trash-alt"></i> &nbsp; Eliminar logo</button>
				</p>
			</form>
			<?php }else{  $logo=APP_URL."app/views/fotos/logo.png"; ?>
			<figure class="image mb-6">
			  	<img id="preview" class="is-rounded is-photo" src="<?php echo $logo; ?>">
			</figure>
			<?php }?>
		</div>


		<div class="column">
			<h4 class="subtitle is-4 has-text-centered pb-6">Actualizar Logo de la empresa</h4>
			<form class="mb-6 has-text-centered FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="modulo_empresa" value="actualizarFoto">
				<input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">
				
				<label>Logo de la empresa</label><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" id="file_logo" name="usuario_foto" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar Logo</button>
				</p>
			</form>
		</div>
	</div>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>
<script src="<?php echo APP_URL?>app/views/js/updatePhoto.js"></script>