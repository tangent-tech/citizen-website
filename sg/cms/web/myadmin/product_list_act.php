<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');

acl::AclBarrier("acl_product_sort", __FILE__, true);

foreach ($_REQUEST['object_global_order_id'] as $ProductID => $GlobalOrderID) {
	$Product = product::GetProductInfo($ProductID, 0);
	if ($Product['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_list.php', __LINE__);
}

foreach ($_REQUEST['object_global_order_id'] as $ProductID => $GlobalOrderID) {
	$query =	"	UPDATE	object " .
				"	SET		object_global_order_id = '" . intval($GlobalOrderID) . "'" .
				"	WHERE	object_id	= '" . intval($ProductID) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

object::TidyUpObjectGlobalOrder($_SESSION['site_id'], 'PRODUCT');

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));