<?php

if (!defined('IN_CMS'))
	die("huh?");

class sync_log {
	
	private $site_id;
	private $shop_id;
	/* @var $_latestLog sync_log_details */
	private $_latestLog = null;
	
	public function sync_log($SiteID, $ShopID) {
		$this->site_id = $SiteID;
		$this->shop_id = $ShopID;
	}
	
	/**
	 * 
	 * @return sync_log_details
	 */
	public function getLatestLogDetails() {
		
		if ($this->_latestLog == null) {
			$query =	"	SELECT	* " .
						"	FROM	sync_log " .
						"	WHERE	site_id = '" . $this->site_id . "'" .
						"		AND	shop_id = '" . $this->shop_id . "'" .
						"	ORDER BY sync_log_id DESC " .
						"	LIMIT 1 ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			if ($result->num_rows > 0)				
				$this->_latestLog = $result->fetch_object();
			else
				die("No SyncLog found!");
		}
		return $this->_latestLog;
	}
	
	public function getSyncLogDetailsList() {
		$query =	"	SELECT	* " .
					"	FROM	sync_log " .
					"	WHERE	site_id = '" . $this->site_id . "'" .
					"		AND	shop_id = '" . $this->shop_id . "'" .
					"	ORDER BY sync_log_id DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$LogList = array();
		while ($myResult = $result->fetch_object())
			array_push($LogList, $myResult);
		
		return $LogList;
	}
	
	public function createNewSyncLog($NewSyncLogID = 0, $LoadMaxFromLastLog = true) {
		$sql = '';
		if ($NewSyncLogID != 0)
			$sql = " sync_log_id = '" . $NewSyncLogID . "', ";

		if ($LoadMaxFromLastLog) {
			$sql .= 
					"		max_user_id			= '" . $this->getLatestLogDetails()->max_user_id . "', " .
					"		max_myorder_id		= '" . $this->getLatestLogDetails()->max_myorder_id . "', " .
					"		max_file_id			= '" . $this->getLatestLogDetails()->max_file_id . "', ";
		}
		
		$query =	"	INSERT INTO sync_log " .
					"	SET	" . $sql .
					"		site_id				= '" . $this->site_id . "', " .
					"		shop_id				= '" . $this->shop_id . "', " .
					"		sync_log_status		= 'init', " .
					"		sync_log_remark		= '' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_latestLog = null;

		return customdb::mysqli()->insert_id;
	}
	
	public function endLatestMyorderProductSync() {
		$MaxUserID = user::GetMaxUserID($this->site_id);
		$MaxMyOrderID = myorder::GetMaxMyOrderID($this->site_id);
		$MaxFileID = filebase::GetMaxFileID($this->site_id);
		
		$query =	"	UPDATE	sync_log " .
					"	SET		max_user_id		= '" . $MaxUserID . "', " .
					"			max_myorder_id	= '" . $MaxMyOrderID . "', " .
					"			max_file_id		= '" . $MaxFileID . "', " .
					"			sync_log_status = 'generate_mysql_backup' " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_latestLog = null;
	}
	
	public function refreshLatestSyncLog() {
		$this->_latestLog = null;
	}
	
	public function updateLatestSyncStatus($Status) {
		$query =	"	UPDATE	sync_log " .
					"	SET		sync_log_status = '" . aveEscT($Status) . "' " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_latestLog != null)
			$this->_latestLog->sync_log_status = $Status;
	}
	
	public function incrementLatestSyncNoOfUserUpdated() {
		$query =	"	UPDATE	sync_log " .
					"	SET		no_of_user_updated = no_of_user_updated + 1 " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_latestLog != null)
			$this->_latestLog->no_of_user_updated++;
	}

	public function incrementLatestSyncNoOfUserImported() {
		$query =	"	UPDATE	sync_log " .
					"	SET		no_of_user_imported = no_of_user_imported + 1 " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_latestLog != null)
			$this->_latestLog->no_of_user_imported++;
	}

	public function incrementLatestSyncNoOfMyorderImported() {
		$query =	"	UPDATE	sync_log " .
					"	SET		no_of_myorder_imported = no_of_myorder_imported + 1 " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_latestLog != null)
			$this->_latestLog->no_of_myorder_imported++;
	}	
	
	public function generateMySQLDumpToSiteFTP() {
		$Site = site::GetSiteInfo($this->site_id);

		$Output = '';
		
		$DumpFile = BASEWEBDIR . 'api/pos/' . MYSQL_DUMP_FILENAME;
		$Command = "/usr/bin/mysqldump -u " . escapeshellarg(DB_USER) . " -p" . escapeshellarg(DB_PASSWD) . " --default-character-set=utf8 " . DB_NAME . " > " . escapeshellarg($DumpFile) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$RemoteFtpFullPath = $Site['site_ftp_filebase_dir'] . "/" . MYSQL_DUMP_FILENAME;
		
		ftp_put($conn_id, $RemoteFtpFullPath, $DumpFile, FTP_ASCII);
	}
	
	public function downloadMySQLDumpFromSiteFTP() {
		$Site = site::GetSiteInfo($this->site_id);

		$conn_id = ftp_connect($Site['site_ftp_address']);
		$login_result = ftp_login($conn_id, $Site['site_ftp_username'], site::MyDecrypt($Site['site_ftp_password']));

		if ($Site['site_ftp_need_passive'] == 'Y')
			ftp_pasv($conn_id, true);
		else
			ftp_pasv($conn_id, false);

		$RemoteFtpFullPath = $Site['site_ftp_filebase_dir'] . "/" . MYSQL_DUMP_FILENAME;
		$LocalPath = FILEBASE_PATH . MYSQL_DUMP_FILENAME;
		
		$Result = ftp_get($conn_id, $LocalPath, $RemoteFtpFullPath, FTP_ASCII);
		
		ftp_close($conn_id);
		
		return $Result;
	}
	
	public function updateLatestSyncMaxUserID($MaxUserID) {
		$query =	"	UPDATE	sync_log " .
					"	SET		max_user_id		= '" . intval($MaxUserID) . "' " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_latestLog = null;		
	}
	
	public function updateLatestSyncMaxMyOrderID($MaxMyOrderID) {
		$query =	"	UPDATE	sync_log " .
					"	SET		max_myorder_id	= '" . intval($MaxMyOrderID) . "' " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_latestLog = null;
	}	

	public function updateLatestSyncMaxFileID($MaxFileID) {
		$query =	"	UPDATE	sync_log " .
					"	SET		max_file_id	= '" . intval($MaxFileID) . "' " .
					"	WHERE	sync_log_id = '" . $this->getLatestLogDetails()->sync_log_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_latestLog = null;
	}		
	
	public static function isOtherShopSyncInProgress($SiteID, $ShopID) {
		$query =	"	SELECT	* " .
					"	FROM	sync_log " .
					"	WHERE	site_id = '" . intval($SiteID) . "'" .
					"		AND	sync_log_status != 'finished' " .
					"		AND sync_log_status != 'failed' " .
					"		AND	shop_id != '" . intval($ShopID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $result->num_rows > 0;
	}
}

class sync_log_details {
	public $sync_log_id;
	public $sync_log_datetime;
	public $site_id;
	public $shop_id;
	public $max_user_id;
	public $max_myorder_id;
	public $max_file_id;
	public $no_of_user_updated;
	public $no_of_user_imported;
	public $no_of_myorder_imported;
	public $sync_log_status;
	public $sync_log_remark;	
}