{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Field Setting</h1>
<p>Leave blank if you decide NOT to use this field. It will be hidden from the edit page.</p>
<p>
	<br />
	For custom text, use the following PREFIX to indicate the input method: <br />
	<strong>HTML_</strong> : html editor (Default) <br />
	<strong>STXT_</strong> : single line text <br />
	<strong>MTXT_</strong> : multi line text <br />
</p>
<br />
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="field_setting_act.php">
		<div id="FieldSettingTabs">
			<ul>
				<li><a href="#FieldSettingTabsPanel-Object">Object</a></li>
				<li><a href="#FieldSettingTabsPanel-Myorder">Myorder</a></li>
				<li><a href="#FieldSettingTabsPanel-User">User</a></li>
				<li><a href="#FieldSettingTabsPanel-Folder">Folder</a></li>
				<li><a href="#FieldSettingTabsPanel-Product">Product</a></li>
				<li><a href="#FieldSettingTabsPanel-ProductBrand">Product Brand</a></li>
				<li><a href="#FieldSettingTabsPanel-ProductCategory">Product Category</a></li>
				<li><a href="#FieldSettingTabsPanel-Album">Album</a></li>
				<li><a href="#FieldSettingTabsPanel-Media">Media</a></li>
				<li><a href="#FieldSettingTabsPanel-Datafile">Datafile</a></li>
			</ul>
			<div id="FieldSettingTabsPanel-Object">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>SEO Tab</th>
							<td>
								<input type="radio" name="object_seo_tab" value="Y" {if $ObjectFieldsShow.object_seo_tab == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="object_seo_tab" value="N" {if $ObjectFieldsShow.object_seo_tab != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>object_security_level</th>
							<td>
								<input type="radio" name="object_security_level" value="Y" {if $ObjectFieldsShow.object_security_level == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="object_security_level" value="N" {if $ObjectFieldsShow.object_security_level != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>object_archive_date</th>
							<td>
								<input type="radio" name="object_archive_date" value="Y" {if $ObjectFieldsShow.object_archive_date == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="object_archive_date" value="N" {if $ObjectFieldsShow.object_archive_date != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>object_publish_date</th>
							<td>
								<input type="radio" name="object_publish_date" value="Y" {if $ObjectFieldsShow.object_publish_date == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="object_publish_date" value="N" {if $ObjectFieldsShow.object_publish_date != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>object_lang_switch_id</th>
							<td>
								<input type="radio" name="object_lang_switch_id" value="Y" {if $ObjectFieldsShow.object_lang_switch_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="object_lang_switch_id" value="N" {if $ObjectFieldsShow.object_lang_switch_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="FieldSettingTabsPanel-Myorder">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>self_take</th>
							<td>
								<input type="radio" name="self_take" value="Y" {if $MyorderFieldsShow.self_take == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="self_take" value="N" {if $MyorderFieldsShow.self_take != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>show_bonus_point_tab</th>
							<td>
								<input type="radio" name="show_bonus_point_tab" value="Y" {if $MyorderFieldsShow.show_bonus_point_tab == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="show_bonus_point_tab" value="N" {if $MyorderFieldsShow.show_bonus_point_tab != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>show_deliver_address_tab</th>
							<td>
								<input type="radio" name="show_deliver_address_tab" value="Y" {if $MyorderFieldsShow.show_deliver_address_tab == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="show_deliver_address_tab" value="N" {if $MyorderFieldsShow.show_deliver_address_tab != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_country_id</th>
							<td>
								<input type="radio" name="invoice_country_id" value="Y" {if $MyorderFieldsShow.invoice_country_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_country_id" value="N" {if $MyorderFieldsShow.invoice_country_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_hk_district_id</th>
							<td>
								<input type="radio" name="invoice_hk_district_id" value="Y" {if $MyorderFieldsShow.invoice_hk_district_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_hk_district_id" value="N" {if $MyorderFieldsShow.invoice_hk_district_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_first_name</th>
							<td>
								<input type="radio" name="invoice_first_name" value="Y" {if $MyorderFieldsShow.invoice_first_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_first_name" value="N" {if $MyorderFieldsShow.invoice_first_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_last_name</th>
							<td>
								<input type="radio" name="invoice_last_name" value="Y" {if $MyorderFieldsShow.invoice_last_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_last_name" value="N" {if $MyorderFieldsShow.invoice_last_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_company_name</th>
							<td>
								<input type="radio" name="invoice_company_name" value="Y" {if $MyorderFieldsShow.invoice_company_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_company_name" value="N" {if $MyorderFieldsShow.invoice_company_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_city_name</th>
							<td>
								<input type="radio" name="invoice_city_name" value="Y" {if $MyorderFieldsShow.invoice_city_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_city_name" value="N" {if $MyorderFieldsShow.invoice_city_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_region</th>
							<td>
								<input type="radio" name="invoice_region" value="Y" {if $MyorderFieldsShow.invoice_region == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_region" value="N" {if $MyorderFieldsShow.invoice_region != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_postcode</th>
							<td>
								<input type="radio" name="invoice_postcode" value="Y" {if $MyorderFieldsShow.invoice_postcode == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_postcode" value="N" {if $MyorderFieldsShow.invoice_postcode != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_phone_no</th>
							<td>
								<input type="radio" name="invoice_phone_no" value="Y" {if $MyorderFieldsShow.invoice_phone_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_phone_no" value="N" {if $MyorderFieldsShow.invoice_phone_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_tel_country_code</th>
							<td>
								<input type="radio" name="invoice_tel_country_code" value="Y" {if $MyorderFieldsShow.invoice_tel_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_tel_country_code" value="N" {if $MyorderFieldsShow.invoice_tel_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_tel_area_code</th>
							<td>
								<input type="radio" name="invoice_tel_area_code" value="Y" {if $MyorderFieldsShow.invoice_tel_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_tel_area_code" value="N" {if $MyorderFieldsShow.invoice_tel_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_fax_country_code</th>
							<td>
								<input type="radio" name="invoice_fax_country_code" value="Y" {if $MyorderFieldsShow.invoice_fax_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_fax_country_code" value="N" {if $MyorderFieldsShow.invoice_fax_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_fax_area_code</th>
							<td>
								<input type="radio" name="invoice_fax_area_code" value="Y" {if $MyorderFieldsShow.invoice_fax_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_fax_area_code" value="N" {if $MyorderFieldsShow.invoice_fax_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_fax_no</th>
							<td>
								<input type="radio" name="invoice_fax_no" value="Y" {if $MyorderFieldsShow.invoice_fax_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_fax_no" value="N" {if $MyorderFieldsShow.invoice_fax_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>invoice_shipping_address_2</th>
							<td>
								<input type="radio" name="invoice_shipping_address_2" value="Y" {if $MyorderFieldsShow.invoice_shipping_address_2 == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="invoice_shipping_address_2" value="N" {if $MyorderFieldsShow.invoice_shipping_address_2 != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_country_id</th>
							<td>
								<input type="radio" name="delivery_country_id" value="Y" {if $MyorderFieldsShow.delivery_country_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_country_id" value="N" {if $MyorderFieldsShow.delivery_country_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_hk_district_id</th>
							<td>
								<input type="radio" name="delivery_hk_district_id" value="Y" {if $MyorderFieldsShow.delivery_hk_district_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_hk_district_id" value="N" {if $MyorderFieldsShow.delivery_hk_district_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_first_name</th>
							<td>
								<input type="radio" name="delivery_first_name" value="Y" {if $MyorderFieldsShow.delivery_first_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_first_name" value="N" {if $MyorderFieldsShow.delivery_first_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_last_name</th>
							<td>
								<input type="radio" name="delivery_last_name" value="Y" {if $MyorderFieldsShow.delivery_last_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_last_name" value="N" {if $MyorderFieldsShow.delivery_last_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_company_name</th>
							<td>
								<input type="radio" name="delivery_company_name" value="Y" {if $MyorderFieldsShow.delivery_company_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_company_name" value="N" {if $MyorderFieldsShow.delivery_company_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_city_name</th>
							<td>
								<input type="radio" name="delivery_city_name" value="Y" {if $MyorderFieldsShow.delivery_city_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_city_name" value="N" {if $MyorderFieldsShow.delivery_city_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_region</th>
							<td>
								<input type="radio" name="delivery_region" value="Y" {if $MyorderFieldsShow.delivery_region == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_region" value="N" {if $MyorderFieldsShow.delivery_region != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_postcode</th>
							<td>
								<input type="radio" name="delivery_postcode" value="Y" {if $MyorderFieldsShow.delivery_postcode == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_postcode" value="N" {if $MyorderFieldsShow.delivery_postcode != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_phone_no</th>
							<td>
								<input type="radio" name="delivery_phone_no" value="Y" {if $MyorderFieldsShow.delivery_phone_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_phone_no" value="N" {if $MyorderFieldsShow.delivery_phone_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_tel_country_code</th>
							<td>
								<input type="radio" name="delivery_tel_country_code" value="Y" {if $MyorderFieldsShow.delivery_tel_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_tel_country_code" value="N" {if $MyorderFieldsShow.delivery_tel_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_tel_area_code</th>
							<td>
								<input type="radio" name="delivery_tel_area_code" value="Y" {if $MyorderFieldsShow.delivery_tel_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_tel_area_code" value="N" {if $MyorderFieldsShow.delivery_tel_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_fax_no</th>
							<td>
								<input type="radio" name="delivery_fax_no" value="Y" {if $MyorderFieldsShow.delivery_fax_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_fax_no" value="N" {if $MyorderFieldsShow.delivery_fax_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_fax_country_code</th>
							<td>
								<input type="radio" name="delivery_fax_country_code" value="Y" {if $MyorderFieldsShow.delivery_fax_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_fax_country_code" value="N" {if $MyorderFieldsShow.delivery_fax_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_fax_area_code</th>
							<td>
								<input type="radio" name="delivery_fax_area_code" value="Y" {if $MyorderFieldsShow.delivery_fax_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_fax_area_code" value="N" {if $MyorderFieldsShow.delivery_fax_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_shipping_address_2</th>
							<td>
								<input type="radio" name="delivery_shipping_address_2" value="Y" {if $MyorderFieldsShow.delivery_shipping_address_2 == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_shipping_address_2" value="N" {if $MyorderFieldsShow.delivery_shipping_address_2 != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>delivery_email</th>
							<td>
								<input type="radio" name="delivery_email" value="Y" {if $MyorderFieldsShow.delivery_email == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="delivery_email" value="N" {if $MyorderFieldsShow.delivery_email != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_balance_tab</th>
							<td>
								<input type="radio" name="user_balance_tab" value="Y" {if $MyorderFieldsShow.user_balance_tab == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_balance_tab" value="N" {if $MyorderFieldsShow.user_balance_tab != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>myorder_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="myorder_custom_text_{$smarty.section.foo.iteration}" value="{$MyorderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>						
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>myorder_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="myorder_custom_int_{$smarty.section.foo.iteration}" value="{$MyorderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>myorder_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="myorder_custom_double_{$smarty.section.foo.iteration}" value="{$MyorderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>myorder_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="myorder_custom_date_{$smarty.section.foo.iteration}" value="{$MyorderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>
			<div id="FieldSettingTabsPanel-User">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>user_datafile</th>
							<td>
								<input type="radio" name="user_datafile" value="Y" {if $UserFieldsShow.user_datafile == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_datafile" value="N" {if $UserFieldsShow.user_datafile != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_thumbnail_file_id </th>
							<td>
								<input type="radio" name="user_thumbnail_file_id" value="Y" {if $UserFieldsShow.user_thumbnail_file_id  == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_thumbnail_file_id" value="N" {if $UserFieldsShow.user_thumbnail_file_id  != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_security_level </th>
							<td>
								<input type="radio" name="user_security_level" value="Y" {if $UserFieldsShow.user_security_level == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_security_level" value="N" {if $UserFieldsShow.user_security_level != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_title </th>
							<td>
								<input type="radio" name="user_title" value="Y" {if $UserFieldsShow.user_title == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_title" value="N" {if $UserFieldsShow.user_title != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_company_name </th>
							<td>
								<input type="radio" name="user_company_name" value="Y" {if $UserFieldsShow.user_company_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_company_name" value="N" {if $UserFieldsShow.user_company_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_city_name </th>
							<td>
								<input type="radio" name="user_city_name" value="Y" {if $UserFieldsShow.user_city_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_city_name" value="N" {if $UserFieldsShow.user_city_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_region </th>
							<td>
								<input type="radio" name="user_region" value="Y" {if $UserFieldsShow.user_region == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_region" value="N" {if $UserFieldsShow.user_region != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_postcode </th>
							<td>
								<input type="radio" name="user_postcode" value="Y" {if $UserFieldsShow.user_postcode == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_postcode" value="N" {if $UserFieldsShow.user_postcode != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_address_1 </th>
							<td>
								<input type="radio" name="user_address_1" value="Y" {if $UserFieldsShow.user_address_1 == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_address_1" value="N" {if $UserFieldsShow.user_address_1 != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_address_2 </th>
							<td>
								<input type="radio" name="user_address_2" value="Y" {if $UserFieldsShow.user_address_2 == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_address_2" value="N" {if $UserFieldsShow.user_address_2 != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_country_id </th>
							<td>
								<input type="radio" name="user_country_id" value="Y" {if $UserFieldsShow.user_country_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_country_id" value="N" {if $UserFieldsShow.user_country_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_hk_district_id </th>
							<td>
								<input type="radio" name="user_hk_district_id" value="Y" {if $UserFieldsShow.user_hk_district_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_hk_district_id" value="N" {if $UserFieldsShow.user_hk_district_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_tel_country_code </th>
							<td>
								<input type="radio" name="user_tel_country_code" value="Y" {if $UserFieldsShow.user_tel_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_tel_country_code" value="N" {if $UserFieldsShow.user_tel_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_tel_area_code </th>
							<td>
								<input type="radio" name="user_tel_area_code" value="Y" {if $UserFieldsShow.user_tel_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_tel_area_code" value="N" {if $UserFieldsShow.user_tel_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_tel_no </th>
							<td>
								<input type="radio" name="user_tel_no" value="Y" {if $UserFieldsShow.user_tel_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_tel_no" value="N" {if $UserFieldsShow.user_tel_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_fax_country_code </th>
							<td>
								<input type="radio" name="user_fax_country_code" value="Y" {if $UserFieldsShow.user_fax_country_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_fax_country_code" value="N" {if $UserFieldsShow.user_fax_country_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_fax_area_code </th>
							<td>
								<input type="radio" name="user_fax_area_code" value="Y" {if $UserFieldsShow.user_fax_area_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_fax_area_code" value="N" {if $UserFieldsShow.user_fax_area_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_fax_no </th>
							<td>
								<input type="radio" name="user_fax_no" value="Y" {if $UserFieldsShow.user_fax_no == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_fax_no" value="N" {if $UserFieldsShow.user_fax_no != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_how_to_know_this_website </th>
							<td>
								<input type="radio" name="user_how_to_know_this_website" value="Y" {if $UserFieldsShow.user_how_to_know_this_website == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_how_to_know_this_website" value="N" {if $UserFieldsShow.user_how_to_know_this_website != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_join_mailinglist </th>
							<td>
								<input type="radio" name="user_join_mailinglist" value="Y" {if $UserFieldsShow.user_join_mailinglist == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_join_mailinglist" value="N" {if $UserFieldsShow.user_join_mailinglist != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_language_id </th>
							<td>
								<input type="radio" name="user_language_id" value="Y" {if $UserFieldsShow.user_language_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_language_id" value="N" {if $UserFieldsShow.user_language_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_currency_id </th>
							<td>
								<input type="radio" name="user_currency_id" value="Y" {if $UserFieldsShow.user_currency_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_currency_id" value="N" {if $UserFieldsShow.user_currency_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_first_name </th>
							<td>
								<input type="radio" name="user_first_name" value="Y" {if $UserFieldsShow.user_first_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_first_name" value="N" {if $UserFieldsShow.user_first_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_last_name </th>
							<td>
								<input type="radio" name="user_last_name" value="Y" {if $UserFieldsShow.user_last_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_last_name" value="N" {if $UserFieldsShow.user_last_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>user_balance </th>
							<td>
								<input type="radio" name="user_balance" value="Y" {if $UserFieldsShow.user_balance == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="user_balance" value="N" {if $UserFieldsShow.user_balance != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>

						
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>user_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="user_custom_text_{$smarty.section.foo.iteration}" value="{$UserCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>						
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>user_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="user_custom_int_{$smarty.section.foo.iteration}" value="{$UserCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>user_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="user_custom_double_{$smarty.section.foo.iteration}" value="{$UserCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>user_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="user_custom_date_{$smarty.section.foo.iteration}" value="{$UserCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>
			<div id="FieldSettingTabsPanel-Folder">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>folder_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="folder_custom_text_{$smarty.section.foo.iteration}" value="{$FolderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>folder_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="folder_custom_int_{$smarty.section.foo.iteration}" value="{$FolderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>folder_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="folder_custom_double_{$smarty.section.foo.iteration}" value="{$FolderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="folder_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>folder_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="folder_custom_date_{$smarty.section.foo.iteration}" value="{$FolderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=$smarty.const.NO_OF_CUSTOM_RGB_FIELDS step=1}
							{assign var='myfield' value="folder_custom_rgb_`$smarty.section.foo.iteration`"}
							<tr>
								<th>folder_rgb_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="folder_custom_rgb_{$smarty.section.foo.iteration}" value="{$FolderCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>
			<div id="FieldSettingTabsPanel-Product">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>product_color_id</th>
							<td>
								<input type="radio" name="product_color_id" value="Y" {if $ProductFieldsShow.product_color_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_color_id" value="N" {if $ProductFieldsShow.product_color_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>factory_code</th>
							<td>
								<input type="radio" name="factory_code" value="Y" {if $ProductFieldsShow.factory_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="factory_code" value="N" {if $ProductFieldsShow.factory_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_code</th>
							<td>
								<input type="radio" name="product_code" value="Y" {if $ProductFieldsShow.product_code == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_code" value="N" {if $ProductFieldsShow.product_code != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_weight</th>
							<td>
								<input type="radio" name="product_weight" value="Y" {if $ProductFieldsShow.product_weight == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_weight" value="N" {if $ProductFieldsShow.product_weight != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_size</th>
							<td>
								<input type="radio" name="product_size" value="Y" {if $ProductFieldsShow.product_size == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_size" value="N" {if $ProductFieldsShow.product_size != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_LWD</th>
							<td>
								<input type="radio" name="product_LWD" value="Y" {if $ProductFieldsShow.product_LWD == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_LWD" value="N" {if $ProductFieldsShow.product_LWD != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_name</th>
							<td>
								<input type="radio" name="product_name" value="Y" {if $ProductFieldsShow.product_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_name" value="N" {if $ProductFieldsShow.product_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_color</th>
							<td>
								<input type="radio" name="product_color" value="Y" {if $ProductFieldsShow.product_color == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_color" value="N" {if $ProductFieldsShow.product_color != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_packaging</th>
							<td>
								<input type="radio" name="product_packaging" value="Y" {if $ProductFieldsShow.product_packaging == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_packaging" value="N" {if $ProductFieldsShow.product_packaging != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_desc</th>
							<td>
								<input type="radio" name="product_desc" value="Y" {if $ProductFieldsShow.product_desc == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_desc" value="N" {if $ProductFieldsShow.product_desc != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_tag</th>
							<td>
								<input type="radio" name="product_tag" value="Y" {if $ProductFieldsShow.product_tag == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_tag" value="N" {if $ProductFieldsShow.product_tag != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_option</th>
							<td>
								<input type="radio" name="product_option" value="Y" {if $ProductFieldsShow.product_option == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_option" value="N" {if $ProductFieldsShow.product_option != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_option_show_no</th>
							<td>
								<select name="product_option_show_no">
									{section name=foo start=0 loop=$smarty.const.PRODUCT_OPTION_DATA_TEXT_MAX_NO}
										<option value="{$smarty.section.foo.iteration}" {if $smarty.section.foo.iteration == $ProductFieldsShow.product_option_show_no}selected="selected"{/if}>{$smarty.section.foo.iteration}</option>
									{/section}
								</select>
							</td>
						</tr>
						<tr>
							<th>product_discount</th>
							<td>
								<input type="radio" name="product_discount" value="Y" {if $ProductFieldsShow.product_discount == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_discount" value="N" {if $ProductFieldsShow.product_discount != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_special_category</th>
							<td>
								<input type="radio" name="product_special_category" value="Y" {if $ProductFieldsShow.product_special_category == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_special_category" value="N" {if $ProductFieldsShow.product_special_category != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_datafile</th>
							<td>
								<input type="radio" name="product_datafile" value="Y" {if $ProductFieldsShow.product_datafile == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_datafile" value="N" {if $ProductFieldsShow.product_datafile != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_brand_id</th>
							<td>
								<input type="radio" name="product_brand_id" value="Y" {if $ProductFieldsShow.product_brand_id == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_brand_id" value="N" {if $ProductFieldsShow.product_brand_id != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_custom_text_{$smarty.section.foo.iteration}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>						
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_custom_int_{$smarty.section.foo.iteration}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_custom_double_{$smarty.section.foo.iteration}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_custom_date_{$smarty.section.foo.iteration}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}

						{section name=foo start=0 loop=$smarty.const.NO_OF_CUSTOM_RGB_FIELDS step=1}
							{assign var='myfield' value="product_custom_rgb_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_rgb_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_custom_rgb_{$smarty.section.foo.iteration}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}

						{for $foo=1 to 9}
							{assign var='myfield' value="product_price`$foo`"}
							<tr>
								<th>product_price{$foo}</th>
								<td><input type="text" name="product_price{$foo}" value="{$ProductCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/for}
					</table>
				</div>
			</div>

			<div id="FieldSettingTabsPanel-ProductBrand">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>product_brand_name</th>
							<td>
								<input type="radio" name="product_brand_name" value="Y" {if $ProductBrandFieldsShow.product_brand_name == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_brand_name" value="N" {if $ProductBrandFieldsShow.product_brand_name != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						<tr>
							<th>product_brand_desc</th>
							<td>
								<input type="radio" name="product_brand_desc" value="Y" {if $ProductBrandFieldsShow.product_brand_desc == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_brand_desc" value="N" {if $ProductBrandFieldsShow.product_brand_desc != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_brand_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_brand_custom_text_{$smarty.section.foo.iteration}" value="{$ProductBrandCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_brand_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_brand_custom_int_{$smarty.section.foo.iteration}" value="{$ProductBrandCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_brand_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_brand_custom_double_{$smarty.section.foo.iteration}" value="{$ProductBrandCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_brand_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_brand_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_brand_custom_date_{$smarty.section.foo.iteration}" value="{$ProductBrandCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>

			<div id="FieldSettingTabsPanel-ProductCategory">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>product_category_media_list</th>
							<td>
								<input type="radio" name="product_category_media_list" value="Y" {if $ProductCatFieldsShow.product_category_media_list == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_category_media_list" value="N" {if $ProductCatFieldsShow.product_category_media_list != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>

						<tr>
							<th>product_category_group_fields</th>
							<td>
								<input type="radio" name="product_category_group_fields" value="Y" {if $ProductCatFieldsShow.product_category_group_fields == 'Y'}checked="checked"{/if}/> Show
								<input type="radio" name="product_category_group_fields" value="N" {if $ProductCatFieldsShow.product_category_group_fields != 'Y'}checked="checked"{/if}/> Hide
							</td>
						</tr>
						
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_category_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_category_custom_text_{$smarty.section.foo.iteration}" value="{$ProductCategoryCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_category_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_category_custom_int_{$smarty.section.foo.iteration}" value="{$ProductCategoryCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_category_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_category_custom_double_{$smarty.section.foo.iteration}" value="{$ProductCategoryCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="product_category_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>product_category_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="product_category_custom_date_{$smarty.section.foo.iteration}" value="{$ProductCategoryCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>
			
			<div id="FieldSettingTabsPanel-Album">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>album_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="album_custom_text_{$smarty.section.foo.iteration}" value="{$AlbumCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>album_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="album_custom_int_{$smarty.section.foo.iteration}" value="{$AlbumCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>album_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="album_custom_double_{$smarty.section.foo.iteration}" value="{$AlbumCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>album_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="album_custom_date_{$smarty.section.foo.iteration}" value="{$AlbumCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="album_custom_file_`$smarty.section.foo.iteration`"}
							<tr>
								<th>album_custom_file_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="album_custom_file_{$smarty.section.foo.iteration}" value="{$AlbumCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>

			<div id="FieldSettingTabsPanel-Media">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>media_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="media_custom_text_{$smarty.section.foo.iteration}" value="{$MediaCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>media_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="media_custom_int_{$smarty.section.foo.iteration}" value="{$MediaCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>media_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="media_custom_double_{$smarty.section.foo.iteration}" value="{$MediaCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="media_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>media_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="media_custom_date_{$smarty.section.foo.iteration}" value="{$MediaCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>
			
			<div id="FieldSettingTabsPanel-Datafile">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_text_`$smarty.section.foo.iteration`"}
							<tr>
								<th>datafile_custom_text_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="datafile_custom_text_{$smarty.section.foo.iteration}" value="{$DatafileCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_int_`$smarty.section.foo.iteration`"}
							<tr>
								<th>datafile_custom_int_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="datafile_custom_int_{$smarty.section.foo.iteration}" value="{$DatafileCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_double_`$smarty.section.foo.iteration`"}
							<tr>
								<th>datafile_custom_double_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="datafile_custom_double_{$smarty.section.foo.iteration}" value="{$DatafileCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_date_`$smarty.section.foo.iteration`"}
							<tr>
								<th>datafile_custom_date_{$smarty.section.foo.iteration}</th>
								<td><input type="text" name="datafile_custom_date_{$smarty.section.foo.iteration}" value="{$DatafileCustomFieldsDef.$myfield|escape:'html'}" size="80" /></td>
							</tr>
						{/section}
					</table>
				</div>
			</div>			
			
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<input class="HiddenSubmit" type="submit" value="Submit" />
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
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
