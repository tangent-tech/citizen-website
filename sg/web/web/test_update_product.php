<?php
die("EXIT");

require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

$Source = BASEWEBDIR . "/import/product_details_20161130_updated_by_aveego.xls";

$inputFileType = PHPExcel_IOFactory::identify($Source);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($Source);
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$sheetData = $objPHPExcel->getActiveSheet()->toArray();

$CountReadData = 0;

$ReturnJson = array();

foreach($sheetData as $key => $row){
	if($key > 0){
			
		$ProductAddPara = array();
		$ProductAddPara['is_enable']				= 'Y';

		if(trim($row[2]) != "")
			ExcelEatColumnVer2($row, $ProductAddPara);
		
		if($CountReadData % 60 == 0)
			sleep(5);
		
		$Search = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . 0 .
							'&security_level=' . 0 .
							'&page_no=' . 1 .
							'&objects_per_page=' . 1 .
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&product_code=' . urlencode(trim($ProductAddPara["product_code"]))
							//,false, true
							);


		$ProductAddPara["product_id"] = intval($Search->objects->product[0]->object_id);

		array_push($ReturnJson, $ProductAddPara);
		var_dump($ProductAddPara);

		$CountReadData++;
		echo "<hr/>";
	}
}
echo "Script End...<hr/>Total Insert:" . $CountReadData . "<br/>";
echo "<hr/>";

$fp = fopen(BASEDIR . 'htmlsafe/product_details_20161130_updated_by_aveego.json', "a");
fwrite($fp, json_encode($ReturnJson));
fclose($fp);

function ExcelEatColumnVer2($row, &$ProductAddPara){	

	$ProductAddPara['object_name']							= trim($row[2]);				//watch_code
	$ProductAddPara['product_code']							= trim($row[2]);				//watch_code
	$ProductAddPara['product_price_v2[1]']					= doubleval(intval($row[3]));	//price HKD

	//mens or ladies or pair
	if(trim($row[4]) == "mens")
		$ProductAddPara['product_custom_int_1']					= 1;
	else if(trim($row[4]) == "ladies")
		$ProductAddPara['product_custom_int_1']					= 2;
	else
		$ProductAddPara['product_custom_int_1']					= 0;

	$ProductAddPara['pair_watch_code']						= strtoupper(trim($row[5]));	//Pair Watch Code

	$ProductAddPara['eco_drive_category_name']				= strtoupper(trim($row[6]));	//Eco-Drive Category Name
	$ProductAddPara['citizen_l_category_name']				= strtoupper(trim($row[7]));	//Citizen L Category Name
	$ProductAddPara['promaster_category_name']				= strtoupper(trim($row[8]));	//Promaster Category Name
	$ProductAddPara['wave_gps_category_name']				= strtoupper(trim($row[9]));	//Eco-Drive Satellite Wave-GPS Category Name
	$ProductAddPara['xc_category_name']						= strtoupper(trim($row[10]));	//xC Category Name

	if(trim($row[14]) == "Automatic")
		$ProductAddPara['mechanical_category_name']			= strtoupper("Automatic");		//Mechanical Category Name

	$ProductAddPara['product_custom_text_1[1]']				= trim($row[14]);				//kudo
	$ProductAddPara['product_custom_text_1[2]']				= trim($row[15]);				//kudo
	$ProductAddPara['product_custom_text_2[1]']				= trim($row[16]);				//denpa
	$ProductAddPara['product_custom_text_2[2]']				= trim($row[17]);				//denpa
	$ProductAddPara['product_custom_text_3[1]']				= trim($row[18]);				//case
	$ProductAddPara['product_custom_text_3[2]']				= trim($row[19]);				//case
	$ProductAddPara['product_custom_text_4[1]']				= trim($row[20]);				//strap
	$ProductAddPara['product_custom_text_4[2]']				= trim($row[21]);				//strap
	$ProductAddPara['product_custom_text_5[1]']				= trim($row[22]);				//water resistant
	$ProductAddPara['product_custom_text_5[2]']				= trim($row[23]);				//water resistant
	$ProductAddPara['product_custom_text_6[1]']				= trim($row[24]);				//glass
	$ProductAddPara['product_custom_text_6[2]']				= trim($row[25]);				//glass

	if(trim($row[26]) != "")
		$ProductAddPara['product_custom_int_2']				= 1;							//new
	if(trim($row[27]) != "")
		$ProductAddPara['product_custom_int_3']				= 1;							//limited
	if(trim($row[28]) != "")
		$ProductAddPara['product_custom_int_4']				= 1;							//calendar
	if(trim($row[29]) != "")
		$ProductAddPara['product_custom_int_5']				= 1;							//chronograph
	if(trim($row[30]) != "")
		$ProductAddPara['product_custom_int_6']				= 1;							//alarm
	if(trim($row[31]) != "")
		$ProductAddPara['product_custom_int_7']				= 1;							//duratect
	if(trim($row[32]) != "")
		$ProductAddPara['product_custom_int_8']				= 1;							//luminous

	$ProductAddPara['product_custom_date_1']				= date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(trim($row[33])));//release date
	$ProductAddPara['product_custom_text_7[1]']				= trim($row[34]);				//caliber no
	$ProductAddPara['product_custom_text_7[2]']				= trim($row[34]);				//caliber no
	$ProductAddPara['product_custom_double_1']				= doubleval($row[35]);			//weight_g
	$ProductAddPara['product_custom_double_2']				= doubleval($row[36]);			//thickness_mm

	$ProductAddPara['product_custom_text_12[1]']			= trim($row[37]);				//case_size_mm
	$ProductAddPara['product_custom_text_12[2]']			= trim($row[37]);				//case_size_mm
	
	$ProductAddPara['product_custom_text_8[1]']				= trim($row[38]);				//surface processing
	$ProductAddPara['product_custom_text_8[2]']				= trim($row[39]);				//surface processing

	$ProductAddPara['product_desc[1]']						= trim($row[40]);				//spec
	$ProductAddPara['product_desc[2]']						= trim($row[41]);				//spec
	//$row[42] pdf en
	//$row[43] pdf tc
	$ProductAddPara['product_custom_text_9[1]']				= trim($row[44]);				//feature tag
	$ProductAddPara['product_custom_text_9[2]']				= trim($row[45]);				//feature tag
	
	if(strtoupper(trim($row[46])) != 'NULL' && trim($row[46]) != ""){
		$ProductAddPara['product_custom_text_10[1]']		= trim($row[46]);				//youtube 01
		$ProductAddPara['product_custom_text_10[2]']		= trim($row[46]);				//youtube 01
	}
	if(strtoupper(trim($row[47])) != 'NULL' && trim($row[47]) != ""){
		$ProductAddPara['product_custom_text_11[1]']		= trim($row[47]);				//youtube 02
		$ProductAddPara['product_custom_text_11[2]']		= trim($row[47]);				//youtube 02
	}

	$ProductAddPara['related_product_id_1'] = trim($row[49]);
	$ProductAddPara['related_product_id_2'] = trim($row[50]);
	$ProductAddPara['related_product_id_3'] = trim($row[51]);
	$ProductAddPara['related_product_id_4'] = trim($row[52]);
	$ProductAddPara['related_product_id_5'] = trim($row[53]);
	$ProductAddPara['related_product_id_6'] = trim($row[54]);
	$ProductAddPara['related_product_id_7'] = trim($row[55]);
	$ProductAddPara['related_product_id_8'] = trim($row[56]);
	$ProductAddPara['related_product_id_9'] = trim($row[57]);
	
	$ProductAddPara['product_custom_text_14[1]'] = trim($row[58]);							//Strap Display Word
	$ProductAddPara['product_custom_text_14[2]'] = trim($row[59]);							//Strap Display Word
	$ProductAddPara['product_custom_text_15[1]'] = trim($row[60]);							//Glass Display Word
	$ProductAddPara['product_custom_text_15[2]'] = trim($row[61]);							//Glass Display Word
	
	if(trim($row[62]) != "")
		$ProductAddPara['product_custom_int_10']				= 1;						//Flying Distance and Navigation Calculations
	
	if(trim($row[63]) != "")
		$ProductAddPara['product_custom_int_11']				= 1;						//Perpetual Calendar

}
?>