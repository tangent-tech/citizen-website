{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_news|ucwords} Page - {$ObjectLink.object_name|escape:'html'} &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="news_page_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id={$ObjectLink.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_page_edit_act.php">
		<div id="NewsPageTabs">
			<ul>
				<li><a href="#NewsPageTabs-NewsPage">{$Site.site_label_news|ucwords} Page Details</a></li>
				<li><a href="#NewsPageTabs-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#NewsPageTabs-Permission">Permission</a></li>{/if}
			</ul>
			<div id="NewsPageTabs-NewsPage">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> {$Site.site_label_news|ucwords} Root </th>
							<td>
								<select id="news_root_id" name="news_root_id">
									{foreach from=$NewsRootList item=R}
									    <option value="{$R.news_root_id}"
											{if $R.news_root_id == $NewsPage.news_root_id}selected="selected"{/if}
									    >{$R.news_root_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> {$Site.site_label_news|ucwords} Category </th>
							<td>
								<select id="news_category_id" name="news_category_id">
									<option value="0" {if $NewsPage.news_category_id == 0}selected="selected"{/if}>All</option>
									{foreach from=$NewsCategories item=C}
									    <option value="{$C.news_category_id}"
											{if $C.news_category_id == $NewsPage.news_category_id}selected="selected"{/if}
									    >{$C.news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="NewsPageTabs-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}								
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="NewsPageTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}			
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
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
