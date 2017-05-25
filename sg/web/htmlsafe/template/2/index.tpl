{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			{if count($Slider) > 0}
				<div id="js-keyvisualSlider" class="keyvisualSlider">
				  {foreach $Slider as $S}
					  <div class="keyvisualSlider_item">
						  <a href="{$S->block_link_url}" target="_blank">
							  <img src="{$REMOTE_BASEURL}/getfile.php?id={$S->block_image_id}" width="1000" height="560" alt="{$S->object_name}">
						  </a>
					  </div>
				  {/foreach}
				</div>
				<ul id="js-keyvisualSliderArrow" class="keyvisualSliderArrow">
				</ul>
			{/if}

			{*Lineup*}
			<section>

				<div class="headingLv1Block noBorder">
					<h2 class="headingLv1">腕錶系列</h2>
				</div>

				<div class="container">
					<div class="lineup">
						<ul id="js-lineupIndex" class="lineupIndex clearfix">
							
							{foreach $HomePageLineup->layout_news_list->layout_news as $L}
								
								{assign var=LinkURL value=$L->layout->block_defs->block_def[6]->block_contents->block[0]}
								{assign var=LineupThumbnail value=$L->layout->block_defs->block_def[0]->block_contents->block[0]}
								
								<li class="js-lineupIndex_item lineupIndex_item">
									<a href="{$BASEURL}{$LinkURL->block_content}">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$LineupThumbnail->block_image_id}" width="196" height="72" alt="{$L->layout_news_title}">
									</a>
								</li>
							{/foreach}

						</ul>
						<div class="lineupDetail">
						  
							{foreach $HomePageLineup->layout_news_list->layout_news as $L}
								
								{assign var=LineupDetailImage value=$L->layout->block_defs->block_def[1]->block_contents->block[0]}
								{assign var=LineupLogo value=$L->layout->block_defs->block_def[3]->block_contents->block[0]}
								{assign var=Content value=$L->layout->block_defs->block_def[5]->block_contents->block[0]}
								
								{assign var=Category value=explode(',', $L->layout->block_defs->block_def[2]->block_contents->block[0]->block_content|strval)}
								{assign var=Feature value=explode(',', $L->layout->block_defs->block_def[4]->block_contents->block[0]->block_content|strval)}
						  
								<div id="lineup0{$L@iteration}" class="lineupDetail_item clearfix {if $L@index == 0}active{/if}">
									<div class="lineupDetail_itemLeft">
										{foreach $Category as $CA}
											<p class="lineup_category">{$CA}</p>
										{/foreach}
										<p class="lineup_logo">
											{if $LineupLogo->block_image_id|intval > 0}
												<img src="{$REMOTE_BASEURL}/getfile.php?id={$LineupLogo->block_image_id}" alt="{$L->layout_news_title}">
											{/if}
										</p>
										{if count($Feature) > 0 && $Feature[0] != ""}
											<ul class="lineup_featureList clearfix">
												{foreach $Feature as $F}
													<li class="lineup_featureList_item"><span>{$F}</span></li>
												{/foreach}
											</ul>
										{/if}
										<p class="lineup_copy">{$Content->block_content|nl2br}</p>
									</div>
									<div class="lineupDetail_itemRight">
										<div>
											{if $LineupDetailImage->block_image_id|intval > 0}
												<img src="{$REMOTE_BASEURL}/getfile.php?id={$LineupDetailImage->block_image_id}" width="442" height="304" alt="">
											{/if}
										</div>
									</div>
								</div>
									
							{/foreach}

							<p class="btn_01 lineupDetail_btnMore">
								<a href="{$BASEURL}{GetSeoUrl($smarty.const.PRODUCT_ROOT_LINK_ID)}">查看腕錶系列</a>
							</p>

						</div>
					</div>

					{*Related Brand*}
					<div class="related">
						<p class="related_label">其它相關品牌</p>
						<ul class="relatedlist clearfix">
							
							{foreach $RelatedBrand as $R}
								<li class="relatedlist_item {if $R@index == 0}ml10{/if}">
									<a href="{$R->block_link_url}" target="_blank">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$R->block_image_id}" width="{$R->block_content}" alt="{$R->object_name}">
									</a>
								</li>
							{/foreach}

						</ul>
					</div>

				</div>

				{*About CITIZEN*}
				<div class="philosophy">
					<div class="container">
						<div class="philosophy_inner">
							<div class="philosophy_logo">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$AboutCITIZEN->block_image_id}" width="284" height="83" alt="{$AboutCITIZEN->object_name}">
							</div>
							<p class="philosophy_copy">{$AboutCITIZEN->block_content|nl2br}</p>
							<p class="btn_01 philosophy_btn"><a href="{$AboutCITIZEN->block_link_url}">關於 CITIZEN</a></p>
						</div>
						<ul class="philosophy_movieList clearfix">
							
							{*Youtube01*}
							<li class="philosophy_movieList_item">
								<a href="{$Youtube01->block_content}" class="js-openModal">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$Youtube01->block_image_id}" alt="{$Youtube01->object_name}">
								</a>
							</li>
							
							{*Youtube02*}
							<li class="philosophy_movieList_item">
								<a href="{$Youtube02->block_content}" class="js-openModal">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$Youtube02->block_image_id}" alt="{$Youtube02->object_name}">
								</a>
							</li>

						</ul>
					</div>
				</div>

			</section>

			{*Technologies*}
			<section>
				<div class="headingLv1Block noBorder">
					<h2 class="headingLv1">技術</h2>
				</div>
				<div class="container">
					<div class="techonology">
						<div class="technology_inner">
							<div class="mb20">
								{foreach $TechnologiesBlockName as $TN}
									<p class="technology_name">{$TN->block_content}</p>
								{/foreach}
							</div>
							<p class="mb40">{$TechnologiesBlockContent->block_content|nl2br}</p>
							<p class="btn_01 technology_btn"><a href="{$TechnologiesBlockContent->block_link_url}">技術</a></p>
						</div>
						<ul class="columnWrap techcolumnWrap column3 clearfix">
														
							{foreach $TechnologImage as $T}
								<li class="column">
									<a href="{$T->block_link_url}" target="_blank">
										<div class="techcolumn_image">
											<img src="{$REMOTE_BASEURL}/getfile.php?id={$T->block_image_id}" width="308" height="210" alt="{$T->object_name}">
										</div>
										<p class="techcolumn_text">{$T->object_name}</p>
									</a>
								</li>
							{/foreach}

						</ul>
					</div>
				</div>
			</section>

			{*Layout News*}
			<section>

				<div class="headingLv1Block noBorderBottom">
					<h2 class="headingLv1">{$LayoutNewsList->object_name}</h2>
				</div>

				<div class="news">
					<div class="container">

						{*
						<div class="news_inner">
							<p class="news_label">{$ImportantNotices->object_name}</p>
							<ul class="linkList_01 news_linkList mb25">
								
								{foreach $ImportantNotices->layout_news_list->layout_news as $I}
									<li>
										<a href="{$BASEURL}{$I->object_seo_url}?lid={$ImportantNotices->object_link_id}">
											{$I->layout_news_title}
										</a>
									</li>
								{/foreach}

							</ul>
							<p class="btn_01 news_btnInfo">
								<a href="{$BASEURL}{$ImportantNotices->object_seo_url}">重要事項一覽</a>
							</p>
						</div>
						*}

						{foreach $LayoutNewsList->layout_news_list->layout_news as $L}
							
							{if $L@index % 2 == 0}
								<ul class="columnWrap newsColumnWrap column2 clearfix">
							{/if}

								{assign var=LayoutNewsTitle value=$L->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
								{assign var=DisplayTag value=$L->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}
								{assign var=ThumbnailID value=$L->layout->block_defs->block_def[3]->block_contents->block[0]->block_image_id}

								<li class="column">
									<a href="{$BASEURL}{$L->object_seo_url}?lid={$LayoutNewsList->object_link_id}">
										<div class="column_inner clearfix">
											{if $ThumbnailID|intval > 0}
												<div class="newscolumn_left">
													<div>
														<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" width="190" {*height="190"*} alt="">
													</div>
												</div>
											{/if}
											<div class="newscolumn_right">
												<p class="icon_categoryBadge">

													{if $L->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
													{else if $L->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_events_01.jpg" width="96" height="18" alt="EVENTS">

													{else if $DisplayTag == "PRODUCT"}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_product_02.gif" width="74" height="18" alt="PRODUCT">
													{else if $DisplayTag == "CORPORATE"}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_corporate_02.gif" width="74" height="18" alt="CORPORATE">
													{else if $DisplayTag == "TECHNOLOGE"}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_technology_02.gif" width="74" height="18" alt="TECHNOLOGE">
													{else if $DisplayTag == "TOPICS"}
														<img src="{$BASEURL}/images/common/icon_categoryBadge_topics_02.gif" width="74" height="18" alt="TOPICS">
													{/if}
												</p>
												<p class="newscolumn_date">{$L->layout_news_date|date_format:"Y/m/d"}</p>
												<p class="newscolumn_detail">{$LayoutNewsTitle|nl2br}</p>
											</div>
										</div>
									</a>
								</li>

							{if $L@index % 2 == 1 || $L@last}
								</ul>
							{/if}

						{/foreach}

					</div>
				</div>

			</section>

			{*Pickup*}
			<section>
			  <div class="headingLv1Block noBorderBottom">
				<h2 class="headingLv1">相關影片</h2>
			  </div>
			  <div class="container">
				<div class="columnWrap column2 columnBlock_01 clearfix">

					<div class="column">
						{if $PickupLeftYoutudeID->object_id|intval > 0}
							<a href="https://www.youtube.com/watch?v={$PickupLeftYoutudeID->block_link_url}" class="js-openModal">
								<div class="specialColumn_image">
									<div class="js-openModal specialColumn_imageCaver"></div>
									<iframe width="100%" height="272" src="https://www.youtube.com/embed/{$PickupLeftYoutudeID->block_link_url}" frameborder="0" allowfullscreen></iframe>
								</div>
								<p class="specialColumn_text">{$PickupLeftYoutudeID->block_content}</p>
							</a>
						{/if}
					</div>

					<div class="column">
						{if $PickupRightYoutudeID->object_id|intval > 0}
							<a href="https://www.youtube.com/watch?v={$PickupRightYoutudeID->block_link_url}" class="js-openModal">
								<div class="specialColumn_image">
									<div class="js-openModal specialColumn_imageCaver"></div>
									<iframe width="100%" height="272" src="https://www.youtube.com/embed/{$PickupRightYoutudeID->block_link_url}" frameborder="0" allowfullscreen></iframe>
								</div>
								<p class="specialColumn_text">{$PickupRightYoutudeID->block_content}</p>
							</a>
						{/if}
					</div>

				</div>
					
				{foreach $PickupLinkLine1 as $L1}
					
					{if $L1@index % 3 == 0}
						<div class="columnWrap specialWrap mb40 column3 clearfix">
					{/if}

						<div class="column">
							<a class="PickupLinkLine1Block" href="{$L1->block_link_url}" target="_blank">
								<div class="specialColumn_image">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L1->block_image_id}" width="308" height="210" alt="">
								</div>
								<p class="specialColumn_text">{$L1->object_name}<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></p>
							</a>
						</div>

					{if $L1@index % 3 == 2 || $L1@last}
						</div>
					{/if}
					
				{/foreach}
					
				{foreach $PickupLinkLine2 as $L2}
					
					{if $L2@index % 3 == 0}
						<div class="columnWrap specialWrap mb40 column3 clearfix">
					{/if}

						<div class="column">
							<a href="{$L2->block_link_url}" target="_blank">
								<div class="specialColumn_image">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L2->block_image_id}" width="308" height="210" alt="">
								</div>
								<p class="specialColumn_text">{$L2->object_name}<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01"></p>
							</a>
						</div>

					{if $L2@index % 3 == 2 || $L2@last}
						</div>
					{/if}

				{/foreach}
					
			  </div>
			</section>

			{*Support*}
			{if $ServiceAndSupport_Left->object_id|intval > 0 || $ServiceAndSupport_Right->object_id|intval > 0}
				<section>
					<div class="headingLv1Block noBorderBottom">
						<h2 class="headingLv1">支援服務</h2>
					</div>
					<div class="support">
						<div class="container">
							<div class="columnWrap supporWrap column2 clearfix">
								<div class="column">
									<div class="column_inner">
										<p class="suportColumn_text">{$ServiceAndSupport_Left->block_content}</p>
										<p class="btn_01 suportColumn_btn">
											<a href="{$ServiceAndSupport_Left_Link->block_link_url}" target="_blank">{$ServiceAndSupport_Left_Link->block_content}</a>
										</p>
									</div>
								</div>
								<div class="column">
									<div class="column_inner">
										<p class="suportColumn_text">{$ServiceAndSupport_Right->block_content}</p>
										<p class="btn_01 suportColumn_btn">
											<a href="{$ServiceAndSupport_Right_Link->block_link_url}" target="_blank">{$ServiceAndSupport_Right_Link->block_content}</a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			{/if}
										
		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}