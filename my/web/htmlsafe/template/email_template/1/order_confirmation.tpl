<table width="800" style="{ldelim}border:solid 1px #D2B8D7; vertical-align: top;{rdelim}">
	<tr>
		<td colspan="2"><div align="left"><img border="0" src="{$smarty.const.BASEURL}/images/logo_white_bg.png" width="203" height="66" /></div></td>
	</tr>
	<tr>
		<td colspan="2">
			<p>
				Dear {$MyOrder->myorder->invoice_first_name} {$MyOrder->myorder->invoice_last_name},<br />
				<br />
				Thanks for shopping at {$smarty.const.CLIENT_NAME}<br />
				<br />
				We have successfully processed the transaction as below.
			</p>
		</td>
	</tr>
	<tr>
		<td width="220">Transaction Date</td>
		<td width="570">{$MyOrder->myorder->create_date|date_format:"%Y-%m-%d"}</td>
	</tr>
	<tr>
		<td>Invoice No.</td>
		<td>{$MyOrder->myorder->order_no}</td>
	</tr>
	<tr>
		<td>Transaction Amount</td>
		<td>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->pay_amount_ca|doubleval|number_format:2}</td>
	</tr>
	<tr>
		<td>Name</td>
		<td>
			{$User->user->user_first_name} {$User->user->user_last_name}
		</td>
	</tr>
	<tr>
		<td>Phone No</td>
		<td>
			{if $User->user->user_tel_country_code != ''}{$User->user->user_tel_country_code} - {/if}{if $User->user->user_tel_area_code != ''}{$User->user->user_tel_area_code} - {/if}{$User->user->user_tel_no}
		</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>{$User->user->user_email}</td>
	</tr>
	<tr>
		<td>Gender</td>
		<td>{$User->user->user_custom_text_3}</td>
	</tr>
	<tr>
		<td>Age</td>
		<td>{$User->user->user_custom_text_4}</td>
	</tr>
</table>
	    	<table border="1">
	    		<tr>
	    			<th width="300">Item</th>
	    			<th width="50">Price</th>
	    		</tr>
		    	{foreach from=$MyOrder->myorder->myorder_products->children() item=O}
			    	<tr>
			    		<td>
			            	{if $O->object_thumbnail_file_id != 0}
			            		<img border="0" height="{$smarty.const.CART_LIST_PHOTO_HEIGHT}" width="{$smarty.const.CART_LIST_PHOTO_WIDTH}" src="{$smarty.const.BASEURL}/getfile.php?id={$O->object_thumbnail_file_id}" /> <br />
			            	{/if}
			            	{$O->product_name}
			            </td>
			    		<td>
			    			{if $O->actual_subtotal_price_ca != ''}
		    					<strong>{$MyOrder->myorder->currency_shortname}{$O->actual_subtotal_price_ca|doubleval|number_format:2}</strong>
		    				{/if}
			    		</td>
			    	</tr>
		    	{/foreach}
		    	<tr>
	    			<td><strong>Total:</strong></td>
	    			<td><strong>{$MyOrder->myorder->currency_shortname}{$MyOrder->myorder->pay_amount_ca|doubleval|number_format:2} </strong></td>
		    	</tr>
	    	</table>
--<br />
This is a post-only mailing.  Replies to this message are not monitored or answered.