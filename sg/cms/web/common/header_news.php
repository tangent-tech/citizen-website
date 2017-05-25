<?php
if ($Site['site_module_news_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_NEWS, 'language_root_list.php', __LINE__);
?>