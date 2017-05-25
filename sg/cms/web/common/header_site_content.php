<?php
	if (!defined('IN_CMS'))
		die("header_site_content.php is called directly " . realpath(__FILE__) . " " .  __LINE__);

	$AllNewsRoots = news::GetAllNewsRootBySiteID($_SESSION['site_id']);
	$smarty->assign('AllNewsRoots', $AllNewsRoots);

	$AllLayoutNewsRoots = layout_news::GetAllLayoutNewsRootBySiteID($_SESSION['site_id']);
	$smarty->assign('AllLayoutNewsRoots', $AllLayoutNewsRoots);
?>