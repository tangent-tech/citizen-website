	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'git_management'}ui-tabs-selected ui-state-active{/if}"><a href="git_repo_list.php">Git</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'site'}ui-tabs-selected ui-state-active{/if}"><a href="site_setting.php">網站</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'language'}ui-tabs-selected ui-state-active{/if}"><a href="language_manage.php">
語言</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'layout'}ui-tabs-selected ui-state-active{/if}"><a href="layout_list.php">排版</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'siteblock'}ui-tabs-selected ui-state-active{/if}"><a href="siteblock_def_list.php">網站區塊</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'product'}ui-tabs-selected ui-state-active{/if}"><a href="product_root_list.php">產品根</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'news_root'}ui-tabs-selected ui-state-active{/if}"><a href="news_root_list.php">
新聞根</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'layout_news_root'}ui-tabs-selected ui-state-active{/if}"><a href="layout_news_root_list.php">排版新聞根</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'field_setting'}ui-tabs-selected ui-state-active{/if}"><a href="field_setting.php">欄位設定</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'api_error_msg_list_client'}ui-tabs-selected ui-state-active{/if}"><a href="api_error_msg_list_client.php">API Error Messages</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'callback_log'}ui-tabs-selected ui-state-active{/if}"><a href="callback_log.php">Callback Log</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
