<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

site::DeleteSite($_REQUEST['site_id']);

header( 'Location: site_list.php?SystemMessage=' . urlencode(ADMIN_MSG_DELETE_SUCCESS));