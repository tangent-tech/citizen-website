<?php

if (!defined('IN_CMS'))
	die("huh?");

class myorder_product {
	public $myorder_id;
	public $product_id;
	public $currency_id;
	public $product_price;
	public $product_price_ca;
	public $product_price2;
	public $product_price2_ca;
	public $product_price3;
	public $product_price3_ca;
	public $product_base_price;
	public $product_base_price_ca;
	public $product_bonus_point_amount;
	public $actual_subtotal_price;
	public $actual_subtotal_price_ca;
	public $actual_unit_price;
	public $actual_unit_price_ca;
	public $quantity;
	public $effective_discount_type;
	public $effective_discount_preprocess_rule_id;
	public $discount1_off_p;
	public $discount2_amount;
	public $discount2_price;
	public $discount2_price_ca;
	public $discount3_buy_amount;
	public $discount3_free_amount;
	public $product_option_id;
	public $product_price_id;
	public $cart_content_custom_key;
	public $cart_content_custom_desc;
	public $product_bonus_point_required;
	
	public function __construct() {
	}
}