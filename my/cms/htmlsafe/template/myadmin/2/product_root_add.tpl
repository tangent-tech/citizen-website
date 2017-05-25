{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">新增{$Site.site_label_product|ucwords}根 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_root_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords}根列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_product|ucwords}根詳情 </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_root_add_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th> {$Site.site_label_product|ucwords}根名稱 </th>
					<td> <input type="text" name="product_root_name" value="Untitled" size="90" maxlength="255" /> </td>
				</tr>
			</table>
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確定
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
