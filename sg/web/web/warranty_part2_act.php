<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$ObjectSeo = GetSeoUrl(WARRANTY_REG_PAGE_LINK_ID);

if(!isset($_SESSION["WarrantyID"]) || intval($_SESSION["WarrantyID"]) < 1){
	UserDie(ERROR_WARRANTY_REG_DATA_ERROR, BASEURL . $ObjectSeo);
}

warranty::SaveWarrantyFormPartTwo($_REQUEST, $_SESSION["WarrantyID"]);

$WarrantyDetail = warranty::GetWarrantyDetailByID($_SESSION["WarrantyID"]);
$smarty->assign('WarrantyDetail', $WarrantyDetail);

if($_SESSION['view'] == 'm'){
	$PrintHtml = $smarty->fetch(BASEDIR .'htmlsafe/template/email_template/' . $CurrentLang->language_root->language_id . '/warranty.tpl');
	$smarty->assign('PrintHtml', $PrintHtml);
}

$smarty->assign('MyJS', 'WarrantyPart2');
$smarty->assign('PageTitle', WARRANTY_REGISTRATION_PAGE_TITLE);

$smarty->display($CurrentLang->language_root->language_id . '/warranty_part2_act.tpl');
?>