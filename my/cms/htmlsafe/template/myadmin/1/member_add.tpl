{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">Add Member &nbsp;
	<a href="member_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Member List</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="member_add_act.php">
		<div id="MemberTabs">
			<ul>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#MemberTabs-Permission">Permission</a></li>{/if}
			    <li><a href="#MemberTabs-CommonData">Member Details</a></li>
			</ul>
			<div id="MemberTabs-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>Status</th>
							<td>
								<input type="radio" name="user_is_enable" value="Y" {if $smarty.request.user_is_enable == 'Y'}checked="checked"{/if}/> Enable
								<input type="radio" name="user_is_enable" value="N" {if $smarty.request.user_is_enable != 'Y'}checked="checked"{/if}/> Disable
							</td>
						</tr>
						<tr>
							<th>Username</th>
							<td><input type="text" name="user_username" value="{$smarty.request.user_username|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><input type="text" name="user_email" value="{$smarty.request.user_email|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_security_level == 'N'}class="Hidden"{/if}>
							<th>Security Level</th>
							<td><input type="text" name="user_security_level" value="{$smarty.request.user_security_level}" size="80" /></td>
						</tr>
						<tr>
							<th>Password</th>
							<td><input type="password" name="user_password" value="" size="80" /></td>
						</tr>
						<tr>
							<th>Re-Type Password</th>
							<td><input type="password" name="user_password2" value="" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_currency_id == 'N'}class="Hidden"{/if}>
							<th>Currency</th>
							<td>
								<select name="user_currency_id">
									{foreach from=$CurrencyList item=C}
										<option value="{$C.currency_id}"
											{if $C.currency_id == $smarty.request.user_currency_id}selected="selected"{/if}
										>{$C.currency_shortname|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_language_id == 'N'}class="Hidden"{/if}>
							<th>Language</th>
							<td>
								<select name="user_language_id">
									{foreach from=$LanguageRootList item=R}
										<option value="{$R.language_id}"
											{if $R.language_id == $smarty.request.user_language_id}selected="selected"{/if}
										>{$R.language_native|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_title == 'N'}class="Hidden"{/if}>
							<th>Title</th>
							<td><input type="text" name="user_title" value="{$smarty.request.user_title|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_first_name == 'N'}class="Hidden"{/if}>
							<th>First Name</th>
							<td><input type="text" name="user_first_name" value="{$smarty.request.user_first_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_last_name == 'N'}class="Hidden"{/if}>
							<th>Last Name</th>
							<td><input type="text" name="user_last_name" value="{$smarty.request.user_last_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_company_name == 'N'}class="Hidden"{/if}>
							<th>Company / Organisation</th>
							<td><input type="text" name="user_company_name" value="{$smarty.request.user_company_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_city_name == 'N'}class="Hidden"{/if}>
							<th>City Name</th>
							<td><input type="text" name="user_city_name" value="{$smarty.request.user_city_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_region == 'N'}class="Hidden"{/if}>
							<th>Region</th>
							<td><input type="text" name="user_region" value="{$smarty.request.user_region|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_postcode == 'N'}class="Hidden"{/if}>
							<th>Postcode</th>
							<td><input type="text" name="user_postcode" value="{$smarty.request.user_postcode|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_address_1 == 'N'}class="Hidden"{/if}>
							<th>Address 1</th>
							<td><input type="text" name="user_address_1" value="{$smarty.request.user_address_1|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_address_2 == 'N'}class="Hidden"{/if}>
							<th>Address 2</th>
							<td><input type="text" name="user_address_2" value="{$smarty.request.user_address_2|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_country_id == 'N'}class="Hidden"{/if}>
							<th>Country</th>
							<td>
								<select name="user_country_id">
									{foreach from=$CountryList item=C}
										<option value="{$C.country_id}"
											{if $C.country_id == $smarty.request.user_country_id}selected="selected"{/if}
										>{$C.country_name_en|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_hk_district_id == 'N'}class="Hidden"{/if}>
							<th>Hong Kong District</th>
							<td>
								<select name="user_hk_district_id">
									{foreach from=$HongKongDistrictList item=D}
										<option value="{$D.hk_district_id}"
											{if $D.hk_district_id == $User.user_hk_district_id}selected="selected"{/if}
										>{$D.hk_district_name_en|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_tel_country_code == 'N' && $UserFieldsShow.user_tel_area_code == 'N' && $UserFieldsShow.user_tel_no == 'N'}class="Hidden"{/if}>
							<th>Tel</th>
							<td>
								<span {if $UserFieldsShow.user_tel_country_code == 'N'}class="Hidden"{/if}><input type="text" name="user_tel_country_code" value="{$smarty.request.user_tel_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $UserFieldsShow.user_tel_area_code == 'N'}class="Hidden"{/if}><input type="text" name="user_tel_area_code" value="{$smarty.request.user_tel_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="user_tel_no" value="{$smarty.request.user_tel_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_fax_country_code == 'N' && $UserFieldsShow.user_fax_area_code == 'N' && $UserFieldsShow.user_fax_no == 'N'}class="Hidden"{/if}>
							<th>Fax</th>
							<td>
								<span {if $UserFieldsShow.user_fax_country_code == 'N'}class="Hidden"{/if}><input type="text" name="user_fax_country_code" value="{$smarty.request.user_fax_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $UserFieldsShow.user_fax_area_code == 'N'}class="Hidden"{/if}><input type="text" name="user_fax_area_code" value="{$smarty.request.user_fax_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="user_fax_no" value="{$smarty.request.user_fax_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_how_to_know_this_website == 'N'}class="Hidden"{/if}>
							<th>How To Know This Website</th>
							<td><input type="text" name="user_how_to_know_this_website" value="{$smarty.request.user_how_to_know_this_website|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_join_mailinglist == 'N'}class="Hidden"{/if}>
							<th>Join Mailing List</th>
							<td>
								<input type="radio" name="user_join_mailinglist" value="Y" {if $smarty.request.user_join_mailinglist == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="user_join_mailinglist" value="N" {if $smarty.request.user_join_mailinglist != 'Y'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr>
							<th>Email Verified</th>
							<td>
								<input type="radio" name="user_is_email_verify" value="Y" {if $smarty.request.user_is_email_verify == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="user_is_email_verify" value="N" {if $smarty.request.user_is_email_verify != 'Y'}checked="checked"{/if}/> No
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_text_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								{if substr($UserCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
									<tr>
										<th>{substr($UserCustomFieldsDef.$myfield, 5)}</th>
										<td><input type="text" name="{$myfield}" value="{$smarty.request.$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{else if substr($UserCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
									<tr>
										<th>{substr($UserCustomFieldsDef.$myfield, 5)}</th>
										<td><textarea name="{$myfield}" cols="80" rows="8">{$smarty.request.$myfield|escape:'html'}</textarea></td>
									</tr>
								{else}
									<tr>
										<th>{$UserCustomFieldsDef.$myfield}</th>
										<td><input type="text" name="{$myfield}" value="{$smarty.request.$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{/if}
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_int_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$smarty.request.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_double_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$smarty.request.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_date_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$smarty.request.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$User.$myfield}</td>
								</tr>							
							{/if}
						{/section}
						<tr>
							<th>Note</th>
							<td>(For internal use only, user will not see this)<br /><textarea name="user_note" cols="80" rows="8">{$smarty.request.user_note|escape:html}</textarea></td>
						</tr>
					</table>
					<input class="HiddenSubmit" type="submit" value="Submit" />
				</div>
			</div>

			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="MemberTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_add.tpl"}
				</div>
			{/if}			
						
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
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
