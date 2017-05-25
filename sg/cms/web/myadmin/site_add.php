<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'site_management');
$smarty->assign('MyJS', 'site_add');

if (!isset($_REQUEST['site_ftp_userfile_dir']))
	$_REQUEST['site_ftp_userfile_dir'] = '/web/userfiles';
if (!isset($_REQUEST['site_ftp_filebase_dir']))
	$_REQUEST['site_ftp_filebase_dir'] = '/filebase';
if (!isset($_REQUEST['site_http_userfile_path']))
	$_REQUEST['site_http_userfile_path'] = '/userfiles';

if (!isset($_REQUEST['site_ftp_static_link_dir']))
	$_REQUEST['site_ftp_static_link_dir'] = '/web/static';
if (!isset($_REQUEST['site_http_static_link_path']))
	$_REQUEST['site_http_static_link_path'] = '/static';

$CurrencyList = currency::GetAllCurrencyList();
$smarty->assign('CurrencyList', $CurrencyList);

$LanguageList = language::GetAllLanguageList();
$smarty->assign('LanguageList', $LanguageList);

$smarty->assign('TITLE', 'Add Site');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_add.tpl');