<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$smarty->assign('CurrentTab', 'site_admin');
$smarty->assign('CurrentTab2', 'siteblock');
$smarty->assign('MyJS', 'siteblock_def_list');

$SiteBlockDefs = block::GetBlockDefListBySiteBlockHolderRootID($Site['site_block_holder_root_id']);
$smarty->assign('SiteBlockDefs', $SiteBlockDefs);

$smarty->assign('TITLE', 'Site Block Definition List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/siteblock_def_list.tpl');