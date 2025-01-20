<?php

	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;

	/*---------- Incluyendo configuraciones ----------*/
    require_once "../../config/app.php";
    require_once "../../autoload.php";

	/*---------- Instancia al controlador venta ----------*/
	use app\controllers\buyController;
	$ins_compra = new buyController();

	$datos_compra=$ins_compra->seleccionarDatos("Normal","compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id INNER JOIN caja ON compra.caja_id=caja.caja_id WHERE (compra_codigo='$code')","*",0);

	if($datos_compra->rowCount()==1){
        
		/*---------- Datos de la compra ----------*/
		$datos_compra=$datos_compra->fetch();

		/*---------- Seleccion de datos de la empresa ----------*/
		$datos_empresa=$ins_compra->seleccionarDatos("Normal","empresa LIMIT 1","*",0);
		$datos_empresa=$datos_empresa->fetch();


		require "./code128.php";

		$pdf = new PDF_Code128('P','mm',array(80,258));
		$pdf->SetMargins(4,10,4);
        $pdf->AddPage();
        
        if($datos_empresa['empresa_nit']==""){
            $pdf->SetFont('Arial','B',10);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,'C',false);
            $pdf->SetFont('Arial','',9);
        }else{
            $pdf->SetFont('Arial','B',10);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($datos_empresa['empresa_nombre'])),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","NIT: ".strtoupper($datos_empresa['empresa_nit'])),0,'C',false);
            $pdf->SetFont('Arial','',9);
        }
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_empresa['empresa_telefono']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: ".$datos_empresa['empresa_email']),0,'C',false);

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);

        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".date("d/m/Y", strtotime($datos_compra['compra_fecha']))." ".$datos_compra['compra_hora']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Caja Nro: ".$datos_compra['caja_numero']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Usuario: ".$datos_compra['usuario_nombre']." ".$datos_compra['usuario_apellido']),0,'C',false);
        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket de Compra Nro: ".$datos_compra['compra_id'])),0,'C',false);
        $pdf->SetFont('Arial','',9);

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);
    
        if($datos_compra['supplier_id']==1){
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Proveedor: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Representante: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: N/A"),0,'C',false);
        }else{
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Proveedor: ".$datos_compra['supplier_nombre']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Representante: ".$datos_compra['supplier_representante']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_compra['supplier_telefono']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: ".$datos_compra['supplier_provincia'].", ".$datos_compra['supplier_ciudad'].", ".$datos_compra['supplier_direccion']),0,'C',false);
        }

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

        $pdf->Ln(3);
        $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);

        /*----------  Seleccionando detalles de la compra  ----------*/
		$compra_detalle=$ins_compra->seleccionarDatos("Normal","compra_detalle WHERE compra_codigo='".$datos_compra['compra_codigo']."'","*",0);
        $compra_detalle=$compra_detalle->fetchAll();
        
        foreach($compra_detalle as $detalle){
            $pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$detalle['compra_detalle_descripcion']),0,'C',false);
            $pdf->Cell(18,4,iconv("UTF-8", "ISO-8859-1",$detalle['compra_detalle_cantidad']),0,0,'C');
            $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['compra_detalle_precio_compra'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),0,0,'C');
            $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($detalle['compra_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)),0,0,'C');
            $pdf->Ln(4);
            $pdf->Ln(3);
        }

        $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR:"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),0,0,'C');

        $pdf->Ln(5);
        
        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO:"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_pagado'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),0,0,'C');

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","CAMBIO:"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",MONEDA_SIMBOLO.number_format($datos_compra['compra_cambio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE),0,0,'C');

        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Recibo de Compra"),'',0,'C');

        $pdf->Ln(9);

        $pdf->Code128(5,$pdf->GetY(),$datos_compra['compra_codigo'],70,20);
        $pdf->SetXY(0,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',14);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_compra['compra_codigo']),0,'C',false);
        
		$pdf->Output("I","Ticket_COMPRA_Nro".$datos_compra['compra_id'].".pdf",true);

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