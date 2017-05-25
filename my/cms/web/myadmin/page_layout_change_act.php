<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'page_layout_change_act');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);
$smarty->assign('Page', $Page);

if ($Page['layout_id'] != $_REQUEST['layout_id']) {
	$query =	"	UPDATE	page " .
				"	SET		layout_id	= '" . intval($_REQUEST['layout_id']) . "'" .
				"	WHERE	page_id		= '" . intval($Page['object_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$NewLayout = layout::GetLayoutInfo($_REQUEST['layout_id']);
	if ($_REQUEST['layout_id'] != 0 && $NewLayout['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);

	$OldBlockDefs = block::GetBlockDefListByLayoutID($Page['layout_id']);

	$NewBlockDefs = array();

	// Error Checking First! As the whole process must be completed to avoid zombie content.
	foreach ($OldBlockDefs as $key => $value) {
		$OldBlockDefID = $value['block_definition_id'];

		if ($_REQUEST['NewBlockDefMapping'][$OldBlockDefID] != 0) {
			$NewBlockDef = block::GetBlockDefInfo($_REQUEST['NewBlockDefMapping'][$OldBlockDefID]);
			if ($NewBlockDef['site_id'] != $_SESSION['site_id'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);
			if ($NewBlockDef['block_definition_type'] != $value['block_definition_type'])
				AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);
			// Save the object so that we don't need to query again below
			$NewBlockDefs[$OldBlockDefID] = $NewBlockDef;
		}
	}
	// Now for the real stuff!
	foreach ($OldBlockDefs as $key => $value) {
		$OldBlockDefID = $value['block_definition_id'];
		if ($_REQUEST['NewBlockDefMapping'][$OldBlockDefID] == 0) {
			$BlockHolder = block::GetBlockHolderByPageID($Page['page_id'], $OldBlockDefID);
			block::DeleteBlockHolder($BlockHolder['block_holder_id'], $Site);
		}
		else {
			$OldBlockHolder = block::GetBlockHolderByPageID($Page['page_id'], $OldBlockDefID);

			// New a BlockHolder if it does not exist
			$NewBlockHolder = block::GetBlockHolderByPageID($Page['page_id'], $NewBlockDefs[$OldBlockDefID]['block_definition_id']);
			$NewBlockHolderID = $NewBlockHolder['block_holder_id'];
			if ($NewBlockHolder == null) {
				$NewBlockHolderID = object::NewObject('BLOCK_HOLDER', $_SESSION['site_id'], 0);
				block::NewBlockHolder($NewBlockHolderID, $Page['page_id'], $NewBlockDefs[$OldBlockDefID]['block_definition_id'], $_SESSION['site_id'], $Page['language_id']);
			}
			block::MoveBlockContentAcrossBlockHolders($OldBlockHolder['block_holder_id'], $NewBlockHolderID);
			block::DeleteBlockHolder($OldBlockHolder['block_holder_id'], $Site);
		}
	}
}
page::UpdateTimeStamp($Page['page_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: page_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));