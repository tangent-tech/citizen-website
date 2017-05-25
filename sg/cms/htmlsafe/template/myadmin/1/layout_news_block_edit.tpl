{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Block Content - {$BlockDef.object_name} &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="layout_news_block_delete.php?layout_news_id={$smarty.request.layout_news_id}&id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_edit.php?id={$smarty.request.layout_news_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_layout_news|ucwords}
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Block Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_block_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<p>{$BlockDef.block_definition_desc|escape:'html'}</p>
			<table class="LeftHeaderTable">
				<tr>
					<th>Last Modify Date</th>
					<td>{$BlockContent.modify_date}</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>
						<input type="radio" name="object_is_enable" value="Y" {if $BlockContent.object_is_enable == 'Y'}checked="checked"{/if}/> Enable
						<input type="radio" name="object_is_enable" value="N" {if $BlockContent.object_is_enable == 'N'}checked="checked"{/if}/> Disable
					</td>
				</tr>
				<tr>
					<th> Security Level </th>
					<td> <input type="text" name="object_security_level" value="{$BlockContent.object_security_level|escape:'html'}" size="6" /> </td>
				</tr>
			{if $BlockDef.block_definition_type == 'text'}
				<tr>
					<th> Block Content </th>
					<td> <textarea name="block_content" cols="50" rows="5">{$BlockContent.block_content|escape:'html'}</textarea> </td>
					{*	<td> <input type="text" name="block_content" value="{$BlockContent.block_content|escape:'html'}" size="90" maxlength="255" /> </td> *}
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
			{elseif $BlockDef.block_definition_type == 'textarea'}
				<tr>
					<th> Block Content </th>
					<td> <textarea name="block_content" cols="87" rows="5">{$BlockContent.block_content|escape:'html'}</textarea> </td>
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
			{elseif $BlockDef.block_definition_type == 'html'}
				<tr>
					<th> Block Reference Name </th>
					<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
				<tr>
					<td colspan="2"> {$EditorHTML} </td>
				</tr>
			{elseif $BlockDef.block_definition_type == 'image'}
				<tr>
					<th> Image ({$BlockDef.block_image_width}px x {$BlockDef.block_image_height}px) </th>
					<td>
						{if $BlockContent.block_image_id != 0}
							<a href="{$smarty.const.BASEURL}/getfile.php?id={$BlockContent.block_image_id}" target="_preview" ><img {if $BlockDef.block_image_width == 0}{elseif $BlockDef.block_image_width < 800}width="{$BlockDef.block_image_width}"{else}width="800"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$BlockContent.block_image_id}" /></a> <br />
						{/if}
						<input type="file" name="block_image" />
					</td>
				</tr>
				<tr>
					<th> Block Link </th>
					<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
			{elseif $BlockDef.block_definition_type == 'file'}
				<tr>
					<th> File Reference Name </th>
					<td> <input type="text" name="block_content" value="{$BlockContent.block_content|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
				<tr>
					<th> File </th>
					<td>
						<a href="{$smarty.const.BASEURL}/getfile.php?id={$BlockContent.block_file_id}">{$BlockContent.filename}</a> <br />
						Filesize: {$BlockContent.size/1024|string_format:"%.2f"}kb <br />
						<br />
						<input type="file" name="block_file" />
					</td>
				</tr>
			{/if}
			</table>
			<input type="hidden" name="layout_news_id" value="{$smarty.request.layout_news_id}" />
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