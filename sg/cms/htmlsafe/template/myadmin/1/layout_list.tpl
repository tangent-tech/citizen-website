{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Layout List</h1>
<table class="TopHeaderTable ui-helper-reset">
	<tr class="ui-state-highlight">
		<th class="AlignCenter">ID</th>
		<th>Layout Name</th>
		<th></th>
	</tr>
	{foreach from=$Layouts item=L}
		<tr>
			<td class="AlignCenter">{$L.layout_id}</td>
			<td width="200">{$L.layout_name|escape:'html'}</td>
			<td>
				<a href="layout_edit.php?id={$L.layout_id}" class="ui-state-default ui-corner-all MyButton">
					<span class="ui-icon ui-icon-pencil"></span> Edit
				</a>
				<a href="layout_delete.php?id={$L.layout_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('WARNING!\n All pages using this layout, together with the corresponding block definition and content, will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')">
					<span class="ui-icon ui-icon-trash"></span> Delete
				</a>							
			</td>
		</tr>
	{/foreach}
</table>
<br class="clearfloat" />
<a href="layout_add.php" class="ui-state-default ui-corner-all MyButton">
	<span class="ui-icon ui-icon-circle-plus"></span> Add Layout
</a>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
