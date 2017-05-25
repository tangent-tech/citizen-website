<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:34:32
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/PRODUCT.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f79198322612_65473348',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a37d09ad109fdcbd05882dda9d565bc61194f8e9' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/api/object_info/PRODUCT.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:api/object_info/OBJECT_PROTOTYPE.tpl' => 1,
    'file:api/object_info/PRODUCT_PROTOTYPE.tpl' => 1,
  ),
),false)) {
function content_58f79198322612_65473348 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:api/object_info/OBJECT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:api/object_info/PRODUCT_PROTOTYPE.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
