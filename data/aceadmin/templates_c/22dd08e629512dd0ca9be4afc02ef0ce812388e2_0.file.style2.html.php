<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:58
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\page\style2.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c6cd5281_50423461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22dd08e629512dd0ca9be4afc02ef0ce812388e2' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\page\\style2.html',
      1 => 1495076447,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c6cd5281_50423461 (Smarty_Internal_Template $_smarty_tpl) {
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
