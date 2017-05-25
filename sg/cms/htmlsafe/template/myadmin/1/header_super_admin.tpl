	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'system_admin'}ui-tabs-selected ui-state-active{/if}"><a href="system_admin_list.php">System Admin</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'content_admin'}ui-tabs-selected ui-state-active{/if}"><a href="content_admin_list.php">Content Admin</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'site_management'}ui-tabs-selected ui-state-active{/if}"><a href="site_list.php">Sites</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'api_error_msg_default_list'}ui-tabs-selected ui-state-active{/if}"><a href="api_error_msg_default_list.php">API Error Messages</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">