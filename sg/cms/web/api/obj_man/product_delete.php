<?php
// parameters:
//	product_id
define('IN_CMS', true);
require_once('../../common/config.php');
//require_once('../../common/common.php');
require_once('../../common/function.php');
require_once('../../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$IsContentAdmin = true;

if ($Site['site_module_objman_enable'] != 'Y')
	APIDie(array('desc' => 'Module ObjMan is not enabled'));

$Product = product::GetProductInfo($_REQUEST['product_id'], 0);
if ($Product['site_id'] != $Site['site_id'])
	APIDie(array('desc' => 'Invalid product_id'));

product::DeleteProduct($_REQUEST['product_id'], $Site);

site::EmptyAPICache($Site['site_id']);
//$smarty->assign('Data', "<product_id>" . $NewProductID . "</product_id>");
$smarty->display('api/api_result.tpl');