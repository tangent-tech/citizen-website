{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Edit Git Repo &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="git_repo_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Git Repo List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Git Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="git_repo_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th colspan="2" class="ui-state-highlight AlignCenter">
							Linux User must be unique <br />
							*** If you updated this field, it will not update immediately. Watch for the action log to see if it finished. DO NOT double submit.
						</th>
					</tr>
					<tr>
						<th>
							Git Repo Name <br />
							(recommend to use domain name) <br />
						</th>
						<td> <input type="text" name="git_repo_name" value="{$GitRepoInfo.git_repo_name}" size="50" /> </td>
					</tr>
					<tr>
						<th> *** Linux User (e.g. web123) </th>
						<td> <input type="text" name="git_repo_linux_user" value="{$GitRepoInfo.git_repo_linux_user}" size="50" {if !$IsSuperAdmin}disabled="disabled"{/if} /> </td>
					</tr>
					<tr>
						<th> Auto Deploy On Push</th>
						<td>
							<input type="radio" name="git_repo_auto_deploy_on_push" value="Y" {if $GitRepoInfo.git_repo_auto_deploy_on_push == 'Y'}checked=checked{/if} /> Yes
							<input type="radio" name="git_repo_auto_deploy_on_push" value="N" {if $GitRepoInfo.git_repo_auto_deploy_on_push == 'N'}checked=checked{/if} /> No
						</td>
					</tr>
					<tr>
						<th> Git URL <br /> (Copy this to Netbean) </th>
						<td>{$GitURL}</td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="git_repo_id" value="{$smarty.request.git_repo_id}" />
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

<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Git Deploy List</h2>
	<div class="InnerContent ui-widget-content">		
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th class="AlignCenter">Auto Deploy On Push</th>
				<th class="AlignCenter">ID</th>
				<th class="AlignCenter" width="200">Git Deploy Name</th>
				<th class="AlignCenter">Branch</th>
				<th class="AlignCenter" width="">Linux User</th>
				<th class="AlignCenter" width="">Last Manual Deploy</th>
				<th></th>
			</tr>
			{foreach $GitRepoDeployList as $D}
				<tr>
					<td class="AlignCenter">
						{if $D.git_repo_deploy_linux_user == null}
							{if $D.git_repo_auto_deploy_on_push == 'Y'}
								Yes
							{else}
								No
							{/if}
						{else}
							-
						{/if}
					</td>
					<td class="AlignCenter">{$D.git_repo_deploy_id}</td>
					<td class="AlignCenter">{$D.git_repo_deploy_name}</td>
					<td class="AlignCenter">{$D.git_repo_deploy_branch}</td>
					<td class="AlignCenter">
						{if $D.git_repo_deploy_linux_user == null}
							{$D.git_repo_linux_user}
						{else}
							{$D.git_repo_deploy_linux_user}
						{/if}
					</td>
					<td class="AlignCenter">
						{if $D.git_repo_deploy_last_deploy_date == null}
							-
						{else}
							{$D.git_repo_deploy_last_deploy_date} by <br />
							{$D.email}
						{/if}
					</td>
					<td>
						{if $D.git_repo_deploy_linux_user != null && $IsSuperAdmin}
							<a href="git_repo_deploy_edit.php?git_repo_deploy_id={$D.git_repo_deploy_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> Edit
							</a>
						{/if}
						{if $D.git_repo_deploy_linux_user != null && $IsSuperAdmin}
							<a href="git_repo_deploy_delete.php?git_repo_deploy_id={$D.git_repo_deploy_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n The actual deploy content will not deleted from server!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')">
								<span class="ui-icon ui-icon-trash"></span> Delete
							</a>
						{/if}
						<a href="git_repo_deploy_do_checkout.php?git_repo_deploy_id={$D.git_repo_deploy_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('Deploy to {$D.git_repo_deploy_name}?', 'Are you 100% sure?')">
							<span class="ui-icon ui-icon-circle-arrow-e"></span> Deploy
						</a>							
					</td>
				</tr>
			{/foreach}
		</table>
		
		<br class="clearfloat" />
		{if $IsSuperAdmin}
			<a href="git_repo_deploy_add.php?git_repo_id={$smarty.request.git_repo_id}" class="ui-state-default ui-corner-all MyButton">
				<span class="ui-icon ui-icon-circle-plus"></span> Add Git Deploy Point
			</a>
		{/if}		
	</div>
</div>

{if $IsSuperAdmin}
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Access List</h2>
		<div class="InnerContent ui-widget-content">
			<table class="TopHeaderTable">
				<tr class="ui-state-highlight">
					<th class="AlignCenter" width="200">Email</th>
					<th width="200"></th>
				</tr>
				{foreach $AdminAccessList as $A}
					<tr>
						<td class="AlignCenter">
							{$A.email}
						</td>
						<td>
							<a href="system_admin_edit.php?id={$A.system_admin_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> Edit
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
	</div>	
{/if}

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
