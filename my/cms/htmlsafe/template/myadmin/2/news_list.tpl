{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$NewsRoot.news_root_name} &nbsp;
{*	<a href="news.php?language_id={$NewsRoot.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Back</a> *}
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="news_root_permission_edit.php?id={$NewsRoot.news_root_id}">
			<span class="ui-icon ui-icon-locked"></span> 權限
		</a>
	{/if}
	<a href="news_category_list.php?language_id={$NewsRoot.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>分類列表</a>
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
		<input type="hidden" name="news_id" value="{$smarty.request.news_id}" />
		<input type="hidden" name="news_date" value="{$smarty.request.news_date}" />
		<input type="hidden" name="news_title" value="{$smarty.request.news_title}" />
		<input type="hidden" name="news_category_id" value="{$smarty.request.news_category_id}" />
		<input type="hidden" name="news_tag" value="{$smarty.request.news_tag}" />
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="120">日期</th>
			<th>標題</th>
			<th><a href="news_category_list.php?language_id={$NewsRoot.language_id}">分類</a></th>
			<th>標籤</th>
			<th width="150">操作</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td><input type="text" name="news_id" size="3" value="{$smarty.request.news_id}" /></td>
				<td><input type="text" name="news_date" class="DatePicker" value="{$smarty.request.news_date}" /></td>
				<td><input type="text" name="news_title" value="{$smarty.request.news_title}" /></td>
				<td>
					<select id="news_category_id" name="news_category_id">
						<option value="0" {if $smarty.request.news_category_id == 0}selected="selected"{/if}>所有</option>
						{foreach from=$NewsCategories item=C}
						    <option value="{$C.news_category_id}"
								{if $C.news_category_id == $smarty.request.news_category_id}selected="selected"{/if}
						    >{$C.news_category_name}</option>						
						{/foreach}
					</select>
				</td>
				<td><input type="text" name="news_tag" size="20" value="{$smarty.request.news_tag}" /></td>
				<td>
					<input type="hidden" name="id" value="{$smarty.request.id}" />
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> 篩選
					</a>
				</td>
			</tr>
		</form>
		{foreach from=$NewsList item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.news_id}</td>
				<td class="AlignCenter">{$R.news_date|date_format:'%Y-%m-%d %H:%M'}</td>
				<td class="AlignCenter">{$R.news_title}</td>
				<td class="AlignCenter">{$R.news_category_name}</td>
				<td>{$R.news_tag|substr:2:-2}</td>
				<td class="AlignCenter">
					<a href="news_edit.php?id={$R.news_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="news_delete.php?id={$R.news_id}" onclick='return confirm("警告! \n 確定刪除？")' class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="news_add.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增{$NewsRoot.news_root_name}</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
