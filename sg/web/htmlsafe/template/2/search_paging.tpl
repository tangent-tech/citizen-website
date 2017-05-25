
					{if $SearchResult->total_no_of_objects|intval > 0}

						<div class="pager clearfix">
							<p class="pager_item">
								共 <span class="pager_number">{$SearchResult->total_no_of_objects}</span> 頁 「{$MinOffSet} 至 {$MaxOffSet}」
							</p>
							<ul class="pager_item pagerList">

								<li class="pagerList_item pager_prev">
									{if $PageNo != 1}
										<a class="SearchPageATag" href="#" data-page_no="{$PageNo-1}">&lt;&lt;</a>
									{else}
										<a class="SearchPageATag" href="#" data-page_no="1">&lt;&lt;</a>
									{/if}
								</li>
								
								{if $PageNo > 3}
									
									{assign var=MinPage value=$PageNo-2}
									{assign var=MaxPage value=$PageNo+2}
									{foreach $PageNoSelection as $PS}
										{if $PS@iteration >= $MinPage && $PS@iteration <= $MaxPage}
											<li class="pagerList_item {if $PS == $PageNo}active{/if}">
												<a class="SearchPageATag" href="#" data-page_no="{$PS}">{$PS}</a>
											</li>
										{/if}
									{/foreach}
									
								{else}
									{foreach $PageNoSelection as $PS}
										{if $PS@index < 5}
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
								
							</ul>
							<p class="pager_item">{$PageNo}/<span class="pager_number">{$TotalPageNo}</span></p>
						</div>
						
					{/if}