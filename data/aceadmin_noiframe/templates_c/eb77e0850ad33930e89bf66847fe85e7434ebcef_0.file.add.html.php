<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:05:39
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\group\add.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3467e3c85dc7_53318512',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb77e0850ad33930e89bf66847fe85e7434ebcef' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\group\\add.html',
      1 => 1535613198,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/head.html' => 1,
    'file:public/sidebar.html' => 1,
    'file:public/breadcrumbs.html' => 1,
    'file:public/settingsBox.html' => 1,
    'file:public/footer.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5c3467e3c85dc7_53318512 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		<?php $_smarty_tpl->_subTemplateRender("file:public/head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
						<?php $_smarty_tpl->_subTemplateRender("file:public/settingsBox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

						<div class="page-header">
                            
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								
                                    
                                    <form class="form-horizontal" id="form" name="form" action="<?php echo U('group/add');?>
" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1"> 用户组名 </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title" id="title" placeholder="用户组名" class="col-xs-10 col-sm-5" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
">
                                                <input type="hidden" name="groupid" id="groupid" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['groupid'];?>
">
                                                <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">用户组名称，不能为空。</span>
                                                        </span>
                                            </div>
                                        </div>
                                        
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-2"> 是否启用 </label>
                                            <div class="control-label no-padding-left col-sm-1">
                                                <label>
                                                    <input name="status" id="status"  <?php if ($_smarty_tpl->tpl_vars['data']->value['status'] == 1) {?> checked="checked"<?php }?> class="ace ace-switch ace-switch-2" type="checkbox">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                            <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">YES，启用；NO，禁用</span>
                                                    </span>
                                        </div>
                    
                                            
                                         
                                        <div class="space-4"></div>
            
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label no-padding-right" for="form-field-1">
                                                    权限选择 </label>
                                                <div class="col-sm-9">
                                                    <div class="col-sm-10">
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebarlist']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                                        <div class="row">
                                                                <div class="widget-box">
                                                                    <div class="widget-header">
                                                                        <h4 class="widget-title">
                                                                            <label>
                                                                                <input name="rules[]" class="ace ace-checkbox-2 father" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
                                                                                <span class="lbl"> <?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
                                                                            </label>
                                                                        </h4>
                                                                       <div class="widget-toolbar">
                                                                            <?php if (!empty($_smarty_tpl->tpl_vars['val']->value['children'])) {?>
                                                                                <a href="#" data-action="collapse">
                                                                                    <i class="ace-icon fa fa-chevron-up"></i>
                                                                                </a>
                                                                            <?php }?>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (!empty($_smarty_tpl->tpl_vars['val']->value['children'])) {?>
                                                                        <div class="widget-body">
                                                                            <div class="widget-main row">
                                                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['children'], 'vv', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['vv']->value) {
?>
                                                                                    <label class="col-xs-2" style="width:160px;">
                                                                                        <input name="rules[]" class="ace ace-checkbox-2 children"   type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
">
                                                                                        <span class="lbl"><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</span>
                                                                                    </label>
                                                                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>    
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                               </div>
                                                            </div>
                                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>    
                                                            
                                                   </div>
                                                </div>
                                            </div>
                                        
            
                                        <div class="col-md-offset-2 col-md-9">
                                            <button class="btn btn-info ajaxFrom" type="button">
                                                <i class="icon-ok bigger-110"></i>
                                                提交
                                            </button>
            
                                            &nbsp; &nbsp; &nbsp;
                                            <button class="btn" type="reset">
                                                <i class="icon-undo bigger-110"></i>
                                                重置
                                            </button>
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

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
 type="text/javascript">
    $(".children").click(function () {
        $(this).parent().parent().parent().parent().find(".father").prop("checked", true);
    })
    $(".father").click(function () {
        if (this.checked) {
            $(this).parent().parent().parent().parent().find(".children").prop("checked", true);
        } else {
            $(this).parent().parent().parent().parent().find(".children").prop("checked", false);
        }
    })
<?php echo '</script'; ?>
>
		
	</body>
</html>
<?php }
}
