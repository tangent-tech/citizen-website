{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">Member List &nbsp; 
	<a href="member_export.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-disk"></span>Export</a>
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="user_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> Permission
		</a>
	{/if}	
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>

</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<a href="member_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Member</a> <br />
	<form name="FrmEditBlock" id="FrmEditBlock" method="get">
		<input type="text" name="SearchKey" />
		<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
			<span class="ui-icon ui-icon-search"></span> Find User
		</a>
	</form>
	{if $smarty.request.SearchKey != null}<p>Search Result for <strong>{$smarty.request.SearchKey}</strong></p><br />{/if}
	<table id="MemberTable" class="TopHeaderTable ui-helper-reset AlignCenter">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th width="250">Username</th>
			<th width="150">Email</th>
			<th width="150">Name 1</th>
			<th width="150">Name 2</th>
			<th width="160">Note</th>
			{if $UserFieldsShow.user_security_level == 'Y'}<th width="50">Security Level</th>{/if}
			<th>Action</th>
		</tr>
		{if $Users|@count == 0}
			<tr class="nodrop nodrag">
				<td colspan="7">No members.</td>
			</tr>
		{/if}
		{foreach from=$Users item=U}
			<tr class="{if $U.user_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$U.user_id}</td>
				<td>{$U.user_username}</td>
				<td>{$U.user_email}</td>
				<td>{$U.user_first_name}</td>
				<td>{$U.user_last_name}</td>
				<td>{$U.user_note|truncate:80:"..."}</td>
				{if $UserFieldsShow.user_security_level == 'Y'}<td>{$U.user_security_level}</td>{/if}
				<td class="AlignCenter">
					<a href="member_edit.php?id={$U.user_id}&page_id={$smarty.request.page_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="member_delete.php?id={$U.user_id}&page_id={$smarty.request.page_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n ALL ORDERS made by this user will also be DELETED!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')">
						<span class="ui-icon ui-icon-trash"></span> Delete
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="member_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Member</a> <br />
	<form name="FrmEditBlock" id="FrmEditBlock" method="get">
		<input type="text" name="SearchKey" />
		<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
			<span class="ui-icon ui-icon-search"></span> Find User
		</a>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
