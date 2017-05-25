{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit {$NewsRoot.news_root_name} Permission &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="news_list.php?id={$TheObject.news_root_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$NewsRoot.news_root_name} List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_news|ucwords} Root Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_root_permission_edit_act.php">
		<div class="InnerContent ui-widget-content">
			{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
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
