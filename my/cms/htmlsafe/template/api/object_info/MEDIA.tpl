<media>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<media_id>{$Object.media_id}</media_id>
	<media_type>{$Object.media_type}</media_type>
	<media_desc>{$Object.media_desc|myxml}</media_desc>
	<media_filename>{$Object.filename|myxml}</media_filename>
	<media_small_file_id>{$Object.media_small_file_id}</media_small_file_id>
	<media_big_file_id>{$Object.media_big_file_id}</media_big_file_id>
	{assign var='object_type' value='media'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $MediaCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $MediaCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $MediaCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $MediaCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
</media>