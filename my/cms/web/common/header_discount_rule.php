<?php
if ($Site['site_module_discount_rule_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_DISCOUNT_RULE, 'index.php', __LINE__);
?>