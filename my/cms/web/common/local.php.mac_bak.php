<?php

// You should change this to true for local development env
define('IS_LOCAL', true);

if (IS_LOCAL) {
	define('BASEDIR', '/Applications/MAMP/htdocs/demo.369cms.com/');	// My Mac Path, probably you need to change ths in PC
	define('PHPUNIT', true);
}
?>