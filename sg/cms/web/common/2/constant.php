<?php
define ('CMS_PRODUCT_NAME', 'CMS');

define ('ADMIN_DELETE_OPTION_TEXT', '***** DELETE *****');

define ('WORKFLOW_SENDER_EMAIL',	'no-reply@369cms.com');
define ('WORKFLOW_SENDER_NAME',		'369CMS');

define ('ADMIN_ERROR_CANNOT_DELETE_YOURSELF', 'Sorry, you cannot delete yourself!');
define ('ADMIN_ERROR_NOT_YOUR_SITE', 'Sorry, you are not allowed to manage this site.');
define ('ADMIN_ERROR_LOGIN_FIRST', 'Sorry, you must login first.');
define ('ADMIN_ERROR_NO_SITE_TO_MANAGE', 'Sorry, there is no site for you to manage.');
define ('ADMIN_ERROR_WRONG_PASSWORD', 'Sorry, password is incorrect.');
define ('ADMIN_ERROR_INVALID_EMAIL', 'Sorry, invalid email address.');
define ('ADMIN_ERROR_INVALID_USERNAME', 'Sorry, invalid username.');
define ('ADMIN_ERROR_USERNAME_ALREADY_EXIST', 'Sorry, username already exists.');
define ('ADMIN_ERROR_INVALID_PASSWORD_LENGTH', 'Password length must between ' . MIN_PASSWORD . ' to ' . MAX_PASSWORD);
define ('ADMIN_ERROR_PASSWORDS_DO_NOT_MATCH', 'Password does not match.');
define ('ADMIN_ERROR_SYSTEM_ADMIN_EMAIL_EXIST', 'This email already exists.');
define ('ADMIN_ERROR_API_LOGIN_EXIST', 'This API Login already exists.');
define ('ADMIN_ERROR_INVALID_LAYOUT_NAME', 'You must enter a layout name.');
define ('ADMIN_ERROR_UPLOAD_FILE_FAIL', 'Sorry, fail to save your file to the server. Please report to us if this problem persists.');
define ('ADMIN_ERROR_PRODUCT_PRICE_LEVEL_ZERO_MUST_BE_GREATER_THAN_ZERO', 'Sorry, you must enter a price value for mininum quantity 0.');
define ('ADMIN_ERROR_ERROR', 'Error');
define ('ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER', 'Error updating. Please refresh your browser.');
define ('ADMIN_ERROR_AJAX_MOVE_TO_SAME_PARENT', 'Sorry, the object is already inside the target parent object.');
define ('ADMIN_ERROR_AJAX_PRODUCT_CAT_MOVE_TO_PRODUCT_GROUP', 'Sorry, you cannot move a product category inside a product group.');
// Use the error below when the error checking is on those paremeter passing between pages. Most likely it is our own programming fault or brower back/forward problem.
define ('ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR', 'Invalid internal data detected. Please report to us if this problem persists.');
define ('ADMIN_ERROR_NO_SITE_LANGUAGE_HAS_ENABLED', 'Sorry, no site language has enabled.');
define ('ADMIN_ERROR_NO_NEWS_CATEGORY', 'Sorry, you must create a news category first.');
define ('ADMIN_ERROR_NO_LAYOUT_NEWS_CATEGORY', 'Sorry, you must create a layout news category first.');
define ('ADMIN_ERROR_CURRENCY_IS_NOT_REMOVABLE', 'Sorry, currency is not removable as it is the site default currency.');
define ('ADMIN_ERROR_PRODUCT_IS_NOT_REMOVABLE', 'Sorry, product is not removable as it is linked to previous orders. You may disable it instead.');
define ('ADMIN_ERROR_PRODUCT_OPTION_IS_NOT_REMOVABLE', 'Sorry, product option is not removable as it is linked to previous orders. You may disable it instead.');
define ('ADMIN_ERROR_BONUS_POINT_ITEM_IS_NOT_REMOVABLE', 'Sorry, bonus point item is not removable as it is linked to previous orders. You may disable it instead.');
define ('ADMIN_ERROR_NOT_ENOUGH_BONUS_POINT_TO_PROCEED_ORDER', 'User does not have enough bonus point to proceed order.');
define ('ADMIN_ERROR_NOT_ENOUGH_BALANCE_TO_PROCEED_ORDER', 'User does not have enough balance to proceed order.');
define ('ADMIN_ERROR_MYORDER_UNDER_STOCK', 'Some items are under stock.');
define ('ADMIN_ERROR_BONUS_POINT_COUPON_INVALID_VALUE', 'Sorry, you must create a coupon with positive bonus point value.');
define ('ADMIN_ERROR_WATERMARK_MUST_BE_PNG', 'Watermark must be in png format');
define ('ADMIN_ERROR_STOCK_IN_OUT_BASKET_CONTAINS_NO_PRODUCTS', 'Sorry, the Stock In/Out Basket is empty.');
define ('ADMIN_ERROR_ALL_PRODUCT_QUANTITY_IS_ZERO', 'Sorry, you must ship something.');
define ('ADMIN_ERROR_SERVER_IS_TOO_BUSY', 'Sorry, server is too busy. Please try again.');
define ('ADMIN_ERROR_ORDER_IS_DELETED', 'Sorry, order has been deleted.');
define ('ADMIN_ERROR_DISCOUNT_RULE_IS_NOT_REMOVABLE', 'Sorry, discount rule is not removable as it is linked to previous orders. You may disable it instead.');

define ('ADMIN_ERROR_CANNOT_CONVERT_TO_PRODUCT_GROUP_SUB_PRODUCT_CATEGORY_INSIDE', 'Sorry, you cannot enable product group if there is sub product category inside.');
define ('ADMIN_ERROR_CANNOT_CONVERT_TO_PRODUCT_GROUP_PRODUCT_INSIDE_IS_IN_MULTI_CAT', 'Sorry, you cannot enable product group if product inside is under multi product category.');
define ('ADMIN_ERROR_ALL_PRODUCTS_IN_PRODUCT_GROUP_IS_DISABLED', 'Sorry, all products in the product group is disabled. You cannot enable this product group.');

define ('ADMIN_ERROR_ORDER_CANNOT_BE_VOIDED', 'Sorry, order cannot be voided');

define ('ADMIN_ERROR_ARTICLE_QUOTA_FULL', 'Sorry, article quota is full.');
define ('ADMIN_ERROR_PRODUCT_QUOTA_FULL', 'Sorry, product quota is full.');
define ('ADMIN_ERROR_NEWS_QUOTA_FULL', 'Sorry, news quota is full.');
define ('ADMIN_ERROR_LAYOUT_NEWS_QUOTA_FULL', 'Sorry, layout news quota is full.');
define ('ADMIN_ERROR_INCOMPATIBLE_LINUX_USER',	'Sorry, incompatible linux user');
define ('ADMIN_ERROR_LINUX_USER_DIR_DOES_NOT_EXIST', 'Sorry, linux user dir does not exist. Ask sysadmin to fix it.');
define ('ADMIN_ERROR_GIT_NAME_IS_IN_USE',	'Sorry, linux user already in use');
define ('ADMIN_ERROR_LINUX_USER_NOT_FOUND',	'Sorry, linux user does not exist');
define ('ADMIN_ERROR_GIT_BRANCH_NAME_INVALID', 'Sorry, invalid git branch name');

define ('ADMIN_MSG_UPDATE_SUCCESS', 'Updated successfully.');
define ('ADMIN_MSG_NEW_SUCCESS', 'Added successfully.');
define ('ADMIN_MSG_RENAME_SUCCESS', 'Renamed successfully.');
define ('ADMIN_MSG_DELETE_SUCCESS', 'Removed successfully.');
define ('ADMIN_MSG_ENABLE_SUCCESS', 'Enabled successfully.');
define ('ADMIN_MSG_ROLLBACK_SUCCESS', 'Rollbacked successfully.');
define ('ADMIN_MSG_DISABLE_SUCCESS', 'Disabled successfully.');
define ('ADMIN_MSG_COPY_SUCCESS', 'Copied successfully.');
define ('ADMIN_MSG_PRODUCT_PHOTO_HIGHLIGHT_SUCCESS', 'Photo has been set as highlight successfully.');
define ('ADMIN_MSG_PRODUCT_GROUP_ENABLE_SUCCESS', 'Product Group enabled successfully.');
define ('ADMIN_MSG_PRODUCT_GROUP_DISABLE_SUCCESS', 'Product Group disabled successfully.');
define ('ADMIN_MSG_PRODUCT_ENABLE_SUCCESS', 'Product enabled successfully.');
define ('ADMIN_MSG_PRODUCT_DISABLE_SUCCESS', 'Product disabled successfully.');
define ('ADMIN_MSG_FOLDER_ENABLE_SUCCESS', 'Folder enabled successfully.');
define ('ADMIN_MSG_FOLDER_DISABLE_SUCCESS', 'Folder disabled successfully.');
define ('ADMIN_MSG_PAGE_ENABLE_SUCCESS', 'Page enabled successfully.');
define ('ADMIN_MSG_PAGE_DISABLE_SUCCESS', 'Page disabled successfully.');

define ('ADMIN_MSG_MODULE_DISABLED_ALL',			'No module is enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_ALBUM',			'Album Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_ARTICLE',		'Article Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_NEWS',			'News Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_LAYOUT_NEWS',	'Layout News Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_PRODUCT',		'Product Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_MEMBER',			'Member Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_ORDER',			'Order Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_BONUS_POINT',	'Bonus Point Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_NEWSLETTER',		'Newsletter Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_INVENTORY',		'Inventory Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_INVOICE',		'Invoice is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_DN',				'Delivery Note is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_GROUP_BUY', 		'Group Buy Module is not enabled. Please contact our sales representative for more details.');
define ('ADMIN_MSG_MODULE_DISABLED_DISCOUNT_RULE',	'Discount Rule Module is not enabled. Please contact our sales representative for more details.');

define ('ADMIN_MSG_ACL_NOT_AUTH',			'Sorry, you are not authorised for this operation.');
define ('ADMIN_MSG_PERMISSION_NOT_AUTH',	'Sorry, you are not authorised to apply the operation on this item.');

$DiscountPreprocessConditionType = array(
											1 => 'Product is under product category',
											2 => 'Product is under brand',
											3 => 'Product is under special category'
										);
$smarty->assign('DiscountPreprocessConditionType', $DiscountPreprocessConditionType);

$BundleDiscountConditionType = array(
											1 => 'Product is under product category',
											2 => 'Product is under special category',
											3 => 'Product ID is '
										);
$smarty->assign('BundleDiscountConditionType', $BundleDiscountConditionType);

$ACL_LIST = array(
	'Module' => array(
		'acl_module_sitemap_show'		=> array ('desc' => 'show Sitemap module',		'default' => false),
		'acl_module_site_block_show'	=> array ('desc' => 'show Site Block module',	'default' => false),
		'acl_module_album_show'			=> array ('desc' => 'show Album module',		'default' => false),
		'acl_module_news_show'			=> array ('desc' => 'show News module',			'default' => false),
		'acl_module_layout_news_show'	=> array ('desc' => 'show Layout News module',	'default' => false),
		'acl_module_product_show'		=> array ('desc' => 'show Product module',		'default' => false),
		'acl_module_bonus_point_show'	=> array ('desc' => 'show Bonus Point module',	'default' => false),
		'acl_module_member_show'		=> array ('desc' => 'show Member module',		'default' => false),
		'acl_module_inventory_show'		=> array ('desc' => 'show Inventory module',	'default' => false),
		'acl_module_order_show'			=> array ('desc' => 'show Order module',		'default' => false),
		'acl_module_redeem_show'		=> array ('desc' => 'show Redeem module',		'default' => false),
		'acl_module_currency_show'		=> array ('desc' => 'show Currency module',		'default' => false),
		'acl_module_discount_rule_show'	=> array ('desc' => 'show Discount Rule module','default' => false)
	),
	'Sitemap' => array(
		'acl_sitemap_add'				=> array ('desc' => 'sitemap - add item',		'default' => false),
		'acl_sitemap_edit'				=> array ('desc' => 'sitemap - edit item',		'default' => false),
		'acl_sitemap_delete'			=> array ('desc' => 'sitemap - delete item',	'default' => false),
		'acl_sitemap_move'				=> array ('desc' => 'sitemap - move item',		'default' => false),
		'acl_sitemap_rename'			=> array ('desc' => 'sitemap - rename item',	'default' => false),
		'acl_sitemap_duplicate'			=> array ('desc' => 'sitemap - duplicate',		'default' => false),
		'acl_sitemap_set_index'			=> array ('desc' => 'sitemap - set index item',	'default' => false)
	),
	'Link' => array(
		'acl_link_add'					=> array ('desc' => 'link - add',		'default' => false),
		'acl_link_edit'					=> array ('desc' => 'link - edit',		'default' => false),
		'acl_link_delete'				=> array ('desc' => 'link - delete',	'default' => false),
		'acl_link_move'					=> array ('desc' => 'link - move',		'default' => false),
		'acl_link_duplicate'			=> array ('desc' => 'link - duplicate',	'default' => false)	
	),
	'Page' => array(
		'acl_page_add'					=> array ('desc' => 'page - add',		'default' => false),
		'acl_page_edit'					=> array ('desc' => 'page - edit',		'default' => false),
		'acl_page_delete'				=> array ('desc' => 'page - delete',	'default' => false),
		'acl_page_move'					=> array ('desc' => 'page - move',		'default' => false),
		'acl_page_duplicate'			=> array ('desc' => 'page - duplicate',	'default' => false)	
	),
	'News' => array(
		'acl_news_list'					=> array ('desc' => 'news - list',				'default' => false),	
		'acl_news_add'					=> array ('desc' => 'news - add',				'default' => false),
		'acl_news_edit'					=> array ('desc' => 'news - edit',				'default' => false),
		'acl_news_delete'				=> array ('desc' => 'news - delete',			'default' => false),
		'acl_news_page_add'				=> array ('desc' => 'news page - add',			'default' => false),
		'acl_news_page_edit'			=> array ('desc' => 'news page - edit',			'default' => false),
		'acl_news_page_delete'			=> array ('desc' => 'news page - delete',		'default' => false),
		'acl_news_page_move'			=> array ('desc' => 'news page - move',			'default' => false),
		'acl_news_page_duplicate'		=> array ('desc' => 'news page - duplicate',	'default' => false),
		'acl_news_category_list'		=> array ('desc' => 'news category - list',		'default' => false),	
		'acl_news_category_add'			=> array ('desc' => 'news category - add',		'default' => false),
		'acl_news_category_edit'		=> array ('desc' => 'news category - edit',		'default' => false),
		'acl_news_category_delete'		=> array ('desc' => 'news category - delete',	'default' => false)
	),
	'Layout News' => array(
		'acl_layout_news_list'				=> array ('desc' => 'layout news - list',				'default' => false),	
		'acl_layout_news_add'				=> array ('desc' => 'layout news - add',				'default' => false),
		'acl_layout_news_edit'				=> array ('desc' => 'layout news - edit',				'default' => false),
		'acl_layout_news_delete'			=> array ('desc' => 'layout news - delete',				'default' => false),
		'acl_layout_news_page_add'			=> array ('desc' => 'layout news page - add',			'default' => false),
		'acl_layout_news_page_edit'			=> array ('desc' => 'layout news page - edit',			'default' => false),
		'acl_layout_news_page_delete'		=> array ('desc' => 'layout news page - delete',		'default' => false),
		'acl_layout_news_page_move'			=> array ('desc' => 'layout news page - move',			'default' => false),
		'acl_layout_news_page_duplicate'	=> array ('desc' => 'layout news page - duplicate',		'default' => false),
		'acl_layout_news_category_list'		=> array ('desc' => 'layout news category - list',		'default' => false),
		'acl_layout_news_category_add'		=> array ('desc' => 'layout news category - add',		'default' => false),
		'acl_layout_news_category_edit'		=> array ('desc' => 'layout news category - edit',		'default' => false),
		'acl_layout_news_category_delete'	=> array ('desc' => 'layout news category - delete',	'default' => false)
	),
	'Folder' => array(
		'acl_folder_add'				=> array ('desc' => 'folder - add',			'default' => false),
		'acl_folder_edit'				=> array ('desc' => 'folder - edit',		'default' => false),
		'acl_folder_delete'				=> array ('desc' => 'folder - delete',		'default' => false),
		'acl_folder_move'				=> array ('desc' => 'folder - move',		'default' => false),
		'acl_folder_duplicate'			=> array ('desc' => 'folder - duplicate',	'default' => false),
		'acl_folder_add_child'			=> array ('desc' => 'folder - add child',	'default' => false)
	),
	'Album' => array(
		'acl_album_list'				=> array ('desc' => 'album - list',			'default' => false),
		'acl_album_add'					=> array ('desc' => 'album - add',			'default' => false),
		'acl_album_edit'				=> array ('desc' => 'album - edit',			'default' => false),
		'acl_album_delete'				=> array ('desc' => 'album - delete',		'default' => false),
		'acl_album_move'				=> array ('desc' => 'album - move',			'default' => false),
		'acl_album_sort'				=> array ('desc' => 'album - sort',			'default' => false),
		'acl_album_add_child'			=> array ('desc' => 'album - add child',	'default' => false),
		'acl_album_link_add'			=> array ('desc' => 'album link - add',		'default' => false),		
		'acl_album_link_edit'			=> array ('desc' => 'album link - edit',	'default' => false),
		'acl_album_link_delete'			=> array ('desc' => 'album link - delete',	'default' => false),
		'acl_album_link_move'			=> array ('desc' => 'album link - move',	'default' => false),
		'acl_album_link_duplicate'		=> array ('desc' => 'album - duplicate',	'default' => false)
	),
	'Bonus Point' => array(
		'acl_bonuspoint_list'			=> array ('desc' => 'bonuspoint - list',		'default' => false),
		'acl_bonuspoint_add'			=> array ('desc' => 'bonuspoint - add',			'default' => false),
		'acl_bonuspoint_edit'			=> array ('desc' => 'bonuspoint - edit',		'default' => false),
		'acl_bonuspoint_delete'			=> array ('desc' => 'bonuspoint - delete',		'default' => false),
		'acl_bonuspoint_sort'			=> array ('desc' => 'bonuspoint - sort',		'default' => false)
	),
	'Datafile' => array(
		'acl_datafile_add'				=> array ('desc' => 'datafile - add',		'default' => false),
		'acl_datafile_edit'				=> array ('desc' => 'datafile - edit',		'default' => false),
		'acl_datafile_delete'			=> array ('desc' => 'datafile - delete',	'default' => false),
		'acl_datafile_sort'				=> array ('desc' => 'datafile - sort',		'default' => false)	
	),
	'Product' => array(
		'acl_product_root_edit'				=> array ('desc' => 'product root - edit',				'default' => false),
		'acl_product_tree_list'				=> array ('desc' => 'product tree - list',				'default' => false),
		'acl_product_tree_move'				=> array ('desc' => 'product tree - move item',			'default' => false),
		'acl_product_tree_rename'			=> array ('desc' => 'product tree - rename item',		'default' => false),
		'acl_product_add'					=> array ('desc' => 'product - add',					'default' => false),
		'acl_product_edit'					=> array ('desc' => 'product - edit',					'default' => false),
		'acl_product_delete'				=> array ('desc' => 'product - delete',					'default' => false),
		'acl_product_move'					=> array ('desc' => 'product - move',					'default' => false),
		'acl_product_duplicate'				=> array ('desc' => 'product - duplicate',				'default' => false),
		'acl_product_root_link_add'			=> array ('desc' => 'product root link - add',			'default' => false),
		'acl_product_root_link_edit'		=> array ('desc' => 'product root link - edit',			'default' => false),
		'acl_product_root_link_delete'		=> array ('desc' => 'product root link - delete',		'default' => false),
		'acl_product_root_link_move'		=> array ('desc' => 'product root link - move',			'default' => false),
		'acl_product_root_link_duplicate'	=> array ('desc' => 'product root link - duplicate',	'default' => false),
		'acl_product_brand_manage'			=> array ('desc' => 'product brand - manage',			'default' => false),
		'acl_product_category_add'			=> array ('desc' => 'product category - add',			'default' => false),
		'acl_product_category_edit'			=> array ('desc' => 'product category - edit',			'default' => false),
		'acl_product_category_delete'		=> array ('desc' => 'product category - delete',		'default' => false),
		'acl_product_category_move'			=> array ('desc' => 'product category - move',			'default' => false),
		'acl_product_category_duplicate'	=> array ('desc' => 'product category - duplicate',		'default' => false),
		'acl_product_category_special_edit'	=> array ('desc' => 'product category special - edit',	'default' => false),
		'acl_product_category_special_move'	=> array ('desc' => 'product category special - move',	'default' => false),
		'acl_product_sort'					=> array ('desc' => 'product sort',						'default' => false)
	),
	'Media' => array(
		'acl_media_list'			=> array ('desc' => 'media - list',		'default' => false),
		'acl_media_add'				=> array ('desc' => 'media - add',		'default' => false),
		'acl_media_edit'			=> array ('desc' => 'media - edit',		'default' => false),
		'acl_media_delete'			=> array ('desc' => 'media - delete',	'default' => false),
		'acl_media_sort'			=> array ('desc' => 'media - sort',		'default' => false)
	),
	'Member' => array(
		'acl_member_list'				=> array ('desc' => 'member - list',				'default' => false),
		'acl_member_add'				=> array ('desc' => 'member - add',					'default' => false),
		'acl_member_edit'				=> array ('desc' => 'member - edit',				'default' => false),
		'acl_member_delete'				=> array ('desc' => 'member - delete',				'default' => false),
		'acl_member_bonuspoint_manage'	=> array ('desc' => 'member - manage bonus point',	'default' => false),
		'acl_member_export'				=> array ('desc' => 'member - export',				'default' => false),
		'acl_member_balance_manage'		=> array ('desc' => 'member - manage balance',		'default' => false),
		'acl_member_balance_list'		=> array ('desc' => 'member - list balance',		'default' => false),
		'acl_member_bonus_point_list'	=> array ('desc' => 'member - list bonus point',	'default' => false)
	),
	'Site Block' => array(
		'acl_siteblock_add'				=> array ('desc' => 'site block - add',			'default' => false),
		'acl_siteblock_edit'			=> array ('desc' => 'site block - edit',		'default' => false),
		'acl_siteblock_delete'			=> array ('desc' => 'site block - delete',		'default' => false),
		'acl_siteblock_move'			=> array ('desc' => 'site block - move',		'default' => false),
		'acl_siteblock_list'			=> array ('desc' => 'site block - list',		'default' => false)
	)
);
$smarty->assign('ACL_LIST', $ACL_LIST);

$PermissionOption = array(
	'ADMIN' => 'Admin',
	'OWNER' => 'Owner',
	'GROUP' => 'Group members',
	'OWNER_OR_GROUP' => 'Owner / Group members',
	'EVERYONE' => 'Any content writer'
);
$smarty->assign('PermissionOption', $PermissionOption);

$ContentAdminMsgStatusList = array(
	'Any', 'Unread'
);
$smarty->assign('ContentAdminMsgStatusList', $ContentAdminMsgStatusList);


$ProductCategoryBasicGroupValidFields = array(
	'' => "",
	'p_product_code' => "產品編號",
	'p_factory_code' => "廠商編號",
	'p_product_weight' => "重量",
	'p_product_size' => "尺碼",
//	'p_product_brand_id' => '品牌',
	'd_product_color' => '顏色',
	'd_product_packaging' => '包裝'
);
?>
