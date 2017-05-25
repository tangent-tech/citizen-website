{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
<h1 class="PageTitle">Change Password &nbsp;</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="password_change_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th>Email Address</th>
					<td>{$SystemAdmin.email|escape:'html'}{$ContentAdmin.email|escape:'html'}</td>
				</tr>
				<tr>
					<th>Old Password</th>
					<td><input type="password" name="old_password" size="80" /></td>
				</tr>
				<tr>
					<th>New Password</th>
					<td><input type="password" name="user_password" value="" size="80" /></td>
				</tr>
				<tr>
					<th>Re-Type New Password</th>
					<td><input type="password" name="user_password2" value="" size="80" /></td>
				</tr>
			</table>
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
