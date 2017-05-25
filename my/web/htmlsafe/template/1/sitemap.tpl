{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$Page->page->object_name}</h1>
			</div>
			<div class="container">

				<section class="mb50">
					<div class="headingLv2Block">
						<h2 class="headingLv2">
							<span class="link_01">
								<a href="{$BASEURL}/index.php">HOME</a>
							</span>
						</h2>
					</div>
				</section>

{*				{if $ProductRootPageXpath->object_id|intval > 0}

					<section class="mb50">

						<div class="headingLv2Block">
							<h2 class="headingLv2">
								<span class="link_01">
									<a href="{$BASEURL}{$ProductRootPageXpath->object_seo_url}">{$ProductRootPageXpath->object_name}</a>
								</span>
							</h2>
						</div>

						<div class="columnWrap column2 columnBlock_01 clearfix">
							<div class="column">
								<div class="ml20">
									{foreach $ProductRootPageXpath->objects->object as $productCat}
										<p class="link_01 mb05">
											<a href="{$BASEURL}{$productCat->object_seo_url}">{$productCat->object_name}</a>
										</p>
									{/foreach}
								</div>
							</div>
							<div class="column">
								<section>
									<h3 class="headingLv3">関連ブランド</h3>
									<p class="link_01 mb05"><a href="http://campanola.jp/" target="_blank">CAMPANOLA <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
									<p class="link_01 mb05"><a href="http://wicca-w.jp/" target="_blank">wicca <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
									<p class="link_01 mb05"><a href="http://independentwatch.com/" target="_blank">INDEPENDENT <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
									<p class="link_01 mb05"><a href="http://reguno.jp/" target="_blank">REGUNO <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
									<p class="link_01 mb05"><a href="/license/index.html" target="_blank">LICENCE FASHION WATCH <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
									<p class="link_01 mb05"><a href="/product/qq_your/index.html">Q&amp;Qウォッチ 法人向けオリジナルウォッチ</a></p>
									<p class="link_01 mb05 mt30"><a href="/product/comparison/index.html">比較表を見る</a></p>
									<p class="link_01 mb05"><a href="/product/images/catalog/2015awcollection.pdf" target="_blank">総合カタログ（2015年）</a></p>
								</section>
							</div>
						</div>

					</section>
				{/if}*}
				
				{foreach $TopMenu->object->objects->object as $C}

					{if $C@index % 3 == 0}
						<div class="columnWrap column3 columnBlock_02 clearfix">
					{/if}

						<div class="column">
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
											<p class="link_01 mb05">
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

					{if $C@index % 3 == 2 || $C@last}
						</div>
					{/if}

				{/foreach}

				{*
				<div class="columnWrap column3 columnBlock_02 clearfix mb50">
					<div class="column">
						<section>
							<div class="headingLv2Block">
								<h2 class="headingLv2"><span class="link_01"><a href="/watchsearch/index.html">ウオッチサーチ</a></span></h2>
							</div>
						</section>
					</div>
					<div class="column">
						<section>
							<div class="headingLv2Block">
								<h2 class="headingLv2"><span class="link_01"><a href="/philosophy/index.html">フィロソフィー</a></span></h2>
							</div>
							<div class="ml20">
								<p class="link_01 mb05"><a href="http://www.betterstartsnow.com/jp/" target="_blank">BETTER STARTS NOW <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
								<p class="link_01 mb05"><a href="/locus/index.html">シチズンのキセキ</a></p>
							</div>
						</section>
					</div>
					<div class="column">
						<section>
							<div class="headingLv2Block">
								<h2 class="headingLv2"><span class="link_01"><a href="/technology/index.html">テクノロジー</a></span></h2>
							</div>
							<div class="ml20">
								<p class="link_01 mb05"><a href="/technology/detail/eco.html">エコ･ドライブ</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/titanium.html">スーパーチタニウム<sup>&trade;</sup></a></p>
								<p class="link_01 mb05"><a href="/technology/detail/satellitewave.html">サテライト ウエーブ</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/rcw.html">電波時計</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/duratect.html">デュラテクト</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/directflight.html">ダイレクトフライト</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/claritycoating.html">99%　クラリティ・コーティング</a></p>
								<p class="link_01 mb05"><a href="/technology/detail/perfex.html">パーフェックス</a></p>
							</div>
						</section>
					</div>
				</div>

				<section class="mb50">
					<div class="headingLv2Block">
						<h2 class="headingLv2"><span class="link_01"><a href="/support/index.html">サポート</a></span></h2>
					</div>
					<div class="columnWrap column3 columnBlock_02 clearfix">
						<div class="column">
							<section class="ml20">
								<h3 class="headingLv3">機能・操作</h3>
								<p class="link_01 mb05"><a href="/support/guide/manual.html">取扱説明書</a></p>
								<p class="link_01 mb05"><a href="/support/exterior/index.html">外装機能ガイド</a></p>
								<p class="link_01 mb05"><a href="/support/exterior/crown.html">りゅうずの操作</a></p>
								<p class="link_01 mb05"><a href="/support/exterior/metalband.html" onclick="return openSubWindow(this.href,'ViewLargeImage',720,850);" target="_blank">メタルバンドの長さ調整<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
								<p class="link_01 mb05"><a href="http://faq-citizen.dga.jp/">よくあるご質問</a></p>
								<p class="link_01 mb05"><a href="/support/contact/index.html">お問い合わせ</a></p>
							</section>
						</div>
						<div class="column">
							<section>
								<h3 class="headingLv3">アフターサービス</h3>
								<p class="link_01 mb05"><a href="/support/after-service/waterproof.html">時計の取り扱い</a></p>
								<p class="link_01 mb05"><a href="/support/after-service/care.html">日常のお手入れ</a></p>
								<p class="link_01 mb05"><a href="/support/after-service/guarantee.html">保証について</a></p>
								<p class="link_01 mb05"><a href="/support/contact/input.html" target="_blank">修理・点検のご相談 <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
								<p class="link_01 mb05"><a href="/support/after-service/battery.html">電池交換</a></p>
								<p class="link_01 mb05"><a href="/support/useful/owners.html" onclick="return openSubWindow(this.href,'ViewLargeImage',720,850);" target="_blank">シチズンオーナーズサイト <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>

								<h3 class="headingLv3 mt30">故障かな？と思ったら</h3>
								<p class="link_01 mb05"><a href="/support/diagnosis/stop.html">時計が止まる</a></p>
								<p class="link_01 mb05"><a href="/support/diagnosis/incorect.html">時計が合わない</a></p>
							</section>
						</div>
						<div class="column">
							<section>
								<h3 class="headingLv3">豆知識</h3>
								<p class="link_01 mb05"><a href="/support/useful/glossary01.html">用語集</a></p>
								<p class="link_01 mb05"><a href="/support/useful/chronograph01.html">クロノグラフについて</a></p>
								<p class="link_01 mb05"><a href="/support/useful/allergy.html">金属アレルギーについて</a></p>
								<p class="link_01 mb05"><a href="/support/useful/magnetism01.html">磁気とは</a></p>
								<p class="link_01 mb05"><a href="/support/useful/timediff01.html">時差とは</a></p>
								<p class="link_01 mb05"><a href="/support/useful/crown01.html">りゅうずとは</a></p>
								<p class="link_01 mb05"><a href="/support/useful/lag01.html">針ズレについて</a></p>
								<p class="link_01 mb05"><a href="/support/useful/leap.html">うるう年・うるう秒とは</a></p>
							</section>
						</div>
					</div>
				</section>

				<div class="columnWrap column3 columnBlock_02 clearfix">

					<div class="column">
						<section>
							<div class="headingLv2Block">
							  <h2 class="headingLv2"><span class="link_01"><a href="/news/index.html">ニュース</a></span></h2>
							</div>
							<div class="ml20">
							  <p class="link_01 mb05"><a href="/news/importance/index.html">重要なお知らせ</a></p>
							  <p class="link_01 mb05"><a href="/news/2016/index.html">2016年</a></p>
							  <p class="link_01 mb05"><a href="/news/2015/index.html">2015年</a></p>
							  <p class="link_01 mb05"><a href="/news/2014/index.html">2014年</a></p>
							  <p class="link_01 mb05"><a href="/news/2013/index.html">2013年</a></p>
							  <p class="link_01 mb05"><a href="/news/2012/index.html">2012年</a></p>
							  <p class="link_01 mb05"><a href="/news/2011/index.html">2011年</a></p>
							  <p class="link_01 mb05"><a href="/news/2010/index.html">2010年</a></p>
							</div>
						</section>
					</div>

					<div class="column">
						<section>
							<div class="headingLv2Block">
								<h2 class="headingLv2">スペシャル</h2>
							</div>
							<p class="link_01 mb05"><a href="/event2016/jp.html" target="_blank">エコ･ドライブ40周年<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="/sw-gps/special/index.html" target="_blank">エコ・ドライブGPS衛星電波時計<br>スペシャルサイト<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="/product/xc/special/index.html" target="_blank">クロスシー スペシャルサイト<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="http://citizen.jp/event2016/baselworld/index.html" target="_blank">BASELWORLD 2016<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="http://www.citizenwatch-global.com/milanosalone/2014/jp.html" target="_blank">MILAN DESIGN WEEK 2014<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="/conceptwatch/index.html" target="_blank">エコ･ドライブ　コンセプトウオッチサイト<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="/conceptshop/index.html">CITIZEN CONCEPTSHOP</a></p>
							<p class="link_01 mb05"><a href="/pr/index.html" target="_blank">市民に愛され市民に貢献する<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<!-- <p class="link_01 mb05"><a href="">CITIZEN DISCOVERY</a></p> -->
						</section>
					</div>

					<div class="column">
						<section>
							<div class="headingLv2Block">
								<h2 class="headingLv2">関連サイト</h2>
							</div>
							<p class="link_01 mb05"><a href="http://www.citizenwatch-global.com/" target="_blank">CITIZEN WATCH Global Network <img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="http://www.citizen.co.jp/" target="_blank">シチズンホールディングス(株)<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
							<p class="link_01 mb05"><a href="http://www.rhythm.co.jp/clock/" target="_blank">シチズン クロック[リズム時計工業(株)]<img src="/common/images/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></a></p>
						</section>
					</div>

				</div>
				
				*}

			</div>
		</main>
	</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}