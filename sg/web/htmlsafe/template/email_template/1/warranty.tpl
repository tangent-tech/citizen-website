
	<style>
		* {
			font-family: Verdana;
		}
	</style>

	<table width="800" cellpadding="3">
		<tr>
			<td align="center" style="border-bottom:2px solid #E5E5E5;">
				<br/>
				<img src="{$smarty.const.REMOTE_BASEURL}/images/email/email_logo.jpg"/><br/>
				<br/>
			</td>
		</tr>
		<tr>
			<td align="center">
				<br/>
				<font style="font-size:21pt;">Warranty Registration</font><br/>
				<br/>
				<img src="{$smarty.const.REMOTE_BASEURL}/images/email/email_label_bottom.jpg"/><br/>
				<br/>
			</td>
		</tr>
		<tr>
			<td align="left" bgcolor="#989898" style="padding: 15px;">
				<font style="font-size:13pt;color: #FFFFFF;">Warranty Registration</font>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="10">
					<tr>
						<th align='left'  width="30%">Case No.</th>
						<td width="75%">{$WarrantyDetail.case_no_a}-{$WarrantyDetail.case_no_b}</td>
					</tr>
					<tr>
						<th align='left' >Manufacturer's No.</th>
						<td>{$WarrantyDetail.manu_no}</td>
					</tr>
					<tr>
						<th align='left' >Model No.</th>
						<td>{$WarrantyDetail.model_no_a}-{$WarrantyDetail.model_no_b}</td>
					</tr>
					<tr>
						<th align='left' >Date of Purchase</th>
						<td>{$WarrantyDetail.pur_date_y} - {$WarrantyDetail.pur_date_m} - {$WarrantyDetail.pur_date_d}</td>
					</tr>
					<tr>
						<th align='left' >Retailer's Name</th>
						<td>{$WarrantyDetail.ret_name}</td>
					</tr>
					<tr>
						<th align='left' >Retailer's Location</th>
						<td>{$WarrantyDetail.ret_reg}</td>
					</tr>
					<tr>
						<th align='left' >Retailer's Address</th>
						<td>{$WarrantyDetail.ret_add}</td>
					</tr>
					<tr>
						<th align='left' >Owner's Name</th>
						<td>{$WarrantyDetail.owner_name}</td>
					</tr>
					<tr>
						<th align='left' >Contact No.</th>
						<td>{$WarrantyDetail.contact_no}</td>
					</tr>
					<tr>
						<th align='left' >Email Address</th>
						<td>{$WarrantyDetail.email}</td>
					</tr>
					<tr>
						<th align='left' >Date</th>
						<td>{$WarrantyDetail.ref_date|date_format:"%Y-%m-%d"}</td>
					</tr>
					<tr>
						<th align='left' >Ref. No.</th>
						<td>{$WarrantyDetail.ref_no}</td>
					</tr>		
				</table>
			</td>
		</tr>
		
	</table>