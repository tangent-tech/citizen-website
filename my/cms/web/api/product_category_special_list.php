<?php
// parameters:
//	lang_id
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$ProductCatSpecialList = product::GetProductCatSpecialList($Site['site_id'], intval($_REQUEST['lang_id']));

$ProductCatListXML = '';
if (count($ProductCatSpecialList) > 0) {				
	foreach ($ProductCatSpecialList as $C) {
		$C['object_seo_url'] = object::GetSeoURL($C, '', intval($_REQUEST['lang_id']), $Site);
		$smarty->assign('Object', $C);
		$ProductCatXML = $smarty->fetch('api/object_info/PRODUCT_CATEGORY_SPECIAL.tpl');
		$ProductCatListXML .= $ProductCatXML;
	}
}

$XML = "<product_category_list>" . $ProductCatListXML . "</product_category_list>";

$smarty->assign('Data', $XML);
$smarty->display('api/api_result.tpl');