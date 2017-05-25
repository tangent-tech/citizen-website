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
								<td class="fieldname">Case No.</td>
								<td>{$WarrantyDetail.case_no_a}-{$WarrantyDetail.case_no_b}</td>
							</tr>
							<tr>
								<td class="fieldname">Manufacturer's No.</td>
								<td>{$WarrantyDetail.manu_no}</td>
							</tr>
							<tr>
								<td class="fieldname">Model No.</td>
								<td>{$WarrantyDetail.model_no_a}-{$WarrantyDetail.model_no_b}</td>
							</tr>
							<tr>
								<td class="fieldname">Date of Purchase</td>
								<td>{$WarrantyDetail.pur_date_y} - {$WarrantyDetail.pur_date_m} - {$WarrantyDetail.pur_date_d}</td>
							</tr>
							<tr>
								<td class="fieldname">Retailer's Name</td>
								<td>{$WarrantyDetail.ret_name}</td>
							</tr>
							<tr>
								<td class="fieldname">Retailer's Location</td>
								<td>{$WarrantyDetail.ret_reg}</td>
							</tr>
							<tr>
								<td class="fieldname">Retailer's Address</td>
								<td>{$WarrantyDetail.ret_add}</td>
							</tr>
							<tr>
								<td class="fieldname">Owner's Name</td>
								<td>{$WarrantyDetail.owner_name}</td>
							</tr>
							<tr>
								<td class="fieldname">Contact No.</td>
								<td>{$WarrantyDetail.contact_no}</td>
							</tr>
							<tr>
								<td class="fieldname">Email Address</td>
								<td>{$WarrantyDetail.email}</td>
							</tr>
							<tr>
								<td class="fieldname"><br/></td>
								<td><br/></td>
							</tr>
							<tr>
								<td class="fieldname">Date</td>
								<td>{$WarrantyDetail.ref_date|date_format:"%Y-%m-%d"}</td>
							</tr>
							<tr>
								<td class="fieldname">Ref. No.</td>
								<td>{$WarrantyDetail.ref_no}</td>
							</tr>
						</table>
									
					</div>
							
					<table class="WarrantyResult">
						<tr>
							<td colspan="2" align="left">

								<br/>
								Remarks: Print out the confirmed receipt, and present it with the sales receipt when warranty service is needed.<br/>
								<br/>
								<a id="WarranryPrintBtn" href="#">
									Print Confrimation Receipt
									<img src="{$BASEURL}/images/print_icon.png"/>
								</a>
								<br/>
								<br/>

								<a class="BtnClass" href="{$BASEURL}/warranty_confirm.php">Confirm</a> 

								<a class="BtnClass" href="{$BASEURL}/warranty_part2.php">Modify</a>

								<a class="BtnClass" href="{$BASEURL}/warranty_cancel.php">Cancel</a> 

							</td>
						</tr>
					</table>

				</section>
			</div>

		</main>
	</div>
								
	{*Print Area*}
	<div id="PrintArea">
		{$PrintHtml}
	</div>
								

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}