{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$NewsList->object_name}</h1>
			</div>
			
			<div class="container js-newsWrap">

				<div class="search">
					<form action="" role="search">
						<div class="clearfix newsSelectWrap">
							<ul class="search_itemList">
								<li class="search_item clearfix">
									<p class="search_inputLabel">Year</p>
									<div class="selectbox">
										<select name="" id="newsSlect">
											{for $Year=$smarty.now|date_format:"Y"|intval to $smarty.const.LAYOUT_NEWS_START_YEAR|intval step -1}
												<option value="{$BASEURL}{GetSeoUrl($smarty.const.LAYOUT_NEWS_ROOT_LINK_ID)}?year={$Year}" {if $smarty.request.year == $Year}selected{/if}>
													{$Year}
												</option>
											{/for}
										</select>
									</div>
								</li>
							</ul>
						</div>
					</form>
				</div>

				<ul class="news_main_itemList mt30">

					{foreach $NewsList->layout_news_list->layout_news as $L}

						{assign var=LayoutNewsTitle value=$L->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
						{assign var=DisplayTag value=$L->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}

						<li class="news_main_item">
							<a href="{$BASEURL}{$L->object_seo_url}?lid={$NewsList->object_link_id}" class="news_itemLink">
								<p class="news_date">{$L->layout_news_date|date_format:"Y/m/d"}</p>
								<p class="icon_categoryBadge">
									{if $L->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
										<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
									{else if $L->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
										<img src="{$BASEURL}/images/common/icon_categoryBadge_events_01.jpg" width="96" height="18" alt="EVENTS">
									{/if}
								</p>
								<p class="news_main_detail">{$LayoutNewsTitle|nl2br}</p>
							</a>
						</li>

					{/foreach}

				</ul>

				{if count($NewsList->layout_news_list->layout_news) > 8}
					<div class="btn_01 readMore_btn mt30"><a href="javascript:;" class="js-readMore"><span>More</span></a></div>
				{/if}

				<div class="news_other mt30">

					{if count($OtherNewsList->layout_news_list->layout_news) > 0}

						<ul class="news_other_linkList clearfix">
							{foreach $OtherNewsList->layout_news_list->layout_news as $O}
								{assign var=LayoutNewsTitle value=$O->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
								{assign var=ShortContent value=$O->layout->block_defs->block_def[1]->block_contents->block[0]->block_content}
								{assign var=ExternalLink value=$O->layout->block_defs->block_def[2]->block_contents->block[0]->block_content}
								{assign var=ThumbnailID value=$O->layout->block_defs->block_def[3]->block_contents->block[0]->block_image_id}
								<li class="news_other_linkItem">
									<div class="column_inner">

										{if $ExternalLink != ""}
											<a href="{$ExternalLink}" target="_blank" class="news_other_link clearfix">
												<div class="news_other_linkImage">
													{if $ThumbnailID|intval > 0}
														<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" width="110" height="75" alt="{$O->layout_news_title}">
													{/if}
												</div>
												<div class="news_other_linkText">
													<p class="news_other_linkLabel news_other_linkLabel_notBlank">
														{$LayoutNewsTitle|nl2br}
														<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
													</p>
													<p class="news_other_linkDetail">{$ShortContent|nl2br}</p>
												</div>
											</a>
										{else}

											<a href="##" class="news_other_link clearfix">
												<div class="news_other_linkImage">
													{if $ThumbnailID|intval > 0}
														<img src="{$REMOTE_BASEURL}/getfile.php?id={$ThumbnailID}" width="110" height="75" alt="{$O->layout_news_title}">
													{/if}
												</div>
												<div class="news_other_linkText">
													<p class="news_other_linkLabel news_other_linkLabel_notBlank">
														{$LayoutNewsTitle|nl2br}
													</p>
													<p class="news_other_linkDetail">{$ShortContent|nl2br}</p>
												</div>
											</a>

										{/if}

									</div>
								</li>
							{/foreach}
						</ul>

					{/if}
					
				</div>
			  
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}