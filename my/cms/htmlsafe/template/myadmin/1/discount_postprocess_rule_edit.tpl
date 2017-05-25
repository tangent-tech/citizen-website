{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Edit Discount Postprocess Rule</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_postprocess_rule_edit_act.php">
		<div id="DiscountPostprocessRuleTabs">
			<ul>
				<li><a href="#DiscountPostprocessRuleTabsPanel-CommonData">Common Data</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DiscountPostprocessRuleTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="DiscountPostprocessRuleTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> Rule Reference Name </th>
							<td> <input type="text" name="object_name" value="{$PostprocessRule.object_name}" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Discount Code </th>
							<td>
								<textarea name="discount_postprocess_rule_discount_code">{$DiscountText}</textarea> <br />
{*								<input type="text" name="discount_postprocess_rule_discount_code" value="{$DiscountText}" size="90" maxlength="255" /> <br /> *}
								Leave blank if no discount code is required to activate this rule <br />
								You may use comma(,) to seperate multiple discount codes
							</td>
						</tr>
						<tr>
							<th> Discount Code Quota (Per discount code)</th>
							<td> 
								<input type="text" name="discount_postprocess_rule_quota_discount_code" value="{$PostprocessRule.discount_postprocess_rule_quota_discount_code}" size="6" maxlength="6" /> <br />
								Enter 0 if unlimited quota.
							</td>
						</tr>
						<tr>
							<th> Rule User Quota </th>
							<td> 
								<input type="text" name="discount_postprocess_rule_quota_user" value="{$PostprocessRule.discount_postprocess_rule_quota_user}" size="6" maxlength="6" /> <br />
								Enter 0 if unlimited quota.
							</td>
						</tr>
						<tr>
							<th> Rule Global Quota (Disregard discount code) </th>
							<td> 
								{$RuleGlobalQty} / <input type="text" name="discount_postprocess_rule_quota_all" value="{$PostprocessRule.discount_postprocess_rule_quota_all}" size="6" maxlength="6" /> <br />
								Enter 0 if unlimited quota.
							</td>
						</tr>						
					</table>
				</div>
				
				{foreach $RulePriceInfoList as $PLIndex => $PL}
					{assign var='LevelRows' value=$PL['level']}
					{assign var='PriceRow' value=$PL['price']}
					<div class="PostprocessDiscountLevelContainer" data-TheInputIndex="{$LevelRows|@count}">
						<h2>{$PL.currency_name} Discount</h2>
						<table class="TopHeaderTable AlignLeft">
							<tr class="ui-state-highlight">
								<th class="AlignLeft"><a class="AddMorePostprocessDiscountLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
								<th class="AlignLeft">
									Min 
									<select name="discount_postprocess_discount_type_id_{$PLIndex}">
										<option value="0" {if $PriceRow.discount_postprocess_discount_type_id==0 || $PriceRow == null}selected="selected"{/if}></option>
										<option value="1" {if $PriceRow.discount_postprocess_discount_type_id==1}selected="selected"{/if}>User Security Level</option>
										<option value="2" {if $PriceRow.discount_postprocess_discount_type_id==2}selected="selected"{/if}>Order Total Price</option>
									</select>
								</th>
								<th class="AlignLeft">Discount</th>
							</tr>
							<tr>
								<td class="AlignLeft"></td>
								<td>0<input type="hidden" name="discount_postprocess_discount_level_min_{$PLIndex}[0]" value="0" /></td>
								<td>
									<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[0]" value="1" {if $LevelRows[0].discount_postprocess_discount_level_type_id != 2}checked="checked"{/if} /> <input type="text" name="discount_postprocess_discount1_off_p_{$PLIndex}[0]" value="{$LevelRows[0].discount_postprocess_discount1_off_p}" maxlength="2" size="2" />% Off <br />
									<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[0]" value="2" {if $LevelRows[0].discount_postprocess_discount_level_type_id == 2}checked="checked"{/if} /> $ <input type="text" name="discount_postprocess_discount2_minus_amount_{$PLIndex}[0]" value="{$LevelRows[0].discount_postprocess_discount2_minus_amount}"  maxlength="5" size="5" /> amount off
								</td>
							</tr>
							{foreach $LevelRows as $L}
								{if $L.discount_postprocess_discount_level_min != 0}
									<tr>
										<td class="AlignLeft"><a class="RemovePostprocessDiscountLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
										<td><input type="text" name="discount_postprocess_discount_level_min_{$PLIndex}[{$L@iteration}]" value="{$L.discount_postprocess_discount_level_min}" /></td>
										<td>
											<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[{$L@iteration}]" value="1" {if $L.discount_postprocess_discount_level_type_id == 1}checked="checked"{/if} /> <input type="text" name="discount_postprocess_discount1_off_p_{$PLIndex}[{$L@iteration}]" value="{$L.discount_postprocess_discount1_off_p}" maxlength="2" size="2" />% Off <br />
											<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[{$L@iteration}]" value="2" {if $L.discount_postprocess_discount_level_type_id == 2}checked="checked"{/if} /> $ <input type="text" name="discount_postprocess_discount2_minus_amount_{$PLIndex}[{$L@iteration}]" value="{$L.discount_postprocess_discount2_minus_amount}"  maxlength="5" size="5" /> amount off							
										</td>
									</tr>
								{/if}
							{/foreach}
							<tr class="PostprocessDiscountLevelInput Hidden">
								<td class="AlignLeft"><a class="RemovePostprocessDiscountLevelLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
								<td><input type="text" name="discount_postprocess_discount_level_min_{$PLIndex}[]" /></td>
								<td>
									<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[]" value="1" checked="checked" /> <input type="text" name="discount_postprocess_discount1_off_p_{$PLIndex}[]" maxlength="2" size="2" />% Off <br />
									<input type="radio" name="discount_postprocess_discount_level_type_id_{$PLIndex}[]" value="2" /> $ <input type="text" name="discount_postprocess_discount2_minus_amount_{$PLIndex}[]" maxlength="5" size="5" /> amount off
								</td>
							</tr>
						</table>
					</div>
				{/foreach}
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountPostprocessRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>Rule Name</th>
								<td><input type="text" name="discount_postprocess_rule_name[{$R.language_id}]" value="{$PostprocessRuleData[$R.language_id].discount_postprocess_rule_name|escape:'html'}" size="90" maxlength="255" /></td>
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
