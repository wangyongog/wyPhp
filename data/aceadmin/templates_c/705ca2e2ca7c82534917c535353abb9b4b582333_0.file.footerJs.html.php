<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\footerJs.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c1320c89_93627981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '705ca2e2ca7c82534917c535353abb9b4b582333' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\footerJs.html',
      1 => 1537079188,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c1320c89_93627981 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
var app ='<?php echo CONTROLLER;?>
_<?php echo ACTION;?>
_<?php echo F("URL_HTML_FIX");?>
';
<?php echo '</script'; ?>
>
<!-- basic scripts -->
<!--[if !IE]> -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>

<!-- <![endif]-->

<!--[if IE]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery-1.11.3.min.js"><?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/bootstrap.min.js"><?php echo '</script'; ?>
>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/excanvas.min.js"><?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery-ui.custom.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.ui.touch-punch.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.easypiechart.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.sparkline.index.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.flot.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.flot.pie.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/jquery.flot.resize.min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/tabs.js"><?php echo '</script'; ?>
>
<!-- ace scripts -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/ace-elements.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/js/ace.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/layer3.02/layer.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/layui/layui.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/ajax.js"><?php echo '</script'; ?>
>

<?php }
}
