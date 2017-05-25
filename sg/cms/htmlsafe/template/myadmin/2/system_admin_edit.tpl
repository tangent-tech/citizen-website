{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">Edit System Admin &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="system_admin_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="system_admin_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> System Admin List
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">System Admin Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="system_admin_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th>Status</th>
						<td>
							<input type="radio" name="system_admin_is_enable" value="Y" {if $TheSystemAdmin.system_admin_is_enable == 'Y'}checked=checked{/if} /> Enable 
							<input type="radio" name="system_admin_is_enable" value="N" {if $TheSystemAdmin.system_admin_is_enable == 'N'}checked=checked{/if} /> Disable						
						</td>
					</tr>
					<tr>
						<th> Email </th>
						<td> <input type="text" name="email" value="{$TheSystemAdmin.email|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> Password </th>
						<td> <input type="password" name="password1" /> </td>
					</tr>
					<tr>
						<th> Retype Password</th>
						<td> <input type="password" name="password2" /> </td>
					</tr>
					<tr>
						<th> Security Level </th>
						<td> <input type="text" name="system_admin_security_level" value="{$TheSystemAdmin.system_admin_security_level}" /> </td>
					</tr>
					<tr>
						<th> SSH Public Key (Make sure this is one line)</th>
						<td> <input type="text" name="ssh_public_key" value="{$TheSystemAdmin.ssh_public_key|escape:'html'}" /> </td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="id" value="{$TheSystemAdmin.system_admin_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<br />
			<div id="SiteListContainer">
				<h2>Site List</h2>
				<table class="TopHeaderTable">
					<tr class="ui-state-highlight">
						<th class="AlignCenter">ID</th>
						<th class="AlignCenter" width="200">Site Name</th>
						<th class="AlignCenter" width="200">URL</th>
						<th></th>
					</tr>
					{foreach from=$SiteListOption item=S}
						<tr>
							<td class="AlignCenter">{$S.site_id}</td>
							<td class="AlignCenter">{$S.site_name|escape:'html'}</td>
							<td class="AlignCenter"><a target="_blank" href="http://{$S.site_address|escape:'html'}">http://{$S.site_address|escape:'html'}</a></td>
							<td>
								<input type="radio" name="SiteAdminAllowedOption[{$S.site_id}]" value="ON" {if $S.system_admin_id != null}checked=checked{/if} /> Allow 
								<input type="radio" name="SiteAdminAllowedOption[{$S.site_id}]" value="OFF" {if $S.system_admin_id == null}checked=checked{/if} /> Disallow 
							</td>
						</tr>
					{/foreach}
				</table>
			</div>
			<div id="GitListContainer">
				<h2>Git List</h2>
				<table class="TopHeaderTable">
					<tr class="ui-state-highlight">
						<th class="AlignCenter">ID</th>
						<th class="AlignCenter" width="200">Git Name</th>
						<th></th>
					</tr>
					{foreach from=$GitListOption item=G}
						<tr>
							<td class="AlignCenter">{$G.git_repo_id}</td>
							<td class="AlignCenter">{$S.git_repo_name|escape:'html'}</td>
								<input type="radio" name="GitAdminAllowedOption[{$G.git_repo_id}]" value="ON" {if $G.system_admin_id != null}checked=checked{/if} /> Allow 
								<input type="radio" name="GitAdminAllowedOption[{$G.git_repo_id}]" value="OFF" {if $G.system_admin_id == null}checked=checked{/if} /> Disallow 
							</td>
						</tr>
					{/foreach}
				</table>
			</div>
			<br class="clearfloat" />
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
