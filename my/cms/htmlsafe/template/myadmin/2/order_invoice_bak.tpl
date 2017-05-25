<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice - {$TITLE}</title>
<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/{$CurrentLang.language_id}/invoice.css" />
</head>
<body>
	<div id="Container">
		<div id="Logo">
			{if $Site.site_admin_logo_url != ''}
				<img src="{$Site.site_admin_logo_url}" />
			{else}
				<img src="../images/aveego_logo.png" />
			{/if}
		</div>
		<div id="InvoiceHeaderInfo">
			<h1>INVOICE</h1>
			<table>
				<tr>
					<td width="780px">
						<p>
							<strong>Invoice Address:</strong> <br />
							{$MyOrder.invoice_first_name} {$MyOrder.invoice_last_name} <br />
							{$MyOrder.invoice_shipping_address_1} <br />
							{if $MyOrder.invoice_shipping_address_2 != ''}{$MyOrder.invoice_shipping_address_2}  <br />{/if}
							{if $MyOrder.invoice_city_name != ''}{$MyOrder.invoice_city_name}, {/if}{if $MyOrder.invoice_region != ''}{$MyOrder.invoice_region}, {/if}{if $MyOrder.invoice_postcode != ''}{$MyOrder.invoice_postcode}, {/if}{$InvoiceCountry.country_name_en} <br />
							Phone: {if $MyOrder.invoice_tel_country_code != ''}{$MyOrder.invoice_tel_country_code} - {/if}{if $MyOrder.invoice_tel_area_code != ''}{$MyOrder.invoice_tel_area_code} - {/if}{$MyOrder.invoice_phone_no} <br />
							Email: {$MyOrder.invoice_email} <br />
							<br />
							<strong>Shipping Address:</strong> <br />
							{if $MyOrder.deliver_to_different_address == 'Y'}
				    			{$MyOrder.delivery_first_name} {$MyOrder.delivery_last_name} <br />
				    			{$MyOrder.delivery_shipping_address_1} <br />
				    			{if $MyOrder.delivery_shipping_address_2 != ''}{$MyOrder.delivery_shipping_address_2}  <br />{/if}
								{if $MyOrder.delivery_city_name != ''}{$MyOrder.delivery_city_name}, {/if}{if $MyOrder.delivery_region != ''}{$MyOrder.delivery_region}, {/if}{if $MyOrder.delivery_postcode != ''}{$MyOrder.delivery_postcode}, {/if}{$DeliveryCountry->country_name_en} <br />
				    			Phone: {if $MyOrder.delivery_tel_country_code != ''}{$MyOrder.delivery_tel_country_code} - {/if}{if $MyOrder.delivery_tel_area_code != ''}{$MyOrder.delivery_tel_area_code} - {/if}{$MyOrder.delivery_phone_no}<br /><br />				
							{else}
								Same as above. <br />
							{/if}
						</p>
					</td>
					<td width="180px">
			    		<table id="InvoiceHeaderInfoRight">
			    			<tr>
			    				<th width="90px"><p>Invoice No:</p></th>
			    				<td><p>&nbsp; INV{"%07d"|sprintf:$MyOrder.order_no}</p></td>
			    			</tr>
			    			<tr>
			    				<th width="90px"><p>Date:</p></th>
			    				<td><p>&nbsp; {$MyOrder.create_date|date_format:"%Y-%m-%d"}</p></td>
			    			</tr>
			    		</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="ProductList">
	    	<table id="ProductListTable" repeat_header="1">
	    		<tr>
	    			<th width="300px"><p>Product</p></th>
	    			<th><p>Product Code</p></th>
	    			<th><p>Quantity</p></th>
	    			<th><p>Unit Price</p></th>
	    			<th><p>Line Total</p></th>
	    			<th width="75px"><p>Bonus Point</p></th>
	    		</tr>
		    	{foreach from=$MyOrderItemList item=P}
			    	<tr>
			    		<td>
			    			<p>
								{if $P.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" />
									<br />
								{/if}
				            	{$P.product_name}
								{if $P.product_option_data_text != ''}
									({$P.product_option_data_text})
								{/if}
			    			</p>
			            </td>
			            <td><p>{$P.product_code}</p></td>
			    		<td><p>&nbsp; {$P.quantity}</p></td>
			    		<td>
			    			<p>
				    			{if $P.effective_discount_type == 1}
				    				<span class="strike">{$MyOrder.currency_shortname} {$P.product_price_ca|doubleval|number_format:2}</span> <br />
				    				{$MyOrder.currency_shortname} {$P.actual_unit_price_ca}
				    			{elseif $P.effective_discount_type == 2}
				    				<span class="strike">{$MyOrder.currency_shortname} {$P.product_price_ca|doubleval|number_format:2}</span>
				    			{elseif $P.effective_discount_type == 3}
				    				<span class="strike">{$MyOrder.currency_shortname} {$P.product_price_ca|doubleval|number_format:2}</span> <br />
				    				{$MyOrder.currency_shortname} {$P.actual_unit_price_ca|doubleval|number_format:2}
				    			{else}
				    				{$MyOrder.currency_shortname} {$P.actual_unit_price_ca|doubleval|number_format:2}
				    			{/if}
				    			{if $P.effective_discount_type == 1}
				    				<br />({$P.discount1_off_p}% Off)
				    			{elseif $P.effective_discount_type == 2}
				    				<br />({$MyOrder.currency_shortname} {$P.discount2_price} for {$P.discount2_amount})
				    			{elseif $P.effective_discount_type == 3}
				    				<br />(Buy {$P.discount3_buy_amount} Get {$P.discount3_free_amount} Free)
				    			{/if}
				    		</p>
			    		</td>
			    		<td>
			    			<p>
				    			{if $P.actual_subtotal_price_ca != ''}
			    					{$MyOrder.currency_shortname} {$P.actual_subtotal_price_ca|doubleval|number_format:2}
			    				{/if}
			    			</p>
			    		</td>
			    		<td>
			    			<p>
			    				{$P.product_bonus_point_amount}
			    			</p>
			    		</td>
			    	</tr>	    	
		    	{/foreach}
				{if $MyOrderBonusPointItemList|@count > 0}
					{foreach from=$MyOrderBonusPointItemList item=B}
						<tr>
							<td>
								<p>
									{if $B.object_thumbnail_file_id != 0}
										<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$B.object_thumbnail_file_id}" />
										<br />
									{/if}
									{$B.bonus_point_item_name}
								</p>
							</td>
							<td><p>-</p></td>
							<td><p>{$B.quantity}</p></td>
							<td>
								<p>
									{if $B.cash_ca > 0}
										-{$MyOrder.currency_shortname} {$B.cash_ca|doubleval|number_format:2}
									{else}
										-
									{/if}
								</p>
							</td>
							<td>
								<p>
									{if $B.subtotal_cash > 0}
										-{$MyOrder.currency_shortname} {$B.subtotal_cash_ca|doubleval|number_format:2}
									{else}
										-
									{/if}
								</p>
							</td>
							<td>
								<p>-{$B.subtotal_bonus_point_required}</p>
							</td>
						</tr>
					{/foreach}
				{/if}
				{if $MyOrder.user_balance_used_ca > 0}
					<tr>
						<td><p>Account Balance Redeemed</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-{$MyOrder.currency_shortname} {$MyOrder.user_balance_used_ca|doubleval|number_format:2}</p></td>
						<td><p>-</p></td>
					</tr>
				{/if}
		    	{if $MyOrder.freight_cost_ca > 0}
			    	<tr>
						<td><p>Freight Cost</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>{$MyOrder.currency_shortname} {$MyOrder.freight_cost_ca|doubleval|number_format:2}</p></td>
						<td><p>-</p></td>
					</tr>
		    	{/if}
		    	{if $MyOrder.discount_amount_ca > 0}
			    	<tr>
						<td><p>Special Discount</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-{$MyOrder.currency_shortname} {$MyOrder.discount_amount_ca|doubleval|number_format:2}</p></td>
						<td><p>-</p></td>
			    	</tr>
		    	{/if}
		    	{if $MyOrder.bonus_point_previous > 0}
			    	<tr>
						<td><p>Previous Bonus Point Balance</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>-</p></td>
						<td><p>{$MyOrder.bonus_point_previous}</p></td>
			    	</tr>
		    	{/if}
		    	<tr>
	    			<th colspan="3" class="NoBorder"></th>
	    			<th><p>TOTAL:</p></th>
	    			<th><p>{$MyOrder.currency_shortname} {$MyOrder.pay_amount_ca|doubleval|number_format:2}</p></th>
	    			<th><p>{$MyOrder.bonus_point_balance}</p></th>
		    	</tr>
	    	</table>
		</div>
	</div>
</body>
