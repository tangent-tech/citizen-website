<?php

die("EXIT");

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

	$Products = ApiQuery('product_search.php', __LINE__,
						 'product_category_id=' . PRODUCT_ROOT_ID .
						 '&product_code=' . urlencode($TL) . 
						 '&security_level=' . 0 .
						 '&page_no=' . 1 .
						 '&objects_per_page=' . PRODUCT_SEARCH_PER_PAGE . 
						 '&lang_id=' . $CurrentLang->language_root->language_id .
						 '&include_sub_category=Y' .
						 '&include_media_details=Y' .
						 '&media_page_no=1' .
						 '&media_per_page=1'
						 //,false, true
						);
	
	foreach($Products->objects->product as $P){
		echo $P->product_code . "<br/>";
		echo "media:" . intval($P->media_list->media[0]->media_big_file_id) . "<br/>";
		echo "<hr/>";
	}
	
die();
 ?>