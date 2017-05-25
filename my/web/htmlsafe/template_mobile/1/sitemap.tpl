{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$Page->page->object_name}</h1>
			</div>
			<div class="container">

				<section>
					<div class="headingLv2Block">
						<h2 class="headingLv2">
							<span class="link_01">
								<a href="{$BASEURL}/index.php">HOME</a>
							</span>
						</h2>
					</div>
				</section>
				
				{foreach $TopMenu->object->objects->object as $C}

					<div>
						<section>

							{if $C->object_type == "PAGE" && $C->object_details->page->layout->layout_name == "PopupLink"}

								{assign var=LinkURL value=$C->object_details->page->layout->block_defs->block_def[0]->block_contents->block[0]->block_content|strval}

								<div class="headingLv2Block">
									<h2 class="headingLv2">
										<span class="link_01">
											<a href="{$LinkURL}" target="_blank">{$C->object_name}</a>
										</span>
									</h2>
								</div>

							{else}

								<div class="headingLv2Block">
									<h2 class="headingLv2">
										<span class="link_01">
											<a href="{$BASEURL}{$C->object_seo_url}">{$C->object_name}</a>
										</span>
									</h2>
								</div>

							{/if}

							{if $C->object_type == "PRODUCT_ROOT_LINK"}
								<div class="ml20">
									{foreach $C->objects->object as $productCat}
										<p class="link_01 mb05 SitemapProductCategory">
											<a href="{$BASEURL}{$productCat->object_seo_url}">{$productCat->object_name}</a>
										</p>
									{/foreach}
								</div>
							{/if}

							<div class="ml20">
								{*
								<p class="link_01 mb05"><a href="/news/importance/index.html">重要なお知らせ</a></p>
								<p class="link_01 mb05"><a href="/news/2016/index.html">2016年</a></p>
								<p class="link_01 mb05"><a href="/news/2015/index.html">2015年</a></p>
								<p class="link_01 mb05"><a href="/news/2014/index.html">2014年</a></p>
								<p class="link_01 mb05"><a href="/news/2013/index.html">2013年</a></p>
								<p class="link_01 mb05"><a href="/news/2012/index.html">2012年</a></p>
								<p class="link_01 mb05"><a href="/news/2011/index.html">2011年</a></p>
								<p class="link_01 mb05"><a href="/news/2010/index.html">2010年</a></p>
								*}
							</div>

						</section>
					</div>

				{/foreach}

			</div>
		</main>
	</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}