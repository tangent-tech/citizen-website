<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_submit');
$smarty->assign('MyJS', 'z_seo_article_submit_2');

if (intval($_REQUEST['content_input_no']) != 1 && intval($_REQUEST['content_input_no']) != 2)
	AdminDie('You must select a version!', 'z_seo_article_submit.php', __LINE__);

$Subject = trim($_REQUEST['content_subject_' . $_REQUEST['content_input_no']]);
$Content = trim($_REQUEST['content_input' . $_REQUEST['content_input_no']]);
$Keyword = trim($_REQUEST['keyword_input_' . $_REQUEST['content_input_no']]);

$tags = explode(",", $Keyword);
$KeywordTagText = ', ';
foreach ($tags as $T)
	$KeywordTagText = $KeywordTagText . trim(strtolower($T)) . ", ";

$query =	"	INSERT INTO	z_seo_article " .
			"	SET		z_seo_article_title			= '" . aveEscT($Subject) . "', " .
			"			z_seo_article_content		= '" . aveEscT($Content) . "', " .
			"			z_seo_keyword				= '" . aveEsc($KeywordTagText) . "', " .
			"			z_seo_counter				= 0" .
			"	ON DUPLICATE KEY UPDATE	z_seo_article_id = z_seo_article_id ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

header( 'Location: z_seo_article_submit.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS) . '&ErrorMessage=' . urlencode($ErrorMessage));