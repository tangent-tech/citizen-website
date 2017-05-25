{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content_writer.tpl"}
<h1 class="PageTitle">編輯內容撰寫員 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="site_content_writer_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 內容撰寫員列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">內容撰寫員詳情</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_content_writer_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr class="ui-state-highlight">
						<th colspan="2" class="AlignCenter">登入資料</th>
					</tr>
					<tr>
						<th>狀態</th>
						<td>
							<input type="radio" name="content_admin_is_enable" value="Y" {if $ContentWriter.content_admin_is_enable == 'Y'}checked=checked{/if} /> 啟用 
							<input type="radio" name="content_admin_is_enable" value="N" {if $ContentWriter.content_admin_is_enable == 'N'}checked=checked{/if} /> 停用						
						</td>
					</tr>
					<tr>
						<th> 電郵 </th>
						<td> <input type="text" name="email" value="{$ContentWriter.email|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 姓名 </th>
						<td> <input type="text" name="content_admin_name" value="{$ContentWriter.content_admin_name|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 密碼 </th>
						<td> <input type="password" name="password1" /> </td>
					</tr>
					<tr>
						<th> 再次輸入密碼 </th>
						<td> <input type="password" name="password2" /> </td>
					</tr>
					{foreach $ACL_LIST as $AclGroupKey => $AclGroupItem}
						<tr class="ui-state-highlight">
							<th colspan="2" class="AlignCenter">{$AclGroupKey}</th>
						</tr>
						{foreach $AclGroupItem as $key => $item}
							<tr>
								<th>{$item.desc}</th>
								<td><input type="checkbox" name="content_admin_acl_option[]" value="{$key}" {if in_array($key, $ContentWriterACL)}checked="checked"{/if}/> </td>
							</tr>							
						{/foreach}
					{/foreach}
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
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
