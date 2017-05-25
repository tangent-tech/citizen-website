<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_product.php');

acl::AclBarrier("acl_product_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'product');
$smarty->assign('MyJS', 'product_option_add_act');

$SiteLanguageRoots = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
if (count($SiteLanguageRoots) == 0)
	AdminDie(ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED, 'index.php', __LINE__);
$smarty->assign('SiteLanguageRoots', $SiteLanguageRoots);

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
if ($Product['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'product_tree.php', __LINE__);
$smarty->assign('Product', $Product);

$ProductOptionID = object::NewObject('PRODUCT_OPTION', $_SESSION['site_id'], 0);
object::NewObjectLink($Product['product_id'], $ProductOptionID, 'Product Option', 0, 'normal', DEFAULT_ORDER_ID);

$query =	"	INSERT INTO	product_option " .
			"	SET			product_id			= '" . intval($Product['product_id']) . "', " .
			"				product_option_id	= '" . intval($ProductOptionID) . "', " .
			"				product_option_code = '" . aveEscT($_REQUEST['product_option_code']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::TidyUpObjectOrder($Product['product_id'], 'PRODUCT_OPTION');

foreach ($SiteLanguageRoots as $R) {
	$query =	"	INSERT INTO	product_option_data " .
				"	SET		product_option_id			= '" . intval($ProductOptionID) . "', " .
				"			language_id					= '" . intval($R['language_id']) . "', " .
				"			product_option_data_text_1	= '" . aveEscT($_REQUEST['product_option_data_text_1'][$R['language_id']]) . "', " .
				"			product_option_data_text_2	= '" . aveEscT($_REQUEST['product_option_data_text_2'][$R['language_id']]) . "', " .
				"			product_option_data_text_3	= '" . aveEscT($_REQUEST['product_option_data_text_3'][$R['language_id']]) . "', " .
				"			product_option_data_text_4	= '" . aveEscT($_REQUEST['product_option_data_text_4'][$R['language_id']]) . "', " .
				"			product_option_data_text_5	= '" . aveEscT($_REQUEST['product_option_data_text_5'][$R['language_id']]) . "', " .
				"			product_option_data_text_6	= '" . aveEscT($_REQUEST['product_option_data_text_6'][$R['language_id']]) . "', " .
				"			product_option_data_text_7	= '" . aveEscT($_REQUEST['product_option_data_text_7'][$R['language_id']]) . "', " .
				"			product_option_data_text_8	= '" . aveEscT($_REQUEST['product_option_data_text_8'][$R['language_id']]) . "', " .
				"			product_option_data_text_9	= '" . aveEscT($_REQUEST['product_option_data_text_9'][$R['language_id']]) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

product::UpdateTimeStamp($Product['product_id']);
site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));