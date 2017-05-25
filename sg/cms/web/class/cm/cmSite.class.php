<?php
require_once(__DIR__ . '/cmCurrency.class.php');
/**
 * @property cmSiteInfo $_cmObjectInfo
 * @method cmSiteInfo getCmInfo()
 */
class cmSite extends cmObject {
	
	public $site_id = null;
	
	static private $curCmSite = null;
	
	static private $curCmSiteID = null;

	/**
	 * 
	 * @return cmSite
	 */
	static public function getCurCmSite() {
		if (self::$curCmSite == null && self::$curCmSiteID == null) {
			customdb::err_die(1, "Unknown curCmSite", "Try to access uninitilized curCmSite", __FILE__, __LINE__, true);
		}
		else if (self::$curCmSite == null) {
			self::$curCmSite = new cmSite(self::$curCmSiteID);
		}
		return self::$curCmSite;
	}
	
	static public function setCurCmSiteID($SiteID) {
		if (self::$curCmSiteID != $SiteID) {
			self::$curCmSite = null;
			self::$curCmSiteID = $SiteID;
		}
	}
	
	function __construct($siteID) {
		parent::__construct(null, $this);
		$this->site_id = $siteID;
	}
	
	public function saveCmInfoToDB() {		
		$update_sql =
				"	site_is_enable = '" . ynval($this->getCmInfo()->site_is_enable) . "', " .
				"	site_name = '" . aveEscT($this->getCmInfo()->site_name) . "', " .
				"	site_address = '" . aveEscT($this->getCmInfo()->site_address) . "', " .
				"	site_api_login = '" . aveEscT($this->getCmInfo()->site_api_login) . "', " .
				"	site_api_key = '" . aveEscT($this->getCmInfo()->site_api_key) . "', " .
				"	site_rich_secret_key = '" . aveEscT($this->getCmInfo()->site_rich_secret_key) . "', " .
				"	site_bonus_point_valid_days = '" . intval($this->getCmInfo()->site_bonus_point_valid_days) . "', " .
				"	site_default_language_id = '" . intval($this->getCmInfo()->site_default_language_id) . "', " .
				"	site_default_currency_id = '" . intval($this->getCmInfo()->site_default_currency_id) . "', " .
				"	site_default_security_level = '" . intval($this->getCmInfo()->site_default_security_level) . "', " .
				"	site_ftp_address = '" . aveEscT($this->getCmInfo()->site_ftp_address) . "', " .
				"	site_ftp_web_dir = '" . aveEscT($this->getCmInfo()->site_ftp_web_dir) . "', " .
				"	site_ftp_userfile_dir = '" . aveEscT($this->getCmInfo()->site_ftp_userfile_dir) . "', " .
				"	site_http_userfile_path = '" . aveEscT($this->getCmInfo()->site_http_userfile_path) . "', " .
				"	site_ftp_filebase_dir = '" . aveEscT($this->getCmInfo()->site_ftp_filebase_dir) . "', " .
				"	site_ftp_static_link_dir = '" . aveEscT($this->getCmInfo()->site_ftp_static_link_dir) . "', " .
				"	site_http_static_link_path = '" . aveEscT($this->getCmInfo()->site_http_static_link_path) . "', " .
				"	site_ftp_username = '" . aveEscT($this->getCmInfo()->site_ftp_username) . "', " .
				"	site_ftp_password = '" . aveEscT($this->getCmInfo()->site_ftp_password) . "', " .
				"	site_ftp_need_passive = '" . ynval($this->getCmInfo()->site_ftp_need_passive) . "', " .
				"	site_empty_cache_url_callback = '" . aveEscT($this->getCmInfo()->site_empty_cache_url_callback) . "', " .
				"	site_rich_xml_data_enable = '" . ynval($this->getCmInfo()->site_rich_xml_data_enable) . "', " .
				"	site_sitemap_ignore_folder = '" . ynval($this->getCmInfo()->site_sitemap_ignore_folder) . "', " .
				"	site_sitemap_always_now = '" . ynval($this->getCmInfo()->site_sitemap_always_now) . "', " .
				"	site_country_show_other = '" . ynval($this->getCmInfo()->site_country_show_other) . "', " .
				"	site_root_id = '" . intval($this->getCmInfo()->site_root_id) . "', " .
				"	site_use_bonus_point_at_once = '" . ynval($this->getCmInfo()->site_use_bonus_point_at_once) . "', " .
				"	library_root_id = '" . intval($this->getCmInfo()->library_root_id) . "', " .
				"	album_root_id = '" . intval($this->getCmInfo()->album_root_id) . "', " .
				"	bonus_point_root_id = '" . intval($this->getCmInfo()->bonus_point_root_id) . "', " .
				"	site_block_holder_root_id = '" . intval($this->getCmInfo()->site_block_holder_root_id) . "', " .
				"	site_product_root_special_id = '" . intval($this->getCmInfo()->site_product_root_special_id) . "', " .
				"	site_product_brand_root_id = '" . intval($this->getCmInfo()->site_product_brand_root_id) . "', " .
				"	site_user_root_id = '" . intval($this->getCmInfo()->site_user_root_id) . "', " .
				"	site_block_file_id = '" . intval($this->getCmInfo()->site_block_file_id) . "', " .
				"	site_media_small_width = '" . intval($this->getCmInfo()->site_media_small_width) . "', " .
				"	site_media_small_height = '" . intval($this->getCmInfo()->site_media_small_height) . "', " .
				"	site_media_big_width = '" . intval($this->getCmInfo()->site_media_big_width) . "', " .
				"	site_media_big_height = '" . intval($this->getCmInfo()->site_media_big_height) . "', " .
				"	site_media_resize = '" . ynval($this->getCmInfo()->site_media_resize) . "', " .
				"	site_watermark_position = '" . aveEscT($this->getCmInfo()->site_watermark_position) . "', " .
				"	site_folder_media_small_width = '" . intval($this->getCmInfo()->site_folder_media_small_width) . "', " .
				"	site_folder_media_small_height = '" . intval($this->getCmInfo()->site_folder_media_small_height) . "', " .
				"	site_product_media_small_width = '" . intval($this->getCmInfo()->site_product_media_small_width) . "', " .
				"	site_product_media_small_height = '" . intval($this->getCmInfo()->site_product_media_small_height) . "', " .
				"	site_product_media_big_width = '" . intval($this->getCmInfo()->site_product_media_big_width) . "', " .
				"	site_product_media_big_height = '" . intval($this->getCmInfo()->site_product_media_big_height) . "', " .
				"	site_product_media_resize = '" . ynval($this->getCmInfo()->site_product_media_resize) . "', " .
				"	site_email_sent_monthly_quota = '" . intval($this->getCmInfo()->site_email_sent_monthly_quota) . "', " .
				"	site_email_default_content = '" . aveEscT($this->getCmInfo()->site_email_default_content) . "', " .
				"	site_email_custom_footer = '" . ynval($this->getCmInfo()->site_email_custom_footer) . "', " .
				"	site_email_user_sender_override_site_sender = '" . ynval($this->getCmInfo()->site_email_user_sender_override_site_sender) . "', " .
				"	site_email_unsubscribe_hide_mailing_list = '" . ynval($this->getCmInfo()->site_email_unsubscribe_hide_mailing_list) . "', " .
				"	site_module_article_enable = '" . ynval($this->getCmInfo()->site_module_article_enable) . "', " .
				"	site_module_article_quota = '" . intval($this->getCmInfo()->site_module_article_quota) . "', " .
				"	site_module_news_enable = '" . ynval($this->getCmInfo()->site_module_news_enable) . "', " .
				"	site_module_news_quota = '" . intval($this->getCmInfo()->site_module_news_quota) . "', " .
				"	site_module_layout_news_enable = '" . ynval($this->getCmInfo()->site_module_layout_news_enable) . "', " .
				"	site_module_layout_news_quota = '" . intval($this->getCmInfo()->site_module_layout_news_quota) . "', " .
				"	site_module_discount_rule_enable = '" . ynval($this->getCmInfo()->site_module_discount_rule_enable) . "', " .
				"	site_module_bundle_rule_enable = '" . ynval($this->getCmInfo()->site_module_bundle_rule_enable) . "', " .
				"	site_module_product_enable = '" . ynval($this->getCmInfo()->site_module_product_enable) . "', " .
				"	site_module_product_quota = '" . intval($this->getCmInfo()->site_module_product_quota) . "', " .
				"	site_module_album_enable = '" . ynval($this->getCmInfo()->site_module_album_enable) . "', " .
				"	site_module_member_enable = '" . ynval($this->getCmInfo()->site_module_member_enable) . "', " .
				"	site_module_bonus_point_enable = '" . ynval($this->getCmInfo()->site_module_bonus_point_enable) . "', " .
				"	site_module_order_enable = '" . ynval($this->getCmInfo()->site_module_order_enable) . "', " .
				"	site_module_elasing_enable = '" . ynval($this->getCmInfo()->site_module_elasing_enable) . "', " .
				"	site_module_elasing_multi_level = '" . ynval($this->getCmInfo()->site_module_elasing_multi_level) . "', " .
				"	site_module_elasing_sender_name = '" . aveEscT($this->getCmInfo()->site_module_elasing_sender_name) . "', " .
				"	site_module_elasing_sender_address = '" . aveEscT($this->getCmInfo()->site_module_elasing_sender_address) . "', " .
				"	site_module_vote_enable = '" . ynval($this->getCmInfo()->site_module_vote_enable) . "', " .
				"	site_module_inventory_enable = '" . ynval($this->getCmInfo()->site_module_inventory_enable) . "', " .
				"	site_module_inventory_partial_shipment = '" . ynval($this->getCmInfo()->site_module_inventory_partial_shipment) . "', " .
				"	site_module_group_buy_enable = '" . ynval($this->getCmInfo()->site_module_group_buy_enable) . "', " .
				"	site_module_content_writer_enable = '" . ynval($this->getCmInfo()->site_module_content_writer_enable) . "', " .
				"	site_module_workflow_enable = '" . ynval($this->getCmInfo()->site_module_workflow_enable) . "', " .
				"	site_module_objman_enable = '" . ynval($this->getCmInfo()->site_module_objman_enable) . "', " .
				"	site_order_show_redeem_tab = '" . ynval($this->getCmInfo()->site_order_show_redeem_tab) . "', " .
				"	site_product_allow_under_stock = '" . ynval($this->getCmInfo()->site_product_allow_under_stock) . "', " .
				"	site_product_stock_threshold_quantity = '" . intval($this->getCmInfo()->site_product_stock_threshold_quantity) . "', " .
				"	site_auto_hold_stock_status = '" . aveEscT($this->getCmInfo()->site_auto_hold_stock_status) . "', " .
				"	site_product_category_special_max_no = '" . intval($this->getCmInfo()->site_product_category_special_max_no) . "', " .
				"	site_admin_logo_url = '" . aveEscT($this->getCmInfo()->site_admin_logo_url) . "', " .
				"	site_vote_multi = '" . ynval($this->getCmInfo()->site_vote_multi) . "', " .
				"	site_vote_guest = '" . ynval($this->getCmInfo()->site_vote_guest) . "', " .
				"	site_next_order_serial = '" . intval($this->getCmInfo()->site_next_order_serial) . "', " .
				"	site_next_redeem_serial = '" . intval($this->getCmInfo()->site_next_redeem_serial) . "', " .
				"	site_invoice_enable = '" . ynval($this->getCmInfo()->site_invoice_enable) . "', " .
				"	site_invoice_header = '" . aveEscT($this->getCmInfo()->site_invoice_header) . "', " .
				"	site_invoice_footer = '" . aveEscT($this->getCmInfo()->site_invoice_footer) . "', " .
				"	site_invoice_tnc = '" . aveEscT($this->getCmInfo()->site_invoice_tnc) . "', " .
				"	site_invoice_show_product_code = '" . ynval($this->getCmInfo()->site_invoice_show_product_code) . "', " .
				"	site_invoice_show_bonus_point = '" . ynval($this->getCmInfo()->site_invoice_show_bonus_point) . "', " .
				"	site_invoice_show_product_image = '" . ynval($this->getCmInfo()->site_invoice_show_product_image) . "', " .
				"	site_dn_enable = '" . ynval($this->getCmInfo()->site_dn_enable) . "', " .
				"	site_dn_header = '" . aveEscT($this->getCmInfo()->site_dn_header) . "', " .
				"	site_dn_footer = '" . aveEscT($this->getCmInfo()->site_dn_footer) . "', " .
				"	site_dn_tnc = '" . aveEscT($this->getCmInfo()->site_dn_tnc) . "', " .
				"	site_dn_show_product_code = '" . ynval($this->getCmInfo()->site_dn_show_product_code) . "', " .
				"	site_dn_show_product_image = '" . ynval($this->getCmInfo()->site_dn_show_product_image) . "', " .
				"	site_order_status_change_callback_url = '" . aveEscT($this->getCmInfo()->site_order_status_change_callback_url) . "', " .
				"	site_member_status_change_callback_url = '" . aveEscT($this->getCmInfo()->site_member_status_change_callback_url) . "', " .
				"	site_order_invoice_callback_url = '" . aveEscT($this->getCmInfo()->site_order_invoice_callback_url) . "', " .
				"	site_friendly_link_enable = '" . ynval($this->getCmInfo()->site_friendly_link_enable) . "', " .
				"	site_http_friendly_link_path = '" . aveEscT($this->getCmInfo()->site_http_friendly_link_path) . "', " .
				"	site_friendly_link_version = '" . aveEscT($this->getCmInfo()->site_friendly_link_version) . "', " .
				"	site_label_product = '" . aveEscT($this->getCmInfo()->site_label_product) . "', " .
				"	site_label_news = '" . aveEscT($this->getCmInfo()->site_label_news) . "', " .
				"	site_label_layout_news = '" . aveEscT($this->getCmInfo()->site_label_layout_news) . "', " .
				"	site_freight_cost_calculation_id = '" . intval($this->getCmInfo()->site_freight_cost_calculation_id) . "', " .
				"	site_order_serial_reset_type = '" . aveEscT($this->getCmInfo()->site_order_serial_reset_type) . "', " .
				"	site_redeem_serial_reset_type = '" . aveEscT($this->getCmInfo()->site_redeem_serial_reset_type) . "', " .
				"	site_order_no_format = '" . aveEscT($this->getCmInfo()->site_order_no_format) . "', " .
				"	site_redeem_no_format = '" . aveEscT($this->getCmInfo()->site_redeem_no_format) . "', " .
				"	site_additional_htaccess_content = '" . aveEscT($this->getCmInfo()->site_additional_htaccess_content) . "', " .
				"	site_product_price_version = '" . intval($this->getCmInfo()->site_product_price_version) . "', " .
				"	site_product_price_indepedent_currency = '" . ynval($this->getCmInfo()->site_product_price_indepedent_currency) . "', " .
				"	site_product_price_process_order = '" . aveEscT($this->getCmInfo()->site_product_price_process_order) . "'";
				
		$query =	"	INSERT INTO site " .
					"	SET site_id = '" . intval($this->site_id) . "', " . $update_sql .
					"	ON DUPLICATE KEY UPDATE " . $update_sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	protected function loadCmInfoFromDB() {		
		$query =	"	SELECT	* " .
					"	FROM	site " .
					"	WHERE	site_id = '" . intval($this->site_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		/* @var $cmSiteInfo cmSiteInfo */
		$cmSiteInfo = $result->fetch_object('cmSiteInfo');
		
		copyObjProperty($this->_cmObjectInfo, $cmSiteInfo, $this->_cmObjectInfo);
		
		$this->_cmObjectInfo = $cmSiteInfo;
	}
	
	protected function loadLangInfoFromDB() {
	}
	
	protected function updateCmMetaInfoFromDB() {
	}
	
	public function incrementSiteCounterAllTime() {
		$query = "	UPDATE site SET site_counter_alltime = site_counter_alltime + 1 WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	private function updateStructureSeoLinkUpdateInfo($Status, $DateTime = 'NOW') {
		if ($DateTime == 'NOW')
			$sql = "NOW()";
		else
			$sql = "'" . aveEscT ($DateTime) . "'";
		
		$query =	" UPDATE site SET " .
					"	site_structure_seo_link_update_status = '" . aveEscT($Status) . "', " .
					"	site_structure_seo_link_update_datetime = " . $sql .
					" WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->setDirty();
	}
	
	private function updateGenerateLinkUpdateInfo($Status, $NoOfFiles, $DateTime = 'NOW') {
		if ($DateTime == 'NOW')
			$sql = "NOW()";
		else
			$sql = "'" . aveEscT ($DateTime) . "'";
		
		$query =	" UPDATE site SET " .
					"	site_generate_link_status = '" . aveEscT($Status) . "', " .
					"	site_generate_link_no_of_files = '" . intval($NoOfFiles) . "', " .
					"	site_generate_datetime = " . $sql .
					" WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->setDirty();		
	}
	
	private function updateDiscountProductLinkUpdateInfo($Status, $DateTime = 'NOW') {
		if ($DateTime == 'NOW')
			$sql = "NOW()";
		else
			$sql = "'" . aveEscT ($DateTime) . "'";
		
		$query =	" UPDATE site SET " .
					"	site_discount_product_link_update_status = '" . aveEscT($Status) . "', " .
					"	site_discount_product_link_update_datetime = " . $sql .
					" WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->setDirty();
	}
	
	private function updateRichXmlDataInfo($Status, $DateTime = 'NOW') {
		if ($DateTime == 'NOW')
			$sql = "NOW()";
		else
			$sql = "'" . aveEscT ($DateTime) . "'";
		
		$query =	" UPDATE site SET " .
					"	site_rich_xml_data_status = '" . aveEscT($Status) . "', " .
					"	site_rich_xml_data_datetime = " . $sql .
					" WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$this->setDirty();
	}
	
	public function incrementEmailSentMonthlyCount() {
		$query = " UPDATE site SET site_email_sent_monthly_count = site_email_sent_monthly_count + 1 WHERE site_id = '" . $this->site_id . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($this->_cmObjectInfo !== null) {
			$this->_cmObjectInfo->site_email_sent_monthly_count++;
		}
	}
	
	public static function resetEmailSentMonthlyCountForAllSite() {
		$query = " UPDATE site SET site_email_sent_monthly_count = 0 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$this->setDirty();
	}	
	
	public function setDirty() {
		parent::setDirty();
		$this->_cmLangRootList = null;
	}
	
	/**
	 * 
	 * @return cmLangRoot[]
	 */
	public function getCmLangRootList() {
		if ($this->_cmLangRootList == null) {
			require_once(__DIR__ . '/cmLangRoot.class.php');

			$query =	"	SELECT	* " .
						"	FROM	language_root R JOIN object O ON (R.language_root_id = O.object_id AND O.site_id = '" . $this->site_id . "') " .
						"							JOIN language L ON (R.language_id = L.language_id) " .
						"	ORDER BY L.language_id ASC ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$this->_cmLangRootList = array();

			while ($myResult = $result->fetch_object('cmLangRootInfo')) {
				/* @var $myResult cmLangRootInfo */
				$cmLangRoot = new cmLangRoot($myResult->language_root_id, $myResult, $this);
				$this->_cmLangRootList[intval($cmLangRoot->getCmInfo()->language_id)] = $cmLangRoot;
			}
		}		
		return $this->_cmLangRootList;
	}
	
	public function emptyApiCache() {
		$query =	"	DELETE FROM c16cmsapi.api_cache " .
					"	WHERE	site_id	= '" . intval($this->site_id) . "'" .
					"		AND	api_server_type = '" . aveEscT(ENV) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if (trim($this->getCmInfo()->site_empty_cache_url_callback) != '') {

			$URL = trim($this->getCmInfo()->site_empty_cache_url_callback) . '?status=EmptyCache';
			$Para = array();
			$Para['string_1'] = 'Empty Cache';

			$this->callbackExec($URL, $Para);
		}
	}
	
	public function callbackExec($callbackURL, $para) {
		if (!is_array($para))
			$para = array();

		$DateTime = date('Y-m-d H:i:s');
		$callbackURL = $callbackURL . '&datetime=' . urlencode($DateTime) . '&api_login=' . $this->getCmInfo()->site_api_login . '&api_key=' . $this->getCmInfo()->site_api_key;

		$curlHandle = curl_init();
		$timeout = 30;
		curl_setopt ($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curlHandle, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($curlHandle, CURLOPT_FRESH_CONNECT, false);
		curl_setopt ($curlHandle, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
		curl_setopt ($curlHandle, CURLOPT_URL, $callbackURL);
		$callbackResult = curl_exec($curlHandle);

		$query =	"	INSERT INTO	callback_log " .
					"	SET		id_1				= 	'" . aveEsc($para['id_1']) . "', " .
					"			id_2				= 	'" . aveEsc($para['id_2']) . "', " .
					"			id_3				= 	'" . aveEsc($para['id_3']) . "', " .
					"			string_1			= 	'" . aveEsc($para['string_1']) . "', " .
					"			string_2			= 	'" . aveEsc($para['string_2']) . "', " .
					"			string_3			= 	'" . aveEsc($para['string_3']) . "', " .
					"			callback_result		= 	'" . aveEsc($callbackResult) . "', " .
					"			callback_datetime	= 	'" . aveEsc($DateTime) . "', " .
					"			site_id				=	'" . intval($this->site_id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		return $callbackResult;
	}
	
	private $_cmLangRootList = null;
}

class cmSiteInfo {
	public $site_id;
	public $site_is_enable;
	public $site_name;
	public $site_address;
	public $site_api_login;
	public $site_api_key;
	public $site_rich_secret_key;
	public $site_counter_alltime;
	public $site_bonus_point_valid_days;
	public $site_default_language_id;
	public $site_default_currency_id;
	public $site_default_security_level;
	public $site_ftp_address;
	public $site_ftp_web_dir;
	public $site_ftp_userfile_dir;
	public $site_http_userfile_path;
	public $site_ftp_filebase_dir;
	public $site_ftp_static_link_dir;
	public $site_http_static_link_path;
	public $site_ftp_username;
	public $site_ftp_password;
	public $site_ftp_need_passive;
	public $site_empty_cache_url_callback;
	public $site_generate_link_status;
	public $site_generate_link_no_of_files;
	public $site_generate_datetime;
	public $site_structure_seo_link_update_status;
	public $site_structure_seo_link_update_datetime;
	public $site_discount_product_link_update_status;
	public $site_discount_product_link_update_datetime;
	public $site_rich_xml_data_enable;
	public $site_rich_xml_data_status;
	public $site_rich_xml_data_datetime;
	public $site_sitemap_ignore_folder;
	public $site_sitemap_always_now;
	public $site_country_show_other;
	public $site_root_id;
	public $site_use_bonus_point_at_once;
	public $library_root_id;
	public $album_root_id;
	public $bonus_point_root_id;
	public $site_block_holder_root_id;
	public $site_product_root_special_id;
	public $site_product_brand_root_id;
	public $site_user_root_id;
	public $site_block_file_id;
	public $site_media_small_width;
	public $site_media_small_height;
	public $site_media_big_width;
	public $site_media_big_height;
	public $site_media_resize;
	public $site_media_watermark_small_file_id;
	public $site_watermark_position;
	public $site_media_watermark_big_file_id;
	public $site_folder_media_small_width;
	public $site_folder_media_small_height;
	public $site_product_media_small_width;
	public $site_product_media_small_height;
	public $site_product_media_big_width;
	public $site_product_media_big_height;
	public $site_product_media_resize;
	public $site_product_media_watermark_small_file_id;
	public $site_product_media_watermark_big_file_id;
	public $site_email_sent_monthly_quota;
	public $site_email_sent_monthly_count;
	public $site_email_default_content;
	public $site_email_custom_footer;
	public $site_email_user_sender_override_site_sender;
	public $site_email_unsubscribe_hide_mailing_list;
	public $site_module_article_enable;
	public $site_module_article_quota;
	public $site_module_news_enable;
	public $site_module_news_quota;
	public $site_module_layout_news_enable;
	public $site_module_layout_news_quota;
	public $site_module_discount_rule_enable;
	public $site_module_bundle_rule_enable;
	public $site_module_product_enable;
	public $site_module_product_quota;
	public $site_module_album_enable;
	public $site_module_member_enable;
	public $site_module_bonus_point_enable;
	public $site_module_order_enable;
	public $site_module_elasing_enable;
	public $site_module_elasing_multi_level;
	public $site_module_elasing_sender_name;
	public $site_module_elasing_sender_address;
	public $site_module_vote_enable;
	public $site_module_inventory_enable;
	public $site_module_inventory_partial_shipment;
	public $site_module_group_buy_enable;
	public $site_module_content_writer_enable;
	public $site_module_workflow_enable;
	public $site_module_objman_enable;
	public $site_order_show_redeem_tab;
	public $site_product_allow_under_stock;
	public $site_product_stock_threshold_quantity;
	public $site_auto_hold_stock_status;
	public $site_product_category_special_max_no;
	public $site_admin_logo_url;
	public $site_vote_multi;
	public $site_vote_guest;
	public $site_next_order_serial;
	public $site_next_redeem_serial;
	public $site_invoice_enable;
	public $site_invoice_header;
	public $site_invoice_footer;
	public $site_invoice_tnc;
	public $site_invoice_show_product_code;
	public $site_invoice_show_bonus_point;
	public $site_invoice_show_product_image;
	public $site_dn_enable;
	public $site_dn_header;
	public $site_dn_footer;
	public $site_dn_tnc;
	public $site_dn_show_product_code;
	public $site_dn_show_product_image;
	public $site_order_status_change_callback_url;
	public $site_member_status_change_callback_url;
	public $site_order_invoice_callback_url;
	public $site_friendly_link_enable;
	public $site_http_friendly_link_path;
	public $site_friendly_link_version;
	public $site_label_product;
	public $site_label_news;
	public $site_label_layout_news;
	public $site_freight_cost_calculation_id;
	public $site_order_serial_next_reset_date;
	public $site_redeem_serial_next_reset_date;
	public $site_order_serial_reset_type;
	public $site_redeem_serial_reset_type;
	public $site_order_no_format;
	public $site_redeem_no_format;
	public $site_additional_htaccess_content;
	public $site_product_price_version;
	public $site_product_price_indepedent_currency;
	public $site_product_price_process_order;	
}