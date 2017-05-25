<?php

if (!defined('IN_CMS'))
	die("huh?");

class cart_result_product {
	public $cart_content_id;
	public $object_link_id;
	public $product_id;
	public $product_option_id;
	public $product_price_id;
	public $cart_content_custom_key;
	public $cart_content_custom_desc;
	public $quantity;
	public $product_base_price;
	public $product_base_price_ca;
	public $product_price;
	public $product_price_ca;
	public $product_price2;
	public $product_price2_ca;
	public $product_price3;
	public $product_price3_ca;
	public $actual_unit_price;
	public $actual_unit_price_ca;
	public $actual_subtotal_price;
	public $actual_subtotal_price_ca;
	public $effective_discount_type;
	public $effective_discount_preprocess_rule_id;
	public $effective_discount_preprocess_code;
	public $effective_discount_bundle_rule_id;
	public $effective_discount_bundle_code;
	public $discount_type;
	public $product_bonus_point_amount;
	public $product_bonus_point_required;
	public $quantity_adjusted = false;
	public $quantity_original;
	
	public function __construct() {
	}
}