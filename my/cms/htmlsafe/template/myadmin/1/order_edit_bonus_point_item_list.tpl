{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">Edit Order Bonus Point Item List &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$smarty.request.id}#MyOrderTabsPanel-BonusPointDetails">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Order
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">Order No: {$MyOrder.myorder_id}</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="order_edit_bonus_point_item_list_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="TopHeaderTable AlignCenter">
				<tr class="ui-state-highlight">
					<th width="350" class="AlignLeft">Bonus Point Item <br /> Reference Name</th>
					<th>Cash Dollar</th>
					<th>Quantity</th>
					<th>Bonus Point</th>
				</tr>
				{foreach from=$BonusPointItemList item=M}
					<tr>
						<td class="AlignLeft">{$M.bonus_point_item_ref_name}</td>
						<td>{$M.cash}</td>
						<td>
		    				<input type="text" name="quantity[{$M.bonus_point_item_id|intval}]" value="{$M.quantity|intval}" size="3" />
						</td>
						<td>{$M.bonus_point_required}</td>
					</tr>
				{/foreach}
			</table>
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
