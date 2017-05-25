{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">Edit Site &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="site_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Site List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Site Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th colspan="2" class="ui-state-highlight">Please do NOT add protocol (http:// or ftp://) in any address fields.</th>
					</tr>
					<tr>
						<th> Site Status</th>
						<td>
							<input type="radio" name="site_is_enable" value="Y" {if $TheSite.site_is_enable == 'Y'}checked=checked{/if} /> Enable
							<input type="radio" name="site_is_enable" value="N" {if $TheSite.site_is_enable == 'N'}checked=checked{/if} /> Disable
						</td>
					</tr>
					<tr>
						<th> Site Name </th>
						<td> <input type="text" name="site_name" value="{$TheSite.site_name|escape:'html'}" size="40" /> </td>
					</tr>
					<tr>
						<th> Site Address </th>
						<td> <input type="text" name="site_address" value="{$TheSite.site_address|escape:'html'}" size="40" />
							{if $ConnectionTest.HttpAddressMatch}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Userfile Match FTP Location: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: Userfile FTP content does not match HTTP content</p>
							{/if}
							{if $ConnectionTest.WebAddressMatch}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Web Match FTP Location: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: Web FTP content does not match HTTP content</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> Passive FTP </th>
						<td>
							<input type="radio" name="site_ftp_need_passive" value="Y" {if $TheSite.site_ftp_need_passive == 'Y'}checked=checked{/if} /> Passive
							<input type="radio" name="site_ftp_need_passive" value="N" {if $TheSite.site_ftp_need_passive == 'N'}checked=checked{/if} /> Active
						</td>
					</tr>
					<tr>
						<th> FTP Address </th>
						<td> <input type="text" name="site_ftp_address" value="{$TheSite.site_ftp_address|escape:'html'}" size="40" />
							{if $ConnectionTest.FtpLogin}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Login: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: Cannot Login</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP Username </th>
						<td> <input type="text" name="site_ftp_username" value="{$TheSite.site_ftp_username|escape:'html'}" size="40" />
							{if $ConnectionTest.FtpLogin}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Login: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: Cannot Login</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP Password </th>
						<td> <input type="password" name="site_ftp_password" size="40" />
							{if $ConnectionTest.FtpLogin}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Login: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: Cannot Login</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP Web Directory </th>
						<td> <input type="text" name="site_ftp_web_dir" value="{$TheSite.site_ftp_web_dir|escape:'html'}" size="40" />
							{if $ConnectionTest.Web.read && $ConnectionTest.Web.write}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Read &amp; Write: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error:
									{if !$ConnectionTest.Web.read && !$ConnectionTest.Web.write}
										Cannot read and write
									{elseif !$ConnectionTest.Web.read}
										Cannot read
									{elseif !$ConnectionTest.Web.write}
										Cannot write
									{/if}
								</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP User File Directory </th>
						<td> <input type="text" name="site_ftp_userfile_dir" value="{$TheSite.site_ftp_userfile_dir|escape:'html'}" size="40" />
							{if $ConnectionTest.Userfile.read && $ConnectionTest.Userfile.write}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Read &amp; Write: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error:
									{if !$ConnectionTest.Userfile.read && !$ConnectionTest.Userfile.write}
										Cannot read and write
									{elseif !$ConnectionTest.Userfile.read}
										Cannot read
									{elseif !$ConnectionTest.Userfile.write}
										Cannot write
									{/if}
								</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> HTTP User File Path </th>
						<td> <input type="text" name="site_http_userfile_path" value="{$TheSite.site_http_userfile_path|escape:'html'}" size="40" />
							{if $ConnectionTest.HttpAddressMatch}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Match FTP Location: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error: FTP content does not match HTTP content</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP File Base Directory </th>
						<td> <input type="text" name="site_ftp_filebase_dir" value="{$TheSite.site_ftp_filebase_dir|escape:'html'}" size="40" />
							{if $ConnectionTest.Filebase.read && $ConnectionTest.Filebase.write}
								<p class="ui-state-highlight MyButton"><span class="ui-icon ui-icon-check"></span> Read &amp; Write: OK</p>
							{else}
								<p class="ui-state-error MyButton"><span class="ui-icon ui-icon-closethick"></span> Error:
									{if !$ConnectionTest.Filebase.read && !$ConnectionTest.Filebase.write}
										Cannot read and write
									{elseif !$ConnectionTest.Filebase.read}
										Cannot read
									{elseif !$ConnectionTest.Filebase.write}
										Cannot write
									{/if}
								</p>
							{/if}
						</td>
					</tr>
					<tr>
						<th> FTP Static File Directory </th>
						<td> <input type="text" name="site_ftp_static_link_dir" value="{$TheSite.site_ftp_static_link_dir|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> HTTP Static File Path </th>
						<td> <input type="text" name="site_http_static_link_path" value="{$TheSite.site_http_static_link_path|escape:'html'}" size="50" /> </td>
					</tr>
					<tr>
						<th> Empty Cache URL Callback </th>
						<td> <input type="text" name="site_empty_cache_url_callback" value="{$TheSite.site_empty_cache_url_callback|escape:'html'}" size="50" /> </td>
					</tr>
					
					<tr>
						<th> Sitemap Ignore FOLDER </th>
						<td>
							<input type="radio" name="site_sitemap_ignore_folder" value="Y" {if $TheSite.site_sitemap_ignore_folder == 'Y'}checked=checked{/if} /> Yes
							<input type="radio" name="site_sitemap_ignore_folder" value="N" {if $TheSite.site_sitemap_ignore_folder == 'N'}checked=checked{/if} /> No
						</td>
					</tr>
					<tr>
						<th> API Login </th>
						<td> <input type="text" name="site_api_login" value="{$TheSite.site_api_login|escape:'html'}" size="40" /> </td>
					</tr>
					<tr>
						<th> API Key </th>
						<td> {$TheSite.site_api_key|escape:'html'} </td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="site_id" value="{$TheSite.site_id}" />
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
