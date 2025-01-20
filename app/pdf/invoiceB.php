<?php
	
	$peticion_ajax=true;
	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;

	/*---------- Incluyendo configuraciones ----------*/
	require_once "../../config/app.php";
    require_once "../../autoload.php";

	/*---------- Instancia al controlador compra ----------*/
	use app\controllers\buyController;

	$ins_compra = new buyController();

	$datos_compra=$ins_compra->seleccionarDatos("Normal","compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id INNER JOIN caja ON compra.caja_id=caja.caja_id WHERE (compra_codigo='$code')","*",0);

	if($datos_compra->rowCount()==1){

		/*---------- Datos de la compra ----------*/
		$datos_compra=$datos_compra->fetch();

		/*---------- Seleccion de datos de la empresa ----------*/
		$datos_empresa=$ins_compra->seleccionarDatos("Normal","empresa LIMIT 1","*",0);
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
		$pdf->Cell(116,7,iconv("UTF-8", "ISO-8859-1",date("d/m/Y", strtotime($datos_compra['compra_fecha']))." ".$datos_compra['compra_hora']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(39,39,51);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper('Factura de compra Nro.')),0,0,'C');

		$pdf->Ln(7);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(12,7,iconv("UTF-8", "ISO-8859-1",'Usuario:'),0,0,'L');
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(134,7,iconv("UTF-8", "ISO-8859-1"," "." ".$datos_compra['usuario_nombre']." ".$datos_compra['usuario_apellido']),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_compra['compra_id'])),0,0,'C');

		$pdf->Ln(10);

		if($datos_compra['supplier_id']==1){
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(16,7,iconv("UTF-8", "ISO-8859-1",'Proveedor:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(50,7,iconv("UTF-8", "ISO-8859-1"," "." "."N/A"),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","Representante: "),0,0,'L');
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
			$pdf->Cell(19,7,iconv("UTF-8", "ISO-8859-1",'Proveedor:'.' '.' '.' '),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1",$datos_compra['supplier_nombre']),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1","Representante:"),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1"," "." ".$datos_compra['supplier_representante']),0,0,'L');
			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(7,7,iconv("UTF-8", "ISO-8859-1",'Tel:'),0,0,'L');
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",$datos_compra['supplier_telefono']),0,0);
			$pdf->SetTextColor(39,39,51);

			$pdf->Ln(7);

			$pdf->SetTextColor(39,39,51);
			$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1",'Dir:'),0,0);
			$pdf->SetTextColor(97,97,97);
			$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1",$datos_compra['supplier_provincia'].", ".$datos_compra['supplier_ciudad'].", ".$datos_compra['supplier_direccion']),0,0);
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

		/*----------  Seleccionando detalles de la compra  ----------*/
		$compra_detalle=$ins_compra->seleccionarDatos("Normal","compra_detalle WHERE compra_codigo='".$datos_compra['compra_codigo']."'","*",0);
		$compra_detalle=$compra_detalle->fetchAll();

		foreach($compra_detalle as $detalle){
			$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",$ins_compra->limitarCadena($detalle['compra_detalle_descripcion'],80,"...")),'L',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$detalle['compra_detalle_cantidad']),'L',0,'C');
			$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['compra_detalle_precio_compra'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),'L',0,'C');
			$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['compra_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),'LR',0,'C');
			$pdf->Ln(7);
		}

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
			$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');

		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'TOTAL A PAGAR:'),'T',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),'T',0,'C');

		$pdf->Ln(7);

		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'TOTAL PAGADO:'),'',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_pagado'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),'',0,'C');

		$pdf->Ln(7);

		$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
		$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1",'CAMBIO:'),'',0,'C');
		$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_cambio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),'',0,'C');

		$pdf->Ln(12);

		$pdf->SetFont('Arial','',9);

		$pdf->SetTextColor(39,39,51);

		$pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Factura De Compra"),'',0,'C');

		$pdf->Ln(9);

		$pdf->SetFillColor(39,39,51);
		$pdf->SetDrawColor(23,83,201);
        $pdf->Code128(72,$pdf->GetY(),$datos_compra['compra_codigo'],70,20);
        $pdf->SetXY(12,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_compra['compra_codigo']),0,'C',false);

		$pdf->Output("I","Factura_Compra_Nro".$datos_compra['compra_id'].".pdf",true);

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
                <p class="subtitle has-text-white">No hemos encontrado datos de la compra</p>
            </div>
        </section>
    </div>
	<?php include '../views/inc/script.php'; ?>
</body>
</html>
<?php } ?>