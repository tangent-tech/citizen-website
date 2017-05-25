{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">
			<main>

				<div class="headingLv1Block noBorder">
					<h1 class="headingLv1">{$Content->object_name}</h1>
				</div>

				<div class="container">

					<section>

						<div>{$Content->block_content}</div>

					</section>

				</div>

			</main>
		</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}