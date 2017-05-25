<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"	
>
	<channel>
		<title>{$Site.site_name|myxml} (RSS 2.0)</title>
		<link>http://{$Site.site_address|myxml}</link>
		<description>{$Site.site_name|myxml} (RSS 2.0)</description>
		<sy:updatePeriod>{$UpdateRate}</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		{$urls}
	</channel>
</rss>