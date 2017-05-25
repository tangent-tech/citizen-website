{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">Edit Campaign &nbsp;
	<a href="elasing_campaign_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Campaign List</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Campaign Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_campaign_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				{if $IsContentAdmin}
					<tr>
						<th>Owner</th>
						<td>{$Campaign.email}</td>
					</tr>
				{/if}
				<tr>
					<th>Campaign Active Date</th>
					<td><input id="campaign_active_datetime" name="campaign_active_datetime" type="text" value="{$Campaign.campaign_active_datetime|date_format:'%Y-%m-%d'}" />{html_select_time use_24_hours=true display_seconds=false time=$Campaign.campaign_active_datetime}</td>
				</tr>
				<tr>
					<th>Email Title</th>
					<td><input type="text" size="80" name="campaign_title" value="{$Campaign.campaign_title}" /></td>
				</tr>
				<tr>
					<th>Email List</th>
					<td>
						{foreach from=$EmailList item=E}
							<input type="checkbox" class="InputCheckBox" name="EmailList[]" value="{$E.list_id}" /> {$E.list_name} <br />
						{/foreach}
					</td>
				</tr>
				<tr>
					<td colspan="2">{$EditorHTML}</td>
				</tr>
{*
				<tr>
					<th>Email Link</th>
					<td><input type="text" size="80" name="campaign_link" value="{$Campaign.campaign_link}" /></td>
				</tr>
				<tr>
					<th>Email Image</th>
					<td>
						{if $Campaign.campaign_image_file_id != 0}
							<img src="getfile.php?id={$Campaign.campaign_image_file_id}" /> <br />
							<input type="checkbox" class="InputCheckBox" name="remove_campaign_image" value="yes" /> Remove Image <br />
						{/if}
						<br />
						<input type="file" name="campaign_image" /> <br />
					</td>
				</tr>
*}
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
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
