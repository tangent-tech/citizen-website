{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">　相簿列表 &nbsp;
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="album_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> 權限
		</a>
	{/if}
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> 顯示/隱藏 縮圖
	</a>
	{if $ObjectFieldsShow.object_seo_tab == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="album_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> SEO
		</a>
	{/if}
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="AlbumListTable" class="TopHeaderTable ui-helper-reset SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">編號</th>
			<th width="300">相簿名稱</th>
			<th width="260">操作</th>
		</tr>
		{foreach from=$Albums item=A}
			<tr id="Album-{$A.album_id}" class="AlignCenter {if $A.object_is_enable == 'N'}DisabledRow{/if}">
				<td>{$A.album_id}</td>
				<td>
					{if $A.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$A.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
					{$A.object_name|escape:'html'}
				</td>
				<td>
					<a href="album_edit.php?link_id={$A.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="album_delete.php?id={$A.album_id}" onclick="return DoubleConfirm('警告! \n 這個相簿的所有媒體都會被刪除。\n　確定刪除？', '警告! \n 真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
					<a href="media_list.php?id={$A.album_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-calculator"></span> 媒體列表
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="album_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增相簿</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
