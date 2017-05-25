<block_def>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<block_def_id>{$Object.block_definition_id}</block_def_id>
	<block_def_type>{$Object.block_definition_type}</block_def_type>
	<block_def_name>{$Object.object_name|myxml}</block_def_name>
	<block_def_desc>{$Object.block_definition_desc|myxml}</block_def_desc>
	<block_contents>{$BlockContentsXML}</block_contents>
</block_def>