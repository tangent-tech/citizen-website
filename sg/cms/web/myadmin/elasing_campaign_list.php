<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_list');
$smarty->assign('MyJS', 'elasing_campaign_list');

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_campaign_list_per_page'])) {
	if (intval($_POST['num_of_campaign_list_per_page']) < NUM_OF_ELASING_CAMPAIGN_PER_PAGE)
		$_POST['num_of_campaign_list_per_page'] = NUM_OF_ELASING_CAMPAIGN_PER_PAGE;
	setcookie('num_of_campaign_list_per_page', $_POST['num_of_campaign_list_per_page']);
	$_COOKIE['num_of_campaign_list_per_page'] = $_POST['num_of_campaign_list_per_page'];
}
else {
	if (intval($_COOKIE['num_of_campaign_list_per_page']) < NUM_OF_ELASING_CAMPAIGN_PER_PAGE) {
		$_COOKIE['num_of_campaign_list_per_page'] = NUM_OF_ELASING_CAMPAIGN_PER_PAGE;
		setcookie('num_of_campaign_list_per_page', $_COOKIE['num_of_campaign_list_per_page']);
	}
}

if (isset($_POST['campaign_status'])) {
	setcookie('campaign_status', $_POST['campaign_status']);
	$_COOKIE['campaign_status'] = $_POST['campaign_status'];
}
else {
	if ($_COOKIE['campaign_status'] == "") {
		
		$_COOKIE['campaign_status'] = "All";
		setcookie('campaign_status', $_COOKIE['campaign_status']);
	}
}

$TotalCampaignList = 0;

$CampaignList = null;
if ($IsContentAdmin)
	$CampaignList = emaillist::GetCampaignListBySiteID($_SESSION['site_id'], $TotalCampaignList, $_REQUEST['page_id'], $_COOKIE['num_of_campaign_list_per_page'], 0);
elseif ($IsElasingUser)
	$CampaignList = emaillist::GetCampaignListBySiteID($_SESSION['site_id'], $TotalCampaignList, $_REQUEST['page_id'], $_COOKIE['num_of_campaign_list_per_page'], $_SESSION['ContentAdminID']);
$smarty->assign('CampaignList', $CampaignList);

$NoOfPage = ceil($TotalCampaignList / $_COOKIE['num_of_campaign_list_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Campaign List');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_campaign_list.tpl');