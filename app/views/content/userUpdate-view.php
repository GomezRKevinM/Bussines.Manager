<head>
	<style>
		.iconPass{
			position: relative;
			left: 90%;
			top: -29px;
			z-index: 11;
		}
		.a_img>i{
			width: 100%;
			height: 100%;
			font-size: 40px;
			color:#333;
			position: relative;
			bottom: 99%;
			padding: 40px;
			border-radius: 50%;
			opacity: 0;
			border: none;
		}

		.a_img>img{
			transition: all 300ms ease-in-out;
		}

		.a_img:hover>img{
			filter: blur(1px);
		}
		.a_img:hover>i{
			opacity: 1;
			background-color: #4747473c;
			color: #444;
		}

	</style>

</head>
<div class="container is-fluid mb-6">
	<?php 

		use app\controllers\companyController;

		$insCompany = new companyController();

		$id=$insLogin->limpiarCadena($url[1]);

		if($id==$_SESSION['id']){ 
	?>
	<h1 class="title">Mi cuenta</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar cuenta</h2>
	<?php }else{ ?>
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar usuario</h2>
	<?php } ?>
</div>
<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","usuario","usuario_id",$id);
		

		if($datos->rowCount()==1){
			$datos=$datos->fetch();

			
	?>

	<div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    			if(is_file("./app/views/fotos/".$datos['usuario_foto'])){
    				echo '<a class="a_img" title="Cambiar logo" href="'.APP_URL.'userPhoto/'.$datos['usuario_id'].'/"><img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$datos['usuario_foto'].'"><i class="fas fa-edit"></i></a>';
    			}else{
    				echo '<a class="a_img" title="Cambiar logo" href="'.APP_URL.'userPhoto/'.$datos['usuario_id'].'/"><img class="is-rounded" src="'.APP_URL.'app/views/fotos/default.png"><i class="fas fa-edit"></i></a>';
    			}
    		?>
		</figure>
  	</div>

	<h2 class="title has-text-centered"><?php echo $datos['usuario_nombre']." ".$datos['usuario_apellido']; ?></h2>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_usuario" value="actualizar">
		<input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $datos['usuario_nombre']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $datos['usuario_apellido']; ?>" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" value="<?php echo $datos['usuario_usuario']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['usuario_email']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		  		<label>Caja de ventas <?php echo CAMPO_OBLIGATORIO; ?></label><br>
				<div class="select">
				  	<select name="usuario_caja">
                        <?php
                            $datos_cajas=$insLogin->seleccionarDatos("Normal","caja","*",0);

                            while($campos_caja=$datos_cajas->fetch()){
                            	if($campos_caja['caja_id']==$datos['caja_id']){
                            		echo '<option value="'.$campos_caja['caja_id'].'" selected="" >Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].' (Actual)</option>';
                            	}else{
                                	echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].'</option>';
                            	}
                            }
                        ?>
				  	</select>
				</div>
		  	</div>
			<?php if($_SESSION['rol']=="admin" || $_SESSION['rol']=="Administrador"){?>
			  <div class="column">
				<label>Tipo de Usuario <?php echo CAMPO_OBLIGATORIO; ?></label><br>
					<div class="select">
						<select name="usuario_rol">
							<option value="" selected="" ><?php echo $datos['usuario_rol'] ?></option>
							<option value="Admin">Admin</option>
							<option value="Empleado">Empleado</option>
							<option value="Cajero">Cajero</option>
						</select>
					</div>
				</div>
				<div class="column">
				<label for="company">Empresa <?php echo CAMPO_OBLIGATORIO.$insCompany->seleccionarCompany("Unico",$datos['company_id']);?></label><br>
				<div class="select">
					
					<select name="company_id" id="company">
					<?php if($datos['company_id']==0){
						echo $insCompany->seleccionarCompany("*",$datos['company_id']);
						} else{
							echo $insCompany->seleccionarCompany("Unico",$datos['company_id']);
						}?>
					</select>
				</div>
			</div>
				<?php }else{} ?>
		</div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nueva clave</label>
				  	<input id="login_clave" class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
					  <i id="ver" class="bi bi-eye iconPass"></i><i id="verHover" class="bi bi-eye-fill iconPass"></i><i id="hidden" class="bi bi-eye-slash iconPass"></i><i id="hiddenHover" class="bi bi-eye-slash-fill iconPass"></i>
		  	</div></div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir nueva clave</label>
				  	<input id="login_clave2" class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
					  <i id="ver2" class="bi bi-eye iconPass"></i><i id="verHover2" class="bi bi-eye-fill iconPass"></i><i id="hidden2" class="bi bi-eye-slash iconPass"></i><i id="hiddenHover2" class="bi bi-eye-slash-fill iconPass"></i>
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
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
<script src="<?php echo APP_URL ?>app/views/js/update.js"></script>