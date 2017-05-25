{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">{$Site.site_label_news|ucwords} Root List &nbsp;
	<a href="news_category_list.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$Site.site_label_news|ucwords} Category List</a>
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
			<th width="50">ID</th>
			<th width="300">{$Site.site_label_news|ucwords} Root Name</th>
			<th width="300">Action</th>
		</tr>
		{foreach from=$NewsRoots item=R}
			<tr class="{if $R.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$R.news_root_id}</td>
				<td>{$R.news_root_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="news_root_edit.php?id={$R.news_root_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="news_root_delete.php?id={$R.news_root_id}" onclick="return DoubleConfirm('WARNING!\n All {$Site.site_label_news|ucwords} in this root will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
					<a href="news_list.php?id={$R.news_root_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-calculator"></span> {$Site.site_label_news|ucwords} list
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="news_root_add.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add {$Site.site_label_news|ucwords} Root</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
