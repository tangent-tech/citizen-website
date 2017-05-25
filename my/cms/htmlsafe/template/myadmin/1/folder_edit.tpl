{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Folder - {$ObjectLink.object_name|escape:'html'} (id: {$Folder.folder_id}) &nbsp;
{if $IsFolderRemovable}
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="folder_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
{else}
	<a onclick="return DoubleConfirm('WARNING!\n All corresponding pages, folders and other related objects will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="folder_delete_recursive.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id={$ObjectLink.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="folder_edit_act.php">
		<div id="FolderTabs">
			<ul>
				<li><a href="#FolderTabsPanel-FolderInfo">Folder Details</a></li>
				{if $ObjectFieldsShow.object_seo_tab == 'Y'}<li><a href="#FolderTabs-SEO">SEO</a></li>{/if}
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#FolderTabs-Permission">Permission</a></li>{/if}
			</ul>
			<div id="FolderTabsPanel-FolderInfo">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th>Thumbnail</th>
							<td>
								{if $Folder.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Folder.object_thumbnail_file_id}" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail
									<br />
								{/if}
								<input type="file" name="folder_file" />
							</td>
						</tr>
						<tr>
							<th> Folder Name </th>
							<td> <input type="text" name="object_name" value="{$ObjectLink.object_name|escape:'html'}" /> </td>
						</tr>
						<tr>
							<th> Folder Link URL </th>
							<td> <input type="text" name="folder_link_url" value="{$Folder.folder_link_url|escape:'html'}" size="80" /> </td>
						</tr>
						{section name=foo start=0 loop=$smarty.const.NO_OF_CUSTOM_RGB_FIELDS step=1}
							{assign var='myfield' value="folder_custom_rgb_`$smarty.section.foo.iteration`"}
							{assign var='myobjfield' value="object_custom_rgb_`$smarty.section.foo.iteration`"}
							{if $FolderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$FolderCustomFieldsDef.$myfield}</th>
									<td><input name="{$myobjfield}" type="color" value="#{$ObjectLink[$myobjfield]}" data-hex="true" /></td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_int_`$smarty.section.foo.iteration`"}
							{if $FolderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$FolderCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Folder.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_double_`$smarty.section.foo.iteration`"}
							{if $FolderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$FolderCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Folder.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_date_`$smarty.section.foo.iteration`"}
							{if $FolderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$FolderCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$Folder.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$Folder.$myfield}</td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_text_`$smarty.section.foo.iteration`"}
							{if $FolderCustomFieldsDef.$myfield != ''}
								{if substr($FolderCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
									<tr>
										<th>{substr($FolderCustomFieldsDef.$myfield, 5)}</th>
										<td><input type="text" name="{$myfield}" value="{$Folder.$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{else if substr($FolderCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
									<tr>
										<th>{substr($FolderCustomFieldsDef.$myfield, 5)}</th>
										<td><textarea name="{$myfield}" cols="80" rows="8">{$Folder.$myfield|escape:'html'}</textarea></td>
									</tr>
								{else if substr($FolderCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
									<tr>
										<th>{substr($FolderCustomFieldsDef.$myfield, 5)}</th>
										<td>{$CustomFieldsEditorHTML[$smarty.section.foo.iteration]}</td>
									</tr>
								{else}
									<tr>
										<th>{$FolderCustomFieldsDef.$myfield}</th>
										<td>{$CustomFieldsEditorHTML[$smarty.section.foo.iteration]}</td>
									</tr>
								{/if}

							{/if}
						{/section}
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="FolderTabs-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="FolderTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}					
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
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
