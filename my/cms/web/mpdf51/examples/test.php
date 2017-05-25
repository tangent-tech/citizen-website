<?php
include("../mpdf.php");
$mpdf=new mPDF();

$mpdf->debug = true;

$mpdf->WriteHTML("Hallo World");
$mpdf->Output();
?>