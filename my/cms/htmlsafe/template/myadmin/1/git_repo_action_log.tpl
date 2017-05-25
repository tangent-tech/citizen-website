{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Git Repo List &nbsp;</h1>
<table class="TopHeaderTable">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">ID</th>
		<th class="AlignCenter" width="">Git Action Type</th>
		<th class="AlignCenter" width="">Create Date</th>
		<th class="AlignCenter" width="">Finish Date</th>
		<th class="AlignCenter" width="">Output</th>
	</tr>
	{foreach $ActionLog as $A}
		<tr>
			<td class="AlignCenter">{$A.git_action_queue_id}</td>
			<td class="AlignCenter">{$A.git_action_type}</td>
			<td class="AlignCenter">{$A.git_action_create_date}</td>
			<td class="AlignCenter">{$A.git_action_finish_date}</td>
			<td class="AlignCenter">{$A.git_action_output|nl2br}</td>
		</tr>
	{/foreach}
</table>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
