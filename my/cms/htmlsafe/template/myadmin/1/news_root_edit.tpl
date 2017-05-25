{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Edit {$Site.site_label_news|ucwords} Root &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="news_root_list.php?language_id={$NewsRoot.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_news|ucwords} Root List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_news|ucwords} Root Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_root_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th> {$Site.site_label_news|ucwords} Root Language </th>
					<td>
						<select id="language_id" name="language_id">
							{foreach from=$SiteLanguageRoots item=L}
							    <option value="{$L.language_id}"
									{if $L.language_id == $NewsRoot.language_id}selected="selected"{/if}
							    >{$L.language_native|escape:'html'}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<th> {$Site.site_label_news|ucwords} Root Name </th>
					<td> <input type="text" name="news_root_name" value="{$NewsRoot.news_root_name|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
			</table>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
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
