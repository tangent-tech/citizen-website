<?php

class cmCurrency extends cmObject {
	function __construct($currencyID) {
		parent::__construct($currencyID, null);
		$this->currency_id = $currencyID;
	}
	
	protected function loadCmInfoFromDB() {
		$query =	"	SELECT	* " .
					"	FROM	currency " .
					"	WHERE	currency_id = '" . intval($this->currency_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->_cmObjectInfo = $result->fetch_object('cmCurrencyInfo');
	}
	
	protected function loadLangInfoFromDB() {}
	
	protected function updateCmMetaInfoFromDB() {}
		
	public $currency_id = null;	
}

class cmCurrencyInfo {
	public $currency_id;
	public $currency_paypal;
	public $currency_paydollar_currCode;
	public $currency_shortname;
	public $currency_longname;
	public $currency_symbol;
	public $currency_rate;
	public $currency_precision;
}

class cmSiteCurrencyInfo extends cmCurrencyInfo {
	public $currency_site_rate;
}