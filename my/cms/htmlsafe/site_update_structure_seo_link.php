<?php
define('IN_CMS', true);
require_once(realpath(dirname(__FILE__)) . '/../web/common/config.php');
require_once(realpath(dirname(__FILE__)) . '/../web/common/common.php');
require_once(realpath(dirname(__FILE__)) . '/../web/common/function.php');

$query	=	"	SELECT	* " .
			"	FROM	site " .
			"	WHERE	site_structure_seo_link_update_status = 'in_progress' ";
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