{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_member.tpl"}
<h1 class="PageTitle">會員列表 &nbsp; 
	<a href="member_export.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-disk"></span>匯出</a>
	{if $IsContentAdmin && $Site.site_module_workflow_enable == 'Y'}
		<a class="ui-state-default ui-corner-all MyButton" href="user_root_edit.php">
			<span class="ui-icon ui-icon-locked"></span> 權限
		</a>
	{/if}	
	<form name="FrmSetPageID" id="FrmSetPageID" method="get">
		頁:
		<select id="page_id" name="page_id" onchange="submit()">
			{foreach from=$PageNoSelection item=P}
			    <option value="{$P}"
					{if $P == $smarty.request.page_id}selected="selected"{/if}
			    >{$P}</option>
			{/foreach}
		</select>
	</form>

</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<a href="member_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增會員</a> <br />
	<form name="FrmEditBlock" id="FrmEditBlock" method="post">
		<input type="text" name="SearchKey" />
		<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
			<span class="ui-icon ui-icon-search"></span> 搜尋會員
		</a>
	</form>
	{if $smarty.request.SearchKey != null}<p>搜尋結果 <strong>{$smarty.request.SearchKey}</strong></p><br />{/if}
	<table id="MemberTable" class="TopHeaderTable ui-helper-reset AlignCenter">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="250">用戶名</th>
			<th width="150">電郵地址</th>
			<th width="150">名稱1</th>
			<th width="150">名稱2</th>
			<th width="160">備註</th>
			{if $UserFieldsShow.user_security_level == 'Y'}<th width="50">安全等級</th>{/if}
			<th>操作</th>
		</tr>
		{if $Users|@count == 0}
			<tr class="nodrop nodrag">
				<td colspan="7">沒有用戶.</td>
			</tr>
		{/if}
		{foreach from=$Users item=U}
			<tr class="{if $U.user_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$U.user_id}</td>
				<td>{$U.user_username}</td>
				<td>{$U.user_email}</td>
				<td>{$U.user_first_name}</td>
				<td>{$U.user_last_name}</td>
				<td>{$U.user_note|truncate:80:"..."}</td>
				{if $UserFieldsShow.user_security_level == 'Y'}<td>{$U.user_security_level}</td>{/if}
				<td class="AlignCenter">
					<a href="member_edit.php?id={$U.user_id}&page_id={$smarty.request.page_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> 編輯
					</a>
					<a href="member_delete.php?id={$U.user_id}&page_id={$smarty.request.page_id}" class="ui-state-default ui-corner-all MyButton" onclick="return DoubleConfirm('警告！\n 所有此會員的訂單和檔案均會被刪除！\n 確定刪除嗎？', '警告！\n真的確定刪除？')">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="member_add.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>新增會員</a> <br />
	<form name="FrmEditBlock" id="FrmEditBlock" method="post">
		<input type="text" name="SearchKey" />
		<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
			<span class="ui-icon ui-icon-search"></span> 搜尋會員
		</a>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
