<head>
<?php $datos=$insLogin->seleccionarDatos("Normal","diseño","*",1);
$navDefaultBG="#3f51b5";
if($datos->rowCount()==1){
    $datos=$datos->fetch(); ?>
	<style>
		.box{
			width: 170px;
			height: auto;
			cursor: pointer;
		}
		.box::after{
			content:"hol";
			width: 300px;
			font-size: 8px;
			background-color: transparent;
			border-radius: 15px;
			color:transparent;
			transition: all 500ms;
			position: relative;
			top: 29px;
			left:-12px;
			padding: 0 57%;
		}
		.box:hover::after{
			font-size: 6px;
			background-color: <?php echo $datos['nav_color'] ?>;
			top:15px;
		}
		.box:hover{
			scale: 115%;
			border:solid 5px solid <?php echo $datos['nav_color'] ?>;
			box-shadow: 1px 1px 15px 1px <?php echo $datos['nav_color'] ?>;
		}
		a{
			position: relative;
			width: 100%;
			height: 100%;
			z-index: 10;
			color: <?php echo $datos['nav_color'] ?>;
		}
	</style>
</head><?php }?>
<div class="container is-fluid pb-5 pt-5">
	<h1 class="title"><i class="bi bi-menu-app-fill"></i>&nbsp;Home</h1>
  	<div class="columns is-flex is-justify-content-center">
    	<figure class="image is-128x128">
    		<?php
    			if(is_file("./app/views/fotos/".$_SESSION['foto'])){
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
    			}else{
    				echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/default.png">';
    			}
    		?>
		</figure>
  	</div>
  	<div class="columns is-flex is-justify-content-center">
  		<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
  	</div>
</div>
<?php
	$total_cajas=$insLogin->seleccionarDatos("Normal","caja WHERE company_id=".$_SESSION['company'],"caja_id",0);

	$total_usuarios=$insLogin->seleccionarDatos("Normal","usuario WHERE company_id=".$_SESSION['company']." AND usuario_id!='".$_SESSION['id']."'","usuario_id",0);

	$total_clientes=$insLogin->seleccionarDatos("Normal","cliente WHERE company_id=".$_SESSION['company'],"cliente_id",0);

	$total_categorias=$insLogin->seleccionarDatos("Normal","categoria WHERE company_id=".$_SESSION['company'],"categoria_id",0);

	$total_productos=$insLogin->seleccionarDatos("Normal","producto WHERE company_id=".$_SESSION['company'],"producto_id",0);

	$total_ventas=$insLogin->seleccionarDatos("Normal","venta WHERE company_id=".$_SESSION['company'],"venta_id",0);

	$total_cotizaciones=$insLogin->seleccionarDatos("Normal","cotizaciones WHERE company_id=".$_SESSION['company'],"cotizacion_id",0);

	$total_servicios=$insLogin->seleccionarDatos("Normal","servicios WHERE company_id=".$_SESSION['company'],"venta_id",0);

if($_SESSION['rol']!=="Cajero"){?>

<div class="container mt-4 mb-2">

	<div class="columns ">
		<div class="column">
			<nav class="level is-mobile">
			  	<div class="level-item has-text-centered">
					<div class="box">
						<a title="Cajas registradas" class="is-link" href="<?php echo APP_URL; ?>cashierList/">
							<p class="heading"><i class="fas fa-cash-register fa-fw"></i> &nbsp; Cajas</p>
							<p class="title"><?php echo $total_cajas->rowCount(); ?></p>
						</a>
					</div>
			  	</div>
			  	<div class="level-item has-text-centered">
					<div class="box">
						<?php 
						$href=""; $icon=""; $titlle=""; $content=""; $class_btn="";
						if($_SESSION['usuario']=='Administrador'){
							$titlle="Usuarios";
							$content=$total_usuarios->rowCount();
							$href="userList/";
							$icon="fas fa-users fa-fw";
							$class_btn="";
							$hover="Usuarios agregados";
						}else{
							$titlle="Cerrar sesión";
							$content='Salir';
							$href="logOut/";
							$icon="fas fa-power-off";
							$class_btn='class="full-width btn-exit"';
							$hover="Cerrar Sesión";
						}
						; ?>
						<a title="<?php echo $hover ?>" href="<?php echo APP_URL.$href ?>" <?php echo $class_btn ?>>
							<p class="heading"><i class="<?php echo $icon ?>"></i> &nbsp; <?php echo $titlle ?></p>
							<p class="title"><?php echo $content ?></p>
						</a>
				  </div>
			  	</div>
			  	<div class="level-item has-text-centered">
					<div class="box">
						<a title="Clientes agregados" href="<?php echo APP_URL; ?>clientList/">
							  <p class="heading"><i class="fas fa-address-book fa-fw"></i> &nbsp; Clientes</p>
							  <p class="title"><?php echo $total_clientes->rowCount(); ?></p>
						</a>
					</div>
			  	</div>
			</nav>
		</div>
	</div>

	<div class="columns">
		<div class="column">
			<nav class="level is-mobile">
				<div class="level-item has-text-centered">
					<div class="box">
						<a title="Categorias Agregadas" href="<?php echo APP_URL; ?>categoryList/">
						  <p class="heading"><i class="fas fa-tags fa-fw"></i> &nbsp; Categorías</p>
						  <p class="title"><?php echo $total_categorias->rowCount(); ?></p>
						</a>
					</div>
			  	</div>
			  	<div class="level-item has-text-centered">
					  <div class="box">
					  <a title="Productos Registrados" href="<?php echo APP_URL; ?>productList/">
							<p class="heading"><i class="fas fa-cubes fa-fw"></i> &nbsp; Productos</p>
							<p class="title"><?php echo $total_productos->rowCount(); ?></p>
					  </a>
					  </div>
			  	</div>
			  	<div class="level-item has-text-centered">
					<div class="box">
						<a title="Ventas Realizadas" href="<?php echo APP_URL; ?>saleList/">
							<p class="heading"><i class="fas fa-shopping-cart fa-fw"></i> &nbsp; Ventas</p>
							<p class="title"><?php echo $total_ventas->rowCount(); ?></p>
						</a>
					</div>

			  	</div>
			</nav>
		</div>
	</div>
	<div class="columns pt-1">
		<div class="column">
			<nav class="level is-mobile">
				<div class="level-item has-text-centered">
					<div class="box">
						<a title="Cotizaciones Realizadas" href="<?php echo APP_URL; ?>cotizacionList/">
						  <p class="heading"><i class="fas fa-tags fa-fw"></i> &nbsp; Cotizaciones</p>
						  <p class="title"><?php echo $total_cotizaciones->rowCount(); ?></p>
						</a>
					</div>
			  	</div>
				<div class="level-item has-text-centered">
					<div class="box">
						<a title="Registrar nueva venta" href="<?php echo APP_URL; ?>saleNew/">
						  <p class="heading"><i class="fas fa-cart-plus fa-fw"></i></i> &nbsp; Nueva Venta</p>
						  <p class="heading"><i class="bi bi-plus-circle-fill"></i></p>
						</a>
					</div>
			  	</div>
			  	<div class="level-item has-text-centered">
					<div class="box">
						<a title="Servicios Realizados" href="<?php echo APP_URL; ?>servicesList/">
							  <p class="heading"><i class="bi bi-currency-dollar"></i> &nbsp; Servicios</p>
							  <p class="title"><?php echo $total_servicios->rowCount(); ?></p>
						</a>
					</div>
			  	</div>
			</nav>
		</div>
	</div>

</div>
<?php }else{?>
	<div class="container is-fluid">
		<div class="columns mt-5">
			<div class="column">
				<nav class="level is-mobile">
					<div class="level-item has-text-centered">
						<div class="box">
							<a title="Registrar nueva cotización" href="<?php echo APP_URL; ?>cotizacionNew/">
							<p class="heading"><i class="fas fa-tags fa-fw"></i> &nbsp; Nueva Cotización</p>
							<p class="tittle"><i class="bi bi-plus-circle-fill"></i></p>
							</a>
						</div>
					</div>
					<div class="level-item has-text-centered">
						<div class="box">
							<a title="Registrar nueva venta" href="<?php echo APP_URL; ?>saleNew/">
							<p class="heading"><i class="fas fa-cart-plus fa-fw"></i></i> &nbsp; Nueva Venta</p>
							<p class="tittle"><i class="bi bi-plus-circle-fill"></i></p>
							</a>
						</div>
					</div>
					<div class="level-item has-text-centered">
						<div class="box">
							<a title="Busca por rango de fecha" href="<?php echo APP_URL; ?>searchDate/">
								<p class="heading"><i class="bi bi-currency-dollar"></i> &nbsp; Buscar por fecha</p>
								<p class="tittle"><i class="bi bi-calendar-event-fill"></i></p>
							</a>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
<?php }?>