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

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

$ProductRoot = product::GetProductRootInfo($ObjectLink['object_id']);
if ($ProductRoot == null)
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

product::DeleteProductRootLink($_REQUEST['link_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_tree.php?id=' . $ObjectLink['language_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));