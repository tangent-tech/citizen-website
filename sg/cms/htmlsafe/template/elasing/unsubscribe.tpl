{include file='elasing/header.tpl'}
<div id="LoginContainer" class="InnerContainer ui-widget ui-widget-content ui-corner-all">
	<h1 style="text-align: center" class="InnerHeader ui-widget-header ui-helper-reset ui-corner-top" >{$TheSite.site_name} - Unsubscribe</h1>
	<div id="LoginContainerContent" class="InnerContent ui-widget-content ui-helper-reset ui-corner-bottom">
		<form action="unsubscribe_act.php" method="post">
			{*<p>
				Unsubscribe all emails from {$TheSite.site_name}: <input type="checkbox" name="UnsubscribeAll" value="Unsubscribe" />
			</p>
			*}
			{if $TheSite.site_email_unsubscribe_hide_mailing_list != 'Y'}
				<table id="UnsubscribeTable">
					<tr>
						<th>Mailing List</th>
						<th>Unsubscribe</th>
					</tr>
					{foreach from=$EmailList item=E}
						<tr>
							<td>
								<span class="ListName">{$E.list_name}</span> <br />
								<span class="ListDesc">{$E.list_desc}</span>
							</td>
							<td class="AlignCenter">
								<input type="checkbox" name="UnsubscribeList[{$E.list_id}]" value="Unsubscribe" />
							</td>
						</tr>
					{/foreach}
					<tr>
						<th colspan="2">
							<input class="ui-state-default ui-corner-all MyInputButton" type="submit" value="Submit" />
							<input class="ui-state-default ui-corner-all MyInputButton" type="reset" value="Reset" />
						</th>
					</tr>
				</table>
			{else}
				<input type="hidden" name="UnsubscribeAll" value="Unsubscribe" />
				<input class="ui-state-default ui-corner-all MyInputButton" type="submit" value="Unsubscribe eDM emails from {$TheSite.site_name}" />
			{/if}
			<input type="hidden" name="ceid" value="{$smarty.request.ceid}" />
			<input type="hidden" name="key" value="{$smarty.request.key}" />
		</form>
	</div>
</div>
{include file='elasing/footer.tpl'}