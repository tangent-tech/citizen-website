<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_news.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'news_root');
$smarty->assign('MyJS', 'news_root_edit_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$SiteLanguage = language::GetSiteLanguageRoot($_REQUEST['language_id'], $_SESSION['site_id']);
if ($SiteLanguage == null)
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);

$NewsRoot = news::GetNewsRootInfo($_REQUEST['id']);
if ($NewsRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'news.php', __LINE__);

$query =	"	UPDATE	news_root " .
			"	SET		news_root_name = '". aveEscT($_REQUEST['news_root_name']) . "'," .
			"			language_id = '" . intval($_REQUEST['language_id']) . "'" .
			"	WHERE	news_root_id =  '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: news_root_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));