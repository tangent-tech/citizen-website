<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$SiteBlockFileID = 0;

if (isset($_REQUEST['site_block_file_delete']) && $_REQUEST['site_block_file_delete'] == 1)
	block::DeleteSiteBlockFile($Site);
elseif (isset($_FILES['site_block_file']))
	$SiteBlockFileID = block::UpdateSiteBlockFile($Site, $_FILES['site_block_file']);

$BlockDefs = block::GetBlockDefListBySiteBlockHolderRootID($Site['site_block_holder_root_id']);

foreach ($BlockDefs as $key => $D) {
	if (isset($_REQUEST['block_def_delete'][$D['block_definition_id']]) && $_REQUEST['block_def_delete'][$D['block_definition_id']] == 1) {
		block::DeleteBlockDef($D['block_definition_id'], $Site);
	}
	elseif (strlen(trim($_REQUEST['object_name'][$D['block_definition_id']])) > 0) {
		$query =	"	UPDATE	object_link " .
					"	SET		object_name	= '" . aveEscT($_REQUEST['object_name'][$D['block_definition_id']]) . "'" .
					"	WHERE	object_link_id = '" . intval($D['object_link_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	UPDATE	block_definition " .
					"	SET		block_definition_type	= '" . aveEscT($_REQUEST['block_definition_type'][$D['block_definition_id']]) . "', " .
					"			block_definition_desc	= '" . aveEscT($_REQUEST['block_definition_desc'][$D['block_definition_id']]) . "', " .
					"			block_image_height		= '" . intval($_REQUEST['block_image_height'][$D['block_definition_id']]) . "', " .
					"			block_image_width		= '" . intval($_REQUEST['block_image_width'][$D['block_definition_id']]) . "'" .
					"	WHERE	block_definition_id		= '" . intval($D['block_definition_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

foreach ($_REQUEST['new_object_name'] as $key => $BlockName) {
	if (strlen(trim($BlockName)) > 0) {
		$BlockDefinitionID = object::NewObject('BLOCK_DEF', $_SESSION['site_id'], 0);
		block::NewBlockDef($BlockDefinitionID, $_REQUEST['new_block_definition_desc'][$key], $_REQUEST['new_block_definition_type'][$key], $_REQUEST['new_block_image_width'][$key], $_REQUEST['new_block_image_height'][$key]);
		object::NewObjectLink($Site['site_block_holder_root_id'], $BlockDefinitionID, trim($BlockName), 0, 'normal', DEFAULT_ORDER_ID);
	}
}
object::TidyUpObjectOrder($Site['site_block_holder_root_id']);

$ErrorMessage = '';

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: siteblock_def_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));