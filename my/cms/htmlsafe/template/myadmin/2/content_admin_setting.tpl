{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
<h1 class="PageTitle"> 內容管理員設定 &nbsp;</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_setting_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th>電郵</th>
					<td>{$AdminInfo.email|escape:'html'}</td>
				</tr>
				<tr>
					<th>舊密碼</th>
					<td><input type="password" name="old_password" size="80" /></td>
				</tr>
				<tr>
					<th>新密碼</th>
					<td><input type="password" name="user_password" value="" size="80" /></td>
				</tr>
				<tr>
					<th>再輸入新密碼</th>
					<td><input type="password" name="user_password2" value="" size="80" /></td>
				</tr>
				<tr>
					<th>電郵通知</th>
					<td>
						<input type="radio" name="email_notification" value="Y" {if $AdminInfo.email_notification != 'N'}checked=checked{/if} /> 是
						<input type="radio" name="email_notification" value="N" {if $AdminInfo.email_notification == 'N'}checked=checked{/if} /> 否
					</td>
				</tr>
			</table>
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確認
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</div>
	</form>
</div>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
