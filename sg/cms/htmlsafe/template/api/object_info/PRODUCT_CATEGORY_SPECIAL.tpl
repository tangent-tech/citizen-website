<product_category>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<product_category_id>{$Object.product_category_id}</product_category_id>
	<product_category_name>{$Object.product_category_special_name|myxml}</product_category_name>
	<product_category_special_name>{$Object.product_category_special_name|myxml}</product_category_special_name>
	<product_category_special_no>{$Object.product_category_special_no|myxml}</product_category_special_no>
	<total_no_of_products>{$NoOfProducts}</total_no_of_products>
	<page_no>{$PageNo}</page_no>
	<products_per_page>{$ProductsPerPage}</products_per_page>
	<products>{$ProductsXML}</products>
	<total_no_of_objects>{$NoOfObjects}</total_no_of_objects>	
	<objects>{$ObjectsXML}</objects>
	<media_page_no>{$MediaPageNo}</media_page_no>
	<total_no_of_media>{$TotalNoOfMedia}</total_no_of_media>
	<media_list>{$MediaListXML}</media_list>
	{assign var='object_type' value='product_category'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{assign var='myfieldsp' value="`$object_type`_special_custom_text_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfieldsp}>{$Object.$myfieldsp|myxml}</{$myfieldsp}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{assign var='myfieldsp' value="`$object_type`_special_custom_int_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfieldsp}>{$Object.$myfieldsp|myxml}</{$myfieldsp}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{assign var='myfieldsp' value="`$object_type`_special_custom_double_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfieldsp}>{$Object.$myfieldsp|myxml}</{$myfieldsp}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{assign var='myfieldsp' value="`$object_type`_special_custom_date_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfieldsp}>{$Object.$myfieldsp|myxml}</{$myfieldsp}>{/if}
	{/section}	
</product_category>