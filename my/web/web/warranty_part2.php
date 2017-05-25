<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

if(!isset($_SESSION["WarrantyID"]) || intval($_SESSION["WarrantyID"]) < 1){
	
	$ObjectSeo = GetSeoUrl(WARRANTY_REG_PAGE_LINK_ID);
	
	UserDie(ERROR_WARRANTY_REG_DATA_ERROR, BASEURL . $ObjectSeo);
}
else {
	$WarrantyDetail = warranty::GetWarrantyDetailByID($_SESSION["WarrantyID"]);
	$smarty->assign('WarrantyDetail', $WarrantyDetail);
}

$smarty->assign('MyJS', 'WarrantyPart2');
$smarty->assign('PageTitle', WARRANTY_REGISTRATION_PAGE_TITLE);

$smarty->display($CurrentLang->language_root->language_id . '/warranty_part2.tpl');
?>