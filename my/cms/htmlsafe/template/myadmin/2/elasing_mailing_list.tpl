{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">電郵名單</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>
	<form name="FrmSetItemsPerPage" id="FrmSetItemsPerPage" method="post">
		每頁顯示:
		<select id="num_of_elasing_list_per_page" name="num_of_elasing_list_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_elasing_list_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_elasing_list_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_elasing_list_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_elasing_list_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_elasing_list_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_elasing_list_per_page == 9999}selected="selected"{/if}>所有</option>
		</select>
	</form>
	<br />
	<table class="TopHeaderTable ui-helper-reset AlignCenter">
		<tr class="ui-state-highlight">
			<th>編號</th>
			<th width="200">名單名稱</th>
			{if $Site.site_module_elasing_multi_level == 'Y' && $IsContentAdmin}
				<th width="150">用戶</th>
			{/if}
{*			<th width="150">Create Date</th>	*}
			<th width="150">最後更新</th>
			<th></th>
		</tr>
		{if empty($EmailList)}
			<tr><td colspan="5">未有名單</td></tr>
		{/if}
		{foreach from=$EmailList item=E}
			<tr>
				<td>{$E.list_id}</td>
				<td>{$E.list_name}</td>
				{if $Site.site_module_elasing_multi_level == 'Y' && $IsContentAdmin}
					<td>{$E.email}</td>
				{/if}
{*	<td>{$E.create_date}</td>	*}
				<td>{$E.last_update}</td>
				<td>
					<a href="elasing_mailing_list_edit.php?id={$E.list_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="elasing_mailing_list_delete.php?id={$E.list_id}" onclick='return confirm("警告! \n 確定刪除？")' class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	
	<a href="elasing_mailing_list_add.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-circle-plus"></span> 新增名單
	</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
