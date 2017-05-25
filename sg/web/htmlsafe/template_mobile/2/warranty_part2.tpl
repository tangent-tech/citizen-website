{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$PageTitle}</h1>
			</div>

			<div class="container">
				<section>

					<div class="WarrantyLabel">3年保養 (只適用於港澳地區)</div>
					
					<form id="WarrantyRegistrationForm" class="WarrantyForm" action="{$BASEURL}/warranty_part2_act.php" method="POST">
						
						<table>
							<tr>
								<td>
									<strong class="WarrantyNotice">註：請列印此確認書，在維修服務時，請出示店舖所發之收據及本確認書。</strong>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">錶殼號碼</div>
									<br/>
									<input class="MinInput" type="text" name="case_no_a" value="{$WarrantyDetail.case_no_a}"/>
									-&nbsp;&nbsp;
									<input class="ShortInput" type="text" name="case_no_b" value="{$WarrantyDetail.case_no_b}"/>
									<div class="ErrorBlock"></div>
									<br/>
									<img src="{$BASEURL}/images/warranty/button_whatcase_off_tc.jpg" width="120" height="20" alt="What is Case No."/><br/>
									<br/>
									<img src="{$BASEURL}/images/warranty/case_sample_tc.jpg" width="280"/>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">製造廠號碼</div>
									<br/>
									<input class="ShortInput" type="text" name="manu_no" value="{$WarrantyDetail.manu_no}"/>
									<div class="ErrorBlock"></div>
									<br/>
									<img src="{$BASEURL}/images/warranty/button_whatmanu_off_tc.jpg" width="182" height="20" alt="What is Manufacturer's No."/><br/>
									<br/>
									<img src="{$BASEURL}/images/warranty/manufacturer_sample_tc.jpg" width="280"/>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">商品號碼</div>
									<br/>
									<input class="ShortInput" type="text" name="model_no_a" value="{$WarrantyDetail.model_no_a}"/>
									-&nbsp;&nbsp;
									<input class="MinInput" type="text" name="model_no_b" value="{$WarrantyDetail.model_no_b}"/>
									<div class="ErrorBlock"></div>
									<br/>
									<img src="{$BASEURL}/images/warranty/button_whatmodel_off_tc.jpg" width="126" height="20" alt="What is Model No."/><br/>
									<br/>
									<img src="{$BASEURL}/images/warranty/model_sample_tc.jpg"/>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">購買日期</div>
									<br/>
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
								<td>
									<div class="WarrantyFormFieldName">經銷鐘錶商號名稱</div>
									<br/>
									<input type="text" name="retailer_name" value="{$WarrantyDetail.ret_name}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">經銷鐘錶商號地區</div>
									<br/>
									<ul>
										<li><input type="radio" name="retailer_reg" value="Hong Kong" {if $WarrantyDetail.ret_reg == "Hong Kong"}checked{/if}/>香港</li>
										<li><input type="radio" name="retailer_reg" value="Macau" {if $WarrantyDetail.ret_reg == "Macau"}checked{/if}/>澳門</li>
									</ul>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">經銷鐘錶商號地址</div>
									<br/>
									<input type="text" name="retailer_add" value="{$WarrantyDetail.ret_add}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">錶主</div>
									<br/>
									<input type="text" name="owner_name" value="{$WarrantyDetail.owner_name}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">聯絡電話</div>
									<br/>
									<input type="text" name="contact_no" value="{$WarrantyDetail.contact_no}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="WarrantyFormFieldName">電郵地址</div>
									<br/>
									<input type="text" name="email_add" value="{$WarrantyDetail.email}"/>
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							
							<tr>
								<td>
									<input type="checkbox" name="is_subscribe" value="1"/>
									&nbsp;&nbsp;
									您提供的所有資料將被嚴格保密。如果你想收到任何產品或促銷新聞請選此框。
									
									<div class="ErrorBlock"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">

									<input type="submit" value="下一步"/>

									<input type="reset" value="重置"/>

								</td>
							</tr>
						</table>
						
					</form>

				</section>
			</div>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}