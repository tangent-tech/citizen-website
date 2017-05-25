<?php

if (!defined('IN_CMS'))
	die("huh?");

class myorder_bonus_point_item {
	public $myorder_id;
	public $bonus_point_item_id;
	public $currency_id;
	public $quantity;
	public $bonus_point_required;
	public $cash;
	public $cash_ca;
	public $subtotal_cash;
	public $subtotal_cash_ca;
	public $subtotal_bonus_point_required;
	
	public function __construct() {
	}
}

?>