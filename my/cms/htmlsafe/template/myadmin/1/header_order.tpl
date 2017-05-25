	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $CurrentTab == 'order' }
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_all'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=ALL&order_type=order">All Orders</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_not_handled'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=N&order_type=order">Outstanding Orders</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_handled'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=Y&order_type=order">Handled Orders</a></li>
			{else}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_all'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=ALL&order_type=redeem">All Redeems</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_not_handled'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=N&order_type=redeem">Outstanding Redeems</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_handled'}ui-tabs-selected ui-state-active{/if}"><a href="order_list.php?handled=Y&order_type=redeem">Handled Redeems</a></li>
			{/if}
			{if ($Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y') && $CurrentTab == 'order' }
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_shipment_list'}ui-tabs-selected ui-state-active{/if}"><a href="order_shipment_list.php">Shipments</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'order_outstanding_shipment_list'}ui-tabs-selected ui-state-active{/if}"><a href="order_outstanding_shipment_list.php">Outstanding Shipments</a></li>
			{/if}			
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
