{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">Member Balance List &nbsp; 
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
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
				<th>Date</th>
				<th>Member</th>
				<th>Details</th>
				<th>Debit</th>
				<th>Credit</th>
				<th>Account Balance</th>
			</tr>
			{foreach from=$UserBalanceList item=B}
				<tr>
					<td>{$B.create_date}</td>
					<td>{$B.user_username}</td>
					<td>
						{if $B.user_balance_transaction_type == 'adjustment'}
							{if $B.content_admin_id != 0}
								Adjustment made by {$B.email} <br />
							{else if $B.system_admin_id != 0}
								Adjustment <br />
							{/if}
							{$B.user_balance_remark}
						{else if $B.user_balance_transaction_type == 'uorder'}
							Order #{$B.order_no}
						{else if $B.user_balance_transaction_type == 'recharge'}
							Recharge
						{else if $B.user_balance_transaction_type == 'void'}
							Void Order #{$B.order_no}
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
