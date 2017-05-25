<?php

//$a = array();
//$a[400] = array();
//$a[300] = array();
//$a[500] = array();
//
//array_push($a[500], 777);
//array_push($a[500], 777);
//array_push($a[300], 77);
//array_push($a[400], 7);
//
//var_dump($a);
//
//foreach ($a as $p)
//	foreach ($p as $b)
//	echo $b . " ";
//
//die();

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$WarrantyDetail = warranty::GetWarrantyDetailByID($_SESSION["WarrantyID"]);
$smarty->assign('WarrantyDetail', $WarrantyDetail);

$smarty->display('email_template/warranty.tpl');

die();

echo warranty::GenerateRefNo();
die();

$TestList = array();
$Count = 0;

$json = file_get_contents(BASEDIR . "/htmlsafe/product_import_new.log");
$JsonProducts = json_decode($json);

foreach($JsonProducts as $J){
	if($J->pair_watch_code != ""){
		
		$key = strval($J->product_code) . "," . strval($J->pair_watch_code);
		$key2 = strval($J->pair_watch_code) . "," . strval($J->product_code);
		if(!is_array($TestList[$key]) && !is_array($TestList[$key2])){
			$TestList[$key] = array();
			array_push($TestList[$key], strval($J->product_code));
			array_push($TestList[$key], strval($J->pair_watch_code));
		}
		
		$Count++;
	}
}

foreach($TestList as $k=>$v){
	foreach($v as $p){


		$Products = ApiQuery('product_search.php', __LINE__,
							 'product_category_id=' . PRODUCT_ROOT_ID .
							 '&product_code=' . urlencode($p) . 
							 '&security_level=' . 0 .
							 '&page_no=' . 1 .
							 '&objects_per_page=' . 1 . 
							 '&lang_id=' . 1 .
							 '&include_sub_category=Y'
							);
		if(count($Products->objects->product) > 0){

			$TempProduct = ApiQuery('product_get_info.php', __LINE__,
								'link_id=' . $Products->objects->product[0]->object_link_id .
								'&lang_id=' . 2 .
								'&currency_id=' . $CurrentCurrency->currency->currency_id
								);
			
			$ProductEditPara = array();
			$ProductEditPara['product_id']					= intval($Products->objects->product[0]->object_id);
			$ProductEditPara['product_category_id_list']	= intval($Products->objects->product[0]->parent_object_id);
			$ProductEditPara['product_code']				= trim(strval($Products->objects->product[0]->product_code));
			$ProductEditPara['product_desc[1]']				= $Products->objects->product[0]->product_desc;
			$ProductEditPara['product_desc[2]']				= $TempProduct->product->product_desc;
			$ProductEditPara['product_price_v2[1]']			= $Products->objects->product[0]->product_price;
			$ProductEditPara['product_custom_text_13[1]']	= $k;
			$ProductEditPara['product_custom_text_13[2]']	= $k;

			$ApiResult = ApiQuery('obj_man/product_edit.php', __LINE__, '', false, false, $ProductEditPara);

		}


	}
}
die();
 ?>