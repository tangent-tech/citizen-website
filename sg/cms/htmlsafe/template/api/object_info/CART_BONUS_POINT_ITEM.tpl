<bonus_point_item>
	{$BonusPointItemXML}
	<currency_id>{$CurrencyObj->currency_id}</currency_id>
	<quantity>{$CartResultBonusPointItem->quantity|intval}</quantity>
	<cash_ca>{$CartResultBonusPointItem->cash_ca|myxml}</cash_ca>
	<subtotal_cash>{$CartResultBonusPointItem->subtotal_cash|myxml}</subtotal_cash>
	<subtotal_cash_ca>{$CartResultBonusPointItem->subtotal_cash_ca|myxml}</subtotal_cash_ca>
	<subtotal_bonus_point_required>{$CartResultBonusPointItem->subtotal_bonus_point_required|myxml}</subtotal_bonus_point_required>
</bonus_point_item>