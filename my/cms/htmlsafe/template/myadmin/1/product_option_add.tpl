{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Add {$Site.site_label_product|ucwords} Option &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_edit.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Product
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords} Option</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_option_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<strong>Product Option Code:</strong> <input type="text" name="product_option_code" /> <br />
				<br />
				<table class="TopHeaderTable AlignLeft">
					<tr class="ui-state-highlight">
						<th class="AlignLeft">Language</th>
						{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
							<th class="AlignLeft">Value ({$smarty.section.foo.iteration})</th>
						{/section}
					</tr>
					{foreach from=$SiteLanguageRoots item=R}
						<tr>
							<td class="AlignLeft">{$R.language_longname|escape:'html'}</td>
							{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
								<td><input type="text" name="product_option_data_text_{$smarty.section.foo.iteration}[{$R.language_id}]" value='' size="6" /></td>
							{/section}
						</tr>
					{/foreach}
				</table>
				<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
			</div>
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
