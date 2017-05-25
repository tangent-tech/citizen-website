{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_layout_news|ucwords} Page - {$ObjectLink.object_name|escape:'html'} &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="layout_news_page_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id={$ObjectLink.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_page_edit_act.php">
		<div id="LayoutNewsPageTabs">
			<ul>
				<li><a href="#LayoutNewsPageTabs-LayoutNewsPage">{$Site.site_label_layout_news|ucwords} Page Details</a></li>
				<li><a href="#LayoutNewsPageTabs-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#LayoutNewsPageTabs-Permission">Permission</a></li>{/if}
			</ul>
			<div id="LayoutNewsPageTabs-LayoutNewsPage">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> {$Site.site_label_layout_news|ucwords} Root </th>
							<td>
								<select id="layout_news_root_id" name="layout_news_root_id">
									{foreach from=$LayoutNewsRootList item=R}
									    <option value="{$R.layout_news_root_id}"
											{if $R.layout_news_root_id == $LayoutNewsPage.layout_news_root_id}selected="selected"{/if}
									    >{$R.layout_news_root_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> {$Site.site_label_layout_news|ucwords} Category </th>
							<td>
								<select id="layout_news_category_id" name="layout_news_category_id">
									<option value="0" {if $LayoutNewsPage.layout_news_category_id == 0}selected="selected"{/if}>All</option>
									{foreach from=$LayoutNewsCategories item=C}
									    <option value="{$C.layout_news_category_id}"
											{if $C.layout_news_category_id == $LayoutNewsPage.layout_news_category_id}selected="selected"{/if}
									    >{$C.layout_news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="LayoutNewsPageTabs-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="LayoutNewsPageTabs-Permission">
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
