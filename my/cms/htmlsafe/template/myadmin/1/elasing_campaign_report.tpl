{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">Campaign Report &nbsp;
	<a href="elasing_campaign_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Campaign List</a>
	{if $Campaign.campaign_status == 'Completed'}
		<a href="elasing_campaign_editasnew.php?id={$Campaign.campaign_id}" class="ui-state-default ui-corner-all MyButton">
			<span class="ui-icon ui-icon-pencil"></span> Edit As New
		</a>
	{/if}
</h1>

<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Campaign Details</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table class="LeftHeaderTable">
			<tr>
				<th>Campaign Active Date</th>
				<td>{$Campaign.campaign_active_datetime|date_format:'%Y-%m-%d'}</td>
			</tr>
			<tr>
				<th>Email Title</th>
				<td>{$Campaign.campaign_title}</td>
			</tr>
			<tr>
				<th>Email Content</th>
				<td>{$Campaign.campaign_content}</td>
			</tr>
		</table>
	</div>
</div>
<div class="ui-widget ui-corner-all InnerContainer" id="SubscriberListTab">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Subscriber List</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom" id="SubscriberListPanel">
		<table class="TopHeaderTable AlignCenter">
			<tr>
				<th width="100">Status</th>
				<th width="80">Total Email</th>
				<th width="80">Blacklisted</th>
				<th width="80">User Deny</th>
				<th width="80">Sent</th>
				<th width="80">Opened</th>
				<th width="80">Clicked</th>
				<th width="80">Soft Bounce</th>
				<th width="80">Hard Bounce</th>
			</tr>
			<tr>
				<td>{$Campaign.campaign_status}</td>
				<td>{$Campaign.no_of_emails}</td>
				<td>{$Campaign.no_of_blacklist}</td>
				<td>{$Campaign.no_of_deny_all}</td>
				<td>{$Campaign.no_of_sent}</td>
				<td>{$Campaign.no_of_opened_emails}</td>
				<td>{$Campaign.no_of_clicked_emails}</td>
				<td>{$Campaign.no_of_soft_bounce}</td>
				<td>{$Campaign.no_of_hard_bounce}</td>
			</tr>
		</table>
		<br />
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
		<form name="FrmSetItemsPerPage" id="FrmSetItemsPerPage" method="post">
			Subscriber Per Page:
			<select id="num_of_elasing_subscriber_per_page" name="num_of_elasing_subscriber_per_page" onchange="submit()">
			    <option value="50" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 50}selected="selected"{/if}>50</option>
			    <option value="100" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 100}selected="selected"{/if}>100</option>
			    <option value="200" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 200}selected="selected"{/if}>200</option>
			    <option value="500" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 500}selected="selected"{/if}>500</option>
			    <option value="1000" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 1000}selected="selected"{/if}>1000</option>
   			    <option value="999999" {if $smarty.cookies.num_of_elasing_subscriber_per_page == 999999}selected="selected"{/if}>ALL</option>
			</select>

			<input type="hidden" name="DeliveryStatus" value="{$smarty.request.DeliveryStatus}" />
			<input type="hidden" name="IsOpened" value="{$smarty.request.IsOpened}" />
			<input type="hidden" name="IsClicked" value="{$smarty.request.IsClicked}" />
		</form>
		<br />
		<table class="TopHeaderTable AlignCenter">
			<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
				<tr class="AlignCenter">
					<td></td>
					<td></td>
					<td></td>
					<td>
						<select name="DeliveryStatus">
							<option value="in_queue"		{if $smarty.request.DeliveryStatus == 'in_queue'}selected="selected"{/if}>in_queue</option>
							<option value="sent" 			{if $smarty.request.DeliveryStatus == 'sent'}selected="selected"{/if}>sent</option>
							<option value="soft_bounced" 	{if $smarty.request.DeliveryStatus == 'soft_bounced'}selected="selected"{/if}>soft_bounced</option>
							<option value="hard_bounced" 	{if $smarty.request.DeliveryStatus == 'hard_bounced'}selected="selected"{/if}>hard_bounced</option>
							<option value="blacklisted" 	{if $smarty.request.DeliveryStatus == 'blacklisted'}selected="selected"{/if}>blacklisted</option>
							<option value="deny_all" 		{if $smarty.request.DeliveryStatus == 'deny_all'}selected="selected"{/if}>deny_all</option>
							<option value="ALL" 			{if $smarty.request.DeliveryStatus == 'ALL'}selected="selected"{/if}>All</option>
						</select>
					</td>
					<td>
						<select name="IsOpened">
							<option value="Y"	{if $smarty.request.IsOpened == 'Y'}selected="selected"{/if}>Yes</option>
							<option value="N" 	{if $smarty.request.IsOpened == 'N'}selected="selected"{/if}>No</option>
							<option value="ALL" {if $smarty.request.IsOpened == 'ALL'}selected="selected"{/if}>All</option>
						</select>
					</td>							<td>
						<select name="IsClicked">
							<option value="Y"	{if $smarty.request.IsClicked == 'Y'}selected="selected"{/if}>Yes</option>
							<option value="N" 	{if $smarty.request.IsClicked == 'N'}selected="selected"{/if}>No</option>
							<option value="ALL" {if $smarty.request.IsClicked == 'ALL'}selected="selected"{/if}>All</option>
						</select>
					</td>
					<td>
						<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
							<span class="ui-icon ui-icon-search"></span> Filter
						</a>
					</td>
					<td></td>
				</tr>
			</form>
			<tr>
				<th width="150">Email Address</th>
				<th width="80">First Name</th>
				<th width="80">Last Name</th>
				<th width="150">Delivery Status</th>
				<th width="50">Opened</th>
				<th width="50">Clicked</th>
				<th width="150">Last Opened Date</th>
				<th width="150">Last Clicked Date</th>
			</tr>
			{if empty($SubscriberList)}
				<tr><td colspan="8">No subscriber found.</td></tr>
			{else}
				{foreach from=$SubscriberList item=S}
					<tr>
						<td>{$S.subscriber_email}</td>
						<td>{$S.subscriber_first_name}</td>
						<td>{$S.subscriber_last_name}</td>
						<td>{$S.delivery_status}</td>
						<td>{if $S.is_opened == 'Y'}Yes{else}No{/if}</td>
						<td>{if $S.is_clicked == 'Y'}Yes{else}No{/if}</td>
						<td>{$S.open_datetime}</td>
						<td>{$S.click_datetime}</td>
					</tr>
			    {/foreach}
			</table>
			{/if}
	</div>
</div>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
