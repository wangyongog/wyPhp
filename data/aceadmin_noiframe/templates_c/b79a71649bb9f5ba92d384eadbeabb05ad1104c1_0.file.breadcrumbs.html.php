<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:31:44
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\breadcrumbs.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c345ff0b51440_52338781',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b79a71649bb9f5ba92d384eadbeabb05ad1104c1' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\breadcrumbs.html',
      1 => 1546931437,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c345ff0b51440_52338781 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/">首页</a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['head_itle']->value) {?>
        	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['head_itle']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
        		<li class="active"><?php if (!isset($_smarty_tpl->tpl_vars['val']->value['last'])) {?> <a href="<?php if ($_smarty_tpl->tpl_vars['val']->value['url']) {
echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
 <?php } else { ?>javascript:; <?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a><?php } else {
echo $_smarty_tpl->tpl_vars['val']->value['name'];
}?></li>
        	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
    </ul>

    <!--<div class="nav-search" id="nav-search">
        <form class="form-search">
            <span class="input-icon">
                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                <i class="ace-icon fa fa-search nav-search-icon"></i>
            </span>
        </form>
    </div>-->
</div><?php }
}
