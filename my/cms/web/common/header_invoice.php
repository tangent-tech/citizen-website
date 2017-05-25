<?php
if ($Site['site_invoice_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_INVOICE, 'language_root_list.php', __LINE__);
?>