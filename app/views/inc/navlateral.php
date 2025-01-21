<?php include_once "app/controllers/styleController.php";?>
<head>
<?php 
	$datos=$insLogin->seleccionarDatos("Normal","diseño","*",1);

	if($datos->rowCount()==1){
		$datos=$datos->fetch();
	$datos['nav_color'];
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<style>
		#Nombre_user{
			display: flex;
			align-items: center;
		}
		#headerLat{
			background-color: <?php echo $datos['nav_color'] ?>;
		}
		.navLateral{
			width: 300px;
			border-right: 1px solid #E1E1E1;
			transition: all .3s ease-in-out;
			position: relative;
		}
		.navLateral-change{
			pointer-events: none;
			opacity: 0;
			width: 0;
			border-right: none;
		}
		.navLateral-body{
			background-color: #fff;
			position: relative;
		}
		.navLateral-body-logo{
			height: 45px;
			line-height: 45px;
			color: #fff;
			width: 100%;
			font-size: 25px;
			background-color: #000428;
		}
		.navLateral-body-cl,
		.navLateral-body-cr{
			box-sizing: border-box;
			height: 77px;
			float: left;
			margin: 0;
			padding: 0;
			position: relative;
		}
		.navLateral-body-cl{
			width: 30%;
		}
		.navLateral-body-cl img{
			width: 57px;
			height: 57px;
			margin: 0 auto;
			display: block;
			margin-top: 10px;
		}
		.navLateral-body-cr{
			width: 70%;
			font-family: "RobotoCondensedLight";
		}
		.navLateral-body-tittle-menu{
			height: 70px;
			line-height: 70px; 
			font-size:20px; 
			background-color: #F5F5F5;
			text-align: center;
		}
		.menu-principal li,
		.menu-principal li a{
			display: block;
		}
		.menu-principal li a{
			height: 45px;
			color: #333;
			position: relative;
			transition: all .3s ease-in-out;
		}
		.menu-principal li a:hover{
			color: <?php echo $datos['nav_color'] ?>;
		}
		.menu-principal li a div.navLateral-body-cl,
		.menu-principal li a div.navLateral-body-cr{
			height: 45px;
			line-height: 45px;
		}
		.menu-principal li a div.navLateral-body-cl{
			text-align: center;
			font-size: 20px;
		}
		.btn-subMenu span.fa-chevron-down{
			position: absolute;
			top: 0;
			right: 7px;
			line-height: 45px;
			height: 45px;
			font-size: 19px;
			transition: all .3s ease-in-out;
		}
		.btn-subMenu + .sub-menu-options{
			transition: all .3s ease-in-out;
		}
		.sub-menu-options{
			height: 0;
			background-color: #F5F5F5;
			overflow-y: hidden;
			transition: all .3s ease-in-out;
		}
		.sub-menu-options li a{ border-left: 4px solid transparent; }
		.sub-menu-options li a:hover{ border-left: 4px solid #fff; }
		.btn-subMenu-show{
			background-color: rgba(0, 0, 0, 0.1);
		}
		.btn-subMenu-show .navLateral-body-cl,
		.btn-subMenu-show .navLateral-body-cr{
			color: <?php echo $datos['nav_color']?>;
		}
		.btn-subMenu-show + .sub-menu-options{
			height: auto;
			overflow-y: auto;
			background-color: rgba(0, 0, 0, 0.1);
		}

		.btn-subMenu-show span.fa-chevron-down{
			color: <?php echo $datos['nav_color'] ?>;
			transform: rotate(180deg);
		}
		.fa-th-large{
			color: <?php echo $datos['nav_color'] ?>;
		}

	</style>
</head><?php }?>
<section class="full-width navLateral scroll navLateral-change" id="navLateral">
	<div class="full-width navLateral-body">
		<div id="headerLat" class="full-width navLateral-body-logo has-text-centered tittles is-uppercase">
			<?php echo APP_NAME ?>
		</div>
		<figure class="full-width" style="height: 77px;">
			<div class="navLateral-body-cl">
				<?php
				$imagen = $_SESSION['foto'];
                    if(is_file("./app/views/fotos/".$_SESSION['foto'])){
                        echo '<img class="is-rounded img-responsive" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
                    }else{
                        echo '<img class="is-rounded img-responsive" src="'.APP_URL.'app/views/fotos/default.png">';
                    }
                ?>
			</div>
			<figcaption id="Nombre_user" class="navLateral-body-cr">
				<span>
					<?php echo $_SESSION['nombre']; ?><br>
					<small><?php echo $_SESSION['rol']; ?></small>
				</span>
			</figcaption>
		</figure>
		<div class="full-width tittles navLateral-body-tittle-menu has-text-centered is-uppercase">
			<i class="fas fa-th-large fa-fw"></i> &nbsp; 
			<?php 
			$datos=$insLogin->seleccionarDatos("Normal","empresa LIMIT 1","*",0);
		if($datos->rowCount()==1){
		$datos=$datos->fetch();
		echo $datos['empresa_nombre'];
	}

?> 
		</div>
		<?php if($_SESSION['rol']!=="Cajero"){?>
		<nav class="full-width">
			<ul class="full-width list-unstyle menu-principal">

				<li class="full-width">
					<a href="<?php echo APP_URL; ?>dashboard/" class="full-width">
						<div class="navLateral-body-cl">
							<i class="fab fa-dashcube fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							Inicio
						</div>
					</a>
				</li>

				<li class="full-width divider-menu-h"></li>
				
				<li class="full-width">
					<a href="<?php echo APP_URL; ?>searchDate/" class="full-width">
						<div class="navLateral-body-cl">
						<i class="bi bi-calendar-check-fill"></i>
						</div>
						<div class="navLateral-body-cr">
							Busqueda por fecha
						</div>
					</a>
				</li>
				<li class="full-width divider-menu-h"></li>

				<?php if($_SESSION['rol']=="Administrador"){?>
				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-buildings-fill"></i>
						</div>
						<div class="navLateral-body-cr">
							EMPRESAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
				<ul class="full-width menu-principal sub-menu-options">
					<li class="full-width">
							<a href="<?php echo APP_URL; ?>companyNew/" class="full-width">
							<div class="navLateral-body-cl">
							<i class="bi bi-view-list"></i>
							</div>
							<div class="navLateral-body-cr">
								Nueva empresa
							</div>
						</a>
					</li>

					<li class="full-width">
						<a href="<?php echo APP_URL; ?>companyList/" class="full-width">
							<div class="navLateral-body-cl">
							<i class="bi bi-view-list"></i>
							</div>
							<div class="navLateral-body-cr">
								Lista de empresas
							</div>
						</a>
					</li>

				</ul>
				<li class="full-width divider-menu-h"></li>
				<?php  }?>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-cash-register fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							CAJAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cashierNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-cash-register fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva caja
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cashierList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de cajas
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cashierSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar caja
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>
				<li class="full-width">
				<?php if($_SESSION['rol']=="Administrador" || $_SESSION['rol']=="Admin"){?>	
			<a href="#" class="full-width btn-subMenu">
				<div class="navLateral-body-cl">
					<i class="fas fa-users fa-fw"></i>
				</div>
				<div class="navLateral-body-cr">
					USUARIOS
				</div>
				<span class="fas fa-chevron-down"></span>
			</a>
			<ul class="full-width menu-principal sub-menu-options">
				<?php if($_SESSION['rol']=="Administrador"){?>
				<li class="full-width">
					<a href="<?php echo APP_URL ?>userNew/" class="full-width">
						<div class="navLateral-body-cl">
							<i class="fas fa-cash-register fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							Nuevo usuario
						</div>
					</a>
				</li><?php }?>
				<li class="full-width">
					<a href="<?php echo APP_URL?>userList/" class="full-width">
						<div class="navLateral-body-cl">
							<i class="fas fa-clipboard-list fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							Lista de usuarios
						</div>
					</a>
				</li>
				<li class="full-width">
					<a href="<?php echo APP_URL?>userSearch/" class="full-width">
						<div class="navLateral-body-cl">
							<i class="fas fa-search fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							Buscar usuario
						</div>
					</a>
				</li>
			</ul>
				<?php }?>
				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-address-book fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							CLIENTES
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>clientNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-male fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nuevo cliente
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>clientList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de clientes
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>clientSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar cliente
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>
				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
						<i class="bi bi-truck-front-fill"></i>
						</div>
						<div class="navLateral-body-cr">
							PROVEEDORES
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>supplierNew/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-person-plus-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Nuevo Provedor
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>supplierList/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-truck"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Provedores
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-tags fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							CATEGORIAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>categoryNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-tag fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva categoría
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>categoryList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de categorías
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>categorySearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar categoría
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>
				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
						<i class="bi bi-file-break-fill"></i>
						</div>
						<div class="navLateral-body-cr">
							PRESENTACIONES
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>presentacionNew/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-file-diff-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva Presentación
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>presentacionList/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-exclude"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Presentaciones
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-cubes fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							PRODUCTOS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>productNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-box fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nuevo producto
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>productList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de productos
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>productCategory/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-boxes fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Productos por categoría
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>productSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar producto
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-shopping-cart fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							VENTAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-cart-plus fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva venta
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de ventas
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar venta
								</div>
							</a>
						</li>
						 <li class="full-width">
							<a href="<?php echo APP_URL; ?>saleSearchDate/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-calendar-event-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar venta por fecha
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>
				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
						<i class="bi bi-backpack4-fill"></i>
						</div>
						<div class="navLateral-body-cr">
							COMPRAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>buyNew/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-basket-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva Compra Productos
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>buyList/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-bar-chart-steps"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Compras
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>buySearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar compra
								</div>
							</a>
						</li>
						 <li class="full-width">
							<a href="<?php echo APP_URL; ?>buySearchDate/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-calendar-event-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar compra por fecha
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-screwdriver"></i>
						</div>
						<div class="navLateral-body-cr">
							SERVICIOS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
					<li class="full-width">
							<a href="<?php echo APP_URL; ?>addService/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-plus-circle-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									agregar Servicio
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>servicesNew/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-tools"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva venta de Servicio
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>services/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-card-checklist"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Servicios
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>servicesList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-bandaid"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Servicios Realizados
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>servicesSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar Servicio
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>servicesSearchR/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-search-heart"></i>								</div>
								<div class="navLateral-body-cr">
									Buscar Servicios Realizados
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>servicesSearchDate/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-search-heart"></i>								</div>
								<div class="navLateral-body-cr">
									Servicios Realizados por fecha
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>
				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-currency-dollar"></i>
						</div>
						<div class="navLateral-body-cr">
							COTIZAR
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-currency-exchange"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva Cotización
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-bank"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Cotizaciones
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar Cotización
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionSearchDate/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar Cotización por fecha
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<!--<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-percent"></i>
						</div>
						<div class="navLateral-body-cr">
							DESCUENTOS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-plus-circle-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Nuevo Descuento
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-pass-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Descuentos
								</div>
							</a>
						</li>
					</ul>
				</li>-->
				<!--<li class="full-width">
					<a href="<?php echo APP_URL; ?>performance/" class="full-width">
						<div class="navLateral-body-cl">
						<i class="bi bi-graph-up"></i>
						</div>
						<div class="navLateral-body-cr">
							Rendimiento
						</div>
					</a>
				</li>-->
				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-cogs fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							CONFIGURACIONES
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
				<ul class="full-width menu-principal sub-menu-options">
						<!--<li class="full-width">
							<a href="<?php echo APP_URL?>alertConfig/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-exclamation-square-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Alertas
								</div>
							</a>
						</li> -->
						<li class="full-width">
							<a href="<?php echo APP_URL."companyDetail/".$_SESSION['company']."/";?>" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-store-alt fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Datos de empresa
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-user-tie fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Mi cuenta
								</div>
							</a>
						</li>
						
						<?php if($_SESSION['rol']=="Admin" || $_SESSION['rol']=="Administrador"){?>
						<li class="full-width">
						<a href="<?php echo APP_URL."styleConfig/"?>" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-layers-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Diseño de interfaz
								</div>
							</a>
						</li><?php }?>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width mt-5">
					<a href="<?php echo APP_URL."logOut/"; ?>" class="full-width btn-exit" >
						<div class="navLateral-body-cl">
							<i class="fas fa-power-off"></i>
						</div>
						<div class="navLateral-body-cr">
							Cerrar sesión
						</div>
					</a>
				</li>

			</ul>
		</nav><?php }else{?>
		<nav class="full-width">
		<ul class="full-width list-unstyle menu-principal">

		<li class="full-width">
					<a href="<?php echo APP_URL; ?>dashboard/" class="full-width">
						<div class="navLateral-body-cl">
							<i class="fab fa-dashcube fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							Inicio
						</div>
					</a>
				</li>

				<li class="full-width divider-menu-h"></li>

		<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="fas fa-shopping-cart fa-fw"></i>
						</div>
						<div class="navLateral-body-cr">
							VENTAS
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-cart-plus fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva venta
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-clipboard-list fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de ventas
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>saleSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar venta
								</div>
							</a>
						</li>
						 <li class="full-width">
							<a href="<?php echo APP_URL; ?>saleSearchDate/" class="full-width">
								<div class="navLateral-body-cl">
								<i class="bi bi-calendar-event-fill"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar venta por fecha
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-currency-dollar"></i>
						</div>
						<div class="navLateral-body-cr">
							COTIZAR
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-currency-exchange"></i>
								</div>
								<div class="navLateral-body-cr">
									Nueva Cotización
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionList/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-bank"></i>
								</div>
								<div class="navLateral-body-cr">
									Lista de Cotizaciones
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionSearch/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar Cotización
								</div>
							</a>
						</li>
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionSearchDate/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="fas fa-search-dollar fa-fw"></i>
								</div>
								<div class="navLateral-body-cr">
									Buscar Cotización por fecha
								</div>
							</a>
						</li>
					</ul>

				<li class="full-width divider-menu-h"></li>

				<li class="full-width">
					<a href="#" class="full-width btn-subMenu">
						<div class="navLateral-body-cl">
							<i class="bi bi-currency-dollar"></i>
						</div>
						<div class="navLateral-body-cr">
							Herramientas
						</div>
						<span class="fas fa-chevron-down"></span>
					</a>
					<ul class="full-width menu-principal sub-menu-options">
						<li class="full-width">
							<a href="<?php echo APP_URL; ?>cotizacionNew/" class="full-width">
								<div class="navLateral-body-cl">
									<i class="bi bi-currency-exchange"></i>
								</div>
								<div class="navLateral-body-cr">
									CODIGO DE BARRA
								</div>
							</a>
						</li>
					</ul>
					
					<li class="full-width mt-5">
					<a href="<?php echo APP_URL."logOut/"; ?>" class="full-width btn-exit" >
						<div class="navLateral-body-cl">
							<i class="fas fa-power-off"></i>
						</div>
						<div class="navLateral-body-cr">
							Cerrar sesión
						</div>
					</a>
				</li>
				</li>
		</nav><?php }?>
	</div>
</section>