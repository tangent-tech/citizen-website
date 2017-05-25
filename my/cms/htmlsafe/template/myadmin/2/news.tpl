{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">{$Site.site_label_news|ucwords}根列表 &nbsp;
	<a href="news_category_list.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$Site.site_label_news|ucwords}分類列表</a>
	<form name="FrmSetLanguageID" id="FrmSetLanguageID" method="post">
		<select id="language_id" name="language_id" onchange="submit()">
			{foreach from=$SiteLanguageRoots item=L}
			    <option value="{$L.language_id}"
					{if $L.language_id == $smarty.request.language_id}selected="selected"{/if}
			    >{$L.language_native}</option>
			{/foreach}
		</select>
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">編號</th>
			<th width="300">{$Site.site_label_news|ucwords}根名稱</th>
			<th width="240">操作</th>
		</tr>
		{foreach from=$NewsRoots item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.news_root_id}</td>
				<td>{$R.news_root_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="news_list.php?id={$R.news_root_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-calculator"></span> {$Site.site_label_news|ucwords}列表
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}