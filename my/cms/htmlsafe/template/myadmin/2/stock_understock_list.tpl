{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">缺貨列表</h1>
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
	</form>
	<br />
	<table class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>系統編號</th>
			<th>產品編號</th>
			<th>產品</th>
			<th>庫存</th>
			<th>貨品出入詳情</th>
			<th>貨物出入籃</th>
		</tr>
		{foreach from=$Products item=P}
			<tr class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$P.product_id}</td>
				<td class="AlignCenter">{$P.product_code}</td>
				<td>
					{$P.object_name}
					{if $P.product_option_data_text != ''}
						({$P.product_option_data_text})
					{/if}
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
							<span class="ui-icon ui-icon-plusthick"></span> 新增
						</a>
					</form>
				</td>				
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
