<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
include_once(FCK_BASEPATH . "/fckeditor.php");


$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'site');
$smarty->assign('MyJS', 'site_setting');

//$ConnectionTest = site::ConnectionTest($_SESSION['site_id']);
//$smarty->assign('ConnectionTest', $ConnectionTest);

$EditorEmailContent	= new FCKeditor('EditorEmailContent');
$EditorEmailContent->BasePath = FCK_BASEURL;
$EditorEmailContent->Value	= $Site['site_email_default_content'];
$EditorEmailContent->Width	= '700';
$EditorEmailContent->Height	= '400';
$EditorEmailContentHTML = $EditorEmailContent->Create();
$smarty->assign('EditorEmailContentHTML', $EditorEmailContentHTML);

$smarty->assign('TITLE', 'Site Setting');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_setting.tpl');