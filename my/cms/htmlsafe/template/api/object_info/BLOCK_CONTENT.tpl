<block>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<block_content_id>{$Object.block_definition_id}</block_content_id>
	<block_content>{$Object.block_content|myxml}</block_content>
	<block_link_url>{$Object.block_link_url|myxml}</block_link_url>
	<block_image_id>{$Object.block_image_id}</block_image_id>
	<block_file_id>{$Object.block_file_id}</block_file_id>
</block>