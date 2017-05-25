{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$PageTitle}</h1>
			</div>

			<div class="container">
				<section>

					<div>

						<div class="WarrantyLabel">{$PageTitle}</div>
						<br/>
						
						<table class="WarrantyResult">
							<tr>
								<td class="fieldname">錶殼號碼</td>
								<td>{$WarrantyDetail.case_no_a}-{$WarrantyDetail.case_no_b}</td>
							</tr>
							<tr>
								<td class="fieldname">製造廠號碼</td>
								<td>{$WarrantyDetail.manu_no}</td>
							</tr>
							<tr>
								<td class="fieldname">商品號碼</td>
								<td>{$WarrantyDetail.model_no_a}-{$WarrantyDetail.model_no_b}</td>
							</tr>
							<tr>
								<td class="fieldname">購買日期</td>
								<td>{$WarrantyDetail.pur_date_y} - {$WarrantyDetail.pur_date_m} - {$WarrantyDetail.pur_date_d}</td>
							</tr>
							<tr>
								<td class="fieldname">經銷鐘錶商號名稱</td>
								<td>{$WarrantyDetail.ret_name}</td>
							</tr>
							<tr>
								<td class="fieldname">經銷鐘錶商號地區</td>
								<td>{$WarrantyDetail.ret_reg}</td>
							</tr>
							<tr>
								<td class="fieldname">經銷鐘錶商號地址</td>
								<td>{$WarrantyDetail.ret_add}</td>
							</tr>
							<tr>
								<td class="fieldname">錶主</td>
								<td>{$WarrantyDetail.owner_name}</td>
							</tr>
							<tr>
								<td class="fieldname">聯絡電話</td>
								<td>{$WarrantyDetail.contact_no}</td>
							</tr>
							<tr>
								<td class="fieldname">電郵地址</td>
								<td>{$WarrantyDetail.email}</td>
							</tr>
							<tr>
								<td class="fieldname"><br/></td>
								<td><br/></td>
							</tr>
							<tr>
								<td class="fieldname">日期</td>
								<td>{$WarrantyDetail.ref_date|date_format:"%Y-%m-%d"}</td>
							</tr>
							<tr>
								<td class="fieldname">參考編號</td>
								<td>{$WarrantyDetail.ref_no}</td>
							</tr>
						</table>
									
					</div>
						
					<table class="WarrantyResult">
						<tr>
							<td colspan="2" align="left">

								<br/>
								註：請列印此確認書，在維修服務時，請出示店舖所發之收據及本確認書。<br/>
								<br/>
								<a id="WarranryPrintBtn" href="#">
									列印確認書
									<img src="{$BASEURL}/images/print_icon.png"/>
								</a>
								<br/>
								<br/>

								<a class="BtnClass" href="{$BASEURL}/warranty_confirm.php">確認</a> 

								<a class="BtnClass" href="{$BASEURL}/warranty_part2.php">修改</a>

								<a class="BtnClass" href="{$BASEURL}/warranty_cancel.php">取消</a> 

							</td>
						</tr>
					</table>

				</section>
			</div>

		</main>
	</div>
								
	{*Print Area*}
	<div id="PrintArea">
		{include file="email_template/`$CurrentLang->language_root->language_id`/warranty.tpl"}
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}