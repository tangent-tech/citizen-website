<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
<link rel="stylesheet" type="text/css" href="../css/{$CurrentLang.language_id}/groupbuy_report.css" />
</head>
<body>
	<h1>{$Product.object_name}</h1>
	<table>
		<tr>
			<th>Order No</th>
			<th>Security Code 1</th>
			<th>Security Code 2</th>
		</tr>
		{foreach from=$PrintOrderList item=O}
			<tr class="{cycle values='tr0,tr1'}">
				<td>{$O.order_no}-{$O.QuantityNo}</td>
				<td>{$O.SecurityCode1}</td>
				<td>{$O.SecurityCode2}</td>
			</tr>
		{/foreach}
	</table>
</body>
</html>
