<?php
if ($Site['site_module_member_enable'] != 'Y')
	AdminDie(ADMIN_MSG_MODULE_DISABLED_MEMBER, 'language_root_list.php', __LINE__);

$UserCustomFieldsDef = site::GetUserCustomFieldsDef($_SESSION['site_id']);
$smarty->assign('UserCustomFieldsDef', $UserCustomFieldsDef);

$UserFieldsShow = site::GetUserFieldsShow($_SESSION['site_id']);
$smarty->assign('UserFieldsShow', $UserFieldsShow);

?>