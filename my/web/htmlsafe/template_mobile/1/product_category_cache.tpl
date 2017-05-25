<div class="main">
	<main>
		
		<h1 class="align-center">
			{$ProductCategory->product_category->product_category_custom_text_8}
		</h1>
		
		<section>
			<div class="headingLv1Block noBorderTop">
				<h2 class="headingLv1">
					Recommended Products<br/>For {$ProductCategory->product_category->product_category_name}
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
																<p class="lineup_price"><!-- {$MyCurrency} --><!-- {$P->product_price|currencyformat} --></p>
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
												<p class="lineup_price"><!-- {$MyCurrency} --><!-- {$P->product_price|currencyformat} --></p>
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

{*
		<section>
		  <div class="headingLv1Block noBorderBottom">
			<h2 class="headingLv1">クロスシーのクオリティ</h2>
		  </div>
		  <div class="container">
			<ul class="accordion">
			  <li class="js-accordionWrap">
				<section>
				  <h3 class="js-accordionTrigger accordionTrigger"><a href="">一番売れている、選ばれている。</a></h3>
				  <div class="js-accordionTarget">
					<div class="accordion_detail">
					  <p class="mb10">「シーンや服装を選ばずに使える」「電池交換がいらなくて、本当に便利」<br>
					  「着けていることを忘れるくらい軽い！」</p>
					  <p class="mb10">1966年の発売以来、クロスシーは&quot;本当にいいもの&quot;を求める女性たちに選ばれ続けてきました。品質、美しさ、そして実力、これからも私たちはその価値を、どこまでも磨き続けます。</p>
					  <p class="font-sizeS">※中価格帯（3～10万円）の女性用腕時計ブランドにおいて。2014年における日本国内小売店での販売数量ベース。 ユーロモニター・インターナショナル調べ。</p>
					</div>
				  </div>
				</section>
			  </li>
			  <li class="js-accordionWrap">
				<section>
				  <h3 class="js-accordionTrigger accordionTrigger"><a href="">品質、美しさ、そして機能。</a></h3>
				  <div class="js-accordionTarget">
					<div class="accordion_detail">
					  <div class="align-center">
						<img src="/s/product/xc/images/img_xc_14.jpg" alt="「こんなに軽い時計、はじめて！」ステンレスの約1/2の軽さで肌にも優しいスーパーチタニウムTM純チタニウムの5倍もの硬さを実現しました。※約40％軽い 「着けた時の高級感がちがう。」上質で透明感あふれる白蝶貝文字盤。南半球の豊かな海で1800日以上かけて育った天然の光沢を、その腕に。 「キズがつかなくて、ずっとキレイ。」不純物0％で高硬度のサファイアガラスとシチズン独自の表面硬化技術デュラテクトが、擦れなどの小さなキズから美しい輝きを守ります。 「暗い場所でも、時間が見やすい。」暗闇でも上品に光る夜光針を採用。1本1本をダイヤモンドで磨き上げ、美しさと見やすさを両立しました。 「電池交換も時刻合わせもいらなくて、うれしい！」太陽や部屋の光で充電するエコ・ドライブ電波時計。標準電波を受信して、正確な時刻・日付にも自動で修正します。">
					  </div>
					</div>
				  </div>
				</section>
			  </li>
			  <li class="js-accordionWrap">
				<section>
				  <h3 class="js-accordionTrigger accordionTrigger"><a href="">ハッピーフライト</a></h3>
				  <div class="js-accordionTarget">
					<div class="accordion_detail">
					  <h3 class="headingLv3 align-left">1本で、世界中どこへでも</h3>
					  <ul>
						<li class="text_indent_01">・光で発電するから、面倒な電池交換はいりません。</li>
						<li class="text_indent_01">・世界4エリア（日本、中国、ヨーロッパ、北米）で電波を受信し、いつでも正確。</li>
						<li class="text_indent_01">・時刻合わせも2ステップで簡単。世界24都市の時刻がすぐにわかります。</li>
					  </ul>
					  <div class="align-center">
						<img src="/s/product/xc/images/img_xc_05.jpg" alt="">
					  </div>

					  <h3 class="headingLv3 align-left mt30">旅先でも、たった2ステップで時刻合わせができる「ワールドタイム機能」</h3>
					  <p class="mb10">Step1 りゅうずを1段引き、秒針を都市の名前に合わせます。<br>
					  Step2 りゅうずを押し戻すだけ、自動で針が回りだし、すぐに現地の時刻に。</p>
					  <div class="align-center">
						<img src="/s/product/xc/images/img_xc_06.jpg" alt="">
					  </div>
					</div>
				  </div>
				</section>
			  </li>
			</ul>
		  </div>
		</section>
		<section>
		  <div class="headingLv1Block noBorderBottom">
			<h2 class="headingLv1">クロスシーのスペシャルコンテンツ</h2>
		  </div>
		  <div class="container">
			<div class="columnWrap column2 columnBlock_01 clearfix">
			  <div class="column">
				<img src="/product/xc/images/img_xc_08.jpg" alt="">
			  </div>
			  <div class="column">
				<p class="mb10">女流作家がショートショートで紡ぐ、わたしだけの“特別”な時間</p>
				<p class="link_01 align-right"><a href="/product/xc/special/index.html#ctsTimeStory">詳しくはこちら</a></p>
			  </div>
			</div>
			<div class="columnWrap column2 columnBlock_01 clearfix">
			  <div class="column">
				<img src="/product/xc/images/img_xc_09.jpg" alt="">
			  </div>
			  <div class="column">
				<p class="mb10">意外と見られている「手元」。美しく女性らしい所作で魅力度UP</p>
				<p class="link_01 align-right"><a href="/product/xc/special/index.html#ctsBusinessScene">詳しくはこちら</a></p>
			  </div>
			</div>
					<div class="columnWrap column2 columnBlock_01 clearfix">
			  <div class="column">
				<img src="/product/xc/images/img_xc_07.jpg" alt="">
			  </div>
			  <div class="column">
				<p class="mb10">働く女性に寄り添う「クロスシー」。愛用者インタビュー</p>
				<p class="link_01 align-right"><a href="/product/xc/special/index.html#ctsWatashiJikan">詳しくはこちら</a></p>
			  </div>
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
				<ul class="support_navi">
					<li class="support_navi_item"><a href="http://faq-citizen.dga.jp/sp/">よくあるご質問</a></li>
					<li class="support_navi_item"><a href="/s/support/contact/index.html">お問い合わせ</a></li>
				</ul>
			</div>
		</section>
		*}
		
		{*
		<section>
			<div class="headingLv1Block noBorderBottom">
				<h2 class="headingLv1">カタログ</h2>
			</div>
			<div class="container">
				<ul class="guide_buttonList">
					<li class="btn_01 catalog"><a href="/product/xc/images/catalog/xcpanf183-16ss_6p.pdf" target="_blank"><span>2016年春夏クロスシーカタログ① [XC]  （PDF / 1.80 MB)</span></a></li>
					<li class="btn_01 catalog"><a href="/product/xc/images/catalog/2015awcollection_xc.pdf" target="_blank"><span>WATCH COLLECTION 2016SS [XC] （PDF / 8.23 MB）</span></a></li>
					<li class="btn_01 catalog"><a href="/product/xc/images/catalog/xc2015aw_catalog.pdf" target="_blank"><span>2015年秋冬クロスシーカタログ [XC]（PDF / 5.02 MB）</span></a></li>
				</ul>
			</div>
		</section>
		*}
		
		{*Pick Up*}
		{if count($PickupRow1) > 0 || count($PickupRow2) > 0}
		
			<section class="js-readMore">
				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">Relevant Video</h2>
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
					<div class="btn_01 readMore_btn mt30"><a href="javascript:;" class="js-readMoreBtn"><span>View More</span></a></div>
				{/if}
				
			</section>
						
		{/if}

	</main>
</div>