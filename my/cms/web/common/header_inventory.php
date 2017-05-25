<?php
if ($Site['site_module_inventory_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_INVENTORY, 'language_root_list.php', __LINE__);
?>