{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">　編輯電郵名單 &nbsp;
	<a href="elasing_mailing_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>電郵名單列表</a>
	{if $Site.site_module_member_enable == 'Y'}
		<a href="elasing_mailing_list_import_member.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-triangle-s"></span>匯入會員</a>
	{/if}
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader"> 電郵名單詳情 </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="elasing_mailing_list_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				{if $IsContentAdmin}
					<tr>
						<th>擁有者</th>
						<td>{$EmailList.email}</td>
					</tr>
				{/if}
				<tr>
					<th>電郵名單名稱</th>
					<td><input type="text" size="80" name="list_name" value="{$EmailList.list_name}" /></td>
				</tr>
				<tr>
					<th>電郵名單描述</th>
					<td><textarea name="list_desc" cols="76" rows="3">{$EmailList.list_desc}</textarea></td>
				</tr>
			</table>
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

<div class="ui-widget ui-corner-all InnerContainer" id="SubscriberListTab">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">訂戶名單</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom" id="SubscriberListPanel">
		<div class="AdminListBlock">
			{if $TotalSubscriber == 0}
				<p>未有訂戶</p>
			{else}
				<p>
					總電郵地址數目: {$TotalSubscriber}
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
					<form name="FrmSetItemsPerPage" id="FrmSetItemsPerPage" method="post">
						每頁顯示:
						<select id="num_of_elasing_user_per_page" name="num_of_elasing_user_per_page" onchange="submit()">
						    <option value="20" {if $smarty.cookies.num_of_elasing_user_per_page == 20}selected="selected"{/if}>20</option>
						    <option value="50" {if $smarty.cookies.num_of_elasing_user_per_page == 50}selected="selected"{/if}>50</option>
						    <option value="100" {if $smarty.cookies.num_of_elasing_user_per_page == 100}selected="selected"{/if}>100</option>
						    <option value="200" {if $smarty.cookies.num_of_elasing_user_per_page == 200}selected="selected"{/if}>200</option>
						    <option value="500" {if $smarty.cookies.num_of_elasing_user_per_page == 500}selected="selected"{/if}>500</option>
						    <option value="1000" {if $smarty.cookies.num_of_elasing_user_per_page == 1000}selected="selected"{/if}>1000</option>
						    <option value="99999" {if $smarty.cookies.num_of_elasing_user_per_page == 99999}selected="selected"{/if}>所有</option>
						</select>
					</form>
					<br />
				</p>
				<table id="SubscriaberListTable">
					<tr>
						<th width="150">電郵</th>
						<th>軟退回</th>
						<th>硬退回</th>
						<th>用戶拒絕接收</th>
						<th>列入黑名單</th>
						<th></th>
					</tr>
					{foreach from=$SubscriberList item=S}
						<tr>
							<td>
								{if $S.subscriber_first_name != '' || $S.subscriber_last_name != ''}
									{$S.subscriber_first_name} {$S.subscriber_last_name} <br />
								{/if}
									{$S.subscriber_email}
							</td>
							<td>{$S.soft_bounce_count}</td>
							<td>{$S.hard_bounce_count}</td>
							<td>{if ($S.deny_all_elasing == 'N' && $S.deny_all_list == 'N') || $S.deny_all_site == 'Y'}否{else}是{/if}</td>
							<td>{if $S.soft_bounce_count >= $smarty.const.SOFT_BOUNCE_LIMIT || $S.hard_bounce_count >= $smarty.const.HARD_BOUNCE_LIMIT}是{else}否{/if}</td>
							<td>
								<a href="elasing_mailing_list_subscriber_id_delete.php?id={$S.list_subscriber_id}" class="ui-state-default ui-corner-all MyButton" onclick="return confirm('警告! \n 確定刪除？')">
									<span class="ui-icon ui-icon-trash"></span> 刪除
								</a>
							</td>
						</tr>
				    {/foreach}
				</table>
			{/if}
			<form enctype="multipart/form-data" name="FrmAddSubscriberEmail" id="FrmAddSubscriberEmail" method="post" action="elasing_subscriber_email_add.php">
				<table>
					<tr>
						<th>電郵</th>
						<td><input type="text" name="subscriber_email_address" /></td>
					</tr>
					{if $smarty.session.site_id != 39}
						<tr>
							<th>名</th>
							<td><input type="text" name="subscriber_first_name" /></td>
						</tr>
						<tr>
							<th>姓</th>
							<td><input type="text" name="subscriber_last_name" /></td>
						</tr>
					{else}
						<tr>
							<th>接收名稱</th>
							<td><input type="text" name="subscriber_first_name" /></td>
						</tr>
						<tr>
							<th>寄件者名稱</th>
							<td><input type="text" name="subscriber_last_name" /></td>
						</tr>					
					{/if}
				</table>
				<input type="hidden" name="id" value="{$smarty.request.id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddSubscriberEmail">
					<span class="ui-icon ui-icon-circle-plus"></span> 新增
				</a>
			</form>
			<br class="clearfloat" />
			<form enctype="multipart/form-data" name="FrmImportSubscriberFromCSV" id="FrmImportSubscriberFromCSV" method="post" action="elasing_import_subscriber_from_csv.php">
				<input type="file" name="csv_file"/>
				<input type="hidden" name="id" value="{$smarty.request.id}" />
				<input class="HiddenSubmit" type="submit" value="Submit" />
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmImportSubscriberFromCSV">
					<span class="ui-icon ui-icon-circle-triangle-n"></span> 從CSV UTF-8匯入用戶
				</a>
			</form>
			<br class="clearfloat" />
		</div>
	</div>
</div>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
