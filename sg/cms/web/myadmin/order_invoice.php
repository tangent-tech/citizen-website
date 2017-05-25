<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
require_once('../common/header_invoice.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if (trim($Site['site_order_invoice_callback_url']) == '') {
	$TmpFiles = array();
	
	$MyOrder = cart::GetMyOrderInfo($_REQUEST['id']);
	if ($MyOrder['site_id'] != $_SESSION['site_id'])
		AdminDie(ADMIN_ERROR_ORDER_IS_DELETED, 'order_list.php', __LINE__);
	$smarty->assign('MyOrder', $MyOrder);

	$InvoiceCountry = country::GetCountryInfo($MyOrder['invoice_country_id']);
	$smarty->assign('InvoiceCountry', $InvoiceCountry);
	
	$DeliveryCountry = country::GetCountryInfo($MyOrder['delivery_country_id']);
	$smarty->assign('DeliveryCountry', $DeliveryCountry);
	
	$CountryList = country::GetCountryList(1);
	$smarty->assign('CountryList', $CountryList);
	
	$HKDistrictList = country::GetHongKongDistrictList();
	$smarty->assign('HKDistrictList', $HKDistrictList);
	
	$User = user::GetUserInfo($MyOrder['user_id']);
	$smarty->assign('User', $User);
	
	$UserLanguage = language::GetLanguageInfo($User['user_language_id']);
	$smarty->assign('UserLanguage', $UserLanguage);
	
	$BonusPointItemList = bonuspoint::GetBonusPointItemList($_SESSION['site_id'], $Site['site_default_language_id'], 0, 'ALL');
	$smarty->assign('BonusPointItemList', $BonusPointItemList);
	
	$TotalPrice = 0;
	$TotalPriceCA = 0;
	$TotalCash = 0;
	$TotalCashCA = 0;
	$TotalBonusPoint = 0;
	$TotalBonusPointRequired = 0;
	$MyOrderItemList = cart::GetMyOrderItemList($_REQUEST['id'], $Site['site_default_language_id'], $TotalPrice, $TotalPriceCA, $TotalBonusPoint);
	if ($Site['site_invoice_show_product_image'] == 'Y') {
		foreach ($MyOrderItemList as &$Item) {
			if ($Item['object_thumbnail_file_id'] != 0) {
				$TmpFile = tempnam('/tmp', 'order_invoice_img-');
				array_push($TmpFiles, $TmpFile);
				
				$filepath = filebase::GetPath($Item['object_thumbnail_file_id'], $Site['FtpFilebasePath'] . "/");
				$filename = $filepath . 'file-'. $Item['object_thumbnail_file_id'];
				copy($filename, $TmpFile);
				
				$Item['object_thumbnail_tmp_filename'] = $TmpFile;
			}
		}
	}
	
	$MyOrderBonusPointItemList = cart::GetMyOrderBonusPointItemList($_REQUEST['id'], $Site['site_default_language_id'], $TotalCash, $TotalCashCA, $TotalBonusPointRequired);
	if ($Site['site_invoice_show_product_image'] == 'Y') {
		foreach ($MyOrderBonusPointItemList as &$Item) {
			if ($Item['object_thumbnail_file_id'] != 0) {
				$TmpFile = tempnam('/tmp', 'order_invoice_img-');
				array_push($TmpFiles, $TmpFile);
				
				$filepath = filebase::GetPath($Item['object_thumbnail_file_id'], $Site['FtpFilebasePath'] . "/");
				$filename = $filepath . 'file-'. $Item['object_thumbnail_file_id'];
				copy($filename, $TmpFile);
				
				$Item['object_thumbnail_tmp_filename'] = $TmpFile;
			}
		}
	}
	$smarty->assign('MyOrderItemList', $MyOrderItemList);
	$smarty->assign('MyOrderBonusPointItemList', $MyOrderBonusPointItemList);
	$smarty->assign('TotalPrice', $TotalPrice);
	$smarty->assign('TotalPriceCA', $TotalPriceCA);
	$smarty->assign('TotalBonusPoint', $TotalBonusPoint);

	$smarty->assign('TITLE', 'Order Invoice');
//	$smarty->display("myadmin/" . $CurrentLang['language_id'] . "/order_invoice.tpl");

	$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
	$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

	if (13 > 2) {
		$html = $smarty->fetch('myadmin/' . $CurrentLang['language_id'] . '/order_invoice.tpl');
		
		include("../mpdf51/mpdf.php");
//		$mpdf=new mPDF('', 'A4', '', '', '10', '5', '110', '20', '5', '5', 'P'); 
		$mpdf=new mPDF('', 'A4', '', '', '10', '10', '0', '10', '5', '5', 'P'); 
		$mpdf->SetHTMLHeader($Site['site_invoice_header']);
		$mpdf->setHTMLFooter($Site['site_invoice_footer'] . '<br /><div align="center"><b>{PAGENO} / {nbpg}</b></div>') ;
		$mpdf->useAdobeCJK = true;		// Default setting in config.php
								// You can set this to false if you have defined other CJK fonts		
		$mpdf->SetAutoFont(AUTOFONT_ALL);	//	AUTOFONT_CJK | AUTOFONT_THAIVIET | AUTOFONT_RTL | AUTOFONT_INDIC	// AUTOFONT_ALL
								// () = default ALL, 0 turns OFF (default initially)
		$mpdf->WriteHTML($html);
		$mpdf->Output('invoice.pdf', 'D');
		
		foreach ($TmpFiles as $TmpFile)
			unlink($TmpFile);
		exit();
	}
}
else {
	$OrderStatus = 'payment_confirmed';
	$URL = trim($Site['site_order_invoice_callback_url']) . '?id=' . $_REQUEST['id'] . "&s=" . md5($Site['site_api_login'] . $Site['site_api_key'] . $_REQUEST['id']);
		
	header("Location: " . $URL);
	die();
}