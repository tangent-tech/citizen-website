<?php
/* 
Please do NOT think this as an OOP object, I just use the class to group the related functions...
*/

	if (!defined('IN_CMS'))
		die("huh?");

	class order{
		public function __construct() {
			die('Do not create me. I am not an object!');
		}
		
		public static function SendOrderConfirmationEmail($MyOrder, $display = false) {
			global $smarty, $CurrentLang;
			$BonusPointItem = ApiQuery('bonus_point_item_details.php', __LINE__,
												'lang_id=' . $CurrentLang->language_root->language_id .
												'&bonus_point_item_id=' . $MyOrder->myorder->bonus_point_item_id
											);
			$smarty->assign('BonusPointItem', $BonusPointItem);
			
			require_once(PHPMAILER);
			$mail = new PHPMailer();
			
			$mail->CharSet = 'UTF-8';
			$smarty->assign('MyOrder', $MyOrder);
			
			$Country = ApiQuery('country_list.php', __LINE__, 'lang_id=' . $CurrentLang->language_root->language_id);
			
			$smarty->assign('InvoiceCountry',	$Country->xpath("/data/country_list/country[country_id='" . $MyOrder->myorder->invoice_country_id . "']"));
			$smarty->assign('DeliveryCountry',	$Country->xpath("/data/country_list/country[country_id='" . $MyOrder->myorder->delivery_country_id . "']"));

			$District = ApiQuery('hk_district_list.php', __LINE__, '');
			$smarty->assign('InvoiceDistrict', $District->xpath("/data/hk_district_list/hk_district[hk_district_id='" . $MyOrder->myorder->invoice_hk_district_id . "']"));
			$smarty->assign('DeliveryDistrict', $District->xpath("/data/hk_district_list/hk_district[hk_district_id='" . $MyOrder->myorder->delivery_hk_district_id . "']"));
			
			/* debug display */
			if($display == true){
				$smarty->display('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation.tpl');
				die();
			}
			
			$body = $smarty->fetch('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation.tpl');
			$mail->SetFrom(CLIENT_NOREPLY_EMAIL, CLIENT_NAME);
			$address = trim($MyOrder->myorder->invoice_email);
			$mail->AddAddress($address, $address);
			$mail->AddCC(CLIENT_CONTACT_EMAIL, CLIENT_CONTACT_EMAIL);
			$mail->AddBCC('info@aveego.com');

			$mail->Subject = $smarty->fetch('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation_title.tpl');;
		
			$mail->MsgHTML($body);
		
			if(!$mail->Send()) {
				UserDie(ERROR_EMAIL_SYSTEM_ERROR);
			}
		}

		public static function SendOrderConfirmationEmailNoPaypal($MyOrder, $display = false) {
			global $smarty, $CurrentLang;
			$BonusPointItem = ApiQuery('bonus_point_item_details.php', __LINE__,
												'lang_id=' . $CurrentLang->language_root->language_id .
												'&bonus_point_item_id=' . $MyOrder->myorder->bonus_point_item_id
											);
			$smarty->assign('BonusPointItem', $BonusPointItem);
			
			require_once(PHPMAILER);
			$mail = new PHPMailer();
			
			$mail->CharSet = 'UTF-8';
			$smarty->assign('MyOrder', $MyOrder);
			
			$Country = ApiQuery('country_list.php', __LINE__, 'lang_id=' . $CurrentLang->language_root->language_id);
			
			$smarty->assign('InvoiceCountry',	$Country->xpath("/data/country_list/country[country_id='" . $MyOrder->myorder->invoice_country_id . "']"));
			$smarty->assign('DeliveryCountry',	$Country->xpath("/data/country_list/country[country_id='" . $MyOrder->myorder->delivery_country_id . "']"));

			$District = ApiQuery('hk_district_list.php', __LINE__, '');
			$smarty->assign('InvoiceDistrict', $District->xpath("/data/hk_district_list/hk_district[hk_district_id='" . $MyOrder->myorder->invoice_hk_district_id . "']"));
			$smarty->assign('DeliveryDistrict', $District->xpath("/data/hk_district_list/hk_district[hk_district_id='" . $MyOrder->myorder->delivery_hk_district_id . "']"));
			
			/* debug display */
			if($display == true){
				$smarty->display('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation_nopaypal.tpl');
				die();
			}
			
			$body = $smarty->fetch('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation_nopaypal.tpl');
			$mail->SetFrom(CLIENT_NOREPLY_EMAIL, CLIENT_NAME);
			$address = trim($MyOrder->myorder->invoice_email);
			$mail->AddAddress($address, $address);
			$mail->AddCC(CLIENT_CONTACT_EMAIL, CLIENT_CONTACT_EMAIL);
			$mail->AddBCC('info@aveego.com');

			$mail->Subject = $smarty->fetch('email_template/' . $CurrentLang->language_root->language_id . '/order_confirmation_title.tpl');;
		
			$mail->MsgHTML($body);
		
			if(!$mail->Send()) {
				UserDie(ERROR_EMAIL_SYSTEM_ERROR);
			}
		}

		public static function SendOrderVoidEmail($PayRef, $DataFeedID, $PayAmount, $Currency, $User) {
			require_once(PHPMAILER);
			$mail = new PHPMailer();

			global $smarty;
		
			$smarty->assign('User', $User);
			$smarty->assign('PayRef', $PayRef);
			$smarty->assign('DataFeedID', $DataFeedID);
			$smarty->assign('PayAmount', $PayAmount);
			$smarty->assign('Currency', $Currency);
			$body = $smarty->fetch('email_template/' . $User['user_language_id'] . '/order_void.tpl');
	
			$mail->SetFrom(CLIENT_NOREPLY_EMAIL, CLIENT_NAME);
		
			$address = trim($User['email']);
			$mail->AddAddress($address, $address);
		
			$mail->Subject = MSG_ORDER_VOID_EMAIL_SUBJECT;
		
			$mail->MsgHTML($body);
		
			if(!$mail->Send())
				UserDie(ERRORMSG_EMAIL_SYSTEM_ERROR);			
		}

	}
?>