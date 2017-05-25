{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$NewsList->object_name}</h1>
			</div>

			<div class="container">
				<section>

					<div class="newsWrap clearfix">
						<div class="news_side">
							<ol class="news_side_linkList">

								{*
								<li class="news_side_linkList_item {if $NewsList->object_link_id|intval == $ImportantNotices->object_link_id|intval}current{/if}">
									<a href="{$BASEURL}{$ImportantNotices->object_seo_url}">{$ImportantNotices->object_name}</a>
								</li>
								*}

								{for $Year=$smarty.now|date_format:"Y"|intval to $smarty.const.LAYOUT_NEWS_START_YEAR|intval step -1}
									<li class="news_side_linkList_item {if $smarty.request.year == $Year}current{/if}">
										<a href="{$BASEURL}{GetSeoUrl($smarty.const.LAYOUT_NEWS_ROOT_LINK_ID)}?year={$Year}">{$Year}</a>
									</li>
								{/for}

							</ol>
						</div>
						
						<div id="CONTENTS" class="news_main">
							<article class="solid">
								
								{assign var=LayoutNewsTitle value=$LayoutNews->layout_news->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
								{assign var=DisplayTag value=$LayoutNews->layout_news->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}
								{assign var=Content value=$LayoutNews->layout_news->layout->block_defs->block_def[4]->block_contents->block[0]->block_content}
								
								<div class="news_article">
									<p class="news_date">{$LayoutNews->layout_news->layout_news_date|date_format:"Y/m/d"}</p>
									<p class="icon_categoryBadge">
										
										{if $LayoutNews->layout_news->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
										{else if $LayoutNews->layout_news->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_events_01.jpg" width="96" height="18" alt="EVENTS">
										
										{else if $DisplayTag == "PRODUCT"}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_product_01.gif" width="96" height="18" alt="PRODUCT">
										{else if $DisplayTag == "CORPORATE"}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_corporate_01.gif" width="96" height="18" alt="CORPORATE">
										{else if $DisplayTag == "TECHNOLOGE"}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_technology_01.gif" width="96" height="18" alt="TECHNOLOGE">
										{else if $DisplayTag == "TOPICS"}
											<img src="{$BASEURL}/images/common/icon_categoryBadge_topics_01.gif" width="96" height="18" alt="TOPICS">
										{/if}
									</p>
									<h2 class="news_article_title">{$LayoutNewsTitle|nl2br}</h2>

									<div class="clearfix mt20">
										{$Content}
									</div>
									{*
									<div class="clearfix">
										<div class="floLeft" style="width: 470px;">
										  <p class="mt20">シチズン時計株式会社（本社：東京都西東京市／代表取締役社長：戸倉 敏夫、以下シチズン）は、公益財団法人日本環境協会（以下：日本環境協会）が主催する、「エコマークアワード2014」において、身につける時計を通じて、消費者のエコ意識向上に貢献したと評価され、時計業界として初めての最高賞である「金賞」を受賞しました。</p>
										  <p class="mt20">この賞は、エコマーク商品をはじめとする環境配慮型商品（以下、エコマーク商品等）の製造、販売あるいは普及啓発等により、「消費者の環境を意識した商品選択、企業の環境改善努力による、持続可能な社会の形成」に大きく寄与した企業・団体等の優れた取り組みを表彰するものです。</p>
										</div>
										<div class="mt10 floRight" style="width: 200px;"><img width="184" height="172" border="0" alt="ECO MARK AWARD 2014" src="images/20150115_01.jpg"></div>
									</div>

									<div class="clearfix mt20">
										<h3>受賞理由</h3>
										<p>光を電気エネルギーに換え二次電池に蓄えて時計を駆動させる光発電技術の「エコ・ドライブ」を搭載した時計で、1996年に業界で初めてエコマーク認定を取得。現在ではシチズンブランドの国内販売商品99％までエコ化を進めるなど、環境面で時計業界をけん引している。「エコ・ドライブ」というソーラー技術の機能性を高めるだけでなく、デザインの美しさとの融合をめざし、消費者がより長く愛用できる時計を追及することで、多彩な商品ラインアップを実現している。また、商品カタログ、ウェブサイト、店頭ポップなど、さまざまな媒体でエコマークを活用し、「エコ・ドライブ」というわかりやすい名称と相まって消費者の環境意識の向上に大きく貢献している。</p>
									</div>

									<div class="clearfix mt20">
										<h3>受賞コメント</h3>
										<p>腕時計の一大革新であったクオーツ式腕時計が普及し始めた1970年代、シチズンはすでに「使用済み電池」の課題を認識し、1976年、世界初の太陽電池を備えた腕時計を発売。その後、更なる改良が進められ、1995年「エコ・ドライブ」と命名し、世界中で販売を開始しました。以来、エコにこだわり、さまざまな技術開発を経て、「エコ・ドライブ」を進化させ、シチズンを代表する商品として市場で高い評価を受けるまでに至りました。</p>
										<p class="mt20">この転機となった要因のひとつに1996年に時計ではじめてエコマークを取得できたことが挙げられます。エコマークによって「社会にその価値が認められた」と受け止めることで、その後の技術開発や商品展開にむけた励みとなり、またエコ推進企業としての自負を持つことができました。</p>
										<p class="mt20">今回、こうして栄えあるエコアワード金賞を受賞できたことは、シチズンとして大変な喜びであり、金賞の名に恥じないよう、なお一層エコマークの普及につとめ、ひいては持続可能な社会の実現に向け貢献してまいります。</p>
									</div>
									
									<h2>関連リンク</h2>
									<p><a class="addb" href="http://www.ecomark.jp/award/" target="_blank">エコマークアワード詳細</a></p>
									<p><a class="addb" href="http://www.ecomark.jp/award/2014/" target="_blank">エコマークアワード2014受賞者</a></p>
									*}

								</div>
							</article>
						</div>
								
					</div>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}