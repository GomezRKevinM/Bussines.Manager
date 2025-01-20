<div class="container is-fluid mb-6">
	<h1 class="title">Codigo</h1>
	<h2 class="subtitle"><i class="bi bi-bar-chart-steps"></i> &nbsp; Lista de Codigos</h2>
</div>
<div class="container is-fluid">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\CodeController;

		$insCode = new CodeController();
        require "./app/pdf/code128.php";
        $pdf = new PDF_Code128('P','mm','Letter');

		echo $insCode->listarCode($url[1],15,$url[0],"");

		include "./app/views/inc/print_invoice_script.php";
	?>
</div>