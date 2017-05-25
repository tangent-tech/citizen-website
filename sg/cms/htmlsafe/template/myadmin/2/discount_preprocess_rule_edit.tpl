{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">編輯前處理折扣規則</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_preprocess_rule_edit_act.php">
		<div id="DiscountPreprocessRuleTabs">
			<ul>
				<li><a href="#DiscountPreprocessRuleTabsPanel-CommonData">一般資料</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DiscountPreprocessRuleTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="DiscountPreprocessRuleTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> 規則參考名稱 </th>
							<td> <input type="text" name="object_name" value="{$PreprocessRule.object_name}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> 折扣碼 </th>
							<td>
								<textarea name="discount_preprocess_rule_discount_code">{$DiscountText}</textarea> <br />
{*								<input type="text" name="discount_postprocess_rule_discount_code" value="{$DiscountText}" size="90" maxlength="255" /> <br /> *}
								若不需要折扣碼啟動，請留空。 <br />
								你可以用逗號(,)分隔多個折扣碼								
							</td>
						</tr>
						<tr>
							<th> 每個用戶最多應用此折扣的產品數量 </th>
							<td> 
								<input type="text" name="discount_preprocess_rule_quota_user" value="{$PreprocessRule.discount_preprocess_rule_quota_user}" size="6" maxlength="6" /> <br />
								無限配額，請輸入0
							</td>
						</tr>
						<tr>
							<th> 所有用戶合共最多應用此折扣的產品數量 </th>
							<td> 
								{$RuleGlobalQty} / <input type="text" name="discount_preprocess_rule_quota_all" value="{$PreprocessRule.discount_preprocess_rule_quota_all}" size="6" maxlength="6" /><br />
								無限配額，請輸入0
							</td>
						</tr>
						<tr>
							<th> 折扣碼配額(每一個折扣碼) </th>
							<td>
								<input type="text" name="discount_preprocess_rule_quota_discount_code" value="{$PreprocessRule.discount_preprocess_rule_quota_discount_code}" size="6" maxlength="6" /> <br />
								無限配額，請輸入0
							</td>
						</tr>
						<tr>
							<th> 用積分付款的產品也可使用 </th>
							<td>
								<input type="radio" name="discount_preprocess_rule_apply_to_bonus_point_payment_products" value="Y" {if $PreprocessRule.discount_preprocess_rule_apply_to_bonus_point_payment_products == 'Y'}checked="checked"{/if}/> 是
								<input type="radio" name="discount_preprocess_rule_apply_to_bonus_point_payment_products" value="N" {if $PreprocessRule.discount_preprocess_rule_apply_to_bonus_point_payment_products == 'N'}checked="checked"{/if}/> 否								
							</td>
						</tr>						
						<tr>
							<th> 停止處理其他較低的規則　</th>
							<td>
								<input type="radio" name="discount_preprocess_rule_stop_process_below_rules" value="Y" {if $PreprocessRule.discount_preprocess_rule_stop_process_below_rules == 'Y'}checked="checked"{/if}/> 是
								<input type="radio" name="discount_preprocess_rule_stop_process_below_rules" value="N" {if $PreprocessRule.discount_preprocess_rule_stop_process_below_rules == 'N'}checked="checked"{/if}/> 否
							</td>
						</tr>
						<tr>
							<th> 停止處理其他後處理折扣規則　</th>
							<td>
								<input type="radio" name="discount_preprocess_rule_stop_process_postprocess_rules" value="Y" {if $PreprocessRule.discount_preprocess_rule_stop_process_postprocess_rules == 'Y'}checked="checked"{/if}/> 是
								<input type="radio" name="discount_preprocess_rule_stop_process_postprocess_rules" value="N" {if $PreprocessRule.discount_preprocess_rule_stop_process_postprocess_rules == 'N'}checked="checked"{/if}/> 否
							</td>
						</tr>
					</table>
				</div>
				
				<div id="ItemConditionRuleListDiv">
					<h2>項目條件 (需同時符合) </h2>
					<table id="DiscountPreprocessRuleItemConditionListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight nodrop nodrag">
							<th class="AlignLeft"><a id="AddMoreItemConditionLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
							<th>條件類型</th>
							<th>參數</th>
						</tr>
						{foreach $ItemConditionList as $COND}
							<tr class="ItemConditionInput">
								<td class="AlignLeft"><a class="RemoveItemConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
								<td>
									<select name="discount_preprocess_item_condition_type_id[]" class="ItemConditionTypeIDInput">
										<option value="0"></option>
										{foreach $DiscountPreprocessConditionType as $T}
											<option value="{$T@iteration}" {if $T@iteration==$COND.discount_preprocess_item_condition_type_id}selected="selected"{/if}>{$T}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<div class="ItemConditionParameterContainer1 ItemConditionParameterContainer Hidden">
										<select name="product_category_id[]">
											{foreach $ProductCatList as $C}
												<option value="{$C.product_category_id}" {if $C.product_category_id==$COND.discount_preprocess_item_condition_para_int_1}selected="selected"{/if}>{$C.object_name}</option>
											{/foreach}
										</select>
										<br />
										包括它的子分類:
										<select name="include_sub_product_cat[]">
											<option value="0" {if $COND.discount_preprocess_item_condition_para_int_2==0}selected="selected"{/if}>否</option>
											<option value="1" {if $COND.discount_preprocess_item_condition_para_int_2==1}selected="selected"{/if}>是</option>
										</select>
									</div>
									<div class="ItemConditionParameterContainer2 ItemConditionParameterContainer Hidden">
										<select name="product_brand_id[]">
											{foreach $ProductBrandList as $B}
												<option value="{$B.product_brand_id}" {if $B.product_brand_id==$COND.discount_preprocess_item_condition_para_int_1}selected="selected"{/if}>{$B.object_name}</option>
											{/foreach}
										</select>
									</div>
									<div class="ItemConditionParameterContainer3 ItemConditionParameterContainer Hidden">
										<select name="product_category_special_id[]">
											{foreach $ProductCatSpecialList as $S}
												{if $Site.site_product_category_special_max_no == $S@index}
													{break}
												{/if}
												<option value="{$S.product_category_special_id}" {if $S.product_category_special_id==$COND.discount_preprocess_item_condition_para_int_1}selected="selected"{/if}>{$S.object_name}</option>
											{/foreach}
										</select>		
									</div>
								</td>
							</tr>
						{/foreach}
						<tr class="ItemConditionInput Hidden">
							<td class="AlignLeft"><a class="RemoveItemConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
							<td>
								<select name="discount_preprocess_item_condition_type_id[]" class="ItemConditionTypeIDInput">
									<option value="0"></option>
									{foreach $DiscountPreprocessConditionType as $T}
										<option value="{$T@iteration}">{$T}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<div class="ItemConditionParameterContainer1 ItemConditionParameterContainer Hidden">
									<select name="product_category_id[]">
										{foreach $ProductCatList as $C}
											<option value="{$C.product_category_id}">{$C.object_name}</option>
										{/foreach}
									</select>
									<br />
									包括它的子分類:
									<select name="include_sub_product_cat[]">
										<option value="0">否</option>
										<option value="1">是</option>
									</select>
								</div>
								<div class="ItemConditionParameterContainer2 ItemConditionParameterContainer Hidden">
									<select name="product_brand_id[]">
										{foreach $ProductBrandList as $B}
											<option value="{$B.product_brand_id}">{$B.object_name}</option>
										{/foreach}
									</select>
								</div>
								<div class="ItemConditionParameterContainer3 ItemConditionParameterContainer Hidden">
									<select name="product_category_special_id[]">
										{foreach $ProductCatSpecialList as $S}
											{if $Site.site_product_category_special_max_no == $S@index}
												{break}
											{/if}
											<option value="{$S.product_category_special_id}">{$S.object_name}</option>
										{/foreach}
									</select>		
								</div>
							</td>
						</tr>
					</table>
				</div>

				<div id="ItemExceptConditionRuleListDiv">
					<h2>剔除附合以下條件 (附合任何一項) </h2>
					<table id="DiscountPreprocessRuleItemExceptConditionListTable" class="TopHeaderTable">
						<tr class="ui-state-highlight nodrop nodrag">
							<th class="AlignLeft"><a id="AddMoreItemExceptConditionLink" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
							<th>條件類型</th>
							<th>參數</th>
						</tr>
						{foreach $ItemExceptConditionList as $COND}
							<tr class="ItemExceptConditionInput">
								<td class="AlignLeft"><a class="RemoveItemExceptConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
								<td>
									<select name="discount_preprocess_item_except_condition_type_id[]" class="ItemExceptConditionTypeIDInput">
										<option value="0"></option>
										{foreach $DiscountPreprocessConditionType as $T}
											<option value="{$T@iteration}" {if $T@iteration==$COND.discount_preprocess_item_except_condition_type_id}selected="selected"{/if}>{$T}</option>
										{/foreach}
									</select>
								</td>
								<td>
									<div class="ItemExceptConditionParameterContainer1 ItemExceptConditionParameterContainer Hidden">
										<select name="except_product_category_id[]">
											{foreach $ProductCatList as $C}
												<option value="{$C.product_category_id}" {if $C.product_category_id==$COND.discount_preprocess_item_except_condition_para_int_1}selected="selected"{/if}>{$C.object_name}</option>
											{/foreach}
										</select>
										<br />
										 包括它的子分類: 
										<select name="except_include_sub_product_cat[]">
											<option value="0" {if $COND.discount_preprocess_item_except_condition_para_int_2==0}selected="selected"{/if}>否</option>
											<option value="1" {if $COND.discount_preprocess_item_except_condition_para_int_2==1}selected="selected"{/if}>是</option>
										</select>
									</div>
									<div class="ItemExceptConditionParameterContainer2 ItemExceptConditionParameterContainer Hidden">
										<select name="except_product_brand_id[]">
											{foreach $ProductBrandList as $B}
												<option value="{$B.product_brand_id}" {if $B.product_brand_id==$COND.discount_preprocess_item_except_condition_para_int_1}selected="selected"{/if}>{$B.object_name}</option>
											{/foreach}
										</select>
									</div>
									<div class="ItemExceptConditionParameterContainer3 ItemExceptConditionParameterContainer Hidden">
										<select name="except_product_category_special_id[]">
											{foreach $ProductCatSpecialList as $S}
												{if $Site.site_product_category_special_max_no == $S@index}
													{break}
												{/if}
												<option value="{$S.product_category_special_id}" {if $S.product_category_special_id==$COND.discount_preprocess_item_except_condition_para_int_1}selected="selected"{/if}>{$S.object_name}</option>
											{/foreach}
										</select>		
									</div>
								</td>
							</tr>
						{/foreach}
						<tr class="ItemExceptConditionInput Hidden">
							<td class="AlignLeft"><a class="RemoveItemExceptConditionLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
							<td>
								<select name="discount_preprocess_item_except_condition_type_id[]" class="ItemExceptConditionTypeIDInput">
									<option value="0"></option>
									{foreach $DiscountPreprocessConditionType as $T}
										<option value="{$T@iteration}">{$T}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<div class="ItemExceptConditionParameterContainer1 ItemExceptConditionParameterContainer Hidden">
									<select name="except_product_category_id[]">
										{foreach $ProductCatList as $C}
											<option value="{$C.product_category_id}">{$C.object_name}</option>
										{/foreach}
									</select>
									<br />
									 包括它的子分類: 
									<select name="except_include_sub_product_cat[]">
										<option value="0">否</option>
										<option value="1">是</option>
									</select>
								</div>
								<div class="ItemExceptConditionParameterContainer2 ItemExceptConditionParameterContainer Hidden">
									<select name="except_product_brand_id[]">
										{foreach $ProductBrandList as $B}
											<option value="{$B.product_brand_id}">{$B.object_name}</option>
										{/foreach}
									</select>
								</div>
								<div class="ItemExceptConditionParameterContainer3 ItemExceptConditionParameterContainer Hidden">
									<select name="except_product_category_special_id[]">
										{foreach $ProductCatSpecialList as $S}
											{if $Site.site_product_category_special_max_no == $S@index}
												{break}
											{/if}
											<option value="{$S.product_category_special_id}">{$S.object_name}</option>
										{/foreach}
									</select>		
								</div>
							</td>
						</tr>
					</table>
				</div>

									
				<div id="PreprocessRuleDiscountDiv">
					{foreach $RulePriceList as $PLIndex => $PL}
						<h2>{$PL.currency_name} 折扣</h2>
						<p>
							{assign var='PriceRow' value=$PL['price']}
							{if $PLIndex != 0}
								<input type="radio" name="discount_preprocess_discount_type_id[{$PLIndex}]" value="-1" {if $PriceRow == null}checked="checked"{/if}/> Disable
								<br />
							{/if}
							<input type="radio" name="discount_preprocess_discount_type_id[{$PLIndex}]" value="1" {if $PriceRow.discount_preprocess_discount_type_id == 1}checked="checked"{/if} /> 數量 <input type="text" name="discount_preprocess_discount1_min_quantity[{$PLIndex}]" value="{$PriceRow.discount_preprocess_discount1_min_quantity}" maxlength="4" size="4" /> 或以上, <input type="text" name="discount_preprocess_discount1_off_p[{$PLIndex}]" value="{$PriceRow.discount_preprocess_discount1_off_p}" maxlength="2" size="2" />% 扣減（７折請輸入30） <br />
							<input type="radio" name="discount_preprocess_discount_type_id[{$PLIndex}]" value="2" {if $PriceRow.discount_preprocess_discount_type_id == 2}checked="checked"{/if} /> $ <input type="text" name="discount_preprocess_discount2_price[{$PLIndex}]" value="{$PriceRow.discount_preprocess_discount2_price}"  maxlength="5" size="5" /> 購買 <input type="text" name="discount_preprocess_discount2_amount[{$PLIndex}]" value="{$PriceRow.discount_preprocess_discount2_amount}" maxlength="2" size="2" /> 件 <br />
						</p>						
					{/foreach}
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountPreprocessRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>規則名稱</th>
								<td><input type="text" name="discount_preprocess_rule_name[{$R.language_id}]" value="{$PreprocessRuleData[$R.language_id].discount_preprocess_rule_name|escape:'html'}" size="90" maxlength="255" /></td>
							</tr>
							<tr>
								<th>規則詳情</th>
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
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> 重置
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
