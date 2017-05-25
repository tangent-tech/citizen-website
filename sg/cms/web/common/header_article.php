<?php
if ($Site['site_module_article_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_ARTICLE, 'index.php', __LINE__);
?>