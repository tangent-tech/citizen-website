<?php

die("EXIT");

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');
require_once('content_common.php');

$ProductCategory = ApiQuery('product_category_info.php', __LINE__,
							'link_id=' . PRODUCT_ROOT_LINK_ID .
							'&page_no=' . 1 .
							'&products_per_page=' . 9999 .
							'&security_level=' . 0 . 
							'&lang_id=' . $CurrentLang->language_root->language_id .
							'&currency_id=' . $CurrentCurrency->currency->currency_id .
							'&category_order_by=order_id' .
							'&category_order_type=ASC'
							,false, true
							);

die("For Insert Store Location");

?>
<script type="text/javascript" charset="utf-8" src="<?=BASEURL ?>/js/jquery-1.11.1.min.js"></script>
<script>
	
	function addslashes(string) {
		return string.replace(/\\/g, '\\\\').
			replace(/\u0008/g, '\\b').
			replace(/\t/g, '\\t').
			replace(/\n/g, '\\n').
			replace(/\f/g, '\\f').
			replace(/\r/g, '\\r').
			replace(/'/g, '\\\'').
			replace(/"/g, '\\"');
	}
	
	$(document).ready(function(){
		var ParentID = 6;
		/*
		var CityNameTC = [];
		$("select[name='NT_TC'] option").each(function(){
			var temp = [];
			temp['name_tc'] = $(this).html();
			CityNameTC[ $(this).val() ] = temp;
		});
		var CityName = [];
		$("select[name='NT_EN'] option").each(function(){
			var temp = [];
			temp['id'] = $(this).val();
			temp['name_en'] = $(this).html();
			temp['name_tc'] = CityNameTC[ $(this).val() ].name_tc;
			CityName.push( temp );
		});

		$.each(CityName, function(index, value){
			var EchoText = "";
			EchoText = " INSERT INTO area_list SET area_list_id = '" + value.id + "', area_parent_id ='" + ParentID + "',";
			EchoText += " area_name_en = '" + value.name_en + "', area_name_tc = '" + value.name_tc + "';<br/>";
			$("#EchoContent").append( EchoText );
		});
		*/
	   
	   //Store
		$(".sub_header").remove();
		var TargetIDEN = "#MCEN";
		var TargetIDTC = "#MCTC";

		console.log("TC Num:" + $(TargetIDTC).find("table").find("table").length);
		console.log("EN Num:" + $("#TargetIDEN").find("table").find("table").length);
		
		var StoreTC = [];
		$(TargetIDTC).find("table").find("table").each(function(){
			//console.log( $(this).find("h2").html() );
			$(this).find("tr[valign='top']").each(function(){
				var temp = [];
				temp['name_tc']			= $(this).find("td[width='210']").html();
				temp['tel_no']			= $(this).find("td[width='100']").html();
				temp['address_tc']		= $(this).find("td[width='335']").html();
				StoreTC[ $(this).find("td[width='100']").html() ] = temp;
			});		
		});
		
		var Store = [];
		$(TargetIDEN).find("table").find("table").each(function(){
			
//			/console.log( $(this).find("h2").html() );
			var TdChild = $(this).find("tr[valign='top']");
			
			//Get Area ID
			var area_list_id = 0;
			$.ajax({
				method: "POST",
				url: "http://localhost:8888/devcitizen.eksx.com/web/test_get_area.php",
				data: { area_name_en: $(this).find("h2").html() },
				dataType: 'json'
			}).done(function( resp ){
				area_list_id = resp.id;
				console.log(area_list_id);
				TdChild.each(function(){
					var temp = [];
					temp['area_list_id']	= area_list_id;
					temp['name_en']			= $(this).find("td[width='210']").html();
					temp['tel_no']			= $(this).find("td[width='100']").html();
					temp['address_en']		= $(this).find("td[width='335']").html();
					temp['name_tc']			= StoreTC[ temp['tel_no'] ].name_tc;
					temp['address_tc']		= StoreTC[ temp['tel_no'] ].address_tc;

					EchoText = " INSERT INTO store_location SET area_list_id = '" + temp.area_list_id + "', store_location_name_en ='" + addslashes(temp.name_en) + "',";
					EchoText += " store_location_name_tc = '" + addslashes(temp.name_tc) + "', store_location_address_en = '" + addslashes(temp.address_en) + "', ";
					EchoText += " store_location_address_tc = '" + addslashes(temp.address_tc) + "', store_location_tel_no = '" + addslashes(temp.tel_no) + "';<br/>";
					console.log(EchoText);
					console.log("------------------------------------");
					$("#EchoContent").append( EchoText );

					Store.push( temp );
				});		
				//console.log(Store);
				//console.log("------------------------------------");
			});

		});
		
	});
</script>

<div id="EchoContent">
</div>

<!-- Kowloon -->
<!--
<select name="KowloonCityEN" class="">
<option value="77"></option><option value="73"></option><option value="76"></option><option value="25">Diamond Hill</option><option value="17">Hung Hom</option><option value="68">Jordan</option><option value="53">Kowloon Bay</option><option value="63">Kowloon City</option><option value="22">Kowloon Tong</option><option value="28">Kwun Tong</option><option value="74">Lai Chi Kok</option><option value="72">Lam Tin</option><option value="58">Lok Fu</option><option value="21">Mei Foo</option><option value="19">Mongkok</option><option value="27">Ngau Tau Kok</option><option value="75">Prince Edward</option><option value="23">San Po Kong</option><option value="47">Sau Mau Ping</option><option value="20">Sham Shui Po</option><option value="78">Tai Kok Tsui</option><option value="16">Tsim Sha Tsui</option><option value="26">Tsz Wan Shan</option><option value="24">Wong Tai Sin</option><option value="18">Yau Ma Tei</option><option value="71">Yau Tong</option></select>
<select name="KowloonCityTC" class="">
<option value="74"></option><option value="75"></option><option value="78"></option><option value="63">九龍城</option><option value="22">九龍塘</option><option value="53">九龍灣</option><option value="68">佐敦</option><option value="77">大角咀</option><option value="76">太子</option><option value="16">尖沙咀</option><option value="26">慈雲山</option><option value="23">新蒲崗</option><option value="19">旺角</option><option value="58">樂富</option><option value="71">油塘</option><option value="18">油麻地</option><option value="20">深水埗</option><option value="27">牛頭角</option><option value="47">秀茂坪</option><option value="17">紅磡</option><option value="21">美孚</option><option value="73">荔枝角</option><option value="72">藍田</option><option value="28">觀塘</option><option value="25">鑽石山</option><option value="24">黃大仙</option></select>
-->

<!-- Hong Kong -->
<!--
<select name="HonKongEN" class=""><option value="14">Aberdeen</option><option value="43">Causeway Bay</option><option value="8">Central</option><option value="12">North Point</option><option value="7">Sheung Wan</option><option value="15">Stanley</option><option value="13">Tai Koo Shing</option><option value="10">Wanchai</option></select>
<select name="HonKongTC" class=""><option value="7">上環</option><option value="8">中環</option><option value="12">北角</option><option value="13">太古城</option><option value="10">灣仔</option><option value="15">赤柱</option><option value="43">銅鑼灣</option><option value="14">香港仔</option></select>
-->

<!-- NT -->
<!--
<select name="NT_EN" class=""><option value="38">Fanling</option><option value="31">Kwai Chung</option><option value="30">Kwai Fong</option><option value="35">Ma On Shan</option><option value="34">Shatin</option><option value="37">Sheung Shui</option><option value="70">Tai Po</option><option value="36">Tai Wai</option><option value="41">Tin Shui Wai</option><option value="29">Tseung Kwan O</option><option value="33">Tsing Yi</option><option value="32">Tsuen Wan</option><option value="39">Tuen Mun</option><option value="66">Tung Chung</option><option value="40">Yuen Long</option></select>
<select name="NT_TC" class=""><option value="37">上水</option><option value="40">元朗</option><option value="36">大圍</option><option value="70">大埔</option><option value="41">天水圍</option><option value="29">將軍澳</option><option value="39">屯門</option><option value="66">東涌</option><option value="34">沙田</option><option value="38">粉嶺</option><option value="32">荃灣</option><option value="31">葵涌</option><option value="30">葵芳</option><option value="33">青衣</option><option value="35">馬鞍山</option></select>
-->
	
<!-- Kowloon -->
<!--
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="KowloonStoreEN">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tsim Sha Tsui</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Astor Watch Co.</td>
                              <td width="100">2366 4649</td>
                              <td width="335">G/F, Mirador Mansion, 37 Nathan Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Australia Watch &amp; Jewellery Co.</td>
                              <td width="100">2722 1338</td>
                              <td width="335">G/F, Mirador Mansion, 39 Nathan Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Classicalarts Jewellery Watch Co.</td>
                              <td width="100">2735 0936</td>
                              <td width="335">Shop G12, G/F., Star House, 3 Salisbury Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Fine Asia Watch (H.K.) Co., Ltd.</td>
                              <td width="100">3911 1965</td>
                              <td width="335">Shop 17, 1/F, Sogo Tsimshatsui Store, 20 Nathan Road, Tsimshatsui, Kowloon.</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Geneve Watch</td>
                              <td width="100">2312 0182</td>
                              <td width="335">G/F, 64B, Nathan Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Global Watch and Jewelry</td>
                              <td width="100">2885 6666</td>
                              <td width="335">BLK B, 1/F, Hankow Apartments, 43-49 Hankow Road,Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Harry Lee Co.</td>
                              <td width="100">2366 0093</td>
                              <td width="335">G/F, 42 Hankow Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">In Watch &amp; Jewelry</td>
                              <td width="100">2312 1663</td>
                              <td width="335">Shop 1B-1C, WK SQUARE Basement, Chungking Mansions, 36-44 Nathan Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Life Time Watch Co., Ltd.</td>
                              <td width="100">2367 2369</td>
                              <td width="335">G/F, 12D Carnarvon Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">New Grand Jewellery &amp; Watch Co., Ltd.</td>
                              <td width="100">2368 8412</td>
                              <td width="335">Shop B, Metropole Building, 53-63 Peking Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">3428 3038</td>
                              <td width="335">Shop 57, UG/F, China Hong Kong City, 33 Canton Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">TWI Duty Free Shop</td>
                              <td width="100">2723 9911</td>
                              <td width="335">Shop A, G/F &amp; 1/F, Railway Plaza, No.39 Chatham Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tycoon</td>
                              <td width="100">3963 9100</td>
                              <td width="335">Shop 9B &amp;10B on G/F &amp; Upper Basement, New Mandarin Plaza, 14 Science Museum Road, Tsim Sha Tsui </td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Wah Hing Co.</td>
                              <td width="100">2368 5867</td>
                              <td width="335">Shop 3-97A-C, 2/F, Chungking Express, 36-44 Nathan Road, Tsim Sha Tsui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Woo Ping Company</td>
                              <td width="100">2739 2238</td>
                              <td width="335">Shop G-22 Site D, G/FL, Park Lane Shopper's Boulevard, Tsim Sha Tsui</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Hung Hom</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Far East Jewellery Holding Ltd.</td>
                              <td width="100">2368 9298</td>
                              <td width="335">No.6. 716-718, Level 7, Fortune Metropolis, No.6 Metropolis Drive, Hung Hom, Kowloon</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">PDW</td>
                              <td width="100">2187 2485</td>
                              <td width="335">G3A &amp; B, G/F, Phase 7, Whampoa Garden, Hung Hom</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Wing Fat Watch Co.</td>
                              <td width="100">2333 9677</td>
                              <td width="335">No. 52 Wuhu Street Ground, Hung Hom</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Ying Kwong Watch Co.</td>
                              <td width="100">2765 6234</td>
                              <td width="335">Shop G64, Hung Hom Square, 37-39 Ma Tau Wai Road, Hung Hom</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Mongkok</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210"> Time 2</td>
                              <td width="100">2384 6073</td>
                              <td width="335">Shop No.11, B/F., 580A Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210"> Time 2</td>
                              <td width="100">2396 2919</td>
                              <td width="335">Shop F115, 1/F., Comm.Podium, Sincere House, 83 Argyle Street, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Future Time Co.</td>
                              <td width="100">2136 8467</td>
                              <td width="335">Shop 9-10, 1/F, Trendy Zone, Chau Tai Fook Centre, 580A Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Grace Clock &amp; Watch Co.</td>
                              <td width="100">2380 7802</td>
                              <td width="335">Shop F11, 1/F, Commerical Podium, Sincere House, 83 Argyle Street, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">In Time Watch Company</td>
                              <td width="100">5372 0757</td>
                              <td width="335">Unit 17B/G, Yan On Building, 1 Kwong Wa Street, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">In Watch</td>
                              <td width="100">2388 9963</td>
                              <td width="335">Shop G21-22, G/F, Sino Centre, 582-592 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kowloon Watch Co., Ltd.</td>
                              <td width="100">2381 0962</td>
                              <td width="335">G/F, 256 Sai Yeung Choi Street, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Kowloon Watch Co., Ltd.</td>
                              <td width="100">2789 3011</td>
                              <td width="335">G/F, Oriental House, No. 24-26, Argyle Street, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Lucky Watch</td>
                              <td width="100">2770 0277</td>
                              <td width="335">No. 4, G/F, Trade &amp; Industry Department Tower, 700 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Midpoint Time Co.</td>
                              <td width="100">2136 6838</td>
                              <td width="335">Shop 26, 1/F, Trendy Zone, Chau Tai Fook Centre, 580A Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Mong Kok Watch Co., Ltd.</td>
                              <td width="100">2787 6632</td>
                              <td width="335">Shop 15, G/F, Trade and Industry Department Tower, 700 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time 2</td>
                              <td width="100">2393 8070</td>
                              <td width="335">Shop No.149, 1/F., Argyle Centre, Phase 1, 688 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Focus</td>
                              <td width="100">2332 9500</td>
                              <td width="335">Shop 20, 1/F, Trendy Zone, Chau Tai Fook Centre, 580A Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time For You</td>
                              <td width="100">2740 9068</td>
                              <td width="335">Shop 33, G/F, Sino Centre, 582-592 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Super Co.</td>
                              <td width="100">2384 0768</td>
                              <td width="335">Shop G35, G/F, Sino Centre, 582-592 Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Valuable Watch and Jewellery Ltd.</td>
                              <td width="100">2891 6682</td>
                              <td width="335">Unit G8A, G/F, Sun Hing Building, 603-609A Nathan Road, Mongkok</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Wing Cheung Watch Co.</td>
                              <td width="100">2381 8487</td>
                              <td width="335">Shop G01B, Allied Plaza, 760 Nathan Road, Mongkok </td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Yau On Watch Shop</td>
                              <td width="100">2384 4854</td>
                              <td width="335">G/F, 425 Shanghai Street, Mongkok</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Sham Shui Po</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kwong Sang Watch Co.</td>
                              <td width="100">2386 5863</td>
                              <td width="335">G/F, 93 Tai Po Road, Sham Shui Po</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Sun Hai Jewellery &amp; Goldsmith Co., Ltd.</td>
                              <td width="100">2386 8554</td>
                              <td width="335">G/F, 100-102 Pei Ho Street, Sham Shui Po, Kowloon</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Shop</td>
                              <td width="100">2708 7633</td>
                              <td width="335">Shop 140-B, Level 1, Dragon Centre, 37K Yen Chow Street, Sham Shui Po</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Wah Sang Watch Co.</td>
                              <td width="100">2708 2891</td>
                              <td width="335">Shop K-1, Golden Computer Centre, 146-152 Fuk Wa Street, Sham Shui po</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Kowloon Tong</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2265 8820</td>
                              <td width="335">Shop 15, L1, Festival Walk, Kowloon Tong</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>San Po Kong</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Wing Hing Watch &amp; Clock Co.</td>
                              <td width="100">2322 3827</td>
                              <td width="335">No. H, Hong King Arcade, 28 Hong Keung Street, San Po Kong</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Diamond Hill</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2110 1510</td>
                              <td width="335">Shop106-107, 1/F, Plaza Hollywood, Diamond Hill</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Watches Watch Co.</td>
                              <td width="100">2110 0699</td>
                              <td width="335">Shop 330-A, Level 3, Plaza Hollywood, Diamond Hill</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tsz Wan Shan</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Grace Clock &amp; Watch Co.</td>
                              <td width="100">2321 5730</td>
                              <td width="335">G/F, 47-A Po Kong Village Road, Fung Wong Village, Tsz Wan Shan</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Ngau Tau Kok</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Champion Watches</td>
                              <td width="100">2796 7879</td>
                              <td width="335">Shop 29-30, 1/F, Phase 1, Amoy Plaza, Ngau Tau Kok</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Kwun Tong</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kowloon Watch Co., Ltd.</td>
                              <td width="100">2343 8315</td>
                              <td width="335">G/F, 23 Mut Wah Street, Kwun Tong</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">The Grand Mall</td>
                              <td width="100">2112 9696</td>
                              <td width="335">Shop B, G/F, Kwun Tong Harbour Plaza, 182 Wai Yip Street, Kwun Tong</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Trendy O’clock Company</td>
                              <td width="100">2357 0268</td>
                              <td width="335">Flat O, 1/F, Camelpaint Building, Block 3, 60 Hoi Yuen Road, Kwun Tong, Kowloon</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Sau Mau Ping</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">28 Watch</td>
                              <td width="100">2354 8899</td>
                              <td width="335">Rm118, 1/F, Sau Mau Ping Shopping Centre, Sau Mau Ping</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Kowloon City</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Basel (Switzerland) Watches Limited</td>
                              <td width="100">2356 8288</td>
                              <td width="335">1/F, 83 Sa Po Road, Kowloon City, Kowloon</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Yau Tong</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Seevers Watch Co.</td>
                              <td width="100">3526 1509</td>
                              <td width="335">Shop No.146, 1/F, Lei Yue Muk Plaza, 80 Lei Yue Mun Road, Yau Tong</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Watch Out</td>
                              <td width="100">2776 9222</td>
                              <td width="335">G16A, G/F, Domain, 38 Ko Chiu Road, Yau Tong</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Lam Tin</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Seevers Watch Co.</td>
                              <td width="100">2349 6732</td>
                              <td width="335">Shop 313, Kai Tin Shopping Centre, Kai Tin Estate, Lam Tin</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Seevers Watch Co.</td>
                              <td width="100">2717 0800</td>
                              <td width="335">Shop 310, Tak Tin Shopping Centre, Tak Tin Estate, Lam Tin</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Prince Edward</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Shui Cheong Watch Company Ltd</td>
                              <td width="100">2381 4223</td>
                              <td width="335">No. 157 Prince Edward Road West, Kowloon</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tai Kok Tsui</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Shop</td>
                              <td width="100">2686 9839</td>
                              <td width="335">Shop 22, G/F, New Kowloon Plaza, 38 Tai Kok Tsui Road, Kowloon</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" id="KowloonStoreTC">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>尖沙咀</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Geneve Watch</td>
                              <td width="100">2312 0182</td>
                              <td width="335">尖沙咀彌敦道地下64B舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">In Watch &amp; Jewelry</td>
                              <td width="100">2312 1663</td>
                              <td width="335">尖沙咀彌敦道36-44號重慶大廈地庫WK SQUARE 1B-1C店</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">3428 3038</td>
                              <td width="335">尖沙咀廣東道33號中港城UG層57號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">典藝珠寶鐘錶公司</td>
                              <td width="100">2735 0936</td>
                              <td width="335">尖沙咀梳士巴利道3號星光行地舖G12</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">和平公司</td>
                              <td width="100">2739 2238</td>
                              <td width="335">尖沙咀彌敦道131號柏麗大道G22號D座地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">夏利表行</td>
                              <td width="100">2366 0093</td>
                              <td width="335">尖沙咀漢口道42號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">御錶城</td>
                              <td width="100">3963 9100</td>
                              <td width="335">尖沙咀科學館道14號新文華中心9B-10B及地庫</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新達利珠寶鐘錶</td>
                              <td width="100">2368 8412</td>
                              <td width="335">尖沙咀北京道53-63號國都大廈B舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時計寶(香港)名錶店</td>
                              <td width="100">2723 9911</td>
                              <td width="335">尖沙咀漆咸道南39號鐵路大廈地下A及一樓全層</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">澳洲表行</td>
                              <td width="100">2722 1338</td>
                              <td width="335">尖沙咀彌敦道39號美麗都大廈地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">瑞聯錶行(香港)有限公司</td>
                              <td width="100">3911 1965</td>
                              <td width="335">九龍尖沙咀彌敦道20號祟光百貨一樓17號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">環球鐘錶珠寶</td>
                              <td width="100">2885 6666</td>
                              <td width="335">尖沙咀漢口道43-49號漢口大廈一樓B店</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">華興公司</td>
                              <td width="100">2368 5867</td>
                              <td width="335">尖沙咀彌敦道36-44號重慶站2字樓3-97ABC舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">蘭宮表行</td>
                              <td width="100">2366 4649</td>
                              <td width="335">尖沙咀彌敦道37號美麗都大廈地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">麗光表行</td>
                              <td width="100">2367 2369</td>
                              <td width="335">尖沙咀加拿芬道12D號地下</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>紅磡</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">榮發表行</td>
                              <td width="100">2333 9677</td>
                              <td width="335">紅磡蕪湖街52號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">英光錶行</td>
                              <td width="100">2765 6234</td>
                              <td width="335">紅磡馬頭圍道37-39號紅磡商場地下G64號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">遠東珠寶集團有限公司</td>
                              <td width="100">2368 9298</td>
                              <td width="335">九龍紅磡都會道6號置富都會7樓716-178號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">鑽表城</td>
                              <td width="100">2187 2485</td>
                              <td width="335">紅磡黃埔花園7期地弄3A及B</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>旺角</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Future Time Co.</td>
                              <td width="100">2136 8467</td>
                              <td width="335">旺角彌敦道580A號周大福商業中心潮流特區1樓9-10號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">In Time Watch Company</td>
                              <td width="100">5372 0757</td>
                              <td width="335">旺角廣華街1號仁安大廈地下17B舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">In Watch</td>
                              <td width="100">2388 9963</td>
                              <td width="335">旺角彌敦道582-592號信和中心地下G21-22號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Midpoint Time Co.</td>
                              <td width="100">2136 6838</td>
                              <td width="335">旺角彌敦道580A號周大福商業中心潮流特區1樓26號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time For You</td>
                              <td width="100">2740 9068</td>
                              <td width="335">旺角彌敦道582-592號信和中心地下G33號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time Super Co.</td>
                              <td width="100">2384 0768</td>
                              <td width="335">旺角彌敦道582-592號信和中心地下G35號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2381 0962</td>
                              <td width="335">旺角西洋菜街256號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2789 3011</td>
                              <td width="335">旺角亞皆老街24-26號東方大廈地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">佑安錶行</td>
                              <td width="100">2384 4854</td>
                              <td width="335">旺角上海街425號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">大德鐘表行</td>
                              <td width="100">2380 7802</td>
                              <td width="335">旺角亞皆老街83號先達廣場1樓F11號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">尊貴鐘錶珠寶有限公司</td>
                              <td width="100">2891 6682</td>
                              <td width="335">旺角彌敦道603-609A新興大廈地下8A舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">幸運錶行</td>
                              <td width="100">2770 0277</td>
                              <td width="335">旺角彌敦道700號貿易處大樓地下4號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">旺角表行</td>
                              <td width="100">2787 6632</td>
                              <td width="335">旺角彌敦道700號工業貿易署大樓地下15號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時計坊</td>
                              <td width="100">2384 6073</td>
                              <td width="335">旺角潮流特區地庫11舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時計坊</td>
                              <td width="100">2396 2919</td>
                              <td width="335">旺角先達廣場一樓F115舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時計坊</td>
                              <td width="100">2393 8070</td>
                              <td width="335">旺角彌敦道688號新の城一樓149舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">永翔表行</td>
                              <td width="100">2381 8487</td>
                              <td width="335">旺角彌敦道760號聯合廣場地下G01B鋪</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">特區時計</td>
                              <td width="100">2332 9500</td>
                              <td width="335">旺角彌敦道580A號周大福商業中心潮流特區1樓20號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>深水埗</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">廣生表行</td>
                              <td width="100">2386 5863</td>
                              <td width="335">深水埗大埔道93號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新喜珠寶金行</td>
                              <td width="100">2386 8554</td>
                              <td width="335">九龍深水埗北河街100-102號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時輪坊</td>
                              <td width="100">2708 7633</td>
                              <td width="335">深水埗欽洲街37K號西九龍中心1樓140-B號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">華生表行</td>
                              <td width="100">2708 2891</td>
                              <td width="335">深水埗福華街146-152號高登電腦中心K-1號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>九龍塘</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2265 8820</td>
                              <td width="335">九龍塘又一城L1樓15號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>新蒲崗</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">永興鐘錶行</td>
                              <td width="100">2322 3827</td>
                              <td width="335">新蒲崗康強街28號康景商場H鋪</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>鑽石山</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2110 1510</td>
                              <td width="335">鑽石山荷里活廣場1樓106-107號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">鐘錶一廊</td>
                              <td width="100">2110 0699</td>
                              <td width="335">鑽石山荷里活廣場3樓330-A號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>慈雲山</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大德鐘表行</td>
                              <td width="100">2321 5730</td>
                              <td width="335">慈雲山鳳凰村蒲崗村道47-A地下</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>牛頭角</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時間寶</td>
                              <td width="100">2796 7879</td>
                              <td width="335">牛頭角道77號淘大商場第1期1樓29-30號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>觀塘</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2343 8315</td>
                              <td width="335">觀塘物華街23號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">潮點</td>
                              <td width="100">2357 0268</td>
                              <td width="335">觀塘開源道60號駱駝漆大廈三期1樓O室</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">百薈名店坊</td>
                              <td width="100">2112 9696</td>
                              <td width="335">觀塘偉業街182號觀塘碼頭廣場地下B號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>秀茂坪</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">28 Watch</td>
                              <td width="100">2354 8899</td>
                              <td width="335">秀茂坪購物中心商場1樓118號</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>九龍城</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">瑞士名錶有限公司</td>
                              <td width="100">2356 8288</td>
                              <td width="335">九龍九龍城沙浦道83號1樓</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>油塘</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Watch Out</td>
                              <td width="100">2776 9222</td>
                              <td width="335">油塘高超道38號大本營地下G16A舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時發錶行</td>
                              <td width="100">3526 1509</td>
                              <td width="335">油塘鯉魚門廣場146號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>藍田</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時發錶行</td>
                              <td width="100">2349 6732</td>
                              <td width="335">藍田啟田商場313 號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時發錶行</td>
                              <td width="100">2717 0800</td>
                              <td width="335">藍田德田商場310號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2></h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">瑞昌表行</td>
                              <td width="100">2381 4223</td>
                              <td width="335">九龍太子道西157號別樹華軒地下2號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2></h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時輪坊</td>
                              <td width="100">2686 9839</td>
                              <td width="335">九龍大角咀道38號新九龍廣場地下22號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>
-->

<!-- Hong Kong -->
<!--
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="HongKongStoreEN">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Sheung Wan</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Hua Mao Company</td>
                              <td width="100">2559 7226</td>
                              <td width="335">No. 3 Liang Ga Building, 300 Des Voeux Road West, Sheung Wan </td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Central</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Great China Watch Co.</td>
                              <td width="100">2543 0968</td>
                              <td width="335">G/F, 62 Connaught Road Central, Central</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Oriental Watch Co., Ltd.</td>
                              <td width="100">2545 4577</td>
                              <td width="335">G/F, 133 Des Voeux Road Central, Central</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tai Cheong Hong</td>
                              <td width="100">2545 8658</td>
                              <td width="335">Shop D, Hing Yip Commercial Center, 272-284 Des Vouex Road Central, Central</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">The King's Watches Co.</td>
                              <td width="100">2522 3469</td>
                              <td width="335">G/F, 49 Queen's Road Central, Central</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tung Hing Watch Co., Ltd.</td>
                              <td width="100">2541 0130</td>
                              <td width="335">Shop 162, Des Voeux Road, Central</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Viking Watch Co.</td>
                              <td width="100">2524 4711</td>
                              <td width="335">Shop 128, 1/F, Hutchison House, 10 Harcourt Road, Central</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Wanchai</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">New Bowling Watch Co.</td>
                              <td width="100">2722 0083</td>
                              <td width="335">G/F, Tak Wah Mansion, 292 Hennessy Road, Wanchai</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Truly Treasury Gold/Jewellery</td>
                              <td width="100">2891 8322</td>
                              <td width="335">G/F, 408 Hennessy Road, Wanchai</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Yau Wing Jewellery &amp; Watch Co.</td>
                              <td width="100">2833 0970</td>
                              <td width="335">Shop 7-8, G/F, Opulent Building, 416 Hennessy Road, Wanchai</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>North Point</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Cheong Tat Watch Co.</td>
                              <td width="100">2563 1315</td>
                              <td width="335">Shop 2, G/F, 18 Marble Road, North Point</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kim Tak Watch Co.</td>
                              <td width="100">2564 3456</td>
                              <td width="335">G/F, 463 King's Road, North Point</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tak Ming Watch Co.</td>
                              <td width="100">2563 8898</td>
                              <td width="335">Shop 1, G/F, 18 Marble Road, North Point</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tai Koo Shing</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Eagle Watches Co.</td>
                              <td width="100">2567 4789</td>
                              <td width="335">Shop P402B, 2/F Yen Kung Mansion, 1 Tai Mou Avenue Tai Koo Shing, Hong Kong</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Causeway Bay</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210"> Time Circle</td>
                              <td width="100">2881 7012</td>
                              <td width="335">Shop 201,Laforet, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Broadway Watch Jewellery &amp; Goldsmith Co., Ltd.</td>
                              <td width="100">2882 2381</td>
                              <td width="335">G/F, A2 HK Mansion, 1 Yee Wo Street, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Fine Asia Watch (HK) Co., Ltd.</td>
                              <td width="100">2834 3789</td>
                              <td width="335">Shop 23-24, B1/F, Sogo Department Store, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kowloon Watch Co., Ltd.</td>
                              <td width="100">2890 3912</td>
                              <td width="335">Shop H, G/F Lai Yuen Apartment, 29-33 Lee Garden Road, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Luxury Watch &amp; Jewellery</td>
                              <td width="100">2833 6191</td>
                              <td width="335">G/F, 64 Percival Street, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Sun Century Watches Limited</td>
                              <td width="100">2625 4103</td>
                              <td width="335">G/F., 454 Hennessy Road, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2110 1350</td>
                              <td width="335">Shop No. 911, 9/F, Times Square, Matheson Street, Causeway Bay </td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time House</td>
                              <td width="100">2882 2791</td>
                              <td width="335">Shop No. 254, 2/F, Laforet,24-26 East point Road, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Trans Mondiale Watch Co., Ltd.</td>
                              <td width="100">2893 7676</td>
                              <td width="335">G/F, No.444 Hennessy Road, Causeway Bay</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Valuable Watch and Jewellery Ltd</td>
                              <td width="100">2891 6308</td>
                              <td width="335">G/F &amp; Cockloft, 63 Percival Street, Causeway Bay</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" id="HongKongStoreTC">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>上環</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">華茂公司</td>
                              <td width="100">2559 7226</td>
                              <td width="335">上環德輔道西300號良基大廈3號</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>中環</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大中華錶行</td>
                              <td width="100">2543 0968</td>
                              <td width="335">中環干諾道62號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">大昌行</td>
                              <td width="100">2545 8658</td>
                              <td width="335">中環德輔道中272-284號興業商業中心D號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">東方表行有限公司</td>
                              <td width="100">2545 4577</td>
                              <td width="335">中環德輔道中133號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">東興表行有限公司</td>
                              <td width="100">2541 0130</td>
                              <td width="335">中環德輔道中162號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">生發表行</td>
                              <td width="100">2522 3469</td>
                              <td width="335">中環皇后大道中49號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">維京錶行</td>
                              <td width="100">2524 4711</td>
                              <td width="335">中環和記大廈1樓128號鋪</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>灣仔</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新寶寧表行</td>
                              <td width="100">2722 0083</td>
                              <td width="335">灣仔軒尼詩道292號德華大廈地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">有榮鐘錶珠寶金行</td>
                              <td width="100">2833 0970</td>
                              <td width="335">灣仔軒尼詩道416號德興大廈地下7-8號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">翠多福金莊</td>
                              <td width="100">2891 8322</td>
                              <td width="335">灣仔軒尼詩道408號地下</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>北角</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">儉德表行</td>
                              <td width="100">2564 3456</td>
                              <td width="335">北角英皇道463號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">德明表行</td>
                              <td width="100">2563 8898</td>
                              <td width="335">北角馬寶道18號地下1號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">祥達表行</td>
                              <td width="100">2563 1315</td>
                              <td width="335">北角馬寶道18號地下2號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>太古城</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">愛高錶行</td>
                              <td width="100">2567 4789</td>
                              <td width="335">香港太古城太茂路1號燕宮閣平台P4028舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>銅鑼灣</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tic Tac Time Co., Ltd.</td>
                              <td width="100">2110 1350</td>
                              <td width="335">銅鑼灣勿地臣街時代廣場9樓911號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Circle</td>
                              <td width="100">2881 7012</td>
                              <td width="335">銅鑼灣東角駅商場201舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2890 3912</td>
                              <td width="335">銅鑼灣利園山道29-33號麗園大廈地下H舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">尊貴鐘錶珠寶有限公司</td>
                              <td width="100">2891 6308</td>
                              <td width="335">銅鑼灣波斯富街63號地下及閣樓</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新世紀表行有限公司</td>
                              <td width="100">2625 4103</td>
                              <td width="335">銅鑼灣軒尼斯道454號地舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時計屋</td>
                              <td width="100">2882 2791</td>
                              <td width="335">銅鑼灣東角道24-26號東角Laforet 2樓254號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">瑞聯錶行(香港)有限公司</td>
                              <td width="100">2834 3789</td>
                              <td width="335">銅鑼灣崇光百貨公司新翼地庫1樓23-24號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">環亞表行</td>
                              <td width="100">2893 7676</td>
                              <td width="335">銅鑼灣軒尼詩道444號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">百老匯表行有限公司</td>
                              <td width="100">2882 2381</td>
                              <td width="335">銅鑼灣怡和街1號A2地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">銀聯鐘錶珠寶有限公司</td>
                              <td width="100">2833 6191</td>
                              <td width="335">銅鑼灣波斯富街64號地下</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>
-->

<!-- NT -->
<!--
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="NTEN">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tseung Kwan O</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Papo Watch </td>
                              <td width="100">3194 3318</td>
                              <td width="335">Shop No. 2017, Level 2, Phase 2, Metro City Plaza, Tseung Kwan O</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Max</td>
                              <td width="100">2704 8448</td>
                              <td width="335">Shop No. L127 First Floor, Hau Tak Shopping Centre, Hau Tak Estate, Tseung Kwan O</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time Station</td>
                              <td width="100">2325 0617</td>
                              <td width="335">Shop 106, Metro City Plaza 3, Tseung Kwan O</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Kwai Fong</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Double Watch Co.</td>
                              <td width="100">2485 1771</td>
                              <td width="335">Shop C112A, 2/F, Kwai Chung Plaza, Kwai Fong</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Hing Yuen Cheong</td>
                              <td width="100">2422 3850</td>
                              <td width="335">Shop A21, G/F, Kwai Chung Plaza, Kwai Fong</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tsuen Wan</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Champion Watches</td>
                              <td width="100">2868 0807</td>
                              <td width="335">Shop G014, KOLOUR Tsuen Wan I, 68 Chung On Street, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Chan Kee Watch Co.</td>
                              <td width="100">2423 0913</td>
                              <td width="335">Shop 108, Riviera Plaza, Riviera Garden, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Chi Sze Watch Co.</td>
                              <td width="100">2437 9668</td>
                              <td width="335">A128-23, 1/F, Nan Fung Centre, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">F-Time</td>
                              <td width="100">2404 8916</td>
                              <td width="335">G46 , G/F, Luk Yeung Galleria, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kowloon Watch Co., Ltd</td>
                              <td width="100">2427 3164</td>
                              <td width="335">Shop 190-191, 2/F, Tsuen Kam Centre, 338 Castle Peak Road, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Sang Kee Watch Co.</td>
                              <td width="100">2492 4633</td>
                              <td width="335">Shop A3, G/F, 24 Chung On Street, Tsuen Wan</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tsuen Wan Watch Co.</td>
                              <td width="100">2332 8578</td>
                              <td width="335">Shop A90, Nan Fung Centre, Tsuen Wan</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tsing Yi</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Famous Express Corporation Ltd</td>
                              <td width="100">2433 3900</td>
                              <td width="335">Shop 17, Level 1, Rambler Plaza, Rambler Crest, 1 Tsing Yi Road, TY</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Shing Hing Watch Co.</td>
                              <td width="100">2432 9372</td>
                              <td width="335">Shop 204, Cheung Fat Shopping Centre, Cheung Fat Estate, Tsing Yi</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Shatin</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Grace Clock &amp; Watch Co.</td>
                              <td width="100">3118 7480</td>
                              <td width="335">Shop 9, Level 3, Lucky Plaza, Shatin</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Grace Clock &amp; Watch Co.</td>
                              <td width="100">2814 8011</td>
                              <td width="335">Shop 23, Level 3, Lucky Plaza, Shatin</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Him Shun Watch Co.</td>
                              <td width="100">2697 5969</td>
                              <td width="335">Shop 16, 3/F, Fook Hoi House, Lek Yuen Estate, Shatin</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Shing Hing Watch Co.</td>
                              <td width="100">2693 5192</td>
                              <td width="335">Shop 23-C, 3/F, Shatin Centre, Shatin</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time House</td>
                              <td width="100">2602 3398</td>
                              <td width="335">Shop 55, Citylink Plaza, Shatin</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Ma On Shan</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">King Watches &amp; Clocks Co.</td>
                              <td width="100">2633 3078</td>
                              <td width="335">Shop 2208A, 2/F, Sunshine City Plaza, Ma On Shan</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tai Wai</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Golden Clock &amp; Watch Co.</td>
                              <td width="100">2609 4003</td>
                              <td width="335">Shop 126, 1/F, Grandeur Shopping Arcade, Tai Wai</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Teen Gallery</td>
                              <td width="100">2603 4722</td>
                              <td width="335">Shop 128, 1/F, Grandeur Shopping Arcade, Tai Wai</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Sheung Shui</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Any Time</td>
                              <td width="100">2476 1406</td>
                              <td width="335">Shop 823A, Landmark North, Lung Sum Avenue, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Cheng Tak Kee</td>
                              <td width="100">2679 7131</td>
                              <td width="335">G/F, 14 San Kin Street, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Kowloon Watch Co., Ltd.</td>
                              <td width="100">2671 6692</td>
                              <td width="335">No.270, 2/F, Landmark North, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Lung Fung Watch Co.</td>
                              <td width="100">2668 4776</td>
                              <td width="335">Shop 82, Lung Fung Garden Shopping Center, Lung Sum Avenue, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Nam Shing Jewellery &amp; Goldsmiths Co.</td>
                              <td width="100">2670 0380</td>
                              <td width="335">G/F, 65 San Fung Avenue, Shek Wu Hui, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Shing Hing Watch Co. </td>
                              <td width="100">2164 8328</td>
                              <td width="335">Shop No. R17 &amp; R17A, 3/F, Choi Yuen Plaza, Chio Yuen Estate, Sheung Shui</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Tak Po Watch Co.</td>
                              <td width="100">2672 9608</td>
                              <td width="335">G/F, 63A San Hong Street, Sheung Shui</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Fanling</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Grace Clock &amp; Watch Co.</td>
                              <td width="100">2669 3830</td>
                              <td width="335">Shop 32, Level 2, Fanling Town Centre, Fanling</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tuen Mun</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Fine Asia Watch (HK) Co., Ltd.</td>
                              <td width="100">3422 8427</td>
                              <td width="335">Shop 1073-1075, L1, Tuen Mun Town Plaza,Phase 1, Tuen Mun, NT</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Focus</td>
                              <td width="100">2440 0186</td>
                              <td width="335">Shop No.10B, 3/F, South Wing, The Trend Plaza Shopping Arcade, Tuen Mun</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Man Fung Watch Co.</td>
                              <td width="100">2441 7735</td>
                              <td width="335">Shop 47, 1/F, Richland Garden, 138 Wu Chui Road, Tuen Mun</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Cube</td>
                              <td width="100">2386 8300</td>
                              <td width="335">Shop H-202A, L2, Zone H.A.N.D.S, Yau Oi Estate, Tuen Mun</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time Cube</td>
                              <td width="100">2386 8300</td>
                              <td width="335">Shop R151, Butterfly Plaza, 1 Wu Chui Road</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Yuen Long</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Any Time</td>
                              <td width="100">2477 9876</td>
                              <td width="335">Shop 1, G/F, Cheung Fat Building, YLTL 425, Yu King Square,Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Any Time</td>
                              <td width="100">2477 2833</td>
                              <td width="335">Shop 7, G/F, Healey Building, 211-223 Castle Peak Road, Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Focus</td>
                              <td width="100">2478 5227</td>
                              <td width="335">Shop 45, G/F, Citimall, 1 Kau Yuk Road, Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Glory Time</td>
                              <td width="100">2470 3848</td>
                              <td width="335">Shop 6, G/F, Kwong Wah Plaza, 11 Tai Tong Road, Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kit Shing Watch Co.</td>
                              <td width="100">2476 1482</td>
                              <td width="335">Shop 5, G/F, Healey Building, 211-233 Yuen Long Main Road, Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Kit Shing Watch Co.</td>
                              <td width="100">2476 8826</td>
                              <td width="335">Shop A, G/F, Fung Hing Building, 33-35 Yuen Long Hong Lok Road, Yuen Long</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Man Wah Watch Co.</td>
                              <td width="100">2470 3398</td>
                              <td width="335">Shop 8, Fu Ho Bldg., 3-7 Kau Yuk Road</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tin Shui Wai</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Jubilee Shop</td>
                              <td width="100">2253 0031</td>
                              <td width="335">Shop 138, Phase 2, Chung Fu Shopping Center, Tin Shui Wai</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tung Chung</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">SAKURA</td>
                              <td width="100">2581 1691</td>
                              <td width="335">Shop 125, Fu Tung Plaza, Tung Chung</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>Tai Po</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Grace Clock &amp; Watch Co., Ltd.</td>
                              <td width="100">2682 8362</td>
                              <td width="335">Shop 220A, Tai Wo Plaza, Tai Po</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Man Wah Watch Co</td>
                              <td width="100">2664 3817</td>
                              <td width="335">Shop No.47, G/F, Tai Po Plaza, Tai Po</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" id="NTTC">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>將軍澳</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time Max</td>
                              <td width="100">2704 8448</td>
                              <td width="335">將軍澳厚德邨厚德商場1樓L127號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Station</td>
                              <td width="100">2325 0617</td>
                              <td width="335">將軍澳新都城中心三期106號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">柏寶鐘錶</td>
                              <td width="100">3194 3318</td>
                              <td width="335">將軍澳新都城中心二期2017號</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>葵芳</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">得寶錶行</td>
                              <td width="100">2485 1771</td>
                              <td width="335">葵芳葵涌廣場2樓C112A號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">興源昌錶行</td>
                              <td width="100">2422 3850</td>
                              <td width="335">葵芳葵涌廣場地下A21號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>荃灣</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">F-Time</td>
                              <td width="100">2404 8916</td>
                              <td width="335">荃灣綠楊坊地下G46號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2427 3164</td>
                              <td width="335">荃灣荃錦中心2樓190-191號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">志時錶行</td>
                              <td width="100">2437 9668</td>
                              <td width="335">荃灣南豐中心A128-23號</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">時間寶</td>
                              <td width="100">2868 0807</td>
                              <td width="335">荃灣眾安街68號荃灣千色1期G014號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">生記錶行</td>
                              <td width="100">2492 4633</td>
                              <td width="335">荃灣眾安街24號A3鋪</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">荃灣表行</td>
                              <td width="100">2332 8578</td>
                              <td width="335">荃灣南豐中心A90舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">贊記錶行</td>
                              <td width="100">2423 0913</td>
                              <td width="335">荃灣海濱花園海濱商場108號鋪</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>青衣</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">勝興鐘錶行</td>
                              <td width="100">2432 9372</td>
                              <td width="335">青衣長發村長發商場204號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">盈采購物</td>
                              <td width="100">2433 3900</td>
                              <td width="335">青衣青衣路1號藍澄灣商場1樓17號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>沙田</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">勝興鐘錶行</td>
                              <td width="100">2693 5192</td>
                              <td width="335">沙田中心3樓23-C號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大德鐘表行有限公司</td>
                              <td width="100">3118 7480</td>
                              <td width="335">沙田好運中心商場3期9號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">大德鐘錶行有限公司</td>
                              <td width="100">2814 8011</td>
                              <td width="335">沙田好運中心商場L3 23號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">時計屋</td>
                              <td width="100">2602 3398</td>
                              <td width="335">沙田連城廣場55號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">謙信表行</td>
                              <td width="100">2697 5969</td>
                              <td width="335">沙田瀝源村福海樓3樓16號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>馬鞍山</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大寶鐘表行</td>
                              <td width="100">2633 3078</td>
                              <td width="335">馬鞍山新港城2樓2208A號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>大圍</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Teen Gallery</td>
                              <td width="100">2603 4722</td>
                              <td width="335">大圍金禧商場128號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">金輝鐘錶行</td>
                              <td width="100">2609 4003</td>
                              <td width="335">大圍金禧商場126號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>上水</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Any Time</td>
                              <td width="100">2476 1406</td>
                              <td width="335">上水龍琛路39號上水廣場823A室</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">S.H. 勝興</td>
                              <td width="100">2164 8328</td>
                              <td width="335">上水彩園邨彩園廣場三樓R17及17A 店</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">九龍表行</td>
                              <td width="100">2671 6692</td>
                              <td width="335">上水上水廣場第二層270號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">南盛珠寶鐘錶</td>
                              <td width="100">2670 0380</td>
                              <td width="335">上水石湖墟新豐路65號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">德寶鐘錶公司</td>
                              <td width="100">2672 9608</td>
                              <td width="335">上水新康街63A號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">鄭德記表行</td>
                              <td width="100">2679 7131</td>
                              <td width="335">上水新健街14號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">龍豐錶行</td>
                              <td width="100">2668 4776</td>
                              <td width="335">上水龍琛路龍豐商場82號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>粉嶺</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大德鐘表行</td>
                              <td width="100">2669 3830</td>
                              <td width="335">粉嶺名都商場第2期32號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>屯門</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Focus</td>
                              <td width="100">2440 0186</td>
                              <td width="335">屯門時代廣場南翼3樓10B號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Cube   </td>
                              <td width="100">2386 8300</td>
                              <td width="335">屯門友愛邨H.A.N.D.S H-202A號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time Cube</td>
                              <td width="100">2386 8300</td>
                              <td width="335">屯門湖翠路1號蝴蝶廣場R151號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">文豐錶行</td>
                              <td width="100">2441 7735</td>
                              <td width="335">屯門湖翠路138號啟豐園1樓47號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">瑞聯錶行(香港)有限公司</td>
                              <td width="100">3422 8427</td>
                              <td width="335">新界屯門屯門市廣場一期1樓1073-1075號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>元朗</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Any Time</td>
                              <td width="100">2477 9876</td>
                              <td width="335">元朗裕景坊元朗市地段第425號祥發大廈地下1號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Any Time</td>
                              <td width="100">2477 2833</td>
                              <td width="335">元朗青山公路211-223號喜利商場地下7號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Focus</td>
                              <td width="100">2478 5227</td>
                              <td width="335">元朗教育路1號千色廣場地下G45號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">傑成錶行</td>
                              <td width="100">2476 1482</td>
                              <td width="335">元朗大馬路211-233號喜利大廈地下5號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">傑成錶行</td>
                              <td width="100">2476 8826</td>
                              <td width="335">元朗康樂路33-35號豐興樓地下A號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">光華錶行</td>
                              <td width="100">2470 3848</td>
                              <td width="335">元朗大棠路11號光華廣場地下6號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">文華錶行</td>
                              <td width="100">2470 3398</td>
                              <td width="335">元朗教育路3-7號富好大廈地下8號</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>天水圍</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">珠錶飾品店</td>
                              <td width="100">2253 0031</td>
                              <td width="335">天水圍頌富商場第2期138號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>東涌</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">SAKURA</td>
                              <td width="100">2581 1691</td>
                              <td width="335">東涌富東商場125號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2>大埔</h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Grace Clock &amp; Watch Co., Ltd.</td>
                              <td width="100">2682 8362</td>
                              <td width="335">大埔太和廣場220A號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">文華錶行</td>
                              <td width="100">2664 3817</td>
                              <td width="335">大埔大埔廣場地下47號舖</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>
-->

<!-- MC -->
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="MCEN">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2></h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">Name of Service Centres</td>
                              <td width="100" align="left">Tel no.</td>        
                              <td width="335">Address</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Chong Kei Watch Co.</td>
                              <td width="100">(853) 2856 4807</td>
                              <td width="335">No.6A, Rua Do Bocage, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">GMT Time</td>
                              <td width="100">(853) 2835 7004</td>
                              <td width="335">Rua De S. Domingos, 23-25 R/C, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">GMT Time</td>
                              <td width="100">(853) 2836 5025</td>
                              <td width="335">Rua De S. Paulo No13-B R/C, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Ho Tin Development Co.</td>
                              <td width="100">(853) 2878 5527</td>
                              <td width="335">Shop A9, G/F, Nam Kwong Department Store, Rua de Pequim, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Ieng Fu Relojoaria</td>
                              <td width="100">(853) 2843 2595</td>
                              <td width="335">Rua Oito Do Bairro Do Iao Hon, Chun Pek Garden, 103., Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Kok Vui Watch</td>
                              <td width="100">(853) 2893 0107</td>
                              <td width="335">No. 473, Avenida De Almeida Ribeiro, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Macau Kinghouse Duty Free Co., Ltd</td>
                              <td width="100">(853) 2833 2308</td>
                              <td width="335">Ave.Do Conselheiro Borja 515,EDF Mei Kui Kuong Cheong,B1.2,1Andar AH, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">New Generation Watches</td>
                              <td width="100">(853) 2833 2659</td>
                              <td width="335">23-23A Rua Da Palha, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">New Generation Watches</td>
                              <td width="100">(853) 2835 5094</td>
                              <td width="335">Shop A &amp; B, 22 Rua de Pedro Nolasco da Silva, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">New Time</td>
                              <td width="100">(853) 2833 2308</td>
                              <td width="335">G/F, 58 Avenida De Horta e Costa, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">New Time</td>
                              <td width="100">(853) 6289 5689</td>
                              <td width="335">EM Macau a Rua  58,  Jardim  Casa  subterrânea  Na  segunda</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">New Time</td>
                              <td width="100">(853) 2878 0933</td>
                              <td width="335">408 Avenida Almeida Ribeiro, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Oriental Watch Co., Ltd.</td>
                              <td width="100">(853) 2871 7323</td>
                              <td width="335">Shop D, G/F &amp; M/F., The Macau Square, Avenida do Infanted D. Henrique No. 43-53A, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Relojoaria Chong I</td>
                              <td width="100">(853) 2856 7496</td>
                              <td width="335">Rua D A Barca No.14-C R/C, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Relojoaria San Kuong</td>
                              <td width="100">(853) 2834 4666</td>
                              <td width="335">107R/C(A), Estrada do Repouso, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Relojoaria San Si Toi</td>
                              <td width="100">(853) 2831 5307</td>
                              <td width="335">Avenida General Castelo Branco, No.9, RC, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Relojoaria San Si Toi</td>
                              <td width="100">(853) 2828 2201</td>
                              <td width="335">G/F, 17 AV.D. Joao IV, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Tai Fung Watch Co.</td>
                              <td width="100">(853) 2837 5155</td>
                              <td width="335">278 Avenida Almeida Ribeiro, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time 2</td>
                              <td width="100">(853) 2841 3730</td>
                              <td width="335">EDF Fu Me Lok R/C(C), Rua do Amirante Costa Cabral 59B, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Square</td>
                              <td width="100">(853) 2832 3149</td>
                              <td width="335">Rua Dos Mercadores, 51. Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Yu Xing Long Watch Ltd.</td>
                              <td width="100">(853) 2836 6396</td>
                              <td width="335">Rua Da Palha, No. 8-10, Yu Heng Long Sedong Cheong, RC.ED; Kam Heng, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Yu Xing Long Watch Ltd.</td>
                              <td width="100">(853) 2838 9845</td>
                              <td width="335">Rua De S. Domingos, 19A R/C, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Yu Xing Long Watch Ltd.</td>
                              <td width="100">(853) 2836 6396</td>
                              <td width="335">Avn De Almeida Ribeiro, 415. R/C, Macau</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Yu Xing Long Watch Ltd.</td>
                              <td width="100">(853) 2871 4075</td>
                              <td width="335">Em Macau, Rua De S. Paulo No34-E, Seng Tak Court Res-Do-Chao a</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" id="MCTC">
          <tbody>
            
            <tr>
              <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td> <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td colspan="7" class="header"><h2></h2></td>
                            </tr>
                            <tr class="sub_header">
                              <td width="210">店鋪名稱</td>
                              <td width="100" align="left">電話號碼</td>        
                              <td width="335">地址</td>

                            </tr>
                            
<tr valign="top" class="sub_item">                           
                              <td width="210">GMT Time</td>
                              <td width="100">(853) 2835 7004</td>
                              <td width="335">澳門板樟堂街23-25號地舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">GMT Time</td>
                              <td width="100">(853) 2836 5025</td>
                              <td width="335">澳門大三巴街13號B地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">Time 2</td>
                              <td width="100">(853) 2841 3730</td>
                              <td width="335">澳門賈伯樂提督街富美樂大廈59號B地下C舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">Time Square</td>
                              <td width="100">(853) 2832 3149</td>
                              <td width="335">澳門營地大街51號</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">國滙錶行</td>
                              <td width="100">(853) 2893 0107</td>
                              <td width="335">澳門新馬路473號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">大豐錶行</td>
                              <td width="100">(853) 2837 5155</td>
                              <td width="335">澳門新馬路278號</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新一代錶行</td>
                              <td width="100">(853) 2833 2659</td>
                              <td width="335">澳門賣草地街23號A百達商場7號舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新一代錶行</td>
                              <td width="100">(853) 2835 5094</td>
                              <td width="335">澳門白馬行22號A,B舖  </td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新光錶行</td>
                              <td width="100">(853) 2834 4666</td>
                              <td width="335">澳門鏡湖馬路107號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新時代鐘錶行 </td>
                              <td width="100">(853) 2831 5307</td>
                              <td width="335">澳門白朗古將軍大馬路9號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新時代鐘錶行</td>
                              <td width="100">(853) 2828 2201</td>
                              <td width="335">澳門約翰四世大馬路17號D地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新時間錶行</td>
                              <td width="100">(853) 2833 2308</td>
                              <td width="335">澳門高士德大馬路58號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">新時間錶行</td>
                              <td width="100">(853) 6289 5689</td>
                              <td width="335">澳門關閘馬路58號海南花園第二幢地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">新時間錶行</td>
                              <td width="100">(853) 2878 0933</td>
                              <td width="335">澳門新馬路408號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">東方表行有限公司</td>
                              <td width="100">(853) 2871 7323</td>
                              <td width="335">澳門殷皇子大馬路47-53號澳門廣場D舖地下及閣樓</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">浩天錶行</td>
                              <td width="100">(853) 2878 5527</td>
                              <td width="335">澳門新口岸北京街南光百貨地下A9舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">淞意錶行</td>
                              <td width="100">(853) 2856 7496</td>
                              <td width="335">澳門新橋區渡船街14C號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">澳門奧特萊斯免稅店有限公司</td>
                              <td width="100">(853) 2833 2308</td>
                              <td width="335">澳門青洲大馬路515號美居廣場第二期一樓AH座</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">盈富錶行</td>
                              <td width="100">(853) 2843 2595</td>
                              <td width="335">澳門祐漢第八街泉碧花園第1座地下103號</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">裕興隆錶行</td>
                              <td width="100">(853) 2836 6396</td>
                              <td width="335">澳門賣草地街8-10號錦興大廈地下B 舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">裕興隆錶行</td>
                              <td width="100">(853) 2838 9845</td>
                              <td width="335">澳門板樟堂街19號A地舖</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">裕興隆錶行</td>
                              <td width="100">(853) 2836 6396</td>
                              <td width="335">澳門新馬路415號地下</td>
                            </tr>


                            
<tr valign="top" class="sub_item">                           
                              <td width="210">裕興隆錶行</td>
                              <td width="100">(853) 2871 4075</td>
                              <td width="335">澳門大三巴街34E成德閣地下A座</td>
                            </tr>


                            
<tr valign="top" class="sub_item2">                           
                              <td width="210">鐘記錶行</td>
                              <td width="100">(853) 2856 4807</td>
                              <td width="335">澳門蓬萊新街6號A地下</td>
                            </tr>


                            
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            
          </tbody>
        </table>