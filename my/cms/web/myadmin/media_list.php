<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_album.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_media_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'media_list');

$Site = site::GetSiteInfo($_SESSION['site_id']);
$smarty->assign('Site', $Site);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$Album = album::GetAlbumInfo($_REQUEST['id'], 0);
if ($Album['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
$smarty->assign('Album', $Album);

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_photos_per_page'])) {
	if (intval($_POST['num_of_photos_per_page']) < NUM_OF_PHOTOS_PER_PAGE)
		$_POST['num_of_photos_per_page'] = NUM_OF_PHOTOS_PER_PAGE;
	setcookie('num_of_photos_per_page', $_POST['num_of_photos_per_page']);
	$_COOKIE['num_of_photos_per_page'] = $_POST['num_of_photos_per_page'];
}
else {
	if (intval($_COOKIE['num_of_photos_per_page']) < NUM_OF_PHOTOS_PER_PAGE) {
		$_COOKIE['num_of_photos_per_page'] = NUM_OF_PHOTOS_PER_PAGE;
		setcookie('num_of_photos_per_page', $_COOKIE['num_of_photos_per_page']);
	}
}

$TotalMedia = 0;

$MediaList = media::GetMediaList($_REQUEST['id'], $Site['site_default_language_id'], $TotalMedia, $_REQUEST['page_id'], $_COOKIE['num_of_photos_per_page']);
$smarty->assign('MediaList', $MediaList);

$NoOfPage = ceil($TotalMedia / $_COOKIE['num_of_photos_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Media List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/media_list.tpl');