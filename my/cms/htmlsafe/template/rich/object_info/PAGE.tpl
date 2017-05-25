<page>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<page_id>{$Object.object_id}</page_id>
	<page_title>{$Object.page_title|myxml}</page_title>
	<search_block_content>{$Object.block_content|myxml}</search_block_content>
	{$LayoutXML}
	{$AlbumXML}
</page>