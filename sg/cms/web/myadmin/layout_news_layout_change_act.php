<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_layout_news.php');

acl::AclBarrier("acl_layout_news_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'layout_news');
$smarty->assign('MyJS', 'layout_news_layout_change_act');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

if ($LayoutNews['layout_id'] != $_REQUEST['layout_id']) {
	$query =	"	UPDATE	layout_news " .
				"	SET		layout_id		= '" . intval($_REQUEST['layout_id']) . "'" .
				"	WHERE	layout_news_id	= '" . intval($LayoutNews['object_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$NewLayout = layout::GetLayoutInfo($_REQUEST['layout_id']);
	if ($_REQUEST['layout_id'] != 0 && $NewLayout['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['id'], __LINE__);

	$OldBlockDefs = block::GetBlockDefListByLayoutID($LayoutNews['layout_id']);

	$NewBlockDefs = array();

	// Error Checking First! As the whole process must be completed to avoid zombie content.
	foreach ($OldBlockDefs as $key => $value) {
		$OldBlockDefID = $value['block_definition_id'];

		if ($_REQUEST['NewBlockDefMapping'][$OldBlockDefID] != 0) {
			$NewBlockDef = block::GetBlockDefInfo($_REQUEST['NewBlockDefMapping'][$OldBlockDefID]);
			if ($NewBlockDef['site_id'] != $_SESSION['site_id'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['id'], __LINE__);
			if ($NewBlockDef['block_definition_type'] != $value['block_definition_type'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['id'], __LINE__);
			// Save the object so that we don't need to query again below
			$NewBlockDefs[$OldBlockDefID] = $NewBlockDef;
		}
	}
	// Now for the real stuff!
	foreach ($OldBlockDefs as $key => $value) {
		$OldBlockDefID = $value['block_definition_id'];
		if ($_REQUEST['NewBlockDefMapping'][$OldBlockDefID] == 0) {
			$BlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $OldBlockDefID);
			block::DeleteBlockHolder($BlockHolder['block_holder_id'], $Site);
		}
		else {
			$OldBlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $OldBlockDefID);

			// New a BlockHolder if it does not exist
			$NewBlockHolder = block::GetBlockHolderByPageID($LayoutNews['layout_news_id'], $NewBlockDefs[$OldBlockDefID]['block_definition_id']);
			$NewBlockHolderID = $NewBlockHolder['block_holder_id'];

			if ($NewBlockHolder == null) {
				$NewBlockHolderID = object::NewObject('BLOCK_HOLDER', $_SESSION['site_id'], 0);
				block::NewBlockHolder($NewBlockHolderID, $LayoutNews['layout_news_id'], $NewBlockDefs[$OldBlockDefID]['block_definition_id'], $_SESSION['site_id'], $LayoutNews['language_id']);
			}
			block::MoveBlockContentAcrossBlockHolders($OldBlockHolder['block_holder_id'], $NewBlockHolderID);
			block::DeleteBlockHolder($OldBlockHolder['block_holder_id'], $Site);
		}
	}
}
layout_news::UpdateTimeStamp($LayoutNews['layout_news_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));