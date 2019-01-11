<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:31:45
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\page\page.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c345ff1d974c8_02751328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c990b7a0c6c1dd8f15da688d1da8d6b7faa26fb2' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\page\\page.html',
      1 => 1535010711,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c345ff1d974c8_02751328 (Smarty_Internal_Template $_smarty_tpl) {
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
