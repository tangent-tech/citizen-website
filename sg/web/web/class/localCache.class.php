<?php
// you should NOT modify this file
// you should modify the customLocalCache.class.php which extends this class instead

// version 1.3 (20161209)
//  - use simplexml_load_string instead of new SimpleXMLElement 

// version 1.2 (20061205)
//	- mechanism to suppress the xml error...

// version 1.1 (20061130)
//	- cacheFileName ksort($args) first
//  - add cleanUpCacheDir() function

// version 1.0 (20161128)
//	- initial draft
class localCache {

	function __construct($cacheBasePath, $testWritable = false) {
		if (trim($cacheBasePath) == '')
			die("Empty cacheBasePath?");
		
		if ($testWritable) {
			$fp = fopen($cacheBasePath . "/test_writable.txt", 'w+');
			if (fwrite($fp, "x") === false)
				die("cacheBasePath seems unwritable.");
			fclose($fp);			
		}
		
		$this->cacheBASEPATH = $cacheBasePath;
	}
	
	/**
	 * 
	 * @param string $cacheName must start with 'xml', 'json' or 'raw' and in the format like xmlCacheHelloWorld
	 * @param array $args key associated array
	 */
	public function addCache($cacheName, $args = array()) {
		$localCacheItem = $this->getLocalCacheItem($cacheName, $args);		
		array_push($this->localCacheItemArray, $localCacheItem);
	}
	
	public function getCache($cacheName, $args = array(), $allowOutdated = false) {		
		$cacheFile = $this->getCacheFileName($cacheName, $args);
		$cacheDate = null;
		$cacheContent = null;

		// Check if cache exists
		if (defined('ENABLE_LOCAL_CACHE') && ENABLE_LOCAL_CACHE && file_exists($cacheFile)) {
			$fp = fopen($cacheFile, "rb");
			$cacheDate = fgets($fp);
			$cacheContent = fread($fp, filesize($cacheFile));
			fclose($fp);

			if (!$allowOutdated) {
				//check if outdated;
				/* @var $dtCmsDirtyDate DateTime */
				$dtCmsDirtyDate = DateTime::createFromFormat('Y-m-d H:i:s', trim($this->getCmsDirtyDate()));
				/* @var $dtCacheDate DateTime */
				$dtCacheDate = DateTime::createFromFormat('Y-m-d H:i:s', trim($cacheDate));
				
				if ($dtCacheDate === false || $dtCmsDirtyDate === false || $dtCacheDate->getTimestamp() < $dtCmsDirtyDate->getTimestamp())
					$this->updateCache ($cacheName, $args);
			}
		}
		else
			$this->updateCache ($cacheName, $args);
		
		if (file_exists($cacheFile)) {
			$fp = fopen($cacheFile, "rb");
			$cacheDate = fgets($fp);
			$cacheContent = fread($fp, filesize($cacheFile));
			fclose($fp);
		
			$localCacheItem = $this->getLocalCacheItem($cacheName, $args);
			if ($localCacheItem->cacheType == 'xml') {
				libxml_use_internal_errors(true);
				$xml = simplexml_load_string($cacheContent);
				$counter = 0;
				while ($xml === false && $counter++ <= 5) {
					// writing in between? Are you serious?
					sleep(1);
					$fp = fopen($cacheFile, "rb");
					$cacheDate = fgets($fp);
					$cacheContent = fread($fp, filesize($cacheFile));
					fclose($fp);
					$xml = simplexml_load_string($cacheContent);
				}
				return $xml;
			}
			else if ($localCacheItem->cacheType == 'json') {
				return json_decode($cacheContent, true);
			}
			else
				return $cacheContent;
		}
		else
			die ("Error getting cache file: " . $cacheFile);
	}
	
	private function getCacheFileName($cacheName, $args = array()) {
		ksort($args);
		return $this->cacheBASEPATH . "/" . $cacheName . "_" . md5(json_encode($args));
	}
	
	public function cleanUpCacheDir() {
		$excludeFilenameArray = array('cache_dirty_date.txt', 'dummy.txt');
		
		if ($handle = opendir($this->cacheBASEPATH)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && !in_array($entry, $excludeFilenameArray)) {
					unlink($this->cacheBASEPATH . "/" . $entry);
				}
			}
			closedir($handle);
		}
	}
	
	public function updateCache($cacheName, $args = array()) {
		$date = date('Y-m-d H:i:s');
		$content = $this->{$cacheName}($args);
		$cacheFile = $this->getCacheFileName($cacheName, $args);
		$fp = fopen($cacheFile, "w");
		fwrite($fp, $date . "\n");
		fwrite($fp, $content);
		fclose($fp);
		
		//TODO: maybe add log here
	}

	public function updateAllCache() {
		foreach ($this->localCacheItemArray as $localCacheItem) {
			/* @var $localCacheItem localCacheItem */
			$this->updateCache($localCacheItem->cacheName, $localCacheItem->args);
		}
	}
	
	private function getCmsDirtyFileName() {
		return $this->cacheBASEPATH . "/cache_dirty_date.txt";
	}
	
	private function getCmsDirtyDate() {
		$cmsDirtyDateFile = $this->getCmsDirtyFileName();
		if (file_exists($cmsDirtyDateFile))
			return file_get_contents($cmsDirtyDateFile);
		else
			return "2038-01-01 00:00:00";
	}
	
	public function setCmsDirtyDate() {
		$date = date('Y-m-d H:i:s');
		$cmsDirtyDateFile = $this->getCmsDirtyFileName();
		$fp = fopen($cmsDirtyDateFile, "w");
		fwrite($fp, $date);
		fclose($fp);		
	}
	
	private function getLocalCacheItem($cacheName, $args = array()) {
		//Just make sure everybody follows the same style here!!!!!
		$cacheType = '';
		for ($i=0; $i <= strlen($cacheName); $i++) {
			$ordChar = ord($cacheName[$i]);
			if ($ordChar >= ord('a') && $ordChar <= ord('z'))
				$cacheType .= $cacheName[$i];
			else if ($ordChar >= ord('A') && $ordChar <= ord('Z'))
				break;
			else
				die("Invalid cacheName:" . $cacheName);
		}
		if (!in_array($cacheType, static::$validCacheType))
			die("Invalid cache type: " . $cacheType);
		
		//check if it comes with Cache... just for fun here actually
		if (substr($cacheName, strlen($cacheType), 5) != "Cache")
			die("Invalid cacheName format: " . $cacheType);
		
		// check if cacheName method is defined
		if (!method_exists($this, $cacheName))
			die("Method not defined for " . $cacheName);
		
		$localCacheItem = new localCacheItem($cacheName, $cacheType, $args);		
		return $localCacheItem;
	}
	
	/* @var $localCacheItemArray localCacheItem[] */
	protected $localCacheItemArray = array();
	
	static $validCacheType = array('xml', 'json', 'raw');

	private $cacheBASEPATH = null;
}

class localCacheItem {
	public function __construct($_cacheName, $_cacheType, $_args) {
		$this->cacheName = $_cacheName;
		$this->cacheType = $_cacheType;
		$this->args = $_args;
	}
	
	public $cacheName;
	public $cacheType;
	public $args = array();	
}