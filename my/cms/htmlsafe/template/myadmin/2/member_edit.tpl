{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">編輯成員 - {$User.user_username|escape:'html'} &nbsp;
	<a href="member_list.php?page_id={$smarty.request.page_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>會員列表</a>
</h1>
	
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="member_edit_act.php">
		<input type="hidden" name="page_id" value="{$smarty.request.page_id}" />
		<div id="UserInfoTabs">
			<ul>
				<li><a href="#UserInfoTabsPanel-UserDetails">用戶詳情</a></li>
				{if $Site.site_module_bonus_point_enable == 'Y'}
					<li><a href="#UserInfoTabsPanel-BonusPointDetails">積分獎賞詳情</a></li>
				{/if}
				{if $UserFieldsShow.user_balance != 'N'}
					<li><a href="#UserInfoTabsPanel-UserBalance">用戶結餘</a></li>
				{/if}
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#UserInfoTabsPanel-Permission">權限</a></li>{/if}
			</ul>
			<div id="UserInfoTabsPanel-UserDetails">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{if $UserFieldsShow.user_thumbnail_file_id != 'N'}
							<tr>
								<th>縮圖</th>
								<td>
									{if $User.user_thumbnail_file_id != 0}
										<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$User.user_thumbnail_file_id}" /> <br />
										<input type="checkbox" name="remove_thumbnail" value="Y" /> 刪除縮略圖 <br />
									{/if}
									<input type="file" name="user_file" />
								</td>
							</tr>						
						{/if}
						<tr>
							<th>狀態</th>
							<td>
								<input type="radio" name="user_is_enable" value="Y" {if $User.user_is_enable == 'Y'}checked="checked"{/if}/> 啟用
								<input type="radio" name="user_is_enable" value="N" {if $User.user_is_enable == 'N'}checked="checked"{/if}/> 停用
							</td>
						</tr>
						<tr>
							<th>用戶名</th>
							<td><input type="text" name="user_username" value="{$User.user_username|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>電郵</th>
							<td><input type="text" name="user_email" value="{$User.user_email|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_security_level == 'N'}class="Hidden"{/if}>
							<th>安全等級</th>
							<td><input type="text" name="user_security_level" value="{$User.user_security_level}" size="80" /></td>
						</tr>
						<tr>
							<th>新密碼</th>
							<td><input type="password" name="user_password" value="" size="80" /></td>
						</tr>
						<tr>
							<th>再次輸入新密碼</th>
							<td><input type="password" name="user_password2" value="" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_language_id == 'N'}class="Hidden"{/if}>
							<th>Language</th>
							<td>
								<select name="user_language_id">
									{foreach from=$LanguageRootList item=R}
									    <option value="{$R.language_id}"
											{if $R.language_id == $User.user_language_id}selected="selected"{/if}
									    >{$R.language_native|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_currency_id == 'N'}class="Hidden"{/if}>
							<th>貨幣</th>
							<td>
								<select name="user_currency_id">
									{foreach from=$SiteCurrencyList item=C}
									    <option value="{$C.currency_id}"
											{if $C.currency_id == $User.user_currency_id}selected="selected"{/if}
									    >{$C.currency_shortname|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_title == 'N'}class="Hidden"{/if}>
							<th>稱號</th>
							<td><input type="text" name="user_title" value="{$User.user_title|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_first_name == 'N'}class="Hidden"{/if}>
							<th>名字</th>
							<td><input type="text" name="user_first_name" value="{$User.user_first_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_last_name == 'N'}class="Hidden"{/if}>
							<th>姓</th>
							<td><input type="text" name="user_last_name" value="{$User.user_last_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_company_name == 'N'}class="Hidden"{/if}>
							<th>公司/機構</th>
							<td><input type="text" name="user_company_name" value="{$User.user_company_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_city_name == 'N'}class="Hidden"{/if}>
							<th>城市</th>
							<td><input type="text" name="user_city_name" value="{$User.user_city_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_region == 'N'}class="Hidden"{/if}>
							<th>區域</th>
							<td><input type="text" name="user_region" value="{$User.user_region|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_postcode == 'N'}class="Hidden"{/if}>
							<th>郵編</th>
							<td><input type="text" name="user_postcode" value="{$User.user_postcode|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_address_1 == 'N'}class="Hidden"{/if}>
							<th>地址1</th>
							<td><input type="text" name="user_address_1" value="{$User.user_address_1|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_address_2 == 'N'}class="Hidden"{/if}>
							<th>地址2</th>
							<td><input type="text" name="user_address_2" value="{$User.user_address_2|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_country_id == 'N'}class="Hidden"{/if}>
							<th>國家</th>
							<td>
								<select name="user_country_id">
									{foreach from=$CountryList item=C}
									    <option value="{$C.country_id}"
											{if $C.country_id == $User.user_country_id}selected="selected"{/if}
									    >{$C.country_name_en|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_country_id == 'N'}class="Hidden"{/if}>
							<th>國家（其他）</th>
							<td><input type="text" name="user_country_other" value="{$User.user_country_other|escape:'html'}" size="80" /></td>							
						</tr>
						{if $User.user_country_id == 133}
							<tr {if $UserFieldsShow.user_hk_district_id == 'N'}class="Hidden"{/if}>
								<th>香港區域</th>
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
						{/if}
						<tr {if $UserFieldsShow.user_tel_country_code == 'N' && $UserFieldsShow.user_tel_area_code == 'N' && $UserFieldsShow.user_tel_no == 'N'}class="Hidden"{/if}>
							<th>電話</th>
							<td>
								<span {if $UserFieldsShow.user_tel_country_code == 'N'}class="Hidden"{/if}><input type="text" name="user_tel_country_code" value="{$User.user_tel_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $UserFieldsShow.user_tel_area_code == 'N'}class="Hidden"{/if}><input type="text" name="user_tel_area_code" value="{$User.user_tel_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="user_tel_no" value="{$User.user_tel_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_fax_country_code == 'N' && $UserFieldsShow.user_fax_area_code == 'N' && $UserFieldsShow.user_fax_no == 'N'}class="Hidden"{/if}>
							<th>傳真</th>
							<td>
								<span {if $UserFieldsShow.user_fax_country_code == 'N'}class="Hidden"{/if}><input type="text" name="user_fax_country_code" value="{$User.user_fax_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $UserFieldsShow.user_fax_area_code == 'N'}class="Hidden"{/if}><input type="text" name="user_fax_area_code" value="{$User.user_fax_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="user_fax_no" value="{$User.user_fax_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_balance == 'N'}class="Hidden"{/if}>
							<th>結餘</th>
							<td>
								{$Site.currency_shortname} {$User.user_balance|escape:'html'}
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_how_to_know_this_website == 'N'}class="Hidden"{/if}>
							<th>如何知道本網站</th>
							<td><input type="text" name="user_how_to_know_this_website" value="{$User.user_how_to_know_this_website|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $UserFieldsShow.user_join_mailinglist == 'N'}class="Hidden"{/if}>
							<th>加入郵寄名單</th>
							<td>
								<input type="radio" name="user_join_mailinglist" value="Y" {if $User.user_join_mailinglist == 'Y'}checked="checked"{/if}/> 是
								<input type="radio" name="user_join_mailinglist" value="N" {if $User.user_join_mailinglist == 'N'}checked="checked"{/if}/> 否
							</td>
						</tr>
						<tr>
							<th>電郵已核實</th>
							<td>
								<input type="radio" name="user_is_email_verify" value="Y" {if $User.user_is_email_verify == 'Y'}checked="checked"{/if}/> 是
								<input type="radio" name="user_is_email_verify" value="N" {if $User.user_is_email_verify == 'N'}checked="checked"{/if}/> 否
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_text_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								{if substr($UserCustomFieldsDef.$myfield, 0, 5) == 'STXT_'}
									<tr>
										<th>{substr($UserCustomFieldsDef.$myfield, 5)}</th>
										<td><input type="text" name="{$myfield}" value="{$User.$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{else if substr($UserCustomFieldsDef.$myfield, 0, 5) == 'MTXT_'}
									<tr>
										<th>{substr($UserCustomFieldsDef.$myfield, 5)}</th>
										<td><textarea name="{$myfield}" cols="80" rows="8">{$User.$myfield|escape:'html'}</textarea></td>
									</tr>
								{else}
									<tr>
										<th>{$UserCustomFieldsDef.$myfield}</th>
										<td><input type="text" name="{$myfield}" value="{$User.$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{/if}
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_int_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$User.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_double_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$User.$myfield|escape:'html'}" size="80" /></td>
								</tr>							
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="user_custom_date_`$smarty.section.foo.iteration`"}
							{if $UserCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$UserCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$User.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$User.$myfield}</td>
								</tr>							
							{/if}
						{/section}
						<tr>
							<th>注</th>
							<td>(僅供內部使用，用戶將不會看到)<br /><textarea name="user_note" cols="80" rows="8">{$User.user_note|escape:html}</textarea></td>
						</tr>
					</table>
				</div>
			</div>
						
			<form></form>			
						
			{if $UserFieldsShow.user_balance != 'N'}
				<div id="UserInfoTabsPanel-UserBalance">
					<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
						<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Adjust user balance</h2>
						<form enctype="multipart/form-data" name="FrmAdjustBalanceBlock" id="FrmAdjustBalanceBlock" method="post" action="member_balance_adjust.php">
							<div class="InnerContent ui-widget-content">
							<table class="LeftHeaderTable">
								<tr>
									<th>調整金額</th>
									<td><input type="text" name="user_balance_transaction_amount" value="0" size="5" /></td>
								</tr>
								<tr>
									<th>原因</th>
									<td><input type="text" name="user_balance_remark" value="" size="100" /></td>
								</tr>
							</table>
							</div>
							<div class="ui-widget-header ui-corner-bottom InnerHeader">
								<input type="hidden" name="id" value="{$smarty.request.id}" />
								<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAdjustBalanceBlock">
									<span class="ui-icon ui-icon-plusthick"></span> 確定
								</a>
								<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAdjustBalanceBlock">
									<span class="ui-icon ui-icon-cancel"></span> 重設
								</a>
							</div>
						</form>
					</div>


					<div class="AdminEditDetailsBlock">
						<table class="TopHeaderTable AlignCenter">
							<tr class="ui-state-highlight">
								<th>日期</th>
								<th>詳情</th>
								<th>支賬</th>
								<th>入賬</th>
								<th>結餘</th>
							</tr>
							{foreach from=$UserBalanceList item=B}
								<tr>
									<td>{$B.create_date}</td>
									<td>
										{if $B.user_balance_transaction_type == 'adjustment'}
											{if $B.content_admin_id != 0}
												{$B.email} 作出調整<br />
											{else if $B.system_admin_id != 0}
												調整 <br />
											{/if}
											{$B.user_balance_remark}
										{else if $B.user_balance_transaction_type == 'uorder'}
											訂單 #{$B.order_no}
										{else if $B.user_balance_transaction_type == 'recharge'}
											充值
										{else if $B.user_balance_transaction_type == 'void'}
											取消訂單 #{$B.order_no}
										{/if}
									</td>
									<td>
										{if $B.user_balance_transaction_amount < 0}
											{$B.user_balance_transaction_amount * -1}
										{/if}
									</td>
									<td>
										{if $B.user_balance_transaction_amount > 0}
											{$B.user_balance_transaction_amount}
										{/if}
									</td>
									<td>{$B.user_balance_after}</td>
								</tr>
							{/foreach}
							<tr>
								<th colspan="4" class="AlignRight">結餘</th>
								<th>{$User.user_balance}</th>
							</tr>
						</table>
					</div>				
				</div>
			{/if}
												
			{if $Site.site_module_bonus_point_enable == 'Y'}
				<div id="UserInfoTabsPanel-BonusPointDetails">
					
					{if $IsContentAdmin || $Site.site_module_workflow_enable == 'N' || in_array('acl_member_bonuspoint_manage', $EffectiveACL)}
						<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
							<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">調整積分獎賞</h2>
							<form name="FrmAddCouponBlock" id="FrmAddCouponBlock" method="post" action="member_bonuspoint_add_coupon.php">
								<div class="InnerContent ui-widget-content">
									<table class="LeftHeaderTable">
										<tr>
											<th>積分獎賞</th>
											<td><input type="text" name="user_bonuspoint_coupon_value" value="0" size="5" /></td>
										</tr>
										<tr>
											<th>有效期至</th>
											<td><input type="text" name="user_bonuspoint_coupon_expiry_date" class="DatePicker" value="{$DefaultExpiryDate}" size="10" /> (如調整屬負數，請忽略這欄)</td>
										</tr>
										<tr>
											<th>原因</th>
											<td><input type="text" name="bonus_point_reason" value="" size="100" /></td>
										</tr>
									</table>
								</div>
								<div class="ui-widget-header ui-corner-bottom InnerHeader">
									<input type="hidden" name="id" value="{$smarty.request.id}" />
									<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddCouponBlock">
										<span class="ui-icon ui-icon-plusthick"></span> 調整
									</a>
									<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddCouponBlock">
										<span class="ui-icon ui-icon-cancel"></span> 重設
									</a>
								</div>
							</form>
						</div>
					{/if}					
					
					
					
					<div class="AdminEditDetailsBlock">
						<table class="TopHeaderTable AlignCenter">
							<tr class="ui-state-highlight">
								<th>參考編號</th>
								<th>日期</th>
								<th>詳情</th>
								<th>支賬</th>
								<th>入賬</th>
								<th>結餘</th>
								<th>有效期至</th>
								<th>自訂參考編號</th>
							</tr>
							{foreach from=$UserBonusPointDetails item=B}
								<tr>
									<td>{$B.user_bonus_point_id}</td>
									<td>{$B.create_date}</td>
									<td>
										{if $B.is_auto_expire_transaction == 'N'}
											{if $B.earn_type == 'uorder'}
												{if $B.bonus_point_earned > 0}
													經訂單 #{$B.order_no} 賺取
												{else if $B.bonus_point_spent > 0}
													經訂單 #{$B.order_no} 兌換
												{/if}
											{else if $B.earn_type == 'void'}
												取消訂單 #{$B.order_no}
											{else}
												{$B.bonus_point_reason}
											{/if}
										{else}
											{if $B.earn_type == 'uorder'}
												訂單 #{$B.order_no} 到期
											{else if $B.earn_type == 'coupon'}
												參考編碼 #{$B.myorder_id} 到期
											{else if $B.earn_type == 'custom'}
												參考編碼 #{$B.myorder_id} 到期
											{else if $B.earn_type == 'void'}
												參考編碼 #{$B.myorder_id} 到期													
											{/if}
										{/if}
									</td>
									<td>{$B.bonus_point_spent}</td>
									<td>{$B.bonus_point_earned}</td>
									<td>{$B.bonus_point_amount_after}</td>
									<td>
										{if $B.expiry_date != '0000-00-00'}
											{$B.expiry_date}
										{else}
											-
										{/if}
									</td>
									<td>{$B.custom_reference_no}</td>									
{*
									<td>
										<a href="member_bonuspoint_delete.php?id={$B.user_bonus_point_id}" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
											<span class="ui-icon ui-icon-trash"></span> delete
										</a>
									</td>
*}
								</tr>
							{/foreach}
							<tr>
								<th colspan="5" class="AlignRight">結餘</th>
								<th>{$User.user_bonus_point}</th>
								<th></th>
							</tr>
						</table>
					</div>
				</div>
			{/if}
		
			
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="UserInfoTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}			
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<input type="hidden" name="id" value="{$smarty.request.id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>

{if $UserFieldsShow.user_datafile == 'Y'}
	<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">Datafile </h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table id="DatafileListTable-{$UserDatafileHolder.user_datafile_holder_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable DatafileListTable">
				<tr class="ui-state-highlight nodrop nodrag">
					<th width="50">編號</th>
					<th width="250">檔案</th>
					<th width="80">檔案大小</th>
					<th>操作</th>
				</tr>
				{if $UserDatafileList|@count == 0}
					<tr class="nodrop nodrag">
						<td colspan="3">你可以上傳任何檔案</td>
					</tr>
				{/if}
				{foreach from=$UserDatafileList item=D}
					<tr id="Datafile-{$D.datafile_id}" class="{if $D.object_is_enable == 'N'}DisabledRow{/if}">
						<td class="AlignCenter">{$D.datafile_id}</td>
						<td><a href="{$smarty.const.BASEURL}getfile.php?id={$D.datafile_file_id}" target="_preview">{$D.filename}</a></td>
						<td>{$D.size/1024|string_format:"%.2f"}kb</td>
						<td class="AlignCenter">
							<a href="datafile_edit.php?id={$D.datafile_id}&user_id={$smarty.request.id}&refer=member_edit" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯
							</a>
							<a href="datafile_delete.php?id={$D.datafile_id}&user_id={$smarty.request.id}&refer=member_edit" onclick="return confirm('警告! \n 確定刪除？');" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> 刪除
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
				檔案安全等級: <input type="text" name="datafile_security_level" value="{$Site.site_default_security_level}" />
				<br />
				<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
				<input type="hidden" name="id" value="{$UserDatafileHolder.user_datafile_holder_id}" />
				<input type="hidden" name="refer" value="member_edit" />
				<br />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-circle-plus"></span> 新增檔案
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddDatafile">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</form>
		</div>
	</div>

{/if}

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
