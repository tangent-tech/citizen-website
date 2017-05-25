<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_bonus_point.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'bonus_point');
$smarty->assign('MyJS', 'bonus_point_root_edit_act');

$BonusPointRoot = object::GetObjectInfo($Site['bonus_point_root_id']);
$smarty->assign('TheObject', $BonusPointRoot);

object::UpdateObjectPermission($BonusPointRoot['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

header( 'Location: bonuspoint_root_edit.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));