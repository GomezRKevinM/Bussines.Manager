<head>
	<style>
		.num_container{
			padding: 2px 6px;
			background-color: #fff;
			color: #000;
			border-radius: 50%;
		}
		.selectores{
			background-color: transparent;
			border: 3px solid #48c78e;
			border-radius: 20px;
			padding: 5px 9px;
			color: #000;
			text-align: center;
    		white-space: nowrap;
			cursor: pointer;
			transition:all 0.2s ease-in-out;
			font-size: 14px;
		}
		.selectores:hover{
			scale: 105%;
			background-color: #48c78e;
			color: white;
			box-shadow: 1px 2px 4px #000,inset 1px 2px 4px #fff;
			border: 3px solid #2D7C59;
		}
		.contenedor-puntos{
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 15px;
			margin-bottom: 15px;
		}
		.points{
			width: 15px;
			height: 15px;
			background-color: #4d4d4d;
			border-radius: 50%;
			box-shadow: 1px 2px 2px #606060;
		}
		.points:hover{
			scale: 105%;
			background-color: #48c78e;
			color: white;
			box-shadow: 1px 2px 4px #000,inset 1px 2px 4px #fff;
			border: 3px solid #2D7C59;
			cursor: pointer;
		}
		.is-select{
			scale: 110%;
			background-color: #48c78e;
			color: white;
			box-shadow: 1px 2px 4px #000,inset 1px 2px 4px #fff;
			border: 3px solid #2D7C59;
		}
		.oculto{
			display: none;
		}
		.mostrar{
			display: block;
		}
	</style>
</head>
<div class="container is-fluid mb-6">
	<h1 class="title mb-5">Clientes</h1>
	<h2 class="subtitle"><i class="fas fa-sync-alt"></i> &nbsp; Información del cliente</h2>
</div>

<div class="container is-fluid">
	
	<?php

		use app\controllers\saleController;
		use app\controllers\clientController;
		use app\models\mainModel;

		$insMainModel = new mainModel();

		$insCliente = new clientController();

		$insVenta = new saleController();
		$pagina = "clientDetail";
	
		include "./app/views/inc/btn_back.php";

		$id=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Unico","cliente","cliente_id",$id);
		$datosVentas=$insLogin->seleccionarDatos("Unico","venta","cliente_id",$id);
		$row=$datosVentas->rowCount();
		if($row >= 1){$datosVentas=$datosVentas->fetchAll();}


		if($datos->rowCount()==1){
			$datos=$datos->fetch();
			$registros=$datos['cliente_ventas'];
			if($registros>=1){
				$compras=$insVenta->listarVentaClientControlador($pagina,$registros,$url[1],$id);
				$llamadas=$insCliente->listarLlamadaClientControlador($pagina,$registros,$url[0],$id);
				$visitas=$insCliente->listarVisitClientControlador($pagina,$registros,$url[0],$id);
			}

	?>

	<h2 class="title has-text-centered"><?php echo $datos['cliente_nombre']." ".$datos['cliente_apellido']; ?></h2>
	<div class="columns">
		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Tipo de documento</div>
				<span class="has-text-link"><?php echo $datos['cliente_tipo_documento']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Numero de documento</div>
				<span class="has-text-link"><?php echo $datos['cliente_numero_documento']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Id del cliente</div>
				<span class="has-text-link"><?php echo $datos['cliente_id']; ?></span>
			</div>

		</div>

		<div class="column">

			<div class="full-width sale-details text-condensedLight">
	 			<div class="has-text-weight-bold has-text-black">Departamento</div>
				<span class="has-text-link"><?php echo $datos['cliente_provincia']; ?></span>
			</div>
			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Ciudad o pueblo</div>
				<span class="has-text-link"><?php echo $datos['cliente_ciudad']; ?></span>
			</div>
			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Dirección</div>
				<span class="has-text-link"><?php echo $datos['cliente_direccion']; ?></span>
			</div>

		</div>

		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Teléfono</div>
				<a href="tel:+57<?php echo $datos['cliente_telefono']; ?>" class="has-text-link"><?php echo '+57 '.$datos['cliente_telefono']; ?></a>
			</div>
			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold has-text-black">Correo</div>
				<a class="has-text-link" href="mailto:<?php echo $datos['cliente_email']; ?>"><?php echo $datos['cliente_email']; ?></a>
			</div>

		</div>
	</div>


	<div class="container">
		<table class="table">
			<tbody>
				<?php 
				$ua = $row-1;
				$PA = $row-2;
				$con = $row-1;	
				$suma = array();

				if($row<=0){
					echo '<td>No tiene compras realizadas<td><p>';
					return;
				}else{
			 for ($i=0; $i < $row;) { 
					$cc= $i+1;
					$n2 = $cc;
					if($n2 >= $row){$n2=$row-2;}


					$fecha = new DateTime($datosVentas[$i]['venta_fecha']);
					$fecha2 = new DateTime($datosVentas[$n2]['venta_fecha']);
					$fecha2STR = $fecha2 -> format('y-m-d');
					$año = $fecha->format('y');
					$mes = $fecha->format('m');
					$dia = $fecha->format('d');
					$fechaYMD = $fecha->format('y-m-d');
					$diferencia = $fecha->diff($fecha2); $diffDay = $diferencia->days;
					$diffDay=(int)$diffDay;
					array_push($suma,$diffDay);
					$frecuencia = array_count_values($suma);
					$moda = array_search(max($frecuencia), $suma);
					$sum=array_sum($suma);
					
					#convertir a mes
					if($diffDay>30){
						$diffDay = round($diffDay/30);
						$diffDay.=' meses';
					}
					$tr='
						<tr>
							<td>'.$cc.'</td>
							<td>'.$fechaYMD.'</td>
							<td>'.$diffDay.'</td>
							<td>'.$i.'</td>
							<td>'.$suma[$i].'</td>
							<td>'.$sum.''.$moda.'</td>
						</tr>
					';
					$i++;	
				}

				$promedio = $sum/4;
				if($moda<=0){$moda='0';}
				echo '<tr><td>promedio :</td><td>'.$promedio.'</td><td> Moda: '.$moda.'</td></tr';}?>
			</tbody>
		</table>
	</div>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
	<script src="<?php echo APP_URL?>app/views/js/selectores.js"></script>
</div>