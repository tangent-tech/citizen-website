{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>
			
			{*DEBUG*}
			{*
			{literal}
				<style>
					#debugBar { display: block; }
					#debugBar input { border: 1px solid #000000; margin: 0 10px; }
				</style>
			{/literal}
			*}
			<div id="debugBar" class="mfp-hide">
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
			
			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$PageTitle}</h1>
			</div>

			<div class="container">
				<section>

					<h2 class="headingLv2">類型</h2>

					<ul id="JSGenderSearch" class="js-tabWrap tab clearfix">
						<li class="js-tabTrigger tab_item active">
							<a data-value="1">男士</a>
						</li>
						<li class="js-tabTrigger tab_item">
							<a data-value="2">女士</a>
						</li>
						<li class="js-tabTrigger tab_item">
							<a data-value="0">對錶</a>
						</li>
					</ul>
					
					<p class="align-center mb10">請選擇以下條件。</p>
			  
					<ul class="termsTable js-optionWrap">
						
						{*Kudo Search*}
						<li class="termsTable_item">
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
								  <p class="termsTable_category">動力</p>
								</li>
								<li class="termsTable_selectItem">
								  <p class="termsTable_selectButton">
									  <a href="#JSKudoOption" class="js-openModal_inline">指定條件</a>
								  </p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSKudoTag" class="clearfix js-params">
								</ul>
							</div>
							{*Search Condition Popup*}
							<div id="JSKudoOption" class="modal mfp-hide JSSearchConditionOption">
								<div>
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
							</div>
						</li>
					  
						{*Denpa Search*}
						<li class="termsTable_item">
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">信號</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSDenpaOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSDenpaTag" class="clearfix js-params">
								</ul>
							</div>
							{*Search Condition Popup*}
							<div id="JSDenpaOption" class="modal mfp-hide JSSearchConditionOption">
								<p class="modalLabel"><span>信號</span></p>
								<ul class="modalInputList clearfix">
									{foreach $DenpaSearchOption as $k=>$v}
										<li class="modalInputList_item">
											<input type="checkbox" id="denpa_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.name_tc}"/>
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">錶殼</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSCaseOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSCaseTag" class="clearfix js-params">
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">錶帶</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSStrapOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSStrapTag" class="clearfix js-params">
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
												{$v.name_tc}
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">防水</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSWaterResistantOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSWaterResistantTag" class="clearfix js-params">
								</ul>
							</div>
							{*Search Condition Popup*}
							<div id="JSWaterResistantOption" class="modal mfp-hide JSSearchConditionOption">
								<p class="modalLabel"><span>防水</span></p>
								<ul class="modalInputList clearfix">
									{foreach $WaterResistantSearchOption as $k=>$v}
										<li class="modalInputList_item">
											<input type="checkbox" id="water_resistant_input_{$k}" data-tag-name="{$v.name_tc}" data-value="{$v.name_tc}"/>
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">錶面</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSGlassOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSGlassTag" class="clearfix js-params">
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">價格</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSPriceOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSPriceTag" class="clearfix js-params">
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
							<ul class="termsTable_selectBox">
								<li class="termsTable_selectItem">
									<p class="termsTable_category">特點</p>
								</li>
								<li class="termsTable_selectItem">
									<p class="termsTable_selectButton">
										<a href="#JSFeaturesOption" class="js-openModal_inline">指定條件</a>
									</p>
								</li>
							</ul>
							<div class="termsTable_selectCategory">
								<ul id="JSFeaturesTag" class="clearfix js-params">
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
								
				<p class="termsTable_searchResult">
					<span class="searchRusltNumber JSsearchTotal">{$Products->total_no_of_objects|intval}</span> 個腕錶結果。
				</p>

				<p class="termsTable_searchButton">
					<a id="JSSearchSubmit" href="" class="rollover_01">搜索條件</a>
				</p>
			  
			</section>

			<section>
				<h2 class="headingLv2">腕錶系列</h2>
				<div class="selectbox">

					<select name="product_category_group">

						<option value="0" selected="selected" data-cate_name="全部系列" data-product_qty="0">
							全部系列(<span class="JSsearchTotal">{$Products->total_no_of_objects|intval}</span>)
						</option>

						{foreach $ProductRootLink->product_category->product_categories->product_category as $C}
							<option value="{$C->object_id}" data-cate_name="{$C->product_category_name}" data-product_qty="0">

								{$C->product_category_name}
								(<span class="JSCategoryQtyNum {$C->object_id}" data-tag_name="0">{$SearchValueQTY[$C->object_id|intval][0]|intval}</span>)

							</option>
						{/foreach}

					</select>
					
				</div>
				<div class="sort">
					<dl id="js-sort_buttonList" class="sort_buttonList clearfix">
						<dt class="sort_label">
							<span class="searchRusltNumber JSRealsearchTotal">{$Products->total_no_of_objects|intval}</span> 個腕錶結果
						</dt>
						<dd class="js-sort_button sort_button active"  data-order_by="order_id"><a href="">未指定</a></dd>
						<dd class="js-sort_button sort_button" data-order_by="price_desc"><a href="">高至低</a></dd>
						<dd class="js-sort_button sort_button" data-order_by="price_asc"><a href="">低至高</a></dd>
					</dl>
				</div>

				<div class="js-displayItem mt20">
					<div id="AjaxSearchProductArea" class="columnWrap column2">
						
						<div class="loading"><img src="{$BASEURL}/images/common/loader.gif"></div>
						
						{include file="`$CurrentLang->language_root->language_id`/ajax_product_search.tpl"}
						
					</div>
				</div>

			</section>

		  </div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}