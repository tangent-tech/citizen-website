{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">

		<main>
			<div class="headingLv1Block noBorder">
				<h1 class="headingLv1">Watch Lineup</h1>
			</div>
			<div class="container">

				{foreach $ProductCategory->product_category->product_categories->product_category as $C}
					
					{assign var=LineupCategory value=explode(',', $C->product_category_custom_text_1|strval)}
			  
					<div class="product_borderBox mb70">
						<a href="{$BASEURL}{$C->object_seo_url}">
							<div class="product_image productCatThumbnail">
								{*<img src="/s/product/images/img_product_01.jpg" alt="Eco-Drive SATELLITE WAVE F900">*}
								{$C->product_category_custom_text_5}
							</div>
							<div class="text-box">
								<ul class="product_featureList">
									{foreach $LineupCategory as $LC}
										<li class="lineup_category">{$LC}</li>
									{/foreach}
								</ul>
								<p class="product_detail">
									{$C->product_category_custom_text_2|nl2br}
								</p>
							</div>
						</a>
					</div>
					
				{/foreach}

			</div>

			<section>

				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">Related Brand</h2>
				</div>

				<div class="container">
					<ul class="relatedList clearfix">

						{foreach $RelatedBrand as $R}
							<li class="relatedList_item">
								<a href="{$R->block_link_url}" target="_blank">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$R->block_image_id}" width="{$R->block_content}" alt="{$R->object_name}">
								</a>
							</li>
						{/foreach}

					</ul>
				</div>

			</section>

		{*
			<section>
				<div class="catalog">
					<div class="headingLv1Block noBorder">
						<h2 class="headingLv1">カタログ</h2>
					</div>
					<div class="container">
						<div class="columnWrap column2 columnBlock_01 clearfix">
							<div class="column align-center">
								<img src="/s/product/images/img_product_12.jpg" alt="">
							</div>
							<div class="column">
								<h3 class="headingLv2">総合カタログ（2015年）</h3>
								<p class="catalog_DlButton"><a href="/product/images/catalog/2015awcollection.pdf" target="_blank">カタログダウンロード</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		*}

		</main>

	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}