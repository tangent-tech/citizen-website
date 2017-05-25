{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">用戶列表</h1>

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
		<select id="num_of_elasing_user_per_page" name="num_of_elasing_user_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_elasing_user_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_elasing_user_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_elasing_user_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_elasing_user_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_elasing_user_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="9999" {if $smarty.cookies.num_of_elasing_user_per_page == 9999}selected="selected"{/if}>所有</option>
		</select>
	</form>
	<br />
	<table id="ElasingUserListTable" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="150">電郵</th>
			<th width="150">名稱</th>
			<th>操作</th>
		</tr>
		{if $ElasingUserList|@count == 0}
			<tr>
				<td colspan="3">未有用戶</td>
			</tr>
		{/if}
		{foreach from=$ElasingUserList item=U}
			<tr class="{if $U.content_admin_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$U.content_admin_id}</td>
				<td class="AlignCenter">{$U.email}</td>
				<td class="AlignCenter">{$U.content_admin_name}</td>
				<td class="AlignCenter">
					<a href="elasing_user_edit.php?id={$U.content_admin_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="elasing_user_delete.php?id={$U.content_admin_id}" onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<br class="clearfloat" />
	<a href="elasing_user_add.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-circle-plus"></span> 新增用戶
	</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
