<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice - {$TITLE}</title>
<link rel="stylesheet" type="text/css" href="../css/{$CurrentLang.language_id}/invoice.css" />
</head>
<body>
	<div id="Container">
		<div id="InvoiceHeaderInfo">
			<table>
				<tr>
					<td width="139mm">
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
					</td>
					<td>
			    		<table id="InvoiceHeaderInfoRight">
			    			<tr>
			    				<th>Invoice No:</th>
			    				<td>&nbsp; INV{"%07d"|sprintf:$MyOrder.order_no}</td>
			    			</tr>
			    			<tr>
			    				<th>Date:</th>
			    				<td>&nbsp; {$MyOrder.create_date|date_format:"%Y-%m-%d"}</td>
			    			</tr>
			    		</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="ProductList">
	    	<table id="ProductListTable" repeat_header="1">
	    		<tbody>
		    		<tr>
		    			<th>Product</th>
		    			{if $Site.site_invoice_show_product_code == 'Y'}<th>Product Code</th>{/if}
		    			<th>Quantity</th>
		    			<th>Unit Price ({$MyOrder.currency_shortname})</th>
		    			<th>Line Total ({$MyOrder.currency_shortname})</th>
		    			{if $Site.site_invoice_show_bonus_point == 'Y'}<th>Bonus Point</th>{/if}
		    		</tr>
			    	{foreach from=$MyOrderItemList item=P}
				    	<tr>
				    		<td>
								{if $P.object_thumbnail_file_id != 0 && $Site.site_invoice_show_product_image == 'Y'}
{*									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /> *}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$P.object_thumbnail_tmp_filename}" />
									<br />
								{/if}
				            	{$P.product_name}
								{if $P.product_option_data_text != ''}
									({$P.product_option_data_text})
								{/if}
				            </td>
				            {if $Site.site_invoice_show_product_code == 'Y'}<td>{$P.product_code}</td>{/if}
				    		<td>&nbsp; {$P.quantity}</td>
				    		<td>
				    			{if $P.effective_discount_type == 1}
				    				<span class="strike">{$MyOrder.currency_symbol}{$P.product_price_ca|doubleval|number_format:2}</span> <br />
				    				{$MyOrder.currency_symbol}{$P.actual_unit_price_ca}
				    			{elseif $P.effective_discount_type == 2}
				    				<span class="strike">{$MyOrder.currency_symbol}{$P.product_price_ca|doubleval|number_format:2}</span>
				    			{elseif $P.effective_discount_type == 3}
				    				<span class="strike">{$MyOrder.currency_symbol}{$P.product_price_ca|doubleval|number_format:2}</span> <br />
				    				{$MyOrder.currency_symbol}{$P.actual_unit_price_ca|doubleval|number_format:2}
				    			{else}
				    				{$MyOrder.currency_symbol}{$P.actual_unit_price_ca|doubleval|number_format:2}
				    			{/if}
				    			{if $P.effective_discount_type == 1}
				    				<br />({$P.discount1_off_p}% Off)
				    			{elseif $P.effective_discount_type == 2}
				    				<br />({$MyOrder.currency_symbol}{$P.discount2_price} for {$P.discount2_amount})
				    			{elseif $P.effective_discount_type == 3}
				    				<br />(Buy {$P.discount3_buy_amount} Get {$P.discount3_free_amount} Free)
				    			{/if}				    		
				    		</td>
				    		<td>
				    			{if $P.actual_subtotal_price_ca != ''}
			    					{$MyOrder.currency_symbol}{$P.actual_subtotal_price_ca|doubleval|number_format:2}
			    				{/if}			    			
				    		</td>
				    		{if $Site.site_invoice_show_bonus_point == 'Y'}
					    		<td>
					    			{$P.product_bonus_point_amount}
					    		</td>
					    	{/if}
				    	</tr>	    	
			    	{/foreach}
					{if $MyOrderBonusPointItemList|@count > 0}
						{foreach from=$MyOrderBonusPointItemList item=B}
							<tr>
								<td>
									{if $B.object_thumbnail_file_id != 0 && $Site.site_invoice_show_product_image == 'Y'}
										<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$B.object_thumbnail_tmp_filename}" />
{*											<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$B.object_thumbnail_file_id}" /> *}
										<br />
									{/if}
									{$B.bonus_point_item_name}
								</td>
								{if $Site.site_invoice_show_product_code == 'Y'}
									<td>-</td>
								{/if}
								<td>{$B.quantity}</td>
								<td>
									
										{if $B.cash_ca > 0}
											-{$MyOrder.currency_symbol}{$B.cash_ca|doubleval|number_format:2}
										{else}
											-
										{/if}
									
								</td>
								<td>
									
										{if $B.subtotal_cash > 0}
											-{$MyOrder.currency_symbol}{$B.subtotal_cash_ca|doubleval|number_format:2}
										{else}
											-
										{/if}
									
								</td>
								{if $Site.site_invoice_show_bonus_point == 'Y'}
									<td>
										-{$B.subtotal_bonus_point_required}
									</td>
								{/if}
							</tr>
						{/foreach}
					{/if}
					{if $MyOrder.user_balance_used_ca > 0}
						<tr>
							<td>Account Balance Redeemed</td>
							{if $Site.site_invoice_show_product_code == 'Y'}<td>-</td>{/if}
							<td>-</td>
							<td>-</td>
							<td>-{$MyOrder.currency_symbol}{$MyOrder.user_balance_used_ca|doubleval|number_format:2}</td>
							{if $Site.site_invoice_show_bonus_point == 'Y'}<td>-</td>{/if}
						</tr>
					{/if}
			    	{if $MyOrder.freight_cost_ca > 0}
				    	<tr>
							<td>Freight Cost</td>
							{if $Site.site_invoice_show_product_code == 'Y'}<td>-</td>{/if}
							<td>-</td>
							<td>-</td>
							<td>{$MyOrder.currency_symbol}{$MyOrder.freight_cost_ca|doubleval|number_format:2}</td>
							{if $Site.site_invoice_show_bonus_point == 'Y'}<td>-</td>{/if}
						</tr>
			    	{/if}
			    	{if $MyOrder.discount_amount_ca > 0}
				    	<tr>
							<td>Special Discount</td>
							{if $Site.site_invoice_show_product_code == 'Y'}<td>-</td>{/if}
							<td>-</td>
							<td>-</td>
							<td>-{$MyOrder.currency_symbol}{$MyOrder.discount_amount_ca|doubleval|number_format:2}</td>
							{if $Site.site_invoice_show_bonus_point == 'Y'}<td>-</td>{/if}
				    	</tr>
			    	{/if}
			    	{if $MyOrder.bonus_point_previous > 0 && $Site.site_invoice_show_bonus_point == 'Y'}
				    	<tr>
							<td>Previous Bonus Point Balance</td>
							{if $Site.site_invoice_show_product_code == 'Y'}<td>-</td>{/if}
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>{$MyOrder.bonus_point_previous}</td>
				    	</tr>
			    	{/if}
			    	<tr>
			    		{if $Site.site_invoice_show_product_code == 'Y'}
		    				<th colspan="3" style="border: none"></th>
		    			{else}
		    				<th colspan="2" style="border: none"></th>
		    			{/if}
						<th>TOTAL:</th>
		    			<th>{$MyOrder.currency_symbol}{$MyOrder.pay_amount_ca|doubleval|number_format:2}</th>
						{if $Site.site_invoice_show_bonus_point == 'Y'}<th>{$MyOrder.bonus_point_balance}</th>{/if}
					</tr>
				</tbody>
	    	</table>
		</div>
		<div id="TNC">{$Site.site_invoice_tnc}</div>
	</div>
</body>
</html>
