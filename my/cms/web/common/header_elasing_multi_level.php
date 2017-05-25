<?php
if ($Site['site_module_elasing_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_NEWSLETTER, 'language_root_list.php', __LINE__);
if ($Site['site_module_elasing_multi_level'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_NEWSLETTER, 'language_root_list.php', __LINE__);
?>