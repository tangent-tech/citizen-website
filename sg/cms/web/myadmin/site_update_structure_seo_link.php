<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_writer_header.php');
require_once('../common/header_site_content.php');
require_once('../common/header_article.php');

// $query =	"	UPDATE	site " .
// 			"	SET		site_structure_seo_link_update_status	= 'in_progress' " .
// 			"	WHERE	site_id	= '" . $_SESSION['site_id'] . "'" .
// 			"		AND	site_structure_seo_link_update_status	= 'job_done'";
// $result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query	=	"	SELECT	* " .
			"	FROM	site " .
			"	WHERE	site_structure_seo_link_update_status = 'job_done' ";

$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

while ($myResult = $result->fetch_assoc()) {
	$Site = site::GetSiteInfo($myResult['site_id']);
	
	site::UpdateSiteStucturedSeoUrlTable($Site);
	
	$query	=	"	UPDATE	site " .
				"	SET		site_structure_seo_link_update_status = 'job_done', " .
				"			site_structure_seo_link_update_datetime = NOW() " .
				"	WHERE	site_id	= '" . intval($Site['site_id']) . "' ";
	$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
}
header( 'Location: language_root_list.php?SystemMessage=' . urlencode(ADMIN_MSG_UPDATE_SUCCESS));