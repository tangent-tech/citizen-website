<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_campaign_list');
$smarty->assign('MyJS', 'elasing_campaign_report');

$Campaign = emaillist::GetCampaignDetails($_REQUEST['id']);
if ($Campaign['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $Campaign['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_campaign_list.php', __LINE__);
$smarty->assign('Campaign', $Campaign);

if (!isset($_REQUEST['page_id']))
	$_REQUEST['page_id'] = 1;
else
	$_REQUEST['page_id'] = intval($_REQUEST['page_id']);

if (isset($_POST['num_of_elasing_subscriber_per_page'])) {
	if (intval($_POST['num_of_elasing_subscriber_per_page']) < NUM_OF_ELASING_SUBSCRIBER_PER_PAGE)
		$_POST['num_of_elasing_subscriber_per_page'] = NUM_OF_ELASING_SUBSCRIBER_PER_PAGE;
	setcookie('num_of_elasing_subscriber_per_page', $_POST['num_of_elasing_subscriber_per_page']);
	$_COOKIE['num_of_elasing_subscriber_per_page'] = $_POST['num_of_elasing_subscriber_per_page'];
}
else {
	if (intval($_COOKIE['num_of_elasing_subscriber_per_page']) < NUM_OF_ELASING_SUBSCRIBER_PER_PAGE) {
		$_COOKIE['num_of_elasing_subscriber_per_page'] = NUM_OF_ELASING_SUBSCRIBER_PER_PAGE;
		setcookie('num_of_elasing_subscriber_per_page', $_COOKIE['num_of_elasing_subscriber_per_page']);
	}
}

$TotalSubscriber = 0;

if (!isset($_REQUEST['DeliveryStatus']))
	$_REQUEST['DeliveryStatus'] = 'ALL';
if (!isset($_REQUEST['IsOpened']))
	$_REQUEST['IsOpened'] = 'ALL';
if (!isset($_REQUEST['IsClicked']))
	$_REQUEST['IsClicked'] = 'ALL';

$SubscriberList = emaillist::GetCampaignSubscriberList($_REQUEST['id'], $TotalSubscriber, $_REQUEST['page_id'], $_COOKIE['num_of_elasing_subscriber_per_page'], $_REQUEST['DeliveryStatus'], $_REQUEST['IsOpened'], $_REQUEST['IsClicked']);
$smarty->assign('SubscriberList', $SubscriberList);

$smarty->assign('SubscriberList', $SubscriberList);
$smarty->assign('TotalSubscriber', $TotalSubscriber);

$NoOfPage = ceil($TotalSubscrbier / $_COOKIE['num_of_elasing_subscriber_per_page']);

$PageNoSelection = array();
$PageNoSelection[1] = 1;
for ($i = 2; $i <= $NoOfPage; $i++)
	$PageNoSelection[$i] = $i;
$smarty->assign('PageNoSelection', $PageNoSelection);

$smarty->assign('TITLE', 'Campaign Report');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_campaign_report.tpl');