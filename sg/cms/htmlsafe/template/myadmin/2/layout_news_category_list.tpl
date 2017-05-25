{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">分類列表 &nbsp;
{*	<a href="layout_news.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$Site.site_label_layout_news|ucwords} Root List</a> *}
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

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="300">分類</th>
			<th width="150">操作</th>
		</tr>
		{if $LayoutNewsCategories|@count == 0}
			<tr>
				<td colspan="3" class="AlignCenter"><p>未有分類</p></td>
			</tr>
		{/if}
		{foreach from=$LayoutNewsCategories item=C}
			<tr class="{if $C.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$C.layout_news_category_id}</td>
				<td>{$C.layout_news_category_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="layout_news_category_edit.php?id={$C.layout_news_category_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="layout_news_category_delete.php?id={$C.layout_news_category_id}" onclick="return DoubleConfirm('警告！\n 所有在此分類中的項目和資料都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="layout_news_category_add.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增分類</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
