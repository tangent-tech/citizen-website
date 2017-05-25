	<item>
		{foreach from=$tags item=T}
			<category><![CDATA[{$T}]]></category>
		{/foreach}
		<pubDate>{$pubDate}</pubDate>
		<lastBuildDate>{$lastBuildDate}</lastBuildDate>
		<guid isPermaLink="true">{$link}</guid>
		<title>{$title}</title>
		<link>{$link}</link>
		<description>{$description|myxml}</description>
		<content:encoded><![CDATA[{$content}]]></content:encoded>
	</item>
