{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">API Error Msg Default List &nbsp;</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="api_error_msg_default_list_act.php">
		<div id="ApiErrorMsgListTabs">
			<ul>
				{foreach from=$LanguageList item=R}
				    <li><a href="#ApiErrorMsgTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			{foreach from=$LanguageList item=R}
				<div id="ApiErrorMsgTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="TopHeaderTable">
							<tr>
								<th>Code</th>
								<th>ID</th>
								<th>Msg</th>
							</tr>
							{foreach $ErrorMsgList[$R.language_id] as $E}
								<tr>
									<td><input type="text" name="api_error_msg_code[{$R.language_id}][]" value="{$E.api_error_msg_code}" size="50" /></td>
									<td><input type="text" name="api_error_no[{$R.language_id}][]" value="{$E.api_error_no}" size="3" /></td>
									<td><input type="text" name="api_error_msg_content[{$R.language_id}][]" value="{$E.api_error_msg_content}" size="80" /></td>
								</tr>								
							{/foreach}
							{for $foo=1 to 3}
								<tr>
									<td><input type="text" name="api_error_msg_code[{$R.language_id}][]" value="" size="50" /></td>
									<td><input type="text" name="api_error_no[{$R.language_id}][]" value="" size="3" /></td>
									<td><input type="text" name="api_error_msg_content[{$R.language_id}][]" value="" size="80" /></td>
								</tr>
							{/for}
						</table>
					</div>
			   </div>
			{/foreach}
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
