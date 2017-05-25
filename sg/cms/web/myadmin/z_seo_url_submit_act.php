<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_url_submit');
$smarty->assign('MyJS', 'z_seo_url_submit_act');

if (strlen(trim($_REQUEST['new_url'])) > 0) {
	$tags = explode(",", $_REQUEST['keyword']);
	$KeywordTagText = ', ';
	foreach ($tags as $T)
		$KeywordTagText = $KeywordTagText . strtolower(trim($T)) . ", ";
	
	$query =	"	INSERT INTO	z_seo_url " .
				"	SET		z_seo_url_address	= '" . aveEscT($_REQUEST['new_url']) . "', " .
				"			z_seo_url_keywords	= '" . aveEsc($KeywordTagText) . "'" .
				"	ON DUPLICATE KEY UPDATE z_seo_url_id = z_seo_url_id ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

header( 'Location: z_seo_url_submit.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));