<div class="main">
	<main>
		
		<h1 class="align-center">
			{$ProductCategory->product_category->product_category_custom_text_8}
		</h1>
		
		<section>
			<div class="headingLv1Block noBorderTop">
				<h2 class="headingLv1">
					{$ProductCategory->product_category->product_category_name}的推介型號
				</h2>
			</div>
			<div class="container">
				<div class="recommend_tab">
					
					<ul class="js-tabWrap tab clearfix">
					  
						{if count($ProductCategory->product_category->product_categories->product_category) > 1}
							{foreach $ProductCategory->product_category->product_categories->product_category as $PC}
								<li class="js-tabTrigger recommend_tab_item {if $PC@index == 0}active{/if}">
									<a href="#tab_lineup_0{$PC@index}">{trim($PC->product_category_name)}</a>
								</li>
							{/foreach}
						{/if}

					</ul>

					{foreach $ProductCategory->product_category->product_categories->product_category as $PC}
					
						<div id="tab_lineup_0{$PC@index}" class="js-tabTarget accordion {if $PC@index == 0}active{/if}">
							
							{if $PC->product_category_custom_int_3|intval == 1}
								

								{assign var=CheckingProductCodeList value=array()}
								
								{foreach $BrandList[$PC->object_id|intval]['display_by_pair'] as  $k=>$v}
								
									{if !$k|in_array:$CheckingProductCodeList && !$v|in_array:$CheckingProductCodeList}
										
										<div class="columnWrap column2 clearfix mt30">
										
											{foreach $PC->products->product as $P}

												{if $P->product_code|strval == $k || $P->product_code|strval == $v}

													<div class="column">
														<a href="{$BASEURL}{$P->object_seo_url}">
															<div class="linup_inner">
																<div class="lineup_image">
																	{if $P->product_custom_int_2|intval == 1}
																		<span class="icon_new_01">NEW</span>
																	{/if}
																	{if $P->object_thumbnail_file_id|intval > 0}
																		<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" width="88" alt="">
																	{/if}
																	{*<img src="/s/product/product-images/img_lineup_01.jpg" width="88" height="130" alt="">*}
																</div>
																<p class="lineup_number">{$P->product_code}</p>
																<p class="lineup_price">{$MyCurrency}{$P->product_price|currencyformat}</p>
															</div>
														</a>
													</div>

													{append var='CheckingProductCodeList' value=$P->product_code|strval}

												{/if}

											{/foreach}
										
										</div>

									{/if}
								
								{/foreach}
								
							{else}
								
								{foreach $PC->products->product as $P}
								
									{if $P@index % 2 == 0}
										<div class="columnWrap column2 clearfix mt30">
									{/if}

									<div class="column">
										<a href="{$BASEURL}{$P->object_seo_url}">
											<div class="linup_inner">
												<div class="lineup_image ProductCategoryProduct">
													{if $P->product_custom_int_2|intval == 1}
														<span class="icon_new_01">NEW</span>
													{/if}
													{if $P->object_thumbnail_file_id|intval > 0}
														<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" width="88" alt="">
													{/if}
													{*<img src="/s/product/product-images/img_lineup_01.jpg" width="88" height="130" alt="">*}
												</div>
												<p class="lineup_number">{$P->product_code}</p>
												<p class="lineup_price">{$MyCurrency}{$P->product_price|currencyformat}</p>
											</div>
										</a>
									</div>

									{if $P@index % 2 == 1 || $P@last}
										</div>
									{/if}
									
								{/foreach}
								
							{/if}

						</div>
					  
					{/foreach}

				</div>
			</div>
		</section>
		
		{*Pick Up*}
		{if count($PickupRow1) > 0 || count($PickupRow2) > 0}
		
			<section class="js-readMore">
				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">相關影片</h2>
				</div>
				<div class="container">
					<div class="specialColumnWrap">
						<ul>

							{foreach $PickupRow1 as $R1}
								<li class="js-readMoreItem specialColumn_image">
									<a href="{$R1->block_link_url}" class="js-openModal">
										<div class="js-openModal specialColumn_imageCaver"></div>
										{*<iframe width="100%" height="200" src="https://www.youtube.com/embed/S-DqSrewebI" frameborder="0" allowfullscreen></iframe>*}
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$R1->block_image_id}" width="100%" alt=""/>
									</a>
								</li>
							{/foreach}

							{foreach $PickupRow2 as $R2}
								<li class="js-readMoreItem">
									<a href="{$R2->block_link_url}" target="_blank">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$R2->block_image_id}" width="100%" alt="{$R2->object_name}"/>
									</a>
								</li>
							{/foreach}

						</ul>
					</div>
				</div>

				{if ( count($PickupRow1) + count($PickupRow2) ) > 3}
					<div class="btn_01 readMore_btn mt30"><a href="javascript:;" class="js-readMoreBtn"><span>查看</span></a></div>
				{/if}
				
			</section>
						
		{/if}

	</main>
</div>