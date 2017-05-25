<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_album.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

acl::AclBarrier("acl_album_list", __FILE__, false);

$smarty->assign('CurrentTab', 'site_content');
$smarty->assign('CurrentTab2', 'album');
$smarty->assign('MyJS', 'album_list');

$Albums = album::GetAlbumList($Site['album_root_id']);
$smarty->assign('Albums', $Albums);

$smarty->assign('TITLE', 'Album List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/album_list.tpl');