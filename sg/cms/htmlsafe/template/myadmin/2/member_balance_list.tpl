{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">會員結餘列表 &nbsp; 
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

</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<div class="AdminEditDetailsBlock">
		<table class="TopHeaderTable AlignCenter">
			<tr class="ui-state-highlight">
				<th>日期</th>
				<th>會員</th>
				<th>詳情</th>
				<th>支賬</th>
				<th>入賬</th>
				<th>戶口結餘</th>
			</tr>
			{foreach from=$UserBalanceList item=B}
				<tr>
					<td>{$B.create_date}</td>
					<td>{$B.user_username}</td>
					<td>
						{if $B.user_balance_transaction_type == 'adjustment'}
							{if $B.content_admin_id != 0}
								{$B.email}　作出調整 <br />
							{else if $B.system_admin_id != 0}
								調整 <br />
							{/if}
							{$B.user_balance_remark}
						{else if $B.user_balance_transaction_type == 'uorder'}
							訂單 #{$B.order_no}
						{else if $B.user_balance_transaction_type == 'recharge'}
							充值
						{else if $B.user_balance_transaction_type == 'void'}
							取消訂單 #{$B.order_no}
						{/if}
					</td>
					<td>
						{if $B.user_balance_transaction_amount < 0}
							{$B.user_balance_transaction_amount * -1}
						{/if}
					</td>
					<td>
						{if $B.user_balance_transaction_amount > 0}
							{$B.user_balance_transaction_amount}
						{/if}
					</td>
					<td>{$B.user_balance_after}</td>
				</tr>
			{/foreach}
		</table>
	</div>				
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
