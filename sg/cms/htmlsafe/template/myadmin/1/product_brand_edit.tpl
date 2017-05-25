{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Brand (id: {$ProductBrand.product_brand_id}) &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Brand List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_brand_edit_act.php">
		<div id="ProductBrandTabs">
			<ul>
				<li><a href="#ProductBrandTabsPanel-CommonData">Common Data</a></li>
				<li><a href="#ProductBrandTabsPanel-SEO">SEO</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductBrandTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductBrandTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="{$ProductBrand.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								{if $ProductBrand.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$ProductBrand.object_thumbnail_file_id}" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail <br />									
								{/if}
								<input type="file" name="product_brand_file" />
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_int_`$smarty.section.foo.iteration`"}
							{if $ProductBrandCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductBrandCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$ProductBrand.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_double_`$smarty.section.foo.iteration`"}
							{if $ProductBrandCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductBrandCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$ProductBrand.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_date_`$smarty.section.foo.iteration`"}
							{if $ProductBrandCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductBrandCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$ProductBrand.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$ProductBrand.$myfield}</td>
								</tr>							
							{/if}
						{/section}
					</table>
				</div>
			</div>
			<div id="ProductBrandTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_add.tpl"}
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductBrandTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ProductBrandFieldsShow.product_brand_name != 'N'}
								<tr>
									<th>Brand Name</th>
									<td>
										<textarea name="product_brand_name[{$R.language_id}]" cols="80" rows="3">{$ProductBrandData[$R.language_id].product_brand_name}</textarea>
									</td>
								</tr>
							{/if}
							{if $ProductBrandFieldsShow.product_desc != 'N'}
								<tr>
									<th>Brand Description</th>
									<td>
										{$EditorHTML[$R.language_id]}
									</td>
								</tr>
							{/if}
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="product_brand_custom_text_`$smarty.section.foo.iteration`"}
								{if $ProductBrandCustomFieldsDef.$myfield != ''}
									{if substr($ProductBrandCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($ProductBrandCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$ProductBrandData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($ProductBrandCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($ProductBrandCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield}[{$R.language_id}]" cols="80" rows="8">{$ProductBrandData[$R.language_id].$myfield|escape:'html'}</textarea></td>
										</tr>
									{else if substr($ProductBrandCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
										<tr>
											<th>{substr($ProductBrandCustomFieldsDef.$myfield, 5)}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{else}
										<tr>
											<th>{$ProductBrandCustomFieldsDef.$myfield}</th>
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

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
