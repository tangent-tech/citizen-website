<folder>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<folder_id>{$Object.object_id}</folder_id>
	<object_link_id>{$Object.object_link_id}</object_link_id>
	<folder_link_url>{$Object.folder_link_url|myxml}</folder_link_url>
	{assign var='object_type' value='folder'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $FolderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $FolderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $FolderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $FolderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	<objects>{$ObjectsXML}</objects>
	{section name=foo start=0 loop=9 step=1}
		{assign var='folder_field' value="folder_custom_rgb_`$smarty.section.foo.iteration`"}
		{assign var='myfield' value="object_custom_rgb_`$smarty.section.foo.iteration`"}
		{if $FolderCustomFieldsDef.$folder_field != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
</folder>