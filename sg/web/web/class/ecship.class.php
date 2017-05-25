<?php

class ecship {
	public function __construct() {
	}

	public static function getEcshipFreightFromJson($CountryCode, $WeightInKG, $ServiceType = "APL/EMS") {
		self::InitEcShipInfo();
		$EffectiveWeightIndex = ceil($WeightInKG/0.5) - 1;
		$Rate = self::$EcShipInfo->$CountryCode->$ServiceType->Rate;
		return $Rate[$EffectiveWeightIndex];
	}
	
	public static function InitEcShipInfo() {
		if (self::$EcShipInfo === null)
			self::$EcShipInfo = json_decode(file_get_contents("http://www.369cms.com/ecship_country_data.json"), false);
	}
	
	public static $EcShipInfo = null;
}