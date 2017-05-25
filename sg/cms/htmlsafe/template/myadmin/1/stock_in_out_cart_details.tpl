{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Stock In/Out Basket</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="stock_in_out_cart_details_update_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
				<tr>
					<th>Type</th>
					<td>
						<select name="stock_in_out_type">
							<option value="STOCK_IN" {if $StockInOutCart.stock_in_out_type == 'STOCK_IN'}selected="selected"{/if}>Stock In</option>
							<option value="ADJUSTMENT" {if $StockInOutCart.stock_in_out_type == 'ADJUSTMENT'}selected="selected"{/if}>Adjustment</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Date</th>
					<td><input type="text" name="stock_in_out_date" class="DatePicker" value="{$StockInOutCart.stock_in_out_date|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time use_24_hours=true display_seconds=false time=$StockInOutCart.stock_in_out_date}</td>
				</tr>
				<tr>
					<th>Vendor</th>
					<td><input type="text" size="62" name="stock_in_out_vendor_name" value="{$StockInOutCart.stock_in_out_vendor_name}" /></td>
				</tr>
				<tr>
					<th>Note Subject</th>
					<td><input type="text" size="62" name="stock_in_out_subject" value="{$StockInOutCart.stock_in_out_subject}" /></td>
				</tr>
				<tr>
					<th>Note Content</th>
					<td><textarea name="stock_in_out_note" cols="60" rows="5">{$StockInOutCart.stock_in_out_note}</textarea></td>
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
				{foreach from=$StockInOutCartProducts item=P}
					<tr class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
						<td class="AlignCenter">{$P.product_id}</td>
						<td class="AlignCenter">{$P.product_code}</td>
						<td>
							{$P.object_name}
							{if $P.product_option_id != 0}
								(
								{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
									{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
									{$P.$myfield} 
								{/section}
								)
							{/if}			
						</td>
						<td class="AlignCenter">
							<input class="AlignRight" size="3" type="text" name="product_quantity-{$P.product_id}-{$P.product_option_id}" value="{$P.product_quantity|intval}" />
							<a href="stock_in_out_cart_add_act.php?product_id={$P.product_id}&product_option_id={$P.product_option_id}&product_quantity=0" class="ui-state-default ui-corner-all MyButton MyRemoveButton">
								<span class="ui-icon ui-icon-circle-minus"></span> del
							</a>
						</td>				
					</tr>
				{/foreach}
			</table>
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Update Basket
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
			<a href="stock_in_out_cart_confirm_act.php" class="ui-state-default ui-corner-all MyButton BtnConfirmStockInOut" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Confirm Stock In/Out
			</a>
		</div>
		<input type="hidden" name="is_confirm_stock_in_out" value="N" />
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
