<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_news_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
//$smarty->assign('CurrentTab2', 'news');
$smarty->assign('MyJS', 'news_list');

$smarty->assign('CurrentNewsRootID', $_REQUEST['id']);

$NewsRoot = news::GetNewsRootInfo($_REQUEST['id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);
$smarty->assign('NewsRoot', $NewsRoot);

acl::ObjPermissionBarrier("browse_children", $NewsRoot, __FILE__, false);

$NewsCategories = news::GetNewsCategoryList($NewsRoot['language_id'], $_SESSION['site_id']);
if (count($NewsCategories) == 0) {
	AdminDie(ADMIN_ERROR_NO_NEWS_CATEGORY, 'news_category_list.php?language_id=' . $NewsRoot['language_id'], __LINE__);
}
$smarty->assign('NewsCategories', $NewsCategories);

$NumOfNews = 0;

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

$NewsList = news::GetNewsListByNewsRootID($_REQUEST['id'], $NumOfNews, $_REQUEST['page_id'], NUM_OF_NEWS_PER_PAGE, $_REQUEST['news_id'], $_REQUEST['news_date'], $_REQUEST['news_title'], $_REQUEST['news_category_id'], $_REQUEST['news_tag']);
$smarty->assign('NewsList', $NewsList);
	
$NoOfPage = ceil($NumOfNews / NUM_OF_NEWS_PER_PAGE);
$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', $NewsRoot['news_root_name'] .' List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/news_list.tpl');