{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
	<a href="language_tree_copy.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-gear"></span> 複製語言結構樹
	</a>
	<br />
	<br />
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">使用中的語言</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			{if $LanguageRootList|@count == 0}
				<p>沒有語言使用中</p>
			{else}
				<table class="TopHeaderTable ui-helper-reset">
					{foreach from=$LanguageRootList item=L}
						<tr>
							<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
							<td>
								<a href="language_tree.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-gear"></span> 管理
								</a>
								<a href="language_tree_delete.php?id={$L.language_root_id}" onclick="return DoubleConfirm('警告！\n 所有在此語言結構樹中的項目和資料都會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-trash"></span> 刪除
								</a>
							</td>
						</tr>
					{/foreach}
				</table>
			{/if}
			<br class="clearfloat" />
		</div>
	</div>
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">未被使用的語言</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$LanguageWithNoRootList item=L}
					<tr>
						<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
						<td>
							<a href="language_root_add.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> 新增
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br class="clearfloat" />
		</div>
	</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
