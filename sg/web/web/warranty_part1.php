<?php

if (!defined('IN_CMS'))
	die(realpath(__FILE__) . " " .  __LINE__);

if(isset($_SESSION["WarrantyID"]) && intval($_SESSION["WarrantyID"]) > 0 ){
	
	//not need remove on db

	unset($_SESSION["WarrantyID"]);
}

?>