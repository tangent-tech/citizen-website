<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'content_admin');
$smarty->assign('MyJS', 'myseo');

$RubbishKey = array('<noscript>', '</noscript>');

$SearchKey  = array(
	'網頁設計', '網站設計', '網上商店', '網頁服務', '網站服務', '網站服務', '網站管理', '網頁製作', '網站製作', '網上推廣', 'SEO', 'seo', 'CMS', 'cms'
);
$ReplaceKey = array(
	'<a title="網頁設計" href="http://www.aveego.com">網頁設計</a>',
	'<a title="網站設計" href="http://www.aveego.com">網站設計</a>',
	'<a title="網上商店" href="http://www.aveego.com">網上商店</a>',
	'<a title="網頁服務" href="http://www.aveego.com">網頁服務</a>',
	'<a title="網站服務" href="http://www.aveego.com">網站服務</a>',
	'<a title="網頁管理" href="http://www.aveego.com">網頁管理</a>',
	'<a title="網站管理" href="http://www.aveego.com">網站管理</a>',
	'<a title="網頁製作" href="http://www.aveego.com">網頁製作</a>',
	'<a title="網站製作" href="http://www.aveego.com">網站製作</a>',
	'<a title="網上推廣" href="http://www.aveego.com">網上推廣</a>',
	'<a title="SEO" href="http://www.aveego.com">SEO</a>',
	'<a title="SEO" href="http://www.aveego.com">SEO</a>',
	'<a title="CMS" href="http://www.aveego.com">CMS</a>',
	'<a title="CMS" href="http://www.aveego.com">CMS</a>'
);

$NewContent = trim($_REQUEST['content_input']);

for ($i = 0; $i < 50; $i++)
	$NewContent = str_replace("\n\n", "\n", $NewContent);
		
$TCNewContent = iconv("UTF-8", "gb2312//TRANSLIT", $NewContent);
$TCNewContent = iconv("gb2312", "big5//TRANSLIT", $TCNewContent);
$TCNewContent = iconv("big5", "UTF-8//TRANSLIT", $TCNewContent);

$NewContent = str_replace(array("<", ">"), array("&lt;", "&gt;"),$NewContent);
$TCNewContent = str_replace(array("<", ">"), array("&lt;", "&gt;"), $TCNewContent);

$NewContent = htmlspecialchars($NewContent, ENT_IGNORE , 'UTF-8');
$TCNewContent = htmlspecialchars($TCNewContent, ENT_IGNORE , 'UTF-8');

$NewContent = str_replace($SearchKey, $ReplaceKey, $NewContent);
$NewContent = str_replace($RubbishKey, '', $NewContent);
$TCNewContent = str_replace($SearchKey, $ReplaceKey, $TCNewContent);
$TCNewContent = str_replace($RubbishKey, '', $TCNewContent);

$NewContent = nl2br($NewContent);
$TCNewContent = nl2br($TCNewContent);

$smarty->assign('TCNewContent', $TCNewContent);
$smarty->assign('NewContent', $NewContent);

$smarty->assign('TITLE', 'Add Content Admin');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/myseo_act.tpl');