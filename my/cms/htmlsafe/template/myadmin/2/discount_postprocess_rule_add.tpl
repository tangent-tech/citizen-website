{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">加入後處理折扣規則</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_postprocess_rule_add_act.php">
		<div id="DiscountPostprocessRuleTabs">
			<ul>
				<li><a href="#DiscountPostprocessRuleTabsPanel-CommonData">一般資料</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DiscountPostprocessRuleTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="DiscountPostprocessRuleTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th> 規則參考名稱 </th>
							<td> <input type="text" name="object_name" value="Untitled Rule" size="90" maxlength="255" /> </td>
						</tr>
					</table>
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DiscountPostprocessRuleTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>規則名稱</th>
								<td><input type="text" name="discount_postprocess_rule_name[{$R.language_id}]" value="" size="90" maxlength="255" /></td>
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
