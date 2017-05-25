{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}

<p>
	{$Counter} links have been generated. <br />
	Sitemap XML file is stored at <a href="{$SitemapURL}" target="_blank">{$SitemapURL}</a>. <br />
	<br />
	{$RssCounter} rss links have been generated. <br />
	RSS file is stored at <a href="{$RssURL}" target="_blank">{$RssURL}</a>. <br />
</p>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
