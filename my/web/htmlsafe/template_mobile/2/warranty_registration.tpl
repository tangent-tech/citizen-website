{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$Content->object_name}</h1>
			</div>

			<div class="container">
				<section>

					<div>{$Content->block_content}</div>
					<br/>
					<br/>
					
					<div class="WarrantyLabel">調查問卷</div>
					
					<form id="WarrantyRegistrationForm" class="WarrantyForm" action="{$BASEURL}/warranty_part1_act.php" method="POST">
						<table>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">性別</div>
									<ul>
										<li><input type="radio" name="q1_sex" value="男"/> 男</li>
										<li><input type="radio" name="q1_sex" value="女"/> 女</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">年齡</div>
									<ul>
										<li><input type="radio" name="q2_age" value="25歲或以下"/> 25歲或以下</li>
										<li><input type="radio" name="q2_age" value="26-30"/> 26-30</li>
										<li><input type="radio" name="q2_age" value="31-35"/> 31-35</li>
										<li><input type="radio" name="q2_age" value="36-40"/> 36-40</li>
										<li><input type="radio" name="q2_age" value="41-45"/> 41-45</li>
										<li><input type="radio" name="q2_age" value="46或以上"/> 46或以上</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">教育程度</div>
									<ul>
										<li><input type="radio" name="q3_education" value="小學"/>小學</li>
										<li><input type="radio" name="q3_education" value="中學"/>中學</li>
										<li><input type="radio" name="q3_education" value="預科"/>預科</li>
										<li><input type="radio" name="q3_education" value="大學"/>大學</li>
										<li>
											<input type="radio" name="q3_education" value="專業資格或以上"/>專業資格或以上
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">職業</div>
									<ul>
										<li><input type="radio" name="q4_occupation" value="學生"/>學生</li>
										<li><input type="radio" name="q4_occupation" value="文職人員"/>文職人員</li>
										<li><input type="radio" name="q4_occupation" value="管理階層"/>管理階層</li>
										<li><input type="radio" name="q4_occupation" value="專業人士"/>專業人士</li>
										<li><input type="radio" name="q4_occupation" value="自顧人士"/>自顧人士</li>
										<li><input type="radio" name="q4_occupation" value="家庭主婦"/>家庭主婦</li>
										<li><input type="radio" name="q4_occupation" value="其他"/>其他</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">個人月入</div>
									<ul>
										<li><input type="radio" name="q5_income" value="港幣9,999或以下"/>港幣9,999或以下 </li>
										<li><input type="radio" name="q5_income" value="港幣10,000 - 19,999"/>港幣10,000 - 19,999</li>
										<li><input type="radio" name="q5_income" value="港幣20,000 - 29,999"/>港幣20,000 - 29,999</li>
										<li><input type="radio" name="q5_income" value="港幣30,000 - 39,999"/>港幣30,000 - 39,999</li>
										<li><input type="radio" name="q5_income" value="港幣40,000或以上"/>港幣40,000或以上 </li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">您購買CITIZEN手錶的原因</div>
									(可選多項) 
									<ul>
										<li><input type="checkbox" name="q6_reason_pur[]" value="價錢"/>價錢</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="設計"/>設計</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="品質"/>品質</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="技術/功能"/>技術/功能</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="品牌形象"/>品牌形象</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="廣告"/>廣告</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="禮物"/>禮物</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="經銷商/售貨員推介"/>經銷商/售貨員推介</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="朋友推介"/>朋友推介</li>
										<li>
											<input type="checkbox" name="q6_reason_pur[]" value="其他"/>其他，請註明:
											<input type="text" name="q6_reason_pur_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">您在那個地區購買CITIZEN手錶</div>
									<ul>
										<li><input type="radio" name="q7_location_pur" value="旺角"/>旺角</li>
										<li><input type="radio" name="q7_location_pur" value="銅鑼灣"/>銅鑼灣</li>
										<li><input type="radio" name="q7_location_pur" value="尖沙咀"/>尖沙咀</li>
										<li><input type="radio" name="q7_location_pur" value="新界"/>新界</li>
										<li><input type="radio" name="q7_location_pur" value="澳門"/>澳門</li>
										<li>
											<input type="radio" name="q7_location_pur" value="其他"/>其他，請註明: 
											<input type="text" name="q7_location_pur_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">您從什麼途徑得知CITIZEN手錶的資訊</div>
									(可選多項) 
									<ul>
										<li><input type="checkbox" name="q8_channel_info[]" value="商品目錄/小冊子"/>商品目錄/小冊子</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="報紙/雜誌"/>報紙/雜誌</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="互聯網"/>互聯網</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="戶外廣告"/>戶外廣告 </li>
										<li><input type="checkbox" name="q8_channel_info[]" value="展覽"/>展覽</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="贊助活動"/>贊助活動</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="店舖陳設"/>店舖陳設</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="經銷商/售貨員"/>經銷商/售貨員</li>
										<li>
											<input type="checkbox" name="q8_channel_info[]" value="其他"/>其他，請註明:
											<input type="text" name="q8_channel_info_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">最想擁有的3個手錶品牌</div>
									(請選3項)
									<ul>
										<li><input type="checkbox" name="q9_brands_want[]" value="Agnes b"/>Agnes b</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="卡地亞 Cartier"/>卡地亞 Cartier</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="卡西歐 Casio"/>卡西歐 Casio</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="司馬 Cyma"/>司馬 Cyma</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Emporio Armani"/>Emporio Armani</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Frank Muller"/>Frank Muller</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Folli Follie"/>Folli Follie</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Fossil"/>Fossil</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Gucci"/>Gucci</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Guess"/>Guess</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="浪琴 Longines"/>浪琴 Longines</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="歐米茄 Omega"/>歐米茄 Omega</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="東方 Orient"/>東方 Orient</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="雷達表 Rado"/>雷達表 Rado</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="勞力士 Rolex"/>勞力士 Rolex</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="精工 Seiko"/>精工 Seiko</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Tag Heuer"/>Tag Heuer</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="天梭 Tissot"/>天梭 Tissot</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="鐵達時 Titus"/>鐵達時 Titus</li>
										<li>
											<input type="checkbox" name="q9_brands_want[]" value="其他"/>其他，請註明:
											<input type="text" name="q9_brands_want_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td align="center">
									<input type="submit" value="繼續"/>
								</td>
							</tr>
						</table>
					</form>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}