<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if ($_REQUEST['refer'] == 'product_edit') {
	require_once('../common/header_product.php');
	acl::AclBarrier("acl_product_edit", __FILE__, false);
}
elseif ($_REQUEST['refer'] == 'member_edit') {
	require_once('../common/header_member.php');
	acl::AclBarrier("acl_member_edit", __FILE__, false);	
}
elseif ($_REQUEST['refer'] == 'bonuspoint_edit') {
	require_once('../common/header_order.php');
	acl::AclBarrier("acl_bonuspoint_edit", __FILE__, false);
}
else {
	require_once('../common/header_album.php');
	acl::AclBarrier("acl_album_edit", __FILE__, false);	
}
acl::AclBarrier("acl_datafile_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');

$Site = site::GetSiteInfo($_SESSION['site_id']);

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);

$Datafile = datafile::GetDatafileInfo($_REQUEST['id'], 0);
if ($Datafile['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);

$ParentObj = object::GetParentObjForPermissionChecking($Datafile);
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

object::UpdateObjectSEOData($Datafile['datafile_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$sql = GetCustomTextSQL("datafile", "int") . GetCustomTextSQL("datafile", "double") . GetCustomTextSQL("datafile", "date");
if (strlen($sql) > 0) {	
	$query =	"	UPDATE	datafile " .
				"	SET		" . substr($sql, 0, -1) .
				"	WHERE	datafile_id = '" . intval($Datafile['datafile_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

foreach ($SiteLanguageRoots as $R) {
	datafile::TouchDatafileData($_REQUEST['id'], $R['language_id']);
	
	$sql = GetCustomTextSQL("datafile", "text", $R['language_id']);
	if (strlen($sql) > 0)
		$sql = ", " . substr($sql, 0, -1);
	
	$query	=	"	UPDATE	datafile_data " .
				"	SET		datafile_desc = '" . aveEscT($_REQUEST['datafile_desc'][$R['language_id']]) . "'" . $sql .
				"	WHERE	datafile_id = '" . intval($_REQUEST['id']) . "'" .
				"		AND	language_id = '" . intval($R['language_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}


if (isset($_FILES['datafile_file']))
	datafile::UpdateDatafile($_REQUEST['id'], $_FILES['datafile_file'], $Site);

datafile::UpdateTimeStamp($_REQUEST['id']);

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: datafile_edit.php?id=' . $_REQUEST['id'] .  '&refer=product_edit&link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'member_edit')
	header( 'Location: datafile_edit.php?id=' . $_REQUEST['id'] .  '&refer=member_edit&user_id=' . $_REQUEST['user_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	header( 'Location: datafile_edit.php?id=' . $_REQUEST['id'] .  '&refer=bonuspoint_edit&parent_id=' . $_REQUEST['parent_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	header( 'Location: datafile_edit.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));