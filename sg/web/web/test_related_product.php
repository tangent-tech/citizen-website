<?php
die('not now!');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

$Source = BASEWEBDIR . "/import/product_details_20161203_updated_by_aveego.xls";

$inputFileType = PHPExcel_IOFactory::identify($Source);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($Source);
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$sheetData = $objPHPExcel->getActiveSheet()->toArray();

$products = array();
foreach($sheetData as $key => $row){
	if($key > 0){
			
		$ProductsInfo = array();
		if(trim($row[2]) != "")
			ExcelEatColumnVer2($row, $ProductsInfo);

		array_push($products, $ProductsInfo);
	}
}


$relatedProducts = array();

foreach ($products as $index => &$P) {
	$relatedProducts[$P['product_code']] = array($P['product_code']);
	for ($i = 1; $i <= 9; $i++) {
		if ($P['related_product_id_' . $i] != '')
			array_push($relatedProducts[$P['product_code']], $P['related_product_id_' . $i]);
	}
	sort($relatedProducts[$P['product_code']]);
	
	$P['brand_name'] = $relatedProducts[$P['product_code']][0];
}

foreach ($relatedProducts as $productCode => $related) {
	
	foreach ($related as $P) {
		if ($P != $productCode) {
			if (count(array_diff($related, $relatedProducts[$P])) > 0) {
				echo "Error detected: <br />";
				echo $productCode . ": "; printArray($related); echo "<br />";
				echo $P . ": "; printArray($relatedProducts[$P]); echo "<br />"; 
			}
		}
	}
}
echo "<hr />";
echo "BRAND NAME HERE" . "<br />";
//foreach ($products as $P) {
//	echo $P['product_code'] . ":" . $P['brand_name'] . "<br />";
//}
$fp = fopen(BASEDIR . 'htmlsafe/product_import.json', "a");
fwrite( $fp, json_encode($products) );
fclose($fp);

function printArray($array) {
	foreach ($array as $v)
		echo $v . " ";
}

function ExcelEatColumnVer2($row, &$ProductsInfo){	

	$ProductsInfo['object_name']							= trim($row[2]);				//watch_code
	$ProductsInfo['product_code']							= trim($row[2]);				//watch_code
	$ProductsInfo['product_price_v2[1]']					= doubleval(intval($row[3]));	//price HKD

	//mens or ladies or pair
	if(trim($row[4]) == "mens")
		$ProductsInfo['product_custom_int_1']				= 1;
	else if(trim($row[4]) == "ladies")
		$ProductsInfo['product_custom_int_1']				= 2;
	else
		$ProductsInfo['product_custom_int_1']				= 0;

	$ProductsInfo['pair_watch_code']						= strtoupper(trim($row[5]));	//Pair Watch Code

	$ProductsInfo['eco_drive_category_name']				= strtoupper(trim($row[6]));	//Eco-Drive Category Name
	$ProductsInfo['citizen_l_category_name']				= strtoupper(trim($row[7]));	//Citizen L Category Name
	$ProductsInfo['promaster_category_name']				= strtoupper(trim($row[8]));	//Promaster Category Name
	$ProductsInfo['wave_gps_category_name']					= strtoupper(trim($row[9]));	//Eco-Drive Satellite Wave-GPS Category Name
	$ProductsInfo['xc_category_name']						= strtoupper(trim($row[10]));	//xC Category Name
	$ProductsInfo['eco_drive_one_category_name']			= strtoupper(trim($row[12]));	//Eco Drive One Category Name

	if(trim($row[14]) == "Automatic")
		$ProductsInfo['mechanical_category_name']			= strtoupper("Automatic");		//Mechanical Category Name

	$ProductsInfo['product_custom_text_1[1]']				= trim($row[14]);				//kudo
	$ProductsInfo['product_custom_text_1[2]']				= trim($row[15]);				//kudo
	$ProductsInfo['product_custom_text_2[1]']				= trim($row[16]);				//denpa
	$ProductsInfo['product_custom_text_2[2]']				= trim($row[17]);				//denpa
	$ProductsInfo['product_custom_text_3[1]']				= trim($row[18]);				//case
	$ProductsInfo['product_custom_text_3[2]']				= trim($row[19]);				//case
	$ProductsInfo['product_custom_text_4[1]']				= trim($row[20]);				//strap
	$ProductsInfo['product_custom_text_4[2]']				= trim($row[21]);				//strap
	$ProductsInfo['product_custom_text_5[1]']				= trim($row[22]);				//water resistant
	$ProductsInfo['product_custom_text_5[2]']				= trim($row[23]);				//water resistant
	$ProductsInfo['product_custom_text_6[1]']				= trim($row[24]);				//glass
	$ProductsInfo['product_custom_text_6[2]']				= trim($row[25]);				//glass

	if(trim($row[26]) != "")
		$ProductsInfo['product_custom_int_2']				= 1;							//new
	if(trim($row[27]) != "")
		$ProductsInfo['product_custom_int_3']				= 1;							//limited
	if(trim($row[28]) != "")
		$ProductsInfo['product_custom_int_4']				= 1;							//calendar
	if(trim($row[29]) != "")
		$ProductsInfo['product_custom_int_5']				= 1;							//chronograph
	if(trim($row[30]) != "")
		$ProductsInfo['product_custom_int_6']				= 1;							//alarm
	if(trim($row[31]) != "")
		$ProductsInfo['product_custom_int_7']				= 1;							//duratect
	if(trim($row[32]) != "")
		$ProductsInfo['product_custom_int_8']				= 1;							//luminous

	$ProductsInfo['product_custom_date_1']					= date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(trim($row[33])));//release date
	$ProductsInfo['product_custom_text_7[1]']				= trim($row[34]);				//caliber no
	$ProductsInfo['product_custom_text_7[2]']				= trim($row[34]);				//caliber no
	$ProductsInfo['product_custom_double_1']				= doubleval($row[35]);			//weight_g
	$ProductsInfo['product_custom_double_2']				= doubleval($row[36]);			//thickness_mm

	$ProductsInfo['product_custom_text_12[1]']				= trim($row[37]);				//case_size_mm
	$ProductsInfo['product_custom_text_12[2]']				= trim($row[37]);				//case_size_mm
	
	$ProductsInfo['product_custom_text_8[1]']				= trim($row[38]);				//surface processing
	$ProductsInfo['product_custom_text_8[2]']				= trim($row[39]);				//surface processing

	$ProductsInfo['product_desc[1]']						= trim($row[40]);				//spec
	$ProductsInfo['product_desc[2]']						= trim($row[41]);				//spec
	//$row[42] pdf en
	//$row[43] pdf tc
	$ProductsInfo['product_custom_text_9[1]']				= trim($row[44]);				//feature tag
	$ProductsInfo['product_custom_text_9[2]']				= trim($row[45]);				//feature tag
	
	if(strtoupper(trim($row[46])) != 'NULL' && trim($row[46]) != ""){
		$ProductsInfo['product_custom_text_10[1]']			= trim($row[46]);				//youtube 01
		$ProductsInfo['product_custom_text_10[2]']			= trim($row[46]);				//youtube 01
	}
	if(strtoupper(trim($row[47])) != 'NULL' && trim($row[47]) != ""){
		$ProductsInfo['product_custom_text_11[1]']			= trim($row[47]);				//youtube 02
		$ProductsInfo['product_custom_text_11[2]']			= trim($row[47]);				//youtube 02
	}

	$ProductsInfo['related_product_id_1'] = trim($row[49]);
	$ProductsInfo['related_product_id_2'] = trim($row[50]);
	$ProductsInfo['related_product_id_3'] = trim($row[51]);
	$ProductsInfo['related_product_id_4'] = trim($row[52]);
	$ProductsInfo['related_product_id_5'] = trim($row[53]);
	$ProductsInfo['related_product_id_6'] = trim($row[54]);
	$ProductsInfo['related_product_id_7'] = trim($row[55]);
	$ProductsInfo['related_product_id_8'] = trim($row[56]);
	$ProductsInfo['related_product_id_9'] = trim($row[57]);
	
	$ProductsInfo['product_custom_text_14[1]'] = trim($row[58]);							//Strap Display Word
	$ProductsInfo['product_custom_text_14[2]'] = trim($row[59]);							//Strap Display Word
	$ProductsInfo['product_custom_text_15[1]'] = trim($row[60]);							//Glass Display Word
	$ProductsInfo['product_custom_text_15[2]'] = trim($row[61]);							//Glass Display Word
	
	if(trim($row[62]) != "")
		$ProductsInfo['product_custom_int_10']				= 1;						//Flying Distance and Navigation Calculations
	
	if(trim($row[63]) != "")
		$ProductsInfo['product_custom_int_11']				= 1;						//Perpetual Calendar
	
	$ProductsInfo['product_custom_text_16[1]']				= trim($row[64]);			//Thickness Notice Display
	$ProductsInfo['product_custom_text_16[2]']				= trim($row[65]);			//Thickness Notice Display

}