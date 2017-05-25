{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">
		<main>

			{if count($MobileSlider) > 0}
				<div id="js-productSlider" class="productSlider clearfix">
					{foreach $MobileSlider as $MS}
						<div class="productSlider_item">
							<a href="{$MS->block_link_url}" target="_blank">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MS->block_image_id}" alt="">
							</a>
						</div>
					{/foreach}
				</div>
			{/if}

			<div class="container">
				<p class="btn_01 watchsearch mt30">
					<a href="{GetSeoUrl($smarty.const.SEARCH_PAGE_LINK_ID)}">
						<span>搜尋腕錶</span>
					</a>
				</p>
			</div>

			<section>
				<div class="headingLv1Block noBorderTop noBorderBottom">
				  <h1 class="headingLv1">腕錶系列</h1>
				</div>
				<div class="lineup">
					<ul class="clearfix">
						{foreach $WatchLineup->product_category->product_categories->product_category as $W}
							<li class="lineupIndex_item">
								<a href="{$BASEURL}{$W->object_seo_url}">
									{$W->product_category_custom_text_7}
								</a>
							</li>
						{/foreach}
					</ul>
				</div>
			</section>

			<div class="container">

				<p class="btn_01 lineup mt30">
					<a href="{$BASEURL}{GetSeoUrl($smarty.const.PRODUCT_ROOT_LINK_ID)}"><span>查看腕錶系列</span></a>
				</p>

				<div class="related">
					<p class="related_label">其它相關品牌</p>
					<ul class="relatedlist clearfix">
						
						{foreach $RelatedBrand as $R}
							<li class="relatedlist_item">
								<a href="{$R->block_link_url}" target="_blank">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$R->block_image_id}" alt="{$R->object_name}">
								</a>
							</li>
						{/foreach}

					</ul>
				</div>

			</div>

			<div class="philosophy">
				<div class="philosophy_inner">
				  <p class="philosophy_logo">BETTER STARTS NOW</p>
				  <p class="philosophy_copy">{$AboutCITIZEN->block_content|nl2br}</p>
				  <p class="btn_01 philosophy_btn"><a href="{$AboutCITIZEN->block_link_url}">關於 CITIZEN</a></p>
				</div>
			</div>

			<div class="techonology">
				<div class="technology_inner">
					<p class="technology_logo">技術</p>
					{foreach $TechnologiesBlockName as $TN}
						<p class="technology_name">{$TN->block_content}</p>
					{/foreach}
					<p class="technology_copy">{$TechnologiesBlockContent->block_content|nl2br}</p>
					<p class="btn_01 technology_btn">
						<a href="{$TechnologiesBlockContent->block_link_url}"><span>技術</span></a>
					</p>
				</div>
			</div>

			<section class="js-readMoreSPNews">
				<div class="headingLv1Block noBorderBottom">
					<h1 class="headingLv1">{$LayoutNewsList->object_name}</h1>
				</div>
				<ul class="newsColumnWrap clearfix">
					
					{foreach $LayoutNewsList->layout_news_list->layout_news as $L}
						
						{assign var=LayoutNewsTitle value=$L->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
						{assign var=DisplayTag value=$L->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}
						{assign var=ThumbnailID value=$L->layout->block_defs->block_def[3]->block_contents->block[0]->block_image_id}
						
						<li class="column js-readMoreItem">
							<div class="column_inner">
								<a href="{$BASEURL}{$L->object_seo_url}?lid={$LayoutNewsList->object_link_id}">
										
									{if $ThumbnailID|intval > 0}
										<div class="newscolumn_left">
											<div class="newscolumn_image">
												<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" alt="">
											</div>
										</div>
									{/if}
										
									<div class="newscolumn_right">
										<p class="newscolumn_date">{$L->layout_news_date|date_format:"Y/m/d"}</p>
										<p class="icon_categoryBadge">

											{if $L->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
												<img src="{$BASEURL}/images/common/icon_categoryBadge_topics_01.gif" width="58" height="13" alt="NEWS">
											{else if $L->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
												<img src="{$BASEURL}/images/common/icon_categoryBadge_corporate_01.gif" width="58" height="13" alt="EVENTS">
											{/if}
											
										</p>
										<p class="newscolumn_detail">{$LayoutNewsTitle|nl2br}</p>
									</div>
								</a>
							</div>
						</li>

					{/foreach}

				</ul>
				<div class="container">
					<div class="btn_01 readMore_btn mt30">
						<a href="javascript:;" class="js-readMoreBtn"><span>查看</span></a>
					</div>
				</div>
			</section>

			<section class="js-readMore">
				<div class="headingLv1Block noBorderBottom">
				  <h1 class="headingLv1">相關影片</h1>
				</div>
				<div class="specialColumnWrap">
					<ul>

						{if $PickupLeftYoutudeID->object_id|intval > 0}
							<li class="js-readMoreItem specialColumn_image">
								<a href="https://www.youtube.com/watch?v={$PickupLeftYoutudeID->block_link_url}" class="js-openModal">
									<div class="js-openModal specialColumn_imageCaver"></div>
									<iframe width="100%" height="200" src="https://www.youtube.com/embed/{$PickupLeftYoutudeID->block_link_url}" frameborder="0" allowfullscreen></iframe>
								</a>
							</li>
						{/if}
					
						{if $PickupRightYoutudeID->object_id|intval > 0}
							<li class="js-readMoreItem specialColumn_image">
								<a href="https://www.youtube.com/watch?v={$PickupRightYoutudeID->block_link_url}" class="js-openModal">
									<div class="js-openModal specialColumn_imageCaver"></div>
									<iframe width="100%" height="200" src="https://www.youtube.com/embed/{$PickupRightYoutudeID->block_link_url}" frameborder="0" allowfullscreen></iframe>
								</a>
							</li>
						{/if}

						{foreach $MobilePickupLink as $MP}
							<li class="js-readMoreItem">
								<a href="{$MP->block_link_url}" target="_blank">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$MP->block_image_id}" alt="{$MP->object_name}">
								</a>
							</li>
						{/foreach}

					</ul>
				</div>
				<div class="btn_01 readMore_btn mt30">
					<a href="javascript:;" class="js-readMoreBtn"><span>查看</span></a>
				</div>
			</section>

			{*Support*}
			{if $MobileServiceAndSupport_Left->object_id|intval > 0 || $MobileServiceAndSupport_Right->object_id|intval > 0}
				<section>
					<div class="headingLv1Block noBorderBottom">
					  <h1 class="headingLv1">支援服務</h1>
					</div>
					<ul class="support_navi">
						{if $MobileServiceAndSupport_Left->block_content != ""}
							<li class="support_navi_item">
								<a href="{$MobileServiceAndSupport_Left->block_link_url}" target="_blank">{$MobileServiceAndSupport_Left->block_content}</a>
							</li>
						{/if}
						{if $MobileServiceAndSupport_Right->block_content != ""}
							<li class="support_navi_item">
								<a href="{$MobileServiceAndSupport_Right->block_link_url}" target="_blank">{$MobileServiceAndSupport_Right->block_content}</a>
							</li>
						{/if}						
					</ul>
				</section>
			{/if}

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}