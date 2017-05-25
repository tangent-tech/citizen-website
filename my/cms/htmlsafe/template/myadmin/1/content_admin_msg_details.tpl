{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_content_admin_msg.tpl"}
<h1 class="PageTitle">Message Details &nbsp;
	<a onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="content_admin_msg_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="content_admin_msg_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Message List
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_msg_action.php">
		<table id="ContentAdminMsgDetailsInfoTable">
			<tr>
				<th>Receive Date:</th>
				<td>{$ContentAdminMsg.content_admin_msg_create_date|date_format:"%Y-%m-%d %H:%M"}</td>
			</tr>
			<tr>
				<th>Sender:</th>
				<td>{$ContentAdminMsg.message_sender_content_admin_email}</td>
			</tr>
			<tr>
				<th>Workflow ID:</th>
				<td>{$ContentAdminMsg.workflow_id}</td>
			</tr>
			<tr>
				<th>Workflow Created By:</th>
				<td>{$ContentAdminMsg.workflow_sender_content_admin_email}</td>
			</tr>
			<tr>
				<th>Type:</th>
				<td>
					{if $ContentAdminMsg.workflow_type == 'SECURITY_LEVEL_UPDATE_REQUEST'}
						Security level update request (From {$ContentAdminMsg.workflow_para_int_2} to {$ContentAdminMsg.workflow_para_int_1}) - 
						{if $TheObject.object_link_id|intval > 0}
							<a href="http://{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ PREVIEW ]</a>
						{else}
							<a href="http://{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">[ PREVIEW ]</a>
						{/if}
					{/if}
				</td>
			</tr>
			{if $ContentAdminMsg.workflow_id != 0}
				<tr>
					<th>Status:</th>
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
					<th>Message</th>
					<td><input type="text" name="workflow_comment_by_receiver" value="" /></td>
				</tr>
				<tr>
					<th>Action:</th>
					<td>
						<a onclick="return DoubleConfirmSubmit('WARNING!\n Are you sure you want to accept this request?', 'WARNING!\nAre you 100% sure?', 'accept', 'FrmEditBlock', 'myaction')" class="ui-state-default ui-corner-all MyButton" href="#">
							<span class="ui-icon ui-icon-check"></span> Accept
						</a>
						<a onclick="return DoubleConfirmSubmit('WARNING!\n Are you sure you want to reject this request?', 'WARNING!\nAre you 100% sure?', 'reject', 'FrmEditBlock', 'myaction')" class="ui-state-default ui-corner-all MyButton" href="#">
							<span class="ui-icon ui-icon-close"></span> Reject
						</a>
					</td>
				</tr>
			{else}
				<tr>
					<th>Message</th>
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
