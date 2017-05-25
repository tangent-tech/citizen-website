{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$LayoutNewsRoot.layout_news_root_name} &nbsp;
{*	<a href="layout_news.php?language_id={$LayoutNewsRoot.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Back</a> *}
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="layout_news_root_permission_edit.php?id={$LayoutNewsRoot.layout_news_root_id}">
			<span class="ui-icon ui-icon-locked"></span> 權限
		</a>
	{/if}
	<a href="layout_news_category_list.php?language_id={$LayoutNewsRoot.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>分類列表</a>
	<a href="?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> 重設篩選
	</a>
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
		<input type="hidden" name="layout_news_id" value="{$smarty.request.layout_news_id}" />
		<input type="hidden" name="layout_news_date" value="{$smarty.request.layout_news_date}" />
		<input type="hidden" name="layout_news_title" value="{$smarty.request.layout_news_title}" />
		<input type="hidden" name="layout_news_category_id" value="{$smarty.request.layout_news_category_id}" />
		<input type="hidden" name="layout_news_tag" value="{$smarty.request.layout_news_tag}" />
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="120">日期</th>
			<th>標題</th>
			<th>分類</th>
			<th>標籤</th>
			<th width="150">操作</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td><input type="text" name="layout_news_id" size="3" value="{$smarty.request.layout_news_id}" /></td>
				<td><input type="text" name="layout_news_date" class="DatePicker" value="{$smarty.request.layout_news_date}" /></td>
				<td><input type="text" name="layout_news_title" value="{$smarty.request.layout_news_title}" /></td>
				<td>
					<select id="layout_news_category_id" name="layout_news_category_id">
						<option value="0" {if $C.layout_news_category_id == 0}selected="selected"{/if}>所有</option>
						{foreach from=$LayoutNewsCategories item=C}
						    <option value="{$C.layout_news_category_id}"
								{if $C.layout_news_category_id == $smarty.request.layout_news_category_id}selected="selected"{/if}
						    >{$C.layout_news_category_name}</option>						
						{/foreach}
					</select>
				</td>
				<td><input type="text" name="layout_news_tag" size="20" value="{$smarty.request.layout_news_tag}" /></td>
				<td>
					<input type="hidden" name="id" value="{$smarty.request.id}" />
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> 篩選
					</a>
				</td>
			</tr>
		</form>		
		{foreach from=$LayoutNewsList item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.layout_news_id}</td>
				<td class="AlignCenter">{$R.layout_news_date|date_format:'%Y-%m-%d %H:%M'}</td>
				<td>{$R.layout_news_title}</td>
				<td>{$R.layout_news_category_name}</td>
				<td>{$R.layout_news_tag|substr:2:-2}</td>
				<td class="AlignCenter">
					<a href="layout_news_edit.php?id={$R.layout_news_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="layout_news_delete.php?id={$R.layout_news_id}" onclick='return confirm("警告! \n 確定刪除？")' class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="layout_news_add.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增 {$LayoutNewsRoot.layout_news_root_name}</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
