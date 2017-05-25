<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_page_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'page_edit_act');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Page = page::GetPageInfo($ObjectLink['object_id']);
if ($Page['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
$smarty->assign('Page', $Page);

$tags = explode(",", $_REQUEST['page_tag']);
$PageTagText = ', ';
foreach ($tags as $T)
	$PageTagText = $PageTagText . trim($T) . ", ";

$query =	"	UPDATE	page " .
			"	SET		page_title	= '" . aveEscT($_REQUEST['page_title']) . "', " .
			"			album_id	= '" . intval($_REQUEST['album_id']) . "', " .
			"			page_tag	= '" . aveEsc($PageTagText) . "' " .
			"	WHERE	page_id		= '" . intval($Page['object_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectCommonDataFromRequest($ObjectLink);
object::UpdateObjectSEOData($Page['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($Page['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));
page::UpdateTimeStamp($Page['page_id']);

if ($Page['layout_id'] != $_REQUEST['layout_id']) {
	$NewLayout = layout::GetLayoutInfo($_REQUEST['layout_id']);
	if ($_REQUEST['layout_id'] != 0 && $NewLayout['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'page_edit.php?link_id=' . $_REQUEST['link_id'], __LINE__);

	$OldBlockDefs = block::GetBlockDefListByLayoutID($Page['layout_id']);
	$NewBlockDefs = block::GetBlockDefListByLayoutID($NewLayout['layout_id']);

	if (count($OldBlockDefs) == 0) {
		$query =	"	UPDATE	page " .
					"	SET		layout_id	= '" . intval($_REQUEST['layout_id']) . "'" .
					"	WHERE	page_id		= '" . intval($Page['object_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Create block_holder here!
		foreach ($NewBlockDefs as $key => $value) {
			$BlockHolderID = object::NewObject('BLOCK_HOLDER', $_SESSION['site_id'], 0);
			block::NewBlockHolder($BlockHolderID, $Page['page_id'], $value['block_definition_id'], $_SESSION['site_id'], $Page['language_id']);
		}
	}
	else {
		foreach ($OldBlockDefs as $key => $value) {
			$ContentOption = array();
			$DropOption = array( 'block_definition_id' => 0, 'object_name' => ADMIN_DELETE_OPTION_TEXT);
			array_push($ContentOption, $DropOption);

			foreach ($NewBlockDefs as $NBD) {
				if ($NBD['block_definition_type'] == $value['block_definition_type'])
					array_push($ContentOption, $NBD);
			}
			$OldBlockDefs[$key]['Option'] = $ContentOption;
		}

		$smarty->assign('NewLayout', $NewLayout);
		$smarty->assign('OldBlockDefs', $OldBlockDefs);
		$smarty->assign('NewBlockDefs', $NewBlockDefs);
		$smarty->assign('TITLE', 'Change Page Layout');
		$smarty->display("myadmin/" . $CurrentLang['language_id'] . "/page_layout_change.tpl");
		exit();
	}
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: page_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));