{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Site Block List &nbsp;
	<form name="FrmSetLanguageID" id="FrmSetLanguageID" method="post">
		<select id="language_id" name="language_id" onchange="submit()">
			{foreach from=$SiteLanguageRoots item=L}
			    <option value="{$L.language_id}"
					{if $L.language_id == $smarty.request.language_id}selected="selected"{/if}
			    >{$L.language_native|escape:'html'}</option>
			{/foreach}
		</select>
	</form>
</h1>

<div class="PageEditRight">
	{if $Site.site_block_file_id != 0}
		<a href="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_block_file_id}" target="_preview" class="PreviewImage"><img src="{$smarty.const.BASEURL}/getfile.php?id={$Site.site_block_file_id}" /></a> <br />
	{/if}
</div>
{if $BlockDefs|@count == 0}
	<p>No Site Block is defined in your site. You may ignore this tab.</p>
{else}
	{foreach from=$BlockDefs item=D}
		<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
			<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">
				{$D.object_name|escape:'html'} ({$D.block_definition_id})
				
				{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
					<a class="ui-state-default ui-corner-all MyButton" href="siteblock_holder_permission_edit.php?block_def_id={$D.block_definition_id}&language_id={$smarty.request.language_id}">
						<span class="ui-icon ui-icon-locked"></span> Permission
					</a>
				{/if}				
			</h2>
			<div class="InnerContent ui-widget-content ui-corner-bottom">
				<p>{$D.block_definition_desc|escape:'html'}</p>
				<table id="BlockDefTable-{$D.block_definition_id}" class="TopHeaderTable ui-helper-reset SortTable">
					<tr class="ui-state-highlight nodrop nodrag">
						{if $D.block_definition_type == 'text' || $D.block_definition_type == 'html'}
							<th width="50" class="AlignCenter">ID</th>
							<th width="220">Content Name</th>
							<th width="160">Action</th>
						{elseif $D.block_definition_type == 'image'}
							<th width="50" class="AlignCenter">ID </th>
							<th width="220">Image</th>
							<th width="160">Action</th>
						{/if}
					</tr>
					{foreach from=$BlockContents[$D.block_definition_id] item=C}
						<tr id="BC-{$C.block_content_id}" class="{if $C.object_is_enable == 'N'}DisabledRow{/if}">
							<td class="AlignCenter">{$C.block_content_id}</td>
							<td>
								{if $D.block_definition_type == 'text'}
									{$C.block_content|escape:'html'|truncate:30:"..."}
								{elseif $D.block_definition_type == 'textarea'}
									{$C.block_content|escape:'html'|truncate:30:"..."|nl2br}
								{elseif $D.block_definition_type == 'html'}
									{$C.object_name|escape:'html'}
								{elseif $D.block_definition_type == 'image'}
									{if $C.block_image_id != 0}
										<a href="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" target="_preview" class="PagePreviewImage"><img {if $D.block_image_width < 150 && $D.block_image_width > 0}width="{$D.block_image_width}"{elseif $D.block_image_width > 0}width="150"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" /></a>
									{/if}
								{/if}
							</td>
							<td>
								<a href="siteblock_edit.php?id={$C.block_content_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> edit
								</a>
								<a href="siteblock_delete.php?id={$C.block_content_id}" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-trash"></span> delete
								</a>
							</td>
						</tr>
					{/foreach}
				</table>
				<a href="siteblock_add.php?block_def_id={$D.block_definition_id}&language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
			</div>
		</div>
	{/foreach}
{/if}
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
