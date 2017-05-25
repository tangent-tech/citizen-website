<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class acl {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function AclBarrier($Option, $FileName, $XMLDie = false) {
		//	Jeff @ 20121219: I like to call this Barrier to remind me the thread terminology, mutex, condition variable, semaphore... haha
		//	Actually AclFence is a better word but barrier looks 型er!

		global $IsContentAdmin, $IsContentWriter;

		if ($IsContentAdmin)
			return true;

		if (!$IsContentWriter)
			acl_die(ADMIN_MSG_ACL_NOT_AUTH, $FileName, $Option, $XMLDie);

		$query =	"	SELECT	* " . 
					"	FROM	content_admin_acl " .
					"	WHERE	content_admin_acl_option = '" . aveEscT($Option) . "'" .
					"		AND	content_admin_id = '" . intval($_SESSION['ContentAdminID']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		if ($result->num_rows > 0)
			return true;
		else
			acl_die(ADMIN_MSG_ACL_NOT_AUTH, $FileName, $Option, $XMLDie);
	}

	public static function ObjPermissionBarrier($Permission = 'add_children/edit/delete/browse_children/publish', $Object, $FileName, $XMLDie = false) {
		if (acl::CheckObjPermission($Permission, $Object))
			return true;
		else
			acl_die(ADMIN_MSG_PERMISSION_NOT_AUTH, $FileName, $Permission, $XMLDie);
	}

	public static function GetObjectPublisherList($Object, &$ContentWriterList, &$ContentAdminList) {
		$ContentWriterList	= content_admin::GetContentWriterGroupMemberList($Object['object_publisher_content_admin_group_id'], 'CONTENT_WRITER');
		$TotalAdminNo = 0;
		$ContentAdminList	= content_admin::GetContentAdminList($Object['site_id'], 'CONTENT_ADMIN', $TotalAdminNo, 1, 999999);
	}

	public static function CheckObjPermission($Permission = 'add_children/edit/delete/browse_children/publish', $Object) {
		global $AdminInfo, $IsContentAdmin, $IsContentWriter, $EffectiveContentAdminGroup;

		if ($IsContentAdmin)
			return true;

		if (!$IsContentWriter)
			return false;

		if (in_array($Permission, array('add_children', 'edit', 'delete', 'browse_children'))) {
			$DbFieldName = 'object_permission_' . $Permission;
			if ($Object[$DbFieldName] == 'OWNER' || $Object[$DbFieldName] == 'OWNER_OR_GROUP') {
				if (intval($Object['object_owner_content_admin_id']) == intval($AdminInfo['content_admin_id']))
					return true;
			}
			if ($Object[$DbFieldName] == 'GROUP' || $Object[$DbFieldName] == 'OWNER_OR_GROUP') {
				if (in_array($Object['object_owner_content_admin_group_id'], $EffectiveContentAdminGroup))
					return true;							
			}
			if ($Object[$DbFieldName] == 'EVERYONE') {
				return true;
			}
		}

		if ($Permission == 'publish') {
			global $Site;
			// Return true for workflow disabled site!
			if ($Site['site_module_workflow_enable'] == 'N')
				return true;

			if (in_array($Object['object_publisher_content_admin_group_id'], $EffectiveContentAdminGroup))
				return true;
		}

		return false;
	}

	public static function SetIsPublisherFlagForSmarty($Object) {
		// IMPORTANT
		// Remember everyone is publisher when $Site['site_module_workflow_enable'] is 'N'
		global $smarty;

		if (acl::CheckObjPermission('publish', $Object))
			$smarty->assign('IsPublisher', true);
		else
			$smarty->assign('IsPublisher', false);
	}

	public static function GetAclListForContentAdmin($ContentAdminID) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin_acl " .
					"	WHERE	content_admin_id = '" . intval($ContentAdminID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AclList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($AclList, $myResult['content_admin_acl_option']);
		}
		return $AclList;
	}

	public static function GetAllAclOption() {
		global $ACL_LIST;

		$OptionValueArray = array();
		foreach ($ACL_LIST as $OptionGroup) {
			$OptionValueArray = array_merge($OptionValueArray, array_keys($OptionGroup));
		}

		return $OptionValueArray;			
	}

	public static function GetAdminGroupIDListForContentAdmin($ContentAdminID) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin_group_member_link " .
					"	WHERE	content_admin_id = '" . intval($ContentAdminID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AdminGroupIDList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($AdminGroupIDList, intval($myResult['content_admin_group_id']));
		}
		return $AdminGroupIDList;
	}

	public static function GetAllContentAdminGroupID($SiteID) {
		$query =	"	SELECT	* " . 
					"	FROM	content_admin_group " .
					"	WHERE	site_id = '" . intval($SiteID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$AdminGroupIDList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($AdminGroupIDList, intval($myResult['content_admin_group_id']));
		}
		array_push($AdminGroupIDList, 0);
		return $AdminGroupIDList;
	}

}