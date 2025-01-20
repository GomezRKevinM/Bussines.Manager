<head>
    <style>
        .f_search{
            width: auto;
        }
        .l_date{
            margin: 10px;
        }
        span{
            color:#3f51b5;
            margin: 48px;
        }
    </style>
</head>
<div class="container is-fluid mb-6">
    <h1 class="title">Cotizar</h1>
    <h2 class="subtitle"><i class="bi bi-calendar-event"></i> &nbsp; Buscar cotizaciones por Fecha</h2>
</div>
<div class="container is-fluid">
    <?php
    
        use app\controllers\cotizarController;
        $insVenta = new cotizarController();

        if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
    ?>
    <div class="columns">
        <div class="column">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="buscar_fecha">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <div>
                    <p><span>Desde:</span><span>Hasta:</span></p>
                </div>
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="date" name="txt_buscador" value="" required >
                    </p>
                    <input class="input is-rounded" type="date" name="fecha_finish" value="<?php echo date("Y-m-d"); ?>" requiered>
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
                <p><i class="fas fa-search fa-fw"></i> &nbsp; Estas buscando por fecha: <strong>“<?php echo $_SESSION[$url[0]]; ?> hasta <?php echo $_SESSION['fechaF'] ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded"><i class="fas fa-trash-restore"></i> &nbsp; Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
            
            echo $insVenta->listarVentaDateControlador($url[1],15,$url[0],$_SESSION[$url[0]],$_SESSION['fechaF']);

            include "./app/views/inc/print_invoice_script.php";
        }
    ?>
</div>