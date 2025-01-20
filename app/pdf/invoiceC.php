<?php
	
	$peticion_ajax=true;
	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;

	/*---------- Incluyendo configuraciones ----------*/
	require_once "../../config/app.php";
    require_once "../../autoload.php";

	/*---------- Instancia al controlador cotización ----------*/
	use app\controllers\cotizarController;

	$ins_venta = new cotizarController();

	$datos_venta=$ins_venta->seleccionarDatos("Normal","cotizaciones INNER JOIN cliente ON cotizaciones.cliente_id=cliente.cliente_id INNER JOIN usuario ON cotizaciones.usuario_id=usuario.usuario_id INNER JOIN caja ON cotizaciones.caja_id=caja.caja_id WHERE (cotizacion_codigo='$code')","*",0);

	if($datos_venta->rowCount()==1){

		/*---------- Datos de la cotización ----------*/
		$datos_venta=$datos_venta->fetch();

		/*---------- Seleccion de datos de la empresa ----------*/
		$datos_empresa=$ins_venta->seleccionarDatos("Normal","empresa LIMIT 1","*",0);
		$datos_empresa=$datos_empresa->fetch();

		$logo = $datos_empresa['logo'];
		$extension="";

		if (strpos($logo, ".png") !== false) {
			$extension="PNG";
		} else {
			$extension="JPG";
		}

		require "./code128.php";
	
		$pdf = new PDF_Code128('P','mm','Letter');
		$pdf->SetMargins(17,17,17);
		$pdf->AddPage();
		if($datos_empresa['logo']=="default.png"){
			$pdf->Image(APP_URL.'app/views/icons/logo.png',165,12,35,35,'PNG');
		}else{
			$pdf->Image(APP_URL.'app/views/fotos/'.$datos_empresa['logo'],165,12,35,35,$extension);
		}

		$pdf->SetFont('Arial','B',16);
		$pdf->SetTextColor(32,100,210);
		$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,0,'L');

		$pdf->Ln(9);

		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(39,39,51);
		if($datos_empresa['empresa_nit']==""){

		}else{
			$pdf->Cell(50,2,iconv("UTF-8", "ISO-8859-1","NIT: ".strtoupper($datos_empresa['empresa_nit'])),0,0,'L');
		}
		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",""),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1",$datos_empresa['empresa_direccion']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_empresa['empresa_telefono']),0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: ".$datos_empresa['empresa_email']),0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1",'Fecha de emisión:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(116,7,iconv("UTF-8", "ISO-8859-1",date("d/m/Y", strtotime($datos_venta['cotizacion_fecha']))." ".$datos_venta['cotizacion_hora']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper('cotizacion Nro.')),0,0,'C');

		$pdf->Ln(7);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(18,7,iconv("UTF-8", "ISO-8859-1",'Empleado:'),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(128,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_venta['cotizacion_id'])),0,0,'C');

		$pdf->Ln(10);

		if($datos_venta['cliente_id']==1){
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1",'Cliente:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(8,7,iconv("UTF-8", "ISO-8859-1","Doc: "),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1",'Tel:'),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0);
			$pdf->SetTextColor(39,39,51);

			$pdf->Ln(7);

			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1",'Dir:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1","N/A"),0,0);
		}else{
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(13,7,iconv("UTF-8", "ISO-8859-1",'Cliente:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(8,7,iconv("UTF-8", "ISO-8859-1","Doc: "),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_tipo_documento']." ".$datos_venta['cliente_numero_documento']),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1",'Tel:'),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_telefono']),0,0);
			$pdf->SetTextColor(39,39,51);

			$pdf->Ln(7);

			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1",'Dir:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1",$datos_venta['cliente_provincia'].", ".$datos_venta['cliente_ciudad'].", ".$datos_venta['cliente_direccion']),0,0);
		}

		$pdf->Ln(9);

		$pdf->SetFillColor(23,83,201);
		$pdf->SetDrawColor(23,83,201);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(100,8,iconv("UTF-8", "ISO-8859-1",'Descripción'),1,0,'C',true);
		$pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1",'Cant.'),1,0,'C',true);
		$pdf->Cell(32,8,iconv("UTF-8", "ISO-8859-1",'Precio'),1,0,'C',true);
		$pdf->Cell(34,8,iconv("UTF-8", "ISO-8859-1",'Subtotal'),1,0,'C',true);

		$pdf->Ln(8);

		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(39,39,51);

		/*----------  Seleccionando detalles de la venta  ----------*/
		$venta_detalle=$ins_venta->seleccionarDatos("Normal","cotizacion_detalle WHERE cotizacion_codigo='".$datos_venta['cotizacion_codigo']."'","*",0);
		$venta_detalle=$venta_detalle->fetchAll();

		foreach($venta_detalle as $detalle){
			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",$ins_venta->limitarCadena($detalle['cotizacion_detalle_descripcion'],80,"...")),'L',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$detalle['cotizacion_detalle_cantidad']),'L',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['cotizacion_detalle_precio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),'L',0,'C');
			$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['cotizacion_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),'LR',0,'C');
			$pdf->Ln(7);
		}

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');

		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'TOTAL A PAGAR:'),'T',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_venta['cotizacion_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),'T',0,'C');

		$pdf->Ln(7);
		if($detalle['cotizacion_detalle_detalles']!=""){
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(32,100,210);
			$pdf->Cell(15,10,iconv("UTF-8", "ISO-8859-1",strtoupper("Detalles")),0,0,'L');
			$pdf->Image(APP_URL.'app/views/productos/COPi3_28.png',145,115,35,35,'PNG');

			$pdf->Ln(12);
			$pdf->SetTextColor(39,39,51);
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Torre: dell "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Procesador: i3(intel core 3) 4th generación "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Memoria Ram 4Gb "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Disco duro: 500Gb "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1",'- Pantalla: 19" '),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Tipo Pantalla: LED "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Teclado y Mouse "),'',0,'L');
			$pdf->Ln(5);
			$pdf->Cell(80,7,iconv("UTF-8","ISO-8859-1","- Color Negro "),'',0,'L');
			$pdf->Ln(5);
		}
		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'L');

		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'L');

		$pdf->Ln(12);

		$pdf->SetFont('Arial','',9);

		$pdf->SetTextColor(39,39,51);
		$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","***Los Precios de productos no incluyen impuestos.***"),0,'C',false);

		$pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Cotización Sujeta a Disponibilidad"),'',0,'C');

        $pdf->Ln(9);


		$pdf->SetFillColor(39,39,51);
		$pdf->SetDrawColor(23,83,201);
        $pdf->Code128(72,$pdf->GetY(),$datos_venta['cotizacion_codigo'],70,20);
        $pdf->SetXY(12,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_venta['cotizacion_codigo']),0,'C',false);

		$pdf->Output("I","cotizacion_Nro".$datos_venta['cotizacion_id'].".pdf",true);

	}else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo APP_NAME; ?></title>
	<?php include '../views/inc/head.php'; ?>
</head>
<body>
	<div class="main-container">
        <section class="hero-body">
            <div class="hero-body">
                <p class="has-text-centered has-text-white pb-3">
                    <i class="fas fa-rocket fa-5x"></i>
                </p>
                <p class="title has-text-white">¡Ocurrió un error!</p>
                <p class="subtitle has-text-white">No hemos encontrado datos de la Cotización</p>
            </div>
        </section>
    </div>
	<?php include '../views/inc/script.php'; ?>
</body>
</html>
<?php } ?>