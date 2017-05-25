<?php
	if (!defined('IN_CMS'))
		die("huh?");

	$AdminInfo = null;
	$IsSuperAdmin = false;
	$IsSiteAdmin = false;
	$IsContentAdmin	= false;
	$IsContentWriter = false;
	$IsElasingUser = false;
	$EffectiveACL = array();
	$EffectiveContentAdminGroup	= array();
	$ContentAdminUnreadMsgNo = 0;
	
	if (!isset($_SESSION['SystemAdminID'])) {
		$ContentAdmin = content_admin::GetContentAdminInfo($_SESSION['ContentAdminID']);
		$smarty->assign('ContentAdmin', $ContentAdmin);

		if ($ContentAdmin['content_admin_is_enable'] != 'Y')
			AdminDie(ADMIN_ERROR_LOGIN_FIRST, 'index.php');

		$ContentAdminSite = site::GetSiteInfo($ContentAdmin['site_id']);
		$SystemAdminSiteList = array();
		array_push($SystemAdminSiteList, $ContentAdminSite);
		$smarty->assign('SystemAdminSiteList', $SystemAdminSiteList);

		$_SESSION['site_id'] = $ContentAdmin['site_id'];

		$IsSuperAdmin = false;
		$IsSiteAdmin = false;

		if ($ContentAdmin['content_admin_type'] == 'CONTENT_ADMIN') {
			$IsContentAdmin = true;
			$IsContentWriter = true;
			$IsElasingUser = true;
			
			$EffectiveACL = acl::GetAllAclOption();
			$EffectiveContentAdminGroup = acl::GetAllContentAdminGroupID($ContentAdmin['site_id']);
		}
		elseif ($ContentAdmin['content_admin_type'] == 'ELASING_USER') {
			$IsContentAdmin = false;
			$IsContentWriter = false;
			$IsElasingUser = true;
		}
		elseif ($ContentAdmin['content_admin_type'] == 'CONTENT_WRITER') {
			$IsContentAdmin = false;
			$IsContentWriter = true;
			$IsElasingUser = true;
			
			$EffectiveACL = acl::GetAclListForContentAdmin($_SESSION['ContentAdminID']);
			$EffectiveContentAdminGroup = acl::GetAdminGroupIDListForContentAdmin($_SESSION['ContentAdminID']);
		}

		$AdminInfo = $ContentAdmin;
		
		$MsgList = content_admin::GetContentAdminMsgList($_SESSION['ContentAdminID'], $ContentAdminUnreadMsgNo, 1, 1, 'ANY', 'ANY', 'Y');
	}
	else {
		$SystemAdmin = system_admin::GetSystemAdminInfo($_SESSION['SystemAdminID']);
		$smarty->assign('SystemAdmin', $SystemAdmin);

		if ($SystemAdmin['system_admin_is_enable'] != 'Y')
			AdminDie(ADMIN_ERROR_LOGIN_FIRST, 'index.php');

		if (intval($SystemAdmin['system_admin_security_level']) >= SUPER_ADMIN_LEVEL) {
			$IsSuperAdmin = true;
			$IsSiteAdmin = true;
			$IsContentAdmin = true;
			$IsContentWriter = true;
			$IsElasingUser = true;

			$EffectiveACL = acl::GetAllAclOption();
			
			$SystemAdminSiteList = site::GetAllSiteList('ALL');
			$smarty->assign('SystemAdminSiteList', $SystemAdminSiteList);

			if (isset($_REQUEST['set_site_id'])) {
				$_SESSION['site_id'] = $_REQUEST['set_site_id'];
			}

			if (!site::IsValidSiteID($_SESSION['site_id']))
				$_SESSION['site_id'] = $SystemAdminSiteList[0]['site_id'];

			$EffectiveContentAdminGroup = acl::GetAllContentAdminGroupID($_SESSION['site_id']);
		}
		else {
			$IsSuperAdmin = false;
			$IsSiteAdmin = true;
			$IsContentAdmin = true;
			$IsContentWriter = true;
			$IsElasingUser = true;

			$EffectiveACL = acl::GetAllAclOption();
			
			$SystemAdminSiteList = system_admin::GetSystemAdminSiteList($SystemAdmin['system_admin_id']);
			$smarty->assign('SystemAdminSiteList', $SystemAdminSiteList);
			if (count($SystemAdminSiteList) <= 0)
				AdminDie(ADMIN_ERROR_LOGIN_FIRST, 'index.php');
			if (isset($_REQUEST['set_site_id'])) {
				$_SESSION['site_id'] = $_REQUEST['set_site_id'];
			}
			elseif (!isset($_SESSION['site_id'])) {
				$_SESSION['site_id'] = $SystemAdminSiteList[0]['site_id'];
			}
		
			$EffectiveContentAdminGroup = acl::GetAllContentAdminGroupID($_SESSION['site_id']);

			if (!system_admin::IsSiteAllowedForSystemAdmin($_SESSION['site_id'], $SystemAdmin['system_admin_id'])) 
				AdminDie(ADMIN_ERROR_NOT_YOUR_SITE , 'index.php');
		}
		$AdminInfo = $SystemAdmin;
	}

	$smarty->assign('AdminInfo', $AdminInfo);
	$smarty->assign('IsSuperAdmin', $IsSuperAdmin);
	$smarty->assign('IsSiteAdmin', $IsSiteAdmin);
	$smarty->assign('IsContentAdmin', $IsContentAdmin);
	$smarty->assign('IsContentWriter', $IsContentWriter);
	$smarty->assign('IsElasingUser', $IsElasingUser);
	$smarty->assign('EffectiveACL', $EffectiveACL);
	$smarty->assign('EffectiveContentAdminGroup', $EffectiveContentAdminGroup);
	$smarty->assign('ContentAdminUnreadMsgNo', $ContentAdminUnreadMsgNo);

	//	Get all admin list for object permission setting here
	$ContentAdminOptionList = content_admin::GetContentAdminOptionList($_SESSION['site_id'], 'CONTENT_WRITER');
	$smarty->assign('ContentAdminOptionList', $ContentAdminOptionList);
	
	//	Get all admin writer group list for object permission setting here
	$ContentWriterGroupOptionList = content_admin::GetContentWriterGroupOptionList($_SESSION['site_id']);
	$smarty->assign('ContentWriterGroupOptionList', $ContentWriterGroupOptionList);
	
	$Site = site::GetSiteInfo($_SESSION['site_id']);
	$smarty->assign('Site', $Site);
?>