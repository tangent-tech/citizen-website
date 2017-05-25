{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Media &nbsp;
	{if $smarty.request.refer == 'product_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_edit.php?link_id={$smarty.request.link_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Product
		</a>
	{elseif $smarty.request.refer == 'product_category_special_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_category_special_edit.php?link_id={$smarty.request.link_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Product Special Category
		</a>
	{elseif $smarty.request.refer == 'product_category_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_category_edit.php?link_id={$smarty.request.link_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Product Category
		</a>
	{elseif $smarty.request.refer == 'bonuspoint_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="bonuspoint_edit.php?id={$smarty.request.parent_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Bonus Point Item
		</a>
	{else}
		<a class="ui-state-default ui-corner-all MyButton" href="media_list.php?id={$Media.parent_object_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Media List
		</a>
	{/if}
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="media_edit_act.php">
		<div id="MediaTabs">
			<ul>
				<li><a href="#MediaTabsPanel-CommonData">Common Data</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#MediaTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="MediaTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th>Media</th>
							<td>
								{if $Media.media_small_file_id != 0}
									<a href="{$smarty.const.BASEURL}/getfile.php?id={$Media.media_big_file_id}" target="_preview"><img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Media.media_small_file_id}" /></a>
									<br />
								{/if}
								<input type="file" name="media_file" /> <br />
								<input type="checkbox" name="update_thumbnail_only" value="Y" /> Update thumbnail only
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_int_`$smarty.section.foo.iteration`"}
							{if $MediaCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MediaCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Media.$myfield|escape:'html'}" size="80" /></td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_double_`$smarty.section.foo.iteration`"}
							{if $MediaCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MediaCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Media.$myfield|escape:'html'}" size="80" /></td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_date_`$smarty.section.foo.iteration`"}
							{if $MediaCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MediaCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$Media.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$Media.$myfield}</td>
								</tr>
							{/if}
						{/section}
					</table>
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="MediaTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$MediaData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$MediaData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$MediaData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$MediaData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}							
							<tr>
								<th>Media Description</th>
								<td><input type="text" name="media_desc[{$R.language_id}]" value="{$MediaData[$R.language_id].media_desc|escape:'html'}" size="90" maxlength="255" /></td>
							</tr>
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="media_custom_text_`$smarty.section.foo.iteration`"}
								{if $MediaCustomFieldsDef.$myfield != ''}
									{if substr($MediaCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($MediaCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$MediaData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($MediaCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($MediaCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield}[{$R.language_id}]" cols="80" rows="8">{$MediaData[$R.language_id].$myfield|escape:'html'}</textarea></td>
										</tr>
									{else if substr($MediaCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
										<tr>
											<th>{substr($MediaCustomFieldsDef.$myfield, 5)}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{else}
										<tr>
											<th>{$MediaCustomFieldsDef.$myfield}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{/if}
								{/if}
							{/section}
						</table>
					</div>
			   </div>
			{/foreach}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
			<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}" />
			<input type="hidden" name="refer" value="{$smarty.request.refer}" />
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
