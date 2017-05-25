{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">Add Site &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="site_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Site List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Site Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th colspan="2" class="ui-state-highlight">Please do NOT add protocol (http:// or ftp://) in any address fields.</th>
					</tr>
					<tr>
						<th> Site Name </th>
						<td> <input type="text" name="site_name" value="{$smarty.request.site_name|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> Site Address</th>
						<td> <input type="text" name="site_address" value="{$smarty.request.site_address|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP Address </th>
						<td> <input type="text" name="site_ftp_address" value="{$smarty.request.site_ftp_address|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP Username </th>
						<td> <input type="text" name="site_ftp_username" value="{$smarty.request.site_ftp_username|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP Password </th>
						<td> <input type="text" name="site_ftp_password" value="{$smarty.request.site_ftp_password|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP User File Directory </th>
						<td> <input type="text" name="site_ftp_userfile_dir" value="{$smarty.request.site_ftp_userfile_dir|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> HTTP User File Path </th>
						<td> <input type="text" name="site_http_userfile_path" value="{$smarty.request.site_http_userfile_path|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP File Base Directory </th>
						<td> <input type="text" name="site_ftp_filebase_dir" value="{$smarty.request.site_ftp_filebase_dir|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> FTP Static File Directory </th>
						<td> <input type="text" name="site_ftp_static_link_dir" value="{$smarty.request.site_ftp_static_link_dir|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> HTTP Static File Path </th>
						<td> <input type="text" name="site_http_static_link_path" value="{$smarty.request.site_http_static_link_path|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> API Login </th>
						<td> <input type="text" name="site_api_login" value="{$smarty.request.site_api_login|escape:'html'}" size="40" /> </td>
					</tr>
					<tr>
						<th> Default Currency </th>
						<td>
							<select id="site_default_currency_id" name="site_default_currency_id">
								{foreach from=$CurrencyList item=C}
								    <option value="{$C.currency_id}">{$C.currency_longname}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th> Default Language </th>
						<td>
							<select id="site_default_language_id" name="site_default_language_id">
								{foreach from=$LanguageList item=L}
								    <option value="{$L.language_id}">{$L.language_native}</option>
								{/foreach}
							</select>
						</td>
					</tr>
				</table>
			</div>
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
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
