<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/site_admin_header.php');
require_once('../common/header_article.php');

$Language = language::GetLanguageInfo($_REQUEST['id']);
if ($Language == null)
	AdminDie("Invalid language_id.", 'language_root_list.php');

if (language::GetSiteLanguageRoot($_REQUEST['id'], $_SESSION['site_id']) != null)
	AdminDie("Language has already been added.", 'language_root_list.php');

$LanguageRootID = object::NewObject('LANGUAGE_ROOT', $Site['site_id'], 0);

$query	=	"	INSERT INTO	language_root " .
			"	SET		language_id 			= '" . intval($Language['language_id']) . "', " .
			"			index_link_id			= 0, " .
			"			language_root_id		= '". intval($LanguageRootID) . "'";
$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

object::NewObjectLink($Site['site_root_id'], $LanguageRootID, $Language['language_native'], $Language['language_id'], 'normal', DEFAULT_ORDER_ID);

object::TidyUpObjectOrder($Site['site_root_id']);

site::EmptyAPICache($_SESSION['site_id']);

header( 'Location: language_manage.php?SystemMessage=' . urlencode(ADMIN_MSG_NEW_SUCCESS));