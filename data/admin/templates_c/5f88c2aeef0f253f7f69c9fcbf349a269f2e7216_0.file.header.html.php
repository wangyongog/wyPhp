<?php
/* Smarty version 3.1.30, created on 2018-01-02 14:21:06
  from "D:\WWW\wy\admin\app\templates\public\header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4b24d2414374_38816421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f88c2aeef0f253f7f69c9fcbf349a269f2e7216' => 
    array (
      0 => 'D:\\WWW\\wy\\admin\\app\\templates\\public\\header.html',
      1 => 1495784279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4b24d2414374_38816421 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>后台管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Theme style -->

    <link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/bootstrap.css" rel="stylesheet" type="text/css">
 	<!--<link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/font-awesome.min.css">
  	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/layui/css/layui.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/index.css">
    
    <link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/summernote.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/webuploader.css" rel="stylesheet" type="text/css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/html5shiv.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/respond.min.js"><?php echo '</script'; ?>
>
  <![endif]-->  
  <meta name="csrf-token" content="<?php echo formhash();?>
">
</head>
<body class="skin-blue sidebar-mini"><?php }
}
