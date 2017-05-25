<?php

if (!defined('IN_CMS'))
	die("huh?");

class cart_result_bonus_point_item {
	public $bonus_point_item_id;
	public $currency_id;
	public $quantity;
	public $cash_ca;
	public $subtotal_cash;
	public $subtotal_cash_ca;
	public $subtotal_bonus_point_required;
	
	public function __construct() {
	}
}