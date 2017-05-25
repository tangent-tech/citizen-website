{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">新增活動 &nbsp;
	<a href="elasing_campaign_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>活動列表</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">活動詳情 </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_campaign_add_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th>活動啟用日期</th>
					<td><input class="DatePicker" name="campaign_active_datetime" type="text" value="{$smarty.now|date_format:'%Y-%m-%d'}"/>{html_select_time use_24_hours=true display_seconds=false}</td>
				</tr>
				<tr>
					<th>電郵標題</th>
					<td><input type="text" size="80" name="campaign_title" value="" /></td>
				</tr>
				<tr>
					<th>電郵名單</th>
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
					<td><input type="text" size="80" name="campaign_link" value="" /></td>
				</tr>
				<tr>
					<th>Email Content</th>
					<td><textarea name="campaign_content" cols="76" rows="10"></textarea></td>
				</tr>
				<tr>
					<th>Email Image</th>
					<td><input type="file" name="campaign_image" /></td>
				</tr>
*}
			</table>
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確定
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重置
			</a>
		</div>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
