{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Edit {$Site.site_label_layout_news|ucwords} Root &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_root_list.php?language_id={$LayoutNewsRoot.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_layout_news|ucwords} Root List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_root_edit_act.php">
		<div id="LayoutNewsTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-CommonData">Reference Data</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#LayoutNewsTabsPanel-Permission">Permission</a></li>{/if}
			</ul>
			<div id="LayoutNewsTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> {$Site.site_label_layout_news|ucwords} Root Language </th>
							<td>
								<select id="language_id" name="language_id">
									{foreach from=$SiteLanguageRoots item=L}
										<option value="{$L.language_id}"
											{if $L.language_id == $LayoutNewsRoot.language_id}selected="selected"{/if}
										>{$L.language_native|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> {$Site.site_label_layout_news|ucwords} Root Name </th>
							<td> <input type="text" name="layout_news_root_name" value="{$LayoutNewsRoot.layout_news_root_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="LayoutNewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
			</div>						
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="LayoutNewsTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
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
