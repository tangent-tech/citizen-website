{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$Page->page->object_name}</h1>
			</div>

			<div class="container">
				<section>

					<div class="search">
						<form id="StoreLocationSearch" action="{$BASEURL}{$ObjectLink->object->object_seo_url}" role="search" method="GET">

							<input type="hidden" name="link_id" value="{$ObjectLink->object->object_link_id}"/>
							
							<div class="clearfix">
								<ul class="search_itemList">
									<li class="search_item clearfix">

										<div class="search_inputList StoreLocationSearchWrap">
											<ul class="search_inputList_inner">
												<li class="search_inputList_item">
													
													<select name="area_parent_id">
														<option value="">地點</option>
														{foreach $StoreLocationRegionList as $k=>$v}
															<option value="{$k}" {if $smarty.request.area_parent_id == $k}selected{/if}>
																{$v.name_tc}
															</option>
														{/foreach}
													</select>
													
												</li>
												<li class="search_inputList_item">
													
													<select name="area_list_id">
														<option value="">{$smarty.const.STORE_PAGE_AJAX_DISTRICT}</option>
														{foreach $SearchAreaList as $k=>$v}
															<option value="{$v.area_list_id}" {if $smarty.request.area_list_id == $v.area_list_id}selected{/if}>
																{$v.area_name_tc}
															</option>
														{/foreach}
													</select>
													
												</li>
												<li class="search_inputList_item">
													
													<input type="text" id="search_input_01" name="search_text" value="{$smarty.request.search_text}" placeholder="關鍵詞">
													
												</li>
											</ul>
										</div>
										<input type="button" value="搜索" class="search_moreButton-input rollover_01">
										
									</li>
								</ul>
							</div>

						</form>
					</div>
					
					<div class="StoreLocationMainShopContent">
						{$Content->block_content}
						{*
						<b>CITIZEN專賣店</b><br>
						九龍太子彌敦道750號始創中心地下G05舖
						&gt;
						<a href="#MapPopup" class="js-openModal_inline" data-search_key="九龍太子彌敦道750號始創中心地下G05舖">
							地圖 <img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
						</a>
						<br>
						電話: 2148 1483<br>
						營業時間: 上午10時30分至晚上10時正<br>
						<br>

						澳門氹仔望德聖母灣大馬路威尼斯人購物中心地下 K12A 號舖
						&gt; 
						<a href="#MapPopup" class="js-openModal_inline" data-search_key="澳門氹仔望德聖母灣大馬路威尼斯人購物中心地下 K12A 號舖">
							地圖 <img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
						</a>
						<br>
						電話: (853) 2882 8792<br>
						營業時間: 上午10時正至晚上11時正(星期日至星期四)，上午10時正至晚上12時正(星期五及星期六)<br>
						<br>

						<b>Authorized CITIZEN Corner</b><br>
						九龍旺角彌敦道610號荷李活商業中心地下G22號舖
						&gt; 
						<a href="#MapPopup" class="js-openModal_inline" data-search_key="九龍旺角彌敦道610號荷李活商業中心地下G22號舖">
							地圖 <img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
						</a>
						<br>
						電話: 2997 5305<br>
						營業時間: 上午10時正至晚上10時正<br>
						<br>

						<hr style="border:solid 1px #E9E9E9 ">
						<b>經銷商 - 連鎖店</b><br>百老匯 [<a href="{$BASEURL}{$ObjectLink->object->object_seo_url}?area_parent_id=&area_list_id=&search_text=broadway">請按此</a>]<br>
						時間廊 2113 2266
						*}
					</div>
	
					{assign var=isFirst value=true}
					{foreach $StoreLocationRegionList as $k=>$v}

						{if $StoreLocationList[$k] != null}

							<div class="js-accordionWrap {if $isFirst || $smarty.request.broadway_only}active{/if}">
								<p class="js-accordionTrigger featureDetailButton"><a href="">{$v.name_tc}</a></p>
								<div class="js-accordionTarget">
								  <div class="featureDetailWrap clearfix">

										<div class="StoreListContent">
											{foreach $StoreLocationList[$k] as $A1}

												{if $A1.area_list_id != '999' && $smarty.request.broadway_only != 'Y'}
													<h4>{$A1.area_name_tc}</h4>
												{/if}

												<table width="100%">
													{foreach $A1.store_location as $SL}
														<tr>
															<td width="33%">{$SL.store_location_name_tc}</td>
															<td width="16%">{$SL.store_location_tel_no}</td>
															<td width="41%" class="NoBorderRight">{$SL.store_location_address_tc}</td>
															<td class="NoBorderLeft">
																&gt;
																<a href="#MapPopup" class="js-openModal_inline" data-search_key="{$SL.store_location_google_key_tc}">
																	地圖
																	<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
																</a>
															</td>
														</tr>
													{/foreach}
												</table>

											{/foreach}
										</div>

								  </div>
								</div>
								<br/>
							</div>
							{assign var=isFirst value=false}

						{/if}

					{/foreach}
					
				</section>
			</div>

		</main>
	</div>
	
	<div id="MapPopup" class="modal mfp-hide">
		<div id='map-canvas'></div>
		<div>
			<input type="hidden" id="address" value="{*馬鞍山新港城2樓2208A號*}"/>
		</div>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}