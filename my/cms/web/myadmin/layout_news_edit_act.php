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
$smarty->assign('MyJS', 'layout_news_edit_act');

$LayoutNews = layout_news::GetLayoutNewsInfo($_REQUEST['id']);
if ($LayoutNews['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);
$smarty->assign('LayoutNews', $LayoutNews);

acl::ObjPermissionBarrier("edit", $LayoutNews, __FILE__, false);

$LayoutNewsCategories = layout_news::GetLayoutNewsCategoryList($LayoutNews['language_id'], $_SESSION['site_id']);
if (count($LayoutNewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_LAYOUT_NEWS_CATEGORY, 'layout_news_category_list.php?language_id=' . $LayoutNews['language_id'], __LINE__);
}

$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['layout_news_category_id']);
if ($LayoutNewsCategory['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news.php', __LINE__);


object::UpdateObjectCommonDataFromRequest($LayoutNews);
object::UpdateObjectSEOData($LayoutNews['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);
object::UpdateObjectPermission($LayoutNews['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

$tags = explode(",", $_REQUEST['layout_news_tag']);
$LayoutNewsTagText = ', ';
foreach ($tags as $T)
	$LayoutNewsTagText = $LayoutNewsTagText . trim($T) . ", ";
$LayoutNewsDateText = $_REQUEST['layout_news_date'] . " " . $_REQUEST['Time_Hour'] . ":" . $_REQUEST['Time_Minute'];

$query =	"	UPDATE	layout_news " .
			"	SET		layout_news_title		= '" . aveEscT($_REQUEST['layout_news_title']) . "', " .
			"			layout_news_date		= '" . aveEscT($LayoutNewsDateText) . "', " .
			"			layout_news_tag			= '" . aveEsc($LayoutNewsTagText) . "', " .
			"			layout_news_category_id	= '" . intval($_REQUEST['layout_news_category_id']) . "', " .
			"			album_id			= '" . intval($_REQUEST['album_id']) . "'" .
			"	WHERE	layout_news_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

layout_news::UpdateTimeStamp($_REQUEST['id']);

if ($LayoutNews['layout_id'] != $_REQUEST['layout_id']) {
	$NewLayout = layout::GetLayoutInfo($_REQUEST['layout_id']);
	if ($_REQUEST['layout_id'] != 0 && $NewLayout['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'layout_news_edit.php?id=' . $_REQUEST['id'], __LINE__);

	$OldBlockDefs = block::GetBlockDefListByLayoutID($LayoutNews['layout_id']);
	$NewBlockDefs = block::GetBlockDefListByLayoutID($NewLayout['layout_id']);

	if (count($OldBlockDefs) == 0) {
		$query =	"	UPDATE	layout_news " .
					"	SET		layout_id		= '" . intval($_REQUEST['layout_id']) . "'" .
					"	WHERE	layout_news_id	= '" . intval($LayoutNews['object_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		// Create block_holder here!
		foreach ($NewBlockDefs as $key => $value) {
			$BlockHolderID = object::NewObject('BLOCK_HOLDER', $_SESSION['site_id'], 0);
			block::NewBlockHolder($BlockHolderID, $LayoutNews['layout_news_id'], $value['block_definition_id'], $_SESSION['site_id'], $LayoutNews['language_id']);
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
		$smarty->assign('TITLE', 'Change News Layout');
		$smarty->display("myadmin/" . $CurrentLang['language_id'] . "/layout_news_layout_change.tpl");
		exit();
	}
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_news_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));