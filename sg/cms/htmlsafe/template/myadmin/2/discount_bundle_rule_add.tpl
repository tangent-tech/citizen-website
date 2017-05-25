{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Add Discount Bundle Rule</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_bundle_rule_add_act.php">
		<div id="DiscountBundleRuleTabs">
			<ul>
				<li><a href="#DiscountBundleRuleTabsPanel-CommonData">Reference Data</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DiscountBundleRuleTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="DiscountBundleRuleTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th> Rule Reference Name </th>
							<td> <input type="text" name="object_name" value="Untitled Rule" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Discount Code </th>
							<td>
								<input type="text" name="discount_bundle_rule_discount_code" value="" size="90" maxlength="255" /> <br />
								Leave blank if no discount code is required to activate this rule
							</td>
						</tr>
						<tr>
							<th> Stop processing any bundle rules below this rule</th>
							<td>
								<input type="radio" name="discount_bundle_rule_stop_process_below_rules" value="Y" /> Yes
								<input type="radio" name="discount_bundle_rule_stop_process_below_rules" value="N"  checked="checked" /> No
							</td>
						</tr>
						<tr>
							<th> Stop processing any pre/postprocess rules below this rule</th>
							<td>
								<input type="radio" name="discount_bundle_rule_stop_process_prepostprocess_rules" value="Y" /> Yes
								<input type="radio" name="discount_bundle_rule_stop_process_prepostprocess_rules" value="N"  checked="checked" /> No
							</td>
						</tr>
					</table>
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountBundleRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>Rule Name</th>
								<td><input type="text" name="discount_bundle_rule_name[{$R.language_id}]" value="" size="90" maxlength="255" /></td>
							</tr>
						</table>
					</div>
			   </div>
			{/foreach}
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