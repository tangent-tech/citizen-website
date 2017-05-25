{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Page - {$ObjectLink.object_name|escape:'html'} (id: {$ObjectLink.object_id}) &nbsp;
	<a onclick="return DoubleConfirm('WARNING!\n All corresponding block content will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="page_delete.php?link_id={$smarty.request.link_id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="language_tree.php?id={$ObjectLink.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Language Tree
	</a>
</h1>

<div class="PageEditRight">
	{if $Page.layout_file_id != 0}
		<a href="{$smarty.const.BASEURL}/getfile.php?id={$Page.layout_file_id}" target="_preview" class="PreviewImage"><img src="{$smarty.const.BASEURL}/getfile.php?id={$Page.layout_file_id}" /></a> <br />
	{/if}
</div>

<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="page_edit_act.php">
		<div id="PageTabs">
			<ul>
				<li><a href="#PageTabs-Page">Page Info</a></li>
				{if $ObjectFieldsShow.object_seo_tab == 'Y'}<li><a href="#PageTabs-SEO">SEO</a></li>{/if}
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#PageTabs-Permission">Permission</a></li>{/if}
			</ul>
			<div id="PageTabs-Page">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> Page Title </th>
							<td> <input type="text" name="page_title" value="{$Page.page_title|escape:'html'}" size="50" /> </td>
						</tr>
						<tr>
							<th>Tag</th>
							<td>
								<p>Please seperate the tag by comma(,)</p>
								<input type="text" name="page_tag" value="{$Page.page_tag|substr:2:-2|escape:'html'}" size="50" maxlength="255" />
							</td>
						</tr>
						<tr>
							<th> Page Layout </th>
							<td>
								<select name="layout_id">
									<option value="0" {if $Page.layout_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$Layouts item=L}
										<option value="{$L.layout_id}" {if $L.layout_id == $Page.layout_id}selected="selected"{/if}>{$L.layout_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> Album </th>
							<td>
								<select name="album_id">
									<option value="0" {if $Page.album_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$Albums item=A}
										<option value="{$A.album_id}" {if $A.album_id == $Page.album_id}selected="selected"{/if}>{$A.object_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="PageTabs-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="PageTabs-Permission">
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
<br class="clearfloat" />
{foreach from=$BlockDefs item=D}
	<div class="PageEditLeft InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
		<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">{$D.object_name|escape:'html'}</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<p>{$D.block_definition_desc|escape:'html'}</p>
			<table id="BlockDefTable-{$D.block_definition_id}" class="TopHeaderTable ui-helper-reset SortTable">
				<tr class="ui-state-highlight nodrop nodrag">
					{if $D.block_definition_type == 'text' || $D.block_definition_type == 'html'}
						<th width="50" class="AlignCenter">ID</th>
						<th width="220">Content Name</th>
						<th width="150">Action</th>
					{elseif $D.block_definition_type == 'image'}
						<th width="50" class="AlignCenter">ID</th>
						<th width="220">Image</th>
						<th width="150">Action</th>
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
									<a href="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" target="_preview" class="PagePreviewImage"><img {if $D.block_image_width < 150 && $D.block_image_width > 0}width="{$D.block_image_width}"{else}width="150"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" /></a>
								{/if}
							{elseif $D.block_definition_type == 'file'}
								{$C.block_content|escape:'html'|truncate:30:"..."} <br />
								{$C.filename|escape:'html'} <br />
								Filesize: {$C.size/1024|string_format:"%.2f"}kb
							{/if}
						</td>
						<td>
							<a href="block_edit.php?link_id={$smarty.request.link_id}&id={$C.block_content_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="block_delete.php?link_id={$smarty.request.link_id}&id={$C.block_content_id}" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<a href="block_add.php?link_id={$smarty.request.link_id}&block_def_id={$D.block_definition_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
		</div>
	</div>
	<br class="clearfloat" />
{/foreach}
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
