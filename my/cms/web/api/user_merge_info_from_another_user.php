<?php
#user_id_from
#user_id_to
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$UserFrom = user::GetUserInfo($_REQUEST['user_id_from']);
$UserTo = user::GetUserInfo($_REQUEST['user_id_to']);

if ($UserTo['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);
if ($UserFrom['site_id'] != $Site['site_id'])
	APIDie($API_ERROR['API_ERROR_NOT_YOUR_OBJECT']);

// Merge wishlist
$query =	"	SELECT	* " .
			"	FROM	wishlist " .
			"	WHERE	user_id = '" . intval($_REQUEST['user_id_from']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	$query =	"	INSERT INTO wishlist " .
				"	SET		user_id				= '" . intval($_REQUEST['user_id_to']) . "', " .
				"			product_id			= '" . intval($myResult['product_id']) . "', " .
				"			product_option_id	= '" . intval($myResult['product_option_id']) . "' " .
				"	ON DUPLICATE KEY UPDATE " .
				"			user_id	= '" . intval($_REQUEST['user_id_to']) . "'";
	$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

// Merge cart_content
$query =	"	SELECT	* " .
			"	FROM	cart_content " .
			"	WHERE	user_id = '" . intval($_REQUEST['user_id_from']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	$query =	"	INSERT INTO cart_content " .
				"	SET		product_id			= '" . intval($myResult['product_id']) . "', " .
				"			product_option_id	= '" . intval($myResult['product_option_id']) . "', " .
				"			quantity			= '" . intval($myResult['quantity']) . "', " .
				"			system_admin_id		= 0, " .
				"			content_admin_id	= 0, " .
				"			user_id				= '" . intval($_REQUEST['user_id_to']) . "', " .
				"			site_id				= '" . intval($Site['site_id']) . "', " .
				"			cart_content_type	= '" . aveEscT($myResult['cart_content_type']) . "'" .
				"	ON DUPLICATE KEY UPDATE " .
				"			quantity = quantity + '" . intval($myResult['quantity']) . "'";
	$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

$smarty->display('api/api_result.tpl');