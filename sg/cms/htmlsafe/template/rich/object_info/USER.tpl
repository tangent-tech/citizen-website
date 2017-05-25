<user>
	<user_id>{$Object.user_id}</user_id>
	<user_is_enable>{$Object.user_is_enable}</user_is_enable>
	<user_thumbnail_file_id>{$Object.user_thumbnail_file_id}</user_thumbnail_file_id>
	<user_security_level>{$Object.user_security_level}</user_security_level>
	<user_username>{$Object.user_username|myxml}</user_username>
	<user_new_password>{$Object.user_new_password|myxml}</user_new_password>
	<user_new_password_token>{$Object.user_new_password_token|myxml}</user_new_password_token>
	<user_is_temp>{$Object.user_is_temp|myxml}</user_is_temp>
	<user_email>{$Object.user_email|myxml}</user_email>
	<user_language_id>{$Object.user_language_id|myxml}</user_language_id>
	<user_currency_id>{$Object.user_currency_id|myxml}</user_currency_id>
	<user_bonus_point>{$Object.user_bonus_point|myxml}</user_bonus_point>
	<currency_site_rate>{$Object.currency_site_rate}</currency_site_rate>
	<currency_paypal>{$Object.currency_paypal}</currency_paypal>
	<currency_paydollar_currCode>{$Object.currency_paydollar_currCode}</currency_paydollar_currCode>
	<currency_shortname>{$Object.currency_shortname}</currency_shortname>
	<currency_longname>{$Object.currency_longname}</currency_longname>
	<currency_precision>{$Object.currency_precision}</currency_precision>
	<user_first_name>{$Object.user_first_name|myxml}</user_first_name>
	<user_last_name>{$Object.user_last_name|myxml}</user_last_name>
	<user_title>{$Object.user_title|myxml}</user_title>
	<user_company_name>{$Object.user_company_name|myxml}</user_company_name>
	<user_city_name>{$Object.user_city_name|myxml}</user_city_name>
	<user_region>{$Object.user_region|myxml}</user_region>
	<user_postcode>{$Object.user_postcode|myxml}</user_postcode>
	<user_address_1>{$Object.user_address_1|myxml}</user_address_1>
	<user_address_2>{$Object.user_address_2|myxml}</user_address_2>
	<user_country_id>{$Object.user_country_id}</user_country_id>
	<user_hk_district_id>{$Object.user_hk_district_id}</user_hk_district_id>
	<user_tel_country_code>{$Object.user_tel_country_code|myxml}</user_tel_country_code>
	<user_tel_area_code>{$Object.user_tel_area_code|myxml}</user_tel_area_code>
	<user_tel_no>{$Object.user_tel_no|myxml}</user_tel_no>
	<user_fax_country_code>{$Object.user_fax_country_code|myxml}</user_fax_country_code>
	<user_fax_area_code>{$Object.user_fax_area_code|myxml}</user_fax_area_code>
	<user_fax_no>{$Object.user_fax_no|myxml}</user_fax_no>
	<user_how_to_know_this_website>{$Object.user_how_to_know_this_website|myxml}</user_how_to_know_this_website>
	<user_balance>{$Object.user_balance|myxml}</user_balance>
	<user_join_mailinglist>{$Object.user_join_mailinglist}</user_join_mailinglist>
	<user_is_email_verify>{$Object.user_is_email_verify}</user_is_email_verify>
	<user_email_verify_token>{$Object.user_email_verify_token}</user_email_verify_token>
	<country_id>{$Object.country_id}</country_id>
	<country_code>{$Object.country_code|myxml}</country_code>
	<country_name_tc>{$Object.country_name_tc|myxml}</country_name_tc>
	<country_name_sc>{$Object.country_name_sc|myxml}</country_name_sc>
	<country_name_en>{$Object.country_name_en|myxml}</country_name_en>
	<country_name_jp>{$Object.country_name_jp|myxml}</country_name_jp>
	<country_name_kr>{$Object.country_name_kr|myxml}</country_name_kr>
	{assign var='object_type' value='user'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $UserCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $UserCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $UserCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $UserCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}	
	<datafile_page_no>{$DatafilePageNo}</datafile_page_no>
	<total_no_of_datafile>{$TotalNoOfDatafile}</total_no_of_datafile>
	<datafile_list>{$DatafileListXML}</datafile_list>
</user>