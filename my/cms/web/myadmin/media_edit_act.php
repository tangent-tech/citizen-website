<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if ($_REQUEST['refer'] == 'product_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'product_category_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	require_once('../common/header_order.php');
else
	require_once('../common/header_album.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');

$Site = site::GetSiteInfo($_SESSION['site_id']);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$Media = media::GetMediaInfo($_REQUEST['id'], 0);
if ($Media['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

$ParentObj = object::GetParentObjForPermissionChecking($Media);
acl::ObjPermissionBarrier("edit", $ParentObj, __FILE__, false);

$ObjectArchiveDateText = $_REQUEST['object_archive_date'] . " " . $_REQUEST['object_archive_date_Hour'] . ":" . $_REQUEST['object_archive_date_Minute'];
$ObjectPublishDateText = $_REQUEST['object_publish_date'] . " " . $_REQUEST['object_publish_date_Hour'] . ":" . $_REQUEST['object_publish_date_Minute'];

$query	=	"	UPDATE	object " .
			"	SET		object_is_enable		= '" . ynval($_REQUEST['object_is_enable']) . "', " .
			"			object_archive_date		= '" . aveEscT($ObjectArchiveDateText) . "', " .
			"			object_publish_date		= '" . aveEscT($ObjectPublishDateText) . "', " .
			"			object_security_level	= '" . intval($_REQUEST['object_security_level']) . "' " .
			"	WHERE	object_id = '" . intval($_REQUEST['id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectSEOData($Media['media_id'], null, null, null, null, $_REQUEST['object_lang_switch_id']);

$sql = GetCustomTextSQL("media", "int") . GetCustomTextSQL("media", "double") . GetCustomTextSQL("media", "date");
if (strlen($sql) > 0) {
	$query =	"	UPDATE	media " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	media_id = '" . $Media['media_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$MediaCustomFieldsDef = site::GetMediaCustomFieldsDef($_SESSION['site_id']);

foreach ($SiteLanguageRoots as $R) {	
	media::TouchMediaData($_REQUEST['id'], $R['language_id']);
	
	$sql = GetCustomTextSQL("media", "autotext", $R['language_id'], null, false, $MediaCustomFieldsDef);	
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);	
	
	$query	=	"	UPDATE	media_data " .
				"	SET		media_desc = '" . aveEscT($_REQUEST['media_desc'][$R['language_id']]) . "'" . $sql .
				"	WHERE	media_id = '" . intval($_REQUEST['id']) . "'" .
				"		AND	language_id = '" . $R['language_id'] . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	$query =	"	UPDATE	media_data " .
				"	SET		object_meta_title	= '" . aveEscT($_REQUEST['object_meta_title'][$R['language_id']]) . "', " .
				"			object_meta_description		= '" . aveEscT($_REQUEST['object_meta_description'][$R['language_id']]) . "', " .
				"			object_meta_keywords	= '" . aveEscT($_REQUEST['object_meta_keywords'][$R['language_id']]) . "', " .
				"			object_friendly_url		= '" . aveEscT($_REQUEST['object_friendly_url'][$R['language_id']]) . "' " .
				"	WHERE	media_id	= '" . intval($_REQUEST['id']) . "'" .
				"		AND	language_id	= '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$SmallWidth = 0;
$SmallHeight = 0;
$BigWidth = 0;
$BigHeight = 0;

if ($_REQUEST['refer'] == 'product_edit') {
	$SmallWidth = $Site['site_product_media_small_width'];
	$SmallHeight = $Site['site_product_media_small_height'];
	$BigWidth = $Site['site_product_media_big_width'];
	$BigHeight = $Site['site_product_media_big_height'];
}
else {
	$SmallWidth = $Site['site_media_small_width'];
	$SmallHeight = $Site['site_media_small_height'];
	$BigWidth = $Site['site_media_big_width'];
	$BigHeight = $Site['site_media_big_height'];
}
$Resize = true;
if ($Site['site_media_resize'] != 'Y')
	$Resize = false;

if (isset($_FILES['media_file']) && $_REQUEST['update_thumbnail_only'] != 'Y') {
	media::UpdateMedia($_REQUEST['id'], $_FILES['media_file'], $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize);
	media::UpdateTimeStamp($_REQUEST['id']);
}
elseif (isset($_FILES['media_file']) && $_REQUEST['update_thumbnail_only'] == 'Y') {
	media::UpdateMediaThumbnail($_REQUEST['id'], $Site, $_FILES['media_file'], $SmallWidth, $SmallHeight);
	media::UpdateTimeStamp($_REQUEST['id']);
	
}

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: media_edit.php?id=' . $_REQUEST['id'] .  '&refer=product_edit&link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'product_category_edit')
	header( 'Location: media_edit.php?id=' . $_REQUEST['id'] .  '&refer=product_category_edit&link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	header( 'Location: media_edit.php?id=' . $_REQUEST['id'] .  '&refer=bonuspoint_edit&parent_id=' . $_REQUEST['parent_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	header( 'Location: media_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));