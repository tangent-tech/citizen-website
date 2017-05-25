<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$SiteLanguageRoot = language::GetSiteLanguageRootByLanguageRootID($_REQUEST['id'], $_SESSION['site_id']);
if ($SiteLanguageRoot['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php', __LINE__);

site::DeleteSiteLanguageTree($SiteLanguageRoot['object_id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_manage.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));