<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delivery Note - {$TITLE}</title>
<link rel="stylesheet" type="text/css" href="../css/{$CurrentLang.language_id}/invoice.css" />
</head>
<body>
	<div id="Container">
		<div id="InvoiceHeaderInfo">
			<table>
				<tr>
					<td width="136mm">
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
			    				<th>Delivery No:</th>
			    				<td>&nbsp; DN{"%07d"|sprintf:$StockTransaction.stock_transaction_id}</td>
			    			</tr>
			    			<tr>
			    				<th>Invoice No:</th>
			    				<td>&nbsp; INV{"%07d"|sprintf:$StockTransaction.order_no}</td>
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
		    			{if $Site.site_dn_show_product_code == 'Y'}<th>Product Code</th>{/if}
		    			<th>Quantity</th>
		    		</tr>
			    	{foreach from=$StockTransactionProducts item=P}
				    	<tr>
				    		<td>
								{if $P.object_thumbnail_file_id != 0 && $Site.site_dn_show_product_image == 'Y'}
{*									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$P.object_thumbnail_file_id}" /> *}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$P.object_thumbnail_tmp_filename}" />
									<br />
								{/if}
								{if $P.product_name != ''}
									{$P.product_name}
								{else}
									{$P.object_name}
								{/if}
								{if $P.product_option_id != 0}
									(
									{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
										{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
										{$P.$myfield} 
									{/section}
									)
								{/if}
				            </td>
				            {if $Site.site_dn_show_product_code == 'Y'}<td>{$P.product_code}</td>{/if}
				    		<td>&nbsp; {$P.product_quantity|abs}</td>
				    	</tr>
			    	{/foreach}
				</tbody>
	    	</table>
		</div>
		<div id="TNC">{$Site.site_dn_tnc}</div>
	</div>
</body>
</html>
