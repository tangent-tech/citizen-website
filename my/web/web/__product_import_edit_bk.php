<?php
die("EXIT");

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$json = file_get_contents(BASEDIR . "/htmlsafe/product_import.json");
$products = json_decode($json);
$Count = 0;
$BigMediaCount = 0;

$relatedProducts = array();

$brand_list = ApiQuery(	'product_brand_list.php', __LINE__,
						'lang_id=' . $CurrentLang->language_root->language_id
						);

foreach ($products as $P) {

	$ThumbnailURL = REMOTE_BASEURL . "/import/update_images/small/" . trim(strval($P->product_code)) . "_m.png";

	if(UR_exists($ThumbnailURL)) {
	}
	else {
		
		$ProductToArray = array();
		foreach($P as $k=>$v){
			if($k == "product_desc[1]")
				$ProductDesc_1 = $v;
			if($k == "product_desc[2]")
				$ProductDesc_2 = $v;
			if($k == "product_price_v2[1]")
				$ProductPrice = $v;
		}
		
		$ProductToArray["related_product_id_1"] = strval($P->related_product_id_1);
		$ProductToArray["related_product_id_2"] = strval($P->related_product_id_2);
		$ProductToArray["related_product_id_3"] = strval($P->related_product_id_3);
		$ProductToArray["related_product_id_4"] = strval($P->related_product_id_4);
		$ProductToArray["related_product_id_5"] = strval($P->related_product_id_5);
		$ProductToArray["related_product_id_6"] = strval($P->related_product_id_6);
		$ProductToArray["related_product_id_7"] = strval($P->related_product_id_7);
		$ProductToArray["related_product_id_8"] = strval($P->related_product_id_8);
		$ProductToArray["related_product_id_9"] = strval($P->related_product_id_9);
		
		echo "Start Search: " .  trim(strval($P->product_code)) . "<br/>";
		
		$Search = ApiQuery('product_search.php', __LINE__,
							'product_category_id=' . 0 .
							'&security_level=' . 0 .
							'&page_no=' . 1 .
							'&objects_per_page=' . 1 .
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&object_name=' . trim(strval($P->product_code))
							);

		if(intval($Search->total_no_of_objects) > 0){
			
			$relatedProducts[trim(strval($P->product_code))] = array(trim(strval($P->product_code)));
			for ($i = 1; $i <= 9; $i++) {
				if ($ProductToArray['related_product_id_' . $i] != '')
					array_push($relatedProducts[trim(strval($P->product_code))], $ProductToArray['related_product_id_' . $i]);
			}
			sort($relatedProducts[trim(strval($P->product_code))]);
			$BrandName = $relatedProducts[trim(strval($P->product_code))][0];

			$ProductID = intval($Search->objects->product[0]->object_id);
			$ProductEditPara = array();
			$ProductEditPara['product_id']					= intval($Search->objects->product[0]->object_id);
			$ProductEditPara['product_category_id_list']	= intval($Search->objects->product[0]->parent_object_id);
			$ProductEditPara['product_code']				= trim(strval($P->product_code));
			$ProductEditPara['product_desc[1]']				= $ProductDesc_1;
			$ProductEditPara['product_desc[2]']				= $ProductDesc_2;
			$ProductEditPara['product_price_v2[1]']			= $ProductPrice;
			$ProductEditPara['product_brand_name']			= $BrandName;
			
			foreach($brand_list->product_brand_list->product_brand as $PB){
				if(strval($PB->object_name) == $ProductEditPara['brand_name']){
//					$ProductEditPara['product_brand_id'] = intval($PB->object_id);
					break;
				}
			}

			$ApiResult = ApiQuery('obj_man/product_edit_temp.php', __LINE__, '', false, false, $ProductEditPara);
			if($ApiResult->result != "Success"){
				echo trim(strval($P->product_code)) . " update thumbnail fail.<br/>";
			}

			echo "Brand:" . $ProductEditPara['brand_name'] . "<br/>";
			echo "Brand ID:" . $ProductEditPara['product_brand_id'];
			echo "<hr/>";

			/***
			 * Media handle ( All done now. )
			 */
//			$MediaURLPath = REMOTE_BASEURL . "/import/update_images/big/" . trim(strval($P->product_code)) . ".jpg";
//			if(UR_exists($MediaURLPath)){
//
//				$MediaAddPara = array();
//				$MediaAddPara['object_id'] = intval($Search->objects->product[0]->object_id);
//				$MediaAddPara['media_url'] = $MediaURLPath;
//				$MediaAddPara['security_level'] = '0';
//				$Media = ApiQuery('obj_man/media_add.php', __LINE__, '', false, false, $MediaAddPara);
//				
//				if($Media->result != "Success"){
//					echo trim(strval($P->product_code)) . " update media fail.<br/>";
//				}
//				
//				$BigMediaCount++;
//
//			}

			$Count++;

		}

	}

}

echo "Total:" . $Count . "<br/>";
die();

function UR_exists($url){
   $headers = get_headers($url);
   return stripos($headers[0],"200 OK")?true:false;
}
?>