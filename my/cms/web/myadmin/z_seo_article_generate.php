<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_generate');
$smarty->assign('MyJS', 'z_seo_article_generate');

$URL_Used = array();

$query =	"	SELECT		* " .
			"	FROM 		z_seo_article " .
			"	ORDER BY	z_seo_counter ASC " .
			"	LIMIT	1 ";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
$TheArticle = $result->fetch_assoc();
$smarty->assign('TheArticle', $TheArticle);

$TheContent = $TheArticle['z_seo_article_content'];
$TheContent = str_replace(array("<", ">"), array("&lt;", "&gt;"),$TheContent);
$TheContent = nl2br($TheContent);

foreach ($SearchKey as $SK)
	$TheContent = str_ireplace($SK, md5($SK), $TheContent);

$AllTotalCount = 0;
foreach ($SearchKey as $SK) {
	$Count = 0;
	$TotalCount = 0;
	
	do {
		$TheURL = GetURLByKeyword($SK);
		$TheURLAddress = '';
		
		if ($TotalCount > 4 || $AllTotalCount > 10) {
			$TheContent = preg_replace("/" . md5($SK) . "/", $SK, $TheContent);
			break;		
		}
		
		if ($TheURL == null || $TotalCount == 0 || rand(0, 10) > 6)
			$TheURLAddress = 'http://www.aveego.com';
		else
			$TheURLAddress = trim($TheURL['z_seo_url_address']);
		$TheReplaceText = '<a title="' . $SK .'" href="' . $TheURLAddress . '">' . $SK . '</a>';

//echo $SK . ": " . $TheURLAddress . "<br />";
			
		$TotalCount++;
		$AllTotalCount += $Count;
		
		$TheContent = preg_replace("/" . md5($SK) . "/", $TheReplaceText, $TheContent, 1, $Count);
		
		if ($Count > 0 && $TheURL != null)
			array_push($URL_Used, $TheURL);
	} while ($Count != 0);
}

$TheContent = htmlspecialchars($TheContent, ENT_IGNORE , 'UTF-8');

$smarty->assign('TheContent', $TheContent);
$smarty->assign('URL_Used', $URL_Used);

function GetURLByKeyword($Keyword) {
	$query =	"	SELECT		FLOOR(RAND() * COUNT(*)) AS `offset` " .
				"	FROM 		z_seo_url " .
				"	WHERE		z_seo_url_keywords LIKE '%, " . aveEscT($Keyword) . ",%' " .
				"	ORDER BY	z_seo_url_id ASC ";
	$offset_result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$offset_row = $offset_result->fetch_object();  
	$offset = $offset_row->offset;
	
	$query =	"	SELECT	* " .
				"	FROM 	z_seo_url " .
				"	WHERE	z_seo_url_keywords LIKE '%, " . aveEscT($Keyword) . ",%' " .
				"	ORDER BY	z_seo_url_id ASC " .
				"	LIMIT	" . $offset . ", 1 ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	if ($result->num_rows > 0)
		return $result->fetch_assoc();
	else
		return null;	
}

function GetArticleByKeyword($Keyword, $AvoidArticleID) {
	$query =	"	SELECT	FLOOR(RAND() * COUNT(*)) AS `offset` " .
				"	FROM 	z_seo_article " .
				"	WHERE	z_seo_keyword = ', " . aveEscT($Keyword) . ",' " .
				"		AND	z_seo_article != '" . intval($AvoidArticleID) . "'";
	$offset_result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$offset_row = $offset_result->fetch_object();  
	$offset = $offset_row->offset;
	
	$query =	"	SELECT	* " .
				"	FROM 	z_seo_article " .
				"	WHERE	z_seo_keyword = ', " . aveEscT($Keyword) . ",' " .
				"		AND	z_seo_article != '" . intval($AvoidArticleID) . "'" .
				"	LIMIT	" . $offset . ", 1 ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	if ($result->num_rows > 0)
		return $result->fetch_assoc();
	else
		return null;
}

$smarty->assign('TITLE', 'SEO Article Generation');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_article_generate.tpl');