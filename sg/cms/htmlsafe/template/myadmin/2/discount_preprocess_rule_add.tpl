{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">新增前處理折扣規則</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_preprocess_rule_add_act.php">
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
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th> 規則參考名稱 </th>
							<td> <input type="text" name="object_name" value="Untitled Rule" size="90" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> 折扣碼 </th>
							<td>
								<input type="text" name="discount_preprocess_rule_discount_code" value="" size="90" maxlength="255" /> <br />
								若不需要折扣碼啟動，請留空。
							</td>
						</tr>
						<tr>
							<th> 停止處理其他較低的規則　</th>
							<td>
								<input type="radio" name="discount_preprocess_rule_stop_process_below_rules" value="Y" /> 是
								<input type="radio" name="discount_preprocess_rule_stop_process_below_rules" value="N"  checked="checked" /> 否
							</td>
						</tr>
					</table>
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountPreprocessRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>規則名稱</th>
								<td><input type="text" name="discount_preprocess_rule_name[{$R.language_id}]" value="" size="90" maxlength="255" /></td>
							</tr>
						</table>
					</div>
			   </div>
			{/foreach}
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
