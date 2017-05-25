{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">會員積分獎賞列表 &nbsp; 
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
				<th>參考編碼</th>
				<th>會員</th>
				<th>曰期</th>
				<th>詳情</th>
				<th>支賬</th>
				<th>入賬</th>
				<th>結餘</th>
				<th>有效期至</th>
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
									經訂單 #{$B.order_no} 賺取
								{else if $B.bonus_point_spent > 0}
									經訂單 #{$B.order_no} 兌換
								{/if}
							{else if $B.earn_type == 'void'}
								取消訂單 #{$B.order_no}
							{else}
								{$B.bonus_point_reason}
							{/if}
						{else}
							{if $B.earn_type == 'uorder'}
								訂單 #{$B.order_no} 到期
							{else if $B.earn_type == 'coupon'}
								參考編碼 #{$B.myorder_id} 到期
							{else if $B.earn_type == 'custom'}
								參考編碼 #{$B.myorder_id} 到期
							{else if $B.earn_type == 'void'}
								參考編碼 #{$B.myorder_id} 到期						
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
