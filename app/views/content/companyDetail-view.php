<div class="container is-fluid mb-6">
	<h1 class="title">Empresas</h1>
	<h2 class="subtitle"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Información de empresa</h2>
</div>

<div class="container is-fluid">
	<?php

use app\controllers\userController;

$insUsuario = new userController();
	
		include "./app/views/inc/btn_back.php";

		$code=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","empresa","empresa_id",$code);

		if($datos->rowCount()==1){
			$datos_company=$datos->fetch();
	?>
    <div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    			if(is_file("./app/views/fotos/".$_SESSION['foto'])){
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$datos_company['logo'].'">';
    			}else{
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/logo.png">';
    			}
    		?>
		</figure>
  	</div>
      <h2 class="title has-text-centered">Datos de la empresa <?php echo " (ID: ".$code.") "; ?><a href="<?php echo APP_URL ?>companyUpdate/<?php echo $datos_company['empresa_id']?>/">Actualizar</a></h2>

	<div class="columns pb-6 pt-6">
		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">NOMBRE</div>
				<span class="has-text-link"><?php echo $datos_company['empresa_nombre'];?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">NIT</div>
				<span class="has-text-link"><?php echo $datos_company['empresa_nit']; ?></span>
			</div>

            <div class="full-width sale-details text-condensedLight">
                <div class="has-text-weight-bold has-text-right has-text-black">DIRECCIÓN</div>
                <span class="has-text-link has-text-centered"><?php echo $datos_company['empresa_direccion']; ?></span>
            </div>

		</div>


		<div class="column">

            <div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">TELEFONO</div>
				<span class="has-text-link"><?php echo $datos_company['empresa_telefono']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">CORREO</div>
				<span class="has-text-link"><?php echo $datos_company['empresa_email']; ?></span>
			</div>

		</div>

	</div>  

    <div class="container is-fluid">
        <?php echo $insUsuario->listarUsuarioCompanyControlador(0,5,"http://localhost/bussines.manager/companyDetail/",$code)?>
    </div>

	<?php }?>
</div>