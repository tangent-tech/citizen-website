{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">訂單列表 &nbsp; 
	<a id="BtnCustomizeHeading" href="#" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-gear"></span> 自訂欄位
	</a>
	<a href="?handled={$smarty.request.handled}" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> 重設篩選
	</a>
	<a id="BtnExport" href="#" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-disk"></span> 匯出
	</a>
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
		Shop: 
		<select name="shop_id" onchange="submit()">
			<option value="all" {if $smarty.request.shop_id=='all'}selected="selected"{/if}>ALL</option>
			{foreach $ShopList as $S}
				<option value="{$S.shop_id}" {if $smarty.request.shop_id==$S.shop_id}selected="selected"{/if}>{$S.shop_name}</option>			
			{/foreach}
		</select>
		<input type="hidden" name="order_no" value="{$smarty.request.order_no}" />
		<input type="hidden" name="order_status" value="{$smarty.request.order_status}" />
		<input type="hidden" name="user_username" value="{$smarty.request.user_username}" />
		<input type="hidden" name="user_email" value="{$smarty.request.user_email}" />
		<input type="hidden" name="invoice_phone_no" value="{$smarty.request.invoice_phone_no}" />
		<input type="hidden" name="pay_amount_ca_min" value="{$smarty.request.pay_amount_ca_min}" />
		<input type="hidden" name="pay_amount_ca_max" value="{$smarty.request.pay_amount_ca_max}" />
		<input type="hidden" name="payment_confirm_by" value="{$smarty.request.payment_confirm_by}" />
		<input type="hidden" name="user_reference" value="{$smarty.request.user_reference}" />
		<input type="hidden" name="order_confirm_date_min" value="{$smarty.request.order_confirm_date_min}" />
		<input type="hidden" name="order_confirm_date_max" value="{$smarty.request.order_confirm_date_max}" />
	</form>
</h1>

<div id="CustomizeHeadingWindow" title="Customize Heading">
	<input data-target_field="Cell_order_no" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_order_no == 'Y'}checked="checked"{/if} /> 訂單編號 <br />
	<input data-target_field="Cell_order_status" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_order_status == 'Y'}checked="checked"{/if} /> 訂單狀態 <br />
	<input data-target_field="Cell_user_username" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_user_username == 'Y'}checked="checked"{/if} /> 會員 <br />
	<input data-target_field="Cell_user_email" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_user_email == 'Y'}checked="checked"{/if} /> 電郵 <br />
	<input data-target_field="Cell_invoice_phone_no" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_invoice_phone_no == 'Y'}checked="checked"{/if} /> 電話 <br />
	<input data-target_field="Cell_pay_amount_ca" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_pay_amount_ca == 'Y'}checked="checked"{/if} /> 金額 <br />
	<input data-target_field="Cell_payment_confirm_by" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_payment_confirm_by == 'Y'}checked="checked"{/if} /> 確認付款經手人 <br />
	<input data-target_field="Cell_user_reference" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_user_reference == 'Y'}checked="checked"{/if} /> 筆記 <br />
	<input data-target_field="Cell_order_confirm_date" type="checkbox" {if $smarty.cookies.CustomizeOrderList_Cell_order_confirm_date == 'Y'}checked="checked"{/if} /> 日期 <br />
</div>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="OrderListTable" class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th class="Cell_order_no" width="30">訂單編號</th>
			<th class="Cell_order_status" width="80">狀態</th>
			<th class="Cell_user_username" width="120">會員</th>
			<th class="Cell_user_email" width="120">電郵</th>
			<th class="Cell_invoice_phone_no" width="120">電話</th>
			<th class="Cell_pay_amount_ca" idth="120">支付金額</th>
			<th class="Cell_order_confirm_date" idth="120">日期</th>
			<th class="Cell_payment_confirm_by" width="90">確認付款經手人</th>
			<th class="Cell_user_reference" width="120">筆記</th>
			<th>操作</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td class="Cell_order_no"><input type="text" name="order_no" size="2" value="{$smarty.request.order_no}" /></td>
				<td class="Cell_order_status">{html_options name=order_status options=$OrderStatusList selected=$smarty.request.order_status}</td>
				<td class="Cell_user_username"><input type="text" name="user_username" size="20" value="{$smarty.request.user_username}" /></td>
				<td class="Cell_user_email"><input type="text" name="user_email" size="20" value="{$smarty.request.user_email}" /></td>
				<td class="Cell_invoice_phone_no"><input type="text" name="invoice_phone_no" size="20" value="{$smarty.request.invoice_phone_no}" /></td>
				<td class="Cell_pay_amount_ca"><input type="text" name="pay_amount_ca_min" size="4" value="{$smarty.request.pay_amount_ca_min}" /> - <input type="text" name="pay_amount_ca_max" size="4" value="{$smarty.request.pay_amount_ca_max}" /></td>
				<td class="Cell_order_confirm_date"><input type="text" name="order_confirm_date_min" size="7" value="{$smarty.request.order_confirm_date_min}" class="DatePicker" /> - <input type="text" name="order_confirm_date_max" size="7" value="{$smarty.request.order_confirm_date_max}" class="DatePicker" /></td>
				<td class="Cell_payment_confirm_by"><input type="text" name="payment_confirm_by" size="20" value="{$smarty.request.payment_confirm_by}" /></td>
				<td class="Cell_user_reference"><input type="text" name="user_reference" size="15" value="{$smarty.request.user_reference}" /></td>
				<td>
					<input type="hidden" name="shop_id" value="{$smarty.request.shop_id}" />
					<input type="hidden" name="myaction" value="filter" />
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> Filter
					</a>
				</td>
			</tr>
		</form>
		{foreach from=$OrderList item=O}
			<tr class="AlignCenter">
				<td class="Cell_order_no">{$O.order_no}</td>
				<td class="Cell_order_status">
					{if $O.order_status == 'awaiting_freight_quote'}
						等待運費報價
					{elseif $O.order_status == 'awaiting_order_confirmation'}
						等待確認訂單
					{elseif $O.order_status == 'order_cancelled'}
						訂單已取消
					{elseif $O.order_status == 'payment_pending'}
						未付款
					{elseif $O.order_status == 'payment_confirmed'}
						已付款
					{elseif $O.order_status == 'partial_shipped'}
						部分發貨
					{elseif $O.order_status == 'shipped'}
						已發貨
					{elseif $O.order_status == 'void'}
						訂單已取消
					{/if}
				</td>
				<td class="Cell_user_username"><a href="member_edit.php?id={$O.user_id}">{$O.user_username}</a></td>
				<td class="Cell_user_email">{$O.user_email}</td>
				<td class="Cell_invoice_phone_no">
					{if $O.invoice_tel_country_code != ''}
						{$O.invoice_tel_country_code|escape:'html'} -
					{/if}
					{if $O.invoice_tel_area_code != ''}
						{$O.invoice_tel_area_code|escape:'html'} -
					{/if}
					{$O.invoice_phone_no|escape:'html'}				
				</td>
				<td class="Cell_pay_amount_ca">{$O.currency_shortname} {$O.pay_amount_ca}</td>
				<td class="Cell_order_confirm_date">{$O.order_confirm_date} </td>
				<td class="Cell_payment_confirm_by">{$O.payment_confirm_by}</td>
				<td class="Cell_user_reference">{$O.user_reference} </td>
				<td>
{*
					{if $O.order_status == 'payment_confirmed'}
						<a href="order_void.php?id={$O.myorder_id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to void this order?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> void
						</a>
					{else}
						<a href="#" class="ui-state-disabled ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> void						
						</a>
					{/if}
*}
					{if $IsSiteAdmin}
						<a href="order_delete.php?id={$O.myorder_id}" onclick="return DoubleConfirm('警告！\n 確定刪除此訂單嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> 刪除
						</a>
					{/if}
					<a href="order_details.php?id={$O.myorder_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-note"></span> 詳情
					</a>
					{if $Site.site_invoice_enable == 'Y'}
						<a href="order_invoice.php?id={$O.myorder_id}" class="ui-state-default ui-corner-all MyButton" target="invoice_window">
							<span class="ui-icon ui-icon-print"></span> 發票
						</a>
					{/if}
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
