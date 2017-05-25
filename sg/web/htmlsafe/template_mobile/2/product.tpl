{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">

			<main class="js-productDetail">

				<h1 class="productTitle">
						
					{if $ProductCategory->product_category->product_category_custom_text_9|isnotemptyeditorstring}
						<div class="product_pdBrand">
							{$ProductCategory->product_category->product_category_custom_text_9}
						</div>
					{/if}
						
					<p class="product_pdNumber">
						{$Product->product->product_code}<input type="hidden" name="iid" value="{$Product->product->product_code}">
					</p>

				</h1>

				<div class="container">
					<!-- productImageBox -->
					<div class="productImageBox">

						<p class="productPrice">{$MyCurrency}{$Product->product->product_price|currencyformat}</p>
				  
						{*COMMENT IT ON 20161202 CLIENT BEFORE LAUNCHING*}
						{*Release Date*}
						{*
						{if $Product->product->product_custom_date_1|strval != "" && $Product->product->product_custom_date_1|strval != "0000-00-00 00:00:00"}
							<p class="product_release">
								{$Product->product->product_custom_date_1|date_format:"Y-m"} will be released
							</p>
						{/if}
						*}
				  
						<ul id="js-productSlider" class="productSlider clearfix">
							
							{foreach $ProductMedia as $PM}
								<li class="productSlider_item">
									<a href="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_big_file_id}" target="_blank">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_small_file_id}" width="165" height="241" alt="">
									</a>
								</li>
							{/foreach}

						</ul>
						
						<div class="productImageBox_inner">
							<ul class="product_imageList clearfix js-thumbs">
								{foreach $ProductMedia as $PM}
									<li class="product_imageList_item {if $PM@index == 0}active{/if}">
										<a href="javascript:;" class="productSlider_anc">
											<img src="{$REMOTE_BASEURL}/getfile.php?id={$PM->media_small_file_id}" width="40" height="60" alt="">
										</a>
									</li>
								{/foreach}
							</ul>
						</div>

						{*
						<div class="movie_area">
							<div class="modal_item">
							  <a href="https://www.youtube.com/watch?v=uNrM6YOpdjM?autoplay=1" class="js-openModal">
								<div class="js-openModal specialColumn_imageCaver"></div>
								<iframe src="https://www.youtube.com/embed/uNrM6YOpdjM" allowfullscreen="" frameborder="0" height="200" width="100%"></iframe>
							  </a>
							</div>
						</div>
						*}
							
						<div class="productImageBox_inner">

							{if count($BrandFriendList->product_list->product) > 1}
								<div class="product_variation">
									<p class="product_variation_label">相關腕錶</p>
									<ul class="product_variationList">
										
										{assign var=CheckProductCode value=array($Product->product->product_code|strval)}
										{foreach $BrandFriendList->product_list->product as $F}

											{if !$F->product_code|strval|in_array:$CheckProductCode}
												<li class="product_variationList_item">
													<a href="{$BASEURL}{$F->object_seo_url}">
														{if $F->product_custom_int_2|intval == 1}
															<span class="icon_new_01">NEW</span>
														{/if}
														{if $F->object_thumbnail_file_id|intval > 0}
															<img src="{$REMOTE_BASEURL}/getfile.php?id={$F->object_thumbnail_file_id}" width="47" height="59" alt=""/>
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
							<div class="product_btns">
							  <ul class="product_btnList">
								<li class="product_btnItem">
								  <div class="product_balloon">
									<div class="limitText">
									  <p>一度に比較できるのは10点までです。</p>
									</div>
									<div class="numberText">
									  <p>比較表に追加しました。<br>あと<span class="js-remain">0</span>点追加できます。</p>
									  <p class="link_01 product_balloon_btnClear"><a href="javascript:;" class="js-removeCompare">比較表から削除する</a></p>
									</div>
								  </div>
								  <p class="product_btnAdd">
									<a href="javascript:;" class="js-addCompare">
									  <span class="normalText">比較表に追加する</span>
									  <span class="disabledText">比較表に追加済</span>
									</a>
								  </p>
								</li>
								<li class="product_btnItem">
								  <p class="link_01 product_compareLink"><a href="">比較表を見る</a></p>
								</li>
							  </ul>
							</div>
							*}
							
							<div class="product_sns">
								<ul class="product_snsList">
									<li class="product_sns_item js-sns-tw">
										<img src="{$BASEURL}/images/common/icon_sns_twitter_01.png" width="35" height="35" alt="">
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
										
										<img src="{$BASEURL}/images/common/icon_sns_facebook_01.png" width="35" height="35" alt="">
										
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
										<img src="{$BASEURL}/images/common/icon_sns_line_01.png" width="37" height="35" alt="">
										<div class="product_sns_wrap">
											<div class="product_sns_popup">
												<a href="line://msg/"><img src="{$BASEURL}/images/common/sns/linebutton_82x20_en.png" width="82" height="20"></a>
											</div>
										</div>
									</li>
								</ul>
							</div>

						</div>
					  </div>
					  <!-- /productImageBox -->
				</div>

				<section>

					<div class="headingLv1Block noBorderBottom">
						<h2 class="headingLv1">規格</h2>
					</div>
					
					<section>
						<h3 class="headingLv2">特點</h3>
						<div class="container">
							<ul class="featureList clearfix">
							  
								{*Features*}
								{assign var=FraturesTag value=explode(",", $Product->product->product_custom_text_9|strval)}
								{foreach $FraturesTag as $FT}
									<li class="featureList_item"><span>{trim($FT)}</span></li>
								{/foreach}
							
							</ul>

							<ul class="accordion">
								<li class="js-accordionWrap">
									<section>
										<h3 class="js-accordionTrigger accordionTrigger"><a href="">詳情</a></h3>
										<div class="js-accordionTarget">
											<div class="accordion_detail">
												<table class="table_basic_02 thWsNorwrap featureDetail_table">
												  <tbody>

													{if $Product->product->product_custom_text_7|isnotemptyeditorstring}
														<tr>
															<th>機芯</th>
															<td>{$Product->product->product_custom_text_7}</td>
														</tr>
													{/if}
													  
													{if $Product->product->product_custom_text_1|isnotemptyeditorstring}
														<tr>
															<th>動力</th>
															<td>{$Product->product->product_custom_text_1}</td>
														</tr>
													{/if}
													
													{if $Product->product->product_custom_text_2|isnotemptyeditorstring}
														<tr>
															<th>訊號接收</th>
															<td>{$Product->product->product_custom_text_2}</td>
														</tr>
													{/if}
													
													{if $Product->product->product_custom_text_14|isnotemptyeditorstring}
														<tr>
															<th>錶帶</th>
															<td>{$Product->product->product_custom_text_14}</td>
														</tr>
													{/if}

													{if $Product->product->product_custom_text_5|isnotemptyeditorstring}
														<tr>
															<th>防水</th>
															<td>{$Product->product->product_custom_text_5}</td>
														</tr>
													{/if}

													{if $Product->product->product_custom_double_1|doubleval > 0}
														<tr>
															<th>重量</th>
															<td>{$Product->product->product_custom_double_1}g</td>
														</tr>
													{/if}

													{if $Product->product->product_custom_double_2|doubleval > 0}
														<tr>
															<th>厚度</th>
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
															<th>錶徑</th>
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
															<th>錶殼</th>
															<td>{$Product->product->product_custom_text_3}</td>
														</tr>
													{/if}

													{if $Product->product->product_custom_text_8|isnotemptyeditorstring}
														<tr>
															<th>表面處理</th>
															<td>{$Product->product->product_custom_text_8}</td>
														</tr>
													{/if}

													{if $Product->product->product_custom_text_15|isnotemptyeditorstring}
														<tr>
															<th>錶面</th>
															<td>{$Product->product->product_custom_text_15}</td>
														</tr>
													{/if}

													<tr>
														<th>保養</th>
														<td>{$smarty.const.MAINTENANCE_COMMON}</td>
													</tr>
													
													{if $Product->product->product_desc|isnotemptyeditorstring}
														<tr>
															<th>產品功能</th>
															<td class="ProductSpec">{$Product->product->product_desc}</td>
														</tr>
													{/if}

													</tbody>
												</table>
													
											</div>
										</div>
									</section>
								</li>
							</ul>

						</div>
					</section>

				</section>

			</main>

		</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}