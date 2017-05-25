How to use?
1) Edit ecship_country_data.txt from ecship_country_data_master, just delete the unwanted country
2) Run build_ecship_country_json.php to build ecship_country_data.json
3) Use ecship_country_data.json to build your html country selection
4) Query the freight cost by ecship::getEcshipFreightFromJson, see ecship_sample.php (Only 'APL' or 'EMS' supported)

File needed to copy to the real client website
1) ecship_country_data.json (maybe under htmlsafe)
2) class/ecship.class.php

Code to read the json:
$EcShipCountryList = json_decode(file_get_contents(BASEDIR . "htmlsafe/ecship_country_data.json"), false);
$smarty->assign('EcShipCountryList', $EcShipCountryList);