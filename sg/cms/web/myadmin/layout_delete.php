<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$Layout = layout::GetLayoutInfo($_REQUEST['id']);
$smarty->assign('Layout', $Layout);

if ($Layout['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');

// Delete Layout Now!
layout::DeleteLayout($_REQUEST['id'], $Site);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: layout_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));