<?php
/* Smarty version 3.1.30, created on 2017-04-06 19:23:55
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/header_inner.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e695cbda6b90_75268035',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '02fd0feb11ab590a204a26ed2aafeeb2053645f6' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/header_inner.tpl',
      1 => 1491504953,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header.tpl' => 1,
  ),
),false)) {
function content_58e695cbda6b90_75268035 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<div id="Header">
		<div id="RightHeaderContainer">
			<form name="FrmSetSiteID" id="FrmSetSiteID" method="post">
				<p>
					You are managing:
					<select id="set_site_id" name="set_site_id">
						<?php
$__section_index_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['SystemAdminSiteList']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total != 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?>
						    <option value="<?php echo $_smarty_tpl->tpl_vars['SystemAdminSiteList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['site_id'];?>
"
								<?php if ($_smarty_tpl->tpl_vars['SystemAdminSiteList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['site_id'] == $_SESSION['site_id']) {?>selected="selected"<?php }?>
						    ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SystemAdminSiteList']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['site_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
						<?php
}
}
if ($__section_index_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_0_saved;
}
?>
					</select>
					<a id="set_site_id_button" href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmSetSiteID">
						<span class="ui-icon ui-icon-circle-arrow-e"></span> Go
					</a>
					<input class="HiddenSubmit" type="submit" value="Submit" />
				</p>
				<?php if (!$_smarty_tpl->tpl_vars['IsSiteAdmin']->value && $_smarty_tpl->tpl_vars['Site']->value['site_module_workflow_enable'] == 'Y') {?>
					<p>
						<a href="content_admin_msg_list.php">
							<?php if ($_smarty_tpl->tpl_vars['ContentAdminUnreadMsgNo']->value > 0) {?>
								<span class="ui-icon ui-icon-alert" style="display: inline-block; margin: 0 0 -5px 0"></span>
								You have <?php echo $_smarty_tpl->tpl_vars['ContentAdminUnreadMsgNo']->value;?>
 new messages.
							<?php } else { ?>
								You have no new messages.
							<?php }?>
						</a>
					</p>
				<?php }?>
				<p>
					<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['AdminInfo']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
 | <a href="content_admin_setting.php">Setting</a> | <a href="logout.php">Logout</a> <br />
				</p>
				<p>
					Preferred screen width:
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ScreenWidth']->value, 'W');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['W']->key => $_smarty_tpl->tpl_vars['W']->value) {
$__foreach_W_1_saved = $_smarty_tpl->tpl_vars['W'];
?>
						<a href="ui_set_screen_size.php?width=<?php echo $_smarty_tpl->tpl_vars['W']->value;?>
" class="ScreenWidthSelection <?php if ($_smarty_tpl->tpl_vars['W']->value == $_smarty_tpl->tpl_vars['AdminInfo']->value['screen_width']) {?> ui-state-active<?php }?>" data-width="<?php echo $_smarty_tpl->tpl_vars['W']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['W']->key;?>
</a>
					<?php
$_smarty_tpl->tpl_vars['W'] = $__foreach_W_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

				</p>
				<p>
					<a href="?lang_id=1" <?php if ($_SESSION['LangID'] == 1) {?>class="ui-state-active"<?php }?>>English</a> | <a href="?lang_id=2" <?php if ($_SESSION['LangID'] == 2) {?>class="ui-state-active"<?php }?>>繁體 (beta)</a>
				</p>
			</form>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_admin_logo_url'] != '') {?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_admin_logo_url'];?>
" />
		<?php } else { ?>
			<img src="../images/aveego_logo.png" />
		<?php }?>
		 <h3>Website Administration</h3>
		 <br class="clearfloat" />
	</div>
	<div id="SecurityLevelDialog" title="Approval Request">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 5px 0;"></span>An approval request will be sent to the corresponding admin during submission.</p>
	</div>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all ContentContainer">
		<ul class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<?php if ($_smarty_tpl->tpl_vars['IsSuperAdmin']->value) {?>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'super_admin') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="system_admin_list.php">SA</a></li>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'super_seo') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="z_seo_article_submit.php">SEO</a></li>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['IsSiteAdmin']->value) {?>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'site_admin') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="site_setting.php">Site Admin</a></li>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['IsContentAdmin']->value) {?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_article_enable'] == 'Y') {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'site_setting_general') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="site_setting_general.php">Site Setting</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_content_writer_enable'] == 'Y') {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'site_content_writer') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="site_content_writer_list.php">Content Writer</a></li>
				<?php }?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['IsContentWriter']->value) {?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_article_enable'] == 'Y') {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'site_content') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="language_root_list.php">Site Content</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_member_enable'] == 'Y' && in_array('acl_module_member_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'member') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="member_list.php">Member</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_bonus_point_enable'] == 'Y' && in_array('acl_module_bonus_point_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'bonuspoint') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="bonuspoint_list.php">Bonus Point</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_product_enable'] == 'Y' && in_array('acl_module_currency_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'currency') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="currency_list.php">Currency</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y' && in_array('acl_module_order_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'order') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="order_list.php?handled=N&order_type=order">Order</a></li>
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_order_show_redeem_tab'] == 'Y' && in_array('acl_module_redeem_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
						<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'redeem') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="order_list.php?handled=N&order_type=redeem">Redeem</a></li>
					<?php }?>			
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'sales_report') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="sales_report_payment_method.php">Sales Report</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_enable'] == 'Y' && in_array('acl_module_inventory_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'inventory') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="stock_list.php">Inventory</a></li>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_discount_rule_enable'] == 'Y' && in_array('acl_module_discount_rule_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'discount_rule') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="discount_preprocess_rule_list.php">Discount Rule</a></li>
				<?php }?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['IsElasingUser']->value) {?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_elasing_enable'] == 'Y') {?>
					<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab']->value == 'newsletter') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="elasing_mailing_list.php">Newsletter</a></li>
				<?php }?>
			<?php }?>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content" id="Content">
<?php }
}
