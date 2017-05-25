<?php

class mylock {
	public $lock_name;
	public $fp;

	public function __construct($_lock_name) {
		$this->lock_name = $_lock_name;
	}

	public function acquireLock($dieOnError = true) {
		$this->fp = fopen("/tmp/" . ENV . "_cms_mylock_" . $this->lock_name, "w+");

		$RetVal = flock($this->fp, LOCK_EX);

		if ($dieOnError && !$RetVal)
			die("Error to acquireLock " . $this->lock_name);
		else
			return $RetVal;
	}

	private function releaseLock() {
		flock($this->fp, LOCK_UN);
		fclose($this->fp);
	}

	public function __destruct() {
		$this->releaseLock();
	}
}