{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorder">
			  <h1 class="headingLv1">Watch Lineup</h1>
			</div>

			<div class="container">

				{foreach $ProductCategory->product_category->product_categories->product_category as $C}

					{if $C@index % 3 == 0}
						<div class="columnWrap productWrap column3">
							<ul class="clearfix">
					{/if}

						{assign var=LineupCategory value=explode(',', $C->product_category_custom_text_1|strval)}

						<li class="column product_column">
							<div class="column_inner product_column_inner">
								<a href="{$BASEURL}{$C->object_seo_url}">
									<div class="product_image productCatThumbnail">
										{*width="290" height="206"*}
										{$C->product_category_custom_text_5}
									</div>
									<p class="product_name">{$C->product_category_name}</p>
									<ul class="product_featureList">
										{foreach $LineupCategory as $LC}
											<li class="lineup_category">{$LC}</li>
										{/foreach}
									</ul>
									<p class="product_detail">{$C->product_category_custom_text_2|nl2br}</p>
									<p class="product_btnDetail">View More</p>
								</a>
							</div>
						</li>

					{if $C@index % 3 == 2 || $C@last}
							</ul>
						</div>
					{/if}

				{/foreach}

			</div>

			{*Related Brand*}
			<section>
				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">Related Brand</h2>
				</div>
				<div class="container">
					<ul class="relatedList ProductRootrelatedList clearfix">

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
					
			<br/>
			<br/>
			<br/>
			<br/>
			{*
			<section>
				<div class="catalog">
					<div class="headingLv1Block noBorder">
						<h2 class="headingLv1">Catalog</h2>
					</div>
					<div class="container">
						<section>
							<h3 class="headingLv2">{$CatalogImage->object_name}</h3>
							<div class="align-center mb50"><img src="{$REMOTE_BASEURL}/getfile.php?id={$CatalogImage->block_image_id}" width="581" height="240" alt=""></div>
							<p class="catalog_DlButton"><a href="{$BASEURL}{$CatalogPdfLink->block_content}" target="_blank">カタログダウンロード</a></p>
							<div class="getAdobeReader">
								<div class="getAdobeReader_inner clearfix">
									<p class="getAdobeReader_adobe"><a href=""><img src="{$BASEURL}/images/common/icon_getadobereader_01.jpg" width="112" height="33" alt="Get ADOBE&reg; READER&reg;"></a></p>
									<p class="getAdobeReader_text">取扱説明書はPDFファイル形式になっておりますのでご利用になる場合はAdobeReaderが必要です。</p>
								</div>
							</div>
						</section>
					</div>
				</div>
			</section>
			*}

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}