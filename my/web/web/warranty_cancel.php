<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$ObjectSeo = GetSeoUrl(WARRANTY_REG_PAGE_LINK_ID);

if(isset($_SESSION["WarrantyID"]) || intval($_SESSION["WarrantyID"]) > 0){

	warranty::CancelWarrantyRegister($_SESSION["WarrantyID"]);
 
	unset($_SESSION["WarrantyID"]);

}

header("Location: " . BASEURL . $ObjectSeo);
?>