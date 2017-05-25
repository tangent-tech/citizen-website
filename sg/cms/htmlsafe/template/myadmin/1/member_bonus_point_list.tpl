{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">Member Bonus Point List &nbsp; 
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
				<th>Ref. No</th>
				<th>User</th>
				<th>Date</th>
				<th>Details</th>
				<th>Debit</th>
				<th>Credit</th>
				<th>Balance</th>
				<th>Expiry Date</th>
			</tr>
			{foreach from=$UserBonusPointList item=B}
				<tr>
					<td>{$B.user_bonus_point_id}</td>
					<td>{$B.user_username}</td>
					<td>{$B.create_date}</td>
					<td>
						{if $B.is_auto_expire_transaction == 'N'}
							{if $B.earn_type == 'uorder'}
								{if $B.bonus_point_earned > 0}
									Earned from order #{$B.order_no}
								{else if $B.bonus_point_spent > 0}
									Redeemed for order #{$B.order_no}
								{/if}
							{else if $B.earn_type == 'void'}
								Void Order #{$B.order_no}
							{else}
								{$B.bonus_point_reason}
							{/if}
						{else}
							{if $B.earn_type == 'uorder'}
								Order #{$B.order_no} Expired
							{else if $B.earn_type == 'coupon'}
								Ref #{$B.myorder_id} Expired
							{else if $B.earn_type == 'custom'}
								Ref #{$B.myorder_id} Expired
							{else if $B.earn_type == 'void'}
								Ref #{$B.myorder_id} Expired												
							{/if}
						{/if}
					</td>
					<td>{$B.bonus_point_spent}</td>
					<td>{$B.bonus_point_earned}</td>
					<td>{$B.bonus_point_amount_after}</td>
					<td>
						{if $B.expiry_date != '0000-00-00'}
							{$B.expiry_date}
						{else}
							-
						{/if}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>				
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
