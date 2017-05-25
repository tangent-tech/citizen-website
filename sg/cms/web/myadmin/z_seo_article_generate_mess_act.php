<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
//require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_generate_mess');
$smarty->assign('MyJS', 'z_seo_article_submit_2');

if (strlen(trim($_REQUEST['new_url'])) > 0) {
	$tags = explode(",", $_REQUEST['keyword']);
	$KeywordTagText = ', ';
	foreach ($tags as $T)
		$KeywordTagText = $KeywordTagText . strtolower(trim($T)) . ", ";
	
	$query =	"	INSERT INTO	z_seo_url_mess " .
				"	SET		z_seo_url_address	= '" . aveEscT($_REQUEST['new_url']) . "', " .
				"			z_seo_url_keywords	= '" . aveEsc($KeywordTagText) . "'" .
				"	ON DUPLICATE KEY UPDATE z_seo_url_id = z_seo_url_id ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}

if (intval($_REQUEST['article_id']) > 0) {
	$query =	"	UPDATE	z_seo_article_mess " .
				"	SET		z_seo_counter		= z_seo_counter + 1 " . 
				"	WHERE	z_seo_article_id	= '" . intval($_REQUEST['article_id']) . "'";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
}


foreach ($_REQUEST['url_id'] as $url_id) {
	if (intval($url_id) > 0) {
		$query =	"	UPDATE	z_seo_url_mess " .
					"	SET		z_seo_url_counter	= z_seo_url_counter + 1 " . 
					"	WHERE	z_seo_url_id = '" . intval($url_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
}

header( 'Location: z_seo_article_generate_mess.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));