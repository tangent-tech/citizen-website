{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">System Admin List</h1>
<table class="TopHeaderTable ui-helper-reset">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">ID</th>
		<th>Username</th>
		<th class="AlignCenter">Security Level</th>
		<th></th>
	</tr>
	{foreach from=$SystemAdmins item=S}
		<tr>
			<td class="AlignCenter">{$S.system_admin_id}</td>
			<td width="200">{$S.email|escape:'html'}</td>
			<td class="AlignCenter">{$S.system_admin_security_level}</td>
			<td>
				<a href="system_admin_edit.php?id={$S.system_admin_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-pencil"></span> Edit
				</a>
				<a href="system_admin_delete.php?id={$S.system_admin_id}" class="ui-state-default ui-corner-all MyButton" onclick="return confirm('WARNING! \n Are you sure you want to delete?')">
					<span class="ui-icon ui-icon-trash"></span> Delete
				</a>							
			</td>
		</tr>
	{/foreach}
</table>
<br class="clearfloat" />
<a href="system_admin_add.php" class="ui-state-default ui-corner-all MyButton">
	<span class="ui-icon ui-icon-circle-plus"></span> Add System Admin
</a>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
