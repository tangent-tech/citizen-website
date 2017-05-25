<?php
$SearchKey2  = array(
	'香港網頁設計', '香港網站設計', '香港', '網頁設計公司', '網頁設計服務', '網頁設計', '網站設計', '網上商店', '網頁服務', '網站服務', '網頁程式', '網站管理', '網頁製作', '網站製作', '網上推廣', 'SEO', 'CMS', '設計網頁', '設計網站', '制作網頁', '網頁開發', '開發網頁', '製作網站', '設計', '網站推廣', '商標設計', 'Logo Design', 'Logo', 'Web Design', '手機程式設計', '手機程式開發', '網站開發', 'eshop', '手機開發', '手機設計', 'apps開發', 'apps設計', 'apps公司', 'app開發公司', 'app開發', 'app設計', 'app公司', 'app設計公司', 'apps開發公司', 'apps設計公司'
);
$SearchKey3  = array(
	'網頁設計公司', '網頁設計', '網站設計', 'Web Design', 'Website Design', 'Web Site Design'
);
$SearchKey  = array(
	'網頁設計公司', '網頁設計'
);

$SearchKeyHighPR = array(
	'css' => array (
		'http://www.csszengarden.com',
		'http://api.jquery.com/css/',
		'http://www.w3schools.com/css/',
		'htmlhelp.com/reference/css/'
	),
	'php' => array (
		'http://www.php.net'
	),
	'html' => array (
		'http://www.w3schools.com/html/',
		'http://en.wikipedia.org/wiki/HTML'
	),
	'Apple' => array (
		'http://www.apple.com',
		'http://en.wikipedia.org/wiki/Apple_Inc.',
		'http://gigaom.com/apple/'
	),
	'google' => array (
		'http://googleblog.blogspot.com',
		'http://www.google.com.hk/blogsearch',
		'http://www.google.com.hk'
	)

);

$RandomSEOText = array(
	'新聞', '技巧介紹', '文章分享', '技術攻略', '技巧', '小技巧', '教程', '工具介紹', '工具分享', '最新新聞', '重大消息', '消息', '小知識', '知識共享'

);

$ValidApiCartContentType = array('normal', 'bonus_point');

// The SITE_PARENT_ID should set to 0 after filebase.parent_object_id is fixed. This is for backend use only, e.g. layout or site block image
define ('SITE_PARENT_ID', '-2');

define('DEFAULT_API_ERROR_LANG_ID', 1);
//$API_ERROR = array (
//	'API_ERROR_AUTH_FAIL'								=> array('no' => 1,		'desc' => 'Authorization Fail'),
//	'API_ERROR_NOT_YOUR_OBJECT'							=> array('no' => 2, 	'desc' => 'Invalid Object'),
//	'API_ERROR_INVALID_EMAIL'							=> array('no' => 3, 	'desc' => 'Invalid Email Address'),
//	'API_ERROR_DUPLICATE_EMAIL'							=> array('no' => 4, 	'desc' => 'Duplicate Email Address'),
//	'API_ERROR_DUPLICATE_USERNAME'						=> array('no' => 5, 	'desc' => 'Duplicate Username'),
//	'API_ERROR_INVALID_LANGUAGE_ID'						=> array('no' => 6, 	'desc' => 'Invalid Language ID'),
//	'API_ERROR_INVALID_COUNTRY_ID'						=> array('no' => 7, 	'desc' => 'Invalid Country ID'),
//	'API_ERROR_INVALID_BONUS_POINT_ITEM_ID'				=> array('no' => 8, 	'desc' => 'Invalid Bonus Point Item ID'),
//	'API_ERROR_INVALID_CURRENCY_ID'						=> array('no' => 9,		'desc' => 'Invalid Currency ID'),
//	'API_ERROR_NOT_ENOUGH_BONUS_POINT'					=> array('no' => 10,	'desc' => 'Not Enough Bonus Point'),
//	'API_ERROR_NOT_ENOUGH_BALANCE'						=> array('no' => 11,	'desc' => 'Not Enough Balance'),
//	'API_ERROR_PAY_AMOUNT_DOES_NOT_MATCH'				=> array('no' => 12,	'desc' => 'Incorrect Pay Amount'),
//	'API_ERROR_INCORRECT_OLD_PASSWORD'					=> array('no' => 13,	'desc' => 'Old password is incorrect'),
//	'API_ERROR_PRODUCT_IS_DISABLED'						=> array('no' => 14,	'desc' => 'Product is disabled'),
//	'API_ERROR_ORDER_ALREADY_CONFIRMED'					=> array('no' => 15,	'desc' => 'Order has been confirmed'),
//	'API_ERROR_ORDER_CURRENCY_ID_MISMATCH'				=> array('no' => 16,	'desc' => 'Order Currency ID mismatched'),
//	'API_ERROR_ORDER_PAY_AMOUNT_MISMATCH'				=> array('no' => 17,	'desc' => 'Order Pay Amount mismatched'),
//	'API_ERROR_NOT_ENOUGH_BONUS_POINT_TO_PROCEED_ORDER'	=> array('no' => 18,	'desc' => 'Not enough bonus point to proceed order'),
//	'API_ERROR_NOT_ENOUGH_BALANCE_TO_PROCEED_ORDER'		=> array('no' => 19,	'desc' => 'Not enough balance to proceed order'),
//	'API_ERROR_NOT_YOUR_USER'							=> array('no' => 20,	'desc' => 'Not your user'),
//	'API_ERROR_GUEST_VOTE_IS_DISABLED'					=> array('no' => 21,	'desc' => 'Guest vote is disabled'),
//	'API_ERROR_INVALID_VOTE_NO'							=> array('no' => 22,	'desc' => 'Invalid Vote No'),
//	'API_ERROR_VOTE_MODULE_DISABLED'					=> array('no' => 23,	'desc' => 'Vote module is disabled'),
//	'API_ERROR_FAIL_TO_READ_FILE'						=> array('no' => 24,	'desc' => 'Fail to read file.'),
//	'API_ERROR_CART_UNDER_STOCK'						=> array('no' => 25,	'desc' => 'Some items in the cart is under stock.'),
//	'API_ERROR_MYORDER_UNDER_STOCK'						=> array('no' => 26,	'desc' => 'Some items in the order is under stock.'),
//	'API_ERROR_BONUS_POINT_ITEM_IS_DISABLED'			=> array('no' => 27,	'desc' => 'Bonus Point Item is disabled'),
//	'API_ERROR_ELASING_MODULE_IS_DISABLED'				=> array('no' => 28,	'desc' => 'Elasing Module is disabled'),
//	'API_ERROR_INVALID_CAMPAIGN_ID'						=> array('no' => 29,	'desc' => 'Invalid Campaign ID'),
//	'API_ERROR_EMAIL_ADDRESS_DENY_ALL_ELASING'			=> array('no' => 30,	'desc' => 'Email address deny all elasing.'),
//	'API_ERROR_UNSUPPORTED_CONVERT_MODE'				=> array('no' => 31,	'desc' => 'Unsupported convert mode.'),
//	'API_ERROR_PRODUCT_UNDER_STOCK'						=> array('no' => 32,	'desc' => 'Product is under stock.'),
//	'API_ERROR_FILE_SIZE_IS_ZERO'						=> array('no' => 33,	'desc' => 'Filesize is zero.'),
//	'API_ERROR_PRODUCT_IS_SHADOW'						=> array('no' => 34,	'desc' => 'Product is a product group'),
//	'API_ERROR_INVALID_LINK_ID_NOT_PRODUCT'				=> array('no' => 35,	'desc' => 'Invalid link. Must be product or product group.')
//);

$ScreenWidth = array ( "ipad" => 950, "normal" => 1200, "wide" => 1400, "wider" => 1600, "HD" => 1850);
$smarty->assign('ScreenWidth', $ScreenWidth);

$MyConstant =
	array (
		'MIN_PASSWORD' => 8,
		'MAX_PASSWORD' => 16,
	);

	foreach ($MyConstant as $key => $value)
	{
//		$smarty->assign($key, $value);
		define($key, $value);
	}

// ****!!!!!**** VERY IMPORTANT
//	Remember to update object::GetParentObj() if you update $ObjectTypeList
$ObjectTypeList = array (
	'SITE_ROOT','LIBRARY_ROOT','LANGUAGE_ROOT','PAGE','LAYOUT','BLOCK_DEF','BLOCK_CONTENT','BLOCK_HOLDER','SITE_BLOCK_HOLDER_ROOT','FOLDER','LINK','PRODUCT_ROOT','PRODUCT_ROOT_LINK','PRODUCT_ROOT_SPECIAL','PRODUCT','PRODUCT_CATEGORY','PRODUCT_SPECIAL_CATEGORY','ALBUM_ROOT','ALBUM','MEDIA','NEWS_ROOT','NEWS','NEWS_PAGE','NEWS_CATEGORY','BONUS_POINT_ITEM','LAYOUT_NEWS','LAYOUT_NEWS_ROOT','LAYOUT_NEWS_CATEGORY','LAYOUT_NEWS_PAGE','PRODUCT_OPTION','DATAFILE','PRODUCT_BRAND','PRODUCT_BRAND_ROOT','DISCOUNT_PREPROCESS_RULE','DISCOUNT_POSTPROCESS_RULE','USER_DATAFILE_HOLDER','BONUS_POINT_ROOT', 'USER_ROOT', 'DISCOUNT_BUNDLE_RULE'
);
$LanguageTreeObjectTypeList = array ( 'SITE_ROOT', 'LANGUAGE_ROOT', 'PAGE', 'FOLDER', 'LINK', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE' );
$SiteGenerateStaticPagesObjectTypeList = array ( 'SITE_ROOT', 'LANGUAGE_ROOT', 'PAGE', 'FOLDER', 'PRODUCT_ROOT_LINK', 'PRODUCT', 'PRODUCT_CATEGORY', 'NEWS', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS', 'LAYOUT_NEWS_PAGE' );
$AlwaysEnableObjectTypeList = array ( 'SITE_ROOT', 'LIBRARY_ROOT', 'ALBUM_ROOT', 'BONUS_POINT_ROOT' );

//$APIFolderTreeObjectTypeList						= array ( 'PAGE', 'FOLDER', 'LINK', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK', 'PRODUCT_CATEGORY', 'PRODUCT');

$APIFolderTreeObjectTypeList						= array ( 'PAGE', 'FOLDER', 'LINK', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK' );
$APIFolderTreeObjectTypeList_DoNotExpandProductRoot = array ( 'PAGE', 'FOLDER', 'LINK', 'ALBUM', 'NEWS_PAGE', 'LAYOUT_NEWS_PAGE', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK' );
$ProductTreeObjectTypeList							= array ( 'PRODUCT', 'PRODUCT_CATEGORY');

// The following three arrays are used to propagate the permission if user wants to do something like "update all child objects". They are NOT controlling which object should be permission aware, this must be hardcoded in each files in a very hard way. Why I choose to do in this way is that when you are editing the file, you should be very focus in that particular file so moving the logic out of the file is IMO stupid. But as propagation occurs from anywhere, it should be done in constant.php
// 
// Note: 20130206 Jeff - Too prevent I become mad, one design rule just think of: If you need to list the child objects in a "click through" action like "album -> media", you need to make MEDIA in PermissionPropagateTargetObjectList, otherwise, ignore it (Think of MEDIA vs DATAFILE)
// 
// Only list the object needed to update permission WHEN propagate by its parent
// So even though BLOCK_HOLDER is permission aware (for SITE_BLOCK) but SITE_BLOCK_HOLDER_ROOT / PAGE will not propagate, so it should be left out here
$PermissionPropagateTargetObjectList = array(
	'PAGE','LAYOUT','BLOCK_CONTENT','FOLDER','LINK','PRODUCT','PRODUCT_CATEGORY','MEDIA','NEWS','LAYOUT_NEWS', 'BONUS_POINT_ITEM', 'USER_DATAFILE_HOLDER'
// Non-propagate list:
// 'SITE_ROOT','LIBRARY_ROOT','LANGUAGE_ROOT','BLOCK_DEF','BLOCK_HOLDER','SITE_BLOCK_HOLDER_ROOT','PRODUCT_ROOT','PRODUCT_ROOT_LINK','PRODUCT_ROOT_SPECIAL','PRODUCT_SPECIAL_CATEGORY','ALBUM_ROOT','ALBUM','NEWS_ROOT','NEWS_PAGE','NEWS_CATEGORY','LAYOUT_NEWS_ROOT','LAYOUT_NEWS_CATEGORY','LAYOUT_NEWS_PAGE','PRODUCT_OPTION','DATAFILE','PRODUCT_BRAND','PRODUCT_BRAND_ROOT','DISCOUNT_PREPROCESS_RULE','DISCOUNT_POSTPROCESS_RULE'
);

// The major question to ask when adding new object type: Should this object propagate the permission to children? So for example PRODUCT_ROOT_LINK, it should not propagate. But PRODUCT_ROOT should do so.
// BLOCK_HOLDER should appear here so that we can update all BLOCK_CONTENT in SITE_BLOCK editing (Page block_holder is not needed as we don't give them control in such detail.
$PermissionPropagateValidContainerObjectList	= array( 
	'BLOCK_HOLDER','FOLDER','PRODUCT_ROOT','PRODUCT_CATEGORY','ALBUM','NEWS_ROOT','LAYOUT_NEWS_ROOT','ALBUM_ROOT', 'BONUS_POINT_ROOT', 'USER_ROOT'
//	'SITE_ROOT','LIBRARY_ROOT','LANGUAGE_ROOT','PAGE','LAYOUT','BLOCK_DEF','BLOCK_CONTENT','SITE_BLOCK_HOLDER_ROOT','LINK','PRODUCT_ROOT_LINK','PRODUCT_ROOT_SPECIAL','PRODUCT_SPECIAL_CATEGORY','MEDIA','NEWS','NEWS_PAGE','NEWS_CATEGORY','BONUS_POINT_ITEM','LAYOUT_NEWS','LAYOUT_NEWS_CATEGORY','LAYOUT_NEWS_PAGE','PRODUCT_OPTION','DATAFILE','PRODUCT_BRAND','PRODUCT_BRAND_ROOT','DISCOUNT_PREPROCESS_RULE','DISCOUNT_POSTPROCESS_RULE','USER_DATAFILE_HOLDER', 'PRODUCT'
);
$smarty->assign('PermissionPropagateValidContainerObjectList', $PermissionPropagateValidContainerObjectList);

// Should be a super set of the above two array, a list of object to continue in the resursive search for permission update
$PermissionPropagateValidObjectList = array ('PAGE','LAYOUT','BLOCK_CONTENT','FOLDER','LINK','PRODUCT','PRODUCT_CATEGORY','MEDIA','NEWS','LAYOUT_NEWS', 'PRODUCT_ROOT', 'BLOCK_HOLDER', 'ALBUM', 'NEWS_ROOT', 'LAYOUT_NEWS_ROOT', 'ALBUM_ROOT', 'BONUS_POINT_ITEM', 'BONUS_POINT_ROOT', 'USER_DATAFILE_HOLDER', 'USER_ROOT');

$MediaTypeList = array (
	'gif', 'jpg', 'png', 'avi', 'wmv', 'mov', 'mpg', 'mp3', 'wma', 'ra'
);

$OrderStatusList = array (
	'any' => 'Any',
	'awaiting_freight_quote' => 'Awaiting Freight Quote',
	'awaiting_order_confirmation' => 'Awaiting Order Confirmation',
	'order_cancelled' => 'Order Cancelled',
	'payment_pending' => 'Payment Pending',
	'payment_confirmed' => 'Payment Confirmed',
	'partial_shipped' => 'Partial Shipped',
	'shipped' => 'Shipped', 
	'void' => 'Void'
);

$WorkflowResultList = array(
	'OVERRIDED' => 'Overrided by a new workflow',
//	'RETURN_TO_SENDER' => 'Returned to sender',
	'AWAITING_APPROVAL' => 'Awaiting approval',
	'APPROVED' => 'Approved',
	'REJECTED' => 'Rejected'
);
$smarty->assign('WorkflowResultList', $WorkflowResultList);

$ValidGitActionType = array('ssh_access_update', 'git_creation', 'git_deploy', 'git_hook', 'update_linux_user', 'git_delete');
$smarty->assign('ValidGitActionType', $ValidGitActionType);

define('ADMINPASSWORD_MD5_SEED',	'dfh3ixnsjj3');
define('CLIENTPASSWORD_MD5_SEED',	'dfh3ixnsjj3');
define('FTP_TEST_FILENAME',			'ftptestfilename_39shckwoewkjfjkbowx.txt');
define('FTP_TEST_FILECONTENT',		'TESTING123456789TESTING123456789');
define('DEFAULT_ORDER_ID', 999999);
define('SUPER_ADMIN_LEVEL', 9999);
define('NUM_OF_NEWS_PER_PAGE', 20);
define('NUM_OF_ADMIN_MSGS_PER_PAGE', 20);
define('NUM_OF_USERS_PER_PAGE', 20);
define('NUM_OF_ORDERS_PER_PAGE', 20);
define('NUM_OF_PHOTOS_PER_PAGE', 10);
define('NUM_OF_GENERAL_CUSTOM_FIELDS', 20);
define('NUM_OF_CUSTOM_INT_FIELDS', 20);
define('NUM_OF_CUSTOM_DOUBLE_FIELDS', 20);
define('NUM_OF_CUSTOM_DATE_FIELDS', 20);
define('NUM_OF_CUSTOM_TEXT_FIELDS', 20);
define('NUM_OF_CONTENT_WRITER_PER_PAGE', 10);
define('NUM_OF_ELASING_USER_PER_PAGE', 10);
define('NUM_OF_ELASING_SUBSCRIBER_PER_PAGE', 50);
define('NUM_OF_ELASING_LIST_PER_PAGE', 10);
define('NUM_OF_ELASING_CAMPAIGN_PER_PAGE', 10);
define('NUM_OF_PRODUCTS_PER_PAGE', 10);
define('NUM_OF_PRODUCT_BRANDS_PER_PAGE', 10);
define('NUM_OF_TRANSACTIONS_PER_PAGE', 20);
define('NO_OF_PRODUCT_CAT_SPECIAL', 20);
define('MAX_VOTE_NO', 9);
define('PRODUCT_OPTION_DATA_TEXT_MAX_NO', 9);
define('TRANSACTION_PER_PAGE', 50);
define('NO_OF_PRODUCT_GROUP_FIELDS', 9);
define('NO_OF_CUSTOM_RGB_FIELDS', 9);

define('OBJECT_DEFAULT_ARCHIVE_DATE', '2038-01-01 00:00:00');
define('OBJECT_DEFAULT_PUBLISH_DATE', '2000-01-01 00:00:00');

define('SOFT_BOUNCE_LIMIT', 5);
define('HARD_BOUNCE_LIMIT', 1);

define('COUNTRY_ID_OTHER', 258);

define('GIT_HOST', 'host02.aveego.com');

define('MYSQL_DUMP_FILENAME', 'posdump_zxzxzx.sql');