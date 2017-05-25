{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯{$LayoutNewsRoot.layout_news_root_name}權限 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_list.php?id={$TheObject.layout_news_root_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$LayoutNewsRoot.layout_news_root_name}列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_news|ucwords}根詳情 </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_root_permission_edit_act.php">
		<div class="InnerContent ui-widget-content">
			{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
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
