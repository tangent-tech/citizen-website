{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">
			<main>

				<div class="container">
					<div class="clearfix">
						<div class="product_imageLeft">
							<div class="product_image">

								{foreach $ProductMedia as $PM}
									<img width="376" src="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_big_file_id}" data-large="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_big_file_id}" alt="" class="js-enlarge">
								{/foreach}

							</div>
							<p class="product_repletion">Roll over to zoom in</p>
							<ul class="product_imageList clearfix js-thumbs">

								{foreach $ProductMedia as $PM}
									<li class="product_imageList_item {if $PM@index == 0}active{/if}">
										<a href="javascript:;" class="rollover_01">
											<img src="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_small_file_id}" alt="">
										</a>
									</li>								
								{/foreach}

				  <!--
							  <li class="product_imageList_item modal_item">
								<a href="href=https://www.youtube.com/watch?v=uNrM6YOpdjM" class="js-openModal">
								  <p class="modalPlayBtn"><img src="{$BASEURL}/images/common/icon_play_01.png" alt="" width="19" height="22"></p>
								  <div class="js-openModal specialColumn_imageCaver"></div>
								  <img src="{$BASEURL}/images/product/product-images/thumb_movie_01.jpg" alt="">
								</a>
							  </li>
							  <li class="product_imageList_item modal_item">
								<a href="href=https://www.youtube.com/watch?v=QHANiliaAIU" class="js-openModal">
								  <p class="modalPlayBtn"><img src="{$BASEURL}/images/common/icon_play_01.png" alt="" width="19" height="22"></p>
								  <div class="js-openModal specialColumn_imageCaver"></div>
								  <img src="{$BASEURL}/images/product/product-images/thumb_movie_02.jpg" alt="">
								</a>
							  </li>
				  -->
							</ul>
						</div>
						<div class="product_imageRight js-itemBox">
							<h1>
								
								{*
								{if $BrandLogo->media_big_file_id|intval > 0}
									<p class="product_pdBrand">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$BrandLogo->media_big_file_id}" alt="{$ProductCategory->product_category->product_category_name}">
									</p>
								{/if}
								*}
								{if $ProductCategory->product_category->product_category_custom_text_9|isnotemptyeditorstring}
									<div class="product_pdBrand">
										{$ProductCategory->product_category->product_category_custom_text_9}
									</div>
								{/if}

								<p class="product_pdNumber">
									{$Product->product->product_code}<input type="hidden" name="iid" value="{$Product->product->product_code}">
								</p>

							</h1>
							<p class="product_pdPrice"><!-- {$MyCurrency}{$Product->product->product_price|currencyformat} --></p>
							
							{*COMMENT IT ON 20161202 CLIENT BEFORE LAUNCHING*}
							{*Release Date*}
							{*
							{if $Product->product->product_custom_date_1|strval != "" && $Product->product->product_custom_date_1|strval != "0000-00-00 00:00:00"}
								<p class="product_release">
									{$Product->product->product_custom_date_1|date_format:"Y-m"} will be released
								</p>
							{/if}
							*}

							<ul class="product_sns clearfix">
								<li class="product_sns_item js-sns-tw">
									<img src="{$BASEURL}/images/common/icon_sns_twitter_01.png" width="26" height="26" alt="">
									<div class="product_sns_wrap">
										<div class="product_sns_popup">
											<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Share</a>
											
{literal}
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
{/literal}

										</div>
									</div>
								</li>
								<li class="product_sns_item js-sns-fb">
									<img src="{$BASEURL}/images/common/icon_sns_facebook_01.png" width="26" height="26" alt="">
									<div class="product_sns_wrap">
										<div class="product_sns_popup">

										  <div id="fb-root"></div>
{literal}
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{/literal}
										  <div class="fb-like" data-href="{$BASEURL}{$Product->product->object_seo_url}" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>

										</div>
									</div>
								</li>
								<li class="product_sns_item js-sns-ln">
									<img src="{$BASEURL}/images/common/icon_sns_line_01.png" width="26" height="26" alt="">
									<div class="product_sns_wrap">
										<div class="product_sns_popup">
										   <a href="line://msg/"><img src="{$BASEURL}/images/common/sns/linebutton_82x20_en.png" width="82" height="20"></a>
										</div>
									</div>
								</li>
							</ul>

							{if count($BrandFriendList->product_list->product) > 1}
								<div class="product_variation">
								  <p class="product_variation_label">Related Models</p>
								  <ul class="product_variationList clearfix">

									{assign var=CheckProductCode value=array($Product->product->product_code|strval)}
									{foreach $BrandFriendList->product_list->product as $F}

										{if !$F->product_code|strval|in_array:$CheckProductCode}
											<li class="product_variationList_item">
												<a href="{$BASEURL}{$F->object_seo_url}" class="rollover_01">
													{if $F->product_custom_int_2|intval == 1}
														<span class="icon_new_01">NEW</span>
													{/if}
													{if $F->object_thumbnail_file_id|intval > 0}
														<img src="{$REMOTE_BASEURL}/getfile.php?id={$F->object_thumbnail_file_id}" width="55" alt="">
													{/if}
												</a>
											</li>
											{append var="CheckProductCode" value=$F->product_code|strval}
										{/if}

									{/foreach}

								  </ul>
								</div>
							{/if}

							{*
							<div class="movie_area">
							  <div class="modal_item">
								<a href="href=https://www.youtube.com/watch?v=uNrM6YOpdjM" class="js-openModal">
								  <div class="js-openModal specialColumn_imageCaver"></div>
								  <iframe src="https://www.youtube.com/embed/uNrM6YOpdjM" allowfullscreen="" frameborder="0" height="180" width="100%"></iframe>
								</a>
							  </div>
							</div>
							*}
							
							<div class="product_zoomBox"><div class="js-zoom-area"></div></div>

						</div>
					</div>
				</div>

				<section>

					<div class="headingLv1Block noBorder">
					  <h2 class="headingLv1">Specification</h2>
					</div>

					<div class="container">
						<section>
							<h3 class="headingLv2">Features</h3>
							<ul class="featureList clearfix">

								{*Features*}
								{assign var=FraturesTag value=explode(",", $Product->product->product_custom_text_9|strval)}
								{foreach $FraturesTag as $FT}
									<li class="featureList_item"><p>{trim($FT)}</p></li>
								{/foreach}

							</ul>
							<div class="js-accordionWrap active">
								<p class="js-accordionTrigger featureDetailButton"><a href="">Details</a></p>
								<div class="js-accordionTarget">
									<div class="featureDetailWrap clearfix">
										<div class="featureDetail_left">
											<table class="table_basic_02 featureDetail_table">
												
												{if $Product->product->product_custom_text_7|isnotemptyeditorstring}
													<tr>
														<th>Caliber No.</th>
														<td>{$Product->product->product_custom_text_7}</td>
													</tr>
												{/if}
												
												{if $Product->product->product_custom_text_1|isnotemptyeditorstring}
													<tr>
														<th>Movement</th>
														<td>{$Product->product->product_custom_text_1}</td>
													</tr>
												{/if}
												
												{if $Product->product->product_custom_text_2|isnotemptyeditorstring}
													<tr>
														<th>Signal Reception</th>
														<td>{$Product->product->product_custom_text_2}</td>
													</tr>
												{/if}
												
												{if $Product->product->product_custom_text_14|isnotemptyeditorstring}
													<tr>
														<th>Strap</th>
														<td>{$Product->product->product_custom_text_14}</td>
													</tr>
												{/if}
												
												{if $Product->product->product_custom_text_5|isnotemptyeditorstring}
													<tr>
														<th>Water Resistant</th>
														<td>{$Product->product->product_custom_text_5}</td>
													</tr>
												{/if}

												{if $Product->product->product_custom_double_1|doubleval > 0}
													<tr>
														<th>Weight</th>
														<td>{$Product->product->product_custom_double_1}g</td>
													</tr>
												{/if}

												{if $Product->product->product_custom_double_2|doubleval > 0}
													<tr>
														<th>Thickness</th>
														<td>
															{$Product->product->product_custom_double_2}mm
															{if $Product->product->product_custom_text_16|isnotemptyeditorstring}
																<br/>
																{$Product->product->product_custom_text_16}
															{/if}
														</td>
													</tr>
												{/if}

												{if $Product->product->product_custom_text_12|isnotemptyeditorstring}
													<tr>
														<th>Case Size</th>
														<td>
															<p>{$Product->product->product_custom_text_12}mm</p>
															{*
															<p class="link_01">
																<a href="/product/guide/case.html" target="_blank" onclick="return openSubWindow(this.href,'ViewLargeImage',720,850);">
																	About Case Size
																	<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
																</a>
															</p>
															*}
														</td>
													</tr>
												{/if}
													
												{if $Product->product->product_custom_text_3|isnotemptyeditorstring}
													<tr>
														<th>Case</th>
														<td>{$Product->product->product_custom_text_3}</td>
													</tr>
												{/if}

												{if $Product->product->product_custom_text_8|isnotemptyeditorstring}
													<tr>
														<th>Surface Processing</th>
														<td>{$Product->product->product_custom_text_8}</td>
													</tr>
												{/if}
												
												{if $Product->product->product_custom_text_15|isnotemptyeditorstring}
													<tr>
														<th>Glass</th>
														<td>{$Product->product->product_custom_text_15}</td>
													</tr>
												{/if}

											</table>
										</div>
										<div class="featureDetail_right">
											<table class="table_basic_02 featureDetail_table">

												<tr>
													<th>Warranty</th>
													<td>{$smarty.const.MAINTENANCE_COMMON}</td>
												</tr>

												{if $Product->product->product_desc|isnotemptyeditorstring}
													<tr>
														<th>Specification</th>
														<td class="ProductSpec">{$Product->product->product_desc}</td>
													</tr>
												{/if}

											</table>
										</div>
									</div>

								</div>
							</div>

						</section>
					</div>

				</section>

			</main>
		</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}