{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
	<a href="language_tree_copy.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-gear"></span> Copy Tree
	</a>
	<br />
	<br />
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Languages In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			{if $LanguageRootList|@count == 0}
				<p>No langauge is in use now.</p>
			{else}
				<table class="TopHeaderTable ui-helper-reset">
					{foreach from=$LanguageRootList item=L}
						<tr>
							<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
							<td>
								<a href="language_tree.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-gear"></span> Manage
								</a>
								<a href="language_tree_delete.php?id={$L.language_root_id}" onclick="return DoubleConfirm('WARNING!\n All objects and data in this language tree will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-trash"></span> Delete
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
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Languages Not In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$LanguageWithNoRootList item=L}
					<tr>
						<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
						<td>
							<a href="language_root_add.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> Add
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
