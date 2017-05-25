{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯{$Site.site_label_news|ucwords}分類 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="news_category_list.php?language_id={$NewsCategory.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_news|ucwords}分類列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">{$Site.site_label_news|ucwords}分類詳情 </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="news_category_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th> {$Site.site_label_news|ucwords}分類語言 </th>
					<td>
						<select id="language_id" name="language_id">
							{foreach from=$SiteLanguageRoots item=L}
							    <option value="{$L.language_id}"
									{if $L.language_id == $NewsCategory.language_id}selected="selected"{/if}
							    >{$L.language_native|escape:'html'}</option>
							{/foreach}
						</select>	
					</td>
				</tr>
				<tr>
					<th> {$Site.site_label_news|ucwords}分類名稱 </th>
					<td> <input type="text" name="news_category_name" value="{$NewsCategory.news_category_name|escape:'html'}" size="90" maxlength="255" /> </td>
				</tr>
			</table>
			<input type="hidden" name="id" value="{$NewsCategory.news_category_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom">
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
