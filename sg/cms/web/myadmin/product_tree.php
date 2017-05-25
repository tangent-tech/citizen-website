<?php

$ValidValue = array('product_tree_full', 'product_category_tree', 'product_list');

if (isset($_REQUEST['view'])) {
	if (!in_array($_REQUEST['view'], $ValidValue, true)) {
		$_REQUEST['view'] = 'product_category_tree';
	}
	setcookie('product_view', $_REQUEST['view']);
	$_COOKIE['product_view'] = $_REQUEST['view'];
}
else {
	if (!isset($_COOKIE['product_view']) || !in_array($_COOKIE['product_view'], $ValidValue, true)) {
		$_COOKIE['product_view'] = 'product_category_tree';
		setcookie('product_view', $_COOKIE['product_view']);
	}
}

$_REQUEST['SystemMessage'] = isset($_REQUEST['SystemMessage']) ? $_REQUEST['SystemMessage'] : '';
$_REQUEST['ErrorMessage'] = isset($_REQUEST['ErrorMessage']) ? $_REQUEST['ErrorMessage'] : '';

header('Location: ' . $_COOKIE['product_view']. '.php?SystemMessage=' . urlencode($_REQUEST['SystemMessage']) . '&ErrorMessage=' . urlencode($_REQUEST['ErrorMessage']));