
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
				<font style="font-size:21pt;">保用証登記</font><br/>
				<br/>
				<img src="{$smarty.const.REMOTE_BASEURL}/images/email/email_label_bottom.jpg"/><br/>
				<br/>
			</td>
		</tr>
		<tr>
			<td align="left" bgcolor="#989898" style="padding: 15px;">
				<font style="font-size:13pt;color: #FFFFFF;">保用証登記</font>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="10">
					<tr>
						<th align='left'  width="30%">錶殼號碼</th>
						<td width="75%">{$WarrantyDetail.case_no_a}-{$WarrantyDetail.case_no_b}</td>
					</tr>
					<tr>
						<th align='left' >製造廠號碼</th>
						<td>{$WarrantyDetail.manu_no}</td>
					</tr>
					<tr>
						<th align='left' >商品號碼</th>
						<td>{$WarrantyDetail.model_no_a}-{$WarrantyDetail.model_no_b}</td>
					</tr>
					<tr>
						<th align='left' >購買日期</th>
						<td>{$WarrantyDetail.pur_date_y} - {$WarrantyDetail.pur_date_m} - {$WarrantyDetail.pur_date_d}</td>
					</tr>
					<tr>
						<th align='left' >經銷鐘錶商號名稱</th>
						<td>{$WarrantyDetail.ret_name}</td>
					</tr>
					<tr>
						<th align='left' >經銷鐘錶商號地區</th>
						<td>{$WarrantyDetail.ret_reg}</td>
					</tr>
					<tr>
						<th align='left' >經銷鐘錶商號地址</th>
						<td>{$WarrantyDetail.ret_add}</td>
					</tr>
					<tr>
						<th align='left' >錶主</th>
						<td>{$WarrantyDetail.owner_name}</td>
					</tr>
					<tr>
						<th align='left' >聯絡電話</th>
						<td>{$WarrantyDetail.contact_no}</td>
					</tr>
					<tr>
						<th align='left' >電郵地址</th>
						<td>{$WarrantyDetail.email}</td>
					</tr>
					<tr>
						<th align='left' >日期</th>
						<td>{$WarrantyDetail.ref_date|date_format:"%Y-%m-%d"}</td>
					</tr>
					<tr>
						<th align='left' >參考編號</th>
						<td>{$WarrantyDetail.ref_no}</td>
					</tr>		
				</table>
			</td>
		</tr>
		
	</table>