{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">Product Stock Transaction Details</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">
		{$Product.object_name}
		{if $Product.product_option_data_text != ''}
			({$Product.product_option_data_text})
		{/if} (id: {$Product.product_id})
	</h2>
	<div class="InnerContent ui-widget-content">
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th>Transaction ID</th>
				<th>Type</th>
				<th>Transaction Date</th>
				<th>Quantity</th>
				<th>Details</th>
			</tr>
			{foreach from=$ProductStockTransactionList item=S}
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
					<td>{$S.product_quantity}</td>
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
			<tr class="ui-state-highlight">
				<th colspan="3" class="AlignRight">Stock Level:</th>
				<td colspan="2">
					{if $Product.product_option_stock_level == null}
						{if $Product.product_stock_level < $Site.site_product_stock_threshold_quantity}
							<span class="Alert">{$Product.product_stock_level}</span>
						{else}
							{$Product.product_stock_level}
						{/if}
					{else}
						{if $Product.product_option_stock_level < $Site.site_product_stock_threshold_quantity}
							<span class="Alert">{$Product.product_option_stock_level}</span>
						{else}
							{$Product.product_option_stock_level}
						{/if}
					{/if}				
				</td>
			</tr>
		</table>
	</div>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
