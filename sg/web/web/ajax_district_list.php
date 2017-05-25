<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$AreaList = store_location::GetDistrictList($_REQUEST["area_parent_id"]);

echo "<option value=''>" . STORE_PAGE_AJAX_DISTRICT . "</option>";

if(count($AreaList) > 0){
	foreach($AreaList as $A){
		
		if(intval($CurrentLang->language_root->language_id) == 2)
			echo "<option value='" . $A["area_list_id"] . "'>" . $A["area_name_tc"] . "</option>";
		else
			echo "<option value='" . $A["area_list_id"] . "'>" . $A["area_name_en"] . "</option>";
	}
}
?>