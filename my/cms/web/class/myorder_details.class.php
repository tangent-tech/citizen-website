<?php

if (!defined('IN_CMS'))
	die("huh?");

class myorder_details {	
	// DB Fields
	public $myorder_id;
	public $order_no;
	public $order_status;
	public $order_content_type;
	public $self_take;
	public $user_id;
	public $site_id;
	public $shop_id;
	public $terminal_id;
	public $cash_paid_ca;
	public $cash_paid;
	public $cash_paid_curreny_id;
	public $cash_change_ca;
	public $effective_base_price_id;
	public $bonus_point_item_id;
	public $deliver_to_different_address;
	public $email_order_confirm;
	public $invoice_country_id;
	public $invoice_country_other;
	public $invoice_hk_district_id;
	public $invoice_first_name;
	public $invoice_last_name;
	public $invoice_company_name;
	public $invoice_city_name;
	public $invoice_region;
	public $invoice_postcode;
	public $invoice_phone_no;
	public $invoice_tel_country_code;
	public $invoice_tel_area_code;
	public $invoice_fax_country_code;
	public $invoice_fax_area_code;
	public $invoice_fax_no;
	public $invoice_shipping_address_1;
	public $invoice_shipping_address_2;
	public $invoice_email;
	public $delivery_country_id;
	public $delivery_country_other;
	public $delivery_hk_district_id;
	public $delivery_first_name;
	public $delivery_last_name;
	public $delivery_company_name;
	public $delivery_city_name;
	public $delivery_region;
	public $delivery_postcode;
	public $delivery_phone_no;
	public $delivery_tel_country_code;
	public $delivery_tel_area_code;
	public $delivery_fax_no;
	public $delivery_fax_country_code;
	public $delivery_fax_area_code;
	public $delivery_shipping_address_1;
	public $delivery_shipping_address_2;
	public $delivery_email;
	public $delivery_date;
	public $user_message;
	public $bonus_point_previous;
	public $bonus_point_earned;
	public $bonus_point_earned_supplied_by_client;
	public $bonus_point_canbeused;
	public $bonus_point_redeemed;
	public $bonus_point_balance;
	public $bonus_point_redeemed_cash;
	public $bonus_point_redeemed_cash_ca;
	public $payment_confirmed;
	public $order_confirmed;
	public $currency_id;
	public $currency_site_rate_atm;
	public $user_balance_previous;
	public $user_balance_used;
	public $user_balance_used_ca;
	public $user_balance_after;
	public $total_price;
	public $total_price_ca;
	public $discount_amount_ca;
	public $user_input_discount_code;
	public $continue_process_postprocess_discount_rule;
	public $effective_discount_postprocess_rule_id;
	public $effective_discount_postprocess_rule_discount_code;
	public $postprocess_rule_discount_amount;
	public $postprocess_rule_discount_amount_ca;
	public $freight_cost_ca;
	public $pay_amount_ca;
	public $order_confirm_by;
	public $order_confirm_date;
	public $payment_confirm_by;
	public $payment_confirm_date;
	public $shipment_confirm_by;
	public $shipment_confirm_date;
	public $create_date;
	public $reference_1;
	public $reference_2;
	public $reference_3;
	public $is_handled;
	public $user_reference;
	public $myorder_custom_text_1;
	public $myorder_custom_text_2;
	public $myorder_custom_text_3;
	public $myorder_custom_text_4;
	public $myorder_custom_text_5;
	public $myorder_custom_text_6;
	public $myorder_custom_text_7;
	public $myorder_custom_text_8;
	public $myorder_custom_text_9;
	public $myorder_custom_text_10;
	public $myorder_custom_text_11;
	public $myorder_custom_text_12;
	public $myorder_custom_text_13;
	public $myorder_custom_text_14;
	public $myorder_custom_text_15;
	public $myorder_custom_text_16;
	public $myorder_custom_text_17;
	public $myorder_custom_text_18;
	public $myorder_custom_text_19;
	public $myorder_custom_text_20;
	public $myorder_custom_int_1;
	public $myorder_custom_int_2;
	public $myorder_custom_int_3;
	public $myorder_custom_int_4;
	public $myorder_custom_int_5;
	public $myorder_custom_int_6;
	public $myorder_custom_int_7;
	public $myorder_custom_int_8;
	public $myorder_custom_int_9;
	public $myorder_custom_int_10;
	public $myorder_custom_int_11;
	public $myorder_custom_int_12;
	public $myorder_custom_int_13;
	public $myorder_custom_int_14;
	public $myorder_custom_int_15;
	public $myorder_custom_int_16;
	public $myorder_custom_int_17;
	public $myorder_custom_int_18;
	public $myorder_custom_int_19;
	public $myorder_custom_int_20;
	public $myorder_custom_double_1;
	public $myorder_custom_double_2;
	public $myorder_custom_double_3;
	public $myorder_custom_double_4;
	public $myorder_custom_double_5;
	public $myorder_custom_double_6;
	public $myorder_custom_double_7;
	public $myorder_custom_double_8;
	public $myorder_custom_double_9;
	public $myorder_custom_double_10;
	public $myorder_custom_double_11;
	public $myorder_custom_double_12;
	public $myorder_custom_double_13;
	public $myorder_custom_double_14;
	public $myorder_custom_double_15;
	public $myorder_custom_double_16;
	public $myorder_custom_double_17;
	public $myorder_custom_double_18;
	public $myorder_custom_double_19;
	public $myorder_custom_double_20;
	public $myorder_custom_date_1;
	public $myorder_custom_date_2;
	public $myorder_custom_date_3;
	public $myorder_custom_date_4;
	public $myorder_custom_date_5;
	public $myorder_custom_date_6;
	public $myorder_custom_date_7;
	public $myorder_custom_date_8;
	public $myorder_custom_date_9;
	public $myorder_custom_date_10;
	public $myorder_custom_date_11;
	public $myorder_custom_date_12;
	public $myorder_custom_date_13;
	public $myorder_custom_date_14;
	public $myorder_custom_date_15;
	public $myorder_custom_date_16;
	public $myorder_custom_date_17;
	public $myorder_custom_date_18;
	public $myorder_custom_date_19;
	public $myorder_custom_date_20;
	public $order_can_delete;
	public $order_can_void;
	
	public function __construct() {
	}	
}