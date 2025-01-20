<head>
    <style>
        .f_search{
            width: auto;
        }
        .l_date{
            margin: 10px;
        }
        .span{
            color:#3f51b5;
            margin: 48px;
        }
    </style>
</head>
<div class="container is-fluid mb-6">
    <h1 class="title">Busqueda</h1>
    <h2 class="subtitle"><i class="bi bi-calendar-check"></i></i> &nbsp; Buscar  por Fecha</h2>
</div>
<div class="container is-fluid">
    <?php
    
        use app\controllers\saleController;
        $insVenta = new saleController();
        use app\controllers\cotizarController;
        $insCotizacion = new cotizarController;
        use app\controllers\serviceController;
        $insService = new serviceController;
        use app\controllers\buyController;
        $insCompra = new buyController;

        if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
    ?>
    <div class="columns">
        <div class="column">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="buscar_all">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <div>
                    <p><span class="span">Desde:</span><span class="span">Hasta:</span></p>
                </div>
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="date" name="txt_buscador" value="" required >
                    </p>
                    <input class="input is-rounded" type="date" name="fecha_finish" value="<?php echo date("Y-m-d"); ?>" requiered>
                    <p class="control is-expanded">
                    <div class="select mr-3">
					  <select name="table" id="table" required>
				    	<option value="0">Selecciona el campo</option>
				    	<option value="Ventas">Ventas</option>
				    	<option value="Servicios">Servicios Realizados</option>
				    	<option value="Cotizaciones">Cotizaciones</option>
				    	<option value="Compras">Compras</option>
				  	</select>
					</div>
                        <button class="button is-info" type="submit"><i class="bi bi-search"></i>&nbsp; Buscar</button>
                    </p>
                </div>
            </form>
    </div>
    <?php }else{ ?>
        <div class="columns">
                    <div class="column" id="date">
                        <form class="has-text-centered mt-6 mb-6 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <p><i class="fas fa-search fa-fw"></i> &nbsp; Estas buscando <strong><?php echo $_SESSION['campo'] ?></strong> por fecha: <strong>“<?php echo $_SESSION[$url[0]]; ?></strong> hasta <strong><?php echo $_SESSION["fechaF"] ?>”</strong></p>
                            <br>
                            <button type="submit" class="button is-danger is-rounded"><i class="fas fa-trash-restore"></i> &nbsp; Eliminar busqueda</button>
                        </form>
                    </div>
                </div>
    <?php
    if($_SESSION['campo']==="0"){
        echo "";
    }else{
        switch ($_SESSION['campo']) {
            case 'Ventas':
                echo $insVenta->listarVentaDateControlador($url[1],15,$url[0],$_SESSION[$url[0]],$_SESSION['fechaF']);
                break;
            case 'Servicios':
                echo $insService->listarVentaDateControlador($url[1],15,$url[0],$_SESSION[$url[0]],$_SESSION['fechaF']);
                break;
            case 'Cotizaciones':
                echo $insCotizacion->listarVentaDateControlador($url[1],15,$url[0],$_SESSION[$url[0]],$_SESSION['fechaF']);
                break;
            case 'Compras':
                echo $insCompra->listarCompraDateControlador($url[1],15,$url[0],$_SESSION[$url[0]],$_SESSION['fechaF']);
                break;
        };
    };

            include "./app/views/inc/print_invoice_script.php";
        }
    ?>
</div>