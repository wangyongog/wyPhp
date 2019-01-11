<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:03:51
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\banner\add.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c346777ad82c8_36057049',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8408d7ecbe4aa763f9f42e49d969398f3efaedc' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\banner\\add.html',
      1 => 1546419641,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c346777ad82c8_36057049 (Smarty_Internal_Template $_smarty_tpl) {
?><form class="form-horizontal " role="form" action="<?php echo U('banner/add');?>
" enctype="multipart/form-data">
<input type="hidden" value="<?php echo formhash();?>
" name="formhash"/>
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['img'];?>
" name="fileup1"/>
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"/>
	<!--<div class="form-group">
		<label class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			<p class="form-control-static">email@example.com</p>
		</div>
	</div>-->
    <div class="form-group">
		<label class="col-sm-2 control-label">广告位</label>
		<div class="col-sm-4">
			<select class="form-control" name="data[pos]">
			<option value="">请选择</option>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pos']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                <option <?php if ($_smarty_tpl->tpl_vars['data']->value['pos'] == $_smarty_tpl->tpl_vars['k']->value) {?> selected <?php }?>value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</select>
		</div>
	</div>
    <div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">图片</label>
		<div class="col-sm-4">
			<button id="fileup1" class="btn btn-info browse_button" data-upload-url="<?php echo U('upload/banner');?>
" data-extensions="jpg,png,gif,bmp" data-max-size="5mb" data-base-url="">请选择图片</button>
            <div class="preview" style="padding-top:15px">
				<img style="max-width:120px; max-height:120px" <?php if ($_smarty_tpl->tpl_vars['data']->value['img']) {?> src="<?php echo picSize($_smarty_tpl->tpl_vars['data']->value['img']);?>
" <?php }?>/>
			</div>
            <div class="process none">
                <span class="filename"></span>
                <span class="filesize"></span>
                <span class="percent"></span>
            </div>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">开始时间</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="data[startime]" readonly="readonly" id="start" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['startime'];?>
"/>
		</div>
	</div>
    <div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">结束时间</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="data[endtime]" readonly="readonly" id="end" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['endtime'];?>
"/>
		</div>
	</div>
    
    <div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">排序</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="data[o]" id="o" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['o'];?>
"/>
		</div>
	</div>
    <div class="form-group">
		<label for="inputPassword" class="col-sm-2 control-label">链接</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" name="data[url]" id="url" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['url'];?>
"/>
		</div>
	</div>
    <!--<div class="form-group">
		<label for="" class="col-sm-2 control-label">是否锁定</label>
		<div class="col-sm-10">
			<label>
                <input name="switch-field-1" class="ace ace-switch ace-switch-4 btn-rotate" type="checkbox">
                <span class="lbl"></span>
            </label>
		</div>
	</div>-->
</form>
<style>
.toast-center-center {
   top: 50%;
   left: 50%;
   margin-top: -25px;
  margin-left: -500px;
 }
</style>
<?php echo '<script'; ?>
 type="text/javascript">
/*toastr.options.positionClass = 'toast-center-center';
toastr.warning('请选择有效数据');*/
function backFuns(url,obj){
	alert(obj)
}
uploaders.initUploaders();
$('#start').datetimepicker({
   format: 'yyyy-mm-dd h:ii:ss',
	autoclose: true,
	//minView: 30,
	language : 'zh-CN',
	minuteStep:1,
	todayBtn: true,
	startView:2,
	startDate: new Date() 
});
$('#end').datetimepicker({
   format: 'yyyy-mm-dd h:ii:ss',
	autoclose: true,
	//minView: 30,
	language : 'zh-CN',
	minuteStep:1,
	todayBtn: true,
	startView:2,
	startDate: new Date() 
});
<?php echo '</script'; ?>
><?php }
}
