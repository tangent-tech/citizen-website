{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Category List &nbsp;
{*	<a href="news.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>{$Site.site_label_news|ucwords} Root List</a> *}
	<form name="FrmSetLanguageID" id="FrmSetLanguageID" method="post">
		<select id="language_id" name="language_id" onchange="submit()">
			{foreach from=$SiteLanguageRoots item=L}
			    <option value="{$L.language_id}"
					{if $L.language_id == $smarty.request.language_id}selected="selected"{/if}
			    >{$L.language_native|escape:'html'}</option>
			{/foreach}
		</select>
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th width="300">Category</th>
			<th width="150">Action</th>
		</tr>
		{if $NewsCategories|@count == 0}
			<tr>
				<td colspan="3" class="AlignCenter"><p>No category is defined.</p></td>
			</tr>
		{/if}
		{foreach from=$NewsCategories item=C}
			<tr class="{if $C.object_is_enable == 'N'}DisabledRow{/if}">
				<td class="AlignCenter">{$C.news_category_id}</td>
				<td>{$C.news_category_name|escape:'html'}</td>
				<td class="AlignCenter">
					<a href="news_category_edit.php?id={$C.news_category_id}" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="news_category_delete.php?id={$C.news_category_id}" onclick="return DoubleConfirm('WARNING!\n All entries in this category will also be deleted!\n Are you sure you want to delete?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		{/foreach}
	</table>
	<a href="news_category_add.php?language_id={$smarty.request.language_id}" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add Category</a>
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
