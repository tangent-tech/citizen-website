{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content_writer.tpl"}
<h1 class="PageTitle">新增內容撰寫員群組 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="site_content_writer_group_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 內容撰寫員群組列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">內容撰寫員群組詳情</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_content_writer_group_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> 名稱 </th>
						<td> <input type="text" name="content_admin_group_name" value="{$smarty.request.content_admin_group_name|escape:'html'}" /> </td>
					</tr>
				</table>
			</div>
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