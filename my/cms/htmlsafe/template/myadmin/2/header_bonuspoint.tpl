	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'bonuspoint_list_all'}ui-tabs-selected ui-state-active{/if}"><a href="bonuspoint_list.php?enable=all">所有積分獎賞產品</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'bonuspoint_list_enable'}ui-tabs-selected ui-state-active{/if}"><a href="bonuspoint_list.php?enable=Y">啟用積分獎賞產品</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'bonuspoint_list_disable'}ui-tabs-selected ui-state-active{/if}"><a href="bonuspoint_list.php?enable=N">停用積分獎賞產品</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
