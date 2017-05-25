<?php
// urlencode:
//		=		%3D
//		>		%3E
//		>=		%3E%3D
//		<		%3C
//		<=		%3C%3D
//
// parameters:
#fields_logical_operator - AND / OR
#security_level
#page_no
#objects_per_page
#product_category_id - 0 for all
#include_sub_category - Default: N 
#product_category_special_no - 0 for all
#lang_id
#exclude_product_id - comma seperated list of product_id (e.g. exclude the current product for related products search)
#object_name
#object_name_wildcard - both / front / end / none
#counter_alltime
#counter_alltime_operator - = / > / >= / < / <=
#product_stock_level
#product_stock_level_operator - = / > / >= / < / <=
#product_price (double)
#product_price_operator - = / > / >= / < / <=
#product_price2 (double)
#product_price2_operator - = / > / >= / < / <=
#product_price3 (double)
#product_price3_operator - = / > / >= / < / <=
#product_bonus_point_amount
#product_bonus_point_amount_operator - = / > / >= / < / <=
#product_brand_id
#factory_code
#factory_code_wildcard - both / front / end / none
#product_color
#product_color_wildcard - both / front / end / none
#product_code
#product_code_wildcard - both / front / end / none
#product_weight
#product_weight_operator - = / > / >= / < / <=
#product_size
#product_size_wildcard - both / front / end / none
#product_L
#product_L_operator - = / > / >= / < / <=
#product_W
#product_W_operator - = / > / >= / < / <=
#product_D
#product_D_operator - = / > / >= / < / <=
#product_custom_int_1 to product_custom_int_10
#product_custom_int_1_operator to product_custom_int_10_operator - = / > / >= / < / <=
#product_custom_double_1 to product_custom_double_10
#product_custom_double_1_operator to product_custom_double_10_operator - = / > / >= / < / <=
#product_custom_date_1 to product_custom_date_10
#product_custom_date_1_operator to product_custom_date_10_operator - = / > / >= / < / <=
#product_custom_text_1_operator to product_custom_text_20_operator - and / or (default)
#product_custom_text_1 to product_custom_text_20
#product_custom_text_1_wildcard to product_custom_text_20_wildcard - both / front / end / none
#product_name
#product_name_wildcard - both / front / end / none
#product_packaging
#product_packaging_wildcard - both / front / end / none
#product_desc
#product_desc_wildcard - both / front / end / none
#product_tag
#product_tag_operator - and / or (default)
#counter_alltime
#counter_alltime_operator - = / > / >= / < / <=
#object_vote_sum_1 to object_vote_sum_9
#object_vote_sum_1_operator to object_vote_sum_9_operator - = / > / >= / < / <=
#object_vote_count_1 to object_vote_count_9
#object_vote_count_1_operator to object_vote_count_9_operator - = / > / >= / < / <=
#object_vote_average_1 to object_vote_average_9
#object_vote_average_1_operator to object_vote_average_9_operator - = / > / >= / < / <=
#order_by_random - default: N, REMEMBER TO TURN OFF CACHE ON THIS CALL
#order_by_counter_alltime - asc / desc / null
#order_by_product_price - asc / desc / null
#order_by_object_vote_sum_1 to order_by_object_vote_sum_9 - asc / desc / null
#order_by_object_vote_count_1 to order_by_object_vote_count_9 - asc / desc / null
#order_by_object_vote_average_1 to order_by_object_vote_average_9 - asc / desc / null
#order_by_object_link_order_id - asc /desc /null
#order_by_object_global_order_id - asc /desc /null
#order_by_product_custom_date_1 to order_by_product_custom_date_20 - asc /desc /null
#product_option_data_text_1 to product_option_data_text_9
#product_option_data_text_1_wildcard to product_option_data_text_9_wildcard - both / front / end / none
#product_option_data_rgb_1 to product_option_data_rgb_9
#product_option_stock_level
#product_option_stock_level_operator - = / > / >= / < / <=
#product_option_quantity_sold
#product_option_quantity_sold_operator - = / > / >= / < / <=

#return_value_range_of_product_price - default: N
#return_value_range_of_product_weight - default: N
#return_value_range_of_product_custom_int_1 to return_value_range_of_product_custom_int_10 - default: N
#return_value_range_of_product_custom_double_1 to return_value_range_of_product_custom_double_10 - default: N
#return_value_range_of_product_custom_date_1 to return_value_range_of_product_custom_date_10 - default: N
#return_value_list_of_product_brand_id - default: N
#return_value_list_of_product_custom_int_1 to return_value_list_of_product_custom_int_10 - default: N
#return_value_list_of_product_custom_double_1 to return_value_list_of_product_custom_double_10 - default: N
#return_value_list_of_product_custom_date_1 to return_value_list_of_product_custom_date_10 - default: N

#return_value_list_of_product_custom_text_1 to return_value_list_of_product_custom_text_20 - default: N

#return_value_list_of_product_option_data_text_1 to return_value_list_of_product_option_data_text_9 - default: N
#return_value_list_of_product_option_data_rgb_1 to return_value_list_of_product_option_data_rgb_9 - default: N

#return_value_list_of_product_color - default: N

#return_product_category_list - default: N

#include_media_details - default: N
#media_page_no - default: 1
#media_per_page - default: 10

#include_datafile_details - default: N
#datafile_page_no - default: 1
#datafile_per_page - default: 10

#group_function - default: min, possible values: min, max, avg (This is required to determine the ordering of product group. Consider three products inside product group with three different values, which one to compare?) 

#return_product_group_instead_of_products - default: Y

#no_stock_product_at_last - default: N

#currency_id - default: site default currency
#product_price_id - default: default: 1
define('IN_CMS', true);
require_once('../common/config.php');
//require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/common_api.php');

site::IncrementApiStats($Site['site_id'], __FILE__);

$PageNo = intval($_REQUEST['page_no']);
if ($PageNo <= 0)
	$PageNo = 1;
$ObjectsPerPage = intval($_REQUEST['objects_per_page']);
$Offset = ($PageNo -1) * $ObjectsPerPage;

if (intval($_REQUEST['media_page_no']) <= 0)
	$_REQUEST['media_page_no'] = 1;
if (intval($_REQUEST['media_per_page']) <= 0)
	$_REQUEST['media_per_page'] = 10;

if (intval($_REQUEST['datafile_page_no']) <= 0)
	$_REQUEST['datafile_page_no'] = 1;
if (intval($_REQUEST['datafile_per_page']) <= 0)
	$_REQUEST['datafile_per_page'] = 10;

if (isset($_REQUEST['product_price_id']))
	$EffectiveProductPriceID = intval($_REQUEST['product_price_id']);
else {
	if (strtolower($_REQUEST['order_by_product_price']) == 'asc' || strtolower($_REQUEST['order_by_product_price']) == 'desc') {
		$EffectiveProductPriceID = 1;
	}
	else if (strtolower($_REQUEST['order_by_product_price2']) == 'asc' || strtolower($_REQUEST['order_by_product_price2']) == 'desc') {
		$EffectiveProductPriceID = 2;
	}
	else if (strtolower($_REQUEST['order_by_product_price3']) == 'asc' || strtolower($_REQUEST['order_by_product_price3']) == 'desc') {
		$EffectiveProductPriceID = 3;
	}
	else
		$EffectiveProductPriceID = 1;
}

$ProductPriceValueRangeFields = array('product_price');

$ProductValueRangeFields = array('product_weight');
for ($i = 1; $i <= 20; $i++) {
	$FieldName = 'product_custom_int_' . $i; 
	array_push($ProductValueRangeFields, $FieldName);
	$FieldName = 'product_custom_double_' . $i; 
	array_push($ProductValueRangeFields, $FieldName);
	$FieldName = 'product_custom_date_' . $i; 
	array_push($ProductValueRangeFields, $FieldName);
}

$ProductValueListFields = array('product_brand_id');
for ($i = 1; $i <= 20; $i++) {
	$FieldName = 'product_custom_int_' . $i; 
	array_push($ProductValueListFields, $FieldName);
	$FieldName = 'product_custom_double_' . $i; 
	array_push($ProductValueListFields, $FieldName);
	$FieldName = 'product_custom_date_' . $i; 
	array_push($ProductValueListFields, $FieldName);
}

$ProductDataValueListFields = array();
for ($i = 1; $i <= 20; $i++) {
	$FieldName = 'product_custom_text_' . $i;
	array_push($ProductDataValueListFields, $FieldName);
}
array_push($ProductDataValueListFields, 'product_color');

$ProductOptionDataValueListFields = array();
for ($i = 1; $i <= 9; $i++) {
	$FieldName = 'product_option_data_text_' . $i;
	array_push($ProductOptionDataValueListFields, $FieldName);

	$FieldName = 'product_option_data_rgb_' . $i;
	array_push($ProductOptionDataValueListFields, $FieldName);
}

$ProductNumericFields = array('product_stock_level', 'product_bonus_point_amount', 'product_weight', 'product_L', 'product_W', 'product_D');
for ($i = 1; $i <= 20; $i++) {
	$FieldName = 'product_custom_int_' . $i; 
	array_push($ProductNumericFields, $FieldName);
	$FieldName = 'product_custom_double_' . $i; 
	array_push($ProductNumericFields, $FieldName);
	$FieldName = 'product_custom_date_' . $i; 
	array_push($ProductNumericFields, $FieldName);
}

$ProductStringFields		= array(
								'factory_code', 'product_code', 'product_size'
							);
$ProductDataStringFields	= array(
								'product_name', 'product_packaging', 'product_desc', 'product_color'
							);
//for ($i = 1; $i <= 20; $i++) {
//	$FieldName = 'product_custom_text_' . $i; 
//	array_push($ProductDataStringFields, $FieldName);
//}

$ProductOptionDataFields = array();
for ($i = 1; $i <= 9; $i++) {
	$FieldName = 'product_option_data_text_' . $i; 
	array_push($ProductOptionDataFields, $FieldName);

	$FieldName = 'product_option_data_rgb_' . $i; 
	array_push($ProductOptionDataFields, $FieldName);
}

$ProductOptionNumericFields = array(
							'product_option_stock_level', 'product_option_quantity_level'
						);

$ProductPriceNumbericFields = array(
							'product_price'
						);

$ObjectLinkStringFields		= array(
								'object_name'
							);
$ObjectNumericFields		= array(
								'counter_alltime',
								'object_vote_sum_1', 'object_vote_count_1', 'object_vote_average_1',
								'object_vote_sum_2', 'object_vote_count_2', 'object_vote_average_2',
								'object_vote_sum_3', 'object_vote_count_3', 'object_vote_average_3',
								'object_vote_sum_4', 'object_vote_count_4', 'object_vote_average_4',
								'object_vote_sum_5', 'object_vote_count_5', 'object_vote_average_5',
								'object_vote_sum_6', 'object_vote_count_6', 'object_vote_average_6',
								'object_vote_sum_7', 'object_vote_count_7', 'object_vote_average_7',
								'object_vote_sum_8', 'object_vote_count_8', 'object_vote_average_8',
								'object_vote_sum_9', 'object_vote_count_9', 'object_vote_average_9'
							);

function GetNumericSQL($Field, $Operator, $Value, $DBSuffix) {
	if (trim($Value) == '')
		return null;

	// =, >, >=, <, <=, [], (), (], [)
	$OperatorSign = '=';
	$RangeOperators = array('[]', '()', '(]', '[)');
	$RangeOperator = false;

	if ($Operator == '>')
		$OperatorSign = '>';
	elseif ($Operator == '>=')
		$OperatorSign = '>=';
	elseif ($Operator == '<')
		$OperatorSign = '<';
	elseif ($Operator == '<=')
		$OperatorSign = '<=';
	elseif (in_array($Operator, $RangeOperators))
		$RangeOperator = true;

	if (!$RangeOperator)
		return $DBSuffix . "." . $Field . $OperatorSign . "'" . trim($Value) . "' ";
	else {
		list($Min, $Max) = explode(',', $Value);
		
		if ($Operator == '[]')
			return "( " . $DBSuffix . "." . $Field .  " >= '" . $Min . "' AND " . $DBSuffix . "." . $Field . " <= '" . $Max . "')";
		elseif ($Operator == '()')
			return "( " . $DBSuffix . "." . $Field .  " > '" . $Min . "' AND " . $DBSuffix . "." . $Field . " < '" . $Max . "')";
		elseif ($Operator == '(]')
			return "( " . $DBSuffix . "." . $Field .  " > '" . $Min . "' AND " . $DBSuffix . "." . $Field . " <= '" . $Max . "')";
		elseif ($Operator == '[)')
			return "( " . $DBSuffix . "." . $Field .  " >= '" . $Min . "' AND " . $DBSuffix . "." . $Field . " < '" . $Max . "')";
	}
}

function GetStringSQL($Field, $Wildcard, $Value) {
	if (trim($Value) == '')
		return null;

	$WildcardCharFront	= '%';
	$WildcardCharEnd	= '%';

	if ($Wildcard == 'none') {
		$WildcardCharFront	= '';
		$WildcardCharEnd	= '';
	}
	elseif ($Wildcard == 'front') {
		$WildcardCharFront	= '%';
		$WildcardCharEnd	= '';
	}
	elseif ($Wildcard == 'end') {
		$WildcardCharFront	= '';
		$WildcardCharEnd	= '%';
	}

	return $Field . " LIKE '" . $WildcardCharFront . aveEscT($Value) . $WildcardCharEnd . "' ";
}

$fields_logical_operator = ' AND ';
if (strtoupper($_REQUEST['fields_logical_operator']) == 'OR')
	$fields_logical_operator = ' OR ';

$FieldSQL = '';

foreach ($ProductNumericFields as $F) {
	$sql = GetNumericSQL($F, $_REQUEST[$F . '_operator'], $_REQUEST[$F], 'P');

	if ($sql != null)
		$FieldSQL = $FieldSQL . $sql . $fields_logical_operator;
}

foreach ($ProductStringFields as $F) {
	$sql = GetStringSQL($F, $_REQUEST[$F . '_wildcard'], $_REQUEST[$F]);

	if ($sql != null)
		$FieldSQL = $FieldSQL . 'P.' . $sql . $fields_logical_operator;
}

foreach ($ProductDataStringFields as $F) {
	$sql = GetStringSQL($F, $_REQUEST[$F . '_wildcard'], $_REQUEST[$F]);

	if ($sql != null)
		$FieldSQL = $FieldSQL . 'PD.' . $sql . $fields_logical_operator;
}

foreach ($ProductOptionNumericFields as $F) {
	$sql = GetNumericSQL($F, $_REQUEST[$F . '_operator'], $_REQUEST[$F], 'PO');

	if ($sql != null)
		$FieldSQL = $FieldSQL . $sql . $fields_logical_operator;
}

foreach ($ProductOptionDataFields as $F) {
	$sql = GetStringSQL($F, $_REQUEST[$F . '_wildcard'], $_REQUEST[$F]);

	if ($sql != null)
		$FieldSQL = $FieldSQL . 'POD.' . $sql . $fields_logical_operator;
}

foreach ($ObjectNumericFields as $F) {
	$sql = GetNumericSQL($F, $_REQUEST[$F . '_operator'], $_REQUEST[$F], 'O');

	if ($sql != null)
		$FieldSQL = $FieldSQL . $sql . $fields_logical_operator;
}

foreach ($ObjectLinkStringFields as $F) {
	$sql = GetStringSQL($F, $_REQUEST[$F . '_wildcard'], $_REQUEST[$F]);

	if ($sql != null)
		$FieldSQL = $FieldSQL . 'OL.' . $sql . $fields_logical_operator;
}

foreach ($ProductPriceNumbericFields as $F) {
	$sql = GetNumericSQL($F, $_REQUEST[$F . '_operator'], $_REQUEST[$F], 'PP');

	if ($sql != null)
		$FieldSQL = $FieldSQL . $sql . $fields_logical_operator;
}

// if (trim($_REQUEST['product_tag']) != '')
//	$FieldSQL = $FieldSQL . "PD.product_tag		LIKE '%, " . trim($_REQUEST['product_tag']) . ",%' " . $fields_logical_operator;

if (trim($_REQUEST['product_tag']) != '') {
	$TagOperator = 'OR ';
	$TagSubstrLength = -3;
	
	if (strtolower(trim($_REQUEST['product_tag_operator'])) == 'and') {
		$TagOperator = 'AND ';
		$TagSubstrLength = -4;
	}
	
	
	$Tags = explode(',', trim($_REQUEST['product_tag']));
	
	$TagSQL = '';
	foreach ($Tags as $T) {
		$TagSQL = $TagSQL . "PD.product_tag LIKE '%, " . aveEscT($T) . ",%' " . $TagOperator;
	}
	
	if (strlen($TagSQL) > 0)
		$FieldSQL = $FieldSQL . "( " . substr($TagSQL, 0, $TagSubstrLength) . ")" . $fields_logical_operator;
}

for ($i = 1; $i <= 20; $i++) {
	if (trim($_REQUEST['product_custom_text_'. $i]) != '') {
		$textOperator = 'OR ';
		$textSubstrLength = -3;
		
		if (strtolower(trim($_REQUEST['product_custom_text_' . $i . '_operator'])) == 'and') {
			$textOperator = 'AND ';
			$textSubstrLength = -4;
		}
		
		$text = explode(',', trim($_REQUEST['product_custom_text_' . $i]));
		
		$WildcardCharFront	= '%';
		$WildcardCharEnd	= '%';

		if ($_REQUEST['product_custom_text_' . $i . '_wildcard'] == 'none') {
			$WildcardCharFront	= '';
			$WildcardCharEnd	= '';
		}
		elseif ($_REQUEST['product_custom_text_' . $i . '_wildcard'] == 'front') {
			$WildcardCharFront	= '%';
			$WildcardCharEnd	= '';
		}
		elseif ($_REQUEST['product_custom_text_' . $i . '_wildcard'] == 'end') {
			$WildcardCharFront	= '';
			$WildcardCharEnd	= '%';
		}
		
		$textSQL = '';
		foreach ($text as $T) {
			$textSQL = $textSQL . "PD.product_custom_text_" . $i . " LIKE '" . $WildcardCharFront . aveEscT($T) . $WildcardCharEnd . "' " . $textOperator;
		}
		
		if (strlen($textSQL) > 0)
			$FieldSQL = $FieldSQL . "( " . substr($textSQL, 0, $textSubstrLength) . ")" . $fields_logical_operator;
	}
}

if (intval($_REQUEST['product_brand_id']) != 0)
	$FieldSQL = $FieldSQL . "P.product_brand_id = '" . intval($_REQUEST['product_brand_id']) . "' " . $fields_logical_operator;

$FieldSQL = substr($FieldSQL, 0, strlen($fields_logical_operator) * -1);
if (strlen($FieldSQL) == 0)
	$FieldSQL = '2 > 1';

$SpecialCatSQL = '';
if (intval($_REQUEST['product_category_special_no']) > 0 && intval($_REQUEST['product_category_special_no']) < NO_OF_PRODUCT_CAT_SPECIAL) {
	$SpecialCatSQL = " P.is_special_cat_" . intval($_REQUEST['product_category_special_no']) . " = 'Y' AND ";
}

$ProductCatSQL = '';
if (intval($_REQUEST['product_category_id']) > 0) {
	if ($_REQUEST['include_sub_category'] == 'Y') {	
		$TargetObjList = array('PRODUCT_CATEGORY');
		$ValidObjList = array('PRODUCT_CATEGORY', 'PRODUCT_ROOT', 'PRODUCT_ROOT_LINK');
		$ProductCat = object::GetObjectInfo($_REQUEST['product_category_id']);
		$ProductCatList = site::GetAllSubChildObjects($TargetObjList, $ValidObjList, $ProductCat, 0, $_REQUEST['security_level'], 99999, true, true, 'Y', 'N');
		
		$sql = '';
		if (count($ProductCatList) > 0) {
			foreach ($ProductCatList as $C) {
				$SubProductCat = product::GetProductCatInfo($C['object_id'], 0);
				if (!product::IsProductCatAProductGroup($SubProductCat))
					$sql = $sql . " OR OL.parent_object_id = '" . $C['object_id'] . "'";
			}

			if (strlen($sql) > 0) {
				$sql = substr($sql, 3);
				$ProductCatSQL = "(" . $sql . " OR OL.parent_object_id = '" . $_REQUEST['product_category_id'] . "' ) AND ";
			}
			else
				$ProductCatSQL = "	OL.parent_object_id	= '" . $_REQUEST['product_category_id'] . "' AND	";			
		}
		else
			$ProductCatSQL = "	OL.parent_object_id	= '" . $_REQUEST['product_category_id'] . "' AND	";
	}
	else
		$ProductCatSQL = "	OL.parent_object_id	= '" . $_REQUEST['product_category_id'] . "' AND	";		
}
else
	$ProductCatSQL = "	OL.object_link_is_shadow = 'N' AND ";

$ValidGroupFuncFields = array("min", "max", "avg");
if (!isset($_REQUEST['group_function']) || !in_array($_REQUEST['group_function'], $ValidGroupFuncFields))
	$_REQUEST['group_function'] = 'min';

$OrderBySQL = ' ';
$LimitSQL = ' ';
if (ynval($_REQUEST['order_by_random']) != 'Y') {
	if (ynval($_REQUEST['no_stock_product_at_last']) == 'Y') {
		$OrderBySQL = ' SUM(P.product_stock_level) = 0, SUM(PO.product_option_stock_level) = 0,';
	}	
	
	if ($EffectiveProductPriceID != 0) {
		if ($_REQUEST['order_by_product_price'] == 'asc' || $_REQUEST['order_by_product_price2'] == 'asc' || $_REQUEST['order_by_product_price3'] == 'asc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(PP.product_price)' . ' ASC,';
		elseif ($_REQUEST['order_by_product_price'] == 'desc' || $_REQUEST['order_by_product_price2'] == 'desc' || $_REQUEST['order_by_product_price3'] == 'desc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(PP.product_price)' . ' DESC,';	
	}

	if ($_REQUEST['order_by_counter_alltime'] == 'asc')
		$OrderBySQL = $OrderBySQL  . $_REQUEST['group_function'] . '(O.counter_alltime)' . ' ASC,';
	elseif ($_REQUEST['order_by_counter_alltime'] == 'desc')
		$OrderBySQL = $OrderBySQL  . $_REQUEST['group_function'] . '(O.counter_alltime)' . ' DESC,';

	for ($i = 1; $i <= 9; $i++) {
		if ($_REQUEST['order_by_object_vote_sum_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_sum_' . $i . ') ASC,';
		elseif ($_REQUEST['order_by_object_vote_sum_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_sum_' . $i . ') DESC,';
		if ($_REQUEST['order_by_object_vote_count_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_count_' . $i . ') ASC,';
		elseif ($_REQUEST['order_by_object_vote_count_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_count_' . $i . ') DESC,';
		if ($_REQUEST['order_by_object_vote_average_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_average_' . $i . ') ASC,';
		elseif ($_REQUEST['order_by_object_vote_average_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(O.object_vote_average_' . $i . ') DESC,';
	}

	for ($i = 1; $i <= 20; $i++) {
		if ($_REQUEST['order_by_product_custom_date_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(P.product_custom_date_' . $i . ') ASC,';
		elseif ($_REQUEST['order_by_product_custom_date_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . $_REQUEST['group_function'] . '(P.product_custom_date_' . $i . ') DESC,';
	}

	for ($i = 1; $i <= 20; $i++) {
		if ($_REQUEST['order_by_product_custom_text_' . $i] == 'asc')
			$OrderBySQL = $OrderBySQL . 'PD.product_custom_text_' . $i . ' ASC,';
		elseif ($_REQUEST['order_by_product_custom_text_' . $i] == 'desc')
			$OrderBySQL = $OrderBySQL . 'PD.product_custom_text_' . $i . ' DESC,';
	}
	
	if ($_REQUEST['order_by_object_link_order_id'] == 'asc') {
		if ($_REQUEST['include_sub_category'] == 'Y')
			$OrderBySQL = $OrderBySQL . 'OL.parent_object_id ASC, ' . ' OL.order_id' . ' ASC,';
		else
			$OrderBySQL = $OrderBySQL . ' OL.order_id' . ' ASC,';
	}
	elseif ($_REQUEST['order_by_object_link_order_id'] == 'desc') {
		if ($_REQUEST['include_sub_category'] == 'Y')
			$OrderBySQL = $OrderBySQL . 'OL.parent_object_id DESC, ' . ' OL.order_id' . ' ASC,';
		else
	//		$OrderBySQL = $OrderBySQL . ' OL.order_id' . ' DESC,';
			$OrderBySQL = $OrderBySQL . ' O.object_global_order_id' . ' DESC,';
	}

	if ($_REQUEST['order_by_object_global_order_id'] == 'asc') {
		$OrderBySQL = $OrderBySQL . ' MIN(O.object_global_order_id)' . ' ASC,';
	}
	elseif ($_REQUEST['order_by_object_global_order_id'] == 'desc') {
		$OrderBySQL = $OrderBySQL . ' MIN(O.object_global_order_id)' . ' DESC,';
	}

	$OrderBySQL = substr($OrderBySQL, 0, -1);
	if (strlen($OrderBySQL) > 0)
		$OrderBySQL = "ORDER BY " . $OrderBySQL;
	
	$LimitSQL = " LIMIT	" . $Offset . ", " . $ObjectsPerPage;
}

$ExcludeProductIDSQL = '';

$ExcludeProductIDList = explode(",", $_REQUEST['exclude_product_id']);
foreach ($ExcludeProductIDList as $PID) {
	$ExcludeProductIDSQL = $ExcludeProductIDSQL . " P.product_id != '" . intval($PID) . "' AND ";
}

$GroupBySQL = '';
if ($_REQUEST['return_product_group_instead_of_products'] == 'N')
	$GroupBySQL = "	GROUP BY	O.object_id ";
else
	$GroupBySQL = "	GROUP BY	OL.shadow_parent_id ";

$ParentObjTypeExcludeList = array('PRODUCT_BRAND');
$parent_obj_type_exclude_sql = '';
foreach ($ParentObjTypeExcludeList as $POT)
	$parent_obj_type_exclude_sql = " AND PRTO.object_type != '" . $POT . "'";

$CurrencyObj = null;
$Currency = currency::GetCurrencyInfo($_REQUEST['currency_id'], $Site['site_id']);
if ($Currency != null)
	$CurrencyObj = (object) $Currency;

$EffectiveCurrencyID = 0;
if ($Site['site_product_price_indepedent_currency'] == 'Y')
	$EffectiveCurrencyID = $CurrencyObj->currency_id;

$product_price_join_sql = '';
if ($EffectiveProductPriceID != 0) {
	$product_price_join_sql = 			"						JOIN		product_price PP		ON	(P.product_id = PP.product_id AND PP.product_price_id = '" . intval($EffectiveProductPriceID) . "' AND PP.currency_id = '" . intval($EffectiveCurrencyID) . "') ";
}

$TheQuery = "	FROM	object O	JOIN		product P				ON	(O.object_id = P.product_id		AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " .
			"						JOIN		object_link OL			ON	(O.object_id = OL.object_id) " . $product_price_join_sql .
			"						JOIN		object PRTO				ON	(OL.parent_object_id = PRTO.object_id " . $parent_obj_type_exclude_sql . ") " .
			"						LEFT JOIN	product_data PD			ON	(O.object_id = PD.product_id AND PD.language_id = '" . intval($_REQUEST['lang_id']) . "')" .
			"						LEFT JOIN	product_option PO		ON	(P.product_id = PO.product_id) " .
			"						LEFT JOIN	product_option_data POD	ON	(POD.product_option_id = PO.product_option_id AND POD.language_id = '" . intval($_REQUEST['lang_id']) . "')" .
			"	WHERE	O.site_id	= '" . intval($Site['site_id']) . "' " .
			"		AND	O.object_is_enable = 'Y' " .
			"		AND OL.object_link_is_enable = 'Y' " .
			"		AND	O.object_archive_date > NOW() " .
			"		AND	O.object_publish_date < NOW() " .
			"		AND	O.is_removed = 'N' AND " . $ProductCatSQL . $SpecialCatSQL . $ExcludeProductIDSQL .
			"			(" . $FieldSQL . ") ";

$product_price_select_sql = '';
if ($EffectiveProductPriceID != 0) {
	$product_price_select_sql = ', PP.*';
}

$query =	"	SELECT	SQL_CALC_FOUND_ROWS POD.*, PO.*, PD.*, O.*, OL.*, P.*" . $product_price_select_sql . " " .
			$TheQuery . $GroupBySQL . $OrderBySQL . $LimitSQL;

$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

$query =	"	SELECT FOUND_ROWS() ";
$result2 = ave_mysqli_query($query, __FILE__, __LINE__, true);
$myResult = $result2->fetch_row();
$NoOfProducts = $myResult[0];

$smarty->assign('TotalNoOfObjects', $NoOfProducts);

$include_media_details_bool = false;
if (ynval($_REQUEST['include_media_details']) == 'Y')
	$include_media_details_bool = true;

$include_datafile_details_bool = false;
if (ynval($_REQUEST['include_datafile_details']) == 'Y')
	$include_datafile_details_bool = true;

$ObjectsXML = '';
//$ObjectsXML = '<query>' . xmlentities($query) . '</query>';

if (ynval($_REQUEST['order_by_random']) != 'Y') {
	while ($myResult = $result->fetch_assoc()) {

		if ($_REQUEST['return_product_group_instead_of_products'] != 'N' && $myResult['object_link_is_shadow'] == 'Y') {
			$TotalNoOfMedia = 0;

			$MediaListXML = media::GetMediaListXML($myResult['shadow_parent_id'], $_REQUEST['lang_id'], $TotalNoOfMedia, $_REQUEST['media_page_no'], $_REQUEST['media_per_page'], intval($_REQUEST['security_level']));
			$mySmarty = new mySmarty();
			$mySmarty->assign('MediaListXML', $MediaListXML);
			$mySmarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
			$mySmarty->assign('MediaPageNo', $MediaPageNo);
			
			$ProductCatGroup = product::GetProductCatInfo($myResult['shadow_parent_id'], $_REQUEST['lang_id']);
			$ProductCatGroup['product_name'] = $ProductCatGroup['product_category_name'];
			$myResult['object_seo_url'] = object::GetSeoURL($ProductCatGroup, '', $_REQUEST['lang_id'], $Site);
			$mySmarty->assign('Object', $ProductCatGroup);
			
			$ProductCatPriceRange = product::GetProductCatPriceRange($myResult['shadow_parent_id'], $CurrencyObj, $Site);
			$mySmarty->assign('ProductCatPriceRange', $ProductCatPriceRange);			
			
			$ObjectsXML = $ObjectsXML . $mySmarty->fetch('api/object_info/PRODUCT_GROUP.tpl');
		}
		else {	
			$ProductXML = product::GetProductXML($myResult['object_link_id'], $_REQUEST['lang_id'], $include_media_details_bool, $_REQUEST['media_page_no'], $_REQUEST['media_per_page'], intval($_REQUEST['security_level']), $include_datafile_details_bool, $_REQUEST['datafile_page_no'], $_REQUEST['datafile_per_page'], true, null, $CurrencyObj, $Site);
			
			$ObjectsXML = $ObjectsXML . $ProductXML;
		}
	}
}
else {
	
	$RandIndexList = array();
	
	while (count($RandIndexList) < $ObjectsPerPage && count($RandIndexList) < $NoOfProducts) {
		$RandIndex = rand(0, $NoOfProducts -1);
		
		if (!in_array($RandIndex, $RandIndexList))
			array_push($RandIndexList, $RandIndex);
	}
	
	foreach ($RandIndexList as $RandIndex) {
		$result->data_seek($RandIndex);
		
		$myResult = $result->fetch_assoc();
		
		if ($_REQUEST['return_product_group_instead_of_products'] != 'N' && $myResult['object_link_is_shadow'] == 'Y') {
			$TotalNoOfMedia = 0;

			$MediaListXML = media::GetMediaListXML($myResult['shadow_parent_id'], $_REQUEST['lang_id'], $TotalNoOfMedia, $_REQUEST['media_page_no'], $_REQUEST['media_per_page'], intval($_REQUEST['security_level']));
			$mySmarty = new mySmarty();
			$mySmarty->assign('MediaListXML', $MediaListXML);
			$mySmarty->assign('TotalNoOfMedia', $TotalNoOfMedia);
			$mySmarty->assign('MediaPageNo', $MediaPageNo);		
			
			$ProductCatGroup = product::GetProductCatInfo($myResult['shadow_parent_id'], $_REQUEST['lang_id']);
			$ProductCatGroup['product_name'] = $ProductCatGroup['product_category_name'];
			$myResult['object_seo_url'] = object::GetSeoURL($ProductCatGroup, '', $_REQUEST['lang_id'], $Site);
			$mySmarty->assign('Object', $ProductCatGroup);
			
			$ProductCatPriceRange = product::GetProductCatPriceRange($myResult['shadow_parent_id'], $CurrencyObj, $Site);
			$mySmarty->assign('ProductCatPriceRange', $ProductCatPriceRange);
			
			$ObjectsXML = $ObjectsXML . $mySmarty->fetch('api/object_info/PRODUCT_GROUP.tpl');
		}
		else {
			$ProductXML = product::GetProductXML($myResult['object_link_id'], $_REQUEST['lang_id'], $include_media_details_bool, $_REQUEST['media_page_no'], $_REQUEST['media_per_page'], intval($_REQUEST['security_level']), $include_datafile_details_bool, $_REQUEST['datafile_page_no'], $_REQUEST['datafile_per_page'], true, null, $CurrencyObj, $Site);
			$ObjectsXML = $ObjectsXML . $ProductXML;
		}		
	}
}

$smarty->assign('PageNo', $PageNo);
$smarty->assign('ObjectsXML', $ObjectsXML);

function GetValueRangeXML($Field, $DBSuffix, $TheQuery) {
	if ($_REQUEST['return_value_range_of_' . $Field] == 'Y') {
		$FN = $DBSuffix . "." . $Field;
		
		$query =	"	SELECT	MIN(" . $FN. ") AS min_value, MAX(" . $FN . ") AS max_value " .
					$TheQuery;
//					"	GROUP BY " . $FN;

		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$myResult = $result->fetch_row();
		
		$MinValue = $myResult[0];
		$MaxValue = $myResult[1];
		
		return "<value_range_of_" . $Field . "><min_value>" . $MinValue . "</min_value><max_value>" . $MaxValue . "</max_value></value_range_of_" . $Field . ">";
	}
}

function GetValueListXML($Field, $DBSuffix, $TheQuery) {
	if ($_REQUEST['return_value_list_of_' . $Field] == 'Y') {
		$FN = $DBSuffix . "." . $Field;
		
		$query =	"	SELECT	" . $FN. " AS my_value, COUNT(DISTINCT P.product_id) AS my_count " .
					$TheQuery . 
					"	GROUP BY " . $FN .
					"	ORDER BY " . $FN;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$TheXML;
		while ($myResult = $result->fetch_row()) {
			$TheXML .= "<value>" . xmlentities($myResult[0]) . "</value>";
			$TheXML .= "<count>" . xmlentities($myResult[1]) . "</count>";
		}
		return "<value_list_of_" . $Field . ">" . $TheXML . "</value_list_of_" . $Field . ">";
	}	
}

$ValueRangeValueListXML = '';
foreach ($ProductValueRangeFields as $F)
	$ValueRangeValueListXML .= GetValueRangeXML($F, 'P', $TheQuery);
foreach ($ProductValueListFields as $F)
	$ValueRangeValueListXML .= GetValueListXML($F, 'P', $TheQuery);
foreach ($ProductOptionDataValueListFields as $F)
	$ValueRangeValueListXML .= GetValueListXML($F, 'POD', $TheQuery);
foreach ($ProductDataValueListFields as $F)
	$ValueRangeValueListXML .= GetValueListXML($F, 'PD', $TheQuery);
foreach ($ProductPriceValueRangeFields as $F)
	$ValueRangeValueListXML .= GetValueRangeXML($F, 'PP', $TheQuery);

if ($_REQUEST['return_product_category_list'] == 'Y') {
	$product_price_join_sql = '';
	if ($EffectiveProductPriceID != 0) {
		$product_price_join_sql = "						JOIN		product_price PP		ON	(P.product_id = PP.product_id AND PP.product_price_id = '" . intval($EffectiveProductPriceID) . "' AND PP.currency_id = '" . intval($EffectiveCurrencyID) . "') ";
	}	
	
	$query =	"	SELECT COL.*, PCD.*, CO.*, C.*, COUNT(DISTINCT P.product_id) AS no_of_products " .
				"	FROM	object O	JOIN		product P					ON	(O.object_id = P.product_id		AND O.object_security_level <= '" . intval($_REQUEST['security_level']) . "') " . $product_price_join_sql .
				"						JOIN		object_link OL				ON	(O.object_id = OL.object_id) " .
				"						LEFT JOIN	product_data PD				ON	(O.object_id = PD.product_id AND PD.language_id = '" . intval($_REQUEST['lang_id']) . "') " .
				"						JOIN		product_category C			ON	(C.product_category_id = OL.parent_object_id) " .
				"						JOIN		object CO					ON	(CO.object_id = C.product_category_id) " .
				"						JOIN		object_link COL				ON	(CO.object_id = COL.object_id) " .
				"						LEFT JOIN	product_category_data PCD	ON	(PCD.product_category_id = C.product_category_id AND PCD.language_id = '" . intval($_REQUEST['lang_id']) . "')" .
				"						LEFT JOIN	product_option PO			ON	(P.product_id = PO.product_id) " .
				"						LEFT JOIN	object POO					ON	(PO.product_option_id = POO.object_id AND POO.object_is_enable = 'Y') " .
				"						LEFT JOIN	product_option_data POD		ON	(POD.product_option_id = PO.product_option_id AND POD.language_id = '" . intval($_REQUEST['lang_id']) . "')" .
				"	WHERE	O.site_id	= '" . intval($Site['site_id']) . "' " .
				"		AND CO.object_is_enable = 'Y' " .
				"		AND COL.object_link_is_enable = 'Y' " .
				"		AND	O.object_is_enable = 'Y' " .
				"		AND OL.object_link_is_enable = 'Y' " .
				"		AND	O.object_archive_date > NOW() " .
				"		AND	O.object_publish_date < NOW() " .
				"		AND	O.is_removed = 'N' AND " . $ProductCatSQL .
				"			(" . $FieldSQL . ") " .
				"	GROUP BY C.product_category_id ";
	$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

	$ProductCategoryListXML = '';
	while ($myResult = $result->fetch_assoc()) {
		$mySmarty = new mySmarty();
		$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $_REQUEST['lang_id'], $Site);
		$mySmarty->assign('Object', $myResult);
		$mySmarty->assign('NoOfProducts', $myResult['no_of_products']);
		$ProductCategoryListXML .= $mySmarty->fetch('api/object_info/PRODUCT_CATEGORY.tpl');
	}
	$ValueRangeValueListXML = $ValueRangeValueListXML . "<product_category_list>" . $ProductCategoryListXML . "</product_category_list>";
}
	
$smarty->assign('ValueRangeValueListXML', $ValueRangeValueListXML);
$Data = $smarty->fetch('api/search.tpl');

$smarty->assign('Data', $Data);
$smarty->display('api/api_result.tpl');