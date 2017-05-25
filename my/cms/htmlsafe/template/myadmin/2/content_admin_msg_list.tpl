{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_content_admin_msg.tpl"}
<h1 class="PageTitle">訊息列表 &nbsp; 
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
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table id="OrderListTable" class="TopHeaderTable">
		<tr class="ui-state-highlight">
			{* <th><!-- Selection Box --></th> *}
			<th><!-- Status --></th>
			<th>訊息編號</th>
			<th>寄件人</th>
			<th>建立日期</th>
			<th>類型</th>
			<th>狀態</th>
			<th></th>
		</tr>
		<form enctype="multipart/form-data" name="FrmFilterheader" id="FrmFilterheader" method="post">
			<tr class="AlignCenter">
				{* <td><input type="checkbox" name="SelectAll" /></td> *}
				<td>
					<select name="content_admin_msg_status">
						{foreach $ContentAdminMsgStatusList as $key => $value}
							<option value="{$value}" {if $smarty.request.content_admin_msg_status == $value}selected='selected'{/if}>{$value}</option>
						{/foreach}
					</select>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<select name="workflow_result">
						<option value="ANY">Any</option>
						{foreach $WorkflowResultList as $key => $value}
							<option value="{$key}" {if $smarty.request.workflow_result == $key}selected='selected'{/if}>{$value}</option>
						{/foreach}
					</select>
				</td>
				<td>
					<input type="hidden" name="myaction" value="filter" />
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmFilterheader">
						<span class="ui-icon ui-icon-search"></span> 篩選
					</a>
				</td>
			</tr>
		</form>
				
		{foreach from=$ContentAdminMsgList item=M}
			<tr class="AlignCenter {if $M.content_admin_msg_read_date == NULL}NewAdminMSg{/if}">
				{*	<td><input type="checkbox" name="content_admin_msg_id" value="{$M.content_admin_msg_id}" /></td> *}
				<td>
					{if $M.content_admin_msg_read_date == NULL}新!{else}-{/if}
				</td>
				<td>{$M.content_admin_msg_id}</td>
				<td>{$M.message_sender_content_admin_email}</td>
				<td>{$M.content_admin_msg_create_date|date_format:"%Y-%m-%d %H:%M"}</td>
				<td>
					{if $M.workflow_type == 'SECURITY_LEVEL_UPDATE_REQUEST'}
						安全等級變更要求
					{else}
						-
					{/if}
				</td>
				<td>
					{$WorkflowResultList[$M.workflow_result]}
				</td>
				<td>
					<a href="content_admin_msg_details.php?id={$M.content_admin_msg_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-note"></span> 詳情
					</a>
					<a href="content_admin_msg_delete.php?id={$M.content_admin_msg_id}" onclick="return DoubleConfirm('警告! \n 確定刪除？', '警告! \n 真的確定刪除？')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> 刪除
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
