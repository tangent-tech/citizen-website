<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/content_admin_header.php');
require_once('../common/header_article.php');
include_once(FCK_BASEPATH . "/fckeditor.php");

$smarty->assign('CurrentTab', 'site_setting_general');
$smarty->assign('CurrentTab2', 'site_setting_general');
$smarty->assign('MyJS', 'site_setting_general');

$smarty->assign('site_id', $_SESSION['site_id']);

$SiteLanguage = language::GetAllSiteLanguageRoot($_SESSION['site_id'], 'N', 'Y');
$smarty->assign('SiteLanguage', $SiteLanguage);

$SiteCurrency = currency::GetAllSiteCurrencyList($_SESSION['site_id']);
$smarty->assign('SiteCurrency', $SiteCurrency);

$SiteFreightList = site::GetAllSiteFreightObjList($_SESSION['site_id']);
$smarty->assign('SiteFreightList', $SiteFreightList);

$EditorInvoiceHeader	= new FCKeditor('EditorInvoiceHeader');
$EditorInvoiceHeader->BasePath = FCK_BASEURL;
$EditorInvoiceHeader->Value	= $Site['site_invoice_header'];
$EditorInvoiceHeader->Width	= '700';
$EditorInvoiceHeader->Height	= '400';
$EditorInvoiceHeaderHTML = $EditorInvoiceHeader->Create();
$smarty->assign('EditorInvoiceHeaderHTML', $EditorInvoiceHeaderHTML);

$EditorInvoiceFooter	= new FCKeditor('EditorInvoiceFooter');
$EditorInvoiceFooter->BasePath = FCK_BASEURL;
$EditorInvoiceFooter->Value	= $Site['site_invoice_footer'];
$EditorInvoiceFooter->Width	= '700';
$EditorInvoiceFooter->Height	= '400';
$EditorInvoiceFooterHTML = $EditorInvoiceFooter->Create();
$smarty->assign('EditorInvoiceFooterHTML', $EditorInvoiceFooterHTML);

$EditorInvoiceTNC	= new FCKeditor('EditorInvoiceTNC');
$EditorInvoiceTNC->BasePath = FCK_BASEURL;
$EditorInvoiceTNC->Value	= $Site['site_invoice_tnc'];
$EditorInvoiceTNC->Width	= '700';
$EditorInvoiceTNC->Height	= '400';
$EditorInvoiceTNCHTML = $EditorInvoiceTNC->Create();
$smarty->assign('EditorInvoiceTNCHTML', $EditorInvoiceTNCHTML);

$EditorDnHeader	= new FCKeditor('EditorDnHeader');
$EditorDnHeader->BasePath = FCK_BASEURL;
$EditorDnHeader->Value	= $Site['site_dn_header'];
$EditorDnHeader->Width	= '700';
$EditorDnHeader->Height	= '400';
$EditorDnHeaderHTML = $EditorDnHeader->Create();
$smarty->assign('EditorDnHeaderHTML', $EditorDnHeaderHTML);

$EditorDnFooter	= new FCKeditor('EditorDnFooter');
$EditorDnFooter->BasePath = FCK_BASEURL;
$EditorDnFooter->Value	= $Site['site_dn_footer'];
$EditorDnFooter->Width	= '700';
$EditorDnFooter->Height	= '400';
$EditorDnFooterHTML = $EditorDnFooter->Create();
$smarty->assign('EditorDnFooterHTML', $EditorDnFooterHTML);

$EditorDnTNC	= new FCKeditor('EditorDnTNC');
$EditorDnTNC->BasePath = FCK_BASEURL;
$EditorDnTNC->Value	= $Site['site_dn_tnc'];
$EditorDnTNC->Width	= '700';
$EditorDnTNC->Height	= '400';
$EditorDnTNCHTML = $EditorDnTNC->Create();
$smarty->assign('EditorDnTNCHTML', $EditorDnTNCHTML);


$smarty->assign('TITLE', 'Site Setting');
$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/site_setting_general.tpl');