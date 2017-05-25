{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯{$Site.site_label_product|ucwords}分類 (編號: {$ProductCat.object_id})&nbsp;
{if $IsProductCatRemovable}
	<a onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="product_category_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
{else}
	<a onclick="return DoubleConfirm('警告！\n 所有在此分類中的分類和項目都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="product_category_delete_recursive.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords}結構樹
	</a>

	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> 顯示/隱藏縮略圖
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_category_edit_act.php">
		<div id="ProductCatTabs">
			<ul>
				<li><a href="#ProductCatTabsPanel-CommonData">一般資料</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#ProductCatTabsPanel-Permission">權限</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductCatTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductCatTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{for $i =1 to 9}
							{if $ProductCustomFieldsDef["product_price`$i`"] != ''}
								{foreach $ProductCatPriceRangeList as $R}
									<tr>
										<th> {$ProductCustomFieldsDef["product_price`$i`"]} Range </th>
										<td>{$R['currency_shortname']} {$R["product_category_price`$i`_range_min"]|number_format:$R['currency_precision']} - {$R['currency_shortname']} {$R["product_category_price`$i`_range_max"]|number_format:$R['currency_precision']}</td>
									</tr>							
								{/foreach}						
							{/if}
						{/for}
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> 參考名稱 </th>
							<td> <input type="text" name="object_name" value="{$ProductCat.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>縮圖</th>
							<td>
								{if $ProductCat.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$ProductCat.object_thumbnail_file_id}" />
									<br />
								{/if}
								<input type="file" name="thumbnail_file" />
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_int_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$ProductCat.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_double_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$ProductCat.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_date_`$smarty.section.foo.iteration`"}
							{if $ProductCategoryCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCategoryCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$ProductCat.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$ProductCat.$myfield}</td>
								</tr>		
							{/if}
						{/section}
						{if $ProductCatFieldsShow.product_category_group_fields == 'Y' && $NoOfSubCat == 0}
							{section name=foo start=0 loop=9 step=1}
								{assign var='myfield' value="product_category_group_field_name_`$smarty.section.foo.iteration`"}
								<tr>
									<th>Grouping Field {$smarty.section.foo.iteration}</th>
									<td>
										<select name="product_category_group_field_name[{$smarty.section.foo.iteration}]">
											{foreach $ProductCategoryGroupValidFields as $key => $value}
												<option value="{$key}" {if $ProductCat.$myfield == $key}selected="selected"{/if}>{$value}</option>
											{/foreach}
										</select>
									</td>
								</tr>							
							{/section}							
						{/if}
					</table>
				</div>
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="ProductCatTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductCatTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> 搜索引擎友好網址 </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$ProductCatData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> meta 標題 </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$ProductCatData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> meta 描述 </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$ProductCatData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> meta 關鍵字 </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$ProductCatData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}
							<tr>
								<th>{$Site.site_label_product|ucwords}分類名稱</th>
								<td> <input type="text" name="product_category_name[{$R.language_id}]" value="{$ProductCatData[$R.language_id].product_category_name}" size="90" maxlength="255" /> </td>
							</tr>
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="product_category_custom_text_`$smarty.section.foo.iteration`"}
								{if $ProductCategoryCustomFieldsDef.$myfield != ''}
									{if substr($ProductCategoryCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($ProductCategoryCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$ProductCatData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($ProductCategoryCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($ProductCategoryCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield}[{$R.language_id}]" cols="80" rows="8">{$ProductCatData[$R.language_id].$myfield|escape:'html'}</textarea></td>
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
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="{foreach from=$SiteLanguageRoots item=R}ContentEditor{$R.language_id} {/foreach}">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>

{if $ProductCatFieldsShow.product_category_media_list == 'Y'}
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">分類媒體</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="MediaListTable-{$ProductCat.product_category_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable MediaListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">編號</th>
					<th width="250">媒體</th>
					<th>操作</th>
				</tr>
				{if $ProductCatMediaList|@count == 0}
					<tr class="nodrop nodrag">
						<td colspan="3">你可以上傳相片和影片</td>
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
							<a href="product_cat_media_set_highlight.php?link_id={$smarty.request.link_id}&id={$M.media_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-image"></span> 縮圖
							</a>
							<a href="media_edit.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_category_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯
							</a>
							<a href="media_delete.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_category_edit" onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> 刪除
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
				媒體安全等級: <input type="text" name="media_security_level" value="{$Site.site_default_security_level}" />
				<br />
				<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
				<input type="hidden" name="id" value="{$ProductCat.product_category_id}" />
				<input type="hidden" name="refer" value="product_category_edit" />
				<br />
				{if $Site.site_product_media_watermark_big_file_id != 0 || $Site.site_product_media_watermark_small_file_id != 0}
					<input type="checkbox" name="AddWatermark" checked="checked" value="Y" /> 添加水印
					<br />
				{/if}
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-circle-plus"></span> 新增媒體
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddPhoto">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</form>		
		</div>
	</div>
{/if}

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords}及分類</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table id="ObjectListTable" class="TopHeaderTable ui-helper-reset SortTable">
			<tr class="ui-state-highlight nodrop nodrag">
				<th></th>
				<th width="50">編號</th>
				<th width="150">類型</th>
				<th width="200">參考名稱</th>
				<th width="100">操作</th>
			</tr>
			{foreach from=$ChildObjects item=O}
				<tr id="Object-{$O.object_link_id}" class="AlignCenter {if $O.object_is_enable == 'N'}DisabledRow{/if}">
					<td>
						{if $O.object_thumbnail_file_id != 0}
							<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$O.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
						{/if}
					</td>
					<td>{$O.object_id}</td>
					<td>{if $O.object_type == 'PRODUCT'}{$Site.site_label_product|ucwords}{elseif $O.object_type == 'PRODUCT_CATEGORY'}分類{/if}</td>
					<td>
					{*
						{if $O.object_thumbnail_file_id != 0}
							<img class="MediaSmallFile" {if $Site.site_media_small_width > 40}width="{$Site.site_media_small_width}"{else}width="40"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$O.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
						{/if}
					*}
						{$O.object_name|escape:'html'}
					</td>
					<td>
						{if $O.object_type == 'PRODUCT'}
							<a href="product_edit.php?link_id={$O.object_link_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯
							</a>
						{elseif $O.object_type == 'PRODUCT_CATEGORY'}
							<a href="product_category_edit.php?link_id={$O.object_link_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯
							</a>
						{/if}
					</td>
				</tr>
			{/foreach}
		</table>
		<a href="product_add.php?link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增{$Site.site_label_product|ucwords}</a>
	</div>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
