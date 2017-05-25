	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $Site.site_module_elasing_multi_level == 'Y' && $IsContentAdmin}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'elasing_user_list'}ui-tabs-selected ui-state-active{/if}"><a href="elasing_user_list.php">User List</a></li>
			{/if}
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'elasing_mailing_list'}ui-tabs-selected ui-state-active{/if}"><a href="elasing_mailing_list.php">Mailing List</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'elasing_campaign_list'}ui-tabs-selected ui-state-active{/if}"><a href="elasing_campaign_list.php">Campaign List</a></li>
			{if $IsContentAdmin}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'elasing_quota'}ui-tabs-selected ui-state-active{/if}"><a href="elasing_quota.php">Quota and Setting</a></li>
			{/if}
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
