<?php

define('DEBUG', false);

$EcShipCountry = array();
$handle = fopen(__DIR__ . "/ecship_country_data.txt", "r");

$i = 0;
$country_code = '';
if ($handle) {
    while (($line = fgets($handle)) !== false) {
		
		if ($i % 3 == 0) {
			$country_code = trim($line);
			if (strlen($country_code) != 3)
				die("Something wrong at line " . $i);
			$EcShipCountry[$country_code] = array();
		}
		else if ($i % 3 == 1) {
			$EcShipCountry[$country_code]['en'] = trim($line);
		}
		else if ($i % 3 == 2) {
			$EcShipCountry[$country_code]['tc'] = trim($line);
		}
		$i++;		
    }
    fclose($handle);
	
	file_put_contents(__DIR__ . "ecship_country_data.json" , json_encode($EcShipCountry, 0));
} else {
    // error opening the file.
}

