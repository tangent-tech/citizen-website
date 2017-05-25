	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'stock_list'}ui-tabs-selected ui-state-active{/if}"><a href="stock_list.php">Stock List</a></li>
{*			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'stock_understock_list'}ui-tabs-selected ui-state-active{/if}"><a href="stock_understock_list.php">Under Stock List</a></li> *}
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'stock_transaction_list'}ui-tabs-selected ui-state-active{/if}"><a href="stock_transaction_list.php">Transaction List</a></li>
			<li id="stock_in_out_cart_tab" class="ui-state-default ui-corner-top {if $CurrentTab2 == 'stock_in_out_cart_details'}ui-tabs-selected ui-state-active{/if}"><a href="stock_in_out_cart_details.php">Stock In/Out Basket</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
