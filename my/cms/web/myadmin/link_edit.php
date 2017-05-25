<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

acl::AclBarrier("acl_sitemap_edit", __FILE__, false);
acl::AclBarrier("acl_link_edit", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'language_root');
$smarty->assign('MyJS', 'link_edit');

$ObjectLink = object::GetObjectLinkInfo($_REQUEST['link_id']);
if ($ObjectLink['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
$smarty->assign('ObjectLink', $ObjectLink);

acl::ObjPermissionBarrier("edit", $ObjectLink, __FILE__, false);
acl::SetIsPublisherFlagForSmarty($ObjectLink);

$Link = link::GetLinkInfo($ObjectLink['object_id']);
$smarty->assign('Link', $Link);
$smarty->assign('TheObject', $Link);

$smarty->assign('TITLE', 'Edit Link');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/link_edit.tpl');