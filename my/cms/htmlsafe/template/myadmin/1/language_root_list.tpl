{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
	{if !in_array("acl_module_sitemap_show", $EffectiveACL)}
		<p>Sorry, there is not sitemap defined.</p>
	{else}
		{if $LanguageRootList|@count == 0}
			<p>No langauge is in use now.</p>
		{else}
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$LanguageRootList item=L}
					<tr>
						<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
						<td>
							<a href="language_tree.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-gear"></span> Manage
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			
			<br />
			
			{if $Site['site_friendly_link_enable'] == 'Y' && $Site['site_friendly_link_version'] == 'structured'}
				{if $Site['site_structure_seo_link_update_status'] == 'job_done'}
					<a href="site_update_structure_seo_link.php" class="ui-state-default ui-corner-all MyButton" onclick="confirm('Are you sure?')">
						<span class="ui-icon ui-icon-gear"></span> Update SEO Links
					</a>					
				{else}
					<p>Updating SEO Links... Please wait...</p>
				{/if}
			{/if}			
		{/if}
	{/if}

{*
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Languages Not In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$LanguageWithNoRootList item=L}
					<tr>
						<td class="AlignCenter" width="100">{$L.language_native|escape:'html'}</td>
						<td>
							<a href="language_root_add.php?id={$L.language_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> Add
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br class="clearfloat" />
		</div>
	</div>
	<br />
	<a href="sitemap_static_xml.php" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-gear"></span> Generate Sitemap XML
	</a>
*}
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
