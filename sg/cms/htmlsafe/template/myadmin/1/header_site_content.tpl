	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			{if $Site.site_module_article_enable == 'Y' && in_array('acl_module_sitemap_show', $EffectiveACL) }
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'language_root'}ui-tabs-selected ui-state-active{/if}"><a href="language_root_list.php">Sitemap</a></li>
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'siteblock'}ui-tabs-selected ui-state-active{/if}"><a href="siteblock.php">Site Block</a></li>
			{/if}
			{if $Site.site_module_album_enable == 'Y' && in_array('acl_module_album_show', $EffectiveACL)}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'album'}ui-tabs-selected ui-state-active{/if}"><a href="album_list.php">Album</a></li>
			{/if}
			{if $Site.site_module_news_enable == 'Y' && in_array('acl_module_news_show', $EffectiveACL)}
{*				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'news'}ui-tabs-selected ui-state-active{/if}"><a href="news.php">{$Site.site_label_news|ucwords}</a></li> *}
				{foreach from=$AllNewsRoots item=R}
					<li class="ui-state-default ui-corner-top 
						{if $CurrentNewsRootID == $R.news_root_id || $CurrentTab2 == 'news'}ui-tabs-selected ui-state-active{/if}
						{if $CurrentTab2 == 'news_category' && $R.language_id == $smarty.request.language_id}ui-tabs-selected ui-state-active{/if}
						"
					>
						<a href="news_list.php?id={$R.news_root_id}">{$R.news_root_name}</a>
					</li>
				{/foreach}
			{/if}
			{if $Site.site_module_layout_news_enable == 'Y' && in_array('acl_module_layout_news_show', $EffectiveACL)}
{*				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'layout_news'}ui-tabs-selected ui-state-active{/if}"><a href="layout_news.php">{$Site.site_label_layout_news|ucwords}</a></li> *}
				{foreach from=$AllLayoutNewsRoots item=R}
					<li class="ui-state-default ui-corner-top 
						{if $CurrentLayoutNewsRootID == $R.layout_news_root_id || $CurrentTab2 == 'news'}ui-tabs-selected ui-state-active{/if}
						{if $CurrentTab2 == 'layout_news_category' && $R.language_id == $smarty.request.language_id}ui-tabs-selected ui-state-active{/if}
						"
					>
						<a href="layout_news_list.php?id={$R.layout_news_root_id}">{$R.layout_news_root_name}</a>
					</li>
				{/foreach}
			{/if}
			{if $Site.site_module_product_enable == 'Y' && in_array('acl_module_product_show', $EffectiveACL)}
				<li class="ui-state-default ui-corner-top {if $CurrentTab2 == 'product'}ui-tabs-selected ui-state-active{/if}"><a href="product_tree.php">{$Site.site_label_product|ucwords}</a></li>
			{/if}
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
