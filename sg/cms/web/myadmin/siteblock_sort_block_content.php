<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_xml_article.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_siteblock_move", __FILE__, true);

$BlockDefID = substr($_REQUEST['table_id'], 14);
$BlockDef = block::GetBlockDefInfo($BlockDefID);
if ($BlockDef['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

$BlockHolder = block::GetBlockHolderBySiteID($_SESSION['site_id'], $BlockDefID, $_REQUEST['language_id']);
if ($BlockHolder['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

acl::ObjPermissionBarrier("edit", $BlockHolder, __FILE__, false);

$BlockContentIDList = $_REQUEST[$_REQUEST['table_id']];
$BlockContents = array();
foreach ($BlockContentIDList as $bcid) {
	if ($bcid != null) {
		$BlockContent = block::GetBlockContentInfo($bcid);
		if ($BlockContent['parent_object_id'] != $BlockHolder['block_holder_id'])
			XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);
		$BlockContents[$bcid] = $BlockContent;
	}
}

$orderid = 1;
foreach ($BlockContentIDList as $bcid) {
	if ($bcid != null) {
		$query =	"	UPDATE	object_link " .
					"	SET		order_id = '" . $orderid++ . "'" .
					"	WHERE	object_link_id	= '" . intval($BlockContents[$bcid]['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', 'ok');
$smarty->assign('msg', ADMIN_MSG_UPDATE_SUCCESS);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/siteblock_sort_block_content.tpl');