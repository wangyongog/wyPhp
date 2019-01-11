<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:31:44
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\header.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c345ff0b12c45_05178780',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b3dc1c014531bdb0c9bdcf731d277f8e75c09034' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\header.html',
      1 => 1546927554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c345ff0b12c45_05178780 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>后台管理</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/layui/css/layui.css">
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/fonts.googleapis.com.css" />
		
		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/ace-rtl.min.css" />
		
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/ace-extra.min.js"><?php echo '</script'; ?>
>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/html5shiv.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin_noIframe/js/respond.min.js"><?php echo '</script'; ?>
>
		<![endif]-->
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/css/bootstrap-tab.css">
        <meta name="csrf-token" content="<?php echo formhash();?>
">
	</head>

	<body class="no-skin"><?php }
}
