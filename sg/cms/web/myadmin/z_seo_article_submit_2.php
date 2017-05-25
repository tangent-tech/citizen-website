<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_submit');
$smarty->assign('MyJS', 'z_seo_article_submit_2');

$SearchKeyCount = array();
$SearchKeyCount2 = array();

$SCSubject = trim($_REQUEST['content_subject']);
$TCSubject = iconv("UTF-8", "gb2312//TRANSLIT", $SCSubject);
$TCSubject = iconv("gb2312", "big5//TRANSLIT", $TCSubject);
$TCSubject = iconv("big5", "UTF-8//TRANSLIT", $TCSubject);
$SCSubject = htmlspecialchars($SCSubject, ENT_IGNORE , 'UTF-8');
$TCSubject = htmlspecialchars($TCSubject, ENT_IGNORE , 'UTF-8');
$smarty->assign('TCSubject', $TCSubject);
$smarty->assign('SCSubject', $SCSubject);

$NewContent = trim($_REQUEST['content_input']);

for ($i = 0; $i < 50; $i++)
	$NewContent = str_replace("\n\n", "\n", $NewContent);
		
$TCNewContent = iconv("UTF-8", "gb2312//TRANSLIT", $NewContent);
$TCNewContent = iconv("gb2312", "big5//TRANSLIT", $TCNewContent);
$TCNewContent = iconv("big5", "UTF-8//TRANSLIT", $TCNewContent);

$NewContent = " " . $SearchKey[rand(0, count($SearchKey) - 1)] . $RandomSEOText[rand(0, count($RandomSEOText) -1)] . "\n" . $NewContent;
$TCNewContent = " " . $SearchKey[rand(0, count($SearchKey) - 1)] . $RandomSEOText[rand(0, count($RandomSEOText) -1)] . "\n" . $TCNewContent;

$SCKeyword = '';
$TCKeyword = '';

foreach ($SearchKey as $key => $value) {
	if (strpossum($TCNewContent, $value) > 0)
		$TCKeyword = $TCKeyword . $value . ", ";

	if (strpossum($NewContent, $value) > 0)
		$SCKeyword = $SCKeyword . $value . ", ";
}
$smarty->assign('SCKeyword', substr($SCKeyword, 0, -2));
$smarty->assign('TCKeyword', substr($TCKeyword, 0, -2));

$NewContent = htmlspecialchars($NewContent, ENT_IGNORE , 'UTF-8');
$TCNewContent = htmlspecialchars($TCNewContent, ENT_IGNORE , 'UTF-8');

$smarty->assign('TCNewContent', $TCNewContent);
$smarty->assign('NewContent', $NewContent);

function strpossum($Subject, $Needle) {
	$i = 0;
	$offset = 0;
	do {
		$offset = stripos($Subject, $Needle, $offset+1);
		if ($offset !== false)
			$i++;
	} while ($offset !== false);
	return $i;
}

$smarty->assign('TITLE', 'SEO Article Submit Review');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_article_submit2.tpl');