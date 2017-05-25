{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">　編輯用戶 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="elasing_user_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 用戶列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">用戶詳情</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_user_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th>狀態</th>
						<td>
							<input type="radio" name="content_admin_is_enable" value="Y" {if $TheContentAdmin.content_admin_is_enable == 'Y'}checked=checked{/if} /> 啟用 
							<input type="radio" name="content_admin_is_enable" value="N" {if $TheContentAdmin.content_admin_is_enable == 'N'}checked=checked{/if} /> 停用						
						</td>
					</tr>
					<tr>
						<th> 電郵 </th>
						<td> <input type="text" name="email" value="{$TheContentAdmin.email|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 名稱 </th>
						<td> <input type="text" name="content_admin_name" value="{$TheContentAdmin.content_admin_name|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 密碼 </th>
						<td> <input type="password" name="password1" /> </td>
					</tr>
					<tr>
						<th> 再次輸入密碼　</th>
						<td> <input type="password" name="password2" /> </td>
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
				<span class="ui-icon ui-icon-cancel"></span> 重置
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
