
					<div class="pager clearfix">
						<p class="pager_item">搜索“<span class="pager_keyword">{$smarty.request.search_text}</span>”的搜索結果有 </p>
						<p class="pager_item"><span class="pager_number">{$SearchResult->total_no_of_objects}</span>個。</p>

						{if $SearchResult->total_no_of_objects|intval > 0}

							<ul class="pager_item pagerList">
								<li class="pagerList_item pager_prev">
									{if $PageNo != 1}
										<a class="SearchPageATag" href="#" data-page_no="{$PageNo-1}">&lt;&lt;</a>
									{else}
										<a class="SearchPageATag" href="#" data-page_no="1">&lt;&lt;</a>
									{/if}
								</li>

								{if $PageNo > 2}
									
									{assign var=MinPage value=$PageNo-1}
									{assign var=MaxPage value=$PageNo+1}
									{foreach $PageNoSelection as $PS}
										{if $PS@iteration >= $MinPage && $PS@iteration <= $MaxPage}
											<li class="pagerList_item {if $PS == $PageNo}active{/if}">
												<a class="SearchPageATag" href="#" data-page_no="{$PS}">{$PS}</a>
											</li>
										{/if}
									{/foreach}
									
								{else}
									{foreach $PageNoSelection as $PS}
										{if $PS@index < 3}
											<li class="pagerList_item {if $PS == $PageNo}active{/if}">
												<a class="SearchPageATag" href="#" data-page_no="{$PS}">{$PS}</a>
											</li>
										{/if}
									{/foreach}
								{/if}
								
								<li class="pagerList_item pager_next">
									{if $PageNo < $TotalPageNo}
										<a class="SearchPageATag" href="#" data-page_no="{$PageNo+1}">&gt;&gt;</a>
									{else}
										<a class="SearchPageATag" href="#" data-page_no="{$TotalPageNo}">&gt;&gt;</a>
									{/if}
								</li>
								<li class="pagerList_item pager_current">{$PageNo}/<span class="pager_number">{$TotalPageNo}</span></li>
							</ul>

						{/if}

					</div>