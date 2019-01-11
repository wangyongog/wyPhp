<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:01:14
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\page\style2.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3466da73e4c7_12901094',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a5c9d67be92b52e2165b9c8058b402f0c064088' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\page\\style2.html',
      1 => 1495076447,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c3466da73e4c7_12901094 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="text-center">
    <ul id="visible-pages-example" class="pagination">
    	<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] != 1) {?>
    	<li class="first " data-page="1"><a href="<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == 1) {?> javascript:; <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['_p']->value['first'];?>
 <?php }?>">首页</a></li>
    	<li class="prev " data-page="<?php echo $_smarty_tpl->tpl_vars['_p']->value['prepg_1'];?>
"><a href="<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == 1) {?> javascript:; <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['_p']->value['prepg'];?>
 <?php }?>">上一页</a></li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['_p']->value['pages']) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_p']->value['pages'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
        <li class="page <?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == $_smarty_tpl->tpl_vars['item']->value['page']) {?>active<?php }?>" data-page="<?php echo $_smarty_tpl->tpl_vars['item']->value['page'];?>
"><a href="<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == $_smarty_tpl->tpl_vars['item']->value['page']) {?> javascript:; <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
 <?php }?>"><?php echo $_smarty_tpl->tpl_vars['item']->value['page'];?>
</a></li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] != $_smarty_tpl->tpl_vars['_p']->value['pagenum']) {?>
        <li class="next" data-page="<?php echo $_smarty_tpl->tpl_vars['_p']->value['nextpg_1'];?>
"><a href="<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == $_smarty_tpl->tpl_vars['_p']->value['pagenum']) {?> javascript:; <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['_p']->value['nextpg'];?>
 <?php }?>">下一页</a></li>
        <li class="last" data-page="<?php echo $_smarty_tpl->tpl_vars['_p']->value['pagenum'];?>
"><a href="<?php if ($_smarty_tpl->tpl_vars['_p']->value['currpage'] == $_smarty_tpl->tpl_vars['_p']->value['pagenum']) {?> javascript:; <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['_p']->value['last'];?>
 <?php }?>">最后页</a></li>
        <?php }?>
    </ul>
</div><?php }
}
