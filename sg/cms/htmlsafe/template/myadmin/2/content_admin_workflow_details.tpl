{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_content_admin_msg.tpl"}
<h1 class="PageTitle">流程詳情 &nbsp;
{*
	<a onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="content_admin_workflow_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
*}
	<a class="ui-state-default ui-corner-all MyButton" href="content_admin_workflow_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 流程列表
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_workflow_action.php">
		<table id="ContentAdminMsgDetailsInfoTable">
			<tr>
				<th>流程編號:</th>
				<td>{$Workflow.workflow_id}</td>
			</tr>
			<tr>
				<th>日期:</th>
				<td>{$Workflow.workflow_create_date|date_format:"%Y-%m-%d %H:%M"}</td>
			</tr>
			<tr>
				<th>流程創建者:</th>
				<td>{$Workflow.workflow_sender_content_admin_email}</td>
			</tr>
			<tr>
				<th>類型:</th>
				<td>
					{if $Workflow.workflow_type == 'SECURITY_LEVEL_UPDATE_REQUEST'}
						安全等級變更要求 (由 {$Workflow.workflow_para_int_2} 改為 {$Workflow.workflow_para_int_1}) - 
						{if $TheObject.object_link_id|intval > 0}
							<a href="http://{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ 預覽 ]</a>
						{else}
							<a href="http://{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ 預覽 ]</a>
						{/if}
					{/if}
				</td>
			</tr>
			{if $Workflow.workflow_id != 0}
				<tr>
					<th>狀態:</th>
					<td>
						{$WorkflowResultList[$Workflow.workflow_result]}
						{if $Workflow.workflow_result == 'APPROVED' || $Workflow.workflow_result == 'REJECTED'}
							by {$Workflow.result_content_admin_email}
						{/if}
					</td>
				</tr>			
			{/if}
			{if $Workflow.workflow_result == 'AWAITING_APPROVAL'}
				{if $Workflow.sender_content_admin_id != $AdminInfo.content_admin_id}
					<tr>
						<th>訊息</th>
						<td><input type="text" name="workflow_comment_by_receiver" value="" /></td>
					</tr>
					<tr>
						<th>操作:</th>
						<td>
							<a onclick="return DoubleConfirmSubmit('警告!\n 你確定接納這個要求？', '警告!\n真的確定?', 'accept', 'FrmEditBlock', 'myaction')" class="ui-state-default ui-corner-all MyButton" href="#">
								<span class="ui-icon ui-icon-check"></span> 接受
							</a>
							<a onclick="return DoubleConfirmSubmit('警告!\n 你確定拒絕這個要求？', '警告!\n真的確定?', 'reject', 'FrmEditBlock', 'myaction')" class="ui-state-default ui-corner-all MyButton" href="#">
								<span class="ui-icon ui-icon-close"></span> 拒絕
							</a>
						</td>
					</tr>
				{/if}
			{else}
				<tr>
					<th>訊息</th>
					<td>{$Workflow.workflow_comment_by_receiver}</td>
				</tr>				
			{/if}
		</table>
		<input type="hidden" id="myaction" name="myaction" value="" />
		<input type="hidden" name="id" value="{$Workflow.workflow_id}" />
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
