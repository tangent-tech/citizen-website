{include file="`$CurrentLang->language_root->language_id`/header.tpl"}
{include file="`$CurrentLang->language_root->language_id`/header_long.tpl"}
	<div class="MainContent">
		<div class="LeftCol">
			<div>
				{$LeftBlock->block_content}
			</div>
		</div>
		<div class="RightCol">
        	<div>
				{$RightBlock->block_content}
			</div>
		</div>
		<br class="clearfloat" />
	</div>
	<br class="clearfloat" />
{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}