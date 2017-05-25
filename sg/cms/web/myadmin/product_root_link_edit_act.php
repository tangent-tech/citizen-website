<?php

die('This script has been phased out');

define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_product.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'product_root_link_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$ProductRoot = product::GetProductRootInfo($ObjectLink['object_id']);
if ($ProductRoot == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

$NewProductRoot = product::GetProductRootInfo($_REQUEST['product_root_id']);
if ($NewProductRoot == null || $NewProductRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

object::UpdateObjectSEOData($ObjectLink['object_id'], $_REQUEST['object_meta_title'], $_REQUEST['object_meta_description'], $_REQUEST['object_meta_keywords'], $_REQUEST['object_friendly_url'], $_REQUEST['object_lang_switch_id']);

$query =	"	UPDATE	object_link " .
			"	SET		object_id		=	'" . intval($_REQUEST['product_root_id']) . "'" .
			"	WHERE	object_link_id	=	'" . intval($_REQUEST['link_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::UpdateObjectTimeStamp($_REQUEST['product_root_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_root_link_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));