<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

//header ("Content-Type:text/xml");
header("Content-type: text/xml");

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');

$Node = null;
$status = 'ERROR';
$Node = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($Node == null || $Node['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if (!in_array($Node['object_type'], array ('PRODUCT','PRODUCT_CATEGORY', 'PRODUCT_SPECIAL_CATEGORY')))
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if ($Node['object_type'] == 'PRODUCT') {
	acl::AclBarrier("acl_product_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PRODUCT_CATEGORY' || $Node['object_type'] == 'PRODUCT_GROUP') {
	acl::AclBarrier("acl_product_category_edit", __FILE__, true);
}
elseif ($Node['object_type'] == 'PRODUCT_SPECIAL_CATEGORY') {
	acl::AclBarrier("acl_product_category_special_edit", __FILE__, true);
}
acl::ObjPermissionBarrier("edit", $Node, __FILE__, true);

$query	=	"	UPDATE	object_link " .
			"	SET		object_link_is_enable = '". aveEscT($_REQUEST['action']) . "'" .
//			"	WHERE	object_link_id = '" . $Node['object_link_id'] . "'";
			"	WHERE	object_id = '" . intval($Node['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable = '". aveEscT($_REQUEST['action']) . "'" .
			"	WHERE	object_id = '" . intval($Node['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$CurrencyList = currency::GetAllSiteCurrencyList($Site['site_id']);
if ($Node['object_type'] == 'PRODUCT') {
	product::UpdateAllProductCategoryPreCalDataByProductID($Node['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
}
else if ($Node['object_type'] == 'PRODUCT_CATEGORY') {
	product::UpdateProductCategoryPreCalData($Node['object_id'], $SiteLanguageRoots, $Site, $CurrencyList);
	
	if ($_REQUEST['action'] == 'Y') {
		$Node = object::GetObjectLinkInfo($_REQUEST['link_id']);
		if ($Node['object_is_enable'] == 'N')
			XMLDie(__LINE__, ADMIN_ERROR_ALL_PRODUCTS_IN_PRODUCT_GROUP_IS_DISABLED);
	}
}

$status = 'ok';

$msg = '';
if ($_REQUEST['action'] == 'Y')
	$msg = ADMIN_MSG_ENABLE_SUCCESS;
elseif ($_REQUEST['action'] == 'N')
	$msg = ADMIN_MSG_DISABLE_SUCCESS;

$NewStatus = '';
if ($_REQUEST['action'] == 'N')
	$NewStatus = 'disable';
else
	$NewStatus = 'enable';

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('NewStatus', $NewStatus);
$smarty->assign('msg', $msg);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_tree_enable.tpl');