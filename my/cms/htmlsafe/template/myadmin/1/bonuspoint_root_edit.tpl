{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Bonus Point Root &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="bonuspoint_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Bonus Point Item List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="bonuspoint_root_edit_act.php">
		<div id="BonusPointTabs">
			<ul>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#AlbumTabsPanel-Permission">Permission</a></li>{/if}
			</ul>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="BonusPointTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
