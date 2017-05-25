{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorder">
				<h1 class="headingLv1">Technology</h1>
			</div>

			<section class="mb50 align-center">
				<h2 class="headingLv2">{$KeyContent->object_name}</h2>
				<div class="copyblock">
					<p>{$KeyContent->block_content}</p>
				</div>
			</section>

			<div class="technologyArea01">

				{if $TechnologyBlock01->block_image_id|intval > 0}
					<section class="technologyBlock ecoBlock" style="background: url({$REMOTE_BASEURL}/getfile.php?id={$TechnologyBlock01->block_image_id}) no-repeat;">
						<div class="technologyBlock_inner">
							<div class="box">
								<h2 class="headingLv2 align-left copy">{$TechnologyBlock01->object_name}</h2>
								<div class="text">
									<p>{$TechnologyBlock01->block_content|nl2br}</p>
									<p class="techbtn_01 support_moreButton mt30">
										<a href="{$TechnologyBlock01->block_link_url}">{$TechnologyBlock01->object_name}</a>
									</p>
								</div>
							</div>
						</div>
					</section>
				{/if}
				
				{if $TechnologyBlock02->block_image_id|intval > 0}
					<section class="technologyBlock" style="background: url({$REMOTE_BASEURL}/getfile.php?id={$TechnologyBlock02->block_image_id}) no-repeat;">
						<div class="technologyBlock_inner">
							<div class="box technologyRightBlock">
								<h2 class="headingLv2 align-left copy">{$TechnologyBlock02->object_name}</h2>
								<div class="text">
									<p>{$TechnologyBlock02->block_content|nl2br}</p>
									<p class="techbtn_01 techbtn_02 support_moreButton mt30">
										<a href="{$TechnologyBlock02->block_link_url}">{$TechnologyBlock02->object_name}</a>
									</p>
								</div>
							</div>
						</div>
					</section>
				{/if}

				{if $TechnologyBlock03->block_image_id|intval > 0}
					<section class="technologyBlock" style="background: url({$REMOTE_BASEURL}/getfile.php?id={$TechnologyBlock03->block_image_id}) no-repeat;">
						<div class="technologyBlock_inner">
							<div class="box">
								<h2 class="headingLv2 align-left copy">{$TechnologyBlock03->object_name}</h2>
								<div class="text">
									<p>{$TechnologyBlock03->block_content|nl2br}</p>
									<p class="techbtn_01 techbtn_02 support_moreButton mt30">
										<a href="{$TechnologyBlock03->block_link_url}">{$TechnologyBlock03->object_name}</a>
									</p>
								</div>
							</div>
						</div>
					</section>
				{/if}
				
				{if $TechnologyBlock04->block_image_id|intval > 0}
					<section class="technologyBlock" style="background: url({$REMOTE_BASEURL}/getfile.php?id={$TechnologyBlock04->block_image_id}) no-repeat;">
						<div class="technologyBlock_inner">
							<div class="box technologyRightBlock">
								<h2 class="headingLv2 align-left copy">{$TechnologyBlock04->object_name}</h2>
								<div class="text">
									<p>{$TechnologyBlock04->block_content|nl2br}</p>
									<p class="techbtn_01 techbtn_02 support_moreButton mt30">
										<a href="{$TechnologyBlock04->block_link_url}">{$TechnologyBlock04->object_name}</a>
									</p>
								</div>
							</div>
						</div>
					</section>
				{/if}

			</div>

			<div class="technologyArea02">
				<section class="technologyBlock duratectBlock">
					<div class="technologyBlock_inner">
						<div class="box">
							<h2 class="headingLv2 align-left copy">デュラテクト</h2>
							<div class="text">
								<p>美しさをキズつけない。<br>
								時計本来の輝きや仕上げの美しさを保護するためにシチズンが独自に開発した表面硬化技術。<br>
								チタニウムやステンレスなどの素材に特殊な加工を施すことで表面硬度を高め、時計のケースやバンドをすりキズや小キズから守ります。</p>
								<p class="techbtn_01 support_moreButton mt30"><a href="">デュラテクト</a></p>
							</div>
						</div>
					</div>
				</section>

				<section class="technologyBlock directflightBlock">
				  <div class="technologyBlock_inner">
					<div class="box technologyRightBlock">
					  <h2 class="headingLv2 align-left copy">ダイレクトフライト</h2>
					  <div class="text">
						<p>2ステップで世界へ直行。<br>
						世界多局受信ワールドタイム機能</p>
						<p>りゅうずを引いて、都市を選ぶ。この2ステップの操作だけで、針やディスクが動き、世界の都市時刻とカレンダーの表示を瞬時に開始。<br>
						シチズンが誇る先進機能を、アナログ時計ならではの操作感とともに堪能できます。</p>
						<p class="techbtn_01 support_moreButton mt30"><a href="">ダイレクトフライト</a></p>
					  </div>
					</div>
				  </div>
				</section>

				<section class="technologyBlock claritycoatingBlock">
				  <div class="technologyBlock_inner">
					<div class="box">
					  <h2 class="headingLv2 align-left copy">99% クラリティ・コーティング</h2>
					  <div class="text">
						<p>時計は見やすくなければならない。<br>
						サファイアガラスの表裏両面にシリコン化合物を多層構造コーティングすることにより光の反射を抑え（透過率99%）、高い視認性を確保し時計の文字板を見やすくしました。<br>
						またキズがつきにくく、表面には汚れを防ぐ撥水膜を施し、優れた耐久性と防汚性を向上させました。</p>
						<p class="techbtn_01 support_moreButton mt30"><a href="">99% クラリティ・コーティング</a></p>
					  </div>
					</div>
				  </div>
				</section>

				<section class="technologyBlock perfexBlock">
				  <div class="technologyBlock_inner">
					<div class="box technologyRightBlock">
					  <h2 class="headingLv2 align-left copy">パーフェックス</h2>
					  <div class="text">
						<p>時は、ズレてはいけない。<br>
						時計の誤作動の大きな要因となる磁気と衝撃。それらの影響を軽減する先進技術がパーフェックスです。「JIS1種耐磁」「衝撃検知機能」「針自動補正機能」という3つの機能を一体化することで、より正確な時刻表示を可能にしました。</p>
						<p class="techbtn_01 support_moreButton mt30"><a href="">パーフェックス</a></p>
					  </div>
					</div>
				  </div>
				</section>
			</div>

			<div class="container mt50 mb50">
				<div class="technologyLinkList">
					<ul class="clearfix">
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/eco.html">エコ・ドライブ</a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/titanium.html">スーパーチタニウム<sup>&trade;</sup></a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/satellitewave.html">サテライト ウエーブ</a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/rcw.html">電波時計</a></li>
					</ul>
					<ul class="clearfix mt10">
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/duratect.html">デュラテクト</a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/directflight.html">ダイレクトフライト</a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/claritycoating.html">99%　クラリティ・コーティング</a></li>
						<li class="technologyLinkList_item rollover_01"><a href="/technology/detail/perfex.html">パーフェックス</a></li>
					</ul>
				</div>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}