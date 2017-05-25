{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
{* <h1 class="PageTitle">Newsletter Quota</h1> *}
<table class="TopHeaderTable AlignCenter">
	<tr>
		<th width="150">每月配額</th>
		<th width="150">已發送電郵</th>
	</tr>
	<tr>
		<td>{$Site.site_email_sent_monthly_quota}</td>
		<td>{$Site.site_email_sent_monthly_count}</td>
	</tr>
</table>
<br />
<h2 class="PageTitle">設定</h2>
<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_quota_act.php">
	<table class="TopHeaderTable">
		<tr>
			<th width="50%">寄件者名稱</th>
			<td>
				<input type="text" name="site_module_elasing_sender_name" value="{$Site.site_module_elasing_sender_name}" />
			</td>
		</tr>
		<tr>
			<th width="50%">發件者電郵地址</th>
			<td>
				<input type="text" name="site_module_elasing_sender_address" value="{$Site.site_module_elasing_sender_address}" />
			</td>
		</tr>
	</table>
	<br />
	<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-check"></span> 確定
	</a>
	<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-cancel"></span> 重置
	</a>
	<br />
</form>


<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
