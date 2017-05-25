{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Album List &nbsp;
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="album_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> Permission
		</a>
	{/if}
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
	{if $ObjectFieldsShow.object_seo_tab == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="album_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> SEO
		</a>
	{/if}
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="AlbumListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">ID</th>
			<th width="300">Album Name</th>
			<th width="260">Action</th>
		</tr>
		{foreach from=$Albums item=A}
			<tr id="Album-{$A.album_id}" class="AlignCenter {if $A.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$A.album_id}</td>
				<td>
					{if $A.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$A.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
					{$A.object_name|escape:'html'}
				</td>
				<td>
					<a href="album_edit.php?link_id={$A.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="album_delete.php?id={$A.album_id}" onclick="return DoubleConfirm('WARNING!\n All media in this album will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
					<a href="media_list.php?id={$A.album_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-calculator"></span> media list
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="album_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Album</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
