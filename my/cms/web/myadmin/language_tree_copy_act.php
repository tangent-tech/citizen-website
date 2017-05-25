<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$SrcLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['src_language_tree_id'], $_SESSION['site_id']);
$DestLanguageRoot = language::GetSiteLanguageRoot($_REQUEST['dest_language_tree_id'], $_SESSION['site_id']);

if ($SrcLanguageRoot == null || $DestLanguageRoot == null)
	AdminDie("Invalid language_id.", 'language_manage.php', __LINE__);
if ($_REQUEST['src_language_tree_id'] == $_REQUEST['dest_language_tree_id'])
	AdminDie("Sorry, not supported to copy to itself.", 'language_manage.php', __LINE__);

set_time_limit(1200);

language::CopyLanguageTree($SrcLanguageRoot, $DestLanguageRoot, $Site);

header( 'Location: language_manage.php?SystemMessage=' . urlencode(ADMIN_MSG_COPY_SUCCESS));