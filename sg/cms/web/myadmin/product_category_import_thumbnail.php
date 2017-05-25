<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_product_category_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_category_import_thumbnail');

$query =	"	SELECT * " .
			"	FROM	product_category C JOIN object O ON (C.product_category_id = O.object_id) " .
			"	WHERE	O.object_thumbnail_file_id = 0 ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	
	$ValidObjectList = array('PRODUCT');
	$ChildObjects = site::GetAllChildObjects($ValidObjectList, $myResult['object_id'], 0, 'Y', 'N');
	
	foreach ($ChildObjects as $O) {
		if ($O['object_thumbnail_file_id'] != 0) {
			
			$NewFileID = filebase::CloneFile($O['object_thumbnail_file_id'], $Site, $myResult['object_id']);
	
			$query =	"	UPDATE	object " .
						"	SET		object_thumbnail_file_id	= '" . intval($NewFileID) . "'" .
						"	WHERE	object_id = '" . intval($myResult['object_id']) . "'";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			break;
		}
	}
}
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_tree_full.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));