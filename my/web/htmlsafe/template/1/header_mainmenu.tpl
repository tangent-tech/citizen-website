{assign var=SeparateObjectsPoint value=ceil(count($TopMenu->object->objects->object)/2)}

{foreach $TopMenu->object->objects->object as $O}

	{if $O->object_type == "PRODUCT_ROOT_LINK"}

		<li class="js-megadropTrigger gnavi_item" data-object_link_id="{$O->object_link_id}">

			<a href="{$BASEURL}{$O->object_seo_url}">
				<span>{$O->object_name}</span>
			</a>
			<div id="js-megadropTarget" class="megadrop">
				<div class="megadrop_inner">
					<div class="megadrop_lineup">
						<p class="megadrop_label">{$O->object_name}</p>
						<ul id="js-megadrop" class="megadrop_linkList">

							{*Product Category*}
							{foreach $O->objects->object as $MenuProductCategory}
								<li data-submenu-id="js-{$MenuProductCategory->object_id}" class="js-megadrop_link megadrop_linkItem">

									<a class="JsSubmenuClickBtn" href="#js-{$MenuProductCategory->object_id}" data-url="{$BASEURL}{$MenuProductCategory->object_seo_url}">{$MenuProductCategory->object_name}</a>
									<div id="js-{$MenuProductCategory->object_id}" class="js-megadrop_products megadrop_products {if $MenuProductCategory@index == 0}active{/if}">
										<div class="megadrop_logo">{$MenuProductCategory->object_name}</div>

										<ul class="megadrop_productList clearfix">

											{*
												Loop Product Cateogory's Products
													Or
												Loop this Category Products
											*}
											{assign var=MenuLoopProductCount value=0}

											{foreach $MenuProductCategory->objects->object as $MenuProduct}

												{if $MenuProduct->object_type == "PRODUCT"}

													{if $MenuLoopProductCount < $smarty.const.SUBMENU_PRODUCT_PER_CATEGORY}
													<li class="megadrop_productListItem">
														<a href="{$BASEURL}{$MenuProduct->object_seo_url}">

															<div class="megadrop_productImage">
																{if $MenuProduct->object_thumbnail_file_id|intval > 0}
																	<img src="{$REMOTE_BASEURL}/getfile.php?id={$MenuProduct->object_thumbnail_file_id}" {*width="107"*} height="135" alt="">
																{/if}
															</div>
															<p class="megadrop_productName">{SubmenuProductGetProductCode($MenuProduct->object_link_id)} </p>
															<p class="megadrop_productPrice">
															<!-- 	{$MyCurrency} {SubmenuProductGetPrice($MenuProduct->object_link_id)|currencyformat} -->
															</p>

														</a>
													</li>
													{assign var=MenuLoopProductCount value=$MenuLoopProductCount+1}
													{/if}

												{else if $MenuProduct->object_type == "PRODUCT_CATEGORY"}

													{foreach $MenuProduct->objects->object as $SubProduct}

														{if $MenuLoopProductCount < $smarty.const.SUBMENU_PRODUCT_PER_CATEGORY}
														<li class="megadrop_productListItem">

															<a href="{$BASEURL}{$SubProduct->object_seo_url}">

																<div class="megadrop_productImage">
																	{if $SubProduct->object_thumbnail_file_id|intval > 0}
																		<img src="{$REMOTE_BASEURL}/getfile.php?id={$SubProduct->object_thumbnail_file_id}" {*width="107"*} height="135" alt="">
																	{/if}
																</div>
																<p class="megadrop_productName">{SubmenuProductGetProductCode($SubProduct->object_link_id)}</p>
																<p class="megadrop_productPrice">
																	<!-- {$MyCurrency} {SubmenuProductGetPrice($SubProduct->object_link_id)|currencyformat} -->
																</p>

															</a>
														</li>
														{assign var=MenuLoopProductCount value=$MenuLoopProductCount+1}
														{/if}
													{/foreach}

												{/if}
											{/foreach}

										</ul>
										<p class="megadrop_btnDetail">
											<a href="{$BASEURL}{$MenuProductCategory->object_seo_url}">Click here for details</a>
										</p>
									</div>

								</li>
							{/foreach}

						</ul>
						<p class="megadrop_btnComparison">
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
						</p>

					</div>
				</div>
			</div>

		</li>
		
	{else if $O->object_type == "PAGE" && $O->object_details->page->layout->layout_name == "PopupLink"}
		
		{assign var=LinkURL value=$O->object_details->page->layout->block_defs->block_def[0]->block_contents->block[0]->block_content|strval}
		
		<li class="gnavi_item" data-object_link_id="{$O->object_link_id}">
			<a href="{$LinkURL}" target="_blank">
				<span>{$O->object_name}</span>
			</a>
		</li>
		
	{else}
		{if $O->object_name == "Warranty Registration" }

		{else}
		<li class="gnavi_item" data-object_link_id="{$O->object_link_id}">
			
			<a href="{$BASEURL}{$O->object_seo_url}">
				
				<span>{$O->object_name}</span>
			</a>
		</li>
		{/if}
	{/if}

	{if $O@iteration == $SeparateObjectsPoint}
		<li class="gnavi_item header_logo">
			<a href="{$BASEURL}/index.php">
				<img src="{$BASEURL}/images/common/logo_header_01.gif" width="150" height="44" alt="CITIZEN BETTER STARTS NOW">
			</a>
		</li>
	{/if}

{/foreach}								