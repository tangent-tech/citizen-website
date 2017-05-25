{assign var=ClearCache value="?v=10"}
<!doctype html>
<html>
	<head>

		{*ogp*}
		<meta property="og:title" content="{$smarty.const.PAGE_TITLE_NAME}">
		<meta property="og:site_name" content="{$smarty.const.PAGE_TITLE_NAME}">
		<meta property="og:url" content="{$BASEURL}">
		{*
		<meta property="og:image" content="">
		<meta property="og:description" content="">
		*}

		<title>
			{if $ObjectLink->object->object_meta_title|strval|strlen > 0}
				{$ObjectLink->object->object_meta_title|escape:'html'} | {$smarty.const.PAGE_TITLE_NAME}
			{elseif $PageTitle|strval|strlen > 0}
				{$PageTitle|escape:'html'} | {$smarty.const.PAGE_TITLE_NAME}
			{else}
			 	{$smarty.const.PAGE_TITLE_NAME}
			{/if}
		</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="{$ObjectLink->object->object_meta_description|escape:'html'}" />
		<meta name="keywords" content="{$ObjectLink->object->object_meta_keywords|escape:'html'}" />		
		<meta name="title" content="{$ObjectLink->object->object_meta_title|escape:'html'}" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">

		<link rel="image_src" href="" />
		<link rel="shortcut icon" type="image/x-icon" href="{$BASEURL}/favicon.ico"  />

		{*common styles*}
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/base.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/parts.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/jquery.plugins.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/print.css">
		
		{if $MyJS != "ProductCategory" && $MyJS != "Philosophy"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/top.css">
		{/if}

		{if $MyJS == "WatchSearch"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/watchsearch.css">
		{else if $MyJS == "LayoutNewsPage" || $MyJS == "LayoutNews"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/news.css">
		{else if $MyJS == "ProductRoot"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/product.css">
		{else if $MyJS == "ProductCategory"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/xc.css">
		{else if $MyJS == "Product"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles_mobile/product_detail.css">
		{else if $MyJS == "StoreLocation"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/product/slw.css">
		{/if}
		
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/{$CurrentLang->language_root->language_id}_mobile/style.css{$ClearCache}" />

		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-validation-1.13.0/dist/jquery.validate.min.js"></script>
		{*<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-validation-1.13.0/dist/localization/messages_zh_TW.min.js"></script>*}
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/jquery.plugins.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts_mobile/app.js"></script>
		
		{if $MyJS == "WarrantyPart2"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/Print DIV Content using jQuery/jQuery.print.js"></script>
		{/if}
		
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/aveego_mobile.js{$ClearCache}"></script>
		
		<script type="text/javascript">
			var MyJS		= '{$MyJS}';
			var ObjID		= '{$ObjectLink->object->object_id}';
			var ObjLinkID	= '{$ObjectLink->object->object_link_id}';
			var BaseURL		= '{$BASEURL}';
			
		</script>
		
		{if $MyJS != "LayoutNewsPage" && $MyJS != "LayoutNews" && $MyJS != "ProductCategory" && $MyJS != "WatchSearch" && $MyJS != "StoreLocation"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts_mobile/top.js"></script>
		{/if}
		
		{if $MyJS == "ProductCategory"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts_mobile/satellitewave-f900.js{$ClearCache}"></script>
		{else if $MyJS == "Product"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts_mobile/product_detail.js{$ClearCache}"></script>
		{else if $MyJS == "LayoutNewsPage" || $MyJS == "LayoutNews"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts_mobile/news.js{$ClearCache}"></script>
		{else if $MyJS == "StoreLocation"}

			<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={$smarty.const.GOOGLE_MAP_API_KEY}"></script>

			{literal}
			<script>

				var map;

				//Initialize and display a google map
				function Init(){
					// Create a Google coordinate object for where to initially center the map
					var latlng = new google.maps.LatLng( 22.30305, 114.17192 );	// Washington, DC

					// Map options for how to display the Google map
					var mapOptions = { zoom: 12, center: latlng  };

					// Show the Google map in the div with the attribute id 'map-canvas'.
					map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				}
				
				// Update the Google map for the user's inputted address
				function UpdateMap() {
					var geocoder = new google.maps.Geocoder();    // instantiate a geocoder object

					// Get the user's inputted address
					var address = document.getElementById( "address" ).value;

					// Make asynchronous call to Google geocoding API
					geocoder.geocode( { 'address': address }, function(results, status) {
						if ( status == google.maps.GeocoderStatus.OK ) {
							var i = results.length - 1;
							var addr_type = results[i].types[0];	// type of address inputted that was geocoded
							ShowLocation( results[i].geometry.location, address, addr_type );
						}
						else     
							alert("Geocode was not successful for the following reason: " + status);        
					});
				}

				// Show the location (address) on the map.
				function ShowLocation( latlng, address, addr_type ){
					// Center the map at the specified location
					map.setCenter( latlng );

					// Set the zoom level according to the address level of detail the user specified
					var zoom = 17;
					map.setZoom( zoom );

					// Place a Google Marker at the same location as the map center 
					// When you hover over the marker, it will display the title
					var marker = new google.maps.Marker( { 
						position: latlng,     
						map: map,      
						title: address
					});

					// Create an InfoWindow for the marker
					var contentString = "" + address + "";	// HTML text to display in the InfoWindow
					var infowindow = new google.maps.InfoWindow( { content: contentString } );

					// Set event to display the InfoWindow anchored to the marker when the marker is clicked.
					google.maps.event.addListener( marker, 'click', function() { infowindow.open( map, marker ); });
				}

			</script>
			{/literal}

		{/if}
		
	</head>

	<body>
		
		{if $smarty.const.IS_LOCAL && !$smarty.const.HIDE_SESSION_DEBUG}
			{*<div class="LocalTest">LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV</div>*}
		{/if}
		{literal}
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-88633725-1', 'auto');
			  ga('send', 'pageview');

			</script>
		{/literal}

		<div class="header">
			<header role="banner">
				<p class="header_logo">
					<a href="{$BASEURL}/index.php">CITIZEN BETTER STARTS NOW</a>
				</p>
				<div class="header_func">
					<p class="header_search">
						<a href="javascript:;" class="js-expandSearch">
							<img src="{$BASEURL}/images_mobile/common/icon_search_02.png" width="16" height="17" alt="">
						</a>
					</p>
					<p class="gnavi_toggle js-drawerBtn">
					  <a href="javascript:;" class=""><span>MENU</span></a>
					</p>
				</div>
				<div class="drawerWrap js-drawerPanel">
					<div class="drawerInner" id="iscwrapper">
						<div class="isc">
							<p class="btn_01 watchsearch">
								<a href="{GetSeoUrl($smarty.const.SEARCH_PAGE_LINK_ID)}">
									<span>Watch Search</span>
								</a>
							</p>
							<nav>

								<ul class="drawerNavList accordion">
									
									{foreach $TopMenu->object->objects->object as $O}
									
										<li class="js-accordionWrap">
											
											{if $O->object_type == "PRODUCT_ROOT_LINK"}
												<p class="js-accordionTrigger accordionTrigger">
													<a href="">{$O->object_name}</a>
												</p>
												<div class="js-accordionTarget">
													<div class="accordion_detail">
														<ul>
															{foreach $O->objects->object as $productCat}
																<li><a href="{$productCat->object_seo_url}">{$productCat->object_name}</a></li>
															{/foreach}
															<li><a href="{GetSeoUrl($smarty.const.PRODUCT_ROOT_LINK_ID)}">Products</a></li>
														</ul>
													</div>
												</div>
														
											{else if $O->object_type == "PAGE" && $O->object_details->page->layout->layout_name == "PopupLink"}

												{assign var=LinkURL value=$O->object_details->page->layout->block_defs->block_def[1]->block_contents->block[0]->block_content|strval}
												<a href="{$LinkURL}" target="_blank">{$O->object_name}</a>
														
											{else}
												<a href="{$O->object_seo_url}">{$O->object_name}</a>
											{/if}

										</li>
									
									{/foreach}

								</ul>
								<div class="drawerBtnWrap">
									
									{*
									<div class="drawerBtnBlock">
										<p class="mb10">シチズン歴代モデル</p>
										<p class="btn_01 citizen">
											<a href="/s/locus/index.html"><span>シチズンのキセキ</span></a>
										</p>
									</div>
									*}

									<div class="drawerBtnBlock">
										<p class="mb10">Citizen Watch Official</p>
										<ul>
											{foreach $FooterSocialLink as $FS}
												<li class="btn_01 sns">
													<a href="{$FS->block_link_url}" target="_blank">
														<span>{$FS->object_name}</span>
														<img src="{$BASEURL}/images_mobile/common/icon_brank_03.png" width="13" height="12" alt="" class="icon_brank_01">
													</a>
												</li>
											{/foreach}
										</ul>
									</div>
									{*
									<div class="drawerBtnBlock">
										<p class="btn_01 global">
											<a href="http://www.citizenwatch-global.com/s/index.html" target="_blank">
												<span>GLOBAL</span>
												<img src="{$BASEURL}/images_mobile/common/icon_brank_01.png" width="13" height="12" alt="" class="icon_brank_01">
											</a>
										</p>
									</div>
									*}

									<!-- <div class="drawerBtnBlock">
										<p class="btn_01 global">
											<a href="{$LangSwitchURLList[2]}">中文</a>
										</p>
									</div> -->
									<!-- <div class="drawerBtnBlock">
										<p class="btn_01 global">
											<a href="{$LangSwitchURLList[1]}">Eng</a>
										</p>
									</div> -->
									
								</div>

							</nav>
						</div>
					</div>
				</div>
			</header>
		</div>

		<div class="js-searchPanel">
			<div class="headerSearchWrap">
				
				{*
				<form id="SiteSearch" action="{$BASEURL}/search.php" method="GET">
					<fieldset>
						<legend>Site Search</legend>
						<input type="text" class="header_search_input" value="{$smarty.request.search_text}" name="search_text" id="MF_form_phrase"/>
						<a class="header_search_submit MySubmitButton" href="" target="SiteSearch">
							<img src="{$BASEURL}/images/common/icon_search_01.png" alt="Search"/>
						</a>
					</fieldset>
				</form>
				*}
				
				<form id="SiteSearch" action="{$BASEURL}/search.php" method="GET">
					<ul class="search_itemList">
						<li class="search_item">
							<ul class="search_kwButtonList">
								<li class="search_kwButtonList_item">
									<input type="text" class="search_kwText" name="search_text" value="{$smarty.request.search_text}">
								</li>
								<li class="search_kwButtonList_item">
									<input type="submit" value="Search" class="search_moreButton">
								</li>
							</ul>
						</li>
					</ul>
				</form>

			</div>
		</div>