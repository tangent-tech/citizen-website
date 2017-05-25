{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit {$Site.site_label_product|ucwords} Root &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords} Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_root_edit_act.php">
		<div id="ProductRootTabs">
			<ul>
				<li><a href="#ProductRootTabsPanel-CommonData">Common Data</a></li>
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#ProductRootTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="ProductRootTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> {$Site.site_label_product|ucwords} Root Name </th>
							<td> <input type="text" name="product_root_name" value="{$ObjectLink.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
					</table>
					<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
					<input class="HiddenSubmit" type="submit" value="Submit" />
				</div>
			</div>
			{foreach from=$SiteLanguageRoots item=R}
				<div id="ProductRootTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> Friendly URL </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$ProductRootData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> Meta Title </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$ProductRootData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> Meta Description </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$ProductRootData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> Meta Keywords </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$ProductRootData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}
						</table>
					</div>
			   </div>
			{/foreach}
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
