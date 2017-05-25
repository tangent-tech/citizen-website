{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Add Site Block Content &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="siteblock.php?language_id={$smarty.request.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Site Block List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="siteblock_add_act.php">
		<div id="SiteBlockTabs">
			<ul>
				<li><a href="#SiteBlockTabs-CommonData">Reference Data</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#SiteBlockTabs-Permission">Permission</a></li>{/if}
			</ul>
			
			<div id="SiteBlockTabs-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Block Name </th>
							<td> {$BlockDef.block_definition_desc|escape:'html'} </td>
						</tr>
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
						{if $BlockDef.block_definition_type == 'text'}
							<tr>
								<th> Block Reference Name </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Content </th>
								<td> <input type="text" name="block_content" value="{$BlockContent.block_content|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
						{elseif $BlockDef.block_definition_type == 'textarea'}
							<tr>
								<th> Block Reference Name </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
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
								<td> <input type="text" name="object_name" value="Untitled" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<td colspan="2"> {$EditorHTML} </td>
							</tr>
						{elseif $BlockDef.block_definition_type == 'image'}
							<tr>
								<th> Image Alt Text </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> Image ({$BlockDef.block_image_width}px x {$BlockDef.block_image_height}px) </th>
								<td> <input type="file" name="block_image" /> </td>
							</tr>
							<tr>
								<th> Image Text Content </th>
								<td> <textarea name="block_content" cols="87" rows="5">{$BlockContent.block_content|escape:'html'}</textarea> </td>
							</tr>
							<tr>
								<th> Block Link </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
						{/if}
					</table>
				</div>
			</div>		
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="SiteBlockTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_add.tpl"}
				</div>
			{/if}
			<div class="ui-widget-header ui-corner-bottom">
				<input type="hidden" name="block_def_id" value="{$smarty.request.block_def_id}" />
				<input type="hidden" name="language_id" value="{$smarty.request.language_id}" />
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
