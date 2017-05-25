<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_member.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");
acl::AclBarrier("acl_member_export", __FILE__, false);

$UserCustomFieldsDef = site::GetUserCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);

$Users = user::GetUserList($_SESSION['site_id'], 'ALL', '', 0, 999999);
$smarty->assign('Users', $Users);

$Output = $smarty->fetch('myadmin/' . $CurrentLang['language_id'] . '/member_export.tpl');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($Output));
// Output to browser with appropriate mime type, you choose ;)
//header("Content-type: text/x-csv");
header("Content-type: application/vnd.ms-excel");
//header("Content-type: text/csv");
//header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=member_export.xls");
echo $Output;
exit;