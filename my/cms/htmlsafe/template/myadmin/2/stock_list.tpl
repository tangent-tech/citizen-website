{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">
	庫存列表
	<a href="?" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> 重設篩選
	</a>
	<a href="?product_stock_level_min=&product_stock_level_max={$Site.site_product_stock_threshold_quantity}" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-alert"></span> 缺貨列表
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
		<input type="hidden" name="parent_object_id" value="{$smarty.request.parent_object_id}" />
		<input type="hidden" name="product_id" value="{$smarty.request.product_id}" />
		<input type="hidden" name="product_code" value="{$smarty.request.product_code}" />
		<input type="hidden" name="product_ref_name" value="{$smarty.request.product_ref_name}" />
		<input type="hidden" name="product_stock_level_min" value="{$smarty.request.product_stock_level_min}" />
		<input type="hidden" name="product_stock_level_max" value="{$smarty.request.product_stock_level_max}" />
	</form>
	<br />
	<table class="TopHeaderTable">
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td></td>
				<td>
					<select id="parent_object_id" name="parent_object_id">
						<option value="0" {if $smarty.request.parent_object_id == 0}selected="selected"{/if}>所有</option>
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
					<input type="text" name="product_stock_level_min" size="2" value="{$smarty.request.product_stock_level_min}" />
					-
					<input type="text" name="product_stock_level_max" size="2" value="{$smarty.request.product_stock_level_max}" />				
				</td>
				{*
				<td>
					<select id="product_stock_level" name="product_stock_level">
						<option value="999999" {if $smarty.request.product_stock_level == 999999}selected="selected"{/if}>Any</option>
						<option value="0" {if $smarty.request.product_stock_level == 0}selected="selected"{/if}>&lt;0</option>
					</select>
				</td>
				*}
				<td colspan="2">
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> 篩選
					</a>
				</td>
			</tr>
		</form>
		<tr class="ui-state-highlight">
			<th></th>
			<th>分類</th>
			<th>系統編號</th>
			<th>產品編號</th>
			<th>產品</th>
			<th>庫存</th>
			<th>貨物進出</th>
			<th>貨物出入籃</th>
		</tr>
		{foreach from=$Products item=P}
			<tr class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter"><img width="40" src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /></td>
				<td class="AlignCenter">{$P.parent_object_ref_name}</td>
				<td class="AlignCenter">{$P.product_id}</td>
				<td class="AlignCenter">{$P.product_code}</td>
				<td>
					{$P.object_name} <br />
					{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
						{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
						{$P.$myfield} 
					{/section}
				</td>
				<td class="AlignCenter">
					{if $P.product_option_stock_level == null}
						{if $P.product_stock_level < $Site.site_product_stock_threshold_quantity}
							<span class="Alert">{$P.product_stock_level}</span>
						{else}
							{$P.product_stock_level}
						{/if}
					{else}
						{if $P.product_option_stock_level < $Site.site_product_stock_threshold_quantity}
							<span class="Alert">{$P.product_option_stock_level}</span>
						{else}
							{$P.product_option_stock_level}
						{/if}
					{/if}
				</td>
				<td class="AlignCenter">
					<a href="stock_product_transaction_list.php?link_id={$P.object_link_id}&poid={$P.product_option_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 詳情
					</a>
				</td>
				<td class="AlignCenter">
					<form enctype="multipart/form-data" method="post" action="stock_in_out_cart_add_act.php" class="FrmCartAdd" id="FrmCartAdd{$P.product_id}{$P.product_option_id}">
						<input class="AlignRight" size="3" type="text" name="product_quantity" value="{$P.product_quantity|intval}" />
						<input type="hidden" name="product_id" value="{$P.product_id}" />
						<input type="hidden" name="product_option_id" value="{$P.product_option_id}" />
						<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmCartAdd{$P.product_id}{$P.product_option_id}">
							<span class="ui-icon ui-icon-plusthick"></span> &nbsp;
						</a>
					</form>
				</td>				
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
