<div class="container is-fluid mb-6">
	<h1 class="title">Compras</h1>
	<h2 class="subtitle"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; Información de compra</h2>
</div>

<div class="container is-fluid">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$code=$insLogin->limpiarCadena($url[1]);

		$datos=$insLogin->seleccionarDatos("Normal","compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id INNER JOIN caja ON compra.caja_id=caja.caja_id WHERE (compra_codigo='".$code."')","*",0);

		if($datos->rowCount()==1){
			$datos_compra=$datos->fetch();
	?>
	<h2 class="title has-text-centered">Datos de la Compra <?php echo " (".$code.")"; ?></h2>
	<div class="columns pb-2 pt-6">
		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Fecha</div>
				<span class="has-text-link"><?php echo date("d-m-Y", strtotime($datos_compra['compra_fecha']))." ".$datos_compra['compra_hora']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Nro. de factura</div>
				<span class="has-text-link"><?php echo $datos_compra['compra_id']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Código de compra</div>
				<span class="has-text-link"><?php echo $datos_compra['compra_codigo']; ?></span>
			</div>

		</div>

		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Pagó desde Caja Nro.</div>
				<span class="has-text-link">Nro. <?php echo $datos_compra['caja_numero']." (".$datos_compra['caja_nombre']; ?>)</span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Usuario</div>
				<span class="has-text-link"><?php echo $datos_compra['usuario_nombre']." ".$datos_compra['usuario_apellido']; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Proveedor</div>
				<span class="has-text-link"><?php echo $datos_compra['supplier_nombre']; ?></span>
			</div>

		</div>

		<div class="column">

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Total</div>
				<span class="has-text-link"><?php echo MONEDA_SIMBOLO.number_format($datos_compra['compra_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Pagado</div>
				<span class="has-text-link"><?php echo MONEDA_SIMBOLO.number_format($datos_compra['compra_pagado'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
			</div>

			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold">Cambio</div>
				<span class="has-text-link"><?php echo MONEDA_SIMBOLO.number_format($datos_compra['compra_cambio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
			</div>
			<?php
							$detalle_compra=$insLogin->seleccionarDatos("Normal","compra_detalle WHERE compra_codigo='".$datos_compra['compra_codigo']."'","*",0);
                            if($detalle_compra->rowCount()>=1){

                                $detalle_compra=$detalle_compra->fetchAll();
                            	$cc=1;

                                foreach($detalle_compra as $detalle){
                        ?>
		</div>
		</div>
		<div class="columns ">
			<div class="full-width sale-details text-condensedLight">
				<div class="has-text-weight-bold center">Descripción:</div>
			<span class="has-text-link"><?php echo $detalle['compra_coment']; ?></span>
			</div>
		</div>

	</div>

	<div class="columns pb-6 pt-6">
		<div class="column">
			<div class="table-container">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th class="has-text-centered">#</th>
                            <th class="has-text-centered">Producto</th>
                            <th class="has-text-centered">Cant.</th>
                            <th class="has-text-centered">Precio de compra</th>
                            <th class="has-text-centered">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="has-text-centered" >
                            <td><?php echo $cc; ?></td>
                            <td><?php echo $detalle['compra_detalle_descripcion']; ?></td>
                            <td><?php echo $detalle['compra_detalle_cantidad']; ?></td>
                            <td><?php echo MONEDA_SIMBOLO.number_format($detalle['compra_detalle_precio_compra'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                            <td><?php echo MONEDA_SIMBOLO.number_format($detalle['compra_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                        </tr>
                        <?php
                                $cc++;
                            }
                        ?>
                        <tr class="has-text-centered" >
                            <td colspan="3"></td>
                            <td class="has-text-weight-bold">
                                TOTAL
                            </td>
                            <td class="has-text-weight-bold">
                                <?php echo MONEDA_SIMBOLO.number_format($datos_compra['compra_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?>
                            </td>
                        </tr>
                        <?php
                            }else{
                        ?>
                        <tr class="has-text-centered" >
                            <td colspan="8">
                                No hay productos agregados
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
	<div class="columns pb-6 pt-6">
		<p class="has-text-centered full-width">
			<?php
			echo '<button type="button" class="button is-link is-light is-medium" onclick="print_invoiceBuy(\''.APP_URL.'app/pdf/invoiceB.php?code='.$datos_compra['compra_codigo'].'\')" title="Imprimir factura de compra Nro. '.$datos_compra['compra_id'].'" >
			<i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Imprimir factura
			</button> &nbsp;&nbsp; 

			<button type="button" class="button is-link is-light is-medium" onclick="print_ticketBuy(\''.APP_URL.'app/pdf/ticketB.php?code='.$datos_compra['compra_codigo'].'\')" title="Imprimir ticket de compra Nro. '.$datos_compra['compra_id'].'" ><i class="fas fa-receipt fa-fw"></i> &nbsp; Imprimir ticket de compra</button>';
			?>
		</p>
	</div>
	<?php
			include "./app/views/inc/print_invoice_script.php";
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>