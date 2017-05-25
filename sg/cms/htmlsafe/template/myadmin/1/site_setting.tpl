{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Site Setting &nbsp; </h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_setting_act.php">
		<div id="SiteSettingTabs">
			<ul>
				<li><a href="#SiteSettingTabsPanel-SiteDetails">Site Details</a></li>
				<li><a href="#SiteSettingTabsPanel-ContentWriterModule">Content Writer</a></li>
				<li><a href="#SiteSettingTabsPanel-MemberModule">Member</a></li>
				<li><a href="#SiteSettingTabsPanel-VoteModule">Vote</a></li>
				<li><a href="#SiteSettingTabsPanel-ArticleModule">Article</a></li>
				<li><a href="#SiteSettingTabsPanel-FolderModule">Folder</a></li>
				<li><a href="#SiteSettingTabsPanel-NewsModule">Simple News</a></li>
				<li><a href="#SiteSettingTabsPanel-LayoutNewsModule">Layout News</a></li>
				<li><a href="#SiteSettingTabsPanel-AlbumModule">Album</a></li>
				<li><a href="#SiteSettingTabsPanel-ProductModule">Product</a></li>
				<li><a href="#SiteSettingTabsPanel-OrderModule">Order</a></li>
				<li><a href="#SiteSettingTabsPanel-InventoryModule">Inventory</a></li>
				<li><a href="#SiteSettingTabsPanel-ElasingModule">Elasing</a></li>
			</ul>
			<div id="SiteSettingTabsPanel-SiteDetails">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th width="50%"> Site ID </th>
							<td> {$Site.site_id|escape:'html'} </td>
						</tr>
						<tr>
							<th width="50%"> Site Name </th>
							<td> {$Site.site_name|escape:'html'} </td>
						</tr>
						<tr>
							<th> Site Address </th>
							<td> {$Site.site_address|escape:'html'} </td>
						</tr>
						<tr>
							<th> API Login </th>
							<td> {$Site.site_api_login|escape:'html'} </td>
						</tr>
						<tr>
							<th> API Key </th>
							<td> {$Site.site_api_key|escape:'html'} </td>
						</tr>
						<tr>
							<th>Site Default Security Level </th>
							<td>
								<input type="text" name="site_default_security_level" value="{$Site.site_default_security_level}" />
							</td>
						</tr>
						<tr>
							<th>Site Admin Logo URL </th>
							<td>
								<input type="text" name="site_admin_logo_url" value="{$Site.site_admin_logo_url}" />
							</td>
						</tr>
						<tr>
							<th> Watermark Position </th>
							<td>
								<select name="site_watermark_position">
									<option value="center" {if $Site.site_watermark_position == 'center'}selected="selected"{/if}>Center</option>
									<option value="random" {if $Site.site_watermark_position == 'random'}selected="selected"{/if}>Random</option>
									<option value="bottom-right" {if $Site.site_watermark_position == 'bottom-right'}selected="selected"{/if}>Bottom Right</option>
									<option value="top-right" {if $Site.site_watermark_position == 'top-right'}selected="selected"{/if}>Top Right</option>
									<option value="top-left" {if $Site.site_watermark_position == 'top-left'}selected="selected"{/if}>Top Left</option>
									<option value="bottom-left" {if $Site.site_watermark_position == 'bottom-left'}selected="selected"{/if}>Bottom Left</option>
									<option value="top" {if $Site.site_watermark_position == 'top'}selected="selected"{/if}>Top</option>
									<option value="bottom" {if $Site.site_watermark_position == 'bottom'}selected="selected"{/if}>Bottom</option>
									<option value="left" {if $Site.site_watermark_position == 'left'}selected="selected"{/if}>Left</option>
									<option value="right" {if $Site.site_watermark_position == 'right'}selected="selected"{/if}>Right</option>
								</select>
							</td>
						</tr>
						<tr>
							<th> Media Thumbnail Watermark (PNG Only) </th>
							<td>
								{if $Site.site_media_watermark_small_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_media_watermark_small_file_id}" /> <input type="checkbox" name="remove_site_media_watermark_small_file" value="Y" /> Remove
									<br />
								{/if}
								<input type="file" name="site_media_watermark_small_file" />
							</td>
						</tr>
						<tr>
							<th> Media Watermark (PNG Only) </th>
							<td>
								{if $Site.site_media_watermark_big_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_media_watermark_big_file_id}" /> <input type="checkbox" name="remove_site_media_watermark_big_file" value="Y" /> Remove
									<br />
								{/if}
								<input type="file" name="site_media_watermark_big_file" />
							</td>
						</tr>
						<tr>
							<th> Product Media Thumbnail Watermark (PNG Only) </th>
							<td>
								{if $Site.site_product_media_watermark_small_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_product_media_watermark_small_file_id}" /> <input type="checkbox" name="remove_site_product_media_watermark_small_file" value="Y" /> Remove
									<br />
								{/if}
								<input type="file" name="site_product_media_watermark_small_file" />
							</td>
						</tr>
						<tr>
							<th> Product Media Watermark (PNG Only) </th>
							<td>
								{if $Site.site_product_media_watermark_big_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_product_media_watermark_big_file_id}" /> <input type="checkbox" name="remove_site_product_media_watermark_big_file" value="Y" /> Remove
									<br />
								{/if}
								<input type="file" name="site_product_media_watermark_big_file" />
							</td>
						</tr>
						<tr>
							<th> Friendly Link </th>
							<td>
								<input type="radio" name="site_friendly_link_enable" value="Y" {if $Site.site_friendly_link_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_friendly_link_enable" value="N" {if $Site.site_friendly_link_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Friendly Link Http Path (Default: html) </th>
							<td>
								<input type="text" name="site_http_friendly_link_path" value="{$Site.site_http_friendly_link_path}" />
							</td>
						</tr>
						<tr>
							<th> Friendly Link Version </th>
							<td>
								<select name="site_friendly_link_version">
									<option value="old" {if $Site.site_friendly_link_version == 'old'}selected="selected"{/if}>old</option>
									<option value="structured" {if $Site.site_friendly_link_version == 'structured'}selected="selected"{/if}>structured</option>
								</select>
							</td>
						</tr>
						<tr>
							<th> Additional htaccess content</th>
							<td>
								<textarea name="site_additional_htaccess_content">{$Site.site_additional_htaccess_content}</textarea>
							</td>
						</tr>
						<tr>
							<th> Rich Client XML Data </th>
							<td>
								<input type="radio" name="site_rich_xml_data_enable" value="Y" {if $Site.site_rich_xml_data_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_rich_xml_data_enable" value="N" {if $Site.site_rich_xml_data_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Country Show Other </th>
							<td>
								<input type="radio" name="site_country_show_other" value="Y" {if $Site.site_country_show_other != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_country_show_other" value="N" {if $Site.site_country_show_other == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Module ObjMan </th>
							<td>
								<input type="radio" name="site_module_objman_enable" value="Y" {if $Site.site_module_objman_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_objman_enable" value="N" {if $Site.site_module_objman_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-ContentWriterModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Content Writer Module </th>
							<td>
								<input type="radio" name="site_module_content_writer_enable" value="Y" {if $Site.site_module_content_writer_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_content_writer_enable" value="N" {if $Site.site_module_content_writer_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Workflow Module </th>
							<td>
								<input type="radio" name="site_module_workflow_enable" value="Y" {if $Site.site_module_workflow_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_workflow_enable" value="N" {if $Site.site_module_workflow_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
					</table>
				</div>
			</div>			
			<div id="SiteSettingTabsPanel-MemberModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Member Module </th>
							<td>
								<input type="radio" name="site_module_member_enable" value="Y" {if $Site.site_module_member_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_member_enable" value="N" {if $Site.site_module_member_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Member Status Change Callback URL </th>
							<td>
								<input type="text" name="site_member_status_change_callback_url" value="{$Site.site_member_status_change_callback_url}" size="64" /> <br />
								Leave blank if no feedback URL
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-VoteModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th width="50%"> Vote Module </th>
							<td width="50%">
								<input type="radio" name="site_module_vote_enable" value="Y" {if $Site.site_module_vote_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_vote_enable" value="N" {if $Site.site_module_vote_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Allow user to vote on same object multiple times? </th>
							<td>
								<input type="radio" name="site_vote_multi" value="Y" {if $Site.site_vote_multi != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_vote_multi" value="N" {if $Site.site_vote_multi == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Allow guest user to vote? </th>
							<td>
								<input type="radio" name="site_vote_guest" value="Y" {if $Site.site_vote_guest != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_vote_guest" value="N" {if $Site.site_vote_guest == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-FolderModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Folder Thumbnail Width </th>
							<td> <input type="text" name="site_folder_media_small_width" value="{$Site.site_folder_media_small_width}" size="5" /> </td>
						</tr>
						<tr>
							<th> Folder Thumbnail Height </th>
							<td> <input type="text" name="site_folder_media_small_height" value="{$Site.site_folder_media_small_height}" size="5" /> </td>
						</tr>						
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-ArticleModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Article Module </th>
							<td>
								<input type="radio" name="site_module_article_enable" value="Y" {if $Site.site_module_article_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_article_enable" value="N" {if $Site.site_module_article_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Article Quota </th>
							<td> <input type="text" name="site_module_article_quota" value="{$Site.site_module_article_quota}" size="5" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-NewsModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> News Module Label </th>
							<td> <input type="text" name="site_label_news" value="{$Site.site_label_news}" size="20" /> </td>
						</tr>
						<tr>
							<th> News Module </th>
							<td>
								<input type="radio" name="site_module_news_enable" value="Y" {if $Site.site_module_news_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_news_enable" value="N" {if $Site.site_module_news_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> News Quota </th>
							<td> <input type="text" name="site_module_news_quota" value="{$Site.site_module_news_quota}" size="5" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-LayoutNewsModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Layout News Module Label </th>
							<td> <input type="text" name="site_label_layout_news" value="{$Site.site_label_layout_news}" size="20" /> </td>
						</tr>
						<tr>
							<th> Layout News Module </th>
							<td>
								<input type="radio" name="site_module_layout_news_enable" value="Y" {if $Site.site_module_layout_news_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_layout_news_enable" value="N" {if $Site.site_module_layout_news_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Layout News Quota </th>
							<td> <input type="text" name="site_module_layout_news_quota" value="{$Site.site_module_layout_news_quota}" size="5" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-AlbumModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Album Module </th>
							<td>
								<input type="radio" name="site_module_album_enable" value="Y" {if $Site.site_module_album_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_album_enable" value="N" {if $Site.site_module_album_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Media Thumbnail Width </th>
							<td> <input type="text" name="site_media_small_width" value="{$Site.site_media_small_width}" size="5" /> </td>
						</tr>
						<tr>
							<th> Media Thumbnail Height </th>
							<td> <input type="text" name="site_media_small_height" value="{$Site.site_media_small_height}" size="5" /> </td>
						</tr>
						<tr>
							<th> Media Auto Resize </th>
							<td>
								<input type="radio" name="site_media_resize" value="Y" {if $Site.site_media_resize != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_media_resize" value="N" {if $Site.site_media_resize == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Media Width </th>
							<td> <input type="text" name="site_media_big_width" value="{$Site.site_media_big_width}" size="5" /> </td>
						</tr>
						<tr>
							<th> Media Height </th>
							<td> <input type="text" name="site_media_big_height" value="{$Site.site_media_big_height}" size="5" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-ProductModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Product Module </th>
							<td>
								<input type="radio" name="site_module_product_enable" value="Y" {if $Site.site_module_product_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_product_enable" value="N" {if $Site.site_module_product_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Discount Rule Module </th>
							<td>
								<input type="radio" name="site_module_discount_rule_enable" value="Y" {if $Site.site_module_discount_rule_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_discount_rule_enable" value="N" {if $Site.site_module_discount_rule_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Bundle Rule Module </th>
							<td>
								<input type="radio" name="site_module_bundle_rule_enable" value="Y" {if $Site.site_module_bundle_rule_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_bundle_rule_enable" value="N" {if $Site.site_module_bundle_rule_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>						
						<tr>
							<th> Product Module Label </th>
							<td> <input type="text" name="site_label_product" value="{$Site.site_label_product}" size="20" /> </td>
						</tr>
						<tr>
							<th> Product Special Category Max No </th>
							<td>
								<select name="site_product_category_special_max_no">
									{section name=foo start=0 loop=20 step=1}
										<option value="{$smarty.section.foo.iteration}" {if $smarty.section.foo.iteration==$Site.site_product_category_special_max_no}selected="selected"{/if}>{$smarty.section.foo.iteration}</option>
									{/section}
								</select>
								(Disable in field setting if you don't even want to show it.)
							</td>
						</tr>
						<tr>
							<th> Product Quota </th>
							<td> <input type="text" name="site_module_product_quota" value="{$Site.site_module_product_quota}" size="5" /> </td>
						</tr>
						<tr>
							<th> Product Media Auto Resize </th>
							<td>
								<input type="radio" name="site_product_media_resize" value="Y" {if $Site.site_product_media_resize != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_product_media_resize" value="N" {if $Site.site_product_media_resize == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Product Thumbnail Width </th>
							<td> <input type="text" name="site_product_media_small_width" value="{$Site.site_product_media_small_width}" size="5" /> </td>
						</tr>
						<tr>
							<th> Product Thumbnail Height </th>
							<td> <input type="text" name="site_product_media_small_height" value="{$Site.site_product_media_small_height}" size="5" /> </td>
						</tr>
						<tr>
							<th> Product Media Width </th>
							<td> <input type="text" name="site_product_media_big_width" value="{$Site.site_product_media_big_width}" size="5" /> </td>
						</tr>
						<tr>
							<th> Product Media Height </th>
							<td> <input type="text" name="site_product_media_big_height" value="{$Site.site_product_media_big_height}" size="5" /> </td>
						</tr>
						<tr>
							<th> Product Price Version</th>
							<td> <input type="text" name="site_product_price_version" value="{$Site.site_product_price_version}" size="2" /> </td>
						</tr>
						<tr>
							<th> Indepedent Product Price Per Currency <br /> Set this to Y will reset all currency rate to 1</th>
							<td>
								<input type="radio" name="site_product_price_indepedent_currency" value="Y" {if $Site.site_product_price_indepedent_currency != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_product_price_indepedent_currency" value="N" {if $Site.site_product_price_indepedent_currency == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-OrderModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Order Module </th>
							<td>
								<input type="radio" name="site_module_order_enable" value="Y" {if $Site.site_module_order_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_order_enable" value="N" {if $Site.site_module_order_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Group Buy Module </th>
							<td>
								<input type="radio" name="site_module_group_buy_enable" value="Y" {if $Site.site_module_group_buy_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_group_buy_enable" value="N" {if $Site.site_module_group_buy_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Bonus Point Module </th>
							<td>
								<input type="radio" name="site_module_bonus_point_enable" value="Y" {if $Site.site_module_bonus_point_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_bonus_point_enable" value="N" {if $Site.site_module_bonus_point_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Use Bonus Point At Once </th>
							<td>
								<input type="radio" name="site_use_bonus_point_at_once" value="Y" {if $Site.site_use_bonus_point_at_once != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_use_bonus_point_at_once" value="N" {if $Site.site_use_bonus_point_at_once == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Invoice </th>
							<td>
								<input type="radio" name="site_invoice_enable" value="Y" {if $Site.site_invoice_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_invoice_enable" value="N" {if $Site.site_invoice_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Freight Cost Calculation</th>
							<td>
								<select name="site_freight_cost_calculation_id">
									<option value="0" {if $Site.site_freight_cost_calculation_id==0}selected="selected"{/if}>-----</option>
									<option value="1" {if $Site.site_freight_cost_calculation_id==1}selected="selected"{/if}>Below $X charge $Y</option>
									<option value="2" {if $Site.site_freight_cost_calculation_id==2}selected="selected"{/if}>Below $X charge Y%</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Show order redeem tab? </th>
							<td>
								<input type="radio" name="site_order_show_redeem_tab" value="Y" {if $Site.site_order_show_redeem_tab != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_order_show_redeem_tab" value="N" {if $Site.site_order_show_redeem_tab == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th>Order Status Change Callback URL </th>
							<td>
								<input type="text" name="site_order_status_change_callback_url" value="{$Site.site_order_status_change_callback_url}" size="64" /> <br />
								Leave blank if no feedback URL
							</td>
						</tr>
						<tr>
							<th>Order NEXT Serial No </th>
							<td>
								<input type="text" name="site_next_order_serial" value="{$Site.site_next_order_serial}" size="64" /> <br />
							</td>
						</tr>
						<tr>
							<th>Order Serial No Reset Type </th>
							<td>
								<select name="site_order_serial_reset_type">
									<option value="monthly" {if $Site.site_order_serial_reset_type == 'monthly'}selected="selected"{/if}>Monthly</option>
									<option value="yearly" {if $Site.site_order_serial_reset_type == 'yearly'}selected="selected"{/if}>Yearly</option>
									<option value="absolute_year" {if $Site.site_order_serial_reset_type == 'absolute_year'}selected="selected"{/if}>Next Year Same Date</option>
									<option value="no_reset" {if $Site.site_order_serial_reset_type == 'no_reset'}selected="selected"{/if}>No Reset</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Order Serial No NEXT Reset Date</th>
							<td>
								<input type="text" name="site_order_serial_next_reset_date" value="{$Site.site_order_serial_next_reset_date}" size="64" /> <br />
							</td>
						</tr>
						<tr>
							<th>Order No Format</th>
							<td>{literal}
								<h3>Supported Tag:</h3>
								<p>
									{SN0} - {SN10} = Serial no with leading 0, {SN10} = 0000123456, {SN7} = 01234567 <br />
									{Y} = 4 digits Year, {y} = 2 digits Year <br />
									{m} = 2 digits Month, {n} = Month without leading zero <br />
									{d} = 2 digits Day, {j} = Day without leading zero <br />
									<br />
									Example: INV{Y}{m}{d}-{SN7} = INV20130405-0001234 <br />
									<br />
								</p>
								{/literal}
								<input type="text" name="site_order_no_format" value="{$Site.site_order_no_format}" size="64" /> <br />
							</td>
						</tr>
						
						
						<tr>
							<th>Redeem NEXT Serial No </th>
							<td>
								<input type="text" name="site_next_redeem_serial" value="{$Site.site_next_redeem_serial}" size="64" /> <br />
							</td>
						</tr>
						<tr>
							<th>Redeem Serial No Reset Type </th>
							<td>
								<select name="site_redeem_serial_reset_type">
									<option value="monthly" {if $Site.site_redeem_serial_reset_type == 'monthly'}selected="selected"{/if}>Monthly</option>
									<option value="yearly" {if $Site.site_redeem_serial_reset_type == 'yearly'}selected="selected"{/if}>Yearly</option>
									<option value="absolute_year" {if $Site.site_redeem_serial_reset_type == 'absolute_year'}selected="selected"{/if}>Next Year Same Date</option>
									<option value="no_reset" {if $Site.site_redeem_serial_reset_type == 'no_reset'}selected="selected"{/if}>No Reset</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Redeem Serial No NEXT Reset Date</th>
							<td>
								<input type="text" name="site_redeem_serial_next_reset_date" value="{$Site.site_redeem_serial_next_reset_date}" size="64" /> <br />
							</td>
						</tr>
						<tr>
							<th>Redeem No Format</th>
							<td><input type="text" name="site_redeem_no_format" value="{$Site.site_redeem_no_format}" size="64" /></td>
						</tr>
						
						<tr>
							<th>Order Invoice callback <br /> ?id=xxx&s=md5($api_login . $api_key . myorder_id) </th>
							<td><input type="text" name="site_order_invoice_callback_url" value="{$Site.site_order_invoice_callback_url}" size="64" /></td>
						</tr>						
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-InventoryModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>
								Partial Shipment
								<p> Partial Shipment may be enabled with Inventory disabled. </p>
							</th>
							<td>
								<input type="radio" name="site_module_inventory_partial_shipment" value="Y" {if $Site.site_module_inventory_partial_shipment != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_inventory_partial_shipment" value="N" {if $Site.site_module_inventory_partial_shipment == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th>
								Inventory Module
								<p> Inventory Module includes Partial Shipment automatically. </p>
							</th>
							<td>
								<input type="radio" name="site_module_inventory_enable" value="Y" {if $Site.site_module_inventory_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_inventory_enable" value="N" {if $Site.site_module_inventory_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th>
								Delivery Note
							</th>
							<td>
								<input type="radio" name="site_dn_enable" value="Y" {if $Site.site_dn_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_dn_enable" value="N" {if $Site.site_dn_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>						
						<tr>
							<th> Product Allow Under Stock </th>
							<td>
								<input type="radio" name="site_product_allow_under_stock" value="Y" {if $Site.site_product_allow_under_stock != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_product_allow_under_stock" value="N" {if $Site.site_product_allow_under_stock == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th>System Automatic Hold Stock Status</th>
							<td>
								<select name="site_auto_hold_stock_status">
									<option value="none" {if $Site.site_auto_hold_stock_status == 'none'}selected="selected"{/if}>None</option>
									<option value="payment_pending" {if $Site.site_auto_hold_stock_status == 'payment_pending'}selected="selected"{/if}>Payment Pending (Order Confirmed)</option>
									<option value="payment_confirmed" {if $Site.site_auto_hold_stock_status == 'payment_confirmed'}selected="selected"{/if}>Payment Confirmed</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="SiteSettingTabsPanel-ElasingModule">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Elasing Module </th>
							<td>
								<input type="radio" name="site_module_elasing_enable" value="Y" {if $Site.site_module_elasing_enable != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_elasing_enable" value="N" {if $Site.site_module_elasing_enable == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Elasing Multi Level </th>
							<td>
								<input type="radio" name="site_module_elasing_multi_level" value="Y" {if $Site.site_module_elasing_multi_level != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_module_elasing_multi_level" value="N" {if $Site.site_module_elasing_multi_level == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Custom Footer </th>
							<td>
								<input type="radio" name="site_email_custom_footer" value="Y" {if $Site.site_email_custom_footer != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_email_custom_footer" value="N" {if $Site.site_email_custom_footer == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Use user info to override site info as sender? </th>
							<td>
								<input type="radio" name="site_email_user_sender_override_site_sender" value="Y" {if $Site.site_email_user_sender_override_site_sender != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_email_user_sender_override_site_sender" value="N" {if $Site.site_email_user_sender_override_site_sender == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Hide mailing list in unsubscribe page? </th>
							<td>
								<input type="radio" name="site_email_unsubscribe_hide_mailing_list" value="Y" {if $Site.site_email_unsubscribe_hide_mailing_list != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_email_unsubscribe_hide_mailing_list" value="N" {if $Site.site_email_unsubscribe_hide_mailing_list == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Elasing Monthly Quota </th>
							<td> <input type="text" name="site_email_sent_monthly_quota" value="{$Site.site_email_sent_monthly_quota}" size="5" /> </td>
						</tr>
						<tr>
							<th> Default Content </th>
							<td>{$EditorEmailContentHTML}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<input type="hidden" name="site_id" value="{$Site.site_id}" />
		<input class="HiddenSubmit" type="submit" value="Submit" />
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
