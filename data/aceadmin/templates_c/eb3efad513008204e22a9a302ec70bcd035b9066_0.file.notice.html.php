<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:50:00
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\reply\notice.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c8c5c100_93363449',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb3efad513008204e22a9a302ec70bcd035b9066' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\reply\\notice.html',
      1 => 1497594023,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5baa04c8c5c100_93363449 (Smarty_Internal_Template $_smarty_tpl) {
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
            	<div class="btn-group">
                	<button type="submit" class="btn btn-success" onclick="adminJs.showIframe('新增','<?php echo U('reply/notadd');?>
','700','450')">添加</button>
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
            <th>公告</th>
            <th>平台</th>
            <th>添加时间</th>
            <th>操作</th>
          </tr> 
        </thead>
        <tbody id="tbody_data" data-name="tbody_data"></tbody>
        <!--<tbody>
          <tr>
            <td><input type="checkbox" class="ids" name="ids[]" lay-skin="primary"></td>
            <td>贤心</td>
            <td>汉族</td>
            <td>1989-10-14</td>
            <td>人生似修行</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="ids" name="ids[]" lay-skin="primary"></td>
            <td>张爱玲</td>
            <td>汉族</td>
            <td>1920-09-30</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="ids" name="ids[]" lay-skin="primary"></td>
            <td>Helen Keller</td>
            <td>拉丁美裔</td>
            <td>1880-06-27</td>
            <td> Life is either a daring adventure or nothing.</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="ids" name="ids[]" lay-skin="primary"></td>
            <td>岳飞</td>
            <td>汉族</td>
            <td>1103-北宋崇宁二年</td>
            <td>教科书再滥改，也抹不去“民族英雄”的事实</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="ids" name="ids[]" lay-skin="primary"></td>
            <td>孟子</td>
            <td>华夏族（汉族）</td>
            <td>公元前-372年</td>
            <td>猿强，则国强。国强，则猿更强！ </td>
          </tr>
        </tbody>-->
      </table>
    </div>
    <div class="pagin" data-name="pagin" ></div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</body>
</html>
<?php }
}
