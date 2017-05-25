{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">貨物進出列表</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>
	<br />
	<table class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>貨物進出編號</th>
			<th>類別</th>
			<th>日期</th>
			<th>詳情</th>
		</tr>
		{foreach from=$StockTransactionList item=S}
			<tr>
				<td class="AlignCenter">{$S.stock_transaction_id}</td>
				<td class="AlignCenter">
					{if		$S.stock_transaction_type == 'STOCK_IN'}
						入貨 ({$S.stock_in_out_vendor_name} - {$S.stock_in_out_subject})
					{elseif	$S.stock_transaction_type == 'SHIPMENT'}
						發貨 (Order: {$S.order_no})
					{elseif	$S.stock_transaction_type == 'ADJUSTMENT'}
						調整
					{elseif	$S.stock_transaction_type == 'STOCK_HOLD'}
						扣貨　(訂單# {$S.order_no})
					{/if}
				</td>
				<td>{$S.stock_transaction_date}</td>
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
							<span class="ui-icon ui-icon-pencil"></span> 詳情
						</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
