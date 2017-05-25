{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">
			<main>

				<div class="headingLv1Block noBorder">
					<h1 class="headingLv1">Notice</h1>
				</div>

				<div class="container">
					
					<div class="ContentWrap">
						{$Msg|nl2br}<br/>
						<br/>
						<br/>
						Click <a href="{$URL}">here</a> to redirect.
					</div>
					
				</div>

			</main>
		</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}