{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content_writer.tpl"}
<h1 class="PageTitle">Content Writer Group List</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>
	<form name="FrmSetItemsPerPage" id="FrmSetItemsPerPage" method="post">
		Group Per Page:
		<select id="num_of_content_writer_group_per_page" name="num_of_content_writer_group_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_content_writer_group_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_content_writer_group_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_content_writer_group_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_content_writer_group_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_content_writer_group_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_content_writer_group_per_page == 9999}selected="selected"{/if}>All</option>
		</select>
	</form>
	<br />
	<table id="ContentWriterListTable" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th>Group Name</th>
			<th>Action</th>
		</tr>
		{if $ContentWriterGroupList|@count == 0}
			<tr>
				<td colspan="3">No group defined.</td>
			</tr>
		{/if}
		{foreach from=$ContentWriterGroupList item=U}
			<tr class="{if $U.content_admin_group_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$U.content_admin_group_id}</td>
				<td class="AlignCenter">{$U.content_admin_group_name}</td>
				<td class="AlignCenter">
					<a href="site_content_writer_group_edit.php?id={$U.content_admin_group_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="site_content_writer_group_delete.php?id={$U.content_admin_group_id}" onclick="return confirm('WARNING!\n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<br class="clearfloat" />
	<a href="site_content_writer_group_add.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-circle-plus"></span> Add Group
	</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
