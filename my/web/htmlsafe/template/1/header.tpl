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
		<meta name="viewport" content="width=1040">
		
		<!-- <link rel="image_src" href="" /> -->
		<link rel="icon" type="image/x-icon" href="{$BASEURL}/favicon.ico"  />

		{*common styles*}
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/base.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/parts.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/jquery.plugins.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/print.css">

		{if $MyJS != "ProductCategory" && $MyJS != "Philosophy"}
			<link rel="stylesheet" href="{$BASEURL}/css/top.css">
		{/if}
		
		{if $MyJS == "Philosophy"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/philosophy.css">
		{else if $MyJS == "Technology"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/technology_detail.css">
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/technology.css">
		{else if $MyJS == "WatchSearch"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/watchsearch.css">
		{else if $MyJS == "LayoutNewsPage" || $MyJS == "LayoutNews"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/news.css">
		{else if $MyJS == "ProductRoot"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/product.css">
		{else if $MyJS == "ProductCategory"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/product/satellitewave-f900.css">
		{else if $MyJS == "Product"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/product/slw.css">
		{else if $MyJS == "StoreLocation"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/styles/product/slw.css">
		{else if $MyJS == "WarrantyPart2"}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
		{/if}
		
		<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/{$CurrentLang->language_root->language_id}/style.css{$ClearCache}" />

		{if $smarty.const.IsIOS == 1}
			<link rel="stylesheet" type="text/css" media="screen" href="{$BASEURL}/css/ios.css"/>
		{/if}

		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-validation-1.13.0/dist/jquery.validate.min.js"></script>
		{*<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/jquery-validation-1.13.0/dist/localization/messages_zh_TW.min.js"></script>*}
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/jquery.plugins.js"></script>
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/app.js{$ClearCache}"></script>
		{if $MyJS == "WarrantyPart2"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/Print DIV Content using jQuery/jQuery.print.js"></script>
		{/if}
		<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/aveego.js{$ClearCache}"></script>

		<script type="text/javascript">
			var MyJS		= '{$MyJS}';
			var ObjID		= '{$ObjectLink->object->object_id}';
			var ObjLinkID	= '{$ObjectLink->object->object_link_id}';
			var BaseURL		= '{$BASEURL}';
			
		</script>
		{literal}
		<script type="text/javascript">
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-96774824-1', 'auto');
			ga('send', 'pageview');

		</script>
		{/literal}

		
		{if $MyJS != "LayoutNewsPage" && $MyJS != "LayoutNews"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/top.js"></script>
		{/if}
		
		{if $MyJS == "Product"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/zoom.js"></script>
		{else if $MyJS == "LayoutNewsPage" || $MyJS == "LayoutNews"}
			<script type="text/javascript" charset="utf-8" src="{$BASEURL}/js/scripts/news.js"></script>
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
			<div class="LocalTest">LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV LOCAL ENV</div>
		{else if $smarty.const.ENV == "DEV"}
			<!-- <div class="LocalTest">DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV DEV ENV </div> -->
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
		
		{*Header*}
		<div class="header">
			<header role="banner">
				<div class="header_inner">

					<div id="js-gnavi" class="gnavi">
						<div class="gnavi_inner">
							<nav role="navigation">
								<ul id="js-megadropWrap" class="clearfix">
									{$HeaderMainMenuRaw}

									{*Language Bar*}
									<li class="gnavi_item LanguageBar">
										<a href="{$LangSwitchURLList[1]}"></a>
									</li>
									
								</ul>
							</nav>
						</div>
					</div>

					<div class="header_search">
						<form id="SiteSearch" action="{$BASEURL}/search.php" method="GET">
							<fieldset>
								<legend>Site Search</legend>
								<input type="text" class="header_search_input" value="{$smarty.request.search_text}" name="search_text" id="MF_form_phrase"/>
								<a class="header_search_submit MySubmitButton" href="" target="SiteSearch">
									<img src="{$BASEURL}/images/common/icon_search_01.png" alt="Search"/>
								</a>
							</fieldset>
						</form>
					</div>

					<div class="narrow_menu gnav_item">
						<p><a href="javascript:;">MENU</a></p>
					</div>

				</div>
			</header>
		</div>
								
		{*Breadcrumb*}
		{if $MyJS != "Index" && $MyJS != "ProductRoot"}
			<div class="breadcrumb">
				<ul itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="{$BASEURL}/index.php"><span itemprop="name">HOME</span></a>
						<meta itemprop="position" content="1" />
					</li>
					{if $ObjectLink->object->object_type == "PAGE"}

						{assign var=PrintBreadcrumb value=false}
						{foreach $ObjectLinkPath->objects->object as $OP}
							{if $PrintBreadcrumb}
								<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<span itemprop="name">{$OP->object_name}</span>
									<meta itemprop="position" content="2" />
								</li>
							{/if}
							{if $OP->object_id|intval == $smarty.const.TOP_MENU_FOLDER_ID}
								{assign var=PrintBreadcrumb value=true}
							{/if}
						{/foreach}
						
					{else if $ObjectLink->object->object_type == "PRODUCT"}
		
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<a itemprop="item" href="{$BASEURL}{$ProductRootLink->product_category->object_seo_url}">
								<span itemprop="name">{$ProductRootLink->product_category->object_name}</span>
							</a>
							<meta itemprop="position" content="1" />
						</li>
						{foreach $ProductCatPath->product_categories->product_category as $PC}
							{if $PC->product_category_name != ""}
								<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a itemprop="item" href="{$BASEURL}{$PC->object_seo_url}">
										<span itemprop="name">{$PC->product_category_name}</span>
									</a>
									<meta itemprop="position" content="1" />
								</li>
							{/if}
						{/foreach}
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<span itemprop="name">{$Product->product->product_code}</span>
							<meta itemprop="position" content="2" />
						</li>
						
					{else if $ObjectLink->object->object_type == "PRODUCT_CATEGORY"}
						
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<a itemprop="item" href="{$BASEURL}{$ProductRootLink->product_category->object_seo_url}">
								<span itemprop="name">{$ProductRootLink->product_category->object_name}</span>
							</a>
							<meta itemprop="position" content="1" />
						</li>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<span itemprop="name">{$ProductCategory->product_category->product_category_name}</span>
							<meta itemprop="position" content="2" />
						</li>
						
					{else if $MyJS == "LayoutNewsPage"}
						
						{if $NewsList->object_link_id|intval == $smarty.const.IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID}
							
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsInfo->object_seo_url}">
									<span itemprop="name">{$NewsInfo->object_name}</span>
								</a>
								<meta itemprop="position" content="1" />
							</li>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<span itemprop="name">{$ImportantNotices->object_name}</span>
								<meta itemprop="position" content="2" />
							</li>
							
						{else}
							
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsList->object_seo_url}">
									<span itemprop="name">{$NewsList->object_name}</span>
								</a>
								<meta itemprop="position" content="1" />
							</li>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<span itemprop="name">{$smarty.request.year}</span>
								<meta itemprop="position" content="2" />
							</li>
							
						{/if}
						
					{else if $MyJS == "LayoutNews"}
						
						{if $NewsList->object_link_id|intval == $smarty.const.IMPORTANT_NOTICES_LAYOUT_NEWS_ROOT_LINK_ID}
							
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsInfo->object_seo_url}">
									<span itemprop="name">{$NewsInfo->object_name}</span>
								</a>
								<meta itemprop="position" content="1" />
							</li>
							{*Important Notices*}
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsList->object_seo_url}">
									<span itemprop="name">{$NewsList->object_name}</span>
								</a>
								<meta itemprop="position" content="2" />
							</li>
							
						{else}
							
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsList->object_seo_url}">
									<span itemprop="name">{$NewsList->object_name}</span>
								</a>
								<meta itemprop="position" content="1" />
							</li>
							<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
								<a itemprop="item" href="{$BASEURL}{$NewsList->object_seo_url}?year={$smarty.request.year}">
									<span itemprop="name">{$smarty.request.year}</span>
								</a>
								<meta itemprop="position" content="2" />
							</li>
							
						{/if}
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<span itemprop="name">{$LayoutNews->layout_news->layout_news_title}</span>
							<meta itemprop="position" content="3" />
						</li>
						
					{else if $MyJS == "Search"}
						
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<span itemprop="name">Search results 「{$smarty.request.search_text}」</span>
						</li>

					{/if}

				</ul>
			</div>
		{/if}
