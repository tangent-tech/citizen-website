<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/system_super_admin_header.php');

$smarty->assign('CurrentTab', 'super_admin');
$smarty->assign('CurrentTab2', 'z_seo_article_submit3');
$smarty->assign('MyJS', 'z_seo_article_submit_3_act');

$AVEEGO_URL_ONLY = true;

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

for ($i = 0; $i < 4; $i++) {
	$NewContent		= RandomInsert($NewContent, $SearchKey[rand(0, count($SearchKey) - 1)]);
	$TCNewContent	= RandomInsert($TCNewContent, $SearchKey[rand(0, count($SearchKey) - 1)]);
}
$NewContent = " " . $SearchKey[rand(0, count($SearchKey) - 1)] . $RandomSEOText[rand(0, count($RandomSEOText) -1)] . "\n" . $NewContent;
$TCNewContent = " " . $SearchKey[rand(0, count($SearchKey) - 1)] . $RandomSEOText[rand(0, count($RandomSEOText) -1)] . "\n" . $TCNewContent;

$NewContent = ReplaceHighPRKeyword($NewContent);
$TCNewContent = ReplaceHighPRKeyword($TCNewContent);

$NewContent = ReplaceKeyword($NewContent);
$TCNewContent = ReplaceKeyword($TCNewContent);


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

function RandomInsert($Subject, $Keyword) {
	if (!Z_SEO_RANDOM_INSERT)
		return $Subject;

	$Length = strlen($Subject);
	$RandomPos = rand(0, $Length);

	return substr($Subject, 0, $RandomPos) . $Keyword . substr($Subject, $RandomPos -1);
}

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

function ReplaceHighPRKeyword($TheContent) {
	global $SearchKeyHighPR;

	foreach ($SearchKeyHighPR as $key => $value)
		$TheContent = str_ireplace($key, md5($key), $TheContent);

	$AllTotalCount = 0;
	foreach ($SearchKeyHighPR as $key => $value) {
		$TotalCount = 0;
		do {
			if ($TotalCount > 10 || $AllTotalCount > 10) {
				$TheContent = preg_replace("/" . md5($key) . "/", $key, $TheContent);
				break;
			}

			$TheURLAddress = trim($value[rand(0, count($value) - 1)]);
			$TheReplaceText = '<a title="' . $key .'" href="' . $TheURLAddress . '">' . $key . '</a>';
			$TheContent = preg_replace("/" . md5($key) . "/", $TheReplaceText, $TheContent, 1, $Count);
			$TotalCount++;
			$AllTotalCount++;
		} while ($Count != 0);
	}

	return $TheContent;
}

function ReplaceKeyword($TheContent) {
	global $SearchKey2;
	$Keyword_Used = array();
	$URL_Used = array();
	foreach ($SearchKey2 as $SK) {

		if (rand(0, 10) > 5) {
			$Pos = rand(0, strlen($TheContent)-1);
			$TheContent = substr($TheContent, 0, $Pos) . $SK . substr($TheContent, $Pos+1);
		}

		$TheContent = str_ireplace($SK, md5($SK), $TheContent);
	}

	$AllTotalCount = 0;
	foreach ($SearchKey2 as $SK) {
		$Count = 0;
		$TotalCount = 0;

		do {
			//$TheURL = GetURLByKeyword($SK);
			$TheURLAddress = '';

			if ($TotalCount > 4 || $AllTotalCount > 10) {
				$TheContent = preg_replace("/" . md5($SK) . "/", $SK, $TheContent);
				break;
			}

			if ($TheURL == null || $AllTotalCount == 0 || rand(0, 10) > 6 || $AVEEGO_URL_ONLY) {
				if (rand(0, 10) > 2)
					$TheURLAddress = 'http://www.aveego.com';
				else {
					$xml = new SimpleXMLElement(file_get_contents('http://www.aveego.com/sitemap.xml'));
					$xml->registerXPathNamespace('mysitemap', 'http://www.sitemaps.org/schemas/sitemap/0.9');
					$URL = $xml->xpath("//mysitemap:loc");
					$TheURLAddress = $URL[rand(0, count($URL))];
				}
			}
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

		if ($TotalCount > 0)
			array_push($Keyword_Used, $SK);
	}
	return $TheContent;
}

function GetURLByKeyword($Keyword) {
	$query =	"	SELECT		FLOOR(RAND() * COUNT(*)) AS `offset` " .
				"	FROM 		z_seo_url " .
				"	WHERE		z_seo_url_wheel = " . Z_SEO_WHEEL_NO .
				"	ORDER BY	z_seo_url_id ASC ";
	$offset_result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	$offset_row = $offset_result->fetch_object();
	$offset = $offset_row->offset;

	$query =	"	SELECT	* " .
				"	FROM 	z_seo_url " .
				"	WHERE		z_seo_url_wheel = " . Z_SEO_WHEEL_NO .
				"	ORDER BY	z_seo_url_id ASC " .
				"	LIMIT	" . $offset . ", 1 ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	if ($result->num_rows > 0)
		return $result->fetch_assoc();
	else
		return null;
}


$smarty->assign('TITLE', 'SEO Article Submit Review');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/z_seo_article_submit_3_act.tpl');