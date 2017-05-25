<?php
if (!defined('IN_CMS'))
	die("HACK ATTEMPT");

if (RUN_PROCESS_TIME)
{
	$mtime = explode(' ', microtime());
	global $totaltime, $starttime;
	$totaltime = $mtime[0] + $mtime[1] - $starttime;
	$totaltime = sprintf("%.4f sec", $totaltime);
	$GLOBALS["smarty"]->assign('totaltime', $totaltime);
	
}

?>