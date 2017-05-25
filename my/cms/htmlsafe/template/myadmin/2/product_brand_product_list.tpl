{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">品牌產品列表 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 品牌列表
	</a>
</h1>
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
		每頁顯示
		<select id="num_of_products_per_page" name="num_of_products_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_products_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_products_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_products_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_products_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_products_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_products_per_page == 9999}selected="selected"{/if}>所有</option>
		</select>
	</form>
	<br />
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> 顯示/隱藏縮略圖
	</a>
	<table id="ProductBrandProductListTable" data-num_of_products_per_page="{$smarty.cookies.num_of_products_per_page}" data-page_id="{$smarty.request.page_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th></th>
			<th>{$Site.site_label_product|ucwords}分類</th>
			<th>{$Site.site_label_product|ucwords}系統編號</th>
			<th>{$Site.site_label_product|ucwords}編號</th>
			<th>{$Site.site_label_product|ucwords}</th>
			<th>操作</th>
		</tr>
		{foreach from=$Products item=P}
			<tr id="Product-{$P.product_brand_object_link_id}" class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">
					{if $P.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
				</td>
				<td class="AlignCenter">{$P.parent_object_ref_name}</td>
				<td class="AlignCenter">{$P.product_id}</td>
				<td class="AlignCenter">{$P.product_code}</td>
				<td>{$P.object_name}</td>
				<td class="AlignCenter">
					<a href="product_edit.php?link_id={$P.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
				</td>
			</tr>
		{foreachelse}
			<tr class="nodrop nodrag">
				<td colspan="6" class="AlignCenter">未有{$Site.site_label_product|ucwords}</td>
			</tr>
		{/foreach}
	</table>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
