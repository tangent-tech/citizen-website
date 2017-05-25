	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $Site.site_module_bundle_rule_enable == 'Y'}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'discount_product_link_update_status'}ui-tabs-selected ui-state-active{/if}"><a href="discount_product_link_update_status.php">Product Tagging</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'discount_bundle_rule_list'}ui-tabs-selected ui-state-active{/if}"><a href="discount_bundle_rule_list.php">Bundle Rule List</a></li>
			{/if}
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'discount_preprocess_rule_list'}ui-tabs-selected ui-state-active{/if}"><a href="discount_preprocess_rule_list.php">Preprocess Rule List</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'discount_postprocess_rule_list'}ui-tabs-selected ui-state-active{/if}"><a href="discount_postprocess_rule_list.php">Postprocess Rule List</a></li>
			<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'discount_rule_test'}ui-tabs-selected ui-state-active{/if}"><a href="discount_rule_test.php">Test</a></li>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">