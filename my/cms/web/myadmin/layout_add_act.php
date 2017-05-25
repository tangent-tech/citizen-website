<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

if (strlen(trim($_REQUEST['layout_name'])) <= 0)
	AdminDie(ADMIN_ERROR_INVALID_LAYOUT_NAME, 'layout_add.php');

$LayoutID = object::NewObject('LAYOUT', $_SESSION['site_id'], 0);
$LayoutFileID = 0;
if (isset($_FILES['layout_file']))
	$LayoutFileID = filebase::AddFile($_FILES['layout_file'], $Site, SITE_PARENT_ID);
layout::NewLayout($LayoutID, trim($_REQUEST['layout_name']), $LayoutFileID);

foreach ($_REQUEST['object_name'] as $key => $BlockName) {
	if (strlen(trim($BlockName)) > 0) {
		$BlockDefinitionID = object::NewObject('BLOCK_DEF', $_SESSION['site_id'], 0);
		block::NewBlockDef($BlockDefinitionID, $_REQUEST['block_definition_desc'][$key], $_REQUEST['block_definition_type'][$key], $_REQUEST['block_image_width'][$key], $_REQUEST['block_image_height'][$key]);
		object::NewObjectLink($LayoutID, $BlockDefinitionID, trim($BlockName), 0, 'normal', DEFAULT_ORDER_ID);
	}
}
object::TidyUpObjectOrder($LayoutID);

$ErrorMessage = '';
if ($LayoutFileID === false)
	$ErrorMessage = ADMIN_ERROR_UPLOAD_FILE_FAIL;

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_edit.php?id=' . $LayoutID . '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));