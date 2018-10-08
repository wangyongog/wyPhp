<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:50:03
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\money\detailed.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04cbc48882_66838165',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ef6b62735a9d79fc7c0858d9d7badfd035206d1' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\money\\detailed.html',
      1 => 1494491099,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5baa04cbc48882_66838165 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<!-- Content Wrapper. Contains page content -->
    <style>
   .layui-form input[type=checkbox], .layui-form input[type=radio], .layui-form select {
    	display:block;
	}
    </style>
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<div class="row">
        	<div class="col-md-12">
            	<!--<div class="btn-group">
                	<button type="submit" class="btn btn-success" onclick="adminJs.showIframe('新增','<?php echo U('User/add');?>
','700','450')">添加用户</button>
                </div>-->
            	<div class="btn-group">
                    <form class="form-inline" id="searchForm" method="get">
                        用户名：
                        <input id="username" class="form-control" name="username" value=""  type="text">
                        消费时间：
                        <span class="datepicker">
                        <input type="text" class="form-control " name="start" readonly="readonly"> - 
                        <input type="text" class="form-control " name="end" readonly="readonly">
                        </span>
                        类型：
                        <select class="form-control" name="stype">
                        	<option value="0">全部</option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stype']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                            	<option <?php if ($_smarty_tpl->tpl_vars['k']->value == I('stype')) {?>  selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                        <button type="button" class="btn btn-primary searchForm">搜索</button>
                    </form>
                </div>
            </div>
        </div>
		
    </section>
    
	<div class="layui-form table_p">
      <table class="layui-table">
        <colgroup>
          <col width="50">
          <col width="150">
          <col width="150">
          <col width="200">
          <col>
        </colgroup>
        <thead>
          <tr>
            <th><input class="check-all" type="checkbox"></th>
            <th>用户名</th>
            <th>余额</th>
            <th>类型</th>
            <th>金额</th>
            <th>备注</th>
            <th>时间</th>
          </tr> 
        </thead>
        <tbody id="tbody_data" data-name="tbody_data"></tbody>
      </table>
    </div>
    <div class="pagin" data-name="pagin" ></div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  
<?php echo '<script'; ?>
>

$('.datepicker >input').datepicker({
    language: "zh-CN",
            autoclose: true,//选中之后自动隐藏日期选择框
            //clearBtn: true,//清除按钮
            //todayBtn: true,//今日按钮
            format: "yyyy-mm-dd",
			todayHighlight:true
});
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
