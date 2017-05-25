{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">發貨列表</h1>
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
		Shop: 
		<select name="shop_id" onchange="submit()">
			<option value="all" {if $smarty.request.shop_id=='all'}selected="selected"{/if}>ALL</option>
			{foreach $ShopList as $S}
				<option value="{$S.shop_id}" {if $smarty.request.shop_id==$S.shop_id}selected="selected"{/if}>{$S.shop_name}</option>			
			{/foreach}
		</select>
	</form>
	<br />
	<table class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>發貨編號</th>
			<th>訂單編號</th>
			<th>送貨日期</th>
			<th>詳情</th>
		</tr>
		{foreach from=$StockTransactionList item=S}
			<tr>
				<td class="AlignCenter">{$S.stock_transaction_id}</td>
				<td class="AlignCenter">
					{$S.order_no}
				</td>
				<td>{$S.stock_transaction_date}</td>
				<td class="AlignCenter">
					<a href="stock_shipment_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-note"></span> 發貨詳情
					</a>
					<a href="order_details.php?id={$S.myorder_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-note"></span> 訂單詳情
					</a>
					{if $Site.site_dn_enable == 'Y'}
						<a href="stock_shipment_dn.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton" target="invoice_window">
							<span class="ui-icon ui-icon-print"></span> 發貨單
						</a>
					{/if}
				</td>
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
