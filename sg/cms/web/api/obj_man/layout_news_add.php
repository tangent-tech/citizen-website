<?php
// parameters:
//	security_level
//	archive_date
//	publish_date
//	object_meta_title
//	object_meta_description
//	object_meta_keywords
//	object_friendly_url
//	object_lang_switch_id
//	layout_news_root_id
//	layout_news_category_id
//	layout_news_tag
//	layout_news_title
//	layout_news_date
//	layout_id
//	album_id
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

//$IsContentAdmin = true;
// Notice for update code: Update validation and handling of product_brand, special_cat, product_cat are different

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

$NoOfLayoutNews = layout_news::GetNoOfLayoutNews($Site['site_id']);
if ($NoOfLayoutNews >= $Site['site_module_layout_news_quota'])
	APIDie(array('desc' => ADMIN_ERROR_LAYOUT_NEWS_QUOTA_FULL));

$LayoutNewsRoot = layout_news::GetLayoutNewsRootInfo($_REQUEST['layout_news_root_id']);
if ($LayoutNewsRoot['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid layout_news_root_id'));

$LayoutNewsCategory = layout_news::GetLayoutNewsCategoryInfo($_REQUEST['layout_news_category_id']);
if ($LayoutNewsCategory['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid layout_news_category_id'));

$Layout = layout::GetLayoutInfo($_REQUEST['layout_id']);
if ($Layout['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid layout_id'));

if (!isset($_REQUEST['archive_date']))
	$_REQUEST['archive_date'] = OBJECT_DEFAULT_ARCHIVE_DATE;
if (!isset($_REQUEST['publish_date']))
	$_REQUEST['publish_date'] = OBJECT_DEFAULT_PUBLISH_DATE;

// OK TO GO!
$LayoutNewsID = object::NewObject('LAYOUT_NEWS', $Site['site_id'], $_REQUEST['security_level'], $_REQUEST['archive_date'], $_REQUEST['publish_date'], 'Y', 'Y', $LayoutNewsRoot);

object::UpdateObjectSEOData($LayoutNewsID, $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$tags = explode(",", $_REQUEST['layout_news_tag']);
$LayoutNewsTagText = ', ';
foreach ($tags as $T)
	$LayoutNewsTagText = $LayoutNewsTagText . trim($T) . ", ";

layout_news::NewLayoutNews($LayoutNewsID, $_REQUEST['layout_news_root_id'], $_REQUEST['layout_news_title'], $_REQUEST['layout_news_date'], $LayoutNewsTagText, $_REQUEST['layout_news_category_id'], $_REQUEST['layout_id'], $_REQUEST['album_id']);
layout_news::UpdateTimeStamp($LayoutNewsID);

$BlockDefs = block::GetBlockDefListByLayoutID($_REQUEST['layout_id']);
foreach ($BlockDefs as $key => $value) {
	block::TouchBlockHolderList($LayoutNewsID, $value['block_definition_id'], $Site['site_id'], $LayoutNewsRoot['language_id']);
}

site::EmptyAPICache($Site['site_id']);

$smarty->assign('Data', "<layout_news_id>" . $LayoutNewsID . "</layout_news_id>");
$smarty->display('api/api_result.tpl');