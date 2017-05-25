<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_url_submit');
$smarty->assign('MyJS', 'z_seo_article_submit');

$smarty->assign('TITLE', 'Add SEO URL');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_url_submit.tpl');