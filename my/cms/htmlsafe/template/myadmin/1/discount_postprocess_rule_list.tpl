{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Discount Postprocess List</h1>

<p>
Note: <br />
1) If a correct discount code is applied, only the corresponding rule will be processed. <br />
2) The engine will stop processing the remaining rules when one of the rule has been successfully applied.</p>
<br />

	<table id="DiscountPostprocessRuleListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">ID</th>
			<th width="300">Rule Name</th>
			<th width="260">Action</th>
		</tr>
		{foreach from=$DiscountPostprocessRuleList item=R}
			<tr id="Rule-{$R.discount_postprocess_rule_id}" class="AlignCenter {if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$R.discount_postprocess_rule_id}</td>
				<td>{$R.object_name|escape:'html'}</td>
				<td>
					<a href="discount_postprocess_rule_edit.php?id={$R.discount_postprocess_rule_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="discount_postprocess_rule_delete.php?id={$R.discount_postprocess_rule_id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
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
	<a href="discount_postprocess_rule_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Rule</a>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
