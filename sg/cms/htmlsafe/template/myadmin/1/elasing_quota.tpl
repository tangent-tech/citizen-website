{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
{* <h1 class="PageTitle">Newsletter Quota</h1> *}
<table class="TopHeaderTable AlignCenter">
	<tr>
		<th width="150">Monthly Quota</th>
		<th width="150">Email Sent</th>
	</tr>
	<tr>
		<td>{$Site.site_email_sent_monthly_quota}</td>
		<td>{$Site.site_email_sent_monthly_count}</td>
	</tr>
</table>
<br />
<h2 class="PageTitle">Setting</h2>
<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_quota_act.php">
	<table class="TopHeaderTable">
		<tr>
			<th width="50%">Sender Name</th>
			<td>
				<input type="text" name="site_module_elasing_sender_name" value="{$Site.site_module_elasing_sender_name}" />
			</td>
		</tr>
		<tr>
			<th width="50%">Sender Address</th>
			<td>
				<input type="text" name="site_module_elasing_sender_address" value="{$Site.site_module_elasing_sender_address}" />
			</td>
		</tr>
	</table>
	<br />
	<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-check"></span> Submit
	</a>
	<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-cancel"></span> Reset
	</a>
	<br />
</form>


<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
