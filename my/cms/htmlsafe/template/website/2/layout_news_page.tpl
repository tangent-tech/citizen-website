{include file="`$CurrentLang->language_root->language_id`/header.tpl"}
{include file="`$CurrentLang->language_root->language_id`/header_short.tpl"}
	<div class="InnerContent">
		<div class="InnerContentHeader">
			<h1>{$LayoutNewsList->object_name}</h1>
		</div>
		<div class="InnerContentBody">
			<div>
				{if $TotalPageNo > 1}
					<form name="FrmSetPageID" id="FrmSetPageID" method="post">
						頁數:
						<select id="page_id" name="page_id" onchange="submit()">
							{foreach from=$PageNoSelection item=P}
							    <option value="{$P}"
									{if $P == $smarty.request.page_id}selected="selected"{/if}
							    >{$P}</option>
							{/foreach}
						</select>
					</form>
				{/if}
				<div id="NewsList">
					<ul>
						{foreach from=$LayoutNewsList->layout_news_list->children() item=N}
							<li><a href="{$N->object_seo_url}"/>{$N->layout_news_title} ({$N->layout_news_date|date_format:"%Y/%m/%d"})</a></li>
						{/foreach}
					</ul>
				</div>
			</div>
		</div>
		<div class="InnerContentBottom"></div>
		<br class="clearfloat" />
	</div>
	<br class="clearfloat" />
{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}