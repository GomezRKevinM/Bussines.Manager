<?php
	
	$peticion_ajax=true;
	$code=(isset($_GET['code'])) ? $_GET['code'] : 0;

	/*---------- Incluyendo configuraciones ----------*/
	require_once "../../config/app.php";
    require_once "../../autoload.php";

	/*---------- Instancia al controlador venta ----------*/
	use app\controllers\CodeController;

	$ins_code = new CodeController();

	$datos_codigo=$ins_code->seleccionarDatos("Normal","codebar WHERE (codigo_codigo='$code')","*",0);

	if($datos_codigo->rowCount()==1){

		/*---------- Datos del codigo ----------*/
		$datos_codigo=$datos_codigo->fetch();


		require "./code128.php";
	
		$pdf = new PDF_Code128('P','mm','Letter');
		$pdf->SetMargins(17,17,17);
		$pdf->AddPage();

		$pdf->SetFillColor(39,39,51);
		$pdf->SetDrawColor(23,83,201);
        $pdf->Code128(72,$pdf->GetY(),$datos_codigo['codigo_codigo'],70,20);
        $pdf->SetXY(12,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_codigo['codigo_codigo']),0,'C',false);

		$pdf->Output("I","Codigo_Nro".$datos_codigo['codigo_id'].".pdf",true);

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
                <p class="subtitle has-text-white">No hemos encontrado datos del codigo</p>
            </div>
        </section>
    </div>
	<?php include '../views/inc/script.php'; ?>
</body>
</html>
<?php } ?>