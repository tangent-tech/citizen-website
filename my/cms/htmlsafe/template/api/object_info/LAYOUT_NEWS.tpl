<layout_news>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<layout_news_root_id>{$Object.layout_news_root_id}</layout_news_root_id>
	<layout_news_id>{$Object.layout_news_id}</layout_news_id>
	<layout_news_title>{$Object.layout_news_title|myxml}</layout_news_title>
	<layout_news_date>{$Object.layout_news_date}</layout_news_date>
	<layout_news_tag>{$Object.layout_news_tag|mytag|myxml}</layout_news_tag>
	<layout_news_category_id>{$Object.layout_news_category_id}</layout_news_category_id>
	<layout_news_category_name>{$Object.layout_news_category_name|myxml}</layout_news_category_name>
	{$LayoutXML}
	{$AlbumXML}
</layout_news>