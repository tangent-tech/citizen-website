	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'git_management'}ui-tabs-selected ui-state-active{/if}"><a href="git_repo_list.php">Git</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'site'}ui-tabs-selected ui-state-active{/if}"><a href="site_setting.php">Site</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'language'}ui-tabs-selected ui-state-active{/if}"><a href="language_manage.php">Language</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'layout'}ui-tabs-selected ui-state-active{/if}"><a href="layout_list.php">Layout</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'siteblock'}ui-tabs-selected ui-state-active{/if}"><a href="siteblock_def_list.php">Site Block</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'product'}ui-tabs-selected ui-state-active{/if}"><a href="product_root_list.php">Product Root</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'news_root'}ui-tabs-selected ui-state-active{/if}"><a href="news_root_list.php">News Root</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'layout_news_root'}ui-tabs-selected ui-state-active{/if}"><a href="layout_news_root_list.php">Layout News Root</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'field_setting'}ui-tabs-selected ui-state-active{/if}"><a href="field_setting.php">Field Setting</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'api_error_msg_list_client'}ui-tabs-selected ui-state-active{/if}"><a href="api_error_msg_list_client.php">API Error Messages</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'callback_log'}ui-tabs-selected ui-state-active{/if}"><a href="callback_log.php">Callback Log</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
