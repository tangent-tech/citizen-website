{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>
			
			{*DEBUG*}
			<div class="mfp-hide">
				<input id="PageNo" type="text" value="1" data-total_page="{$TotalPageNo|intval}"/>	{*page_no*}
				<input id="GenderSearchValue" type="text" value="1"/>			{*product_custom_int_1*}
				<input id="KudoSearchValue" type="text" value=""/>				{*product_custom_text_1*}
				<input id="DenpaSearchValue" type="text" value=""/>				{*product_custom_text_2*}
				<input id="CaseSearchValue" type="text" value=""/>				{*product_custom_text_3*}
				<input id="StrapSearchValue" type="text" value=""/>				{*product_custom_text_4*}
				<input id="WaterResistantSearchValue" type="text" value=""/>	{*product_custom_text_5*}
				<input id="GlassSearchValue" type="text" value=""/>				{*product_custom_text_6*}
				<input id="PriceSearchValue" type="text" value=""/>				{*product_price <= search_price*}
				<input id="FeaturesSearchValue" type="text" value=""/>			{*product_custom_int 2-8*}
				<input id="OrderBy" type="text" value="order_id"/>				{*OrderBy*}
				<input id="ProductCategoryID" type="text" value="0"/>			{*ProductCategoryID*}
			</div>

			<div class="headingLv1Block noBorder">
				<h1 class="headingLv1">{$PageTitle}</h1>
			</div>

			<div class="container">

				{*Gender Search*}
				<ul id="JSGenderSearch" class="tab tabColumun3 mb40 clearfix">
					<li class="tab_item active">
						<a data-value="1">男士</a>
					</li>
					<li class="tab_item">
						<a data-value="2">女士</a>
					</li>
					<li class="tab_item">
						<a data-value="0">對錶</a>
					</li>
				</ul>
				<p class="align-center mb45">請選擇以下條件。</p>

				<ul class="termsTable clearfix js-optionWrap">

					{*Kudo Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSKudoOption" class="js-openModal_inline">動力</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSKudoTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSKudoOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>動力</span></p>
							<ul class="modalInputList clearfix">
								{foreach $KudoSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="kudo_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.name_tc}"/>
										<label for="kudo_input_{$k}">
											{$v.name_tc}
											(<span class="product_custom_text_1" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_1"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSKudoOption" data-tag_name="#JSKudoTag" data-value_input="#KudoSearchValue">指定條件</a>
							</p>
						</div>
					</li>

					{*Denpa Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSDenpaOption" class="js-openModal_inline">信號</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSDenpaTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSDenpaOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>信號</span></p>
							<ul class="modalInputList clearfix">
								{foreach $DenpaSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="denpa_input_{$k}" data-tag-name="{$v.tag_name_tc}" data-value="{$v.name_tc}"/>
										<label for="denpa_input_{$k}">
											{$v.name_tc}
											(<span class="product_custom_text_2" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_2"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSDenpaOption" data-tag_name="#JSDenpaTag" data-value_input="#DenpaSearchValue">指定條件</a>
							</p>
						</div>
					</li>
					
					{*Case Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSCaseOption" class="js-openModal_inline">錶殼</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSCaseTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSCaseOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>錶殼</span></p>
							<ul class="modalInputList clearfix">
								{foreach $CaseSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="case_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.name_tc}"/>
										<label for="case_input_{$k}">
											{$v.name_tc}
											(<span class="product_custom_text_3" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_3"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSCaseOption" data-tag_name="#JSCaseTag" data-value_input="#CaseSearchValue">指定條件</a>
							</p>
						</div>
					</li>

					{*Strap Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSStrapOption" class="js-openModal_inline">錶帶</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSStrapTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSStrapOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>錶帶</span></p>
							<ul class="modalInputList clearfix">
								{foreach $StrapSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="strap_input_{$k}" data-tag-name="{$v.tag_name_tc}" data-value="{$v.name_tc}"/>
										<label for="strap_input_{$k}">
											{$v.tag_name_tc}
											(<span class="product_custom_text_4" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_4"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSStrapOption" data-tag_name="#JSStrapTag" data-value_input="#StrapSearchValue">指定條件</a>
							</p>
						</div>
					</li>
					
					{*Water Resistant Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSWaterResistantOption" class="js-openModal_inline">防水</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSWaterResistantTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSWaterResistantOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>防水</span></p>
							<ul class="modalInputList clearfix">
								{foreach $WaterResistantSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="water_resistant_input_{$k}" data-tag-name="{$v.tag_name_tc}" data-value="{$v.name_tc}"/>
										<label for="water_resistant_input_{$k}">
											{$v.name_tc}
											(<span class="product_custom_text_5" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_5"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSWaterResistantOption" data-tag_name="#JSWaterResistantTag" data-value_input="#WaterResistantSearchValue">指定條件</a>
							</p>
						</div>
					</li>
					
					{*Glass Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSGlassOption" class="js-openModal_inline">錶面</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSGlassTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSGlassOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>錶面</span></p>
							<ul class="modalInputList clearfix">
								{foreach $GlassSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="glass_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.name_tc}"/>
										<label for="glass_input_{$k}">
											{$v.name_tc}
											(<span class="product_custom_text_6" data-tag_name="{$v.name_tc}">{$SearchValueQTY["product_custom_text_6"][$v.name_tc]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSGlassOption" data-tag_name="#JSGlassTag" data-value_input="#GlassSearchValue">指定條件</a>
							</p>
						</div>
					</li>

					{*Price Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSPriceOption" class="js-openModal_inline">價格</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSPriceTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSPriceOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>價格</span></p>
							<ul class="modalInputList clearfix">
								{foreach $PriceSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="radio" id="price_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.below_value}" name="search_input_group_02"/>
										<label for="price_input_{$k}">
											{$v.name_tc}
											(<span class="product_price" data-tag_name="{$v.below_value}">{$SearchValueQTY["product_price"][{$v.below_value}]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSPriceOption" data-tag_name="#JSPriceTag" data-value_input="#PriceSearchValue">指定條件</a>
							</p>
						</div>
					</li>

					{*Features Search*}
					<li class="termsTable_item">
						<p class="termsTable_category">
							<a href="#JSFeaturesOption" class="js-openModal_inline">特點</a>
						</p>
						<div class="termsTable_selectCategory">
							<ul id="JSFeaturesTag" class="js-params">
							</ul>
						</div>
						{*Search Condition Popup*}
						<div id="JSFeaturesOption" class="modal mfp-hide JSSearchConditionOption">
							<p class="modalLabel"><span>特點</span></p>
							<ul class="modalInputList clearfix">
								{foreach $FeaturesSearchOption as $k=>$v}
									<li class="modalInputList_item">
										<input type="checkbox" id="features_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.field_name}"/>
										<label for="features_input_{$k}">
											{$v.name_tc}
											(<span class="{$v.field_name}" data-tag_name="1">{$SearchValueQTY[$v.field_name][1]|intval}</span>)
										</label>
									</li>
								{/foreach}
							</ul>
							<p class="modal_searchButton">
								<a href="" class="js-closeModal" data-parent="#JSFeaturesOption" data-tag_name="#JSFeaturesTag" data-value_input="#FeaturesSearchValue">指定條件</a>
							</p>
						</div>
					</li>
				  
				</ul>

				<div class="termsTable_noSelect">
					<p class="termsTable_noSelect_text">沒有指定條件。</p>
				</div>

				<div class="termsTable_search">
					<p class="termsTable_searchRusult">
						<span class="searchRusltNumber JSsearchTotal">{$Products->total_no_of_objects|intval}</span> 個腕錶結果。
					</p>
					<p class="termsTable_searchButton">
						<a id="JSSearchSubmit" href="" class="rollover_01">搜索條件</a>
					</p>
				</div>

				<div class="search">
					<div class="clearfix">
						<ul id="js-search_inputList" class="search_inputList ProductCategorySearchList clearfix">
							<li class="search_inputList_item">
								<input type="radio" id="product_category_0" name="product_category_group" data-product_category_id="0" checked="checked">
								<label for="product_category_0">
									全部系列
									(<span class="JSsearchTotal">{$Products->total_no_of_objects|intval}</span>)
								</label>
							</li>
							
							{foreach $ProductRootLink->product_category->product_categories->product_category as $C}

								<li class="search_inputList_item">
									<input type="radio" id="product_category_{$C->object_id}" name="product_category_group" data-product_category_id="{$C->object_id}" data-product_category_name="{$C->product_category_name|upper}">
									<label for="product_category_{$C->object_id}">
										{$C->product_category_name}
										(<span class="JSCategoryQtyNum {$C->object_id}" data-tag_name="0">{$SearchValueQTY[$C->object_id|intval][0]|intval}</span>)
									</label>
								</li>
								
								{if ($C@iteration + 1) % 4 == 0}
									<br class="clearfloat"/>
								{/if}
								
							{/foreach}
						</ul>
					</div>
				</div>

				<div id="JSSearchContent">
					
					{*Brand*}
					{foreach $Brand as $B}
						<div class="brand clearfix" data-brand_name="{$B->object_name|upper}" style="display:none;">
							<p class="brand_image">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$B->block_image_id}" width="175" height="29" alt="{$B->object_name}">
							</p>
							<div class="brand_text">
								<p>{$B->block_content}</p>
								<p class="brand_link">
									<a href="{$B->block_link_url}" target="_blank">
										按此查看更多 <img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
									</a>
								</p>
							</div>
						</div>
					{/foreach}

					<div class="sort">
						<p class="searchTable_searchRusult">

							<span class="searchRusltNumber JSRealsearchTotal">{$Products->total_no_of_objects|intval}</span> 個腕錶結果。

						</p>
						<dl id="js-sort_buttonList" class="sort_buttonList clearfix">
							<dt class="sort_label">價格排序</dt>
							<dd class="js-sort_button sort_button active" data-order_by="order_id">
								<a href="">未指定</a>
							</dd>
							<dd class="js-sort_button sort_button" data-order_by="price_desc">
								<a href="">高至低</a>
							</dd>
							<dd class="js-sort_button sort_button" data-order_by="price_asc">
								<a href="">低至高</a>
							</dd>
						</dl>
					</div>

					<div class="js-displayItem">
						<div class="columnWrap lineupWrap column5">
							<ul id="AjaxSearchProductArea" class="clearfix">
								{include file="`$CurrentLang->language_root->language_id`/ajax_product_search.tpl"}
							</ul>
						</div>
					</div>

				</div>

			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}