<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_xml_article.php');

header ("Content-Type:text/xml");

acl::AclBarrier("acl_sitemap_set_index", __FILE__, true);

$Node = null;
$status = 'ERROR';
$Node = object::GetObjectLinkInfo($_REQUEST['link_id']);

if ($Node == null || $Node['site_id'] != $_SESSION['site_id'])
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

if ($Node['object_type'] != 'PAGE')
	XMLDie(__LINE__, ADMIN_ERROR_AJAX_UPDATE_ERROR_REFRESH_BROWSER);

$SiteLanguageRoot = language::GetSiteLanguageRoot($Node['language_id'], $_SESSION['site_id']);

$query	=	"	UPDATE	language_root " .
			"	SET		index_link_id		= '". intval($_REQUEST['link_id']) . "'" .
			"	WHERE	language_root_id	= '" . intval($SiteLanguageRoot['language_root_id']) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$status = 'ok';
$msg = ADMIN_MSG_UPDATE_SUCCESS;

site::EmptyAPICache($_SESSION['site_id']);

$smarty->assign('status', $status);
$smarty->assign('msg', $msg);
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/language_tree_set_as_index_object.tpl');