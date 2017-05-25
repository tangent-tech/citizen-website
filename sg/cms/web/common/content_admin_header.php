<?php
	require_once('admin_info_header.php');

	if (!$IsContentAdmin)
		AdminDie(ADMIN_ERROR_NOT_YOUR_SITE, 'index.php');
?>