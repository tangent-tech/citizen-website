<product>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_PROTOTYPE.tpl"}
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_price`$smarty.section.foo.iteration`_range_min"}
		<{$myfield}>{$ProductCatPriceRange.$myfield|myxml}</{$myfield}>
	{/section}
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_price`$smarty.section.foo.iteration`_range_max"}
		<{$myfield}>{$ProductCatPriceRange.$myfield|myxml}</{$myfield}>
	{/section}
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_price`$smarty.section.foo.iteration`_ca_range_min"}
		<{$myfield}>{$ProductCatPriceRange.$myfield|myxml}</{$myfield}>
	{/section}
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_price`$smarty.section.foo.iteration`_ca_range_max"}
		<{$myfield}>{$ProductCatPriceRange.$myfield|myxml}</{$myfield}>
	{/section}

	{assign var='object_type' value='product_category'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	<product_group_fields>
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_group_field_name_`$smarty.section.foo.iteration`"}
		{if $Object.$myfield != ''}<product_group_field>{$Object.$myfield|substr:2|myxml}</product_group_field>{/if}
	{/section}	
	</product_group_fields>
	<product_category_group_json_cache>{$Object.product_category_group_json_cache|myxml}</product_category_group_json_cache>	
</product>