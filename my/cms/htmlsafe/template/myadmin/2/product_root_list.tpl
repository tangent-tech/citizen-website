{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">{$Site.site_label_product|ucwords}根列表 </h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="300">{$Site.site_label_product|ucwords}根名稱</th>
			<th width="240">操作</th>
		</tr>
		{foreach from=$ProductRoots item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.object_id}</td>
				<td>{$R.object_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="product_root_edit.php?link_id={$R.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="product_root_delete.php?id={$R.object_link_id}" onclick="return DoubleConfirm('警告！\n 所有在此{$Site.site_label_product|ucwords}根中的分類和項目都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="product_root_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增{$Site.site_label_product|ucwords}根</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
