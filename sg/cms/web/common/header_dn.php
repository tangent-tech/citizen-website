<?php
if ($Site['site_dn_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_DN, 'language_root_list.php', __LINE__);
?>