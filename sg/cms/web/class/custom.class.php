<?php
// Jeff: 20140722 I decided to use custom function for some custom function which is worthless to generic build like bonus point expiry date

class custom {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}
	
	public static function GetBonusPointExpiryDate($Site, $TimeStamp = null, $Price = null) {
		if ($TimeStamp == null)
			$TimeStamp = time();
				
		if (
			($Site['site_id'] == 1 &&  ENV == 'DEMO') ||
			($Site['site_id'] == 13 &&  ENV == 'CUH')		// Click U Home!		
			) {
			
			$Month = date("n", $TimeStamp);
			$Year = date("Y", $TimeStamp);
			
			$ExpiryYear = $Year;
			
			if ($Month >= 7)
				$ExpiryYear = $Year + 1;
			
			return $ExpiryYear . "-12-31";
		}
		else {
			// Default 1 years later
			return date("Y-m-d", $TimeStamp + $Site['site_bonus_point_valid_days'] * 24 * 60 * 60);
		}
	}
}
