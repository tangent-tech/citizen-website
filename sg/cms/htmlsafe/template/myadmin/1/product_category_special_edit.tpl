{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit {$Site.site_label_product|ucwords} Special Category ({$ProductCatSpecial.object_id}) &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree_special.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords} Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_category_special_edit_act.php">
		<div id="ProductCatSpecialTabs">
			<ul>
				<li><a href="#ProductCatSpecialTabsPanel-CommonData">Common Data</a></li>
				{if $ObjectFieldsShow.object_seo_tab == 'Y'}
					<li><a href="#ProductCatSpecialTabsPanel-SEO">SEO</a></li>
				{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductCatSpecialTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductCatSpecialTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="{$ProductCatSpecial.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								{if $ProductCatSpecial.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$ProductCatSpecial.object_thumbnail_file_id}" />
									<br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail
									<br />
								{/if}
								<input type="file" name="thumbnail_file" />
							</td>
						</tr>						
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_int_`$smarty.section.foo.iteration`"}
							{assign var='myvalfield' value="product_category_special_custom_int_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myvalfield}" value="{$ProductCatSpecial.$myvalfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_double_`$smarty.section.foo.iteration`"}
							{assign var='myvalfield' value="product_category_special_custom_double_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myvalfield}" value="{$ProductCatSpecial.$myvalfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_date_`$smarty.section.foo.iteration`"}
							{assign var='myvalfield' value="product_category_special_custom_date_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myvalfield}" class="DatePicker" value="{$ProductCatSpecial.$myvalfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=myvalfield use_24_hours=true display_seconds=false time=$ProductCatSpecial.myvalfield}</td>
								</tr>							
							{/if}
						{/section}
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="ProductCatSpecialTabsPanel-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductCatSpecialTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>{$Site.site_label_product|ucwords} Special Category Name</th>
								<td> <input type="text" name="product_category_special_name[{$R.language_id}]" value="{$ProductCatSpecialData[$R.language_id].product_category_special_name}" size="90" maxlength="255" /> </td>
							</tr>
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="product_category_custom_text_`$smarty.section.foo.iteration`"}
								{assign var='myfield2' value="product_category_special_custom_text_`$smarty.section.foo.iteration`"}
								{if $ProductCategoryCustomFieldsDef.$myfield != ''}
									{if substr($ProductCategoryCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($ProductCategoryCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield2}[{$R.language_id}]" value="{$ProductCatSpecialData[$R.language_id].$myfield2|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($ProductCategoryCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($ProductCategoryCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield2}[{$R.language_id}]" cols="80" rows="8">{$ProductCatSpecialData[$R.language_id].$myfield2|escape:'html'}</textarea></td>
										</tr>
									{else if substr($ProductCategoryCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
										<tr>
											<th>{substr($ProductCategoryCustomFieldsDef.$myfield, 5)}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{else}
										<tr>
											<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
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
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="{foreach from=$SiteLanguageRoots item=R}ContentEditor{$R.language_id} {/foreach}">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>

{if $ProductCatFieldsShow.product_category_media_list == 'Y'}
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords} Special Category Media</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="MediaListTable-{$ProductCatSpecial.product_category_special_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable MediaListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">ID</th>
					<th width="250">Media</th>
					<th>Action</th>
				</tr>
				{if $ProductCatMediaList|@count == 0}
					<tr class="nodrop nodrag">
						<td colspan="3">You may upload photos and video here.</td>
					</tr>
				{/if}
				{foreach from=$ProductCatMediaList item=M}
					<tr id="Media-{$M.media_id}" class="{if $M.object_is_enable == 'N'}DisabledRow{/if}">
						<td class="AlignCenter">{$M.media_id}</td>
						<td>
							{if $M.media_small_file_id != 0}
								<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview"><img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}getfile.php?id={$M.media_small_file_id}" /><br class="MediaSmallFile" />{$M.filename}</a>
							{else}
								<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview">{$M.filename}</a>
							{/if}
						</td>
						<td class="AlignCenter">
							<a href="product_cat_media_set_highlight.php?link_id={$smarty.request.link_id}&id={$M.media_id}&refer=product_category_special_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-image"></span> thumbnail
							</a>
							<a href="media_edit.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_category_special_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="media_delete.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_category_special_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<form enctype="multipart/form-data" name="FrmAddPhoto" id="FrmAddPhoto" method="post" action="media_add_act.php">
				<input type="file" name="media[]" multiple="true" />
				<input type="file" name="media[]" multiple="true" />
				<input type="file" name="media[]" multiple="true" /> <br />
				<br />
				Media Security Level: <input type="text" name="media_security_level" value="{$Site.site_default_security_level}" />
				<br />
				<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
				<input type="hidden" name="id" value="{$ProductCatSpecial.product_category_special_id}" />
				<input type="hidden" name="refer" value="product_category_special_edit" />
				<br />
				<input type="checkbox" name="UpdateThumbnailOnly" value="Y" /> Update Thumbnail Only <br />
				<br />			
				{if $Site.site_product_media_watermark_big_file_id != 0 || $Site.site_product_media_watermark_small_file_id != 0}
					<input type="checkbox" name="AddWatermark" checked="checked" value="Y" /> Add watermark
					<br />
				{/if}
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-circle-plus"></span> Add Media
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</form>		
		</div>
	</div>
{/if}
					
					
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="ObjectListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">ID</th>
			<th width="150">Type</th>
			<th width="200">Reference Name</th>
			<th width="170">Action</th>
		</tr>
		{foreach from=$ChildObjects item=O}
			<tr id="Object-{$O.object_link_id}" class="AlignCenter {if $O.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$O.object_id}</td>
				<td>{if $O.object_type == 'PRODUCT'}Product{elseif $O.object_type == 'PRODUCT_CATEGORY'}Category{/if}</td>
				<td>
				{*
					{if $O.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_media_small_width > 40}width="{$Site.site_media_small_width}"{else}width="40"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$O.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
				*}
					{$O.object_name|escape:'html'}
				</td>
				<td>
					<a href="product_edit.php?link_id={$O.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="product_category_special_remove_product.php?link_id={$O.object_link_id}&cat_link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-circle-minus"></span> remove
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
