<?php
die("EXIT");

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$json = file_get_contents(BASEDIR . "/htmlsafe/product_import_new.log");
$products = json_decode($json);
$Count = 0;
$BigMediaCount = 0;

$relatedProducts = array();

foreach ($products as $P) {
	
	if(intval($P->product_custom_int_1) == 0) {
		
		$ProductToArray = array();
		foreach($P as $k=>$v){
			if($k == "product_desc[1]")
				$ProductDesc_1 = $v;
			if($k == "product_desc[2]")
				$ProductDesc_2 = $v;
			if($k == "product_price_v2[1]")
				$ProductPrice = $v;
		}

		
		$ProductEditPara = array();
		$ProductEditPara['product_code']				= trim(strval($P->product_code));
		$ProductEditPara['product_desc[1]']				= $ProductDesc_1;
		$ProductEditPara['product_desc[2]']				= $ProductDesc_2;
		$ProductEditPara['product_price_v2[1]']			= $ProductPrice;
		//$ProductEditPara['product_custom_int_9']		= intval($RP->objects->product[0]->object_link_id);
		
		$Search = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . 0 .
							'&security_level=' . 0 .
							'&page_no=' . 1 .
							'&objects_per_page=' . 1 .
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&object_name=' . trim(strval($P->product_code))
							);
		$ProductID = intval($Search->objects->product[0]->object_id);
		$ProductEditPara['product_id']					= intval($Search->objects->product[0]->object_id);
		$ProductEditPara['product_category_id_list']	= intval($Search->objects->product[0]->parent_object_id);
		
		var_dump($ProductEditPara);
		//echo strval($P->pair_watch_code) . "<br/>";
		echo "<hr/>";
/*

		$Search = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . 0 .
							'&security_level=' . 0 .
							'&page_no=' . 1 .
							'&objects_per_page=' . 1 .
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&object_name=' . trim(strval($P->product_code))
							);

		if(intval($Search->total_no_of_objects) > 0){

			$RP = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . 0 .
							'&security_level=' . 0 .
							'&page_no=' . 1 .
							'&objects_per_page=' . 1 .
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&object_name=' . trim(strval($P->pair_watch_code))
							);
			
			$ProductID = intval($Search->objects->product[0]->object_id);
			$ProductEditPara = array();
			$ProductEditPara['product_id']					= intval($Search->objects->product[0]->object_id);
			$ProductEditPara['product_category_id_list']	= intval($Search->objects->product[0]->parent_object_id);
			$ProductEditPara['product_code']				= trim(strval($P->product_code));
			$ProductEditPara['product_desc[1]']				= $ProductDesc_1;
			$ProductEditPara['product_desc[2]']				= $ProductDesc_2;
			$ProductEditPara['product_price_v2[1]']			= $ProductPrice;
			$ProductEditPara['product_custom_int_9']		= intval($RP->objects->product[0]->object_link_id);
			
			var_dump($ProductEditPara);
			//$ApiResult = ApiQuery('obj_man/product_edit.php', __LINE__, '', false, false, $ProductEditPara);

			echo "<hr/>";

		}
 */
		$Count++;

	}

}
echo "Total:" . $Count . "<br/>";
?>