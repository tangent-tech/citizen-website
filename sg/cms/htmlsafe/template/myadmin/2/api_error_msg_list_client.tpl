{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">API Error Msg List (Client) &nbsp;</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="api_error_msg_list_client_act.php">
		<div id="ApiErrorMsgListTabs">
			<ul>
				{foreach from=$LanguageRootList item=R}
				    <li><a href="#ApiErrorMsgTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			{foreach from=$LanguageRootList item=R}
				<div id="ApiErrorMsgTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="TopHeaderTable">
							<tr>
								<th>Code</th>
								<th>ID</th>
								<th>Msg</th>
							</tr>
							{foreach $ErrorMsgList[$R.language_id] as $index => $value}
								<tr>
									<td><input type="hidden" name="api_error_msg_code[{$R.language_id}][]" value="{$index}" size="50" />{$index}</td>
									<td><input type="hidden" name="api_error_no[{$R.language_id}][]" value="{$value.no}" size="3" />{$value.no}</td>
									<td><input type="text" name="api_error_msg_content[{$R.language_id}][]" value="{$value.desc}" size="80" /></td>
								</tr>								
							{/foreach}
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
