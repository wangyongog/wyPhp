<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:38:56
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\archives\class_add.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3461a0b2e1c5_45950871',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '410f1ad4e7943fde5625ad5b5aefe163d6bfd9a7' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\archives\\class_add.html',
      1 => 1546936735,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/head.html' => 1,
    'file:public/sidebar.html' => 1,
    'file:public/breadcrumbs.html' => 1,
    'file:public/footer.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5c3461a0b2e1c5_45950871 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:public/head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<div class="main-container ace-save-state" id="main-container">
			<?php echo '<script'; ?>
 type="text/javascript">
				try{
					ace.settings.loadState('main-container')
					}catch(e){
				}
			<?php echo '</script'; ?>
>
			<?php $_smarty_tpl->_subTemplateRender("file:public/sidebar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


			<div class="main-content">
				<div class="main-content-inner">
					<?php $_smarty_tpl->_subTemplateRender("file:public/breadcrumbs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

					<div class="page-content">


						<div class="row">
							<div class="col-xs-12">
								<form class="form-horizontal form1" id="formx" role="form" action="<?php echo U('archives/add');?>
" METHOD="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['arid']->value;?>
" name="arid"/>
                                <input type="hidden" value="<?php echo formhash();?>
" name="formhash"/>
                                <input type="hidden" value="<?php echo G('typeid');?>
" name="typeid"/>
                                <input type="hidden" value="<?php echo G('stype');?>
" name="stype"/>
									<div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 文章标题 </label>

										<div class="col-sm-5">
											<input type="text" name="data[title]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
" id="form-field-1" placeholder="" class="form-control">
                                            
										</div>
									</div>
                                    
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 自定义属性 </label>

										<div class="col-sm-9">
                                                <div class="checkbox">
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['flag_arr']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
													<label>
														<input name="flag[]" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,explode(',',$_smarty_tpl->tpl_vars['data']->value['flag']))) {?> checked="checked" <?php }?> type="checkbox" class="ace">
														<span class="lbl"> <?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</span>
													</label>
                                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
												</div>
                                                
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> 缩 略 图 </label>

										<div class="col-sm-2">
											<input multiple="" type="file" id="ace_upfile" accept="image/jpg,image/jpeg,image/png,image/bmp"/>
                                            
										</div>
                                        <span class="ace-file-container hide-placeholder selected">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['thumb'];?>
" style="max-width:135px; max-height:126px"/>
                                        </span>
									</div>
                                    
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 文章主栏目 </label>

										<div class="col-sm-4">
											<select class="form-control" id="form-field-select-1" name="data[typeid]">
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menus']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['typeid'];?>
" <?php if ($_smarty_tpl->tpl_vars['typeid']->value == $_smarty_tpl->tpl_vars['val']->value['typeid']) {?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['typename'];?>
</option>
                                                <?php if (isset($_smarty_tpl->tpl_vars['val']->value['children'])) {?>  
                                                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['children'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                                                	<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['typeid'];?>
" <?php if ($_smarty_tpl->tpl_vars['typeid']->value == $_smarty_tpl->tpl_vars['v']->value['typeid']) {?> selected="selected" <?php }?>>&nbsp;&nbsp;┗━<?php echo $_smarty_tpl->tpl_vars['v']->value['typename'];?>
</option>
                                                      <?php if (isset($_smarty_tpl->tpl_vars['v']->value['children'])) {?>
                                                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['children'], 'vo', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['vo']->value) {
?>
                                                          <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['typeid'];?>
" <?php if ($_smarty_tpl->tpl_vars['typeid']->value == $_smarty_tpl->tpl_vars['vo']->value['typeid']) {?> selected="selected" <?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━<?php echo $_smarty_tpl->tpl_vars['vo']->value['typename'];?>
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
                            
                                            </select>
										</div>
									</div>
                                    <?php if (isset($_smarty_tpl->tpl_vars['data']->value['ext_data']['ld'])) {?> 
                                    	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['ext_data']['ld'], 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 班级亮点 </label>
                                            <div class="col-sm-9">
                                                <input type="text" id="form-field-1" name="edata[ld][]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" placeholder="" class="col-xs-10 col-sm-6">
                                                <span class="middle" style="margin-left: 15px"><a href="javascript:;" class="add_but">添加</a> <a href="javascript:;" class="del_but">删除</a></span>
                                            </div>
                                        </div>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?> 
                                    <?php } else { ?>
                                    	<div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 班级亮点 </label>
                                            <div class="col-sm-9">
                                                <input type="text" id="form-field-1" name="edata[ld][]" value="" placeholder="" class="col-xs-10 col-sm-6">
                                                <span class="middle" style="margin-left: 15px"><a href="javascript:;" class="add_but">添加</a> <a href="javascript:;" class="del_but">删除</a></span>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    
                                    <?php echo $_smarty_tpl->tpl_vars['extend_list']->value;?>

                                    
                                    <?php if (isset($_smarty_tpl->tpl_vars['data']->value['ext_data']['gh'])) {?> 
                                    	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['ext_data']['gh'], 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 专业规划 </label>
                                                <div class="col-sm-9">
                                                    <span >
                                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" name="edata[gh][]">
                                                    </span>
                                                    <span class=" input-icon-right">说明
                                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['ext_data']['gh_task'][$_smarty_tpl->tpl_vars['k']->value];?>
" id="form-field-icon-2" name="edata[gh_task][]" style="width:560px">
                                                    </span>
                                                    <span class="middle" style="margin-left: 15px"><a href="javascript:;" class="add_but">添加</a> <a href="javascript:;" class="del_but">删除</a></span>
                                                </div>
                                            </div>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    <?php } else { ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 专业规划 </label>
                                            <div class="col-sm-9">
                                                <span >
                                                    <input type="text" value="" name="edata[gh][]">
                                                </span>
                                                <span class=" input-icon-right">说明
                                                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['ext_data']['gh_task'][$_smarty_tpl->tpl_vars['k']->value];?>
" id="form-field-icon-2" name="edata[gh_task][]" style="width:560px">
                                                </span>
                                                <span class="middle" style="margin-left: 15px"><a href="javascript:;" class="add_but">添加</a> <a href="javascript:;" class="del_but">删除</a></span>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 关键字 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="data[keywords]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['keywords'];?>
" placeholder="" class="col-xs-10 col-sm-6">
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 内容摘要 </label>

										<div class="col-sm-9">
											<textarea class="form-control" name="data[description]" id="form-field-8" style="height:120px" placeholder=""><?php echo $_smarty_tpl->tpl_vars['data']->value['description'];?>
</textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 权重 </label>

										<div class="col-sm-9">
											<input data-rel="tooltip" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['weight'];?>
" name="data[weight]" id="form-field-6" placeholder="" title="" >
											<span class="middle">越大越前</span>
										</div>
									</div>

								
                                    
                                    <div class="form-group">
										<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 文章内容 </label>

										<div class="col-sm-9">
											<?php echo '<script'; ?>
 id="contents" name="contents" type="text/plain"><?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['data']->value['article_body']);
echo '</script'; ?>
>
										</div>
									</div>
                                    
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info post_info" type="button">
												<i class="ace-icon fa fa-check bigger-110"></i>
												提 交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												重 置
											</button>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->


		<?php $_smarty_tpl->_subTemplateRender("file:public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		</div><!-- /.main-container -->

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('ueditor'=>1), 0, false);
echo '<script'; ?>
 type="text/javascript">
    var editor = UE.getEditor('contents',{ initialFrameHeight:650 } );
    var img_data = [];
	///parent.document.getElementById('breadcrumbs').innerHTML = 'ssssss';
    jQuery(function ($) {

		
		$('.add_but').on('click',function(){
			var str = $(this).parent().parent().parent().prop("outerHTML");
			$(this).parent().parent().parent().after($(this).parent().parent().parent().prop("outerHTML"));
			var obj = $(this).parent().parent().parent().next();
			obj.find('.add_but').remove();
			obj.find("input[type='text']").val('');
		});
		$('#formx').on('click','.del_but',function(){
			$(this).parent().parent().parent().remove();
		});
		
		
		
        $('.post_info').on('click',function () {
            var formData = new FormData($('#formx')[0]);
            for(i=0; i<img_data.length; i++){
                 formData.append('files', img_data[i]);
            }
            $.ajax({
                processData: false,
                contentType: false,
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                url: "<?php echo U('archives/add');?>
",
                data: formData,
                success: function (data) {
					if(data.status == 1){
						adminJs.msg(data.msg);
						setTimeout('adminJs.goUrl("'+data.url+'")',2000);
					}else{
						adminJs.showAlert(data.msg, 2);
					}
                }, complete: function (XMLHttpRequest, textStatus) {
                }, beforeSend: function () {

                }, error: function () {
                    adminJs.showAlert('服务器异常，请联系管理员', 2);
                    return;
                }
            });
        })
        $('#ace_upfile').ace_file_input({
            style: 'well',
            btn_choose: '请选择图片',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small',//large | fit
            allowExt: ["jpeg", "jpg", "png", "gif", "bmp"],
            allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"]


            //样式二
            /*no_file:'请选择图片',
            btn_choose:'选择',
            btn_change:'修改',
            droppable:false,
            onchange:null,
            thumbnail:'small',//| true | large
            allowExt: ["jpeg", "jpg", "png", "gif", "bmp"],
            allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"]*/
            //,icon_remove:null//set null, to hide remove/reset button
            ,before_change:function(files, dropped) {
                for(var i = 0; i < files.length; i++) {
                    img_data.push( files[i])
                    //formData.append('files', files[i]);
                }
				return true;
			}
            /**,before_remove : function() {
						return true;
					}*/
            ,
            preview_error : function(filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function(){
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });

    });
<?php echo '</script'; ?>
>
		
	</body>
</html>
<?php }
}
