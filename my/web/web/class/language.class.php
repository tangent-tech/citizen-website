<?php
// version 1.1 20161128
//	Add support for localCache!
//	
//Please do NOT think this as an OOP object, I just use the class to group the related functions...
	if (!defined('IN_CMS'))
		die("huh?");

	class language {
		public function __construct() {
			die('Do not create me. I am not an object!');
		}

		public static function SetCurrentLanguage($LangID) {
			setcookie('LangID', $LangID, time()+60*60*24*365, '/');
			$_SESSION['LangID'] = intval($LangID);
			$_COOKIE['LangID'] = intval($LangID);
			$Language = language::GetLanguageInfo($_SESSION['LangID']);
			return $Language;
		}

		public static function GetCurrentLanguage() {
			
			if (isset($_COOKIE['LangID']) && !isset($_REQUEST['lang_id']))
				$_SESSION['LangID'] = $_COOKIE['LangID'];
			$Language = language::GetLanguageInfo($_SESSION['LangID']);
			if ($Language->language_root->language_root_id == null) {
				global $Site;
				language::SetCurrentLanguage(intval($Site->site->site_default_language_id));
				$Language = language::GetLanguageInfo($_SESSION['LangID']);
			}
			return $Language;
		}

		public static function GetLanguageInfo($LangID) {
			if (defined('ENABLE_LOCAL_CACHE') && ENABLE_LOCAL_CACHE) {
				require_once(__DIR__ . '/customLocalCache.class.php');
				$localCache = customLocalCache::Singleton();
				$Language = $localCache->getCache('xmlCacheLanguageInfo', array('lang_id' => $LangID), false);
			}
			else {
				$Language = ApiQuery('language_root_info.php', __LINE__, 'lang_id=' . $LangID);
			}
			return $Language;
		}

		public static function IsValidLanguageID($LangID) {
			$Language = self::GetLanguageInfo($LangID);
			if ($Language->language_root->language_root_id == null )
				return false;
			else
				return true;
		}

		public static function GetAllSiteLanguage() {
			if (defined('ENABLE_LOCAL_CACHE') && ENABLE_LOCAL_CACHE) {
				require_once(__DIR__ . '/customLocalCache.class.php');
				$localCache = customLocalCache::Singleton();
				$LanguageList = $localCache->getCache('xmlCacheLanguageRootList', array(), false);
			}
			else {
				$LanguageList = ApiQuery('language_root_list.php', __LINE__, '');			
			}
			return $LanguageList;
		}
	}