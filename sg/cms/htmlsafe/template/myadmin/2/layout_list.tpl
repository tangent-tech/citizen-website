{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">排版列表</h1>
<table class="TopHeaderTable ui-helper-reset">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">編號</th>
		<th>排版名稱</th>
		<th></th>
	</tr>
	{foreach from=$Layouts item=L}
		<tr>
			<td class="AlignCenter">{$L.layout_id}</td>
			<td width="200">{$L.layout_name|escape:'html'}</td>
			<td>
				<a href="layout_edit.php?id={$L.layout_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-pencil"></span> 編輯
				</a>
				<a href="layout_delete.php?id={$L.layout_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('警告！\n 所有使用此排版的內頁和其資料都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')">
					<span class="ui-icon ui-icon-trash"></span> 刪除
				</a>							
			</td>
		</tr>
	{/foreach}
</table>
<br class="clearfloat" />
<a href="layout_add.php" class="ui-state-default ui-corner-all MyButton">
	<span class="ui-icon ui-icon-circle-plus"></span> 新增排版
</a>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
