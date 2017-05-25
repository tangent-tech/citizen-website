<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');

$smarty->assign('TITLE', 'System Admin Login');

if (system_admin::Login($_REQUEST['email'], $_REQUEST['password'])) {
	$SystemAdmin = system_admin::GetSystemAdminInfo($_SESSION['SystemAdminID']);

	if ($SystemAdmin['system_admin_security_level'] >= SUPER_ADMIN_LEVEL) {
		header( 'Location: system_admin_list.php');
	}
	else {
		if (count(system_admin::GetSystemAdminSiteList($SystemAdmin['system_admin_id'])) > 0)
			header( 'Location: site_setting.php');
		else {
			$smarty->assign('ErrorMsg', ADMIN_ERROR_NO_SITE_TO_MANAGE);
			$smarty->display("myadmin/" . $CurrentLang['language_id'] . "/index.tpl");
		}
	}
}
elseif (content_admin::Login($_REQUEST['email'], $_REQUEST['password'])) {
	$ContentAdmin = content_admin::GetContentAdminInfo($_SESSION['ContentAdminID']);
	$ContentAdminSite = site::GetSiteInfo($ContentAdmin['site_id']);
	$_SESSION['site_id'] = $ContentAdmin['site_id'];
	$Site = site::GetSiteInfo($_SESSION['site_id']);

	if ($ContentAdmin['content_admin_type'] == 'CONTENT_ADMIN') {
		if ($Site['site_module_article_enable'] == 'Y')
			header( 'Location: language_root_list.php');
		elseif ($Site['site_module_elasing_enable'] == 'Y')
			header( 'Location: elasing_mailing_list.php');
		else{
			AdminDie(ADMIN_MSG_MODULE_DISABLED_ALL, 'index.php', __LINE__);
		}
	}
	elseif ($ContentAdmin['content_admin_type'] == 'ELASING_USER') {
		header( 'Location: elasing_mailing_list.php');
	}
	elseif ($ContentAdmin['content_admin_type'] == 'CONTENT_WRITER') {
		header( 'Location: language_root_list.php');
	}
}
else {
	$smarty->assign('ErrorMsg', ADMIN_ERROR_WRONG_PASSWORD);
	$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/index.tpl');
}