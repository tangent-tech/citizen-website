<?php
if ($Site['site_module_product_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_PRODUCT, 'language_root_list.php', __LINE__);
?>