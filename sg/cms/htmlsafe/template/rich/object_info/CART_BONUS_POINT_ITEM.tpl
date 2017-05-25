<bonus_point_item>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	{include file="api/object_info/BONUS_POINT_ITEM_PROTOTYPE.tpl"}
	<currency_id>{$Object.currency_id}</currency_id>
	<quantity>{$Object.quantity|intval}</quantity>
	<cash_ca>{$Object.cash_ca|myxml}</cash_ca>
	<subtotal_cash>{$Object.subtotal_cash|myxml}</subtotal_cash>
	<subtotal_cash_ca>{$Object.subtotal_cash_ca|myxml}</subtotal_cash_ca>
	<subtotal_bonus_point_required>{$Object.subtotal_bonus_point_required|myxml}</subtotal_bonus_point_required>
</bonus_point_item>