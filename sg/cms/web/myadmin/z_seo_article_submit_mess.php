<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_submit_mess');
$smarty->assign('MyJS', 'z_seo_article_submit');

$smarty->assign('TITLE', 'Add SEO Article');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_article_submit_mess.tpl');