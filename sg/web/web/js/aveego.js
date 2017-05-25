function ReadyFunction(){
	
	$('a.MySubmitButton').click( function(ev) {
		ev.preventDefault();
		if ($(this).attr('target') != '') {
			$('#' + $(this).attr('target')).submit();
		}
	});
	
	$('input').keypress(function(e){
		code= (e.keyCode ? e.keyCode : e.which);
		if (code == 13)
			$(this).closest('form').submit();
	});
	
}

function AjaxProductSearch(){
	
	var PageNo = $("#PageNo").val();
	var GenderSearchValue = $("#GenderSearchValue").val();
	var KudoSearchValue = $("#KudoSearchValue").val();
	var DenpaSearchValue = $("#DenpaSearchValue").val();
	var CaseSearchValue = $("#CaseSearchValue").val();
	var StrapSearchValue = $("#StrapSearchValue").val();
	var WaterResistantSearchValue = $("#WaterResistantSearchValue").val();
	var GlassSearchValue = $("#GlassSearchValue").val();
	var PriceSearchValue = $("#PriceSearchValue").val();
	var FeaturesSearchValue = $("#FeaturesSearchValue").val();
	var OrderBy = $("#OrderBy").val();
	var ProductCategoryID = $("#ProductCategoryID").val();
	
	$('#JSGenderSearch a').addClass('disabled');
	$('#js-search_inputList input').prop("disabled", true);
	$(".js-sort_button").addClass('disabled');
	$("#JSSearchSubmit").addClass('disabled');
	
	$.ajax({
		method: "POST",
		url: BaseURL + "/ajax_product_search.php",
		data: {
			page_no: PageNo,
			product_custom_int_1: GenderSearchValue,
			product_custom_text_1: KudoSearchValue,
			product_custom_text_2: DenpaSearchValue,
			product_custom_text_3: CaseSearchValue,
			product_custom_text_4: StrapSearchValue,
			product_custom_text_5: WaterResistantSearchValue,
			product_custom_text_6: GlassSearchValue,
			product_price:			PriceSearchValue,
			product_features:		FeaturesSearchValue,
			order_by:				OrderBy,
			product_category_id:	ProductCategoryID
		},
		dataType: 'json'
	})
	.done(function( resp ) {
		$('#JSGenderSearch a').removeClass('disabled');
		$('#js-search_inputList input').prop("disabled", false);
		$('.js-sort_button').removeClass('disabled');
		$("#JSSearchSubmit").removeClass('disabled');

		$(".loading").remove();

		$(".JSsearchTotal").html(resp.total_result);
		$(".JSRealsearchTotal").html(resp.real_total_result);

		$(".JSCategoryQtyNum").html("0");
		$.each(resp.search_value_qty, function(key, value){

			var FieldNameKey = key;
			var QtyDataList = value;

			//reset first
			$("." + FieldNameKey).html("0");

			//add value
			$.each(QtyDataList, function(key, value){
				$("." + FieldNameKey + "[data-tag_name='" + key + "']").html(value);
			});

		});
		
		$("#PageNo").attr("data-total_page", resp.total_page);
		
		$(".brand").hide();
		$(".brand[data-brand_name='" + $("input[name='product_category_group']:checked").data("product_category_name") + "']").show();
		$(resp.html).appendTo("#AjaxSearchProductArea")
		$("#AjaxSearchProductArea").fadeIn('slow');

		WatchSearchScrollAction();

	});
	
}

function selectCategoryitemResetHeight(){
	
	tagRect = {t: 8, l: 8, w: 86, h: 60}
	
	var maxHeight = -1;
	$('.js-params').each(function(i){
		if($(this).find('.termsTable_selectCategory_item').length > 0){
			$(this).find('.termsTable_selectCategory_item').each(function(j){
				maxHeight = maxHeight <= j ? j:maxHeight;
				$(this).css({'top': tagRect.t + (tagRect.h + tagRect.t) * j})
			});
		}
	});

	if(maxHeight >= 0)
		$('.termsTable_selectCategory').css({'display':'block', 'height': tagRect.t + (tagRect.h + tagRect.t) * (maxHeight + 1)});

	else
		$('.termsTable_selectCategory').css({'display':'none', 'height': 0});

}

function WatchSearchScrollAction(){
	
	$(window).on('scroll', function() {

		if (MyJS == 'WatchSearch'){

			var footerHeight = $('.footer').outerHeight();
			if($(window).scrollTop() >= $(document).height() - $(window).height() - footerHeight){

//				console.log("Scorll");

				$(window).off('scroll');

				var CurrencyPage = parseInt($("#PageNo").val());
				$("#PageNo").val( CurrencyPage + 1 );
				
				if(parseInt($("#PageNo").val()) <= $("#PageNo").data("total_page")){

					var loadingHTML = '<div class="loading"><img src="' + BaseURL + '/images/common/loader.gif"></div>';
					$(loadingHTML).appendTo( "#AjaxSearchProductArea" );
					$(".loading").show();

					AjaxProductSearch();
				
				}

			}

		}

	});	
	
}

function SubmenuCategoryNameClickAction(){
	
	$(".JsSubmenuClickBtn").on("click", function(ev){
		ev.preventDefault();
		window.location.href = $(this).data("url");
	});
	
}

WatchSearchScrollAction();

$(document).ready(function(){

	ReadyFunction();
	
	SubmenuCategoryNameClickAction();
	
	//For page
	$("#js-megadropWrap li[data-object_link_id='" + ObjLinkID + "']").addClass("active");
	
	if (MyJS == 'ProductRoot') {
		
		$(function() {
			$('.product_name').tile(3);
			$('.product_detail').tile(3);
		});
		
	}
	
	else if (MyJS == 'ProductCategory') {

		$(function() {
		  $('.newsColumnWrap > .column').tile(2);
		  $('.js-slider').bxSlider({
			  pagerCustom: '.js-pager'
		  });
		});
		
	}
	
	else if (MyJS == 'WatchSearch'){
		
		$(".columnWrap.column5").css("opacity", '1');
		
		//Gender Search Action
		$("#JSGenderSearch").on("click", "a", function(ev){
			ev.preventDefault();
			if ($(this).hasClass('disabled'))
				return;
			
			$("#JSGenderSearch li").removeClass("active");
			$(this).parent().addClass("active");
			$("#GenderSearchValue").val($(this).data("value"));
			$("#JSSearchSubmit").trigger("click");
		});
		
		//Search Submit
		$("#JSSearchSubmit").on("click", function(ev){
			ev.preventDefault();
			if ($(this).hasClass('disabled'))
				return;
			
			$("#PageNo").val("1");
			$("#AjaxSearchProductArea").html('');
			
			var loadingHTML = '<div class="loading"><img src="' + BaseURL + '/images/common/loader.gif"></div>';
			$(loadingHTML).appendTo( "#AjaxSearchProductArea" );
			$(".loading").show();
			
			AjaxProductSearch();
		});
		
		//Call condition popup
		$('.js-openModal_inline').magnificPopup({
			type: 'inline',
			midClick: true,
			callbacks: {
				open: function() {
				},
				close: function() {
				}
			}
		});
		
		//Condition popup search submit
		$('.JSSearchConditionOption').on('click', '.js-closeModal', function(ev){
			ev.preventDefault();

			var PopupContainer = $(this).data("parent");
			var TagName = $(this).data("tag_name");
			var ValueInputBox = $(this).data("value_input");
			var SearchVar = "";
			
			if($(".JSSearchConditionOption input:checked").length > 0)
				$(".termsTable_noSelect").hide();
			else
				$(".termsTable_noSelect").show();

			$(TagName).html("");
			
			if($(PopupContainer).find("input:checked").length > 0){
				$(PopupContainer).find("input:checked").each(function(index, value){
					tagTemplate = "";
					tagTemplate += "<li class='termsTable_selectCategory_item'>";
						tagTemplate += "<a href='' class='js-tag' data-inputbox_id='#" + $(this).attr("id") + "'>";
							tagTemplate += "<span>" + $(this).data('tag-name');
							tagTemplate += "</span>";
						tagTemplate += "</a>";
					tagTemplate += "</li>";
					$(tagTemplate).appendTo(TagName);
					SearchVar += "," + $(this).data('value');
				});
				$(ValueInputBox).val(SearchVar);
			}
			else {
				$(ValueInputBox).val("");
			}
			selectCategoryitemResetHeight();
			$.magnificPopup.close();
			return;
		});
		
		//Remove Condition Tag
		$(".js-optionWrap").on("click", ".js-tag", function(ev){
			ev.preventDefault();
			var OptionSelectBox = $(this).data("inputbox_id");
			$(OptionSelectBox).prop("checked", false);
			$(OptionSelectBox).closest(".modalInputList").siblings(".modal_searchButton").find("a").trigger("click");
		});
		
		//Order by option
		$(".js-sort_button").on("click", function(ev){
			ev.preventDefault();
			if ($(this).hasClass('disabled'))
				return;
			
			$(".js-sort_button").removeClass('active');
			$(this).addClass('active');
			$("#OrderBy").val($(this).data("order_by"));
			$("#JSSearchSubmit").trigger("click");
		});
		
		//Product Category 
		$("input[name='product_category_group']").on("change", function(ev){
			ev.preventDefault();
			$("#ProductCategoryID").val($("input[name='product_category_group']:checked").data('product_category_id'));
			$("#JSSearchSubmit").trigger("click");
		});

		//ScrollDisplay.init('');

	}
	
	else if (MyJS == "StoreLocation") {
		
		$('.js-openModal_inline').magnificPopup({
			type: 'inline',
			midClick: true,
			callbacks: {
				open: function(){
					
					var mp = $.magnificPopup.instance,
						t = $(mp.currItem.el[0]);
					$("#address").val( t.data('search_key') );
					//console.log( t.data('search_key') );
					Init();
					UpdateMap();
				},
				close: function(){
				}
			}
		});
		
		$('.search_moreButton-input').on("click", function(){
			$("#StoreLocationSearch").submit();
		});
		
		$('select[name="area_parent_id"]').on("change", function(){
			$.ajax({
				method: "POST",
				url: BaseURL + "/ajax_district_list.php",
				data: { area_parent_id: $(this).val() },
				dataType: 'html'
			})
			.done(function( resp ) {
				$('select[name="area_list_id"]').html( resp );
			});
		});
		
	}
	
	else if (MyJS == "WarrantyRegistration") {
		
		$("#WarrantyRegistrationForm").validate({
			rules: { q1_sex:							{ required: true },
					 q2_age:							{ required: true },
					 q3_education:						{ required: true },
					 q4_occupation:						{ required: true },
					 q5_income:							{ required: true },
					 "q6_reason_pur[]":					{ required: true },
					 q7_location_pur:					{ required: true },
					 "q8_channel_info[]":				{ required: true },
					 "q9_brands_want[]":				{ required: true, minlength: 3 }
			},
			errorPlacement: function( error, element ) {
				$(element).closest("ul").parent().find("div.ErrorBlock").html(error);
			}
		});
		
	}
	
	else if (MyJS == "WarrantyPart2") {
		
		$(".tooltipIMG").tooltip({
			tooltipClass: "CustomTooltip",
			content: function() {
				var element = $( this );
				return "<img src='" + element.data("tipcontent") + "' />";
			}
		});
		
		$("#WarrantyRegistrationForm").validate({
			rules: { case_no_a:							{ required: true },
					 case_no_b:							{ required: true },
					 manu_no:							{ required: true },
					 model_no_a:						{ required: true },
					 model_no_b:						{ required: true },
					 retailer_name:						{ required: true },
					 retailer_reg:						{ required: true },
					 retailer_add:						{ required: true },
					 owner_name:						{ required: true },
					 contact_no:						{ required: true },
					 email_add:							{ required: true, email: true }
			},
			errorPlacement: function( error, element ) {
				
				var NotLiField = [  "case_no_a", "case_no_b", "manu_no", "model_no_a", "model_no_b",
									"retailer_name", "retailer_add", "owner_name"
									, "contact_no", "email_add"
								];
				
				if( $.inArray(element.attr("name"), NotLiField) >= 0 )
					$(element).siblings("div.ErrorBlock").html(error);
				else
					$(element).closest("ul").parent().find("div.ErrorBlock").html(error);

			}
		});
		
		$("#WarranryPrintBtn").click(function(ev){
			ev.preventDefault();
			$("#PrintArea").print();
		});
		
	}
	
	else if (MyJS == "Search") {
		
		$(".SearchPageATag").on("click", function(ev){
			ev.preventDefault();
			$("input[name='page_no']").val( $(this).data("page_no") );
			$("#SearchForm").submit();
		});
		
		$(".search_moreButton-input").on("click", function(ev){
			ev.preventDefault();
			$("#SearchForm").submit();
		});
		
		$("#SearchForm").on("change", "input[name='search_text'],input[name='search_type']", function(){
			$("input[name='page_no']").val("1");
		});
		
	}
	
	else if (MyJS == "WarrantyExcel"){
		
		$("#WarrantyExcelForm").validate({
			rules: { admin_username:					{ required: true },
					 admin_password:					{ required: true }
			}
		});
		
	}
	
});