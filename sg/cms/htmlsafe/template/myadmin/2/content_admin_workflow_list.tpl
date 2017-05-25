{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_content_admin_msg.tpl"}
<h1 class="PageTitle">流程列表 &nbsp; 
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
			<th>流程編號</th>
			<th>寄件人</th>
			<th>日期</th>
			<th>類型</th>
			<th>狀態</th>
			<th></th>
		</tr>
		<form enctype="multipart/form-data" name="FrmFilterheader" id="FrmFilterheader" method="post">
			<tr class="AlignCenter">
				{* <td><input type="checkbox" name="SelectAll" /></td> *}
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<select name="workflow_result">
						<option value="ANY">所有</option>
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
				
		{foreach from=$ContentAdminWorkflowList item=M}
			<tr class="AlignCenter {if $M.content_admin_msg_read_date == NULL}NewAdminMSg{/if}">
				{*	<td><input type="checkbox" name="content_admin_msg_id" value="{$M.content_admin_msg_id}" /></td> *}
				<td>{$M.workflow_id}</td>
				<td>{$M.workflow_sender_content_admin_email}</td>
				<td>{$M.workflow_create_date|date_format:"%Y-%m-%d %H:%M"}</td>
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
					<a href="content_admin_workflow_details.php?id={$M.workflow_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-note"></span> 詳情
					</a>
{*
					<a href="content_admin_msg_delete.php?id={$M.content_admin_msg_id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
*}
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
