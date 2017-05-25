{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$Page->page->object_name}</h1>
			</div>
			
			<div class="search">
				<form id="StoreLocationSearch" action="{$BASEURL}{$ObjectLink->object->object_seo_url}" role="search" method="GET">

					<input type="hidden" name="link_id" value="{$ObjectLink->object->object_link_id}"/>
					<div class="clearfix">
						<ul class="search_itemList">
							<li class="search_item clearfix">
								<p class="search_inputLabel">Area</p>
								<div class="selectbox">
									<select name="area_parent_id">
										<option value="">Area</option>
										{foreach $StoreLocationRegionList as $k=>$v}
											<option value="{$k}" {if $smarty.request.area_parent_id == $k}selected{/if}>
												{$v.name_en}
											</option>
										{/foreach}
									</select>
								</div>
							</li>
							<li class="search_item clearfix">
								<p class="search_inputLabel">{$smarty.const.STORE_PAGE_AJAX_DISTRICT}</p>
								<div class="selectbox">
									<select name="area_list_id">
										<option value="">{$smarty.const.STORE_PAGE_AJAX_DISTRICT}</option>
										{foreach $SearchAreaList as $k=>$v}
											<option value="{$v.area_list_id}" {if $smarty.request.area_list_id == $v.area_list_id}selected{/if}>
												{$v.area_name_en}
											</option>
										{/foreach}
									</select>
								</div>
							</li>
							<li class="search_item clearfix">
								<p class="search_inputLabel">Keyword</p>
								<ul class="search_kwButtonList">
									<li class="search_kwButtonList_item">
										<input type="text" id="search_input_01" name="search_text" value="{$smarty.request.search_text}" placeholder="Keyword">
									</li>
									<li class="search_kwButtonList_item">
										<input type="submit" value="Search" class="search_moreButton">
									</li>
								</ul>
							</li>
						</ul>
					</div>

				</form>
			</div>

			<div class="container">
				<section>
					
					<div class="StoreLocationMainShopContent">
<!-- 						{$Content->block_content}
 -->					</div>
					<br/>
					<br/>
	
					{assign var=isFirst value=true}

					{foreach $StoreLocationRegionList as $k=>$v}

						{if $StoreLocationList[$k] != null}

							<div class="js-accordionWrap {if $isFirst || $smarty.request.broadway_only}active{/if}">
								<p class="js-accordionTrigger featureDetailButton"><a href="">{$v.name_en}</a></p>
								<div class="js-accordionTarget">
								  <div class="featureDetailWrap clearfix">

										<div class="StoreListContent">
											{foreach $StoreLocationList[$k] as $A1}

												{if $A1.area_list_id != '999' && $smarty.request.broadway_only != 'Y'}
													<h4>{$A1.area_name_en}</h4>
												{/if}

												{foreach $A1.store_location as $SL}
													<table class="MobileStoreDetails" width="100%">
														<tr>
															<td colspan="2">{$SL.store_location_name_en}</td>
														</tr>
														<tr>
															<td width="70%" class="NoBorderRight">{$SL.store_location_address_en}</td>
															<td class="NoBorderLeft" align="right">
																<!-- <a href="#MapPopup" class="js-openModal_inline" data-search_key="{$SL.store_location_google_key_tc}">
																	MAP
																	<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
																</a> -->
															</td>
														</tr>
														<tr>
															<td colspan="2" class="StoreTel">{$SL.store_location_tel_no}</td>
														</tr>
													</table>
												{/foreach}

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