<?php
define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$ObjectSeo = GetSeoUrl(WARRANTY_REG_PAGE_LINK_ID);

if(!isset($_SESSION["WarrantyID"]) || intval($_SESSION["WarrantyID"]) < 1){
	UserDie(ERROR_WARRANTY_REG_DATA_ERROR, BASEURL . $ObjectSeo);
}

warranty::ConfirmWarrantyRegister($_SESSION["WarrantyID"]);

$WarrantyDetail = warranty::GetWarrantyDetailByID($_SESSION["WarrantyID"]);
$smarty->assign('WarrantyDetail', $WarrantyDetail);

unset($_SESSION["WarrantyID"]);

require_once(PHPMAILER);
$mail = new PHPMailer();

//$smarty->display('email_template/warranty.tpl');
//die();
$body = $smarty->fetch(BASEDIR .'htmlsafe/template/email_template/' . $CurrentLang->language_root->language_id . '/warranty.tpl');

$mail->CharSet = 'UTF-8';
$mail->SetFrom(CLIENT_NOREPLY_EMAIL, WARRANTY_EMAIL_SEND_FROM);

$address = $WarrantyDetail["email"];
$mail->AddAddress($address, $address);

$mail->AddCC(CLIENT_CONTACT_EMAIL);
$mail->AddBCC(CLIENT_AVE1_EMAIL);
$mail->AddBCC(CLIENT_AVE2_EMAIL);

$mail->Subject = WARRANTY_EMAIL_SUBJECT;

$mail->MsgHTML($body);

if(!$mail->Send())
	UserDie(ERROR_EMAIL_SYSTEM_ERROR, $ObjectSeo);
else
	UserDie(MSG_WARRANTY_REG_SUCCSEE, BASEURL . "/index.php");

?>