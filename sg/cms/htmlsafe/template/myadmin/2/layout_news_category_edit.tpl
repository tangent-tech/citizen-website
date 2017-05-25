{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯新聞分類 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_category_list.php?language_id={$LayoutNewsCategory.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 分類列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_category_edit_act.php">
		<div id="LayoutNewsCatTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-News">分類詳情</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>				
			</ul>
			<div id="LayoutNewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> 分類語言 </th>
							<td>
								<select id="language_id" name="language_id">
									{foreach from=$SiteLanguageRoots item=L}
										<option value="{$L.language_id}"
											{if $L.language_id == $LayoutNewsCategory.language_id}selected="selected"{/if}
										>{$L.language_native|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> 分類名稱 </th>
							<td> <input type="text" name="layout_news_category_name" value="{$LayoutNewsCategory.layout_news_category_name|escape:'html'}" size="90" maxlength="255" /> </td>
						</tr>
					</table>
				</div>
			</div>
			<div id="LayoutNewsTabsPanel-SEO">
				{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
			</div>
		</div>
		<input type="hidden" name="id" value="{$LayoutNewsCategory.layout_news_category_id}" />
		<input class="HiddenSubmit" type="submit" value="Submit" />
		<div class="ui-widget-header ui-corner-bottom">
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
