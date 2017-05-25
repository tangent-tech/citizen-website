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

$TheContent = '';

for ($i = 0; $i < 20; $i++) {
	$Article = GetRandomArticle();
	$TheContent = $TheContent . ExtractTextFromArticle($Article['z_seo_article_content']) . "\n";
}

$TheContent = str_replace(array("<", ">"), array("&lt;", "&gt;"),$TheContent);
$TheContent = nl2br($TheContent);

foreach ($SearchKey as $SK) {
/*
	if (rand(0, 10) > 5) {
		$Pos = rand(0, strlen($TheContent)-1);
		$TheContent = substr($TheContent, 0, $Pos) . $SK . substr($TheContent, $Pos+1);
	}
*/
	$TheContent = str_ireplace($SK, md5($SK), $TheContent);
}

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
		
		if ($TheURL == null || $AllTotalCount == 0 || rand(0, 10) > 6)
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

function GetRandomArticle() {
	$query =	"	SELECT	COUNT(*) AS no_of_articles " .
				"	FROM 	z_seo_article ";
	$offset_result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$offset_row = $offset_result->fetch_object();
	$offset = rand(0, $offset_row->no_of_articles - 1);
	
	$query =	"	SELECT	* " .
				"	FROM 	z_seo_article " .
				"	LIMIT	" . $offset . ", 1 ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	if ($result->num_rows > 0)
		return $result->fetch_assoc();
	else
		return null;
}

function ExtractTextFromArticle($ArticleText) {
	$Sentence = preg_split("/[\s：；，。●,.◆…？]+/u", $ArticleText, -1, PREG_SPLIT_NO_EMPTY);
	$NoOfSentences = rand(10, 20);
	$PickSentence = array_rand($Sentence, $NoOfSentences);
	$Text = '';
	for ($i = 0; $i < $NoOfSentences; $i++) {
		$Text = $Text . $Sentence[$PickSentence[$i]];
		$RandomFactor = rand(0, 50);

		if ($RandomFactor > 0 && $RandomFactor <= 25)
				$Text = $Text . "，";
		elseif ($RandomFactor > 25 && $RandomFactor <= 35)
				$Text = $Text . "。";
		elseif ($RandomFactor > 35 && $RandomFactor <= 40)
				$Text = $Text . "﹗";
		elseif ($RandomFactor > 40 && $RandomFactor <= 42)
				$Text = $Text . "？";
		elseif ($RandomFactor > 42 && $RandomFactor <= 47)
				$Text = $Text . "。\n\n";
		elseif ($RandomFactor > 47 && $RandomFactor <= 49)
				$Text = $Text . "﹗\n\n";
		elseif ($RandomFactor > 49 && $RandomFactor <= 50)
				$Text = $Text . "？\n\n";
	}
	return $Text;
	
/*
	$Sentence = array();
	$Token = "，﹗。\n";
	
	$tok = strtok($ArticleText, $Token);

	while ($tok !== false) {
		echo $tok . "<br />";
    	$tok = strtok($Token);
	    array_push($Sentence, $tok);
	}
	$Sentence = explode($Token, $ArticleText);
var_dump($Sentence);
	return "";
	$NoOfSentences = rand(10, 20);
	$PickSentence = array_rand($Sentence, $NoOfSentences);
	
	$Text = '';
	for ($i = 0; $i < $NoOfSentences; $i++) {
		$Text = $Text . $PickSentence[$i];
	}

	return $Text;
*/	
	
	$RandLength = rand(80, 100)*3;
	$ArticleText = str_ireplace("\n", '', $ArticleText);
	$ArticleText = str_ireplace("\r", '', $ArticleText);
	$ArticleText = str_ireplace("\t", '', $ArticleText);
	$LeftCount = rand(0, strlen($ArticleText) - $RandLength);
	return substr($ArticleText, $LeftCount, $RandLength);
}

$smarty->assign('TITLE', 'SEO Article Generation');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_article_generate.tpl');