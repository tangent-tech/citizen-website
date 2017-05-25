{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Edit Discount Bundle Rule</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_bundle_rule_edit_act.php">
		<div id="DiscountBundleRuleTabs">
			<ul>
				<li><a href="#DiscountBundleRuleTabsPanel-CommonData">Common Data</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DiscountBundleRuleTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="DiscountBundleRuleTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> Rule Reference Name </th>
							<td> <input type="text" name="object_name" value="{$BundleRule.object_name}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Discount Code </th>
							<td>
								<textarea name="discount_bundle_rule_discount_code">{$DiscountText}</textarea> <br />
{*								<input type="text" name="discount_postprocess_rule_discount_code" value="{$DiscountText}" size="90" maxlength="255" /> <br /> *}
								Leave blank if no discount code is required to activate this rule <br />
								You may use comma(,) to seperate multiple discount codes
							</td>
						</tr>
						<tr>
							<th> Maximum PRODUCT QTY to apply this rule per user </th>
							<td> 
								<input type="text" name="discount_bundle_rule_quota_user" value="{$BundleRule.discount_bundle_rule_quota_user}" size="6" maxlength="6" /> <br />
								Enter 0 if unlimited quota.
							</td>
						</tr>
						<tr>
							<th> Maximum PRODUCT QTY to apply this rule for ALL user </th>
							<td> 
								{$RuleGlobalQty} / <input type="text" name="discount_bundle_rule_quota_all" value="{$BundleRule.discount_bundle_rule_quota_all}" size="6" maxlength="6" /><br />
								Enter 0 if unlimited quota.
							</td>
						</tr>
						<tr>
							<th> Discount Code Quota (Per discount code) </th>
							<td>
								<input type="text" name="discount_bundle_rule_quota_discount_code" value="{$BundleRule.discount_bundle_rule_quota_discount_code}" size="6" maxlength="6" /> <br />
								Enter 0 if unlimited quota.
							</td>
						</tr>
						<tr>
							<th> Also apply to bonus point payment products? </th>
							<td>
								<input type="radio" name="discount_bundle_rule_apply_to_bonus_point_payment_products" value="Y" {if $BundleRule.discount_bundle_rule_apply_to_bonus_point_payment_products == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="discount_bundle_rule_apply_to_bonus_point_payment_products" value="N" {if $BundleRule.discount_bundle_rule_apply_to_bonus_point_payment_products == 'N'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr>
							<th> Stop processing any rules below this rule</th>
							<td>
								<input type="radio" name="discount_bundle_rule_stop_process_below_rules" value="Y" {if $BundleRule.discount_bundle_rule_stop_process_below_rules == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="discount_bundle_rule_stop_process_below_rules" value="N" {if $BundleRule.discount_bundle_rule_stop_process_below_rules == 'N'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr>
							<th> Stop processing any pre/post process rules</th>
							<td>
								<input type="radio" name="discount_bundle_rule_stop_process_prepostprocess_rules" value="Y" {if $BundleRule.discount_bundle_rule_stop_process_prepostprocess_rules == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="discount_bundle_rule_stop_process_prepostprocess_rules" value="N" {if $BundleRule.discount_bundle_rule_stop_process_prepostprocess_rules == 'N'}checked="checked"{/if}/> No
							</td>
						</tr>
					</table>
				</div>
				
				<div id="ItemCostConditionRuleListDiv">
					<h2>Cost Aware Items</h2>
					<table id="DiscountBundleRuleItemCostConditionListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight nodrop nodrag">
							<th class="AlignLeft"><a id="AddMoreItemCostConditionLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
							<th>Condition Type</th>
							<th>Parameter</th>
							<th>Required Quantity</th>
						</tr>
						{foreach $ItemCostAwareConditionList as $COND}
							<tr class="ItemCostConditionInput">
								<td class="AlignLeft"><a class="RemoveItemCostConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
								<td>
									<select name="discount_bundle_item_cost_condition_type_id[]" class="ItemCostConditionTypeIDInput">
										<option value="0"></option>
										{foreach $BundleDiscountConditionType as $T}
											<option value="{$T@iteration}" {if $T@iteration==$COND.discount_bundle_item_condition_type_id}selected="selected"{/if}>{$T}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<div class="ItemCostConditionParameterContainer1 ItemCostConditionParameterContainer Hidden">
										<select name="cost_product_category_id[]">
											{foreach $ProductCatList as $C}
												<option value="{$C.product_category_id}" {if $C.product_category_id==$COND.discount_bundle_item_condition_product_category_id}selected="selected"{/if}>{$C.object_name}</option>
											{/foreach}
										</select>
										<br />
										Include its sub-category:
										<select name="cost_include_sub_product_cat[]">
											<option value="N" {if $COND.discount_bundle_item_condition_include_sub_category==N}selected="selected"{/if}>No</option>
											<option value="Y" {if $COND.discount_bundle_item_condition_include_sub_category==Y}selected="selected"{/if}>Yes</option>
										</select>
									</div>
									<div class="ItemCostConditionParameterContainer2 ItemCostConditionParameterContainer Hidden">
										<select name="cost_product_category_special_id[]">
											{foreach $ProductCatSpecialList as $S}
												{if $Site.site_product_category_special_max_no == $S@index}
													{break}
												{/if}
												<option value="{$S.product_category_special_id}" {if $S.product_category_special_id==$COND.discount_bundle_item_condition_product_category_id}selected="selected"{/if}>{$S.object_name}</option>
											{/foreach}
										</select>		
									</div>
									<div class="ItemCostConditionParameterContainer3 ItemCostConditionParameterContainer Hidden">
										<input type="text" name="cost_product_id[]" value="{$COND.discount_bundle_item_condition_product_id}" />
									</div>
								</td>
								<td>
									<input type="text" name="cost_quantity[]" value="{$COND.discount_bundle_item_condition_quantity}" />
								</td>
							</tr>
						{/foreach}

						<tr class="ItemCostConditionInput Hidden">
							<td class="AlignLeft"><a class="RemoveItemCostConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
							<td>
								<select name="discount_bundle_item_cost_condition_type_id[]" class="ItemCostConditionTypeIDInput">
									<option value="0"></option>
									{foreach $BundleDiscountConditionType as $T}
										<option value="{$T@iteration}">{$T}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<div class="ItemCostConditionParameterContainer1 ItemCostConditionParameterContainer Hidden">
									<select name="cost_product_category_id[]">
										{foreach $ProductCatList as $C}
											<option value="{$C.product_category_id}">{$C.object_name}</option>
										{/foreach}
									</select>
									<br />
									Include its sub-category:
									<select name="cost_include_sub_product_cat[]">
										<option value="N">No</option>
										<option value="Y">Yes</option>
									</select>
								</div>
								<div class="ItemCostConditionParameterContainer2 ItemCostConditionParameterContainer Hidden">
									<select name="cost_product_category_special_id[]">
										{foreach $ProductCatSpecialList as $S}
											{if $Site.site_product_category_special_max_no == $S@index}
												{break}
											{/if}
											<option value="{$S.product_category_special_id}">{$S.object_name}</option>
										{/foreach}
									</select>
								</div>
								<div class="ItemCostConditionParameterContainer3 ItemCostConditionParameterContainer Hidden">
									<input type="text" name="cost_product_id[]" value="{$COND.discount_bundle_item_condition_product_id}" />
								</div>
							</td>
							<td>
								<input type="text" name="cost_quantity[]" />
							</td>
						</tr>
					</table>
				</div>

				<div id="ItemFreeConditionRuleListDiv">
					<h2>Free Items</h2>
					<table id="DiscountBundleRuleItemFreeConditionListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight nodrop nodrag">
							<th class="AlignLeft"><a id="AddMoreItemFreeConditionLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
							<th>Condition Type</th>
							<th>Parameter</th>
							<th>Required Quantity</th>
						</tr>
						{foreach $ItemFreeConditionList as $COND}
							<tr class="ItemFreeConditionInput">
								<td class="AlignLeft"><a class="RemoveItemFreeConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
								<td>
									<select name="discount_bundle_item_free_condition_type_id[]" class="ItemFreeConditionTypeIDInput">
										<option value="0"></option>
										{foreach $BundleDiscountConditionType as $T}
											<option value="{$T@iteration}" {if $T@iteration==$COND.discount_bundle_item_condition_type_id}selected="selected"{/if}>{$T}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<div class="ItemFreeConditionParameterContainer1 ItemFreeConditionParameterContainer Hidden">
										<select name="free_product_category_id[]">
											{foreach $ProductCatList as $C}
												<option value="{$C.product_category_id}" {if $C.product_category_id==$COND.discount_bundle_item_condition_product_category_id}selected="selected"{/if}>{$C.object_name}</option>
											{/foreach}
										</select>
										<br />
										Include its sub-category:
										<select name="free_include_sub_product_cat[]">
											<option value="N" {if $COND.discount_bundle_item_condition_include_sub_category==N}selected="selected"{/if}>No</option>
											<option value="Y" {if $COND.discount_bundle_item_condition_include_sub_category==Y}selected="selected"{/if}>Yes</option>
										</select>
									</div>
									<div class="ItemFreeConditionParameterContainer2 ItemFreeConditionParameterContainer Hidden">
										<select name="free_product_category_special_id[]">
											{foreach $ProductCatSpecialList as $S}
												{if $Site.site_product_category_special_max_no == $S@index}
													{break}
												{/if}
												<option value="{$S.product_category_special_id}" {if $S.product_category_special_id==$COND.discount_bundle_item_condition_product_category_id}selected="selected"{/if}>{$S.object_name}</option>
											{/foreach}
										</select>		
									</div>
									<div class="ItemFreeConditionParameterContainer3 ItemFreeConditionParameterContainer Hidden">
										<input type="text" name="free_product_id[]" value="{$COND.discount_bundle_item_condition_product_id}" />
									</div>
								</td>
								<td>
									<input type="text" name="free_quantity[]" value="{$COND.discount_bundle_item_condition_quantity}" />
								</td>
							</tr>
						{/foreach}

						<tr class="ItemFreeConditionInput Hidden">
							<td class="AlignLeft"><a class="RemoveItemFreeConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
							<td>
								<select name="discount_bundle_item_free_condition_type_id[]" class="ItemFreeConditionTypeIDInput">
									<option value="0"></option>
									{foreach $BundleDiscountConditionType as $T}
										<option value="{$T@iteration}">{$T}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<div class="ItemFreeConditionParameterContainer1 ItemFreeConditionParameterContainer Hidden">
									<select name="free_product_category_id[]">
										{foreach $ProductCatList as $C}
											<option value="{$C.product_category_id}">{$C.object_name}</option>
										{/foreach}
									</select>
									<br />
									Include its sub-category:
									<select name="free_include_sub_product_cat[]">
										<option value="N">No</option>
										<option value="Y">Yes</option>
									</select>
								</div>
								<div class="ItemFreeConditionParameterContainer2 ItemFreeConditionParameterContainer Hidden">
									<select name="free_product_category_special_id[]">
										{foreach $ProductCatSpecialList as $S}
											{if $Site.site_product_category_special_max_no == $S@index}
												{break}
											{/if}
											<option value="{$S.product_category_special_id}">{$S.object_name}</option>
										{/foreach}
									</select>
								</div>
								<div class="ItemFreeConditionParameterContainer3 ItemFreeConditionParameterContainer Hidden">
									<input type="text" name="free_product_id[]" value="{$COND.discount_bundle_item_condition_product_id}" />
								</div>
							</td>
							<td>
								<input type="text" name="free_quantity[]" />
							</td>
						</tr>
					</table>
				</div>

				<div id="BundleRuleDiscountDiv">
					{foreach $BundleRulePriceList as $PLIndex => $PL}
						<h2>{$PL.currency_name} Discount</h2>
						<p>
							{assign var='PriceRow' value=$PL['price']}
							{if $PLIndex != 0}
								<input type="radio" name="discount_bundle_discount_type_id[{$PLIndex}]" value="-1" {if $PriceRow == null}checked="checked"{/if}/> Disable
								<br />
							{/if}
							<input type="radio" name="discount_bundle_discount_type_id[{$PLIndex}]" value="1" {if $PriceRow.discount_bundle_discount_type_id == 1}checked="checked"{/if} /> Buy at <input type="text" name="discount_bundle_discount1_off_p[{$PLIndex}]" value="{$PriceRow.discount_bundle_discount1_off_p}" maxlength="2" size="2" />% off<br />
							<input type="radio" name="discount_bundle_discount_type_id[{$PLIndex}]" value="2" {if $PriceRow.discount_bundle_discount_type_id == 2}checked="checked"{/if} /> Buy at $ <input type="text" name="discount_bundle_discount2_at_price[{$PLIndex}]" value="{$PriceRow.discount_bundle_discount2_at_price}" maxlength="8" size="8" /> <br />
							<input type="radio" name="discount_bundle_discount_type_id[{$PLIndex}]" value="3" {if $PriceRow.discount_bundle_discount_type_id == 3}checked="checked"{/if} /> Add $ <input type="text" name="discount_bundle_discount3_add_price[{$PLIndex}]" value="{$PriceRow.discount_bundle_discount3_add_price}"  maxlength="8" size="8" /> to original price
						</p>
						<br />
					{/foreach}
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountBundleRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>Rule Name</th>
								<td><input type="text" name="discount_bundle_rule_name[{$R.language_id}]" value="{$BundleRuleData[$R.language_id].discount_bundle_rule_name|escape:'html'}" size="90" maxlength="255" /></td>
							</tr>
							<tr>
								<th>Rule Desc</th>
								<td>
									{$EditorHTML[$R.language_id]}
								</td>
							</tr>
						</table>
					</div>
			   </div>
			{/foreach}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
