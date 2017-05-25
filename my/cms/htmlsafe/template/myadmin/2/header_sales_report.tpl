	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $CurrentTab == 'sales_report' }
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'sales_report_payment_method'}ui-tabs-selected ui-state-active{/if}"><a href="sales_report_payment_method.php">Summary By Payment Method</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'sales_report_country'}ui-tabs-selected ui-state-active{/if}"><a href="sales_report_country.php">Summary By Country</a></li>
			{/if}
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
