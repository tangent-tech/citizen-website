<album>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<album_id>{$Object.album_id}</album_id>
	<album_desc>{$Object.album_desc|myxml}</album_desc>
	<page_no>{$MediaPageNo}</page_no>
	<total_no_of_media>{$TotalNoOfMedia}</total_no_of_media>
	<media_list>{$MediaListXML}</media_list>
	{assign var='object_type' value='album'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $AlbumCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $AlbumCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $AlbumCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $AlbumCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfielddef' value="`$object_type`_custom_file_`$smarty.section.foo.iteration`"}
		{assign var='myfield' value="`$object_type`_custom_file_id_`$smarty.section.foo.iteration`"}
		{if $AlbumCustomFieldsDef.$myfielddef != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
</album>