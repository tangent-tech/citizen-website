{include file="`$CurrentLang->language_root->language_id`/header.tpl"}
{include file="`$CurrentLang->language_root->language_id`/header_short.tpl"}
	<div class="InnerContent">
		<div class="InnerContentHeader">
			<h1>{$Page->page->page_title}</h1>
		</div>
		<div class="InnerContentBody">
			<div>
				{$BlockContent->block_content}
			</div>
		</div>
		<div class="InnerContentBottom"></div>
		<br class="clearfloat" />
	</div>
	<br class="clearfloat" />
{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}