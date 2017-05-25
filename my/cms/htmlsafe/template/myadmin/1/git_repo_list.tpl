{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Git Repo List &nbsp;</h1>
<table class="TopHeaderTable">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">ID</th>
		<th class="AlignLeft" width="200">Git Repo Name</th>
		<th class="AlignCenter" width="">Linux User</th>
		<th class="AlignCenter" width="">Auto Deploy On Push</th>
		<th class="AlignCenter" width="">No Of Deploy Points</th>
		<th></th>
	</tr>
	{foreach $GitRepoList as $G}
		<tr>
			<td class="AlignCenter">{$G.git_repo_id}</td>
			<td class="AlignLeft">{$G.git_repo_name}</td>
			<td class="AlignCenter">{$G.git_repo_linux_user}</td>
			<td class="AlignCenter">{$G.git_repo_auto_deploy_on_push}</td>
			<td class="AlignCenter">{$G.no_of_deploy}</td>
			<td>
				<a href="git_repo_edit.php?git_repo_id={$G.git_repo_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-pencil"></span> Edit
				</a>
				{if $IsSuperAdmin}
					<a href="git_repo_delete.php?git_repo_id={$G.git_repo_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n The actual GIT REPO will not deleted from server!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')">
						<span class="ui-icon ui-icon-trash"></span> Delete
					</a>
				{/if}
				<a href="git_repo_action_log.php?git_repo_id={$G.git_repo_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-script"></span> Action Log
				</a>
			</td>
		</tr>
	{/foreach}
</table>
<br class="clearfloat" />
{if $IsSuperAdmin}
	<a href="git_repo_add.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-circle-plus"></span> Add Git Repo
	</a>
{/if}
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
