	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'member_all'}ui-tabs-selected ui-state-active{/if}"><a href="member_list.php?enable=all">所有會員</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'member_enable'}ui-tabs-selected ui-state-active{/if}"><a href="member_list.php?enable=Y">啟用會員</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'member_disable'}ui-tabs-selected ui-state-active{/if}"><a href="member_list.php?enable=N">停用會員</a></li>
			{if $UserFieldsShow.user_balance != 'N'}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'member_balance_list'}ui-tabs-selected ui-state-active{/if}"><a href="member_balance_list.php">會員餘額</a></li>
			{/if}
			{if $Site.site_module_bonus_point_enable == 'Y'}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'member_bonus_point_list'}ui-tabs-selected ui-state-active{/if}"><a href="member_bonus_point_list.php">會員積分獎賞</a></li>
			{/if}
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
