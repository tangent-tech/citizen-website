<?php

// You should change this to true for local development env
define('IS_LOCAL', false);

if (1 > 2) {	
	$FORCE_ENV == 'POS';
	define('SHOP_ID',		1);
	define('SITE_ID',		13);
	define('api_login', 	'citizenweb'); //herocross
	define('api_key',		'4b1835ee5a1f46a4e0c3d2148129990b');  //8564db108fb6fd7fb1bc39f56c4a8abe
	define('DB_HOST',			'localhost'); // default is host02.aveego.com
	define('DB_NAME',			'cms_citizenhk'); // default is c184hcpos
	define('DB_USER',			'root'); // default is c184hcpos
	define('DB_PASSWD',			''); // default is hmbgVpRM2F_8
	//define('BASEDIR',			'/var/www/hcpos.eksx.com/');
	define('BASEDIR',			'/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/');	// My Mac Path, probably you need to change ths in PC
	define('BASEWEBDIR',		BASEDIR . 'web/');
	define('BASEDIR_HTMLSAFE',	BASEDIR . 'htmlsafe/');
	define('BASEURL',			'http://local.cms.citizen-hk.com/myadmin/');

	define('API_BASEURL',		'http://local.cms.citizen-hk.com/api/');

	define('MYSQL_COMMAND',		'/usr/bin/mysql');
}

if (IS_LOCAL) {
	define('BASEDIR',			'/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/');	// My Mac Path, probably you need to change ths in PC
	define('PHPUNIT', false);
	define('LOCAL_SIM_ENV',	'LOCAL');
	define('DB_HOST',			'localhost'); // default is host02.aveego.com
	define('DB_NAME',			'cms_citizenhk'); // default is c184hcpos
	define('DB_USER',			'root'); // default is c184hcpos
	define('DB_PASSWD',			''); // default is hmbgVpRM2F_8
}