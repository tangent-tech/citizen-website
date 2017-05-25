<?php
die('not now!');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('./PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

define("REAL_RUN_API",				true);

//$OnlyImport = array("AR5014-04E", "AR5000-50E", "AR5000-68A", "AR5004-59H");
$CategoryIDList = array(
	'O, SUPER TITANIUM'				=> 275464,//Eco-Drive Satellite Wave-GPS
	'MARINE'						=> 274857,//PROMASTER
	'SKY'							=> 274858,//PROMASTER
	'LAND'							=> 274859,//PROMASTER
	'ABMILUNA'						=> 275009,//Citizen L
	'REGULAR'						=> 275010,//Citizen L
	
	//'AUTOMATIC'					=> 275465,//Mechanical
	'AUTOMATIC_men'					=> 283025,
	'AUTOMATIC_lady'				=> 283026,
	'AUTOMATIC_pair'				=> 283027,
	
	'ECO-DRIVE 光動能_xc'				=> 275466,//xC
	'RADIO-CONTROLLED 電波時計_xc'	=> 275467,//xC
	
	//'ECO-DRIVE 光動能_ec'			=> 275468,//Eco-Drive
	'ECO-DRIVE 光動能_ec_men'			=> 283004,//Eco-Drive
	'ECO-DRIVE 光動能_ec_lady'		=> 283023,//Eco-Drive
	'ECO-DRIVE 光動能_ec_pair'		=> 283024,//Eco-Drive
	
	'SUPER TITANIUM 超級鈦_ec'		=> 275469,//Eco-Drive
	'RADIO-CONTROLLED 電波時計_ec'	=> 275470,//Eco-Drive,
	'ECO-DRIVE_ONE'					=> 282869
);

$Source = BASEWEBDIR . "/import/product_details_20161203_updated_by_aveego.xls";

$inputFileType = PHPExcel_IOFactory::identify($Source);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($Source);
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$sheetData = $objPHPExcel->getActiveSheet()->toArray();

$TotalCount = 1;
$EditCount = 0;
$AddCount = 0;
$FailCount = 0;

$PairWatchList = array();

foreach($sheetData as $key => $row){
	if($key > 0){
			
		$ProductsInfo = array();
		if(trim($row[2]) != "")
			ExcelEatColumnVer2($row, $ProductsInfo);

		$relatedProducts[$ProductsInfo['product_code']] = array($ProductsInfo['product_code']);
		for ($i = 1; $i <= 9; $i++) {
			if ($ProductsInfo['related_product_id_' . $i] != '')
				array_push($relatedProducts[$ProductsInfo['product_code']], $ProductsInfo['related_product_id_' . $i]);
		}
		sort($relatedProducts[$ProductsInfo['product_code']]);
		
		$ProductEditPara = array();
		$ProductEditPara['is_enable']								= 'Y';
		$ProductEditPara['product_key']								= 'product_code';
		$ProductEditPara['product_code']							= trim(strval($ProductsInfo['product_code']));
		$ProductEditPara['object_name']								= $ProductEditPara['product_code'];
		$ProductEditPara['product_custom_int_1']					= $ProductsInfo['product_custom_int_1'];
		$ProductEditPara['product_desc[1]']							= trim(strval($ProductsInfo['product_desc[1]']));
		$ProductEditPara['product_desc[2]']							= trim(strval($ProductsInfo['product_desc[2]']));
		$ProductEditPara['product_custom_int_10']					= trim(strval($ProductsInfo['product_custom_int_10']));
		$ProductEditPara['product_custom_int_11']					= trim(strval($ProductsInfo['product_custom_int_11']));
		$ProductEditPara['product_price_v2[1]']						= trim(strval($ProductsInfo['product_price_v2[1]']));
		$ProductEditPara['product_brand_name']						= $relatedProducts[$ProductsInfo['product_code']][0];
		
		$ProductEditPara['product_custom_text_1[1]']				= trim(strval($ProductsInfo['product_custom_text_1[1]']));
		$ProductEditPara['product_custom_text_1[2]']				= trim(strval($ProductsInfo['product_custom_text_1[2]']));
		$ProductEditPara['product_custom_text_2[1]']				= trim(strval($ProductsInfo['product_custom_text_2[1]']));
		$ProductEditPara['product_custom_text_2[2]']				= trim(strval($ProductsInfo['product_custom_text_2[2]']));
		$ProductEditPara['product_custom_text_3[1]']				= trim(strval($ProductsInfo['product_custom_text_3[1]']));
		$ProductEditPara['product_custom_text_3[2]']				= trim(strval($ProductsInfo['product_custom_text_3[2]']));
		$ProductEditPara['product_custom_text_4[1]']				= trim(strval($ProductsInfo['product_custom_text_4[1]']));
		$ProductEditPara['product_custom_text_4[2]']				= trim(strval($ProductsInfo['product_custom_text_4[2]']));
		$ProductEditPara['product_custom_text_5[1]']				= trim(strval($ProductsInfo['product_custom_text_5[1]']));
		$ProductEditPara['product_custom_text_5[2]']				= trim(strval($ProductsInfo['product_custom_text_5[2]']));
		$ProductEditPara['product_custom_text_6[1]']				= trim(strval($ProductsInfo['product_custom_text_6[1]']));
		$ProductEditPara['product_custom_text_6[2]']				= trim(strval($ProductsInfo['product_custom_text_6[2]']));

		if(intval($ProductsInfo['product_custom_int_2']) > 0)
			$ProductEditPara['product_custom_int_2']				= 1;							//new
		if(intval($ProductsInfo['product_custom_int_3']) > 0)
			$ProductEditPara['product_custom_int_3']				= 1;							//limited
		if(intval($ProductsInfo['product_custom_int_4']) > 0)
			$ProductEditPara['product_custom_int_4']				= 1;							//calendar
		if(intval($ProductsInfo['product_custom_int_5']) > 0)
			$ProductEditPara['product_custom_int_5']				= 1;							//chronograph
		if(intval($ProductsInfo['product_custom_int_6']) > 0)
			$ProductEditPara['product_custom_int_6']				= 1;							//alarm
		if(intval($ProductsInfo['product_custom_int_7']) > 0)
			$ProductEditPara['product_custom_int_7']				= 1;							//duratect
		if(intval($ProductsInfo['product_custom_int_8']) > 0)
			$ProductEditPara['product_custom_int_8']				= 1;							//luminous

		$ProductEditPara['product_custom_date_1']					= trim(strval($ProductsInfo['product_custom_date_1']));
		$ProductEditPara['product_custom_text_7[1]']				= trim(strval($ProductsInfo['product_custom_text_7[1]']));
		$ProductEditPara['product_custom_text_7[2]']				= trim(strval($ProductsInfo['product_custom_text_7[2]']));
		$ProductEditPara['product_custom_double_1']					= doubleval($ProductsInfo['product_custom_double_1']);
		$ProductEditPara['product_custom_double_2']					= doubleval($ProductsInfo['product_custom_double_2']);

		$ProductEditPara['product_custom_text_12[1]']				= trim(strval($ProductsInfo['product_custom_text_12[1]']));
		$ProductEditPara['product_custom_text_12[2]']				= trim(strval($ProductsInfo['product_custom_text_12[2]']));

		$ProductEditPara['product_custom_text_8[1]']				= trim(strval($ProductsInfo['product_custom_text_8[1]']));
		$ProductEditPara['product_custom_text_8[2]']				= trim(strval($ProductsInfo['product_custom_text_8[2]']));

		$ProductEditPara['product_custom_text_9[1]']				= trim(strval($ProductsInfo['product_custom_text_9[1]']));
		$ProductEditPara['product_custom_text_9[2]']				= trim(strval($ProductsInfo['product_custom_text_9[2]']));

		if(strtoupper(trim($ProductsInfo['product_custom_text_10[1]'])) != 'NULL' && trim($ProductsInfo['product_custom_text_10[1]']) != ""){
			$ProductEditPara['product_custom_text_10[1]']			= trim($ProductsInfo['product_custom_text_10[1]']);				//youtube 01
			$ProductEditPara['product_custom_text_10[2]']			= trim($ProductsInfo['product_custom_text_10[2]']);				//youtube 01
		}
		if(strtoupper(trim($ProductsInfo['product_custom_text_11[1]'])) != 'NULL' && trim($ProductsInfo['product_custom_text_11[1]']) != ""){
			$ProductEditPara['product_custom_text_11[1]']			= trim($ProductsInfo['product_custom_text_11[2]']);				//youtube 02
			$ProductEditPara['product_custom_text_11[2]']			= trim($ProductsInfo['product_custom_text_11[2]']);				//youtube 02
		}
		
		$ProductEditPara['product_custom_text_14[1]']	= trim(strval($ProductsInfo['product_custom_text_14[1]']));
		$ProductEditPara['product_custom_text_14[2]']	= trim(strval($ProductsInfo['product_custom_text_14[2]']));
		$ProductEditPara['product_custom_text_15[1]']	= trim(strval($ProductsInfo['product_custom_text_15[1]']));
		$ProductEditPara['product_custom_text_15[2]']	= trim(strval($ProductsInfo['product_custom_text_15[2]']));
		$ProductEditPara['product_custom_text_16[1]']	= trim(strval($ProductsInfo['product_custom_text_16[1]']));
		$ProductEditPara['product_custom_text_16[2]']	= trim(strval($ProductsInfo['product_custom_text_16[2]']));
		
		if($ProductsInfo['pair_watch_code'] != ""){

			$key = strval($ProductsInfo['product_code']) . "," . strval($ProductsInfo['pair_watch_code']);
			$key2 = strval($ProductsInfo['pair_watch_code']) . "," . strval($ProductsInfo['product_code']);

			if(!is_array($PairWatchList[$key]) && !is_array($PairWatchList[$key2])){
				$PairWatchList[$key] = array();
				$ProductEditPara['product_custom_text_13[1]'] = $key;
				$ProductEditPara['product_custom_text_13[2]'] = $key;
			}
			
			else if(is_array($PairWatchList[$key])){
				$ProductEditPara['product_custom_text_13[1]'] = $key;
				$ProductEditPara['product_custom_text_13[2]'] = $key;
			}
			
			else if(is_array($PairWatchList[$key2])){
				$ProductEditPara['product_custom_text_13[1]'] = $key2;
				$ProductEditPara['product_custom_text_13[2]'] = $key2;
			}

		}

		$ProductEditPara['product_category_id_list'] = '';
		if($ProductsInfo['eco_drive_category_name'] != ""){
			
			$Key = $ProductsInfo['eco_drive_category_name'] . "_ec";

			if($Key == "ECO-DRIVE 光動能_ec"){
				
				if(intval($ProductsInfo['product_custom_int_1']) == 1)
					$Key = $ProductsInfo['eco_drive_category_name'] . "_ec_men";
				
				elseif(intval($ProductsInfo['product_custom_int_1']) == 2)
					$Key = $ProductsInfo['eco_drive_category_name'] . "_ec_lady";
				
				elseif (intval($ProductsInfo['product_custom_int_1']) == 0)
					$Key = $ProductsInfo['eco_drive_category_name'] . "_ec_pair";
					
			}
			
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $Key ] . ", ";
			
		}
		if($ProductsInfo['citizen_l_category_name'] != ""){
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $ProductsInfo['citizen_l_category_name'] ] . ", ";
		}
		if($ProductsInfo['promaster_category_name'] != ""){
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $ProductsInfo['promaster_category_name'] ] . ", ";
		}
		if($ProductsInfo['wave_gps_category_name'] != ""){
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $ProductsInfo['wave_gps_category_name'] ] . ", ";
		}
		if($ProductsInfo['xc_category_name'] != ""){
			$Key = $ProductsInfo['xc_category_name'] . "_xc";
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $Key ] . ", ";
		}
		if($ProductsInfo['mechanical_category_name'] != ""){
			
			if(intval($ProductsInfo['product_custom_int_1']) == 1)
				$Key = $ProductsInfo['mechanical_category_name'] . "_men";

			elseif(intval($ProductsInfo['product_custom_int_1']) == 2)
				$Key = $ProductsInfo['mechanical_category_name'] . "_lady";

			elseif (intval($ProductsInfo['product_custom_int_1']) == 0)
				$Key = $ProductsInfo['mechanical_category_name'] . "_pair";
			
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList[ $Key ] . ", ";
			
		}
		if($ProductsInfo['eco_drive_one_category_name'] != "") {
			$ProductEditPara['product_category_id_list'] .= $CategoryIDList['ECO-DRIVE_ONE'] . ", ";
		}
		
		$ProductEditPara['product_category_id_list'] = substr($ProductEditPara['product_category_id_list'], 0, -2); 

		//Edit
		if(REAL_RUN_API){

			$ApiResult = ApiQuery('obj_man/product_edit.php', __LINE__, '', false, false, $ProductEditPara);

			if($ApiResult->result == "Fail"){

				$AddProductApiResult = ApiQuery('obj_man/product_add.php', __LINE__, '', false, false, $ProductEditPara);

				if($AddProductApiResult->result == "Success"){
					echo "Add Success <br/>";
					echo $ProductEditPara["product_code"];
					$AddCount++;
				}
				else {
					echo "Add Fail <br/>";
					var_dump($ProductEditPara);
					$FailCount++;
				}
			}
			else {
				echo "Edit Success <br/>";
				echo $ProductEditPara["product_code"];
				$EditCount++;
			}

		}
		else {
			var_dump($ProductEditPara);
			$EditCount++;
		}

		if($TotalCount % 60 == 0)
			sleep(7);
		
		$TotalCount++;
		
		echo "<hr/>";
	}
}

echo "Total Update:" . $EditCount . "<br/>";
echo "Total Add:" . $AddCount . "<br/>";
echo "Total Fail:" . $FailCount . "<br/>";

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
?>