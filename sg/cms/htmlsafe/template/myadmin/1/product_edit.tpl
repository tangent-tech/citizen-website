{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit {$Site.site_label_product|ucwords} (id: {$Product.product_id})&nbsp;
{if $IsProductRemovable == true}
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="product_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
{else}
	<a href="#" class="ui-state-disabled ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords} Tree
	</a>
	{foreach $ProductParentCatAndRootList as $C}
		{if $C.object_type == 'PRODUCT_CATEGORY'}
			<a class="ui-state-default ui-corner-all MyButton" href="product_category_edit.php?link_id={$C.object_link_id}">
				<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$C.object_name}
			</a>
		{/if}		
	{/foreach}
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_edit_act.php">
		<div id="ProductTabs">
			<ul>
				<li><a href="#ProductTabsPanel-CommonData">Common Data</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#ProductTabsPanel-Permission">Permission</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
				{if $Site.site_module_order_enable == 'Y'}
				    <li><a href="#ProductTabsPanel-OrderList">Order List</a></li>
				{/if}
			</ul>
			<div id="ProductTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr class="ProductCatRow">
							<th>{$Site.site_label_product|ucwords} Categories</th>
							<td>
								<div id="ProductCatInputContainer">
									<table class="TopHeaderTable AlignLeft">
										<tr>
											<th class="AlignLeft"><a id="AddMoreProductCatLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
											<td></td>
										</tr>
										{foreach from=$ProductParentCatAndRootList item=L}
											<tr class="ProductCatInput">
												<td class="AlignLeft"><a class="RemoveProductCatLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
												<td class="AlignLeft">
													<select name="product_category_id[]">
														{foreach from=$ProductRoots item=PC}
															<option {if $L.object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
														{/foreach}
														{foreach from=$ProductCatList item=PC}
															<option {if $L.object_id == $PC.object_id}selected="selected"{/if} value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
														{/foreach}
													</select>
												</td>
											</tr>
										{/foreach}
										<tr class="ProductCatInput Hidden">
											<td class="AlignLeft"><a class="RemoveProductCatLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
											<td class="AlignLeft">
												<select name="product_category_id[-1]">
													{foreach from=$ProductRoots item=PC}
														<option value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
													{/foreach}
													{foreach from=$ProductCatList item=PC}
														<option value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
													{/foreach}
												</select>
											</td>
										</tr>
									</table>
								</div>								
							</td>
						</tr>
						<tr class="ProductGroupRow Hidden">
							<th>{$Site.site_label_product|ucwords} Group</th>
							<td>
								<select name="product_category_group_id">
									{foreach from=$ProductGroupList item=PC}
										<option value="{$PC.object_id}">{$PC.object_name} (id: {$PC.object_id})</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> Reference Name </th>
							<td> <input type="text" name="object_name" value="{$Product.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>Thumbnail</th>
							<td>
								{if $Product.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Product.object_thumbnail_file_id}" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> Remove thumbnail <br />
								{/if}
								<input type="file" name="product_file" />
							</td>
						</tr>
						{if $Site.site_product_stock_level_enable == 'Y'}
							<tr>
								<th>Stock Level </th>
								<td><input type="text" size="90" name="product_stock_level" value="{$Product.product_stock_level|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_code != 'N'}
							<tr>
								<th>{$Site.site_label_product|ucwords} Code </th>
								<td><input type="text" size="90" name="product_code" value="{$Product.product_code|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.factory_code != 'N'}
							<tr>
								<th>Factory Code </th>
								<td><input type="text" size="90" name="factory_code" value="{$Product.factory_code|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_size != 'N'}
							<tr>
								<th>{$Site.site_label_product|ucwords} Size </th>
								<td><input type="text" size="10" name="product_size" value="{$Product.product_size|escape:'html'}" /></td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_weight != 'N'}
							<tr>
								<th>Weight </th>
								<td><input type="text" size="10" name="product_weight" value="{$Product.product_weight|escape:'html'}" />(g)</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_brand_id != 'N'}
							<tr>
								<th>Brand </th>
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
								<th>Special Item </th>
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
								<th>Dimension</th>
								<td>
									<input type="text" name="product_L" value="{$Product.product_L}" size="3" />cm x <input type="text" name="product_W" value="{$Product.product_W}" size="3" />cm x <input type="text" name="product_D" value="{$Product.product_D}" size="3" />cm
								</td>
							</tr>
						{/if}
						{if $ProductFieldsShow.product_color_id != 'N' && 1 > 2}
							<tr>
								<th>Color </th>
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
								<th>Color </th>
								<td>
									<input name="product_rgb" type="color" value="#{$Product.product_rgb_r|string_format:"%02x"}{$Product.product_rgb_g|string_format:"%02x"}{$Product.product_rgb_b|string_format:"%02x"}" data-hex="true" />
								</td>
							</tr>
						{/if}
						{section name=foo start=0 loop=$smarty.const.NO_OF_CUSTOM_RGB_FIELDS step=1}
							{assign var='myfield' value="product_custom_rgb_`$smarty.section.foo.iteration`"}
							{assign var='myobjfield' value="object_custom_rgb_`$smarty.section.foo.iteration`"}
							{if $ProductCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$ProductCustomFieldsDef.$myfield}</th>
									<td><input name="{$myobjfield}" type="color" value="#{$ObjectLink[$myobjfield]}" data-hex="true" /></td>
								</tr>
							{/if}
						{/section}
						
						{foreach $ProductPriceList as $PPLIndex => $PL}
							{section name=foo start=0 loop=9 step=1}
								{assign var='PriceID' value=$smarty.section.foo.iteration}
								{assign var='myfield' value="product_price`$smarty.section.foo.iteration`"}
								{if $ProductCustomFieldsDef.$myfield != ''}
									<tr class="ProductPriceTr{$PPLIndex}">
										<th colspan="2"><hr /></th>
									</tr>
									{if $PPLIndex != 0}
										<tr>
											<th colspan="2" class="AlignLeft">{$PL.currency_name} Price {$PriceID}</th>
										</tr>
									{/if}
									{assign var='ProductPriceRow' value=$PL['product_price_list'][$PriceID]}
									
									<tr class="ProductPriceTr{$PPLIndex}">
										<th>Enable </th>
										<td>
											<input type="radio" name="product_price_enable_{$PPLIndex}_{$PriceID}" value="Y" {if $ProductPriceRow != null}checked="checked"{/if}/> Enable
											<input type="radio" name="product_price_enable_{$PPLIndex}_{$PriceID}" value="N" {if $ProductPriceRow == null}checked="checked"{/if}/> Disable
										</td>
									</tr>									
									{if $Site.site_module_bonus_point_enable == 'Y'}
										<tr>
											<th> Bonus Point </th>
											<td> <input type="text" name="product_bonus_point_amount_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.product_bonus_point_amount}" size="90" maxlength="255" /> </td>
										</tr>
									{/if}
									<tr class="ProductPriceTr{$PPLIndex}">
										<th> {$ProductCustomFieldsDef.$myfield} </th>
										<td>
											$<input type="text" name="product_price_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.product_price}" />
											{if $Site.site_product_price_version >= 2}
												Bonus Point Required <input type="text" name="product_bonus_point_required_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.product_bonus_point_required}" />
											{/if}
										</td>
									</tr>
									{if $ProductFieldsShow.product_discount != 'N'}
										{if $smarty.section.foo.iteration == 1 || $Site.site_product_price_version >= 2}
											<tr class="ProductPriceTr{$PPLIndex}">
												<th>Discount</th>
												<td>
													<table>
														<tr>
															<td>
																<input type="radio" class="discount_type" name="discount_type_{$PPLIndex}_{$PriceID}" value="0" {if $ProductPriceRow.discount_type == 0}checked="checked"{/if} /> No Discount <br />
																<input type="radio" class="discount_type" name="discount_type_{$PPLIndex}_{$PriceID}" value="1" {if $ProductPriceRow.discount_type == 1}checked="checked"{/if} /> <input type="text" name="discount1_off_p_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.discount1_off_p}" maxlength="2" size="2" />% Off <br />
																<input type="radio" class="discount_type" name="discount_type_{$PPLIndex}_{$PriceID}" value="2" {if $ProductPriceRow.discount_type == 2}checked="checked"{/if} /> $<input type="text" name="discount2_price_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.discount2_price}"  maxlength="5" size="5" /> for <input type="text" name="discount2_amount_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.discount2_amount}" maxlength="2" size="2" /> <br />
																<input type="radio" class="discount_type" name="discount_type_{$PPLIndex}_{$PriceID}" value="3" {if $ProductPriceRow.discount_type == 3}checked="checked"{/if} /> Buy <input type="text" name="discount3_buy_amount_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.discount3_buy_amount}" maxlength="2" size="2" /> Get <input type="text" name="discount3_free_amount_{$PPLIndex}_{$PriceID}" value="{$ProductPriceRow.discount3_free_amount}" maxlength="2" size="2" /> Free <br />
															</td>
															<td>
																<input type="radio" class="discount_type" name="discount_type_{$PPLIndex}_{$PriceID}" value="4" {if $ProductPriceRow.discount_type == 4}checked="checked"{/if} /> Price Level
																<div class="ProductPriceLevelContainer">
																	<table class="TopHeaderTable AlignLeft">
																		<tr class="ui-state-highlight">
																			<th class="AlignLeft"><a class="AddMoreProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
																			<th class="AlignLeft">Min Quantity</th>
																			<th class="AlignLeft">Price</th>
																		</tr>
																		<tr>
																			<td class="AlignLeft"></td>
																			<td>0<input type="hidden" name="product_price_level_min_{$PPLIndex}_{$PriceID}[]" value="0" /></td>
																			<td><input type="text" name="product_price_level_price_{$PPLIndex}_{$PriceID}[]" value="{$ProductPriceRow['ProductPriceLevel'][0].product_price_level_price}" /></td>
																		</tr>
																		{foreach from=$ProductPriceRow['ProductPriceLevel'] item=L}
																			{if $L.product_price_level_min != 0}
																				<tr>
																					<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																					<td><input type="text" name="product_price_level_min_{$PPLIndex}_{$PriceID}[]" value="{$L.product_price_level_min}" /></td>
																					<td><input type="text" name="product_price_level_price_{$PPLIndex}_{$PriceID}[]" value="{$L.product_price_level_price}" /></td>
																				</tr>
																			{/if}
																		{/foreach}
																		<tr class="ProductPriceLevelInput Hidden">
																			<td class="AlignLeft"><a class="RemoveProductPriceLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
																			<td><input type="text" name="product_price_level_min_{$PPLIndex}_{$PriceID}[]" /></td>
																			<td><input type="text" name="product_price_level_price_{$PPLIndex}_{$PriceID}[]" /></td>
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
							
						{/foreach}
						<tr>
							<th colspan="2"><hr /></th>
						</tr>							
						
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
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$ProductData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$ProductData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$ProductData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$ProductData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}
							{if $ProductFieldsShow.product_name != 'N'}
								<tr>
									<th>{$Site.site_label_product|ucwords} Name</th>
									<td>
										<textarea name="product_name[{$R.language_id}]" cols="87" rows="4">{$ProductData[$R.language_id].product_name}</textarea>
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_color != 'N'}
								<tr>
									<th>Color</th>
									<td>
										<input type="text" class="ProductColor" name="product_color[{$R.language_id}]" value="{$ProductData[$R.language_id].product_color}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_packaging != 'N'}
								<tr>
									<th>Packaging</th>
									<td>
										<input type="text" name="product_packaging[{$R.language_id}]" value="{$ProductData[$R.language_id].product_packaging}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
							{if $ProductFieldsShow.product_desc != 'N'}
								<tr>
									<th>{$Site.site_label_product|ucwords} Description</th>
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
									<th>Tag</th>
									<td>
										<p>Please seperate the tag by comma(,)</p>
										<input type="text" name="product_tag[{$R.language_id}]" value="{$ProductData[$R.language_id].product_tag|substr:2:-2|escape:'html'}" size="90" maxlength="255" />
									</td>
								</tr>
							{/if}
						</table>
					</div>
			   </div>
			{/foreach}
			{if $Site.site_module_order_enable == 'Y'}
				<div id="ProductTabsPanel-OrderList">
					{if $Site.site_module_group_buy_enable == 'Y'}
						<a href="product_group_buy_report.php?link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton" target="GroupBuyReport">
							<span class="ui-icon ui-icon-clipboard"></span> Group Buy Report
						</a>
					{/if}
					<table id="OrderListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight">
							<th width="50">Ref ID</th>
							<th width="50">Order No</th>
							<th width="120">User</th>
							<th width="120">Status</th>
				{*
							<th width="80">Payment Confirmed</th>
							<th width="90">Payment Confirmed By</th>
				*}
							<th width="120">Amount</th>
							<th width="120">Note</th>
							<th width="220">Action</th>
						</tr>
						{if $OrderList|@count == 0}
							<tr>
								<td colspan="7">No order has been made with this product.</td>
							</tr>
						{/if}

						{foreach from=$OrderList item=O}
							<tr class="AlignCenter">
								<td>{$O.myorder_id}</td>
								<td>{$O.order_no}</td>
								<td>{$O.user_username}</td>
								<td>
									{if $O.order_status == 'awaiting_freight_quote'}
										Awaiting Freight Quote
									{elseif $O.order_status == 'awaiting_order_confirmation'}
										Awaiting Order Confirmation
									{elseif $O.order_status == 'order_cancelled'}
										Order Cancelled
									{elseif $O.order_status == 'payment_pending'}
										Payment Pending
									{elseif $O.order_status == 'payment_confirmed'}
										Payment Confirmed
									{elseif $O.order_status == 'partial_shipped'}
										Partial Shipped
									{elseif $O.order_status == 'shipped'}
										Shipped
									{/if}
								</td>
				{*
								<td>{if $O.payment_confirmed == 'Y'}Yes{else}No{/if}</td>
								<td>{$O.payment_confirm_by}</td>
				*}
								<td>{$O.currency_shortname} {$O.pay_amount_ca}</td>
								<td>{$O.user_reference} </td>
								<td>
									<a href="order_delete.php?id={$O.myorder_id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
										<span class="ui-icon ui-icon-trash"></span> delete
									</a>
									<a href="order_details.php?id={$O.myorder_id}" class="ui-state-default ui-corner-all MyButton">
										<span class="ui-icon ui-icon-calculator"></span> details
									</a>
								</td>
							</tr>
						{/foreach}
					</table>
				</div>
			{/if}
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="{foreach from=$SiteLanguageRoots item=R}ContentEditor{$R.language_id} {/foreach}{$CustomFieldsEditorInstance}">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>

{if $ProductFieldsShow.product_option != 'N'}
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords} Option</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="ProductOptionTable-{$Product.product_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable ProductOptionTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="120">Option Code</th>
					{foreach from=$SiteLanguageRoots item=R}
					    <th width="80">{$R.language_longname|escape:'html'}</th>
					{/foreach}
					<th>Action</th>
				</tr>
				{if $ProductOptionList|@count == 0}
					<tr class="nodrop nodrag">
						<td colspan="{math equation='x + y' x=2 y=$SiteLanguageRoots|@count}">You may add product option here.</td>
					</tr>
				{/if}
				{foreach from=$ProductOptionList item=O key=K}
					<tr id="ProductOption-{$K}" class="{if $O.object_is_enable == 'N'}DisabledRow{/if}">
						<td class="AlignCenter">{$O.product_option_code}</td>
						{foreach from=$SiteLanguageRoots item=R}
						    <td width="80">
								{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
									{$ProductOptionList[$K][$R.language_id][$smarty.section.foo.iteration]} <br />
								{/section}
						    </td>
						{/foreach}
						<td class="AlignCenter">
							<a href="product_option_edit.php?id={$K}&link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="product_option_delete.php?id={$K}&link_id={$smarty.request.link_id}" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<a href="product_option_add.php?link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton">
				<span class="ui-icon ui-icon-circle-plus"></span> Add Option
			</a>
		</div>
	</div>
{/if}


<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords} Media</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table id="MediaListTable-{$Product.product_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable MediaListTable">
			<tr class="ui-state-highlight nodrop nodrag">
				<th width="50">ID</th>
				<th width="250">Media</th>
				<th>Action</th>
			</tr>
			{if $ProductMediaList|@count == 0}
				<tr class="nodrop nodrag">
					<td colspan="3">You may upload photos and video here.</td>
				</tr>
			{/if}
			{foreach from=$ProductMediaList item=M}
				<tr id="Media-{$M.media_id}" class="{if $M.object_is_enable == 'N'}DisabledRow{/if}">
					<td class="AlignCenter">{$M.media_id}</td>
					<td>
						{if $M.media_small_file_id != 0}
							<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview"><img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$M.media_small_file_id}" /><br class="MediaSmallFile" />{$M.filename}</a>
						{else}
							<a href="{$smarty.const.BASEURL}/getfile.php?id={$M.media_big_file_id}" target="_preview">{$M.filename}</a>
						{/if}
					</td>
					<td class="AlignCenter">
						<a href="product_media_set_highlight.php?link_id={$smarty.request.link_id}&id={$M.media_id}" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-image"></span> product thumbnail
						</a>
						<a href="media_edit.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_edit" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-pencil"></span> edit
						</a>
						<a href="media_delete.php?id={$M.media_id}&link_id={$smarty.request.link_id}&refer=product_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
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
			<input type="hidden" name="id" value="{$Product.product_id}" />
			<input type="hidden" name="refer" value="product_edit" />
			<br />
			<input type="checkbox" name="UpdateThumbnailOnly" value="Y" /> Update Thumbnail <br />
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

{if $ProductFieldsShow.product_datafile == 'Y'}
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords} Datafile </h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="DatafileListTable-{$Product.product_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable DatafileListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">ID</th>
					<th width="250">Datafile</th>
					<th width="80">Filesize</th>
					<th width="30">Security Level</th>					
					<th>Action</th>
				</tr>
				{if $ProductDatafileList|@count == 0}
					<tr class="nodrop nodrag">
						<td colspan="3">You may upload any files here.</td>
					</tr>
				{/if}
				{foreach from=$ProductDatafileList item=D}
					<tr id="Datafile-{$D.datafile_id}" class="{if $D.object_is_enable == 'N'}DisabledRow{/if}">
						<td class="AlignCenter">{$D.datafile_id}</td>
						<td><a href="{$smarty.const.BASEURL}getfile.php?id={$D.datafile_file_id}" target="_preview">{$D.filename}</a></td>
						<td>{($D.size/1024)|string_format:"%.2f"}kb</td>
						<td>{$D.object_security_level}</td>
						<td class="AlignCenter">
							<a href="datafile_edit.php?id={$D.datafile_id}&link_id={$smarty.request.link_id}&refer=product_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="datafile_delete.php?id={$D.datafile_id}&link_id={$smarty.request.link_id}&refer=product_edit" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br />
			<form enctype="multipart/form-data" name="FrmAddDatafile" id="FrmAddDatafile" method="post" action="datafile_add_act.php">
				<input type="file" name="datafile[]" multiple="true" />
				<input type="file" name="datafile[]" multiple="true" />
				<input type="file" name="datafile[]" multiple="true" /> <br />
				<br />
				Datafile Security Level: <input type="text" name="datafile_security_level" value="{$Site.site_default_security_level}" />
				<br />
				<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
				<input type="hidden" name="id" value="{$Product.product_id}" />
				<input type="hidden" name="refer" value="product_edit" />
				<br />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-circle-plus"></span> Add Datafile
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</form>
		</div>
	</div>

{/if}

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
