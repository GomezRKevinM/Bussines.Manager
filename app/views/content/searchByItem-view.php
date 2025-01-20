<head>
    <style>
        .f_search{
            width: auto;
        }
        .l_date{
            margin: 10px;
        }
    </style>
</head>
<div class="container is-fluid mb-6">
    <h1 class="title">Ventas</h1>
    <h2 class="subtitle"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar ventas por producto</h2>
</div>
<div class="container is-fluid">
    <?php
    
        use app\controllers\saleController;
        $insVenta = new saleController();

        if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
    ?>
    <div class="columns">
        <div class="column">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="buscar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                    <div class="select">
					  	<select name="txt_buscador">
					    	<option value="" selected="" >Seleccione un Producto</option>
	                        <?php
	                        	 $datos_categorias=$insLogin->seleccionarDatos("Normal","producto","*",0);

								 $cc=1;
								 while($campos_categoria=$datos_categorias->fetch()){
									 echo '<option value="'.$campos_categoria['producto_id'].'">'.$cc.' - '.$campos_categoria['producto_nombre'].'</option>';
									 $cc++;
								 }
	                        ?>
					  	</select>
					</div>
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
    </div>
            </div>
    <?php }else{ ?>
    <div class="columns">
        <div class="column" id="date">
            <form class="has-text-centered mt-6 mb-6 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="eliminar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <p><i class="fas fa-search fa-fw"></i> &nbsp; Estas buscando por código <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded"><i class="fas fa-trash-restore"></i> &nbsp; Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
            echo $insVenta->listarByItemControlador($url[1],15,$url[0],$_SESSION[$url[0]]);

            include "./app/views/inc/print_invoice_script.php";
        }
    ?>
</div>