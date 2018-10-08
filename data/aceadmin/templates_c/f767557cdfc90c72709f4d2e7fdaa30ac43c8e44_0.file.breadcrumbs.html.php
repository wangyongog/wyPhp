<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\breadcrumbs.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c12af808_85710008',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f767557cdfc90c72709f4d2e7fdaa30ac43c8e44' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\breadcrumbs.html',
      1 => 1537085753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c12af808_85710008 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="content-tabs">
    <button class="roll-nav roll-left tabLeft">
        <i class="fa fa-backward"></i>
    </button>
    <nav class="page-tabs menuTabs">
        <div class="page-tabs-content">
            <a href="javascript:;" class="menuTab active" data-id="<?php echo U('main/default');?>
">欢迎首页</a>
            
        </div>
    </nav>
    <button class="roll-nav roll-right tabRight">
        <i class="fa fa-forward" style="margin-left: 3px;"></i>
    </button>
    <div class="btn-group roll-nav roll-right">
        <button class="dropdown tabClose" data-toggle="dropdown">
            页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a class="tabReload" href="javascript:void();">刷新当前</a></li>
            <li><a class="tabCloseCurrent" href="javascript:void();">关闭当前</a></li>
            <li><a class="tabCloseAll" href="javascript:void();">全部关闭</a></li>
            <li><a class="tabCloseOther" href="javascript:void();">除此之外全部关闭</a></li>
        </ul>
    </div>
    <button class="roll-nav roll-right fullscreen"><i class="fa fa-arrows-alt"></i></button>
</div>

<!--<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/">Home</a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['head_itle']->value) {?>
        	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['head_itle']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
        		<li class="active"><a href="<?php if ($_smarty_tpl->tpl_vars['val']->value['url']) {
echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
 <?php } else { ?>javascript:; <?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a></li>
        	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
    </ul>

    <div class="nav-search" id="nav-search">
        <form class="form-search">
            <span class="input-icon">
                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                <i class="ace-icon fa fa-search nav-search-icon"></i>
            </span>
        </form>
    </div>
</div>--><?php }
}
