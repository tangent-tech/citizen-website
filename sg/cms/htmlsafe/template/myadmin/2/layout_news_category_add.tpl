{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">新增分類 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_news_category_list.php?language_id={$smarty.request.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 分類列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Category Details </h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_category_add_act.php">
		<div class="InnerContent ui-widget-content">
			<table class="LeftHeaderTable">
				<tr>
					<th> 分類語言 </th>
					<td>
						<select id="language_id" name="language_id">
							{foreach from=$SiteLanguageRoots item=L}
							    <option value="{$L.language_id}"
									{if $L.language_id == $smarty.request.language_id}selected="selected"{/if}
							    >{$L.language_native|escape:'html'}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<th> 分類名稱 </th>
					<td> <input type="text" name="layout_news_category_name" value="Untitled" size="90" maxlength="255" /> </td>
				</tr>
			</table>
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
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
