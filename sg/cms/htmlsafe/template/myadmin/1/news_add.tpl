{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Add {$NewsRoot.news_root_name|escape:'html'} &nbsp;
	<a href="news_list.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$NewsRoot.news_root_name}</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_add_act.php">
		<div id="NewsTabs">
			<ul>
				<li><a href="#NewsTabsPanel-News">Details</a></li>
				<li><a href="#NewsTabsPanel-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#NewsTabsPanel-Permission">Permission</a></li>{/if}
			</ul>
			<div id="NewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						<tr>
							<th>News Date</th>
							<td><input type="text" name="news_date" class="DatePicker" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time use_24_hours=true display_seconds=false}</td>
						</tr>
						<tr>
							<th>Category</th>
							<td>
								<select name="news_category_id">
									{foreach from=$NewsCategories item=C}
									    <option value="{$C.news_category_id}">{$C.news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>Title</th>
							<td><input type="text" name="news_title" value="Untitled" size="80" /></td>
						</tr>
						<tr>
							<th>Tag</th>
							<td><input type="text" name="news_tag" value="" size="80" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<strong>Summary</strong> <br />
								{$SummaryEditorHTML}
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<strong>Content</strong> <br />
								{$EditorHTML}
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="NewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_add.tpl"}
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="NewsTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_add.tpl"}
				</div>
			{/if}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="SummaryEditor ContentEditor">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
