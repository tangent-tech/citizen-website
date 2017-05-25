<?php
/* Smarty version 3.1.30, created on 2017-04-06 19:23:49
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e695c5a82b39_56381068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8cde4cfc120a501e9a695cf0c8faed8804148c29' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/header.tpl',
      1 => 1491504953,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58e695c5a82b39_56381068 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Administration - <?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
</title>
<link href="../css/reset.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="../js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<?php if (@constant('ENV') == 'PRODUCTION' || @constant('LOCAL_SIM_ENV') == 'PRODUCTION') {?>
	<link type="text/css" href="../js/jquery_ui/css/blitzer/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'DEMO' || @constant('LOCAL_SIM_ENV') == 'DEMO') {?>
	<link type="text/css" href="../js/jquery_ui/css/redmond/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'HNK' || @constant('ENV') == 'POS' || @constant('LOCAL_SIM_ENV') == 'POS' || @constant('ENV') == 'FLA') {?>
	<link type="text/css" href="../js/jquery_ui/css/south-street/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'CUH' || @constant('ENV') == 'HEROCROSSDEV' || @constant('LOCAL_SIM_ENV') == 'HEROCROSSDEV') {?>
	<link type="text/css" href="../js/jquery_ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'HEROCROSS' || @constant('LOCAL_SIM_ENV') == 'HEROCROSS') {?>
	<link type="text/css" href="../js/jquery_ui/css/humanity/jquery-ui.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'LOCAL') {?>
	<link type="text/css" href="../js/jquery_ui/css/redmond/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<?php } elseif (@constant('ENV') == 'DEV') {?>
	<link type="text/css" href="../js/jquery_ui/css/south-street/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<?php }?>
<link rel="stylesheet" href="../js/jgrowl-1.2.2/jquery.jgrowl.css" type="text/css"/>

<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery-1.8.3.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery.cookie.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/mColorPicker/javascripts/mColorPicker.js" charset="UTF-8"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery_ui/js/jquery-ui-1.8.24.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery-validate/jquery.validate.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery-validate/jquery.metadata.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery-validate/jquery.form.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="../js/jstree/jquery.tree.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jstree/plugins/jquery.tree.contextmenu.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jgrowl-1.2.2/jquery.jgrowl.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery.tablednd_0_5.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/prettyPhoto/js/jquery.prettyPhoto.js" charset="utf-8"><?php echo '</script'; ?>
>



<?php echo '<script'; ?>
 type="text/javascript">
	var CurrentTab = '<?php echo $_smarty_tpl->tpl_vars['CurrentTab']->value;?>
';
	var MyJS = '<?php echo $_smarty_tpl->tpl_vars['MyJS']->value;?>
';
	var ErrorMsg = '<?php echo $_REQUEST['ErrorMessage'];?>
';
	var SystemMsg = '<?php echo $_REQUEST['SystemMessage'];?>
';
	var CustomJS = '<?php echo $_smarty_tpl->tpl_vars['CustomJS']->value;?>
';

	
<?php echo '</script'; ?>
>

<?php if (intVal($_smarty_tpl->tpl_vars['AdminInfo']->value['screen_width']) == 950) {?>
	<?php if (($_smarty_tpl->tpl_vars['MyJS']->value == 'language_tree' || $_smarty_tpl->tpl_vars['MyJS']->value == 'product_tree' || $_smarty_tpl->tpl_vars['MyJS']->value == 'product_category_tree')) {?> 
		<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery.ui.touch.js"><?php echo '</script'; ?>
>
	<?php }
}
echo '<script'; ?>
 type="text/javascript" src="../js/myadmin888.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/js_constant/<?php echo $_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'];?>
/constant.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" type="text/css" href="../css/<?php echo $_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'];?>
/admin.css" />
<style type="text/css">
	#Container {
		width: <?php if ($_smarty_tpl->tpl_vars['AdminInfo']->value['screen_width'] < 950) {?>950<?php } else {
echo $_smarty_tpl->tpl_vars['AdminInfo']->value['screen_width'];
}?>px;
	}
</style>
</head>
<body>
	<div id="Container">
<?php }
}
