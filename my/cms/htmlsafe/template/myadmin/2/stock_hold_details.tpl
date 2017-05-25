{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">貨物進出詳情 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="stock_transaction_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 貨物進出列表
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$StockTransaction.myorder_id}#MyOrderTabsPanel-Shipment">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 訂單
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">貨物進出 (編號: {$StockTransaction.stock_transaction_id})</h2>
	<div class="InnerContent ui-widget-content">
		<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
			<tr>
				<th> 訂單日期 </th>
				<td width="70%"> {$StockTransaction.create_date} </td>
			</tr>
			<tr>
				<th> 訂單編號 </th>
				<td> {$StockTransaction.order_no} </td>
			</tr>
			<tr>
				<th>訂單狀態</th>
				<td>
					{if $StockTransaction.order_status == 'awaiting_freight_quote'}
						ERROR 等待運費報價
					{elseif $StockTransaction.order_status == 'awaiting_order_confirmation'}
						ERROR 等待確認訂單
					{elseif $StockTransaction.order_status == 'order_cancelled'}
						ERROR 訂單已取消
					{elseif $StockTransaction.order_status == 'payment_pending'}
						未付款
					{elseif $StockTransaction.order_status == 'payment_confirmed'}
						已付款
					{elseif $StockTransaction.order_status == 'partial_shipped'}
						部分發貨
					{elseif $StockTransaction.order_status == 'shipped'}
						已發貨
					{/if}
				</td>
			</tr>
			<tr>
				<th> 支付金額 </th>
				<td>
					{$StockTransaction.currency_shortname|escape:'html'} {$StockTransaction.pay_amount_ca|number_format:$StockTransaction.currency_precision}
				</td>
			</tr>
			<tr>
				<th> 已付款? </th>
				<td> {if $StockTransaction.payment_confirmed == 'Y'}是{else}否{/if} </td>
			</tr>
			<tr>
				<th> 確認付款經手人 </th>
				<td> {$StockTransaction.payment_confirm_by|escape:'html'} </td>
			</tr>
			<tr>
				<th> 確認付款日期 </th>
				<td> {$StockTransaction.payment_confirm_date} </td>
			</tr>
			<tr>
				<th> 筆記 </th>
				<td>
					{$StockTransaction.user_reference|nl2br}
				</td>
			</tr>
		</table>
		<hr />
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th>系統編號</th>
				<th>產品編號</th>
				<th>產品</th>
				<th>數量</th>
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
