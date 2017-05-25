{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">前處理折扣規則列表</h1>
<p>
	注: <br />
	1. 前處理折扣規則由上至下處理 <br />
	2. 你可以拖放更改次序 <br />
	<br />
</p>

	<table id="DiscountPreprocessRuleListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">編號</th>
			<th width="300">規則名稱</th>
			<th width="260">操作</th>
		</tr>
		{foreach from=$DiscountPreprocessRuleList item=R}
			<tr id="Rule-{$R.discount_preprocess_rule_id}" class="AlignCenter {if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$R.discount_preprocess_rule_id}</td>
				<td>{$R.object_name|escape:'html'}</td>
				<td>
					<a href="discount_preprocess_rule_edit.php?id={$R.discount_preprocess_rule_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="discount_preprocess_rule_delete.php?id={$R.discount_preprocess_rule_id}" onclick="return DoubleConfirm('警告! \n 確定刪除？', '警告! \n 真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3">沒有定義規則</td>
			</tr>
		{/foreach}
	</table>
	<br />
	<a href="discount_preprocess_rule_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Rule</a>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
