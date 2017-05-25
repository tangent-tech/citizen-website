<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$WarrantyID = warranty::SaveWarrantyFormPartOne($_REQUEST);

$_SESSION["WarrantyID"] = $WarrantyID;

header("Location:" . BASEURL . "/warranty_part2.php")
?>