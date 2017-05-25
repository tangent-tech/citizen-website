{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">新增{$Site.site_label_product|ucwords} &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords}結構樹
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_add_act.php">
		<div id="ProductTabs">
			<ul>
				<li><a href="#ProductTabsPanel-CommonData">一般資料</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#ProductTabsPanel-Permission">權限</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>{$Site.site_label_product|ucwords}分類</th>
							<td>
								<select name="parent_object_id">
									{foreach from=$ProductRoots item=PC}
										<option {if $Product.parent_object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
									{/foreach}								
									{foreach from=$ProductCatList item=PC}
										<option {if $ObjectLink.object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
									{/foreach}
								</select>
							</td>
						</tr>
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th> 參考名稱 </th>
							<td> <input type="text" name="object_name" value="{$Product.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> 縮圖 </th>
							<td>
								{if $Product.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Product.object_thumbnail_file_id}" />
									<br />
								{/if}
								<input type="file" name="product_file" />
							</td>
						</tr>
						{if $ProductCatFieldsShow.product_category_no_of_group_media_fields == 'Y'}
							{if $ProductCat.product_category_no_of_group_media_fields > 0}
								{for $i=1 to $ProductCat.product_category_no_of_group_media_fields}
									{assign var='product_group_media_def_field' value="product_category_group_media_field_name_`$i`"}
									{assign var='product_group_media_file_field' value="product_group_media_file_`$i`"}
									<tr>
										<th>{$ProductCatData[$SiteLanguageRoots[0]['language_id']][$product_group_media_def_field]}</th>
										<td>
											{if $Product[$product_group_media_file_field] != 0}
												<img class="MediaSmallFile" src="{$smarty.const.BASEURL}/getfile.php?id={$Product[$product_group_media_file_field]}" /> <br />
												<input type="checkbox" name="remove_{$product_group_media_file_field}" value="Y" /> 刪除 <br />
											{/if}
											<input type="file" name="{$product_group_media_file_field}" />
										</td>
									</tr>
								{/for}
							{/if}
						{/if}												
						{if $Site.site_product_stock_level_enable == 'Y'}
							<tr>
								<th> 庫存 </th>
								<td><input type="text" size="90" name="product_stock_level" value="{$Product.product_stock_level|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_code != 'N'}
							<tr>
								<th>{$Site.site_label_product|ucwords}編碼</th>
								<td><input type="text" size="90" name="product_code" value="{$Product.product_code|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.factory_code != 'N'}
							<tr>
								<th> 廠商編號 </th>
								<td><input type="text" size="90" name="factory_code" value="{$Product.factory_code|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_size != 'N'}
							<tr>
								<th> 尺碼 </th>
								<td><input type="text" size="10" name="product_size" value="{$Product.product_size|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_weight != 'N'}
							<tr>
								<th> 重量 </th>
								<td><input type="text" size="10" name="product_weight" value="{$Product.product_weight|escape:'html'}" />(克)</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_brand_id != 'N'}
							<tr>
								<th> 品牌 </th>
								<td>
									<select name="product_brand_id">
										<option value="0"></option>
										{foreach $ProductBrandList as $B}
											<option {if $Product.product_brand_id == $B.product_brand_id}selected="selected"{/if} value="{$B.product_brand_id}">{$B.object_name}</option>
										{/foreach}
									</select>
								</td>
							</tr>
						{/if}						
						{if $ProductFieldsShow.product_special_category != 'N'}
							<tr>
								<th> 特別項目 </th>
								<td>
									{foreach $ProductCatSpecialList as $PCS}
										{if $Site.site_product_category_special_max_no == $PCS@index}
											{break}
										{/if}								
										<input type="checkbox" value="Y" name="is_special_cat_{$PCS.product_category_special_no}"
											{if $PCS.is_product_below == 'Y'}
												checked="checked"
											{/if}
										/> {$PCS.object_name} &nbsp; &nbsp; &nbsp;
									{/foreach}
								</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_LWD != 'N'}
							<tr>
								<th> 尺寸</th>
								<td>
									<input type="text" name="product_L" value="{$Product.product_L}" size="3" />cm x <input type="text" name="product_W" value="{$Product.product_W}" size="3" />cm x <input type="text" name="product_D" value="{$Product.product_D}" size="3" />cm
								</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_color_id != 'N' && 1 > 2}
							<tr>
								<th>顏色 </th>
								<td>
									{foreach from=$Colors item=C name=ColorLoop}
										<span class="AdminColorBlock">
											<input type="radio" name="product_color_id" value="{$C.color_id}"
												{if $C.color_id == $Product.product_color_id}
													checked="checked"
												{/if}
											/>
											<img src="{$smarty.const.BASEURL}../images/color_icons/{$C.color_image_url}" /> {$C.color_name}
										</span>
										{if $smarty.foreach.ColorLoop.index % 5 == 0}
											<br />
										{/if}
									{/foreach}
								</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_color_id != 'N'}
							<tr>
								<th> 顏色 </th>
								<td>
									<input name="product_rgb" type="color" value="#{$Product.product_rgb_r|string_format:"%02x"}{$Product.product_rgb_g|string_format:"%02x"}{$Product.product_rgb_b|string_format:"%02x"}" data-hex="true" />
								</td>
							</tr>
						{/if}
						{section name=foo start=0 loop=9 step=1}
							{assign var='myfield' value="product_price`$smarty.section.foo.iteration`"}
							{if $ProductCustomFieldsDef.$myfield != ''}
								<tr>
									<th colspan="2"><hr /></th>
								</tr>
								{assign var='ProductPriceRow' value=$ProductPriceList[$smarty.section.foo.iteration]}
								{if $Site.site_module_bonus_point_enable == 'Y'}
									<tr>
										<th> 積分獎賞 </th>
										<td> <input type="text" name="product_bonus_point_amount[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.product_bonus_point_amount}" size="90" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> {$ProductCustomFieldsDef.$myfield} </th>
									<td>
										$<input type="text" name="product_price[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.product_price}" />
										{if $Site.site_product_price_version >= 2}
											需要積分 <input type="text" name="product_bonus_point_required[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.product_bonus_point_required}" />
										{/if}
									</td>
								</tr>
								{if $ProductFieldsShow.product_discount != 'N'}
									{if $smarty.section.foo.iteration == 1 || $Site.site_product_price_version >= 2}
										<tr>
											<th>折扣</th>
											<td>
												<table>
													<tr>
														<td>
															<input type="radio" class="discount_type" name="discount_type[{$smarty.section.foo.iteration}]" value="0" {if $ProductPriceRow.discount_type == 0}checked="checked"{/if} /> 無折扣 <br />
															<input type="radio" class="discount_type" name="discount_type[{$smarty.section.foo.iteration}]" value="1" {if $ProductPriceRow.discount_type == 1}checked="checked"{/if} /> <input type="text" name="discount1_off_p[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.discount1_off_p}" maxlength="2" size="2" />% 扣減 <br />
															<input type="radio" class="discount_type" name="discount_type[{$smarty.section.foo.iteration}]" value="2" {if $ProductPriceRow.discount_type == 2}checked="checked"{/if} /> $<input type="text" name="discount2_price[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.discount2_price}"  maxlength="5" size="5" /> <input type="text" name="discount2_amount[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.discount2_amount}" maxlength="2" size="2" />件 <br />
															<input type="radio" class="discount_type" name="discount_type[{$smarty.section.foo.iteration}]" value="3" {if $ProductPriceRow.discount_type == 3}checked="checked"{/if} /> 買<input type="text" name="discount3_buy_amount[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.discount3_buy_amount}" maxlength="2" size="2" />送<input type="text" name="discount3_free_amount[{$smarty.section.foo.iteration}]" value="{$ProductPriceRow.discount3_free_amount}" maxlength="2" size="2" /><br />
														</td>
														<td>
															<input type="radio" class="discount_type" name="discount_type[{$smarty.section.foo.iteration}]" value="4" {if $ProductPriceRow.discount_type == 4}checked="checked"{/if} /> 價格水平
															<div class="ProductPriceLevelContainer">
																<table class="TopHeaderTable AlignLeft">
																	<tr class="ui-state-highlight">
																		<th class="AlignLeft"><a class="AddMoreProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
																		<th class="AlignLeft">最少數量</th>
																		<th class="AlignLeft">價錢</th>
																	</tr>
																	<tr>
																		<td class="AlignLeft"></td>
																		<td>0<input type="hidden" name="product_price_level_min{$smarty.section.foo.iteration}[]" value="0" /></td>
																		<td><input type="text" name="product_price_level_price{$smarty.section.foo.iteration}[]" value="{$ProductPriceRow['ProductPriceLevel'][0].product_price_level_price}" /></td>
																	</tr>
																	{foreach from=$ProductPriceRow['ProductPriceLevel'] item=L}
																		{if $L.product_price_level_min != 0}
																			<tr>
																				<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																				<td><input type="text" name="product_price_level_min{$smarty.section.foo.iteration}[]" value="{$L.product_price_level_min}" /></td>
																				<td><input type="text" name="product_price_level_price{$smarty.section.foo.iteration}[]" value="{$L.product_price_level_price}" /></td>
																			</tr>
																		{/if}
																	{/foreach}
																	<tr class="ProductPriceLevelInput Hidden">
																		<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																		<td><input type="text" name="product_price_level_min{$smarty.section.foo.iteration}[]" /></td>
																		<td><input type="text" name="product_price_level_price{$smarty.section.foo.iteration}[]" /></td>
																	</tr>
																</table>
															</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									{/if}
								{/if}
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_int_`$smarty.section.foo.iteration`"}
							{if $ProductCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Product.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_double_`$smarty.section.foo.iteration`"}
							{if $ProductCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Product.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_date_`$smarty.section.foo.iteration`"}
							{if $ProductCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$Product.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$Product.$myfield}</td>
								</tr>							
							{/if}
						{/section}
					</table>
				</div>
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="ProductTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_add.tpl"}
				</div>
			{/if}			
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> 搜索引擎友好網址 </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$ProductData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> meta 標題 </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$ProductData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> meta 描述 </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$ProductData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> meta 關鍵字 </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$ProductData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}							
							{if $ProductCatFieldsShow.product_category_no_of_group_text_fields == 'Y'}
								{if $ProductCat.product_category_no_of_group_text_fields > 0}
									{for $i=1 to $ProductCat.product_category_no_of_group_text_fields}
										{assign var='productgrouptextfield' value="product_category_group_text_field_name_`$i`"}
										{assign var='producttextfield' value="product_group_text_field_`$i`"}
										<tr>
											<th>{$ProductCatData[$R.language_id][$productgrouptextfield]}</th>
											<td><input type="text" name="{$producttextfield}[{$R.language_id}]" value="{$ProductData[$R.language_id][$producttextfield]}" size="90" maxlength="255" />
											</td>
										</tr>
									{/for}
								{/if}
							{/if}							
							{if $ProductFieldsShow.product_name != 'N'}
								<tr>
									<th>{$Site.site_label_product|ucwords}名稱</th>
									<td>
										<textarea name="product_name[{$R.language_id}]" cols="80" rows="3">{$ProductData[$R.language_id].product_name}</textarea>
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_color != 'N'}
								<tr>
									<th>顏色</th>
									<td>
										<input type="text" class="ProductColor" name="product_color[{$R.language_id}]" value="{$ProductData[$R.language_id].product_color}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_packaging != 'N'}
								<tr>
									<th>包裝</th>
									<td>
										<input type="text" name="product_packaging[{$R.language_id}]" value="{$ProductData[$R.language_id].product_packaging}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_desc != 'N'}
								<tr>
									<th>{$Site.site_label_product|ucwords}描述</th>
									<td>
										{$EditorHTML[$R.language_id]}
									</td>
								</tr>
							{/if}
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="product_custom_text_`$smarty.section.foo.iteration`"}
								{if $ProductCustomFieldsDef.$myfield != ''}
									{if substr($ProductCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
										<tr>
											<th>{substr($ProductCustomFieldsDef.$myfield, 5)}</th>
											<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$ProductData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
										</tr>
									{else if substr($ProductCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
										<tr>
											<th>{substr($ProductCustomFieldsDef.$myfield, 5)}</th>
											<td><textarea name="{$myfield}[{$R.language_id}]" cols="80" rows="8">{$ProductData[$R.language_id].$myfield|escape:'html'}</textarea></td>
										</tr>
									{else if substr($ProductCustomFieldsDef.$myfield, 0, 5) == 'HTML_'}
										<tr>
											<th>{substr($ProductCustomFieldsDef.$myfield, 5)}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{else}
										<tr>
											<th>{$ProductCustomFieldsDef.$myfield}</th>
											<td>{$CustomFieldsEditorHTML[$R.language_id][$smarty.section.foo.iteration]}</td>
										</tr>
									{/if}
								{/if}
							{/section}						
							{if $ProductFieldsShow.product_tag != 'N'}
								<tr>
									<th>標籤</th>
									<td>
										<p>請以逗號(,)分隔</p>
										<input type="text" name="product_tag[{$R.language_id}]" value="{$ProductData[$R.language_id].product_tag|substr:2:-2|escape:'html'}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
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