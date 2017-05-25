<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_product_edit", __FILE__, true);

$ParentObjectID = substr($_REQUEST['table_id'], strlen('ProductOptionTable-'));
$Object = object::GetObjectInfo($ParentObjectID);
if ($Object['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

acl::ObjPermissionBarrier("edit", $Object, __FILE__, false);

$ProductOptionIDList = $_REQUEST[$_REQUEST['table_id']];
$ProductOptionList = array();
foreach ($ProductOptionIDList as $pid) {
	if ($pid != null) {
		$ProductOption = product::GetProductOptionInfo($pid, 0);
		
		if ($ProductOption['product_id'] != $ParentObjectID)
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$ProductOptionList[$pid] = $ProductOption;
	}
}

$orderid = 1;
foreach ($ProductOptionIDList as $pid) {
	if ($pid != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($ProductOptionList[$pid]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_option_sort.tpl');