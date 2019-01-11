<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:09:11
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\manager\add.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3468b73cb7c5_83522274',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8369b403b72fd4b96459b3439a03e611c2649b7d' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\manager\\add.html',
      1 => 1535791945,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5c3468b73cb7c5_83522274 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<style>
*, *:before, *:after {
  box-sizing:content-box;
}
body{
	background-color:#fff
}
</style>
    <div class="main-content">
	<div class="main-content-inner">
    	<div class="page-content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <!-- /.box-header -->
            <!-- form start -->
            <form class="layui-form" action="<?php echo U('Manager/add');?>
">
            <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
" name="uid"/>
            <input type="hidden" value="<?php echo creatToken($_smarty_tpl->tpl_vars['uid']->value);?>
" name="formhash"/>
            
              <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-inline">
                  <input type="text" name="user" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['user'];?>
" <?php if ($_smarty_tpl->tpl_vars['uid']->value > 0) {?>  disabled="disabled" <?php }?> required  lay-verify="required"  datatype="s" errormsg="请输入用户名" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">用户组</label>
                <div class="layui-input-inline">
                  <select name="group" lay-verify="required">
                    <?php if ($_smarty_tpl->tpl_vars['group']->value) {?>  
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['group']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                    <option  <?php if ($_smarty_tpl->tpl_vars['data']->value['groupid'] == $_smarty_tpl->tpl_vars['val']->value['groupid']) {?>  selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['groupid'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                  <input type="password" name="password" value="" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">重复密码</label>
                <div class="layui-input-block">
                  <input type="password" name="password1" value="" required  lay-verify="required" placeholder="再次输入密码" autocomplete="off" class="layui-input">
                </div>
              </div>
              
              <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline">
                  <input type="checkbox" name="status" lay-skin="switch" lay-text="正常|锁定"  checked >
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button type="button" class="layui-btn ajaxFrom">立即提交</button>
                 <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
                </div>
              </div>
            </form>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div>
    </div>
    </div>
<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
>
layui.use(['form'], function(){
  var form = layui.form;
  
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
