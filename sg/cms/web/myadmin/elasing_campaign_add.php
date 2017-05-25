<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_list');
$smarty->assign('MyJS', 'elasing_campaign_list_add');

$TotalEmailList = 0;

if ($IsContentAdmin)
	$EmailList = emaillist::GetEmailListBySiteID($_SESSION['site_id'], $TotalEmailList, 1, 99999, 0, 'N');
elseif ($IsElasingUser)
	$EmailList = emaillist::GetEmailListBySiteID($_SESSION['site_id'], $TotalEmailList, 1, 99999, $_SESSION['ContentAdminID'], 'N');
$smarty->assign('EmailList', $EmailList);

$Editor	= new FCKeditor('ContentEditor');
$Editor->BasePath = FCK_BASEURL;
$Editor->Value	=  $Site['site_email_default_content'];
$Editor->Width	= '800';
$Editor->Height	= '600';
$EditorHTML	= $Editor->Create();
$smarty->assign('EditorHTML', $EditorHTML);

$smarty->assign('TITLE', 'Campaign List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_campaign_add.tpl');