{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">{$Site.site_label_product|ucwords} Root List </h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th width="300">{$Site.site_label_product|ucwords} Root Name</th>
			<th width="240">Action</th>
		</tr>
		{foreach from=$ProductRoots item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.object_id}</td>
				<td>{$R.object_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="product_root_edit.php?link_id={$R.object_link_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="product_root_delete.php?id={$R.object_link_id}" onclick="return DoubleConfirm('WARNING!\n All products in this tree will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="product_root_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add {$Site.site_label_product|ucwords} Root</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
