<?php
    require "../../pdf/code128.php";

    $pdf = new PDF_Code128('P','mm','Letter');
    $pdf->SetMargins(17,17,17);
    $pdf->AddPage();

?>
