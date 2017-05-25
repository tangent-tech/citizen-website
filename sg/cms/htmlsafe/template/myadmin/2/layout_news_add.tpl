{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">新增{$LayoutNewsRoot.layout_news_root_name|escape:'html'} &nbsp;
	<a href="layout_news_list.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$LayoutNewsRoot.layout_news_root_name|escape:'html'}</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_add_act.php">
		<div id="LayoutNewsTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-News">詳情</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>
			</ul>
			<div id="LayoutNewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> 安全等級 </th>
							<td> <input type="text" name="object_security_level" value="{$Site.site_default_security_level}" size="6" /> </td>
						</tr>
						<tr>
							<th>日期</th>
							<td><input type="text" name="layout_news_date" class="DatePicker" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time use_24_hours=true display_seconds=false}</td>
						</tr>
						<tr>
							<th>分類</th>
							<td>
								<select name="layout_news_category_id">
									{foreach from=$LayoutNewsCategories item=C}
									    <option value="{$C.layout_news_category_id}">{$C.layout_news_category_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>標題</th>
							<td><input type="text" name="layout_news_title" value="Untitled News" size="80" /></td>
						</tr>
						<tr>
							<th>標籤</th>
							<td><input type="text" name="layout_news_tag" value="" size="80" /></td>
						</tr>
						<tr>
							<th>排版 </th>
							<td>
								<select name="layout_id">
									<option value="0" selected="selected"> - </option>
									{foreach from=$Layouts item=L}
										<option value="{$L.layout_id}">{$L.layout_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> 相簿 </th>
							<td>
								<select name="album_id">
									<option value="0" selected="selected"> - </option>
									{foreach from=$Albums item=A}
										<option value="{$A.album_id}">{$A.object_name|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="LayoutNewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_add.tpl"}
			</div>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確定
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="SummaryEditor ContentEditor">
					<span class="ui-icon ui-icon-cancel"></span> 重置
				</a>
			</div>
		</div>
	</form>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
