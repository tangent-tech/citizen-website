{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
	<div id="DialogSelectAlbum">
		<p>Select album to add:</p>
		<select name="SelectAlbum">
			{foreach from=$Albums item=A}
				<option value="{$A.object_id}">{$A.object_name}</option>
			{/foreach}
		</select>
	</div>
	<div id="DialogSelectProductRoot">
		<p>Select product tree to add:</p>
		<select name="SelectProductRoot">
			{foreach from=$ProductRoots item=R}
				<option value="{$R.object_id}">{$R.object_name}</option>
			{/foreach}
		</select>
	</div>
	<div id="DialogSelectNewsRoot">
		<p>Select news tree to add:</p>
		<select name="SelectNewsRoot">
			{foreach from=$NewsRoots item=R}
				<option value="{$R.object_id}">{$R.news_root_name}</option>
			{/foreach}
		</select>
	</div>
	<div id="DialogSelectLayoutNewsRoot">
		<p>Select layout news tree to add:</p>
		<select name="SelectLayoutNewsRoot">
			{foreach from=$LayoutNewsRoots item=R}
				<option value="{$R.object_id}">{$R.layout_news_root_name}</option>
			{/foreach}
		</select>
	</div>
	<div class="InnerContainer ui-widget ui-corner-all">
<!--
		<a class="ui-state-default ui-corner-all MyButton" href="#" id="BtnCloseAllNode">
			<span class="ui-icon ui-icon-minusthick"></span> Close All
		</a>
		<a class="ui-state-default ui-corner-all MyButton" href="#" id="BtnOpenAllNode">
			<span class="ui-icon ui-icon-plusthick"></span> Open All
		</a>
		<br />
		<br />
-->
		<div id="SITE_ROOT">
			<ul>
				<li rel="SITE_ROOT" id="OL_0" data-object_type="SITE_ROOT" data-object_link_id="0" data-object_id="{$Site.site_root_id}" data-object_system_flag="system"><a href="#"><ins>&nbsp;</ins>Site</a>
					<ul>
						<li rel="{if $SiteLanguageRoot.object_link_is_enable == 'Y'}ENABLE_{else}DISABLE_{/if}{$SiteLanguageRoot.object_type}" id="OL_{$SiteLanguageRoot.object_link_id}" data-object_type="LANGUAGE_ROOT" data-object_link_id="{$SiteLanguageRoot.object_link_id}" data-object_id="{$SiteLanguageRoot.object_id}" data-object_system_flag="{$SiteLanguageRoot.object_system_flag}"><a href="#"><ins>&nbsp;</ins>{$SiteLanguageRoot.object_name|escape:'html'}</a>
							{$LanguageRootHTML}
{*
							<ul>
								<li rel="ENABLE_FOLDER" id="OL_9999" data-object_type="FOLDER" data-object_link_id="9999" data-object_id="9999" data-object_system_flag="normal"><a href="#"><ins>&nbsp;</ins>Test Object</a>
							</ul>
*}
						</li>
{*
						<li rel="{$LibraryRoot.object_type}" id="OL_{$LibraryRoot.object_link_id}" data-object_type="LIBRARY_ROOT" data-object_link_id="{$LibraryRoot.object_link_id}" data-object_id="{$LibraryRoot.object_id}" data-object_system_flag="{$LibraryRoot.object_system_flag}"><a href="#"><ins>&nbsp;</ins>{$LibraryRoot.object_name|escape:'html'}</a>
							{$LibraryRootHTML}
							<ul>
								<li rel="ENABLE_FOLDER" id="OL_9998" data-object_type="FOLDER" data-object_link_id="9998" data-object_id="9998" data-object_system_flag="normal"><a href="#"><ins>&nbsp;</ins>Test Object</a>
							</ul>
*}
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<br class="clearfloat" />
	</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
