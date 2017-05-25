	<div class="main">
		<main>

			<div class="keyvisualBlock">

				<div class="keyvisual_inner" {*style="background: url({$REMOTE_BASEURL}/getfile.php?id={$KeyVisual->block_image_id}) no-repeat center 0;"*}>
					
					{$ProductCategory->product_category->product_category_custom_text_6}
					{*
					<p class="keyvisual_logo mb45">
						{if $KeyVisualLogo->block_image_id|intval > 0}	
							<img src="{$REMOTE_BASEURL}/getfile.php?id={$KeyVisualLogo->block_image_id}" alt="{$ProductCategory->product_category->product_category_name}">
						{/if}
					</p>
					<h2 class="keyvisual_copy mt30">{$KeyVisual->object_name}</h2>
					<div class="keyvisual_text">
						{$KeyVisual->block_content|nl2br}
						{if $KeyVisual->block_link_url != ""}
							<p class="font-sizeSS"><span class="font-sizeSSS">＊</span>{$KeyVisual->block_link_url}</p>
						{/if}
					</div>
					*}
					
				</div>

			</div>

			<section>
				<div class="headingLv1Block noBorder">
					<h2 class="headingLv1">Recommended Products For {$ProductCategory->product_category->product_category_name}</h2>
				</div>
				<div class="container">
					<div class="recommend_tab">
						<ul class="js-tabWrap tab clearfix">
							
							{if count($ProductCategory->product_category->product_categories->product_category) > 1}
								{foreach $ProductCategory->product_category->product_categories->product_category as $PC}
									<li class="js-tabTrigger recommend_tab_item rollover_01 {if $PC@index == 0}active{/if}">
										<a href="#tab_lineup_0{$PC@index}">{trim($PC->product_category_name)}</a>
									</li>
								{/foreach}
							{/if}

						</ul>
					</div>
							
					{foreach $ProductCategory->product_category->product_categories->product_category as $PC}
							
						<div id="tab_lineup_0{$PC@index}" class="js-tabTarget accordion {if $PC@index == 0}active{/if}">
							
							{if $PC->product_category_custom_text_2 != ""}
								{*<p class="mb65">{$PC->product_category_custom_text_2}</p>*}
							{/if}

							{if $PC->product_category_custom_int_3|intval == 1}
								
								
								{assign var=CheckingProductCodeList value=array()}
								
								{foreach $BrandList[$PC->object_id|intval]['display_by_pair'] as  $k=>$v}
								
									{if !$k|in_array:$CheckingProductCodeList && !$v|in_array:$CheckingProductCodeList}
										
										<div class="columnWrap lineupTopWrap column5">
											<ul class="clearfix">
										
												{foreach $PC->products->product as $P}

													{if $P->product_code|strval == $k || $P->product_code|strval == $v}

														<li class="column">
															<div class="lineup_inner js-itemBox">
																<div class="lineup_image">
																	<a href="{$BASEURL}{$P->object_seo_url}">
																		{if $P->product_custom_int_2|intval == 1}
																			<span class="icon_new_01">NEW</span>
																		{/if}
																		{if $P->object_thumbnail_file_id|intval > 0}
																			<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" height="218" alt="">
																		{/if}
																	</a>
																</div>
																<p class="lineup_number">{$P->product_code}</p>
																<p class="lineup_price"><!-- {$MyCurrency}{$P->product_price|currencyformat} --></p>
																<p class="btn_01 products_moreButton mt10"></p>
															</div>
														</li>
														
														{append var='CheckingProductCodeList' value=$P->product_code|strval}
														
													{/if}

												{/foreach}
										
											</ul>
										</div>

									{/if}
								
								{/foreach}
								
							{else}
							
								{foreach $BrandList[$PC->object_id|intval]['display_by_brand'] as $CatBrandList}

									{foreach $CatBrandList as $index => $P}
										{if $index % 5 == 0}
											<div class="columnWrap lineupTopWrap column5">
												<ul class="clearfix">										
										{/if}
										<li class="column">
											<div class="lineup_inner">
												<a href="{$BASEURL}{$P->object_seo_url}">
													<div class="lineup_image">
														{if $P->product_custom_int_2|intval == 1}
															<span class="icon_new_01">NEW</span>
														{/if}
														{if $P->object_thumbnail_file_id|intval > 0}
															<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" width="150" alt="">
														{/if}
													</div>
													<p class="lineup_number">{$P->product_code}</p>
													<p class="lineup_price"><!-- {$MyCurrency}{$P->product_price|currencyformat} --></p>
													<ul class="lineup_featureList clearfix">
														{assign var=FeatureList value=explode(',', $P->product_custom_text_9|strval)}
														{foreach $FeatureList as $F}
															<li class="lineup_featureList_item"><span>{$F}</span></li>
														{/foreach}
													</ul>
												</a>
											</div>
										</li>
										{if $index % 5 == 4 || $P@last}
												</ul>
											</div>										
										{/if}									
									{/foreach}

								{/foreach}
								
							{/if}

							{if $PC->product_category_custom_text_3 != ""}
								<p class="btn_01 lineup_moreButton">
									<a href="{$PC->product_category_custom_text_4}">
										{$PC->product_category_custom_text_3}
									</a>
								</p>
							{/if}

						</div>
								  
					{/foreach}

				</div>
			</section>

			{*Slider Show*}
			{*
			<section>
			  <div class="tech">
				<div class="headingLv1Block noBorderBottom">
				  <h2 class="headingLv1">{$SliderShowTitle->block_content}</h2>
				</div>
				<div class="container">

					<section>
						<div class="js-slider tech_slider">
							
							{foreach $SliderShowImage as $S1}
								<div class="tech_slider_item clearfix">
									<div class="tech_slider_text">
										<h3 class="tech_slider_heading">{$S1->object_name}</h3>
										<p class="tech_slider_detail">
											{$S1->block_content|nl2br}
										</p>
										<p class="link_01 mb25"><a href="{$S1->block_link_url}">Click here for details</a></p>
									</div>
									<div class="tech_slider_image">
										<div><img src="{$REMOTE_BASEURL}/getfile.php?id={$S1->block_image_id}" width="552" height="520" alt="{$S1->object_name}"></div>
									</div>
								</div>
							{/foreach}
						</div>

						<ul class="js-pager tech_slider_pager clearfix">
							{foreach $SliderShowImage as $S2}
								<li class="tech_slider_pager_item rollover_01"><a data-slide-index="{$S2@index}" href="">{$S2->object_name}</a></li>
							{/foreach}
						</ul>

					</section>

				</div>
			  </div>
			</section>
			*}

			{*Support*}
			{*
			<section>
				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">サポート</h2>
				</div>
				<div class="container">
					<div class="supportWrap clearfix">
						<div class="column">
							<p class="support_label">よくあるご質問</p>
							<p class="support_text">お客さまから寄せられたお問い合わせの中から、<br>よくあるご質問を掲載しています。</p>
							<p class="btn_01 support_moreButton faq"><a href="http://faq-citizen.dga.jp/">よくあるご質問</a></p>
						</div>
						<div class="column">
							<p class="support_label">お問い合わせ</p>
							<p class="support_text">修理のご相談やご不明点など、フォームからお問い合わせください。</p>
							<p class="btn_01 support_moreButton contact"><a href="/support/contact/index.html">お問い合わせ</a></p>
						</div>
					</div>
				</div>
			</section>
			*}

			{*Pick Up*}
			{if count($PickupRow1) > 0 || count($PickupRow2) > 0}

				<section>
					<div class="headingLv1Block noBorderBottom">
						<h2 class="headingLv1">Relevant Video</h2>
					</div>
					<div class="container">

						{foreach $PickupRow1 as $R1}

							{if $R1@index % 2 == 0}
								<div class="columnWrap specialWrap last column2 clearfix">
							{/if}

								<div class="column">
									<a href="{$R1->block_link_url}" class="js-openModal">
										<div class="special_image">
											<img src="{$REMOTE_BASEURL}/getfile.php?id={$R1->block_image_id}" width="480" height="272" alt="">
										</div>
										<p class="link_01">
											<a href="{$R1->block_link_url}" class="js-openModal">{$R1->object_name}</a>
										</p>
									</a>
								</div>

							{if $R1@index % 2 == 1 || $R1@last}
								</div>
							{/if}

						{/foreach}

						{*
						<div class="columnWrap specialWrap last column2 clearfix">

							{foreach $PickupRow1 as $R1}
								<div class="column">
									<a href="{$R1->block_link_url}" class="js-openModal">
										<div class="special_image">
											<img src="{$REMOTE_BASEURL}/getfile.php?id={$R1->block_image_id}" width="480" height="272" alt="">
										</div>
										<p class="link_01">
											<a href="{$R1->block_link_url}" class="js-openModal">{$R1->object_name}</a>
										</p>
									</a>
								</div>
							{/foreach}

						</div>
						*}

						{foreach $PickupRow2 as $R2}

							<div class="special_image mb30">
							  <a href="{$R2->block_link_url}" target="_blank" class="rollover_01">
								  <img src="{$REMOTE_BASEURL}/getfile.php?id={$R2->block_image_id}" width="1000" height="320" alt="{$R2->object_name}" class="mb10">
							  </a>
							  <p class="link_01">
								  <a href="{$R2->block_link_url}" target="_blank">{$R2->object_name}
									  <img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
								  </a>
							  </p>
							</div>

						{/foreach}

					</div>
				</section>

			{/if}

		</main>
	</div>