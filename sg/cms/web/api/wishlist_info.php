<?php
// parameters:
//	user_id
//	lang_id
//	currency_id

define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$User = user::GetUserInfo($_REQUEST['user_id']);
if ($User['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

$WishListXML = wishlist::GetWishlistList($_REQUEST['user_id'], $_REQUEST['lang_id'], $_REQUEST['currency_id']);

$smarty->assign('Data', $WishListXML);
$smarty->display('api/api_result.tpl');