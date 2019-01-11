<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:33:01
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\menus\add.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c34603d08b749_47489445',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '271e5881099b6916153396ae34c0ec316756cb7f' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\menus\\add.html',
      1 => 1546052843,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5c34603d08b749_47489445 (Smarty_Internal_Template $_smarty_tpl) {
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
            <form class="layui-form" action="<?php echo U('menus/add');?>
">
            <div class="layui-form-item">
                <label class="layui-form-label">上级菜单</label>
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"/>
                <input type="hidden" value="<?php echo formhash();?>
" name="formhash"/>
                <div class="layui-input-inline">
                  <select lay-verify="required" id="pid" name="data[pid]">
                  	<option value="0" <?php if ($_smarty_tpl->tpl_vars['pid']->value == 0) {?> selected="selected" <?php }?> >顶级菜单</option>
                    <?php if ($_smarty_tpl->tpl_vars['sidebarlist']->value) {?>  
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebarlist']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <option <?php if ($_smarty_tpl->tpl_vars['pid']->value == $_smarty_tpl->tpl_vars['val']->value['typeid']) {?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['typeid'];?>
"  ><?php echo $_smarty_tpl->tpl_vars['val']->value['typename'];?>
</option>
                        <?php if (isset($_smarty_tpl->tpl_vars['val']->value['children'])) {?>  
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['children'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                                  <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['typeid'];?>
" <?php if ($_smarty_tpl->tpl_vars['pid']->value == $_smarty_tpl->tpl_vars['v']->value['typeid']) {?> selected="selected" <?php }?>>&nbsp;&nbsp;┗━<?php echo $_smarty_tpl->tpl_vars['v']->value['typename'];?>
</option>
                                  <?php if (isset($_smarty_tpl->tpl_vars['v']->value['children'])) {?>
                                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['children'], 'vo', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['vo']->value) {
?>
                                      <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['typeid'];?>
" <?php if ($_smarty_tpl->tpl_vars['pid']->value == $_smarty_tpl->tpl_vars['vo']->value['typeid']) {?> selected="selected" <?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━<?php echo $_smarty_tpl->tpl_vars['vo']->value['typename'];?>
</option>
                                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                  <?php }?>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                        <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php }?>  
                  </select>
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">菜单名称</label>
                <div class="layui-input-inline">
                  <input type="text" name="data[typename]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['typename'];?>
" required  lay-verify="required"  datatype="s" errormsg="请输入菜单名称" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">链接</label>
                <div class="layui-input-block">
                  <input type="text" name="data[url]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['url'];?>
" required  lay-verify="required"  placeholder="请输入连接" autocomplete="off" class="layui-input">
                </div>
              </div>

              <div class="layui-form-item">
                <label class="layui-form-label">文章添加模板</label>
                <div class="layui-input-inline">
                  <input type="text" name="data[add_article]" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['add_article'];?>
" autocomplete="off" class="layui-input" >
                </div>
              </div>
              
              <div class="layui-form-item">
                <label class="layui-form-label">显示状态</label>
                <div class="layui-input-inline">
                  <input type="checkbox" name="data[ishide]" lay-skin="switch" lay-text="显示|隐藏" <?php if ($_smarty_tpl->tpl_vars['data']->value['ishide'] == 1) {?> checked <?php }?>  >
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                  <input type="text" name="data[weight]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['weight'];?>
" required  lay-verify="required"  placeholder="排序越小越靠前 " autocomplete="off" class="layui-input">
                </div>
              </div>
              
              <div class="layui-form-item" >
                <label class="layui-form-label">页面说明</label>
                <div class="layui-input-block" style="width:466px">
                  <textarea name="data[description]" placeholder="请输入内容" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['description'];?>
" class="layui-textarea"></textarea>
                </div>
              </div>
              
              
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button type="button" class="layui-btn ajaxFrom">立即提交</button>
                  <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
//Demo
layui.use(['form'], function(){
  var form = layui.form;
  
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
