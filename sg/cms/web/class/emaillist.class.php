<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class emaillist {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetEmailListBySiteID($SiteID, &$TotalEmailList, $PageNo = 1, $EmailListPerPage = 20, $ContentAdminID = 0, $IsDeleted = 'N') {
		$Offset = intval(($PageNo -1) * $EmailListPerPage);

		$sql = '';
		if ($ContentAdminID != 0)
			$sql =	"	AND	A.content_admin_id = '" . intval($ContentAdminID) . "'";

		if ($IsDeleted != 'ALL')
			$sql = 	"	AND	L.is_deleted = '" . ynval($IsDeleted) . "'" . $sql;

		$query  =	" 	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	elasing_list L	LEFT JOIN	content_admin A	ON	(L.content_admin_id = A.content_admin_id) " .
					"	WHERE	L.site_id = '" . intval($SiteID) . "'" . $sql .
					"	ORDER BY A.content_admin_id ASC, L.list_id ASC" .
					"	LIMIT	" . $Offset . ", " . intval($EmailListPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalEmailList = $myResult[0];

		$EmailList = array();
		while ($myResult = $result->fetch_assoc())
			array_push($EmailList, $myResult);
		return $EmailList;
	}

	public static function GetEmailListDetails($id) {
		$query  =	" 	SELECT	*, EL.* " .
					"	FROM	elasing_list EL LEFT JOIN content_admin A ON (EL.content_admin_id = A.content_admin_id) " .
					"	WHERE	EL.list_id = '" . intval($id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetSubscriberList($EmailListID, $SiteID, &$TotalSubscriber, $PageNo = 1, $SubscriberPerPage = 20) {
		$Offset = intval(($PageNo -1) * $SubscriberPerPage);

		$query  =	" 	SELECT	SQL_CALC_FOUND_ROWS *, L.*, S.* " .
					"	FROM	elasing_list_subscriber L	JOIN elasing_subscriber S ON (L.list_id = '" . intval($EmailListID) . "' AND L.subscriber_id = S.subscriber_id) " .
					"										LEFT JOIN elasing_site_subscriber ESS ON (S.subscriber_id = ESS.subscriber_id AND ESS.site_id = '" . intval($SiteID) . "')" .
					"	WHERE	L.is_confirmed = 'Y' " .
					"	ORDER BY L.list_subscriber_id " .
					"	LIMIT	" . $Offset . ", " . intval($SubscriberPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalSubscriber = $myResult[0];

		$SubscriberList = array();

		while ($myResult = $result->fetch_assoc())
			array_push($SubscriberList, $myResult);

		return $SubscriberList;
	}

	public static function GetSubscriberInfo($EmailAddress, $EmailListID) {
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_list_subscriber LS	JOIN	elasing_subscriber S	ON (LS.subscriber_id = S.subscriber_id) " .
					"										JOIN	elasing_list L			ON (LS.list_id = L.list_id) " .
					"	WHERE	L.list_id = '" . intval($EmailListID) . "' " .
					"		AND	S.subscriber_email = '" . aveEscT(strtolower($EmailAddress)) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetSubscriberInfoBySiteID($EmailAddress, $SiteID) {
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_site_subscriber SS	JOIN	elasing_subscriber S	ON (SS.subscriber_id = S.subscriber_id) " .
					"	WHERE	SS.site_id = '" . intval($SiteID) . "' " .
					"		AND	S.subscriber_email = '" . aveEscT(strtolower($EmailAddress)) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetSubscriberInfoXML($EmailAddress, $EmailListID) {
		$smarty = new mySmarty();
		$Subscriber = emaillist::GetSubscriberInfo($EmailAddress, $EmailListID);
		$smarty->assign('Object', $Subscriber);
		$SubscriberXML = $smarty->fetch('api/object_info/SUBSCRIBER.tpl');
		return $SubscriberXML;
	}

	public static function GetListSubscriberLinkInfo($list_subscriber_id) {
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_list_subscriber LS	JOIN	elasing_subscriber S	ON (LS.subscriber_id = S.subscriber_id) " .
					"										JOIN	elasing_list L			ON (LS.list_id = L.list_id) " .
					"	WHERE	LS.list_subscriber_id = '" . intval($list_subscriber_id) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetCampaignListBySiteID($SiteID, &$TotalCampaign, $PageNo = 1, $CampaignPerPage = 20, $ContentAdminID = 0) {
		$Offset = intval(($PageNo -1) * $CampaignPerPage);

		$sql = '';
		if ($ContentAdminID != 0)
			$sql =	"	AND	A.content_admin_id = '" . intval($ContentAdminID) . "'";

		$query  =	" 	SELECT	SQL_CALC_FOUND_ROWS A.*, EC.* " .
					"	FROM	elasing_campaign EC	LEFT JOIN content_admin A ON (EC.content_admin_id = A.content_admin_id) " .
					"	WHERE	EC.site_id = '" . intval($SiteID) . "'" . $sql .
					"	ORDER BY EC.campaign_active_datetime DESC " .
					"	LIMIT	" . $Offset . ", " . intval($CampaignPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalCampaign = $myResult[0];

		$CampaignList = array();

		while ($myResult = $result->fetch_assoc())
			array_push($CampaignList, $myResult);

		return $CampaignList;
	}

	public static function GetCampaignDetails($id) {
		$query  =	" 	SELECT	*, EC.* " .
					"	FROM	elasing_campaign EC LEFT JOIN content_admin A ON (EC.content_admin_id = A.content_admin_id) " .
					"	WHERE	EC.campaign_id = '" . intval($id) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetCampaignSubscriberList($id, &$TotalSubscriber, $PageNo = 1, $SubscriberPerPage = 20, $DeliveryStatus = 'ALL', $IsOpened = 'ALL', $IsClicked = 'ALL') {
		$Offset = intval(($PageNo -1) * $SubscriberPerPage);

		$sql = '';
		if ($DeliveryStatus != 'ALL')
			$sql = $sql . "	AND	CE.delivery_status = '" . aveEscT($DeliveryStatus) . "'";
		if ($IsOpened != 'ALL')
			$sql = $sql . "	AND	CE.is_opened = '" . ynval($IsOpened) . "'";
		if ($IsClicked != 'ALL')
			$sql = $sql . "	AND	CE.is_clicked = '" . ynval($IsClicked) . "'";

		$query  =	" 	SELECT	SQL_CALC_FOUND_ROWS * " .
					"	FROM	elasing_campaign_email CE	JOIN elasing_subscriber S ON (CE.subscriber_id = S.subscriber_id) " .
					"										JOIN elasing_campaign C ON (CE.campaign_id = C.campaign_id) " .
					"										LEFT JOIN elasing_site_subscriber SS ON (CE.subscriber_id = SS.subscriber_id AND SS.site_id = C.site_id) " .
					"	WHERE	CE.campaign_id = '" . $id . "' " . $sql .
					"	ORDER BY S.subscriber_email " .
					"	LIMIT	" . $Offset . ", " . intval($SubscriberPerPage);
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	SELECT FOUND_ROWS() ";
		$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result2->fetch_row();
		$TotalSubscriber = $myResult[0];

		$EmailList = array();

		while ($myResult = $result->fetch_assoc())
			array_push($EmailList, $myResult);

		return $EmailList;
	}

	public static function AddEmailToList($Email, $ListID, $SiteID, $IsConfirmed = 'Y', $FirstName ='', $LastName = '') {
		if (IsValidEmail(trim($Email))) {
			$query	=	"	UPDATE	elasing_list " .
						"	SET		last_update = now() " .
						"	WHERE	list_id = '" . intval($ListID) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	INSERT INTO elasing_subscriber " .
						"	SET	subscriber_email	= '" . aveEscT(strtolower($Email)) . "', " .
						"		unsubscribe_key		= '" . substr(md5(rand(0,65535) . "elasing call me rambo!" . rand(0,65535) ), 0, 8) . "', " .
						"		soft_bounce_count	= 0, " .
						"		hard_bounce_count	= 0, " .
						"		deny_all_elasing	= 'N'" .
						"	ON DUPLICATE KEY " .
						"	UPDATE	subscriber_id = LAST_INSERT_ID(subscriber_id)";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$SubscriberID = customdb::mysqli()->insert_id;

			$query  =	" 	INSERT INTO elasing_list_subscriber " .
						"	SET	list_id			= '" . intval($ListID) . "', " .
						"		subscriber_id	= '" . intval($SubscriberID) . "', " .
						"		subscribe_key	= '" . substr(md5(rand(0,65535) . "ewgagc321aweg" . rand(0,65535) ), 0, 8) . "', " .
						"		is_confirmed	= '". ynval($IsConfirmed) . "'" .
						"	ON DUPLICATE KEY " .
						"	UPDATE	is_confirmed = '". ynval($IsConfirmed) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query =	"	INSERT INTO	elasing_site_subscriber " .
						"	SET		deny_all_site = 'N', " .
						"			subscriber_id = '" . intval($SubscriberID) . "', " .
						"			site_id = '" . intval($SiteID) . "', " .
						"			subscriber_first_name = '" . aveEscT($FirstName) . "', " .
						"			subscriber_last_name = '" . aveEscT($LastName) . "' " .
						"	ON DUPLICATE KEY UPDATE " .
						"			subscriber_first_name = '" . aveEscT($FirstName) . "', " .
						"			subscriber_last_name = '" . aveEscT($LastName) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			return true;
		}
		else
			return false;
	}

	public static function AddEmailToCampaign(&$ErrorMsg, $Email, $CampaignID, $SiteID, $FirstName ='', $LastName = '') {
		if (IsValidEmail(trim($Email))) {
			$query  =	" 	INSERT INTO elasing_subscriber " .
						"	SET	subscriber_email	= '" . aveEscT(strtolower($Email)) . "', " .
						"		unsubscribe_key		= '" . substr(md5(rand(0,65535) . "elasing call me rambo!" . rand(0,65535) ), 0, 8) . "', " .
						"		soft_bounce_count	= 0, " .
						"		hard_bounce_count	= 0, " .
						"		deny_all_elasing	= 'N'" .
						"	ON DUPLICATE KEY " .
						"	UPDATE	subscriber_id = LAST_INSERT_ID(subscriber_id)";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$SubscriberID = customdb::mysqli()->insert_id;

			$query =	"	INSERT INTO	elasing_site_subscriber " .
						"	SET		deny_all_site = 'N', " .
						"			subscriber_id = '" . intval($SubscriberID) . "', " .
						"			site_id = '" . intval($SiteID) . "', " .
						"			subscriber_first_name = '" . aveEscT($FirstName) . "', " .
						"			subscriber_last_name = '" . aveEscT($LastName) . "' " .
						"	ON DUPLICATE KEY UPDATE " .
						"			subscriber_first_name = '" . aveEscT($FirstName) . "', " .
						"			subscriber_last_name = '" . aveEscT($LastName) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$Subscriber = emaillist::GetSubscriberInfoBySiteID($Email, $SiteID);

			if ($Subscriber['deny_all_site'] == 'N' && $Subscriber['deny_all_elasing'] == 'N') {
				$query  =	" 	INSERT INTO elasing_campaign_email " .
							"	SET	campaign_id			= '" . intval($CampaignID) . "', " .
							"		subscriber_id		= '" . $Subscriber['subscriber_id'] . "', " .
							"		campaign_email_key	= '" . substr(md5(rand(0,65535) . "avbwbwe" . rand(0,65535) ), 0, 8) . "', " .
							"		delivery_status		= 'in_queue', " .
							"		delivery_datetime	= NULL, " .
							"		remark				= '', " .
							"		is_opened			= 'N', " .
							"		is_clicked			= 'N'" .
							"	ON DUPLICATE KEY " .
							"	UPDATE	campaign_email_id = LAST_INSERT_ID(campaign_email_id)";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				$query  =	" 	SELECT	COUNT(*) AS TotalEmail " .
							"	FROM	elasing_campaign_email " .
							"	WHERE	campaign_id			= '" . intval($CampaignID) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
				$myResult = $result->fetch_assoc();

				$query  =	" 	UPDATE	elasing_campaign" .
							"	SET		no_of_emails = '" . intval($myResult['TotalEmail']) . "'" .
							"	WHERE	campaign_id			= '" . intval($CampaignID) . "'";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

				return true;
			}
			else {
				$ErrorMsg = 'API_ERROR_EMAIL_ADDRESS_DENY_ALL_ELASING';
				return false;
			}
		}
		else {
			$ErrorMsg = 'API_ERROR_INVALID_EMAIL';
			return false;
		}
	}

	public static function ActivateQueue() {
		$query  =	" 	UPDATE	elasing_campaign " .
					"	SET		campaign_status = 'Active' " .
					"	WHERE	campaign_status = 'Submitted' " .
					"		AND	campaign_active_datetime <= NOW() ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function IsSystemActive() {
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_system " .
					"	WHERE	parameter = 'system_active' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();
		$SystemActive = $myResult['the_value'];
		if ($SystemActive == 'yes')
			return true;
		else
			return false;
	}

	public static function GetDomainLimit() {
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_system " .
					"	WHERE	parameter = 'domain_hourly_limit' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_assoc();
		return $myResult['the_value'];
	}

	public static function GetActiveCampaign() {
		// Select All Active Campaign
		$query  =	" 	SELECT	* " .
					"	FROM	elasing_campaign EC	JOIN	site S	ON (EC.site_id = S.site_id) " .
					"	WHERE	EC.campaign_status = 'Active' " .
					"		AND	S.site_email_sent_monthly_quota >= S.site_email_sent_monthly_count ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$ActiveCampaign = array();

		while ($myResult = $result->fetch_assoc())
			array_push($ActiveCampaign, $myResult);

		return $ActiveCampaign;
	}

	public static function GetSubscribersFromCampaign($CampaignID) {
		$query  =	" 	SELECT	*, CE.*, EC.*, ES.* " .
					"	FROM			elasing_campaign_email CE " .
					"		JOIN		elasing_campaign EC			ON	(CE.campaign_id = EC.campaign_id) " .
					"		JOIN		elasing_subscriber ES		ON	(CE.subscriber_id = ES.subscriber_id) " .
					"		LEFT JOIN	elasing_site_subscriber ESS	ON	(CE.subscriber_id = ESS.subscriber_id AND EC.site_id = ESS.site_id) " .
					"	WHERE	CE.campaign_id = '" . intval($CampaignID) . "' " .
					"		AND	CE.delivery_status = 'in_queue' " .
					"		AND	ES.soft_bounce_count < " . SOFT_BOUNCE_LIMIT .
					"		AND	ES.hard_bounce_count < " . HARD_BOUNCE_LIMIT .
					"		AND	ES.deny_all_elasing = 'N' " .
					"	ORDER BY rand() " .
					"	LIMIT	50 ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$Subscribers = array();

		while ($myResult = $result->fetch_assoc())
			array_push($Subscribers, $myResult);

		return $Subscribers;
	}

	public static function UpdateCampaignNoOfSent($CampaignID) {
		$query  =	" 	UPDATE	elasing_campaign " .
					"	SET		no_of_sent = no_of_sent + 1 " .
					"	WHERE	campaign_id = '" . intval($CampaignID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateCampaignEmailStatus($CampaignEmailID, $Status = 'sent') {
		$query  =	" 	UPDATE	elasing_campaign_email " .
					"	SET		delivery_status = '" . aveEscT($Status) . "' " .
					"	WHERE	campaign_email_id = '" . intval($CampaignEmailID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function CompleteCampaign($CampaignID) {
		$query  =	" 	SELECT	* " .
					"	FROM		elasing_campaign_email CE " .
					"		JOIN	elasing_subscriber ES		ON	(CE.subscriber_id = ES.subscriber_id) " .
					"	WHERE	CE.campaign_id = '" . intval($CampaignID) . "' " .
					"		AND	CE.delivery_status = 'in_queue' " .
					"		AND	(		ES.soft_bounce_count >= " . SOFT_BOUNCE_LIMIT .
					"				OR	ES.hard_bounce_count >= " . HARD_BOUNCE_LIMIT .
					"			)" ;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$NoOfBlackList = $result->num_rows;
		while ($myResult = $result->fetch_assoc()) {
			$query  =	" 	UPDATE	elasing_campaign_email " .
						"	SET		delivery_status = 'blacklisted' " .
						"	WHERE	campaign_email_id = '" . $myResult['campaign_email_id'] . "' ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query  =	" 	SELECT	* " .
					"	FROM		elasing_campaign_email CE " .
					"		JOIN	elasing_subscriber ES		ON	(CE.subscriber_id = ES.subscriber_id) " .
					"	WHERE	CE.campaign_id = '" . intval($CampaignID) . "' " .
					"		AND	CE.delivery_status = 'in_queue' " .
					"		AND	ES.deny_all_elasing = 'Y' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$NoOfDenyAll = $result->num_rows;
		while ($myResult = $result->fetch_assoc()) {
			$query  =	" 	UPDATE	elasing_campaign_email " .
						"	SET		delivery_status = 'deny_all' " .
						"	WHERE	campaign_email_id = '" . $myResult['campaign_email_id'] . "' ";
			$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}

		$query  =	" 	UPDATE	elasing_campaign " .
					"	SET		no_of_blacklist = '" . intval($NoOfBlackList) . "', " .
					"			no_of_deny_all = '" . intval($NoOfDenyAll) . "' " .
					"	WHERE	campaign_id = '" . intval($CampaignID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	UPDATE	elasing_campaign " .
					"	SET		campaign_status = 'Completed' " .
					"	WHERE	campaign_id = '" . intval($CampaignID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function SendEmail($Site, $Subscriber, $ActiveCampaign) {
		$smarty = new mySmarty();
		$mail = new PHPMailer();

		$Doc = new DOMDocument();
		$Doc->loadHTML(
			'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' .
			'<html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head><body>' .
			$ActiveCampaign['campaign_content'] . '</body></html>');

		$Links = $Doc->getElementsByTagName('a');
		foreach ($Links as $L) {
			$href = $L->getAttribute('href');
			if ($href != '%unsubscribe_url%')
				$href = BASEURL_ELASING . "tracker_get_link.php?ceid=" . $Subscriber['campaign_email_id'] . "&key=" . $Subscriber['campaign_email_key'] . "&url=" . urlencode($href);
			$L->setAttribute('href', $href);
		}
		$Content = substr($Doc->saveXML($Doc->getElementsByTagName('body')->item(0)), 6, -7);

		$tidy_config = array(
							 'clean' => true,
							 'output-xhtml' => true,
							 'show-body-only' => true,
							 'wrap' => 0,                    
							 );

		$tidy_config = array(
							 'show-body-only' => true
							 );
		$tidy = tidy_parse_string($Content, $tidy_config, 'UTF8'); 

		$Content = substr($tidy->body()->value, 7, -8);

//LogAPI("Raw: \n" . $Content);
		$UnsubscribeURL = BASEURL_ELASING . "unsubscribe.php?ceid=" . $Subscriber['campaign_email_id'] . "&key=" . $Subscriber['campaign_email_key'];

		$theUsername = explode ("@", $Subscriber['subscriber_email']);

		$ElasingSearchWords		= array("%first_name%", "%last_name%", "%user_username%", "%unsubscribe_url%");
		$ElasingReplaceWords	= array($Subscriber['subscriber_first_name'], $Subscriber['subscriber_last_name'], $theUsername[0], $UnsubscribeURL);

		$Content = str_replace($ElasingSearchWords, $ElasingReplaceWords, $Content);
		$smarty->assign('Content', $Content);
//LogAPI("After Replace: \n" . $Content);

		$smarty->assign('Site', $Site);
		$smarty->assign('Subscriber', $Subscriber);
		$smarty->assign('ActiveCampaign', $ActiveCampaign);

		$body = '';
		if ($Site['site_email_custom_footer'] == 'Y')
			$body = $smarty->fetch('email_template/sendout_mail_no_footer_20130520.tpl');
		else
			$body = $smarty->fetch('email_template/sendout_mail_20130520.tpl');
//LogAPI("Body: \n" . $body);

		$SenderAddress = 'noreply-' . $Subscriber['campaign_email_id'] . '-' . $Subscriber['campaign_email_key'] . '@smartemail.369cms.com';

		$FromAddress = 'noreply-' . $Subscriber['campaign_email_id'] . '-' . $Subscriber['campaign_email_key'] . '@smartemail.369cms.com';
		if (strlen(trim($Site['site_module_elasing_sender_address'])) > 0 && IsValidEmail(trim($Site['site_module_elasing_sender_address'])))
			$FromAddress = $Site['site_module_elasing_sender_address'];

		$SenderName = $Site['site_name'];
		if (strlen(trim($Site['site_module_elasing_sender_name'])) > 0 )
			$SenderName = $Site['site_module_elasing_sender_name'];

		$ContentAdmin = content_admin::GetContentAdminInfo($ActiveCampaign['content_admin_id']);
		if (
				($ContentAdmin != null && $Site['site_module_elasing_sender_address'] == 'magic@example.com') ||
				($ContentAdmin != null && $ContentAdmin['content_admin_type'] == 'ELASING_USER' && $Site['site_email_user_sender_override_site_sender'] == 'Y')
			) {
			$FromAddress = $ContentAdmin['email'];

			$SenderName = $ContentAdmin['content_admin_name'];

			if (strlen(trim($SenderName)) <= 0)
				$SenderName = $ContentAdmin['email'];
		}

		$mail->SetFrom($FromAddress, $SenderName);

		$mail->ClearReplyTos();
//			$mail->AddReplyTo('noreply-' . $Subscriber['campaign_email_id'] . '-' . $Subscriber['campaign_email_key'] . '@smartemail.369cms.com', $SenderName);
		$mail->AddReplyTo($FromAddress, $SenderName);


		$mail->ClearAllRecipients();
		$address = trim($Subscriber['subscriber_email']);

		$mail->IsSMTP();
		$mail->Host	= "elasing.aveego.com";
		$mail->Sender = $SenderAddress;
		$mail->AddAddress($address, $address);
		$mail->CharSet = 'UTF-8';
		$mail->AddCustomHeader('Precedence: bulk');
		$mail->AddCustomHeader('List-Unsubscribe: ' . 'noreply-' . $Subscriber['campaign_email_id'] . '-' . $Subscriber['campaign_email_key'] . '@smartemail.369cms.com');

		$mail->Subject = trim($ActiveCampaign['campaign_title']);

		$mail->MsgHTML($body);

		if(!$mail->Send()) {
			LogAPI('Email error: ' . $Subscriber['subscriber_email']);
		}

		emaillist::UpdateCampaignNoOfSent($ActiveCampaign['campaign_id']);
		emaillist::UpdateCampaignEmailStatus($Subscriber['campaign_email_id'], 'sent');

		unset($mail);
	}

	public static function SendErrorReport($Subject, $Content) {
		$smarty = new mySmarty();
		$mail = new PHPMailer();

		$mail->SetFrom('jeff.chan@aveego.com', 'CMS Error Reporter');
		$mail->Sender = 'jeff.chan@aveego.com';

		$mail->ClearReplyTos();
		$mail->ClearAllRecipients();
		$address = trim('info@aveego.com');
		$mail->AddAddress($address, $address);
		$mail->AddAddress('jeff.chan@aveego.com', 'jeff.chan@aveego.com');
		$mail->CharSet = 'UTF-8';

		$mail->Subject = trim($Subject);

		$mail->MsgHTML($Content);

		if(!$mail->Send()) {
			LogAPI('Email error: Error Report cannot be sent.');
		}
		unset($mail);
	}

	public static function UpdateMXCounter($Hostname) {
		$mxhosts = array();
		$weight = array();
		getmxrr($Hostname, $mxhosts, $weight);

		if (count($mxhosts) == 0) {
			$query  =	" 	INSERT INTO	elasing_mx_counter " .
						"	SET			elasing_mx_counter	=	elasing_mx_counter + 1, " .
						"				elasing_mx_host		=	'" . aveEscT($Hostname) . "' " .
						"	ON DUPLICATE KEY " .
						"		UPDATE	elasing_mx_counter	=	elasing_mx_counter + 1 ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
		else {
			foreach($mxhosts as $H) {
				$query  =	" 	INSERT INTO	elasing_mx_counter " .
							"	SET			elasing_mx_counter	=	elasing_mx_counter + 1, " .
							"				elasing_mx_host		=	'" . aveEscT($H) . "' " .
							"	ON DUPLICATE KEY " .
							"		UPDATE	elasing_mx_counter	=	elasing_mx_counter + 1 ";
				$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			}
		}
	}

	public static function CheckMXCounter($Hostname) {
		$sql = '';

		$mxhosts = array();
		$weight = array();
		getmxrr($Hostname, $mxhosts, $weight);

		if (count($mxhosts) == 0)
			$sql = " elasing_mx_host = '" . aveEscT($Hostname) . "' ";
		else {
			foreach($mxhosts as $H)
				$sql = $sql . " elasing_mx_host = '" . aveEscT($H) . "' OR ";
			$sql = substr($sql, 0, -3);
		}

		$query  =	" 	SELECT	MAX(elasing_mx_counter) AS max_count " .
					"	FROM	elasing_mx_counter " .
					"	WHERE	" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();
			return $myResult['max_count'];
		}
		else
			return 0;
	}

	public static function UpdateEmailCount($SiteID) {
		$query  =	" 	UPDATE	site " .
					"	SET		site_email_sent_monthly_count = site_email_sent_monthly_count + 1 " .
					"	WHERE	site_id = '" . intval($SiteID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function UpdateBounceCount($CampaignEmailID, $CampaignEmailKey, $BounceType = 'soft') {
		if ($BounceType != 'soft' && $BounceType != 'hard')
			return false;

		$query  =	" 	SELECT	* " .
					"	FROM	elasing_campaign_email CE " .
					"	WHERE	CE.campaign_email_id	= '" . intval($CampaignEmailID) . "' " .
					"		AND	CE.campaign_email_key	= '" . aveEscT($CampaignEmailKey) . "' " .
					"		AND	CE.delivery_status		= 'sent' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0) {
			$myResult = $result->fetch_assoc();

			$query  =	" 	UPDATE	elasing_campaign_email " .
						"	SET		delivery_status = '" . $BounceType . "_bounced' " .
						"	WHERE	campaign_email_id = '" . $CampaignEmailID . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	elasing_campaign " .
						"	SET		no_of_" . $BounceType . "_bounce = no_of_" . $BounceType . "_bounce + 1 " .
						"	WHERE	campaign_id = '" . $myResult['campaign_id'] . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$query  =	" 	UPDATE	elasing_subscriber " .
						"	SET		" . $BounceType . "_bounce_count = " . $BounceType . "_bounce_count + 1 " .
						"	WHERE	subscriber_id = '" . $myResult['subscriber_id'] . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			return true;
		}
		else
			return false;

	}

	public static function RemoveCampaign($CampaignID) {
		$query  =	" 	DELETE FROM elasing_campaign " .
					"	WHERE	campaign_id = '" . intval($CampaignID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE FROM elasing_campaign_email " .
					"	WHERE	campaign_id = '" . intval($CampaignID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function RemoveEmailList($EmailListID) {
		$query  =	" 	DELETE FROM elasing_list " .
					"	WHERE	list_id = '" . intval($EmailListID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query  =	" 	DELETE FROM elasing_list_subscriber " .
					"	WHERE	list_id = '" . intval($EmailListID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

}