<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class workflow {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function NewContentAdminMsg($SenderContentAdminID, $ReceiverContentAdminID, $WorkflowID, $ContentAdminMsg) {
		$query	=	"	INSERT INTO content_admin_msg " .
					"	SET		content_admin_id		= '" . intval($ReceiverContentAdminID) . "', " .
					"			sender_content_admin_id	= '" . intval($SenderContentAdminID) . "', " .
					"			workflow_id				= '" . intval($WorkflowID) . "', " .
					"			content_admin_msg_text	= '" . aveEscT($ContentAdminMsg) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewMsgID = customdb::mysqli()->insert_id;

		$Admin = content_admin::GetContentAdminInfo($ReceiverContentAdminID);
		if ($Admin['email_notification'] == 'Y') {
			require_once(PHPMAILER);			

			$mail = new PHPMailer();

			$mail->SetFrom(WORKFLOW_SENDER_EMAIL, WORKFLOW_SENDER_NAME);

			$mail->ClearReplyTos();
			$mail->AddReplyTo(WORKFLOW_SENDER_EMAIL, WORKFLOW_SENDER_NAME);

			$mail->ClearAllRecipients();
			$address = trim($Admin['email']);

//				$mail->IsSMTP();
//				$mail->Host	= "elasing.aveego.com";
			$mail->Sender = $SenderAddress;
			$mail->AddAddress($address, $address);
			$mail->CharSet = 'UTF-8';

			$mail->Subject = "You have a new message in 369CMS";

			global $smarty;
			$body = $smarty->fetch('email_template/workflow_message.tpl');

			$mail->MsgHTML($body);

			if(!$mail->Send()) {
				LogAPI('Email error: ' . $mail->ErrorInfo);
			}

			unset($mail);				
		}

		return $NewMsgID;
	}

	public static function UpdateContentAdminMsgRead($ContentAdminMsgID) {
		$query =	"	UPDATE	content_admin_msg M	" .
					"	SET		M.content_admin_msg_read_date = NOW() " .
					"	WHERE	M.content_admin_msg_id = '" . intval($ContentAdminMsgID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}		

	public static function NewWorkflow($ObjectID, $WorkflowType, $SenderContentAdminID, $ReceiverContentAdminGroupID, $SenderComment, $Para) {
		$para_sql = '';
		for ($i = 1; $i <= 5; $i++) {
			if (isset($Para['int_' . $i]))
				$para_sql = $para_sql . " workflow_para_int_" . $i . " = " . intval($Para['int_' . $i]) . ", ";
			if (isset($Para['double_' . $i]))
				$para_sql = $para_sql . " workflow_para_double_" . $i . " = " . doubleval($Para['double_' . $i]) . ", ";
			if (isset($Para['text_' . $i]))
				$para_sql = $para_sql . " workflow_para_text_" . $i . " = '" . aveEscT($Para['text_' . $i]) . "', ";
		}

		$query	=	"	INSERT INTO workflow " .
					"	SET		sender_content_admin_id				= '" . intval($SenderContentAdminID) . "', " . $para_sql .
					"			receiver_content_admin_group_id		= '" . intval($ReceiverContentAdminGroupID) . "', " .
					"			object_id							= '" . intval($ObjectID)  . "', " .
					"			workflow_type						= '" . aveEscT($WorkflowType) . "', " .
					"			workflow_result						= 'AWAITING_APPROVAL', " .
					"			workflow_result_content_admin_id	= 0, " .
					"			workflow_comment_by_sender			= '" . aveEscT($SenderComment) . "', " .
					"			workflow_comment_by_receiver		= ''";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$NewWorkflowID = customdb::mysqli()->insert_id;

		return $NewWorkflowID;
	}

	public static function DeleteWorkflow($WorkflowID) {
		$query =	"	DELETE FROM workflow " .
					"	WHERE	workflow_id	= '" . intval($WorkflowID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM content_admin_msg " .
					"	WHERE	workflow_id	= '" . intval($WorkflowID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function OverrideExistingRunningWorkflow($ObjectID, $WorkflowType) {
		$query	=	"	UPDATE	workflow " .
					"	SET		workflow_result = 'OVERRIDED' " .
					"	WHERE	workflow_type	= '" . aveEscT($WorkflowType) . "' " .
					"		AND	(workflow_result = 'RETURN_TO_SENDER' OR workflow_result = 'AWAITING_APPROVAL') " .
					"		AND	object_id		= '" . intval($ObjectID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetWorkflowInfo($WorkflowID) {
		$query =	"	SELECT		W.*, G.*, A.email AS result_content_admin_email, WSA.email AS workflow_sender_content_admin_email " .
					"	FROM		workflow W				LEFT JOIN	content_admin_group	G	ON (G.content_admin_group_id = W.receiver_content_admin_group_id) " .
					"										LEFT JOIN	content_admin A			ON (A.content_admin_id = W.workflow_result_content_admin_id) " .
					"										LEFT JOIN	content_admin WSA		ON (WSA.content_admin_id = W.sender_content_admin_id) " .
					"	WHERE		W.workflow_id = '" . intval($WorkflowID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function IsWorkflowReadableByContentAdmin($WorkflowID, $ContentAdminID) {
		$WhereSQL = '';
		$WhereInSQL = '';
		$WhereOutSQL = '';

		// IN Workflow
		$ContentAdminGroupList = content_admin::GetContentWriterGroupListByContentAdminID($ContentAdminID);

		if (count($ContentAdminGroupList) > 0) {
			$ContentAdminGroupSQL = '';
			foreach ($ContentAdminGroupList as $G)
				$ContentAdminGroupSQL = $ContentAdminGroupSQL . "W.receiver_content_admin_group_id = '" . intval($G['content_admin_group_id']) . "' OR ";

			$WhereInSQL = substr($ContentAdminGroupSQL, 0, -3);
		}

		// Out Workflow
		$WhereOutSQL = " W.sender_content_admin_id = '" . intval($ContentAdminID) . "'";

		$WhereSQL = "AND ( " . $WhereInSQL . " OR " . $WhereOutSQL . ") ";

		$query =	"	SELECT		* " .
					"	FROM		workflow W " .
					"	WHERE		W.workflow_id = '" . intval($WorkflowID) . "' " . $WhereSQL .
					"	ORDER BY	W.workflow_create_date DESC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			return false;
	}

}