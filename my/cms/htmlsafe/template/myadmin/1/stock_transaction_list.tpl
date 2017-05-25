{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">Stock Transaction List</h1>
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
	</form>
	<br />
	<table class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>Transaction ID</th>
			<th>Type</th>
			<th>Transaction Date</th>
			<th>Details</th>
		</tr>
		{foreach from=$StockTransactionList item=S}
			<tr>
				<td class="AlignCenter">{$S.stock_transaction_id}</td>
				<td class="AlignCenter">
					{if		$S.stock_transaction_type == 'STOCK_IN'}
						Stock In ({$S.stock_in_out_vendor_name} - {$S.stock_in_out_subject})
					{elseif	$S.stock_transaction_type == 'SHIPMENT'}
						Shipment (Order: {$S.order_no})
					{elseif	$S.stock_transaction_type == 'ADJUSTMENT'}
						Adjustment
					{elseif	$S.stock_transaction_type == 'STOCK_HOLD'}
						Stock Hold (Order: {$S.order_no})
					{/if}
				</td>
				<td>{$S.stock_transaction_date}</td>
				<td class="AlignCenter">
					{if		$S.stock_transaction_type == 'STOCK_IN'}
						<a href="stock_in_out_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
					{elseif	$S.stock_transaction_type == 'SHIPMENT'}
						<a href="stock_shipment_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
					{elseif	$S.stock_transaction_type == 'ADJUSTMENT'}
						<a href="stock_in_out_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
					{elseif	$S.stock_transaction_type == 'STOCK_HOLD'}
						<a href="stock_hold_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
					{/if}
							<span class="ui-icon ui-icon-pencil"></span> Details
						</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
