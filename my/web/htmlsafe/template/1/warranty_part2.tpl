{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$PageTitle}</h1>
			</div>

			<div class="container">
				<section>

					<div class="WarrantyLabel">Three-Year Warranty (Hong Kong & Macau only) </div>
					
					<form id="WarrantyRegistrationForm" class="WarrantyForm" action="{$BASEURL}/warranty_part2_act.php" method="POST">
						
						<table>
							<tr>
								<td colspan="2">
									<strong class="WarrantyNotice">Remarks: Print out the confirmed receipt, and present it with the sales receipt when warranty service is needed.</strong>
								</td>
							</tr>
							<tr>
								<th width="25%">Case No.</th>
								<td width="75%">
									<input class="MinInput" type="text" name="case_no_a" value="{$WarrantyDetail.case_no_a}"/>
									-&nbsp;&nbsp;
									<input class="ShortInput" type="text" name="case_no_b" value="{$WarrantyDetail.case_no_b}"/>

									<img class="tooltipIMG" data-tipcontent="{$BASEURL}/images/warranty/case_sample_en.jpg" title=""
										 src="{$BASEURL}/images/warranty/button_whatcase_off_en.jpg" width="120" height="20" alt="What is Case No."/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Manufacturer's No.</th>
								<td>
									<input class="ShortInput" type="text" name="manu_no" value="{$WarrantyDetail.manu_no}"/>

									<img class="tooltipIMG" data-tipcontent="{$BASEURL}/images/warranty/manufacturer_sample_en.jpg" title=""
										 src="{$BASEURL}/images/warranty/button_whatmanu_off_en.jpg" width="182" height="20" alt="What is Manufacturer's No."/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Model No.</th>
								<td>
									<input class="ShortInput" type="text" name="model_no_a" value="{$WarrantyDetail.model_no_a}"/>
									-&nbsp;&nbsp;
									<input class="MinInput" type="text" name="model_no_b" value="{$WarrantyDetail.model_no_b}"/>

									<img class="tooltipIMG" data-tipcontent="{$BASEURL}/images/warranty/model_sample_en.jpg" title=""
										 src="{$BASEURL}/images/warranty/button_whatmodel_off_en.jpg" width="126" height="20" alt="What is Model No."/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Date of Purchase</th>
								<td>
									<select class="DateSelect" name="date_y">
										{for $Year=$smarty.now|date_format:"Y" to WARRANTY_PURCHASE_YEAR_START step=-1}
											<option value="{$Year}" {if $WarrantyDetail.pur_date_y == $Year}selected{/if}>{$Year}</option>
										{/for}
									</select>
									-&nbsp;&nbsp;
									<select class="DateSelect" name="date_m">
										{for $Month=1 to 12}
											<option value="{$Month}" {if $WarrantyDetail.pur_date_m == $Month}selected{/if}>{$Month}</option>
										{/for}
									</select>
									-&nbsp;&nbsp;
									<select class="DateSelect" name="date_d">
										{for $Day=1 to 31}
											<option value="{$Day}" {if $WarrantyDetail.pur_date_d == $Day}selected{/if}>{$Day}</option>
										{/for}
									</select>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Retailer's Name</th>
								<td>
									<input type="text" name="retailer_name" value="{$WarrantyDetail.ret_name}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Retailer's Location</th>
								<td>
									<ul>
										<li><input type="radio" name="retailer_reg" value="Hong Kong" {if $WarrantyDetail.ret_reg == "Hong Kong"}checked{/if}/>Hong Kong</li>
										<li><input type="radio" name="retailer_reg" value="Macau" {if $WarrantyDetail.ret_reg == "Macau"}checked{/if}/>Macau</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Retailer's Address</th>
								<td>
									<input type="text" name="retailer_add" value="{$WarrantyDetail.ret_add}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Owner's Name</th>
								<td>
									<input type="text" name="owner_name" value="{$WarrantyDetail.owner_name}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Contact No.</th>
								<td>
									<input type="text" name="contact_no" value="{$WarrantyDetail.contact_no}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<th>Email Address</th>
								<td>
									<input type="text" name="email_add" value="{$WarrantyDetail.email}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							
							<tr>
								<td colspan="2">
									<input type="checkbox" name="is_subscribe" value="1"/>
									&nbsp;&nbsp;
									All information provided will be treated confidentially. Please check this box if you want to receive any product or promotional news from CITIZEN in the future.
									
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">

									<input type="submit" value="Next"/>

									<input type="reset" value="Reset"/>

								</td>
							</tr>
						</table>
						
					</form>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}