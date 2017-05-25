<?php
// version 1.1 20161128
//	Add support for localCache!

/*
Please do NOT think this as an OOP object, I just use the class to group the related functions...
*/

	if (!defined('IN_CMS'))
		die("huh?");

	class currency {
		public function __construct() {
			die('Do not create me. I am not an object!');
		}

		public static function SetCurrentCurrency($CurrencyID) {
			setcookie('CurrencyID', $CurrencyID, time()+60*60*24*365, '/');
			$_SESSION['CurrencyID'] = $CurrencyID;
		}

		public static function GetCurrentCurrency() {
			if (isset($_COOKIE['CurrencyID']))
				$_SESSION['CurrencyID'] = $_COOKIE['CurrencyID'];

		    $_SESSION['CurrencyID'] = 14;
			$Currency = currency::GetCurrencyInfo($_SESSION['CurrencyID']);

			if ($Currency->currency->currency_id == null ) {
				global $Site;

				currency::SetCurrentCurrency(intval($Site->site->site_default_currency_id));
				$Currency = currency::GetCurrencyInfo(intval($Site->site->site_default_currency_id));
			}

			return $Currency;
		}

		public static function GetCurrencyInfo($CurrencyID) {

			if (defined('ENABLE_LOCAL_CACHE') && ENABLE_LOCAL_CACHE) {

				require_once(__DIR__ . '/customLocalCache.class.php');
				$localCache = customLocalCache::Singleton();
				$Currency = $localCache->getCache('xmlCacheCurrencyInfo', array('currency_id' => $CurrencyID), false);
			}
			else {
				$Currency = ApiQuery('currency_info.php', __LINE__, 'currency_id=' . $CurrencyID);			
			}
			
			return $Currency;
		}

		public static function IsValidCurrencyID($CurrencyID) {

			$Currency = self::GetCurrentCurrency($CurrencyID);
			if ($Currency->currency->currency_id == null )
				return false;
			else
				return true;
		}

		public static function GetAllSiteCurrency() {
			if (defined('ENABLE_LOCAL_CACHE') && ENABLE_LOCAL_CACHE) {

				die('ok');
				require_once(__DIR__ . '/customLocalCache.class.php');
				$localCache = customLocalCache::Singleton();
				$CurrencyList = $localCache->getCache('xmlCacheAllSiteCurrency', array(), false);
			}
			else {
				$CurrencyList = ApiQuery('currency_list.php', __LINE__, '');			
			}			
			return $CurrencyList;
		}
	}