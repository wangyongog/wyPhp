<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:57
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\page\page.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c5b7d680_93504745',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce03f9154d22173414ade0366d6a1f789d27fc90' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\page\\page.html',
      1 => 1535010711,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c5b7d680_93504745 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="page" align="center">
</div>
<?php echo '<script'; ?>
>
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage;
        laypage.render({
            elem: 'page'
            ,count: <?php echo $_smarty_tpl->tpl_vars['count']->value;?>

            ,limit:<?php echo $_smarty_tpl->tpl_vars['limit']->value;?>

            ,theme:'#3C8DBC'
            ,jump: function(obj, first){
                //得到了当前页，用于向服务端请求对应数据
                if(first !=true){
                    var curr = obj.curr || 1;
                    formAjax.tbodyLoading(curr);
                }
            }
        });
    });
<?php echo '</script'; ?>
><?php }
}
