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

						<p class="productPrice"><!-- {$MyCurrency} --><!-- {$Product->product->product_price|currencyformat} --></p>
				  
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
									<p class="product_variation_label">Related Models</p>
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
						<h2 class="headingLv1">Specification</h2>
					</div>
					
					<section>
						<h3 class="headingLv2">Features</h3>
						<div class="container">
							<ul class="featureList clearfix">
							  
								{*Features*}
								{assign var=FraturesTag value=explode(",", $Product->product->product_custom_text_9|strval)}
								{foreach $FraturesTag as $FT}
									<li class="featureList_item"><span>{trim($FT)}</span></li>
								{/foreach}
							
							</ul>

							<ul class="accordion">
								<li class="js-accordionWrap active">
									<section>
										<h3 class="js-accordionTrigger accordionTrigger"><a href="">Details</a></h3>
										<div class="js-accordionTarget">
											<div class="accordion_detail">
												<table class="table_basic_02 thWsNorwrap featureDetail_table">
												  <tbody>

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

													</tbody>
												</table>

												{*
												<div class="featureDetail_bottom">
												  <div class="icon_markWrap">
																			<img src="/s/common/images/icon_mark_01.gif" width="39" height="39" alt="">
																			<img src="/s/common/images/icon_mark_02.gif" width="38" height="39" alt="">
																			<img src="/s/common/images/icon_mark_03.gif" width="38" height="39" alt="">
																			<img src="/s/common/images/icon_mark_04.gif" width="55" height="39" alt="">
																			<img src="/s/common/images/icon_mark_05.gif" width="22" height="39" alt="">
																			<img src="/s/common/images/icon_mark_06.gif" width="26" height="39" alt="">
																			<img src="/s/common/images/icon_mark_07.gif" width="21" height="39" alt="">
																			<img src="/s/common/images/icon_mark_08.gif" width="16" height="39" alt="">
																			<img src="/s/common/images/icon_mark_09.gif" width="54" height="39" alt="">
																			<img src="/s/common/images/icon_mark_10.gif" width="54" height="39" alt="">
																			<img src="/s/common/images/icon_mark_11.gif" width="54" height="39" alt="">
																			<img src="/s/common/images/icon_mark_12.gif" width="53" height="39" alt="">
																		</div>
												  <p class="link_01 mb20"><a href="/s/product/guide/mark.html" target="_blank">アイコンについて</a><img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></p>
												  <ul class="cautionList">
													<li class="text_indent_03"><span class="listNum">※</span><span class="listInner">重量、厚み、ケースサイズは参考値としてご参照ください。</span></li>
													<li class="text_indent_03"><span class="listNum">※</span><span class="listInner">価格及び仕様は、予告なく変更する場合があります。</span></li>
												  </ul>
												</div>
												*}
													
											</div>
										</div>
									</section>
								</li>
							</ul>

						</div>
					</section>

				</section>

{*						
												
				<section>
				  <div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">製品特長</h2>
				  </div>
				  <div class="align-center"><img src="/s/product/attesa/lineup/model-name/images/img_detail_01.jpg" alt=""></div>
				  <div class="align-center mb20"><img src="/s/product/attesa/lineup/model-name/images/img_product_01.jpg" alt=""></div>
				  <div class="container">
					<ul class="accordion">
					  <li class="js-accordionWrap">
						<section>
						  <h3 class="js-accordionTrigger accordionTrigger"><a href="">世界最速＊最短3秒受信</a></h3>
						  <div class="js-accordionTarget">
							<div class="accordion_detail">
							  <p class="mb20">GPS衛星からの時刻情報の受信時間、最短3秒。独自のアルゴリズムが可能にした受信スピードと、新開発「高速ツインコイルモーター」の力で、針が瞬時になめらかに回りだし、正確な時刻でピタリと止まる。</p>
							  <ul class="cautionList">
								<li class="indent_01 mb10">＊光発電GPS衛星電波時計時計として。2015年5月現在、当社調べ。</li>
							  </ul>
							  <div class="align-center"><img src="/s/product/attesa/lineup/model-name/images/img_detail_08.jpg" alt=""></div>
							</div>
						  </div>
						</section>
					  </li>
					  <li class="js-accordionWrap">
						<section>
						  <h3 class="js-accordionTrigger accordionTrigger"><a href="">高速ツインコイルモーター</a></h3>
						  <div class="js-accordionTarget">
						  </div>
						</section>
					  </li>
					  <li class="js-accordionWrap">
						<section>
						  <h3 class="js-accordionTrigger accordionTrigger"><a href="">デリケートな肌の人も安心。<br>「耐メタルアレルギー」ウオッチ</a></h3>
						  <div class="js-accordionTarget">
						  </div>
						</section>
					  </li>
					</ul>
					<div class="columnWrap column2 product_bannerList clearfix">
					  <div class="column product_bannerList_item">
						<div class="product_bannerList_item_inner">
						  <a href="/s/technology/detail/eco.html"><img src="/s/product/attesa/lineup/model-name/images/img_detail_02.jpg" alt=""></a>
						</div>
					  </div>
					  <div class="column product_bannerList_item">
						<div class="product_bannerList_item_inner">
						  <a href="/s/technology/detail/titanium.html"><img src="/s/product/attesa/lineup/model-name/images/img_detail_03.jpg" alt="スーパーチタニウム&trade;"></a>
						</div>
					  </div>
					</div>
					<div class="align-center mb40"><a href="/locus/index.html"><img src="/s/common/images/kiseki.jpg" alt="シチズンのキセキ"></a></div>
				  </div>
				</section>

				<section>
				  <div class="popular">
					<div class="headingLv1Block noBorder">
					  <h2 class="headingLv1 mb40">アテッサ 人気の製品</h2>
					</div>
					<ul id="js-popularListSlider" class="popularListSlider clearfix">
					  <li class="popularListSlider_item"><a href=""><img src="/s/product/product-images/img_product_03-01.jpg" width="67" height="103" alt=""></a></li>
					  <li class="popularListSlider_item"><a href=""><img src="/s/product/product-images/img_product_03-02.jpg" width="67" height="103" alt=""></a></li>
					  <li class="popularListSlider_item"><a href=""><img src="/s/product/product-images/img_product_03-03.jpg" width="67" height="103" alt=""></a></li>
					  <li class="popularListSlider_item"><a href=""><img src="/s/product/product-images/img_product_03-04.jpg" width="67" height="103" alt=""></a></li>
					  <li class="popularListSlider_item"><a href=""><img src="/s/product/product-images/img_product_03-05.jpg" width="67" height="103" alt=""></a></li>
					</ul>
					<div class="container">
					</div>
				  </div>
				</section>

				<section>
				  <div class="headingLv1Block noBorderTop">
					<h2 class="headingLv1">サポート</h2>
				  </div>
				  <div class="supportColumnWrap">
					<section class="useGuide">
					  <h3 class="headingLv2 align-left">この製品の「操作ガイド」</h3>
					  <p class="mb15">ご覧の製品の操作ガイドを確認できます。操作方法・様々な機能をご確認ください。</p>
					  <ul class="supportList clearfix">
						<li class="supportList_item">
						  <p class="product_supportManualButton"><a href="">取扱説明書</a></p>
						</li>
						<li class="supportList_item">
						  <p class="product_supportManualButton"><a href="">簡易操作ガイド</a></p>
						</li>
					  </ul>
					  <h3 class="headingLv2 align-left mt50">よくあるご質問</h3>
						<p>お客さまから寄せられたお問い合わせの中から、よくあるご質問を掲載しています。</p>
						<p class="btn_01 support_moreButton mt10"><a href="http://faq-citizen.dga.jp/sp/"><span>よくあるご質問</span></a></p>
					</section>
				  </div>
				</section>

				<section>
				  <div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">ピックアップ</h2>
				  </div>
				  <div class="container">
					<div class="mb10 align-center"><a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="js-openModal"><img src="/s/product/attesa/lineup/model-name/images/img_detail_05.jpg" alt=""></a></div>
					<div class="columnWrap column2 specialContentsWrap clearfix">
					  <div class="column">
						<div class="column_inner">
						  <a href="/sw-gps/special/index.html#/opening" target="_blank"><img src="/s/product/attesa/lineup/model-name/images/img_detail_06.jpg" alt="エコ・ドライブGPS衛星電波時計 スペシャルサイト"></a>
						</div>
					  </div>
					  <div class="column">
						<div class="column_inner">
						  <a href="http://www.citizenwatch-global.com/baselworld/2016/jp.html" target="_blank"><img src="/s/product/attesa/lineup/model-name/images/img_detail_07.jpg" alt="BASELWORLD 2016"></a>
						</div>
					  </div>
					</div>
				  </div>
				</section>
*}

			</main>

		</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}