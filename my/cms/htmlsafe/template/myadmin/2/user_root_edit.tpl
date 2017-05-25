{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">編輯會員根 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="member_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 會員列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="user_root_edit_act.php">
		<div id="UserRootTabs">
			<ul>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#UserRootTabs-Permission">權限</a></li>{/if}
			</ul>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="UserRootTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit_user_root.tpl"}
				</div>
			{/if}
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
