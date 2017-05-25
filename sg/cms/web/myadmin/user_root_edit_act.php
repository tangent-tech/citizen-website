<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'member');
//$smarty->assign('CurrentTab2', 'member_all');
$smarty->assign('MyJS', 'user_root_edit');

$UserRoot = object::GetObjectInfo($Site['site_user_root_id']);

object::UpdateObjectPermission($UserRoot['object_id'], $_REQUEST['object_owner_content_admin_id'], $_REQUEST['object_owner_content_admin_group_id'], $_REQUEST['object_publisher_content_admin_group_id'], $_REQUEST['object_permission_browse_children'], $_REQUEST['object_permission_add_children'], $_REQUEST['object_permission_edit'], $_REQUEST['object_permission_delete'], intval($_REQUEST['object_permission_propagate_children_depth']));

header( 'Location: user_root_edit.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));