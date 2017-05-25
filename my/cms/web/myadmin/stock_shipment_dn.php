<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_order.php');
require_once('../common/header_dn.php');
//include_once(FCK_BASEPATH . "/fckeditor.php");

if (!($Site['site_module_inventory_enable'] == 'Y' || $Site['site_module_inventory_partial_shipment'] == 'Y'))
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'order_list.php', __LINE__);

$TmpFiles = array();

$StockTransaction = inventory::GetStockTransactionInfo($_REQUEST['id']);
if ($StockTransaction['site_id'] != $_SESSION['site_id'])
	AdminDie(ADMIN_ERROR_INVALID_INTERNAL_DATA_ERROR, 'stock_transaction_list.php', __LINE__);
$smarty->assign('StockTransaction', $StockTransaction);

$MyOrder = cart::GetMyOrderInfo($StockTransaction['myorder_id']);
$smarty->assign('MyOrder', $MyOrder);

$StockTransactionProducts = inventory::GetStockTransactionProducts($_REQUEST['id'], $Site['site_default_language_id']);
if ($Site['site_invoice_show_product_image'] == 'Y') {
	foreach ($StockTransactionProducts as &$Item) {
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
$smarty->assign('StockTransactionProducts', $StockTransactionProducts);

$HongKongDistrict = country::GetHongKongDistrictInfo($StockTransaction['shipment_hk_district_id']);
$smarty->assign('HongKongDistrict', $HongKongDistrict);

$ShipmentCountry = country::GetCountryInfo($StockTransaction['shipment_country_id']);
$smarty->assign('ShipmentCountry', $ShipmentCountry);

$ProductFieldsShow = site::GetProductFieldsShow($_SESSION['site_id']);
$smarty->assign('ProductFieldsShow', $ProductFieldsShow);

$html = $smarty->fetch('myadmin/' . $CurrentLang['language_id'] . '/stock_shipment_dn.tpl');

include("../mpdf51/mpdf.php");
//		$mpdf=new mPDF('', 'A4', '', '', '10', '5', '110', '20', '5', '5', 'P'); 
$mpdf=new mPDF('', 'A4', '', '', '10', '10', '0', '10', '5', '5', 'P'); 
$mpdf->SetHTMLHeader($Site['site_dn_header']);
$mpdf->setHTMLFooter($Site['site_dn_footer'] . '<br /><div align="center"><b>{PAGENO} / {nbpg}</b></div>') ;
$mpdf->useAdobeCJK = true;		// Default setting in config.php
						// You can set this to false if you have defined other CJK fonts		
$mpdf->SetAutoFont(AUTOFONT_ALL);	//	AUTOFONT_CJK | AUTOFONT_THAIVIET | AUTOFONT_RTL | AUTOFONT_INDIC	// AUTOFONT_ALL
						// () = default ALL, 0 turns OFF (default initially)
$mpdf->WriteHTML($html);
$mpdf->Output();

foreach ($TmpFiles as $TmpFile)
	unlink($TmpFile);
exit();