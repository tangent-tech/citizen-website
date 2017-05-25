{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_inventory.tpl"}
<h1 class="PageTitle">貨物進出詳情 &nbsp;
	<a onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="stock_transaction_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="stock_transaction_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 貨物進出列表
	</a>
	<a onclick="return confirm('警告!\n貨物出入籃會被此次回退覆蓋﹗\n你確定要回退嗎?')" class="ui-state-default ui-corner-all MyButton" href="stock_in_out_rollback.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-refresh"></span> 回退
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Stock Transaction (id: {$StockTransaction.stock_transaction_id})</h2>
	<div class="InnerContent ui-widget-content">
		<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
			<tr>
				<th>類型</th>
				<td>
					{if $StockTransaction.stock_in_out_type == 'STOCK_IN'}
						入貨
					{elseif $StockTransaction.stock_in_out_type == 'ADJUSTMENT'}
						修正
					{/if}
				</td>
			</tr>
			<tr>
				<th>日期</th>
				<td>{$StockTransaction.stock_in_out_date|date_format:'%Y-%m-%d %H:%M'}</td>
			</tr>
			<tr>
				<th>供應商</th>
				<td>{$StockTransaction.stock_in_out_vendor_name}</td>
			</tr>
			<tr>
				<th>標題</th>
				<td>{$StockTransaction.stock_in_out_subject}</td>
			</tr>
			<tr>
				<th>內容</th>
				<td>{$StockTransaction.stock_in_out_note|nl2br}</td>
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
						{$P.product_quantity}
					</td>				
				</tr>
			{/foreach}
		</table>
	</div>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
