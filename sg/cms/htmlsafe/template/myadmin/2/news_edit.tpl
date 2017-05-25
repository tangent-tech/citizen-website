{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯 {$News.news_root_name|escape:'html'} &nbsp;
	<a href="news_list.php?id={$News.news_root_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$News.news_root_name|escape:'html'}</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_edit_act.php">
		<div id="NewsTabs">
			<ul>
				<li><a href="#NewsTabsPanel-News">詳情</a></li>
				<li><a href="#NewsTabsPanel-SEO">SEO</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#NewsTabsPanel-Permission">權限</a></li>{/if}
			</ul>
			<div id="NewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th>日期</th>
							<td><input type="text" name="news_date" class="DatePicker" value="{$News.news_date|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time use_24_hours=true display_seconds=false time=$News.news_date}</td>
						</tr>
						<tr>
							<th>分類</th>
							<td>
								<select name="news_category_id">
									{foreach from=$NewsCategories item=C}
									    <option value="{$C.news_category_id}"
											{if $C.news_category_id == $News.news_category_id}selected="selected"{/if}
									    >{$C.news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>標題</th>
							<td><input type="text" name="news_title" value="{$News.news_title|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>標籤</th>
							<td><input type="text" name="news_tag" value="{$NewsTagText|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th> 相簿 </th>
							<td>
								<select name="album_id">
									<option value="0" {if $News.album_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$Albums item=A}
										<option value="{$A.album_id}" {if $A.album_id == $News.album_id}selected="selected"{/if}>{$A.object_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<strong>摘要</strong> <br />
								{$SummaryEditorHTML}
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<strong>內容</strong> <br />
								{$EditorHTML}
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="NewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="NewsTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}			
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="SummaryEditor ContentEditor">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
