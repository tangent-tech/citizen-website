<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_product.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_root_add_act');

$ProductRootID = object::NewObject('PRODUCT_ROOT', $_SESSION['site_id'], 0);
$NewLinkID = object::NewObjectLink($Site['library_root_id'], $ProductRootID, $_REQUEST['product_root_name'], 0, 'normal', DEFAULT_ORDER_ID);
object::TidyUpObjectOrder($Site['library_root_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_root_edit.php?id=' . $NewLinkID .  '&SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));