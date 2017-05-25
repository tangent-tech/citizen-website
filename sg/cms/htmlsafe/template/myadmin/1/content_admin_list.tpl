{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Content Admin List</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				<tr class="ui-state-highlight">
					<th class="AlignCenter">ID</th>
					<th>Username</th>
					<th class="AlignCenter">Site</th>
					<th>Role</th>
					<th></th>
				</tr>
				{foreach from=$ContentAdmins item=C}
					<tr>
						<td class="AlignCenter">{$C.content_admin_id}</td>
						<td width="200">{$C.email|escape:'html'}</td>
						<td class="AlignCenter">{$C.site_name|escape:'html'}</td>
						<td class="AlignCenter">{$C.content_admin_type|escape:'html'}</td>
						<td>
							<a href="content_admin_edit.php?id={$C.content_admin_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> Edit
							</a>
							<a href="content_admin_delete.php?id={$C.content_admin_id}" class="ui-state-default ui-corner-all MyButton" onclick="return confirm('WARNING! \n Are you sure you want to delete?')">
								<span class="ui-icon ui-icon-trash"></span> Delete
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br class="clearfloat" />
			<a href="content_admin_add.php" class="ui-state-default ui-corner-all MyButton">
				<span class="ui-icon ui-icon-circle-plus"></span> Add Content Admin
			</a>
		</div>
	</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
