<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_product.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_product_brand_manage", __FILE__, true);

$ObjectLinkIDList = $_REQUEST[$_REQUEST['table_id']];
$ObjectList = array();
foreach ($ObjectLinkIDList as $link_id) {
	if ($link_id != null) {
		$Object = object::GetObjectLinkInfo($link_id);
		if ($Object['site_id'] != $_SESSION['site_id'])
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		if (!($Object['object_type'] == 'PRODUCT'))
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$ObjectList[$link_id] = $Object;
	}
}

$orderid = 1;
foreach ($ObjectLinkIDList as $link_id) {
	if ($link_id != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($ObjectList[$link_id]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/product_brand_product_list_sort.tpl');