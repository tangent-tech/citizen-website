<?php
if ($Site['site_module_album_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_ALBUM, 'language_root_list.php', __LINE__);
?>