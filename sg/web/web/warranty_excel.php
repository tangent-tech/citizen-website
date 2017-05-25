<?php	
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$smarty->assign("MyJS", "WarrantyExcel");

if(	!isset($_POST["admin_username"]) && trim($_POST["admin_username"]) != WARRANTY_EXCEL_USERNAME
	&& !isset($_POST["admin_password"]) && trim($_POST["admin_password"]) != WARRANTY_EXCEL_PASSWORD ){
	
	$smarty->display('1/warranty_excel.tpl');
	die();
}

else if( isset($_POST["admin_username"]) && trim($_POST["admin_username"]) != WARRANTY_EXCEL_USERNAME
		 && isset($_POST["admin_password"]) && trim($_POST["admin_password"]) != WARRANTY_EXCEL_PASSWORD ){
	
	$smarty->assign("ErrorMsg", "Login Fail.");
	
	$smarty->display('1/warranty_excel.tpl');
	die();
}

else if( trim($_POST["admin_username"]) == WARRANTY_EXCEL_USERNAME && trim($_POST["admin_password"]) == WARRANTY_EXCEL_PASSWORD ){
	
	$ExcelTitle = WARRANTY_EXCEL_TITLE . date("Ymd");
	$ExcelFileName = $ExcelTitle . ".xlsx";
	$ExpiresDate = date("D d M Y H:i:s e");
	$LastModifiedDate = date("D d M Y H:i:s e");
	
	$WarrantyList = warranty::GetConfirmWarrantyListToExcel();
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator(CLIENT_NAME)
								 ->setLastModifiedBy(CLIENT_NAME)
								 ->setTitle($ExcelTitle)
								 ->setSubject($ExcelTitle);
	
	if(count($WarrantyList) > 0){
		
		$pColumn = 0;
		$pRow = 1;
		foreach($WarrantyList[0] as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($pColumn, $pRow, $k);
			$pColumn++;
		}
		$pRow++;

		
		foreach($WarrantyList as $value){

			$pColumn = 0;
			foreach($value as $k=>$v){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($pColumn, $pRow, $v);
				$pColumn++;
			}
			$pRow++;

		}
		
	}
	
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $ExcelFileName . '"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: ' . $ExpiresDate); // Date in the past
	header ('Last-Modified: ' . $LastModifiedDate); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit();
}
?>