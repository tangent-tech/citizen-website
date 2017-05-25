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
														<option value="">Area</option>
														{foreach $StoreLocationRegionList as $k=>$v}
															<option value="{$k}" {if $smarty.request.area_parent_id == $k}selected{/if}>
																{$v.name_en}
															</option>
														{/foreach}
													</select>
													
												</li>
												<li class="search_inputList_item">
													
													<select name="area_list_id">
														<option value="">{$smarty.const.STORE_PAGE_AJAX_DISTRICT}</option>
														{foreach $SearchAreaList as $k=>$v}
															<option value="{$v.area_list_id}" {if $smarty.request.area_list_id == $v.area_list_id}selected{/if}>
																{$v.area_name_en}
															</option>
														{/foreach}
													</select>
													
												</li>
												<li class="search_inputList_item">
													
													<input type="text" id="search_input_01" name="search_text" value="{$smarty.request.search_text}" placeholder="Keyword">
													
												</li>
											</ul>
										</div>
										<input type="button" value="Search" class="search_moreButton-input rollover_01">
										
									</li>
								</ul>
							</div>

						</form>
					</div>
					
					<div class="StoreLocationMainShopContent">
						
						<b>Citizen Flagship Store</b><br>
						2 Bayfront Avenue #B2-01A The Shoppes at Marina Bay Sands Singapore 018972
						
						<br>
						Tel: 6688 7412<br>
						Opening Hour: : 10:30am to 10:45pm (Sunday to Thursday)<br>
										10:30am to 11:30pm (Friday & Saturday)
						<br>
						<br>

						<b>Citizen Kiosk (VivoCity)</b><br>
						1 Harbourfront Walk #02-K3 VivoCity Singapore 098585
						
						
						<br>
						Tel: 6221 0216	<br>
						Opening Hour: 10:30am to 9:30pm<br>
						<br>

						<b>Citizen Kiosk (Westgate)	</b><br>
						3 Gateway Drive #01-K4 Westgate Singapore 608532 
						
						<br>
						Tel: 6710 4167	<br>
						Opening Hour: : 10:30am to 9:30pm<br>
						<br>

						
					</div>
	
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

												<table width="100%">
													{foreach $A1.store_location as $SL}
														<tr>
															<td width="33%">{$SL.store_location_name_en}</td>
															<td width="16%">{$SL.store_location_tel_no}</td>
															<td width="41%" class="NoBorderRight">{$SL.store_location_address_en}</td>
															<td class="NoBorderLeft">
															
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