<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_media_add", __FILE__, false);

if ($_REQUEST['refer'] == 'product_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'product_category_edit' || $_REQUEST['refer'] == 'product_category_special_edit')
	require_once('../common/header_product.php');
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	require_once('../common/header_order.php');
else
	require_once('../common/header_album.php');

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'media_add_act');

$SmallWidth = 0;
$SmallHeight = 0;
$BigWidth = 0;
$BigHeight = 0;

$Resize = true;
$WatermarkIDBig = 0;
$WatermarkIDSmall = 0;

$ParentObj = null;

if ($_REQUEST['refer'] == 'product_edit') {

	$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
	if ($ObjectLink['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
	$smarty->assign('ObjectLink', $ObjectLink);

	acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
	
	$Product = product::GetProductInfo($ObjectLink['object_id'], 0);
	$ParentObj = $Product;
	if ($Product['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
	$SmallWidth = $Site['site_product_media_small_width'];
	$SmallHeight = $Site['site_product_media_small_height'];
	$BigWidth = $Site['site_product_media_big_width'];
	$BigHeight = $Site['site_product_media_big_height'];

	if ($Site['site_product_media_resize'] != 'Y')
		$Resize = false;

	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_big_file_id']) != 0)
		$WatermarkIDBig = $Site['site_product_media_watermark_big_file_id'];
	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_small_file_id']) != 0)
		$WatermarkIDSmall = $Site['site_product_media_watermark_small_file_id'];
}
elseif ($_REQUEST['refer'] == 'product_category_edit') {

	$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
	if ($ObjectLink['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
	$smarty->assign('ObjectLink', $ObjectLink);

	acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
	
	$ProductCat = product::GetProductCatInfo($ObjectLink['object_id'], 0);
	$ParentObj = $ProductCat;
	if ($ProductCat['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
	$SmallWidth = $Site['site_product_media_small_width'];
	$SmallHeight = $Site['site_product_media_small_height'];
	$BigWidth = $Site['site_product_media_big_width'];
	$BigHeight = $Site['site_product_media_big_height'];

	if ($Site['site_product_media_resize'] != 'Y')
		$Resize = false;

	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_big_file_id']) != 0)
		$WatermarkIDBig = $Site['site_product_media_watermark_big_file_id'];
	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_small_file_id']) != 0)
		$WatermarkIDSmall = $Site['site_product_media_watermark_small_file_id'];
}
elseif ($_REQUEST['refer'] == 'product_category_special_edit') {

	$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
	if ($ObjectLink['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'index.php', __LINE__);
	$smarty->assign('ObjectLink', $ObjectLink);

	acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);

	$ProductCatSpecial = product::GetProductCatSpecialInfo($ObjectLink['object_id'], 0);
	$ParentObj = $ProductCatSpecial;
	if ($ProductCatSpecial['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);
	$SmallWidth = $Site['site_product_media_small_width'];
	$SmallHeight = $Site['site_product_media_small_height'];
	$BigWidth = $Site['site_product_media_big_width'];
	$BigHeight = $Site['site_product_media_big_height'];

	if ($Site['site_product_media_resize'] != 'Y')
		$Resize = false;

	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_big_file_id']) != 0)
		$WatermarkIDBig = $Site['site_product_media_watermark_big_file_id'];
	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_small_file_id']) != 0)
		$WatermarkIDSmall = $Site['site_product_media_watermark_small_file_id'];
}
elseif ($_REQUEST['refer'] == 'bonuspoint_edit') {
	$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['id'], 0);
	$ParentObj = $BonusPointItem;
	if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'bonuspoint_list.php', __LINE__);

	acl::ObjPermissionBarrier("edit", $BonusPointItem, __FILE__, false);	
	
	$SmallWidth = $Site['site_product_media_small_width'];
	$SmallHeight = $Site['site_product_media_small_height'];
	$BigWidth = $Site['site_product_media_big_width'];
	$BigHeight = $Site['site_product_media_big_height'];

	if ($Site['site_product_media_resize'] != 'Y')
		$Resize = false;

	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_big_file_id']) != 0)
		$WatermarkIDBig = $Site['site_product_media_watermark_big_file_id'];
	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_product_media_watermark_small_file_id']) != 0)
		$WatermarkIDSmall = $Site['site_product_media_watermark_small_file_id'];
}
else {
	$Album = album::GetAlbumInfo($_REQUEST['id'], 0);
	$ParentObj = $Album;
	if ($Album['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'album_list.php', __LINE__);

	acl::ObjPermissionBarrier("add_children", $Album, __FILE__, false);	
	
	$SmallWidth = $Site['site_media_small_width'];
	$SmallHeight = $Site['site_media_small_height'];
	$BigWidth = $Site['site_media_big_width'];
	$BigHeight = $Site['site_media_big_height'];

	if ($Site['site_media_resize'] != 'Y')
		$Resize = false;

	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_media_watermark_big_file_id']) != 0)
		$WatermarkIDBig = $Site['site_media_watermark_big_file_id'];
	if (isset($_REQUEST['AddWatermark']) && $_REQUEST['AddWatermark'] == 'Y' && intval($Site['site_media_watermark_small_file_id']) != 0)
		$WatermarkIDSmall = $Site['site_media_watermark_small_file_id'];
}

if (!isset($_REQUEST['media_security_level']))
	$_REQUEST['media_security_level'] = $Site['site_default_security_level'];

$TotalMedia =0;
$MediaList = media::GetMediaList($ParentObj['object_id'], 0, $TotalMedia, 1, 999999, 999999, false, false);

$MediaFiles = ReformatMultiFilePost($_FILES['media']);
foreach ($MediaFiles as $Index => $TheFile) {
	if (isset($TheFile)) {
		if (ynval($_REQUEST['UpdateThumbnailOnly']) == 'Y') {
			if ($Index >= $TotalMedia)
				break;
			else
				media::UpdateMediaThumbnail($MediaList[$Index]['media_id'], $Site, $TheFile, 0, 0);
		}
		else {
			$MediaID = media::NewMediaWithObject($TheFile, $Site, $SmallWidth, $SmallHeight, $BigWidth, $BigHeight, $Resize, $WatermarkIDSmall, $WatermarkIDBig, $_REQUEST['media_security_level']);
			if ($MediaID !== false && $MediaID != 0) {
				object::NewObjectLink($_REQUEST['id'], $MediaID, 'Media File', 0, 'normal', DEFAULT_ORDER_ID);
				object::TidyUpObjectOrder($_REQUEST['id'], 'MEDIA');
				media::UpdateTimeStamp($MediaID);
			}
		}
	}
}

site::EmptyAPICache($_SESSION['site_id']);

if ($_REQUEST['refer'] == 'product_edit')
	header( 'Location: product_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'product_category_edit')
	header( 'Location: product_category_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'product_category_special_edit')
	header( 'Location: product_category_special_edit.php?link_id=' . $_REQUEST['link_id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
elseif ($_REQUEST['refer'] == 'bonuspoint_edit')
	header( 'Location: bonuspoint_edit.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));
else
	header( 'Location: media_list.php?id=' . $_REQUEST['id'] .  '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));