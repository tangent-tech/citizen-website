{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Edit Datafile &nbsp;
	{if $smarty.request.refer == 'product_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="product_edit.php?link_id={$smarty.request.link_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Product
		</a>
	{elseif $smarty.request.refer == 'bonuspoint_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="bonuspoint_edit.php?id={$smarty.request.parent_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Bonus Point Item
		</a>
	{elseif $smarty.request.refer == 'member_edit'}
		<a class="ui-state-default ui-corner-all MyButton" href="member_edit.php?id={$smarty.request.user_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Member
		</a>
	{else}
		<a class="ui-state-default ui-corner-all MyButton" href="datafile_list.php?id={$Datafile.parent_object_id}">
			<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Datafile List
		</a>
	{/if}
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="datafile_edit_act.php">
		<div id="DatafileTabs">
			<ul>
				<li><a href="#DatafileTabsPanel-CommonData">Common Data</a></li>
				{if $ObjectFieldsShow.object_seo_tab == 'Y'}<li><a href="#DatafileTabsPanel-SEO">SEO</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#DatafileTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="DatafileTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th>Datafile</th>
							<td>
								<a href="{$smarty.const.BASEURL}/getfile.php?id={$Datafile.datafile_file_id}">{$Datafile.filename}</a> <br />
								Filesize: {$Datafile.size/1024|string_format:"%.2f"}kb <br />
								<input type="file" name="datafile_file" />
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_int_`$smarty.section.foo.iteration`"}
							{if $DatafileCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$DatafileCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Datafile.$myfield|escape:'html'}" size="80" /></td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_double_`$smarty.section.foo.iteration`"}
							{if $DatafileCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$DatafileCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" value="{$Datafile.$myfield|escape:'html'}" size="80" /></td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="datafile_custom_date_`$smarty.section.foo.iteration`"}
							{if $DatafileCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$DatafileCustomFieldsDef.$myfield}</th>
									<td><input type="text" name="{$myfield}" class="DatePicker" value="{$Datafile.$myfield|date_format:'%Y-%m-%d'}" size="10" /> {html_select_time prefix=$myfield use_24_hours=true display_seconds=false time=$Datafile.$myfield}</td>									
								</tr>
							{/if}
						{/section}
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="DatafileTabsPanel-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="DatafileTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>Datafile Description</th>
								<td><input type="text" name="datafile_desc[{$R.language_id}]" value="{$DatafileData[$R.language_id].datafile_desc|escape:'html'}" size="90" maxlength="255" /></td>
							</tr>
							{section name=foo start=0 loop=20 step=1}
								{assign var='myfield' value="datafile_custom_text_`$smarty.section.foo.iteration`"}
								{if $DatafileCustomFieldsDef.$myfield != ''}
									<tr>
										<th>{$DatafileCustomFieldsDef.$myfield}</th>
										<td><input type="text" name="{$myfield}[{$R.language_id}]" value="{$DatafileData[$R.language_id].$myfield|escape:'html'}" size="80" /></td>
									</tr>
								{/if}
							{/section}
						</table>
					</div>
			   </div>
			{/foreach}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input type="hidden" name="link_id" value="{$smarty.request.link_id}" />
			<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}" />
			<input type="hidden" name="refer" value="{$smarty.request.refer}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
