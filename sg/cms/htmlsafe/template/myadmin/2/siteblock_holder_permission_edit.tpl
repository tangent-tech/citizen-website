{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯網站區塊根權限 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="siteblock.php?language_id={$smarty.request.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 網站區塊列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="siteblock_holder_permission_edit_act.php">
		<div class="InnerContent ui-widget-content">
			{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
			<input type="hidden" name="block_def_id" value="{$smarty.request.block_def_id}" />
			<input type="hidden" name="language_id" value="{$smarty.request.language_id}" />
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確認
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
