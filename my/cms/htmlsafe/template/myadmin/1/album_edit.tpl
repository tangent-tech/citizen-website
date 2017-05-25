{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Album (id: {$Album.object_id}) &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="album_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Album List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="album_edit_act.php">
		<div id="AlbumTabs">
			<ul>
				<li><a href="#AlbumTabsPanel-CommonData">Reference Data</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#AlbumTabsPanel-Permission">Permission</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#AlbumTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="AlbumTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> Album Name </th>
							<td> <input type="text" name="object_name" value="{$Album.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								{if $Album.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Album.object_thumbnail_file_id}" />
									<br />
								{/if}
								<input type="file" name="album_file" />
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_int_`$smarty.section.foo.iteration`"}
							{if $AlbumCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$AlbumCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Album.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_double_`$smarty.section.foo.iteration`"}
							{if $AlbumCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$AlbumCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Album.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_date_`$smarty.section.foo.iteration`"}
							{if $AlbumCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$AlbumCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$Album.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$Album.$myfield}</td>
								</tr>							
							{/if}
						{/section}

						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_file_`$smarty.section.foo.iteration`"}
							{assign var='myfieldval' value="album_custom_file_id_`$smarty.section.foo.iteration`"}
							{if $AlbumCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$AlbumCustomFieldsDef.$myfield}</th>
									<td>
										{if $Album.$myfieldval != 0}
											<a href="{$smarty.const.BASEURL}/getfile.php?id={$Album.$myfieldval}">{$AlbumFiles[$smarty.section.foo.iteration].filename}</a> <br />
											Filesize: {$AlbumFiles[$smarty.section.foo.iteration].size/1024|string_format:"%.2f"}kb <br />
											<input type="checkbox" name="delete_{$myfield}" value="Y" /> Delete <br />
										{/if}
										<input type="file" name="{$myfield}" />
									</td>
								</tr>
							{/if}
						{/section}
					</table>
				</div>
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="AlbumTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="AlbumTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$AlbumData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$AlbumData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$AlbumData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$AlbumData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}							
							<tr>
								<th>Album Description</th>
								<td><input type="text" name="album_desc[{$R.language_id}]" value="{$AlbumData[$R.language_id].album_desc|escape:'html'}" size="90" maxlength="255" /></td>
							</tr>
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="album_custom_text_`$smarty.section.foo.iteration`"}
								{if $AlbumCustomFieldsDef.$myfield != ''}
									{if substr($AlbumCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($AlbumCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$AlbumData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($AlbumCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($AlbumCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield}[{$R.language_id}]" cols="80" rows="8">{$AlbumData[$R.language_id].$myfield|escape:'html'}</textarea></td>
										</tr>
									{else if substr($AlbumCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
										<tr>
											<th>{substr($AlbumCustomFieldsDef.$myfield, 5)}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{else}
										<tr>
											<th>{$AlbumCustomFieldsDef.$myfield}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{/if}
								{/if}
							{/section}
						</table>
					</div>
			   </div>
			{/foreach}
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
