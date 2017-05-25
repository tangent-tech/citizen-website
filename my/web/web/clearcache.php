<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

if ($_REQUEST['api_key'] == api_key && $_REQUEST['api_login'] == api_login) {

	require_once(BASEWEBDIR . '/class/customLocalCache.class.php');
	$localCache = customLocalCache::Singleton();
	$localCache->setCmsDirtyDate();
	
//	$query =	"	DELETE FROM api_cache ";
//	$result = ave_mysql_query($query, realpath(__FILE__), __LINE__, true);
	if(ENV == 'DEV'){
		$cacheFiles = BASEDIR . '/htmlsafe/localcache';
		$files = glob($cacheFiles . '/*');

		foreach($files as $file){
    		if(is_file($file))
    			unlink($file); //delete file
		}
		die('Cache is cleaned');
	}
	if(ENV == "PRODUCTION"){
		$cacheFiles = BASEDIR . '/htmlsafe/localcache';
		$files = glob($cacheFiles . '/*');

		foreach($files as $file){
    		if(is_file($file))
    			unlink($file); //delete file
		}
		die('Cache is cleaned');
	}
	if(ENV == "LOCAL"){
		$cacheFiles = BASEDIR . 'htmlsafe/localcache';
		$files = glob($cacheFiles . '/*'); //get all file names

		foreach($files as $file){	
    		if(is_file($file))
    			unlink($file); //delete file
		}
		die('Cache is cleaned');
	}
	
	echo('OK');
}
else {
	echo('INVALID API KEY');
}
?>