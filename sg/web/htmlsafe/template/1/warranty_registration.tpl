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
					
					<div class="WarrantyLabel">Questionnaire</div>
					
					<form id="WarrantyRegistrationForm" class="WarrantyForm" action="{$BASEURL}/warranty_part1_act.php" method="POST">
						<table>
							<tr>
								<th width="25%">Sex</th>
								<td width="75%">
									<ul>
										<li><input type="radio" name="q1_sex" value="Male"/> Male</li>
										<li><input type="radio" name="q1_sex" value="Female"/> Female</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Age</th>
								<td>
									<ul>
										<li><input type="radio" name="q2_age" value="25 or below"/> 25 or below</li>
										<li><input type="radio" name="q2_age" value="26-30"/> 26-30</li>
										<li><input type="radio" name="q2_age" value="31-35"/> 31-35</li>
										<li><input type="radio" name="q2_age" value="36-40"/> 36-40</li>
										<li><input type="radio" name="q2_age" value="41-45"/> 41-45</li>
										<li><input type="radio" name="q2_age" value="46 or above"/> 46 or above</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Education</th>
								<td>
									<ul>
										<li><input type="radio" name="q3_education" value="Primary"/>Primary</li>
										<li><input type="radio" name="q3_education" value="Secondary"/>Secondary</li>
										<li><input type="radio" name="q3_education" value="Matriculation"/>Matriculation</li>
										<li><input type="radio" name="q3_education" value="University"/>University</li>
										<li class="WidthAuto">
											<input type="radio" name="q3_education" value="Professional Qualification or above"/>Professional Qualification or above
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Occupation</th>
								<td>
									<ul>
										<li><input type="radio" name="q4_occupation" value="Student"/>Student</li>
										<li><input type="radio" name="q4_occupation" value="Clerical/Office"/>Clerical/Office</li>
										<li><input type="radio" name="q4_occupation" value="Manager"/>Manager</li>
										<li><input type="radio" name="q4_occupation" value="Professional"/>Professional</li>
										<li><input type="radio" name="q4_occupation" value="Self-Employed"/>Self-Employed</li>
										<li><input type="radio" name="q4_occupation" value="Housewife"/>Housewife</li>
										<li><input type="radio" name="q4_occupation" value="Other"/>Other</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Income</th>
								<td>
									<ul>
										<li class="WidthAuto"><input type="radio" name="q5_income" value="HKD9,999 or below"/>HKD9,999 or below </li>
										<li class="WidthAuto"><input type="radio" name="q5_income" value="HKD10,000-19,999"/>HKD10,000-19,999</li>
										<li class="WidthAuto"><input type="radio" name="q5_income" value="HKD20,000-29,999"/>HKD20,000-29,999</li>
										<li class="WidthAuto"><input type="radio" name="q5_income" value="HKD30,000-39,999"/>HKD30,000-39,999</li>
										<li class="WidthAuto"><input type="radio" name="q5_income" value="HKD40,000 or above"/>HKD40,000 or above </li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Reason(s) you purchased<br/>CITIZEN Watch</th>
								<td>
									(Can select more than one answer) 
									<ul>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Price"/>Price</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Design"/>Design</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Quality"/>Quality</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Technology/Function"/>Technology/Function</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Brand Image"/>Brand Image</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Advertisement"/>Advertisement</li>
										<li><input type="checkbox" name="q6_reason_pur[]" value="Gift"/>Gift</li>
										<br/>
										<li class="WidthAuto"><input type="checkbox" name="q6_reason_pur[]" value="Dealers/Salespersons Recommendation"/>Dealers/Salespersons Recommendation</li>
										<li class="WidthAuto"><input type="checkbox" name="q6_reason_pur[]" value="Friends Recommendation"/>Friends Recommendation</li>
										<li class="WidthAuto">
											<input type="checkbox" name="q6_reason_pur[]" value="Others"/>Others, pls. specify:
											<input type="text" name="q6_reason_pur_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Location you purchased<br/>CITIZEN watch </th>
								<td>
									<ul>
										<li><input type="radio" name="q7_location_pur" value="Mongkok"/>Mongkok</li>
										<li><input type="radio" name="q7_location_pur" value="Causeway Bay"/>Causeway Bay</li>
										<li><input type="radio" name="q7_location_pur" value="Tsim Sha Tsui"/>Tsim Sha Tsui</li>
										<li><input type="radio" name="q7_location_pur" value="New Territories"/>New Territories</li>
										<li><input type="radio" name="q7_location_pur" value="Macau"/>Macau</li>
										<li class="WidthAuto">
											<input type="radio" name="q7_location_pur" value="Others"/>Others, pls. specify:
											<input type="text" name="q7_location_pur_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Channel(s) you received<br/>information about CITIZEN</th>
								<td>
									(Can select more than one answer) 
									<ul>
										<li><input type="checkbox" name="q8_channel_info[]" value="Catalogue/Leaflet"/>Catalogue/Leaflet</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Newspaper/Magazine"/>Newspaper/Magazine</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Internet"/>Internet</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Outdoor Advertising"/>Outdoor Advertising </li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Roadshow"/>Roadshow</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Event Sponsorhip"/>Event Sponsorhip</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Shop Display"/>Shop Display</li>
										<li><input type="checkbox" name="q8_channel_info[]" value="Dealers/Salespersons"/>Dealers/Salespersons</li>
										<li class="WidthAuto">
											<input type="checkbox" name="q8_channel_info[]" value="Others"/>Others, pls. specify:
											<input type="text" name="q8_channel_info_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>3 Brands of watch you<br/>want to own</th>
								<td>
									(Pls. select 3 answers)
									<ul>
										<li><input type="checkbox" name="q9_brands_want[]" value="Agnes b"/>Agnes b</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Cartier"/>Cartier</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Casio"/>Casio</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Cyma"/>Cyma</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Emporio Armani"/>Emporio Armani</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Frank Muller"/>Frank Muller</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Folli Follie"/>Folli Follie</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Fossil"/>Fossil</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Gucci"/>Gucci</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Guess"/>Guess</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Longines"/>Longines</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Omega"/>Omega</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Orient"/>Orient</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Rado"/>Rado</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Rolex"/>Rolex</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Seiko"/>Seiko</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Tag Heuer"/>Tag Heuer</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Tissot"/>Tissot</li>
										<li><input type="checkbox" name="q9_brands_want[]" value="Titus"/>Titus</li>
										<li class="WidthAuto">
											<input type="checkbox" name="q9_brands_want[]" value="Others"/>Others, pls. specify:
											<input type="text" name="q9_brands_want_other" value=""/>
										</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="Continue"/>
								</td>
							</tr>
						</table>
					</form>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}