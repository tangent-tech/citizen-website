{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{* include file='myadmin/header_site_setting_general.tpl' *}
<h1 class="PageTitle">網站設定 &nbsp; </h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">網站資料</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_setting_general_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> 積分獎賞有效期天數 </th>
						<td> <input type="text" name="site_bonus_point_valid_days" value="{$Site.site_bonus_point_valid_days|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 網站默認語言 </th>
						<td>
							<select name="site_default_language_id">
								{foreach from=$SiteLanguage item=L}
									<option value="{$L.language_id}" {if $L.language_id == $Site.site_default_language_id}selected="selected"{/if}>{$L.language_native|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th> 網站默認貨幣 </th>
						<td>
							<select name="site_default_currency_id">
								{foreach from=$SiteCurrency item=C}
									<option value="{$C.currency_id}" {if $C.currency_id == $Site.site_default_currency_id}selected="selected"{/if}>{$C.currency_shortname|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					{if $Site.site_module_order_enable == 'Y'}
						<tr>
							<th width='50%'>計算價錢次序 <br /> <br /> (會影響最後價錢。一般而言，先處理平宜貨品會得出較高價錢，因為折扣會先應用在平宜貨品上。)</th>
							<td>
								<select name="site_product_price_process_order">
									<option value="ASC" {if $Site.site_product_price_process_order=='ASC'}selected="selected"{/if}>先處理平宜貨品</option>
									<option value="DESC" {if $Site.site_product_price_process_order=='DESC'}selected="selected"{/if}>先處理貴價貨品</option>
								</select>								
							</td>
						</tr>
					{/if}
					{foreach $SiteFreightList as $F}
						{if $Site.site_freight_cost_calculation_id == 1}
							<tr>
								<th> 運費計算 ({$F->currency_shortname})</th>
								<td>
									若一定附加運費，請填寫少於$-1 <br />
									<select name="site_freight_1_free_min_total_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_1_free_min_total_price_def==0}selected="selected"{/if}>扣除折扣後，但未扣除現金回贈的總價格 </option>
										<option value="1" {if $F->site_freight_1_free_min_total_price_def==1}selected="selected"{/if}>扣除折扣和現金回贈後的總價格 </option>
										<option value="2" {if $F->site_freight_1_free_min_total_price_def==2}selected="selected"{/if}>總價格 (以原價計算) </option>
									</select>
									少於 $<input size="4" type="text" name="site_freight_1_free_min_total_price[{$F->currency_id}]" value="{$F->site_freight_1_free_min_total_price|escape:'html'}" />, 收取 $<input  size="4" type="text" name="site_freight_1_cost[{$F->currency_id}]" value="{$F->site_freight_1_cost|escape:'html'}" />
								</td>
							</tr>
						{else if $Site.site_freight_cost_calculation_id == 2}
							<tr>
								<th> 運費計算 </th>
								<td>
									若一定附加運費，請填寫少於$-1 <br />

									<select name="site_freight_2_free_min_total_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_2_free_min_total_price_def==0}selected="selected"{/if}>扣除折扣後，但未扣除現金回贈的總價格 </option>
										<option value="1" {if $F->site_freight_2_free_min_total_price_def==1}selected="selected"{/if}>扣除折扣和現金回贈後的總價格</option>
										<option value="2" {if $F->site_freight_2_free_min_total_price_def==2}selected="selected"{/if}>總價格 (以原價計算) </option>
									</select>
									少於 $<input size="4" type="text" name="site_freight_2_free_min_total_price[{$F->currency_id}]" value="{$F->site_freight_2_free_min_total_price|escape:'html'}" />,
									收取
									<select name="site_freight_2_total_base_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_2_total_base_price_def==0}selected="selected"{/if}>扣除折扣後，但未扣除現金回贈的總價格 </option>
										<option value="1" {if $F->site_freight_2_total_base_price_def==1}selected="selected"{/if}>扣除折扣和現金回贈後的總價格 </option>
										<option value="2" {if $F->site_freight_2_total_base_price_def==2}selected="selected"{/if}>總價格 (以原價計算) </option>
									</select>之<input  size="4" type="text" name="site_freight_2_cost_percent[{$F->currency_id}]" value="{$F->site_freight_2_cost_percent|escape:'html'}" />%								
								</td>
							</tr>
						{/if}
					{/foreach}
					{if $Site.site_module_inventory_enable == 'Y'}
						<tr>
							<th> 庫存數量門檻 </th>
							<td> <input type="text" name="site_product_stock_threshold_quantity" value="{$Site.site_product_stock_threshold_quantity|escape:'html'}" /> </td>
						</tr>
					{/if}
					{if $Site.site_module_order_enable == 'Y' && $Site.site_invoice_enable == 'Y'}
						<tr>
							<th> 發票顯示產品圖片? </th>
							<td>
								<input type="radio" name="site_invoice_show_product_image" value="Y" {if $Site.site_invoice_show_product_image != 'N'}checked=checked{/if} /> 是
								<input type="radio" name="site_invoice_show_product_image" value="N" {if $Site.site_invoice_show_product_image == 'N'}checked=checked{/if} /> 否
							</td>
						</tr>
						<tr>
							<th> 發票顯示產品編號？ </th>
							<td>
								<input type="radio" name="site_invoice_show_product_code" value="Y" {if $Site.site_invoice_show_product_code != 'N'}checked=checked{/if} /> 是
								<input type="radio" name="site_invoice_show_product_code" value="N" {if $Site.site_invoice_show_product_code == 'N'}checked=checked{/if} /> 否
							</td>
						</tr>
						<tr>
							<th> 發票顯示積分獎賞？ </th>
							<td>
								<input type="radio" name="site_invoice_show_bonus_point" value="Y" {if $Site.site_invoice_show_bonus_point != 'N'}checked=checked{/if} /> 是
								<input type="radio" name="site_invoice_show_bonus_point" value="N" {if $Site.site_invoice_show_bonus_point == 'N'}checked=checked{/if} /> 否
							</td>
						</tr>
					{/if}
					{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
						{if $Site.site_dn_enable == 'Y'}
							<tr>
								<th> 送貨單顯示產品圖片？ </th>
								<td>
									<input type="radio" name="site_dn_show_product_image" value="Y" {if $Site.site_dn_show_product_image != 'N'}checked=checked{/if} /> 是
									<input type="radio" name="site_dn_show_product_image" value="N" {if $Site.site_dn_show_product_image == 'N'}checked=checked{/if} /> 否
								</td>
							</tr>
							<tr>
								<th> 送貨單顯示產品編號？ </th>
								<td>
									<input type="radio" name="site_dn_show_product_code" value="Y" {if $Site.site_dn_show_product_code != 'N'}checked=checked{/if} /> 是
									<input type="radio" name="site_dn_show_product_code" value="N" {if $Site.site_dn_show_product_code == 'N'}checked=checked{/if} /> 否
								</td>
							</tr>
						{/if}
					{/if}
				</table>
				{if $Site.site_module_order_enable == 'Y' && $Site.site_invoice_enable == 'Y'}
					<table class="LeftHeaderTable">
						<tr>
							<th>發票頁首</th>
							<td>{$EditorInvoiceHeaderHTML}</td>
						</tr>
						<tr>
							<th>發票頁尾</th>
							<td>{$EditorInvoiceFooterHTML}</td>
						</tr>
						<tr>
							<th>發票條款和條件</th>
							<td>{$EditorInvoiceTNCHTML}</td>
						</tr>
					</table>
				{/if}
				{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
					{if $Site.site_dn_enable == 'Y'}
						<table class="LeftHeaderTable">
							<tr>
								<th>送貨單頁首</th>
								<td>{$EditorDnHeaderHTML}</td>
							</tr>
							<tr>
								<th>送貨單頁尾</th>
								<td>{$EditorDnFooterHTML}</td>
							</tr>
							<tr>
								<th>送貨單條款和條件</th>
								<td>{$EditorDnTNCHTML}</td>
							</tr>
						</table>
					{/if}
				{/if}
			</div>
			<input type="hidden" name="site_id" value="{$Site.site_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確定
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
