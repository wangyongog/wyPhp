<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:03:49
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\footerJs.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c346775185745_57132402',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8682bc1c9dda1deaa9e7c70a6b3f4254fea5a3d5' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\footerJs.html',
      1 => 1546938226,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c346775185745_57132402 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
var app ='<?php echo CONTROLLER;?>
_<?php echo ACTION;?>
_<?php echo CF("URL_HTML_FIX");?>
';
<?php echo '</script'; ?>
>
<!-- basic scripts -->
<!--[if !IE]> -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>

<!-- <![endif]-->

<!--[if IE]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/jquery-1.8.3.min.js"><?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/bootstrap.min.js"><?php echo '</script'; ?>
>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/excanvas.min.js"><?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery-ui.custom.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.ui.touch-punch.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.easypiechart.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.sparkline.index.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.flot.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.flot.pie.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/jquery.flot.resize.min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/tabs.js"><?php echo '</script'; ?>
>
<!-- ace scripts -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/ace-elements.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/ace.min.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/bootstrap3-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/bootstrap3-dialog/js/bootstrap-dialog.min.js"><?php echo '</script'; ?>
>
<!--时间控件-->
<?php if (!empty($_smarty_tpl->tpl_vars['isdate']->value)) {?> 
<link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/datetimepicker/js/bootstrap-datetimepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"><?php echo '</script'; ?>
>
<?php }
if (!empty($_smarty_tpl->tpl_vars['ueditor']->value)) {
echo '<script'; ?>
 type="text/javascript" charset="utf-8" src="/ueditor-1.4.3.3/ueditor.config.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8" src="/ueditor-1.4.3.3/ueditor.all.js"><?php echo '</script'; ?>
>

<?php }?>

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
/aceAdmin_noIframe/common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/ajax.js"><?php echo '</script'; ?>
>
<?php if (!empty($_smarty_tpl->tpl_vars['isupfile']->value)) {?>
<!--/*图片上传控件-->
<link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/css/uploaders.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/plupload/js/plupload.full.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/initUploaders.js"><?php echo '</script'; ?>
>
<?php }?>

<?php }
}
