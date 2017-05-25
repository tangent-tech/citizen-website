<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Administration - {$TITLE}</title>
<link href="../css/reset.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="../js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
{if $smarty.const.ENV == 'PRODUCTION' || $smarty.const.LOCAL_SIM_ENV == 'PRODUCTION'}
	<link type="text/css" href="../js/jquery_ui/css/blitzer/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'DEMO' || $smarty.const.LOCAL_SIM_ENV == 'DEMO'}
	<link type="text/css" href="../js/jquery_ui/css/redmond/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'HNK' || $smarty.const.ENV == 'POS' || $smarty.const.LOCAL_SIM_ENV == 'POS' || $smarty.const.ENV == 'FLA'}
	<link type="text/css" href="../js/jquery_ui/css/south-street/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'CUH' || $smarty.const.ENV == 'HEROCROSSDEV' || $smarty.const.LOCAL_SIM_ENV == 'HEROCROSSDEV'}
	<link type="text/css" href="../js/jquery_ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'HEROCROSS' || $smarty.const.LOCAL_SIM_ENV == 'HEROCROSS'}
	<link type="text/css" href="../js/jquery_ui/css/humanity/jquery-ui.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'LOCAL'}
	<link type="text/css" href="../js/jquery_ui/css/redmond/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
{elseif $smarty.const.ENV == 'DEV'}
	<link type="text/css" href="../js/jquery_ui/css/south-street/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
{/if}
<link rel="stylesheet" href="../js/jgrowl-1.2.2/jquery.jgrowl.css" type="text/css"/>
{* <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" charset="UTF-8"></script> *}
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/mColorPicker/javascripts/mColorPicker.js" charset="UTF-8"></script>
{* <script type="text/javascript" src="../js/jquery_ui/js/jquery-ui-1.7.2.custom.min.js"></script> *}
<script type="text/javascript" src="../js/jquery_ui/js/jquery-ui-1.8.24.min.js"></script>
<script type="text/javascript" src="../js/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="../js/jquery-validate/jquery.metadata.js"></script>
<script type="text/javascript" src="../js/jquery-validate/jquery.form.js"></script>

<script type="text/javascript" src="../js/jstree/jquery.tree.js"></script>
<script type="text/javascript" src="../js/jstree/plugins/jquery.tree.contextmenu.js"></script>
<script type="text/javascript" src="../js/jgrowl-1.2.2/jquery.jgrowl.js"></script>
<script type="text/javascript" src="../js/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="../js/prettyPhoto/js/jquery.prettyPhoto.js" charset="utf-8"></script>

{* <script src="//cdn.ckeditor.com/4.4.3/full/ckeditor.js"></script> *}

<script type="text/javascript">
	var CurrentTab = '{$CurrentTab}';
	var MyJS = '{$MyJS}';
	var ErrorMsg = '{$smarty.request.ErrorMessage}';
	var SystemMsg = '{$smarty.request.SystemMessage}';
	var CustomJS = '{$CustomJS}';

	
</script>

{if intVal($AdminInfo.screen_width) == 950}
	{if ($MyJS == 'language_tree' || $MyJS == 'product_tree' || $MyJS == 'product_category_tree')} 
		<script type="text/javascript" src="../js/jquery.ui.touch.js"></script>
	{/if}
{/if}
<script type="text/javascript" src="../js/myadmin888.js"></script>
<script type="text/javascript" src="../js/js_constant/{$CurrentLang.language_id}/constant.js"></script>
<link rel="stylesheet" type="text/css" href="../css/{$CurrentLang.language_id}/admin.css" />
<style type="text/css">
	#Container {
		width: {if $AdminInfo.screen_width < 950}950{else}{$AdminInfo.screen_width}{/if}px;
	}
</style>
</head>
<body>
	<div id="Container">
