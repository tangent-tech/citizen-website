<product_category>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<product_category_id>{$Object.object_id}</product_category_id>
	<product_category_name>{$Object.object_name|myxml}</product_category_name>
	<total_no_of_products>{$NoOfProducts}</total_no_of_products>
	<page_no>{$PageNo}</page_no>
	<products_per_page>{$ProductsPerPage}</products_per_page>
	<products>{$ProductsXML}</products>
	<product_categories>{$ProductCategoriesXML}</product_categories>
	<total_no_of_objects>{$NoOfObjects}</total_no_of_objects>
	<objects>{$ObjectsXML}</objects>
	<product_root_id>{$Object.object_id}</product_root_id>
</product_category>