{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_product|ucwords}列表 &nbsp;
	{if $ProductFieldsShow.product_special_category != 'N'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_tree_special.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>特別分類
		</a>
	{/if}
	{if $ProductFieldsShow.product_brand_id != 'N'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>品牌列表
		</a>
	{/if}
</h1>
<p>
	<strong>顯示模式:</strong>
	<a href="product_tree.php?view=product_category_tree" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_category_tree'} ui-state-active{/if}">結構樹</a> | 
	<a href="product_tree.php?view=product_tree_full" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_tree_full'} ui-state-active{/if}">結構樹連{$Site.site_label_product|ucwords}</a> | 
	<a href="product_tree.php?view=product_list" class="ProductTreeViewSelector{if $smarty.cookies.product_view == 'product_list'} ui-state-active{/if}">列表</a>
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
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
		&nbsp; &nbsp; &nbsp;
		每頁顯示:
		<select id="num_of_products_per_page" name="num_of_products_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_products_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_products_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_products_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_products_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_products_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_products_per_page == 9999}selected="selected"{/if}>所有</option>
		</select>
		<input type="hidden" name="parent_object_id" value="{$smarty.request.parent_object_id}" />
		<input type="hidden" name="product_id" value="{$smarty.request.product_id}" />
		<input type="hidden" name="product_code" value="{$smarty.request.product_code}" />
		<input type="hidden" name="product_ref_name" value="{$smarty.request.product_ref_name}" />
	</form>
	<br />
	<a href="product_add.php?link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增{$Site.site_label_product|ucwords}</a>
	<a href="?" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> 重設篩選
	</a>	
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> 顯示/隱藏縮略圖
	</a>
	<table class="TopHeaderTable">
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td></td>
				<td>
					<select id="parent_object_id" name="parent_object_id">
						<option value="0" {if $smarty.request.parent_object_id == 0}selected="selected"{/if}>Any</option>
						{foreach from=$ProductRoots item=PC}
							<option {if $smarty.request.parent_object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
						{/foreach}
						{foreach from=$ProductCatList item=PC}
							<option {if $smarty.request.parent_object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
						{/foreach}
					</select>
				</td>
				<td><input type="text" name="product_id" size="5" value="{$smarty.request.product_id}" /></td>
				<td><input type="text" name="product_code" size="5" value="{$smarty.request.product_code}" /></td>
				<td><input type="text" name="product_ref_name" value="{$smarty.request.product_ref_name}" /></td>
				<td>
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> 篩選
					</a>
				</td>
			</tr>
		</form>	
		<tr class="ui-state-highlight">
			<th></th>
			<th>{$Site.site_label_product|ucwords}分類</th>
			<th>系統編號</th>
			<th>{$Site.site_label_product|ucwords}編號</th>
			<th>{$Site.site_label_product|ucwords}</th>
			<th>價錢1</th>
			<th>排序</th>
			<th>操作</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmUpdateProductOrder" id="FrmUpdateProductOrder" method="post" action="product_list_act.php">
			{foreach from=$Products item=P}
				<tr class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
					<td class="AlignCenter">
						{if $P.object_thumbnail_file_id != 0}
							<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
						{/if}
					</td>
					<td class="AlignCenter">{$P.parent_object_ref_name}</td>
					<td class="AlignCenter">{$P.product_id}</td>
					<td class="AlignCenter">{$P.product_code}</td>
					<td>{$P.object_name}</td>
					<td>{$P.product_price}</td>
					<td><input class="AlignCenter" style="width: 50px" type="text" name="object_global_order_id[{$P.object_id}]" value="{$P.object_global_order_id}" /></td>
					<td class="AlignCenter">
						<a href="product_edit.php?link_id={$P.object_link_id}" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-pencil"></span> 編輯
						</a>
					</td>
				</tr>
			{/foreach}
			<tr>
				<td colspan="8">
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton FloatRight" target="FrmUpdateProductOrder">
						<span class="ui-icon ui-icon-circle-plus"></span> 更新
					</a>

					<input type="submit" value="Update" class="Hidden" />
				
				</td>
			</tr>			
		</form>
	</table>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
