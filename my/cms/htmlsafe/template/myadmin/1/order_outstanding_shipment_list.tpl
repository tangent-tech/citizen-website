{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">Outstanding Shipment List</h1>
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
			<th>Shipment ID</th>
			<th>Order ID</th>
			<th>Payment Confirm Date</th>
			<th>Details</th>
		</tr>
		{foreach from=$StockTransactionList item=S}
			<tr>
				<td class="AlignCenter">{$S.stock_transaction_id}</td>
				<td class="AlignCenter">
					{$S.order_no}
				</td>
				<td>{$S.stock_transaction_date}</td>
				<td class="AlignCenter">
					<a href="order_details.php?id={$S.myorder_id}#MyOrderTabsPanel-Shipment" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> Order Details
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
