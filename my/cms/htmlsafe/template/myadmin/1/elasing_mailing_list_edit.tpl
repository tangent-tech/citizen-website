{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">Edit Mailing List &nbsp;
	<a href="elasing_mailing_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Mailing List</a>
	{if $Site.site_module_member_enable == 'Y'}
		<a href="elasing_mailing_list_import_member.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-triangle-s"></span>Import Members</a>
	{/if}
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Mailing List Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_mailing_list_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				{if $IsContentAdmin}
					<tr>
						<th>Owner</th>
						<td>{$EmailList.email}</td>
					</tr>
				{/if}
				<tr>
					<th>List Name</th>
					<td><input type="text" size="80" name="list_name" value="{$EmailList.list_name}" /></td>
				</tr>
				<tr>
					<th>List Description</th>
					<td><textarea name="list_desc" cols="76" rows="3">{$EmailList.list_desc}</textarea></td>
				</tr>
			</table>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>

<div class="ui-widget ui-corner-all InnerContainer" id="SubscriberListTab">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Subscriber List</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom" id="SubscriberListPanel">
		<div class="AdminListBlock">
			{if $TotalSubscriber == 0}
				<p>No subscriber in this list.</p>
			{else}
				<p>
					Total No Of Email Address: {$TotalSubscriber}
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
						User Per Page:
						<select id="num_of_elasing_user_per_page" name="num_of_elasing_user_per_page" onchange="submit()">
						    <option value="20" {if $smarty.cookies.num_of_elasing_user_per_page == 20}selected="selected"{/if}>20</option>
						    <option value="50" {if $smarty.cookies.num_of_elasing_user_per_page == 50}selected="selected"{/if}>50</option>
						    <option value="100" {if $smarty.cookies.num_of_elasing_user_per_page == 100}selected="selected"{/if}>100</option>
						    <option value="200" {if $smarty.cookies.num_of_elasing_user_per_page == 200}selected="selected"{/if}>200</option>
						    <option value="500" {if $smarty.cookies.num_of_elasing_user_per_page == 500}selected="selected"{/if}>500</option>
						    <option value="1000" {if $smarty.cookies.num_of_elasing_user_per_page == 1000}selected="selected"{/if}>1000</option>
						    <option value="99999" {if $smarty.cookies.num_of_elasing_user_per_page == 99999}selected="selected"{/if}>All</option>
						</select>
					</form>
					<br />
				</p>
				<table id="SubscriaberListTable">
					<tr>
						<th width="150">Email Address</th>
						<th>Soft Bounce</th>
						<th>Hard Bounce</th>
						<th>Deny All Email By User</th>
						<th>Blacklisted</th>
						<th></th>
					</tr>
					{foreach from=$SubscriberList item=S}
						<tr>
							<td>
								{if $S.subscriber_first_name != '' || $S.subscriber_last_name != ''}
									{$S.subscriber_first_name} {$S.subscriber_last_name} <br />
								{/if}
									{$S.subscriber_email}
							</td>
							<td>{$S.soft_bounce_count}</td>
							<td>{$S.hard_bounce_count}</td>
							<td>{if ($S.deny_all_elasing == 'N' && $S.deny_all_list == 'N') || $S.deny_all_site == 'Y'}No{else}Yes{/if}</td>
							<td>{if $S.soft_bounce_count >= $smarty.const.SOFT_BOUNCE_LIMIT || $S.hard_bounce_count >= $smarty.const.HARD_BOUNCE_LIMIT}Yes{else}No{/if}</td>
							<td>
								<a href="elasing_mailing_list_subscriber_id_delete.php?id={$S.list_subscriber_id}" class="ui-state-default ui-corner-all MyButton" onclick="return confirm('WARNING! \n Are you sure you want to delete?')">
									<span class="ui-icon ui-icon-trash"></span> Delete
								</a>
							</td>
						</tr>
				    {/foreach}
				</table>
			{/if}
			<form enctype="multipart/form-data" name="FrmAddSubscriberEmail" id="FrmAddSubscriberEmail" method="post" action="elasing_subscriber_email_add.php">
				<table>
					<tr>
						<th>Email Address</th>
						<td><input type="text" name="subscriber_email_address" /></td>
					</tr>
					{if $smarty.session.site_id != 39}
						<tr>
							<th>First Name</th>
							<td><input type="text" name="subscriber_first_name" /></td>
						</tr>
						<tr>
							<th>Last Name</th>
							<td><input type="text" name="subscriber_last_name" /></td>
						</tr>
					{else}
						<tr>
							<th>Receiver Name</th>
							<td><input type="text" name="subscriber_first_name" /></td>
						</tr>
						<tr>
							<th>Sender Name</th>
							<td><input type="text" name="subscriber_last_name" /></td>
						</tr>					
					{/if}
				</table>
				<input type="hidden" name="id" value="{$smarty.request.id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddSubscriberEmail">
					<span class="ui-icon ui-icon-circle-plus"></span> Add
				</a>
			</form>
			<br class="clearfloat" />
			<form enctype="multipart/form-data" name="FrmImportSubscriberFromCSV" id="FrmImportSubscriberFromCSV" method="post" action="elasing_import_subscriber_from_csv.php">
				<input type="file" name="csv_file"/>
				<input type="hidden" name="id" value="{$smarty.request.id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmImportSubscriberFromCSV">
					<span class="ui-icon ui-icon-circle-triangle-n"></span> Import Subscribers From CSV UTF-8
				</a>
			</form>
			<br class="clearfloat" />
		</div>
	</div>
</div>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
