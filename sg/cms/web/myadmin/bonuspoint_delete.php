<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_bonus_point.php');

acl::AclBarrier("acl_bonuspoint_delete", __FILE__, false);

$BonusPointItem = bonuspoint::GetBonusPointItemInfo($_REQUEST['id'], 0);

if ($BonusPointItem['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'bonuspoint_list.php', __LINE__);
$smarty->assign('BonusPointItem', $BonusPointItem);

acl::ObjPermissionBarrier('delete', $BonusPointItem, __FILE__, false);

if (!bonuspoint::IsBonusPointItemRemovable($_REQUEST['id']))
	AdminDie(ADMIN_ERROR_BONUS_POINT_ITEM_IS_NOT_REMOVABLE, 'bonuspoint_list.php', __LINE__);

bonuspoint::UpdateTimeStamp($BonusPointItem['object_id']);
bonuspoint::DeleteBonusPointItem($BonusPointItem['object_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: bonuspoint_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));