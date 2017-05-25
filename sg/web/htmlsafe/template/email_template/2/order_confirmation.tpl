<p>
	親愛的 {$MyOrder->myorder->invoice_first_name} {$MyOrder->myorder->invoice_last_name},<br />
	<br />
	多謝你的訂單<br />
	<br />
	我們已成功處理你的訂單要求，詳情如下︰
</p>
<table width="800" style="{ldelim}border:solid 1px #D2B8D7; vertical-align: top;{rdelim}">

	<tr>
		<td width="220">交易日期</td>
		<td width="570">{$MyOrder->myorder->create_date|date_format:"%Y-%m-%d"}</td>
	</tr>
	<tr>
		<td>發票號</td>
		<td>{$MyOrder->myorder->order_no}</td>
	</tr>
	<tr>
		<td>交易金額</td>
		<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->pay_amount_ca|doubleval|number_format:2}</td>
	</tr>
	<tr>
		<td valign="top">會員資料:</td>
		<td><table width="570" border="0">
			<tr>
				<td width="158">用戶</td>
				<td width="10">:</td>
				<td width="388">
					{$User->user->user_first_name} {$User->user->user_last_name}
				</td>
			</tr>
			<tr>
				<td valign="top">用戶地址</td>
				<td>:</td>
				<td>
					
	    			{$User->user->user_address_1} <br />
	    			{if $User->user->user_address_2 != ''}{$User->user->user_address_2} <br />{/if}
    				{if $User->user->user_city_name != ''}{$User->user->user_city_name}, {/if}{if $User->user->user_region != ''}{$User->user->user_region}, {/if}{if $User->user->user_postcode != ''}{$User->user->user_postcode} <br /> {/if}
				
				</td>
			</tr>
			
			<tr>
				<td>電話號碼</td>
				<td>:</td>
				<td>
					{if $User->user->user_tel_country_code != ''}{$User->user->user_tel_country_code} - {/if}{if $User->user->user_tel_area_code != ''}{$User->user->user_tel_area_code} - {/if}{$User->user->user_phone_no}

				</td>
			</tr>
			<tr>
				<td>電子郵件</td>
				<td>:</td>
				<td>{$User->user->user_email}</td>
			</tr>
			<tr>
				<td>給我們留言/特別指示</td>
				<td>:</td>
				<td>{if $MyOrder->myorder->user_message != ''}{$MyOrder->myorder->user_message}{else}-不適用-{/if}</td>
			</tr>
		</table></td>
	</tr>	
	<tr>
		<td valign="top">貨運資料:</td>
		<td><table width="570" border="0">
			<tr>
				<td width="158">經辦人</td>
				<td width="10">:</td>
				<td width="388">
					{if $MyOrder->myorder->deliver_to_different_address == 'N'}
						{$MyOrder->myorder->invoice_first_name} {$MyOrder->myorder->invoice_last_name}
					{else}
						{$MyOrder->myorder->delivery_first_name} {$MyOrder->myorder->delivery_last_name}
					{/if}
				</td>
			</tr>
			<tr>
				<td valign="top">送貨地址</td>
				<td>:</td>
				<td>
					{if $MyOrder->myorder->deliver_to_different_address == 'N'}
		    			{$MyOrder->myorder->invoice_shipping_address_1} <br />
		    			{if $MyOrder->myorder->invoice_shipping_address_2 != ''}{$MyOrder->myorder->invoice_shipping_address_2}  <br />{/if}
		    			{if $MyOrder->myorder->invoice_city_name != ''}{$MyOrder->myorder->invoice_city_name}, {/if}{if $MyOrder->myorder->invoice_hk_district_id > 0}{$InvoiceDistrict[0]->hk_district_name_tc}, {/if}{if $MyOrder->myorder->invoice_region != ''}{$MyOrder->myorder->invoice_region}, {/if}{if $MyOrder->myorder->invoice_postcode != '' && $MyOrder->myorder->invoice_postcode != 'NONE'}{$MyOrder->myorder->invoice_postcode}, {/if}{$InvoiceCountry[0]->country_name_tc} <br />
					{else}
		    			{$MyOrder->myorder->delivery_shipping_address_1} <br />
		    			{if $MyOrder->myorder->delivery_shipping_address_2 != ''}{$MyOrder->myorder->delivery_shipping_address_2}  <br />{/if}
	    				{if $MyOrder->myorder->delivery_city_name != ''}{$MyOrder->myorder->delivery_city_name}, {/if}{if $MyOrder->myorder->delivery_hk_district_id > 0}{$DeliveryDistrict[0]->hk_district_name_tc}, {/if}{if $MyOrder->myorder->delivery_region != ''}{$MyOrder->myorder->delivery_region}, {/if}{if $MyOrder->myorder->delivery_postcode != '' && $MyOrder->myorder->delivery_postcode != 'NONE'}{$MyOrder->myorder->delivery_postcode}, {/if}{$DeliveryCountry[0]->country_name_tc} <br />
					{/if}
				</td>
			</tr>
			<tr>
				<td>電話號碼</td>
				<td>:</td>
				<td>
					{if $MyOrder->myorder->deliver_to_different_address == 'N'}
						{if $MyOrder->myorder->invoice_tel_country_code != ''}{$MyOrder->myorder->invoice_tel_country_code} - {/if}{if $MyOrder->myorder->invoice_tel_area_code != ''}{$MyOrder->myorder->invoice_tel_area_code} - {/if}{$MyOrder->myorder->invoice_phone_no} <br />
					{else}
						{if $MyOrder->myorder->delivery_tel_country_code != ''}{$MyOrder->myorder->delivery_tel_country_code} - {/if}{if $MyOrder->myorder->delivery_tel_area_code != ''}{$MyOrder->myorder->delivery_tel_area_code} - {/if}{$MyOrder->myorder->delivery_phone_no}
					{/if}
				</td>
			</tr>
			<tr>
				<td>電子郵件</td>
				<td>:</td>
				<td>{$MyOrder->myorder->delivery_email}</td>
			</tr>
		</table></td>
	</tr>
</table>
	    	<table border="1">
	    		<tr>
	    			<th width="300">產品</th>
					<th width="50">產品編號</th>
					<th width="50">數量</th>
					<th width="200">備註</th>
					<th width="50">單價</th>
					<th width="50">總價格 </th>
	    			<th width="50">積分</th>
	    		</tr>
		    	{foreach from=$MyOrder->myorder->myorder_products->children() item=O}
			    	<tr>
			    		<td>
			            	{if $O->object_thumbnail_file_id != 0}
			            		<img border="0" height="{$smarty.const.CART_LIST_PHOTO_HEIGHT}" width="{$smarty.const.CART_LIST_PHOTO_WIDTH}" src="{$smarty.const.BASEURL}/getfile.php?id={$O->object_thumbnail_file_id}" /> <br />
			            	{/if}
			            	{$O->product_name}
			            </td>
			            <td>{$O->product_code}</td>
			    		<td>{$O->quantity}</td>
			    		<td>
			    			{if $O->effective_discount_type == 1}
			    				{$O->discount1_off_p}% Off
			    			{elseif $O->effective_discount_type == 2}
			    				{$MyOrder->myorder->currency_shortname}{$O->discount2_price} for {$O->discount2_amount}
			    			{elseif $O->effective_discount_type == 3}
			    				買 {$O->discount3_buy_amount} 送 {$O->discount3_free_amount} 
			    			{else}
			    				-
			    			{/if}
			    		</td>
			    		<td>
			    			{if $O->effective_discount_type == 1}
			    				{$MyOrder->myorder->currency_shortname}{$O->actual_unit_price_ca}
			    			{elseif $O->effective_discount_type == 2}
			    				-
			    			{elseif $O->effective_discount_type == 3}
			    				{$MyOrder->myorder->currency_shortname}{$O->actual_unit_price_ca|doubleval|number_format:2}
			    			{else}
			    				{$MyOrder->myorder->currency_shortname}{$O->actual_unit_price_ca|doubleval|number_format:2}
			    			{/if}
			    		</td>
			    		<td>
			    			{if $O->actual_subtotal_price_ca != ''}
		    					<strong>{$MyOrder->myorder->currency_shortname}{$O->actual_subtotal_price_ca|doubleval|number_format:2}</strong>
		    				{/if}
			    		</td>
			    		
			    		<td>
							{$O->product_bonus_point_amount}
			    		</td>
			    		
			    	</tr>
		    	{/foreach}

		    	<tr>
	    			<th rowspan="4" colspan="4"></th>
	    			<td><strong>小計:</strong></td>
	    			<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->total_price_ca|doubleval|number_format:2}</strong></td>
	    			<td><strong>{$MyOrder->myorder->bonus_point_earned}</strong></td>
		    	</tr>
		    	<tr>
					
					<td><strong>折扣</strong></td>
					<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->postprocess_rule_discount_amount_ca|doubleval|number_format:2}</td>
					<td>{if $MyOrder->myorder->effective_discount_postprocess_rule_discount_code != ''}({$MyOrder->myorder->effective_discount_postprocess_rule_discount_code}){/if}</td>
				</tr>
				<tr>
					
					<td><strong>運費</strong></td>
					<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->freight_cost_ca|doubleval|number_format:2}</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					
					<td><strong>總價</strong></td>
					<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->pay_amount_ca|doubleval|number_format:2}</td>
					<td>&nbsp;</td>
				</tr>
	    	</table>
	    	
			<h3>積分 </h3>
			<table id="BonusPointReward">
				<tr>
					<td width="100">贖回:</td>
					<td>
						{if $MyOrder->myorder->myorder_bonus_point_items->myorder_bonus_point_item|@count > 0}
							{if $BonusPointItem->bonus_point_item->bonus_point_item_type == 'cash'}
								Cash Value {$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->bonus_point_redeemed_cash_ca|doubleval|number_format:2}
							{else}
				            	{if $BonusPointItem->bonus_point_item->object_thumbnail_file_id != 0}
				            		<img border="0" class="BonusPointItem" src="{$smarty.const.BASEURL}/getfile.php?id={$BonusPointItem->bonus_point_item->object_thumbnail_file_id}" />
				            		<br />
				            	{/if}
				            	{$BonusPointItem->bonus_point_item->bonus_point_item_name}
							{/if}
						{else}
							-
						{/if}
					</td>
				</tr>
			</table>

			<h3>積分結餘</h3>
			<table id="CPBalance">
				<tr>
					<td>前積分結餘:</td>
					<td> {$MyOrder->myorder->bonus_point_previous} </td>
				</tr>
				<tr>
					<td>得到積分:</td>
					<td> {$MyOrder->myorder->bonus_point_earned} </td>
				</tr>
				<tr>
					<td>可用積分:</td>
					<td> {$MyOrder->myorder->bonus_point_canbeused} </td>
				</tr>
				<tr>
					<td>贖回積分: </td>
					<td> {$MyOrder->myorder->bonus_point_redeemed} </td>
				</tr>
				<tr>
					<td>積分結餘:</td>
					<td> {$MyOrder->myorder->bonus_point_balance} </td>
				</tr>
			</table>

			<table id="ShoppingSummary">
				<tr>
					<th width="200" align="left">小計:</th>
					<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->total_price_ca|doubleval|number_format:2} </td>
				</tr>
				<tr>
					<th width="200" align="left">折扣{if $MyOrder->myorder->effective_discount_postprocess_rule_discount_code != ''}({$MyOrder->myorder->effective_discount_postprocess_rule_discount_code}){/if}:</th>
					<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->postprocess_rule_discount_amount_ca|doubleval|number_format:2} </td>
				</tr>	
				<tr>
					<th width="200" align="left">運費:</th>
					<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->freight_cost_ca|doubleval|number_format:2} </td>
				</tr>				
				
				<tr>
					<th width="200" align="left">兌換現金價值:</th>
					<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->bonus_point_redeemed_cash_ca} </td>
				</tr>
				
				{if $UserBalance > 0}
					<tr>
						<th>現金結餘:</th>
						<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->user_balance_used_ca|doubleval|number_format:2} </td>
					</tr>
				{/if}
				<tr>
					<th width="200" align="left">總價:</th>
					<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->pay_amount_ca|doubleval|number_format:2} </strong></td>
				</tr>
			</table>


--<br />
This is a post-only mailing.  Replies to this message are not monitored or answered.