{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">
			<main>

				<div class="headingLv1Block noBorder">
					<h1 class="headingLv1">搜索結果</h1>
				</div>

				<div class="search">
					<form id="SearchForm" action="{$BASEURL}/search.php" method="GET" role="search">
						<div class="clearfix">
							<ul class="search_itemList">
								<li class="search_item clearfix">
									<p class="search_inputLabel">關鍵詞</p>
									<ul class="search_kwButtonList">
										<li class="search_kwButtonList_item">
											<input type="text" id="search_input_01" class="search_input_text" name="search_text" value="{$smarty.request.search_text}">
										</li>
										<li class="search_kwButtonList_item">
											<input type="hidden" name="page_no" value="{$PageNo}"/>
											<input type="submit" value="搜索" class="search_moreButton">
										</li>
									</ul>
								</li>
								<li class="search_item clearfix">
									<p class="search_inputLabel">類別</p>
									<div class="selectbox">
										<select name="search_type" id="">
											<option value="all" {if $smarty.request.search_type == "all" || $smarty.request.search_type == ""}selected{/if}>所有</option>
											<option value="product" {if $smarty.request.search_type == "product"}selected{/if}>產品</option>
											<option value="layout_news" {if $smarty.request.search_type == "layout_news"}selected{/if}>最新消息</option>
											<option value="page"  {if $smarty.request.search_type == "page"}selected{/if}>文章</option>
										</select>
									</div>
								</li>
							</ul>
						</div>
					</form>
				</div>
				
				<div class="container">

					<!-- search_result -->
					<div class="search_result">

						{include file="`$CurrentLang->language_root->language_id`/search_paging.tpl"}

						<div class="search_resultList">

							{if count($SearchResult->objects->children()) > 0}
								{foreach $SearchResult->objects->children() as $R}
									
									<div class="search_resultList_item">
										
										{if $R->object_type == "PRODUCT"}
											<a href="{$BASEURL}{$R->object_seo_url}" class="news_itemLink">
												<p class="icon_categoryBadge">
													<img src="{$BASEURL}/images/common/icon_categoryBadge_product_01.gif" width="96" height="18" alt="PRODUCT"><br/>
													<br/>
												</p>
												<div class="search_resultList_image">
													{if $R->object_thumbnail_file_id|intval > 0}
														<div>
															<img src="{$REMOTE_BASEURL}/getfile.php?id={$R->object_thumbnail_file_id}" height="100" alt="{$R->product_code}">
														</div>
													{/if}
												</div>
												<div class="search_resultList_detail">
													<p class="search_resultList_detail_label">
														{$R->product_code} ({$MyCurrency}{$R->product_price|currencyformat})
													</p>
													{*<p class="mb30">REGUNO(レグノ) Watch Collectionをご紹介いたします。</p>*}
													{*<p class="search_resultList_detail_link">http://reguno.jp/</p>*}
												</div>
											</a>
										{else if $R->object_type == "LAYOUT_NEWS"}
											<a href="{$BASEURL}{$R->object_seo_url}?lid={LayoutNewsRootIDGetLayoutNewsPageLinkID($R->layout_news_root_id)}" class="news_itemLink">
												<div class="search_resultList_detail">
													<p class="icon_categoryBadge">

														{if $R->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
															<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
														{else if $R->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
															<img src="{$BASEURL}/images/common/icon_categoryBadge_events_01.jpg" width="96" height="18" alt="EVENTS">
														{/if}
														<br/>

													</p>
													<p class="search_resultList_detail_label">
														{$R->layout_news_title}
													</p>
													{*<p class="mb30">REGUNO(レグノ) Watch Collectionをご紹介いたします。</p>*}
													{*<p class="search_resultList_detail_link">http://reguno.jp/</p>*}
												</div>
											</a>
										{else if $R->object_type == "PAGE"}
											<a href="{$BASEURL}{$R->object_seo_url}" class="news_itemLink">
												<div class="search_resultList_detail">
													{*<p class="icon_categoryBadge"><img src="/common/images/icon_categoryBadge_product_01.gif" width="96" height="18" alt="PRODUCT"></p>*}
													<p class="search_resultList_detail_label">
														{$R->object_name}
													</p>
													<p class="mb30">
														{$R->object_meta_description}
														{*{$BASEURL}{$R->object_seo_url}*}
													</p>
													{*<p class="search_resultList_detail_link">http://reguno.jp/</p>*}
												</div>
											</a>
										{else}
											{*
											{$R->object_name} | 
											{$R->object_type}
											*}
										{/if}
										
									</div>
									
								{/foreach}
							{/if}
								


							{*
							<div class="search_resultList_item clearfix">
							  <a href="http://citizen.jp/importance/20130514.html">
								<div class="search_resultList_image">
								  <div><img src="/search/images/img_search_02.jpg" width="240" height="160" alt="REGUNO（レグノ）chouchou(シュシュ)レディースウオッチをご購入のお客様へのお知らせ[CITIZEN-シチズン腕時計]"></div>
								</div>
								<div class="search_resultList_detail">
								  <p class="icon_categoryBadge"><img src="/common/images/icon_categoryBadge_corporate_01.gif" width="96" height="18" alt="CORPORATE"></p>
								  <p class="search_resultList_detail_label">REGUNO（レグノ）chouchou(シュシュ)レディースウオッチをご購入のお客様へのお知らせ[CITIZEN-シチズン腕時計]</p>
								  <p class="mb30">シチズン腕時計オフィシャルサイトです。</p>
								  <p class="search_resultList_detail_link">http://citizen.jp/importance/20130514.html</p>
								</div>
							  </a>
							</div>
							*}
							
						</div>

						{include file="`$CurrentLang->language_root->language_id`/search_paging.tpl"}

					</div>
					<!-- /search_result -->

				</div>

			</main>
		</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}