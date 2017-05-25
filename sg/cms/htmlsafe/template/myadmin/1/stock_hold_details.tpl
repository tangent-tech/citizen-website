{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">Stock Transaction Details &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="stock_transaction_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Transaction List
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$StockTransaction.myorder_id}#MyOrderTabsPanel-Shipment">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Order
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Stock Transaction (id: {$StockTransaction.stock_transaction_id})</h2>
	<div class="InnerContent ui-widget-content">
		<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
			<tr>
				<th> Order Date </th>
				<td width="70%"> {$StockTransaction.create_date} </td>
			</tr>
			<tr>
				<th> Order No </th>
				<td> {$StockTransaction.order_no} </td>
			</tr>
			<tr>
				<th>Order Status</th>
				<td>
					{if $StockTransaction.order_status == 'awaiting_freight_quote'}
						ERROR AWAITING FREIGHT QUOTE
					{elseif $StockTransaction.order_status == 'awaiting_order_confirmation'}
						ERROR AWAITING ORDER CONFIRMATION
					{elseif $StockTransaction.order_status == 'order_cancelled'}
						ERROR ORDER CANCELLED
					{elseif $StockTransaction.order_status == 'payment_pending'}
						Payment Pending
					{elseif $StockTransaction.order_status == 'payment_confirmed'}
						Payment Confirmed
					{elseif $StockTransaction.order_status == 'partial_shipped'}
						Partial Shipped
					{elseif $StockTransaction.order_status == 'shipped'}
						Shipped
					{/if}
				</td>
			</tr>
			<tr>
				<th> Pay Amount </th>
				<td>
					{$StockTransaction.currency_shortname|escape:'html'} {$StockTransaction.pay_amount_ca|number_format:$StockTransaction.currency_precision}
				</td>
			</tr>
			<tr>
				<th> Payment Confirmed? </th>
				<td> {if $StockTransaction.payment_confirmed == 'Y'}Yes{else}No{/if} </td>
			</tr>
			<tr>
				<th> Payment Confirmed By </th>
				<td> {$StockTransaction.payment_confirm_by|escape:'html'} </td>
			</tr>
			<tr>
				<th> Payment Confirm Date </th>
				<td> {$StockTransaction.payment_confirm_date} </td>
			</tr>
			<tr>
				<th> Note </th>
				<td>
					{$StockTransaction.user_reference|nl2br}
				</td>
			</tr>
		</table>
		<hr />
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th>Product ID</th>
				<th>Product Code</th>
				<th>Product</th>
				<th>Quantity</th>
			</tr>
			{foreach from=$StockTransactionProducts item=P}
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
						{$P.product_quantity|abs}
					</td>				
				</tr>
			{/foreach}
		</table>
	</div>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
