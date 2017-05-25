<site>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<site_id>{$Object.site_id}</site_id>
	<site_name>{$Object.site_name|myxml}</site_name>
	<site_address>{$Object.site_address|myxml}</site_address>
	<site_counter_alltime>{$Object.site_counter_alltime}</site_counter_alltime>
	<site_use_bonus_point_at_once>{$Object.site_use_bonus_point_at_once}</site_use_bonus_point_at_once>
	<site_default_currency_id>{$Object.site_default_currency_id}</site_default_currency_id>
	<site_default_language_id>{$Object.site_default_language_id}</site_default_language_id>
	<currency_paypal>{$Object.currency_paypal}</currency_paypal>
	<currency_paydollar_currCode>{$Object.currency_paydollar_currCode}</currency_paydollar_currCode>
	<currency_shortname>{$Object.currency_shortname}</currency_shortname>
	<currency_longname>{$Object.currency_longname}</currency_longname>
	<currency_site_rate>{$Object.currency_site_rate}</currency_site_rate>
	<currency_precision>{$Object.currency_precision}</currency_precision>
	<site_http_friendly_link_path>{$Object.site_http_friendly_link_path}</site_http_friendly_link_path>
	<site_product_allow_under_stock>{$Object.site_product_allow_under_stock}</site_product_allow_under_stock>
</site>
