{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">Site List &nbsp;</h1>
<table class="TopHeaderTable">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">ID</th>
		<th class="AlignCenter" width="200">Site Name</th>
		<th class="AlignCenter" width="200">URL</th>
		<th class="AlignCenter" width="200">Static Pages Generation</th>
		<th></th>
	</tr>
	{foreach from=$SiteList item=S}
		<tr id="SiteRow{$S.site_id}" class="{if $S.site_is_enable == 'N'}DisabledRow{/if}">
			<td class="AlignCenter">{$S.site_id}</td>
			<td class="AlignCenter">{$S.site_name|escape:'html'}</td>
			<td class="AlignCenter"><a target="_blank" href="http://{$S.site_address|escape:'html'}">http://{$S.site_address|escape:'html'}</a></td>
			<td class="AlignCenter">
				{if $S.site_generate_link_status == 'idle' || $S.site_generate_link_status == 'job_done'}
					<a href="site_generate_static_pages.php?site_id={$S.site_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n Generate Static Pages?', 'WARNING!\nAre you 100% sure?')">
						<span class="ui-icon ui-icon-circle-triangle-e"></span> Generate Static Pages
					</a>
				{else}
					{$S.site_generate_link_status}
				{/if}
				<br />
				({$S.site_generate_link_no_of_files} files on {$S.site_generate_datetime})
			</td>
			<td>
				<a href="site_edit.php?site_id={$S.site_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-pencil"></span> Edit
				</a>
				<a href="site_delete.php?site_id={$S.site_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n All objects in this site will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')">
					<span class="ui-icon ui-icon-trash"></span> Delete
				</a>
			</td>
		</tr>
	{/foreach}
</table>
<br class="clearfloat" />
<a href="site_add.php" class="ui-state-default ui-corner-all MyButton">
	<span class="ui-icon ui-icon-circle-plus"></span> Add Site
</a>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
