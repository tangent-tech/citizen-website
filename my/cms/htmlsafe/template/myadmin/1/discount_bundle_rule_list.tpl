{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Bundle Discount List</h1>
<p>
	Note: <br />
	1. The discount rules will be processed from top to bottom. <br />
	2. You may drag to re-order the rule. <br />
	<br />
</p>

	<table id="DiscountBundleRuleListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">ID</th>
			<th width="300">Rule Name</th>
			<th width="260">Action</th>
		</tr>
		{foreach from=$DiscountBundleRuleList item=R}
			<tr id="Rule-{$R.discount_bundle_rule_id}" class="AlignCenter {if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$R.discount_bundle_rule_id}</td>
				<td>{$R.object_name|escape:'html'}</td>
				<td>
					<a href="discount_bundle_rule_edit.php?id={$R.discount_bundle_rule_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="discount_bundle_rule_delete.php?id={$R.discount_bundle_rule_id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3">No rule has been defined.</td>
			</tr>
		{/foreach}
	</table>
	<br />
	<a href="discount_bundle_rule_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Rule</a>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}