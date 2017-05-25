{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">編輯購買產品列表 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$smarty.request.id}#MyOrderTabsPanel-Pricing">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 訂單
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">訂單編碼: {$MyOrder.myorder_id}</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="order_edit_product_list_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="TopHeaderTable AlignCenter">
				<tr class="ui-state-highlight">
					<th class="AlignLeft">產品編號</th>
					<th width="350" class="AlignLeft">產品參考名稱</th>
					<th>數量</th>
				</tr>
				{foreach from=$MyOrderItemList item=M}
					<tr class="MyOrderItem" data-object_link_id="{$M.object_link_id}">
						<td class="AlignLeft">{$M.product_code}</td>
						<td class="AlignLeft">
							{$M.object_name}
							{if $M.product_option_id != 0}
								(
								{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
									{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
									{$M.$myfield} 
								{/section}
								)
							{/if}
						</td>
						<td>
		    				<input type="text" name="quantity[]" value="{$M.quantity}" size="3" />
		    				<input type="hidden" name="product_id[]" value="{$M.product_id|intval}" />
		    				<input type="hidden" name="product_option_id[]" value="{$M.product_option_id|intval}" />
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<input type="hidden" name="id" value="{$smarty.request.id}" />
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
