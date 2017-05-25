{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">媒體列表  &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="album_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 專輯列表
	</a>
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> 顯示/隱藏縮略圖
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>
	<form name="FrmSetItemsPerPage" id="FrmSetItemsPerPage" method="post">
		每頁顯示:
		<select id="num_of_photos_per_page" name="num_of_photos_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_photos_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_photos_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_photos_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_photos_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_photos_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_photos_per_page == 9999}selected="selected"{/if}>所有</option>
		</select>
	</form>
	<br />
	<table id="MediaListTable-{$smarty.request.id}" data-num_of_photos_per_page="{$smarty.cookies.num_of_photos_per_page}" data-page_id="{$smarty.request.page_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight nodrop nodrag">
			<th width="50">編號</th>
			<th width="150">媒體</th>
			<th width="250">描述</th>
			<th>操作</th>
		</tr>
		{if $MediaList|@count == 0}
			<tr class="nodrop nodrag">
				<td colspan="3">沒有檔案</td>
			</tr>
		{/if}
		{foreach from=$MediaList item=M}
			<tr id="Media-{$M.media_id}" class="{if $M.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$M.media_id}</td>
				<td>
					{if $M.media_small_file_id != 0}
						<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview"><img class="MediaSmallFile" {if $Site.site_media_small_width > 0 && $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}getfile.php?id={$M.media_small_file_id}" /><br class="MediaSmallFile" />{$M.filename}</a>
					{else}
						<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview">{$M.filename}</a>
					{/if}
				</td>
				<td class="AlignCenter">{$M.media_desc}</td>
				<td class="AlignCenter">
					<a href="album_set_highlight.php?album_id={$M.parent_object_id}&id={$M.media_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-image"></span> 相簿縮略圖
					</a>
					<a href="media_edit.php?id={$M.media_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="media_delete.php?id={$M.media_id}" onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<br />
	<form enctype="multipart/form-data" name="FrmAddPhoto" id="FrmAddPhoto" method="post" action="media_add_act.php">
		<input type="file" name="media[]" multiple="true" />
		<input type="file" name="media[]" multiple="true" />
		<input type="file" name="media[]" multiple="true" /> <br />
		<br />
		媒體安全等級: <input type="text" name="media_security_level" value="{$Site.site_default_security_level}" />
		<br />		
		<input type="hidden" name="id" value="{$smarty.request.id}" />
		{if $Site.site_media_watermark_big_file_id != 0 || $Site.site_media_watermark_small_file_id != 0}
			<input type="checkbox" name="AddWatermark" checked="checked" value="Y" /> 新增水印
			<br />
		{/if}
		<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddPhoto">
			<span class="ui-icon ui-icon-circle-plus"></span> 新增媒體
		</a>
		<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddPhoto">
			<span class="ui-icon ui-icon-cancel"></span> 重設
		</a>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
