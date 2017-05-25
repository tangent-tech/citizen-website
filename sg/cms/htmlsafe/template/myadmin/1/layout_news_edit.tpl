{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit {$LayoutNews.layout_news_root_name|escape:'html'} &nbsp;
	<a href="layout_news_list.php?id={$LayoutNews.layout_news_root_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$LayoutNews.layout_news_root_name|escape:'html'}</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_edit_act.php">
		<div id="LayoutNewsTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-News">Details</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#LayoutNewsTabsPanel-Permission">Permission</a></li>{/if}
			</ul>
			<div id="LayoutNewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th>Date</th>
							<td><input type="text" name="layout_news_date" class="DatePicker" value="{$LayoutNews.layout_news_date|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time use_24_hours=true display_seconds=false time=$LayoutNews.layout_news_date}</td>
						</tr>
						<tr>
							<th>Category</th>
							<td>
								<select name="layout_news_category_id">
									{foreach from=$LayoutNewsCategories item=C}
									    <option value="{$C.layout_news_category_id}"
											{if $C.layout_news_category_id == $LayoutNews.layout_news_category_id}selected="selected"{/if}
									    >{$C.layout_news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>Title</th>
							<td><input type="text" name="layout_news_title" value="{$LayoutNews.layout_news_title|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Tag</th>
							<td><input type="text" name="layout_news_tag" value="{$LayoutNewsTagText|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th> Layout </th>
							<td>
								<select name="layout_id">
									<option value="0" {if $LayoutNews.layout_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$Layouts item=L}
										<option value="{$L.layout_id}" {if $L.layout_id == $LayoutNews.layout_id}selected="selected"{/if}>{$L.layout_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> Album </th>
							<td>
								<select name="album_id">
									<option value="0" {if $LayoutNews.album_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$Albums item=A}
										<option value="{$A.album_id}" {if $A.album_id == $LayoutNews.album_id}selected="selected"{/if}>{$A.object_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="LayoutNewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="LayoutNewsTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
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
							{elseif $D.block_definition_type == 'html'}
								{$C.object_name|escape:'html'}
							{elseif $D.block_definition_type == 'image'}
								{if $C.block_image_id != 0}
									<a href="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" target="_preview" class="PagePreviewImage"><img {if $D.block_image_width > 0 && $D.block_image_width < 150}width="{$D.block_image_width}"{else}width="150"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$C.block_image_id}" /></a>
								{/if}
							{elseif $D.block_definition_type == 'file'}
								{$C.block_content|escape:'html'|truncate:30:"..."} <br />
								{$C.filename|escape:'html'} <br />
								Filesize: {$C.size/1024|string_format:"%.2f"}kb
							{/if}
						</td>
						<td>
							<a href="layout_news_block_edit.php?layout_news_id={$smarty.request.id}&id={$C.block_content_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> edit
							</a>
							<a href="layout_news_block_delete.php?layout_news_id={$smarty.request.id}&id={$C.block_content_id}" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-trash"></span> delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<a href="layout_news_block_add.php?layout_news_id={$smarty.request.id}&block_def_id={$D.block_definition_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>New Block</a>
		</div>
	</div>
{/foreach}
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
