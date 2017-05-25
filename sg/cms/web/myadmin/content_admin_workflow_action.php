<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_any_header.php');
require_once('../common/header_site_content.php');
//require_once('../common/header_article.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

//acl::AclBarrier("acl_sitemap_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'content_admin_msg');
$smarty->assign('CurrentTab2', 'content_admin_task');
$smarty->assign('MyJS', 'content_admin_task_action');

$Workflow = workflow::GetWorkflowInfo($_REQUEST['id']);

if (!workflow::IsWorkflowReadableByContentAdmin($_REQUEST['id'], $AdminInfo['content_admin_id']))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'content_admin_task_list.php', __LINE__);
$smarty->assign('Workflow', $Workflow);

if ($Workflow['workflow_result'] != 'AWAITING_APPROVAL') {
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'content_admin_task_list.php', __LINE__);
}

if ($_REQUEST['myaction'] == 'reject' ) {
	$query =	"	UPDATE	workflow " .
				"	SET		workflow_result = 'REJECTED', " .
				"			workflow_result_content_admin_id = '" . $_SESSION['ContentAdminID'] . "', " .
				"			workflow_comment_by_receiver = '" . aveEscT($_REQUEST['workflow_comment_by_receiver']) . "' " .
				"	WHERE	workflow_id = '" . intval($Workflow['workflow_id']) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	
	if ($ContentAdminMsg['workflow_type'] == 'SECURITY_LEVEL_UPDATE_REQUEST') {
		$Msg = 'Security level update request rejected by ' . $AdminInfo['email'];

		workflow::NewContentAdminMsg($AdminInfo['content_admin_id'], $Workflow['sender_content_admin_id'], $Workflow['workflow_id'], $Msg);
	}
}
else if ($_REQUEST['myaction'] == 'accept' ) {
	$query =	"	UPDATE	workflow " .
				"	SET		workflow_result = 'APPROVED', " .
				"			workflow_result_content_admin_id = '" . $_SESSION['ContentAdminID'] . "', " .
				"			workflow_comment_by_receiver = '" . aveEscT($_REQUEST['workflow_comment_by_receiver']) . "' " .
				"	WHERE	workflow_id = '" . intval($Workflow['workflow_id']) . "' ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	if ($Workflow['workflow_type'] == 'SECURITY_LEVEL_UPDATE_REQUEST') {
		$Object = object::GetObjectInfo($ContentAdminMsg['object_id']);
		
		$query =	"	UPDATE	object " .
					"	SET		object_security_level = '" . intval($Workflow['workflow_para_int_1']) .  "' " .
					"	WHERE	object_id = '" . intval($Workflow['object_id']) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$ContentWriterList = array();
		$ContentAdminList = array();

		acl::GetObjectPublisherList($Object, $ContentWriterList, $ContentAdminList);

		$Msg = 'Security level update request accepted by ' . $AdminInfo['email'];

		workflow::NewContentAdminMsg($AdminInfo['content_admin_id'], $Workflow['sender_content_admin_id'], $Workflow['workflow_id'], $Msg);
	}
	
}

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: content_admin_workflow_details.php?id=' . $_REQUEST['id'] . '&SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));