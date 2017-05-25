{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_product|ucwords} Tree &nbsp;
	{if $ProductFieldsShow.product_special_category != 'N'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_tree_special.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Special Category
		</a>
	{/if}
	{if $ProductFieldsShow.product_brand_id != 'N'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Brand List
		</a>
	{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="product_category_import_thumbnail.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Update blank product category thumbnail
	</a>		
</h1>
<p>
	<strong>View:</strong>
	<a href="product_tree.php?view=product_category_tree" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_category_tree'} ui-state-active{/if}">Tree</a> | 
	<a href="product_tree.php?view=product_tree_full" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_tree_full'} ui-state-active{/if}">Tree with Products</a> | 
	<a href="product_tree.php?view=product_list" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_list'} ui-state-active{/if}">List</a>
</p>
{*
<form name="product_view_form" action="product_tree.php">
	<select name="view" onchange="product_view_form.submit()">
		<option value="product_category_tree" {if $smarty.cookies.product_view == 'product_category_tree'}selected="selected"{/if}>Tree View</option>
		<option value="product_tree_full" {if $smarty.cookies.product_view == 'product_tree_full'}selected="selected"{/if}>Tree View with {$Site.site_label_product|ucwords}</option>
		<option value="product_list" {if $smarty.cookies.product_view == 'product_list'}selected="selected"{/if}>List View</option>
	</select>
</form>
*}
<br />
<div class="InnerContainer ui-widget ui-corner-all">
	<div id="PRODUCT_TREE">
		<ul>
			<li rel="SITE_ROOT" id="OL_0" data-object_type="SITE_ROOT" data-object_link_id="0" data-object_id="{$Site.site_root_id}" data-object_system_flag="system"><a href="#"><ins>&nbsp;</ins></a>
				{$ProductTree}
			</li>
		</ul>
	</div>
	<br class="clearfloat" />
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
