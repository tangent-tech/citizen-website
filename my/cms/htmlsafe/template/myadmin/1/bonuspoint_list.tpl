{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_bonuspoint.tpl"}
<h1 class="PageTitle">Bonus Point Item List &nbsp;
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="bonuspoint_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> Permission
		</a>
	{/if}	
	<a id="BtnToggleThumbnails" class="ui-state-default ui-corner-all MyButton" href="#">
		<span class="ui-icon ui-icon-image"></span> Show/Hide Thumbnails
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="BonusPointItemListTable" class="TopHeaderTable ui-helper-reset AlignCenter">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th width="200">Item</th>
			<th width="50">Type</th>
			<th width="100">Cash Value</th>
			<th width="150">Bonus Point Required</th>
			<th>Action</th>
		</tr>
		{if $BonusPointItemList|@count == 0}
			<tr>
				<td colspan="6">No bonus item found.</td>
			</tr>
		{/if}
		{foreach from=$BonusPointItemList item=B}
			<tr class="{if $B.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$B.bonus_point_item_id}</td>
				<td>
					{if $B.object_thumbnail_file_id != 0}
						<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}getfile.php?id={$B.object_thumbnail_file_id}" /><br class="MediaSmallFile" />
					{/if}
					{$B.bonus_point_item_ref_name}
				</td>
				<td>{$B.bonus_point_item_type}</td>
				<td>{$B.cash}</td>
				<td>{$B.bonus_point_required}</td>
				<td class="AlignCenter">
					<a href="bonuspoint_edit.php?id={$B.bonus_point_item_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="bonuspoint_delete.php?id={$B.bonus_point_item_id}" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<br />
	<a href="bonuspoint_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Bonus Point Item</a> <br />
</div>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
