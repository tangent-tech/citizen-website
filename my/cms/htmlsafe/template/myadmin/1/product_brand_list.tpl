{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Brand List &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords} Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
		&nbsp; &nbsp; &nbsp;
		Brands Per Page:
		<select id="num_of_product_brand_per_page" name="num_of_product_brand_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_product_brand_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_product_brand_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_product_brand_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_product_brand_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_product_brand_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_product_brand_per_page == 9999}selected="selected"{/if}>All</option>
		</select>
		<input type="hidden" name="product_brand_ref_name" value="{$smarty.request.product_brand_ref_name}" />
	</form>
	<br />
	<a href="product_brand_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Brand</a>
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
	<table id="ProductBrandListTable" data-num_of_product_brand_per_page="{$smarty.cookies.num_of_product_brand_per_page}" data-page_id="{$smarty.request.page_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th></th>
			<th>Brand Name</th>
			<th>Action</th>
		</tr>
		{foreach $ProductBrandList as $P}
			<tr id="ProductBrand-{$P.object_link_id}" class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">
					{if $P.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
				</td>
				<td>{$P.object_name}</td>
				<td class="AlignCenter">
					<a href="product_brand_edit.php?link_id={$P.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> Edit
					</a>
					<a href="product_brand_delete.php?link_id={$P.object_link_id}" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
					<a href="product_brand_product_list.php?link_id={$P.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> Product List
					</a>
				</td>
			</tr>
		{foreachelse}
			<tr class="nodrop nodrag">
				<td colspan="3" class="AlignCenter">No brand defined.</td>
			</tr>
		{/foreach}
	</table>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
