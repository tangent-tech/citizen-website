<news>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<news_root_id>{$Object.news_root_id}</news_root_id>
	<news_id>{$Object.news_id}</news_id>
	<news_title>{$Object.news_title|myxml}</news_title>
	<news_summary>{$Object.news_summary|myxml}</news_summary>
	<news_content>{$Object.news_content|myxml}</news_content>
	<news_date>{$Object.news_date}</news_date>
	<news_tag>{$Object.news_tag|mytag|myxml}</news_tag>
	<news_category_id>{$Object.news_category_id}</news_category_id>
	<news_category_name>{$Object.news_category_name|myxml}</news_category_name>
	<albums>{$AlbumXML}</albums>
</news>