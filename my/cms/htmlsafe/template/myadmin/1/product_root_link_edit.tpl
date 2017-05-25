{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_product|ucwords} Root Link - {$ObjectLink.object_name|escape:'html'} &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="product_root_link_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id={$ObjectLink.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="product_root_link_edit_act.php">
		<div id="ProductRootLinkTabs">
			<ul>
				<li><a href="#ProductRootLink-ProductRoot">{$Site.site_label_product|ucwords} Tree Link Details</a></li>
				<li><a href="#ProductRootLink-SEO">SEO</a></li>
			</ul>
			<div id="ProductRootLink-ProductRoot">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>Link</th>
							<td>
								{if $Site.site_friendly_link_enable == 'Y'}
									<a href="http://{$Site.site_address}{$ProductRoot.object_seo_url}" target="_blank">http://{$Site.site_address}{$ProductRoot.object_seo_url}</a>
								{else}
									<a href="http://{$Site.site_address}/load.php?link_id={$smarty.request.link_id}" target="_blank">http://{$Site.site_address}/load.php?link_id={$smarty.request.link_id}</a>
								{/if}
							</td>
						</tr>					
						<tr>
							<th> {$Site.site_label_product|ucwords} Tree </th>
							<td>
								<select id="product_root_id" name="product_root_id">
									{foreach from=$ProductRoots item=R}
									    <option value="{$R.object_id}"
											{if $R.object_id == $ProductRoot.object_id}selected="selected"{/if}
									    >{$R.object_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="ProductRootLink-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
			</div>
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
