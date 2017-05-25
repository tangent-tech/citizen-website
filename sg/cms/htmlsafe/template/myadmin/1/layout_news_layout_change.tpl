{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Change {$Site.site_label_layout_news|ucwords} Layout - {$LayoutNews.layout_news_title|escape:'html'}</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_layout_change_act.php">
		<div class="InnerContent ui-widget-content AdminEditDetailsBlock">
			<table id="TablePageLayoutChange" class="TopHeaderTable ui-helper-reset">
				<tr class="ui-state-highlight">
					<th width="380">Old Layout</th>
					<th></th>
					<th width="380">New Layout</th>
				</tr>
				<tr>
					<td>
						{$LayoutNews.layout_name|escape:'html'} <br />
						{if $LayoutNews.layout_file_id != 0}<a href="{$smarty.const.BASEURL}/getfile.php?id={$LayoutNews.layout_file_id}" target="_preview" class="PreviewImage"><img {if $LayoutNews.block_image_width < 400}width="{$LayoutNews.block_image_width}"{else}width="300"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$LayoutNews.layout_file_id}" /></a>{/if}
					</td>
					<td> => </td>
					<td>
						{$NewLayout.layout_name|escape:'html'} <br />
						{if $NewLayout.layout_file_id != 0}<a href="{$smarty.const.BASEURL}/getfile.php?id={$NewLayout.layout_file_id}" target="_preview" class="PreviewImage"><img {if $NewLayout.block_image_width < 400}width="{$NewLayout.block_image_width}"{else}width="300"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$NewLayout.layout_file_id}" /></a>{/if}
					</td>
				</tr>
				{foreach from=$OldBlockDefs item=OBD}
					<tr>
						<td>{$OBD.object_name|escape:'html'}</td>
						<td>=></td>
						<td>
							<select name="NewBlockDefMapping[{$OBD.block_definition_id}]">
								{foreach from=$OBD.Option key=k item=O}
									<option value="{$O.block_definition_id}" {if $k == 1}selected="selected"{/if}>{$O.object_name|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
				{/foreach}
			</table>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input type="hidden" name="layout_id" value="{$smarty.request.layout_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a id="TheSubmitButton" href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="page_edit.php?link_id={$smarty.request.link_id}" class="ui-state-default ui-corner-all MyButton">
				<span class="ui-icon ui-icon-cancel"></span> Cancel
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
