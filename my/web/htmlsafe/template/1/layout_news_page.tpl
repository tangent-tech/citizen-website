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
								<li class="news_side_linkList_item {if $ObjectLink->object->object_link_id|intval == $ImportantNotices->object_link_id|intval}current{/if}">
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
						<div class="news_main js-newsWrap">
							<ul class="news_main_itemList">

								{foreach $NewsList->layout_news_list->layout_news as $L}
								
									{assign var=LayoutNewsTitle value=$L->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
									{assign var=DisplayTag value=$L->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}
									
									<li class="news_main_item">
										<a href="{$BASEURL}{$L->object_seo_url}?lid={$NewsList->object_link_id}" class="news_main_itemLink">
											<p class="news_date">{$L->layout_news_date|date_format:"Y/m/d"}</p>
											<p class="icon_categoryBadge">
												
												{if $L->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
													<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
												{else if $L->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
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
											<p class="news_main_detail">{$LayoutNewsTitle|nl2br}</p>
										</a>
									</li>
								
								{/foreach}

							</ul>
							<div class="news_readMore mt40 btn_01 btnMore clearfix"><a href="javascript:;" class="js-readMore rollover_01">More</a></div>
						</div>
					</div>

					<div class="news_other">
						
						{if count($OtherNewsList->layout_news_list->layout_news) > 0}
						
							<ul class="columnWrap column4 news_other_linkList clearfix">

								{foreach $OtherNewsList->layout_news_list->layout_news as $O}

									{assign var=LayoutNewsTitle value=$O->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
									{assign var=ShortContent value=$O->layout->block_defs->block_def[1]->block_contents->block[0]->block_content}
									{assign var=ExternalLink value=$O->layout->block_defs->block_def[2]->block_contents->block[0]->block_content}
									{assign var=ThumbnailID value=$O->layout->block_defs->block_def[3]->block_contents->block[0]->block_image_id}

									<li class="column">
										<div class="column_inner">

											{if $ExternalLink != ""}

												<a href="{$ExternalLink}" target="_blank" class="news_other_link">
													<div class="news_other_linkImage">
														{if $ThumbnailID|intval > 0}
															<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" width="220" height="150" alt="{$O->layout_news_title}">
														{/if}
													</div>
													<p class="news_other_linkText">
														{$LayoutNewsTitle|nl2br}
														<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
													</p>
													<p class="news_other_linkDetail">{$ShortContent|nl2br}</p>
												</a>

											{else}

												<a href="##" class="news_other_link">
													<div class="news_other_linkImage">
														{if $ThumbnailID|intval > 0}
															<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" width="220" height="150" alt="{$O->layout_news_title}">
														{/if}
													</div>
													<p class="news_other_linkText">{$LayoutNewsTitle|nl2br}</p>
													<p class="news_other_linkDetail">{$ShortContent|nl2br}</p>
												</a>

											{/if}

										</div>
									</li>
								{/foreach}

							</ul>
							
						{/if}
							
					</div>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}