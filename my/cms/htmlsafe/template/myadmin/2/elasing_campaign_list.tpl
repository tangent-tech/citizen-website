{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">活動列表</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
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
		每頁顯示活動:
		<select id="num_of_campaign_list_per_page" name="num_of_campaign_list_per_page" onchange="submit()">
		    <option value="10" {if $smarty.cookies.num_of_campaign_list_per_page == 10}selected="selected"{/if}>10</option>
		    <option value="20" {if $smarty.cookies.num_of_campaign_list_per_page == 20}selected="selected"{/if}>20</option>
		    <option value="30" {if $smarty.cookies.num_of_campaign_list_per_page == 30}selected="selected"{/if}>30</option>
		    <option value="40" {if $smarty.cookies.num_of_campaign_list_per_page == 40}selected="selected"{/if}>40</option>
		    <option value="50" {if $smarty.cookies.num_of_campaign_list_per_page == 50}selected="selected"{/if}>50</option>
		    <option value="99999" {if $smarty.cookies.num_of_campaign_list_per_page == 99999}selected="selected"{/if}>所有</option>
		</select>
	</form>
	<form name="FrmSetStatus" id="FrmSetStatus" method="post">
		活動狀態篩選:
		<select id="campaign_status" name="campaign_status" onchange="submit()">
		    <option value="Completed" {if $smarty.cookies.campaign_status == 'Completed'} selected="selected"{/if}>已完成</option>
		    <option value="Draft" {if $smarty.cookies.campaign_status == 'Draft'} selected="selected"{/if}>草稿</option>
		    <option value="Inactive" {if $smarty.cookies.campaign_status == 'Inactive'} selected="selected"{/if}>待啟動</option>
		    <option value="Submitted" {if $smarty.cookies.campaign_status == 'Submitted'} selected="selected"{/if}>已提交</option>
		    <option value="Active" {if $smarty.cookies.campaign_status == 'Active'} selected="selected"{/if}>已啟動</option>
		    <option value="All" {if $smarty.cookies.campaign_status == 'All'} selected="selected"{/if}>所有</option>
		    
		</select>
	</form>
	<br />


	<table class="TopHeaderTable ui-helper-reset AlignCenter">
		<tr class="ui-state-highlight">
			<th>標題</th>
			<th width="100">狀態</th>
			<th width="50">總數</th>
			<th width="50">過濾</th>
			<th width="50">發送</th>
			<th width="50">開啟</th>
			<th width="50">點擊</th>
			<th width="50">退回</th>
			<th></th>
		</tr>
		{if empty($CampaignList)}
			<tr><td colspan="12">未有活動</td></tr>
		{else}
			{foreach from=$CampaignList item=C}
				{if $C.campaign_status != $smarty.cookies.campaign_status && $smarty.cookies.campaign_status != "All"}
					{continue}
				{/if}
				<tr>
					<td>
						{$C.campaign_title}
						{if $IsContentAdmin && $C.email != null}
							<br />( {$C.email} )
						{/if}
					</td>
					<td>{$C.campaign_status}</td>
					<td>{$C.no_of_emails}</td>
					<td>{$C.no_of_blacklist+$C.no_of_deny_all}</td>
					<td>{$C.no_of_sent}</td>
					<td>{$C.no_of_opened_emails}</td>
					<td>{$C.no_of_clicked_emails}</td>
					<td>{$C.no_of_soft_bounce+$C.no_of_hard_bounce}</td>
					<td class="AlignLeft">
						{if $C.campaign_status == 'Draft' || $C.campaign_status == 'Inactive'}
							<a href="elasing_campaign_update_status.php?id={$C.campaign_id}&status=active" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-play"></span> 啟動
							</a>
						{elseif $C.campaign_status == 'Submitted' || $C.campaign_status == 'Active'}
							<a href="elasing_campaign_update_status.php?id={$C.campaign_id}&status=inactive" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pause"></span> 暫停
							</a>
						{/if}
						{if $C.campaign_status != 'Completed'}
							<a href="elasing_campaign_edit.php?id={$C.campaign_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯
							</a>
						{/if}
						{if $C.campaign_status == 'Completed'}
							<a href="elasing_campaign_editasnew.php?id={$C.campaign_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> 編輯為新活動
							</a>
						{/if}
						<a href="elasing_campaign_report.php?id={$C.campaign_id}" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-clipboard"></span> 報告
						</a>
						<a href="elasing_campaign_list_delete.php?id={$C.campaign_id}" onclick='return confirm("警告! \n 確定刪除？")' class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> 刪除
						</a>
					</td>
				</tr>
			{/foreach}
		{/if}
	</table>

	<a href="elasing_campaign_add.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-circle-plus"></span> 新增活動
	</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
