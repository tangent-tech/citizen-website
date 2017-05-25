{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">{$Site.site_label_layout_news|ucwords}根列表 &nbsp;
	<a href="layout_news_category_list.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$Site.site_label_layout_news|ucwords}分類列表</a>
	<form name="FrmSetLanguageID" id="FrmSetLanguageID" method="post">
		<select id="language_id" name="language_id" onchange="submit()">
			{foreach from=$SiteLanguageRoots item=L}
			    <option value="{$L.language_id}"
					{if $L.language_id == $smarty.request.language_id}selected="selected"{/if}
			    >{$L.language_native}</option>
			{/foreach}
		</select>
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="300">{$Site.site_label_layout_news|ucwords}根名稱</th>
			<th width="260">操作</th>
		</tr>
		{foreach from=$LayoutNewsRoots item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.layout_news_root_id}</td>
				<td>{$R.layout_news_root_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="layout_news_root_edit.php?id={$R.layout_news_root_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="layout_news_root_delete.php?id={$R.layout_news_root_id}" onclick="return DoubleConfirm('警告！\n 所有在此分類中的項目和資料都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
					<a href="layout_news_list.php?id={$R.layout_news_root_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-calculator"></span> {$Site.site_label_layout_news|ucwords}列表
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="layout_news_root_add.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增{$Site.site_label_layout_news|ucwords}根</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}