<head>
    <style>
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
	<h1 class="title">Empresa</h1>
	<h2 class="subtitle"><i class="fas fa-store-alt fa-fw"></i> &nbsp; Datos de empresa<?php echo $url[1];?></h2>
</div>

<div class="container is-fluid">

    <?php
    $id=$insLogin->limpiarCadena($url[1]);

    $datos=$insLogin->seleccionarDatos("Unico","empresa","empresa_id",$id);

    if($datos->rowCount()==1){
        $datos=$datos->fetch();

        include "./app/views/inc/btn_back.php";

    ?>
    <div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    			if(is_file("./app/views/fotos/".$_SESSION['foto'])){
    				echo '<a class="a_img" href="'.APP_URL.'companyUpdatePhoto/'.$datos['empresa_id'].'/"><img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$datos['logo'].'"><i class="fas fa-edit"></i></a>';
    			}else{
    				echo '<a class="a_img" href="'.APP_URL.'companyUpdatePhoto/'.$datos['empresa_id'].'/"><img class="is-rounded" src="'.APP_URL.'app/views/fotos/default.png"><i class="fas fa-edit"></i></a>';
    			}
    		?>
		</figure>
  	</div>
    <h2 class="title has-text-centered"><?php echo $datos['empresa_nombre']; ?></h2>

    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empresaAjax.php" method="POST" autocomplete="off" >

        <input type="hidden" name="modulo_empresa" value="actualizar">
        <input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre <?php echo CAMPO_OBLIGATORIO; ?></label>
                    <input class="input" type="text" name="empresa_nombre" value="<?php echo $datos['empresa_nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}" maxlength="85" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nit</label>
                    <input class="input" type="text" name="empresa_nit" value="<?php echo $datos['empresa_nit']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,- ]{4,85}" maxlength="85">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Teléfono</label>
                    <input class="input" type="text" name="empresa_telefono" value="<?php echo $datos['empresa_telefono']; ?>" pattern="[0-9()+]{8,20}" maxlength="20" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="empresa_email" value="<?php echo $datos['empresa_email']; ?>" maxlength="50" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input" type="text" name="empresa_direccion" value="<?php echo $datos['empresa_direccion']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" maxlength="97" >
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

</div>
<?php } ?>
