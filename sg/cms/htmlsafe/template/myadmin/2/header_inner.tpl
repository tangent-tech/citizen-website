{include file="myadmin/`$CurrentLang['language_id']`/header.tpl"}
	<div id="Header">
		<div id="RightHeaderContainer">
			<form name="FrmSetSiteID" id="FrmSetSiteID" method="post">
				<p>
					正在管理:
					<select id="set_site_id" name="set_site_id">
						{section name=index loop=$SystemAdminSiteList}
						    <option value="{$SystemAdminSiteList[index].site_id}"
								{if $SystemAdminSiteList[index].site_id == $smarty.session.site_id}selected="selected"{/if}
						    >{$SystemAdminSiteList[index].site_name|escape:'html'}</option>
						{/section}
					</select>
					<a id="set_site_id_button" href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmSetSiteID">
						<span class="ui-icon ui-icon-circle-arrow-e"></span> 前往
					</a>
					<input class="HiddenSubmit" type="submit" value="Submit" />
				</p>
				{if !$IsSiteAdmin && $Site.site_module_workflow_enable == 'Y'}
					<p>
						<a href="content_admin_msg_list.php">
							{if $ContentAdminUnreadMsgNo > 0}
								<span class="ui-icon ui-icon-alert" style="display: inline-block; margin: 0 0 -5px 0"></span>
								你有{$ContentAdminUnreadMsgNo}個新訊息
							{else}
								你未有新訊息
							{/if}
						</a>
					</p>
				{/if}
				<p>
					{$AdminInfo.email|escape:'html'} | <a href="content_admin_setting.php">設定</a> | <a href="logout.php">登出</a> <br />
				</p>
				<p>
					屏幕寬度:
					{foreach $ScreenWidth as $W}
						<a href="ui_set_screen_size.php?width={$W}" class="ScreenWidthSelection {if $W==$AdminInfo.screen_width} ui-state-active{/if}" data-width="{$W}">{$W@key}</a>
					{/foreach}
				</p>
				<p>
					<a href="?lang_id=1" {if $smarty.session.LangID == 1}class="ui-state-active"{/if}>English</a> | <a href="?lang_id=2" {if $smarty.session.LangID == 2}class="ui-state-active"{/if}>繁體 (beta)</a>
				</p>
			</form>
		</div>
		{if $Site.site_admin_logo_url != ''}
			<img src="{$Site.site_admin_logo_url}" />
		{else}
			<img src="../images/aveego_logo.png" />
		{/if}
		 <h3>網站管理</h3>
		 <br class="clearfloat" />
	</div>
	<div id="SecurityLevelDialog" title="Approval Request">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 5px 0;"></span>在確定提交時，審批請求將被發送到相關的管理員</p>
	</div>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all ContentContainer">
		<ul class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $IsSuperAdmin}
				<li class="ui-state-default ui-corner-top {if $CurrentTab == 'super_admin'}ui-tabs-selected ui-state-active{/if}"><a href="system_admin_list.php">SA</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab == 'super_seo'}ui-tabs-selected ui-state-active{/if}"><a href="z_seo_article_submit.php">SEO</a></li>
			{/if}
			{if $IsSiteAdmin}
				<li class="ui-state-default ui-corner-top {if $CurrentTab == 'site_admin'}ui-tabs-selected ui-state-active{/if}"><a href="site_setting.php">網站管理設定</a></li>
			{/if}
			{if $IsContentAdmin}
				{if $Site.site_module_article_enable == 'Y'}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'site_setting_general'}ui-tabs-selected ui-state-active{/if}"><a href="site_setting_general.php">網站設定</a></li>
				{/if}
				{if $Site.site_module_content_writer_enable == 'Y'}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'site_content_writer'}ui-tabs-selected ui-state-active{/if}"><a href="site_content_writer_list.php">內容管理人員</a></li>
				{/if}
			{/if}
			{if $IsContentWriter}
				{if $Site.site_module_article_enable == 'Y'}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'site_content'}ui-tabs-selected ui-state-active{/if}"><a href="language_root_list.php">網站內容</a></li>
				{/if}
				{if $Site.site_module_member_enable == 'Y' && in_array('acl_module_member_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'member'}ui-tabs-selected ui-state-active{/if}"><a href="member_list.php">
會員</a></li>
				{/if}
				{if $Site.site_module_bonus_point_enable == 'Y' && in_array('acl_module_bonus_point_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'bonuspoint'}ui-tabs-selected ui-state-active{/if}"><a href="bonuspoint_list.php">積分獎賞</a></li>
				{/if}
				{if $Site.site_module_product_enable == 'Y' && in_array('acl_module_currency_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'currency'}ui-tabs-selected ui-state-active{/if}"><a href="currency_list.php">貨幣</a></li>
				{/if}
				{if $Site.site_module_order_enable == 'Y' && in_array('acl_module_order_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'order'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=N&order_type=order">訂單</a></li>
					{if $Site.site_order_show_redeem_tab == 'Y' && in_array('acl_module_redeem_show', $EffectiveACL)}
						<li class="ui-state-default ui-corner-top {if $CurrentTab == 'redeem'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=N&order_type=redeem">禮品贖回單</a></li>
					{/if}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'sales_report'}ui-tabs-selected ui-state-active{/if}"><a href="sales_report_payment_method.php">銷售報告</a></li>
				{/if}
				{if $Site.site_module_inventory_enable == 'Y' && in_array('acl_module_inventory_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'inventory'}ui-tabs-selected ui-state-active{/if}"><a href="stock_list.php">庫存</a></li>
				{/if}
				{if $Site.site_module_discount_rule_enable == 'Y' && in_array('acl_module_discount_rule_show', $EffectiveACL)}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'discount_rule'}ui-tabs-selected ui-state-active{/if}"><a href="discount_preprocess_rule_list.php">折扣規則</a></li>
				{/if}
			{/if}
			{if $IsElasingUser}
				{if $Site.site_module_elasing_enable == 'Y'}
					<li class="ui-state-default ui-corner-top {if $CurrentTab == 'newsletter'}ui-tabs-selected ui-state-active{/if}"><a href="elasing_mailing_list.php">電郵通訊</a></li>
				{/if}
			{/if}
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content" id="Content">
