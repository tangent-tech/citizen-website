{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_content_admin_msg.tpl"}
<h1 class="PageTitle">訊息內容 &nbsp;
	<a onclick="return DoubleConfirm('警告! \n 確定刪除？', '警告! \n 真的確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="content_admin_msg_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="content_admin_msg_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 訊息列表
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_msg_action.php">
		<table id="ContentAdminMsgDetailsInfoTable">
			<tr>
				<th>接收日期:</th>
				<td>{$ContentAdminMsg.content_admin_msg_create_date|date_format:"%Y-%m-%d %H:%M"}</td>
			</tr>
			<tr>
				<th>寄件人:</th>
				<td>{$ContentAdminMsg.message_sender_content_admin_email}</td>
			</tr>
			<tr>
				<th>流程編號:</th>
				<td>{$ContentAdminMsg.workflow_id}</td>
			</tr>
			<tr>
				<th>流程創建者:</th>
				<td>{$ContentAdminMsg.workflow_sender_content_admin_email}</td>
			</tr>
			<tr>
				<th>類型:</th>
				<td>
					{if $ContentAdminMsg.workflow_type == 'SECURITY_LEVEL_UPDATE_REQUEST'}
						安全等級變更要求 (由 {$ContentAdminMsg.workflow_para_int_2} 改為 {$ContentAdminMsg.workflow_para_int_1}) - 
						{if $TheObject.object_link_id|intval > 0}
							<a href="http://{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ 預覽 ]</a>
						{else}
							<a href="http://{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ 預覽 ]</a>
						{/if}
					{/if}
				</td>
			</tr>
			{if $ContentAdminMsg.workflow_id != 0}
				<tr>
					<th>狀態:</th>
					<td>
						{$WorkflowResultList[$ContentAdminMsg.workflow_result]}
						{if $ContentAdminMsg.workflow_result == 'APPROVED' || $ContentAdminMsg.workflow_result == 'REJECTED'}
							by {$ContentAdminMsg.result_content_admin_email}
						{/if}
					</td>
				</tr>			
			{/if}
			{if $ContentAdminMsg.workflow_result == 'AWAITING_APPROVAL'}
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
			{else}
				<tr>
					<th>訊息</th>
					<td>{$ContentAdminMsg.workflow_comment_by_receiver}</td>
				</tr>				
			{/if}
		</table>
		<input type="hidden" id="myaction" name="myaction" value="" />
		<input type="hidden" name="id" value="{$ContentAdminMsg.content_admin_msg_id}" />
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
