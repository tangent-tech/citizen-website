{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">新增品牌 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_brand_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 品牌列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_brand_add_act.php">
		<div id="ProductBrandTabs">
			<ul>
				<li><a href="#ProductBrandTabsPanel-CommonData">一般資料</a></li>
				<li><a href="#ProductBrandTabsPanel-SEO">SEO</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductBrandTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductBrandTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th> 參考名稱 </th>
							<td> <input type="text" name="object_name" value="{$ProductBrand.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> 縮圖 </th>
							<td>
								{if $ProductBrand.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$ProductBrand.object_thumbnail_file_id}" />
									<br />
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
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$smarty.now}</td>
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
									<th>品牌名稱</th>
									<td>
										<textarea name="product_brand_name[{$R.language_id}]" cols="80" rows="3">{$ProductBrandData[$R.language_id].product_brand_name}</textarea>
									</td>
								</tr>
							{/if}
							{if $ProductBrandFieldsShow.product_desc != 'N'}
								<tr>
									<th>品牌描述</th>
									<td>
										{$EditorHTML[$R.language_id]}
									</td>
								</tr>
							{/if}
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="product_brand_custom_text_`$smarty.section.foo.iteration`"}
								{if $ProductBrandCustomFieldsDef.$myfield != ''}
									<tr>
										<th>{$ProductBrandCustomFieldsDef.$myfield}</th>
										<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
									</tr>
								{/if}
							{/section}
						</table>
					</div>
			   </div>
			{/foreach}
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="{foreach from=$SiteLanguageRoots item=R}ContentEditor{$R.language_id} {/foreach}">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
