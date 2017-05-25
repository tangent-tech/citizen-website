{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content_writer.tpl"}
<h1 class="PageTitle">編輯內容撰寫員群組 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="site_content_writer_group_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 內容撰寫員群組列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">內容撰寫員群組詳情</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_content_writer_group_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr class="ui-state-highlight">
						<th colspan="2" class="AlignCenter">詳情</th>
					</tr>
					<tr>
						<th>狀態</th>
						<td>
							<input type="radio" name="content_admin_group_is_enable" value="Y" {if $ContentWriterGroup.content_admin_group_is_enable == 'Y'}checked=checked{/if} /> 啟用 
							<input type="radio" name="content_admin_group_is_enable" value="N" {if $ContentWriterGroup.content_admin_group_is_enable == 'N'}checked=checked{/if} /> 停用						
						</td>
					</tr>
					<tr>
						<th> 名稱 </th>
						<td> <input type="text" name="content_admin_group_name" value="{$ContentWriterGroup.content_admin_group_name|escape:'html'}" /> </td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確定
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</div>
	</form>
</div>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">組員列表</h2>
	<div class="InnerContent ui-widget-content">
		<table id="ContentWriterListTable" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
			<tr class="ui-state-highlight">
				<th width="50">編號</th>
				<th width="150">電郵</th>
				<th width="150">姓名</th>
				<th>操作</th>
			</tr>
			{if $ContentWriterGroupMemberList|@count == 0}
				<tr>
					<td colspan="3">未有組員</td>
				</tr>
			{/if}
			{foreach from=$ContentWriterGroupMemberList item=U}
				<tr>
					<td class="AlignCenter">{$U.content_admin_id}</td>
					<td class="AlignCenter">{$U.email}</td>
					<td class="AlignCenter">{$U.content_admin_name}</td>
					<td class="AlignCenter">
						<a href="site_content_writer_group_member_link_delete.php?id={$U.content_admin_group_member_link_id}" onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> 刪除
						</a>
					</td>
				</tr>
			{/foreach}
		</table>
		<br class="clearfloat" />
		{if $ContentWriterGroupNonMemberList|@count > 0}
			<form enctype="multipart/form-data" name="FrmContentWriterAdd" id="FrmContentWriterAdd" method="post" action="site_content_writer_group_member_link_add_act.php">
				<select name="content_admin_id">
					{foreach from=$ContentWriterGroupNonMemberList item=I}
						<option value="{$I.content_admin_id}">{$I.email}</option>
					{/foreach}
				</select>
				<input type="hidden" name="content_admin_group_id" value="{$smarty.request.id}" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmContentWriterAdd">
					<span class="ui-icon ui-icon-circle-plus"></span> 新增內容撰寫員
				</a>
			</form>
		{/if}
	</div>
</div>
			
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
