{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<form name="FrmSetPageID" id="FrmSetPageID" method="post">
	Site:
	<select id="log_site_id" name="log_site_id" onchange="submit()">
		<option value="0">All</option>
		{section name=index loop=$SystemAdminSiteList}
			<option value="{$SystemAdminSiteList[index].site_id}"
				{if $SystemAdminSiteList[index].site_id == $smarty.request.log_site_id}selected="selected"{/if}
			>{$SystemAdminSiteList[index].site_name|escape:'html'}</option>
		{/section}
	</select>
	&nbsp; &nbsp; &nbsp;
	Page:
	<select id="page_id" name="page_id" onchange="submit()">
		{foreach from=$PageNoSelection item=P}
			<option value="{$P}"
				{if $P == $smarty.request.page_id}selected="selected"{/if}
			>{$P}</option>
		{/foreach}
	</select>
	&nbsp; &nbsp; &nbsp;
	Log Per Page:
	<select id="num_of_products_per_page" name="num_of_log_per_page" onchange="submit()">
		<option value="10" {if $smarty.cookies.num_of_log_per_page == 10}selected="selected"{/if}>10</option>
		<option value="20" {if $smarty.cookies.num_of_log_per_page == 20}selected="selected"{/if}>20</option>
		<option value="30" {if $smarty.cookies.num_of_log_per_page == 30}selected="selected"{/if}>30</option>
		<option value="40" {if $smarty.cookies.num_of_log_per_page == 40}selected="selected"{/if}>40</option>
		<option value="50" {if $smarty.cookies.num_of_log_per_page == 50}selected="selected"{/if}>50</option>
		<option value="9999" {if $smarty.cookies.num_of_log_per_page == 9999}selected="selected"{/if}>All</option>
	</select>
	&nbsp; &nbsp; &nbsp;
	Status:
	<select id="is_not_ok_only" name="status" onchange="submit()">
		<option value="hard_fail" {if $smarty.request.status == 'hard_fail'}selected="selected"{/if}>Hard Fail Only</option>
		<option value="not_ok_only" {if $smarty.request.status == 'not_ok_only'}selected="selected"{/if}>Not OK Only</option>		
		<option value="all" {if $smarty.request.status == 'all'}selected="selected"{/if}>All</option>		
	</select>
	&nbsp; &nbsp; &nbsp;
	Exclude Empty Cache:
	<select id="exclude_empty_cache" name="exclude_empty_cache" onchange="submit()">
		<option value="Y" {if $smarty.request.exclude_empty_cache == 'Y'}selected="selected"{/if}>Y</option>
		<option value="N" {if $smarty.request.exclude_empty_cache == 'N'}selected="selected"{/if}>N</option>		
	</select>
</form>
	
<table class="TopHeaderTable">
	<tr>
		<th>site</th>
		<th>id</th>
		<th>datetime</th>
		<th>hard fail</th>
		<th>id_1</th>
		<th>id_2</th>
		<th>id_3</th>
		<th>string_1</th>
		<th>string_2</th>
		<th>string_3</th>
		<th>result</th>		
	</tr>
	{foreach $CallbackLog as $L}
		<tr>
			<td>{$L.site_name}</td>			
			<td>{$L.callback_log_id}</td>			
			<td>{$L.callback_datetime}</td>
			<td>{$L.callback_hard_fail}</td>
			<td>{$L.id_1|escape}</td>			
			<td>{$L.id_2|escape}</td>			
			<td>{$L.id_3|escape}</td>
			<td>{$L.string_1|escape}</td>			
			<td>{$L.string_2|escape}</td>			
			<td>{$L.string_3|escape}</td>			
			<td>{$L.callback_result|escape:'html'}</td>
		</tr>
	{/foreach}
</table>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}