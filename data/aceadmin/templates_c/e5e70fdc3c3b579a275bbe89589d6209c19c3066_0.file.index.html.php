<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:58
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\log\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c6d46702_25885283',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5e70fdc3c3b579a275bbe89589d6209c19c3066' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\log\\index.html',
      1 => 1535445769,
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
function content_5baa04c6d46702_25885283 (Smarty_Internal_Template $_smarty_tpl) {
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
							<form action="" method="get" class="form-inline">
                            	
                                类型：
                                <select name="ltype" class="form-control">
                                    <option value="">全部</option>
                                    <option value="sql">sql</option>
                                    <option value="file">文件</option>
                                </select>
                                <button type="submit" class="btn btn-purple btn-sm">
                                    <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                    搜索
                                </button>
                            </form>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<table id="simple-table" class="table  table-bordered table-hover">
									<thead>
									<tr>
										<th class="center">
											<label class="pos-rel">
												<input type="checkbox"  class="ace check-all">
												<span class="lbl"></span>
											</label>
										</th>
                                        <th style="width:80px">类型</th>
										<th>url</th>
										<th class="hidden-480">错误信息</th>
										<th style="width:100px" class="hidden-480">时间</th>
                                        <th style="width:80px">操作</th>
									</tr>
									</thead>

									<tbody>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
									<tr>
										<td class="center">
											<label class="pos-rel">
												<input type="checkbox" class="ace ids" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
												<span class="lbl"></span>
											</label>
										</td>

										
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['ltype'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
</td>
										<td class="hidden-480"><?php echo $_smarty_tpl->tpl_vars['val']->value['msg'];?>
</td>
										<td class="hidden-480"><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['addtime']);?>
</td>
										
										<td>
										
											<div class="hidden-sm hidden-xs action-buttons">	
                                                <a class="red del" href="javascript:;" _url="<?php echo U('log/del',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['id'])));?>
" title="删除">
                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                </a>
                                            </div>
                                            
											<div class="hidden-md hidden-lg">
												<div class="inline pos-rel">
													<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
													</button>

													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														<li>
															<a href="javascript:;" class="tooltip-error del" _url="<?php echo U('log/del',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['id'])));?>
" title="删除" data-rel="tooltip" title="" data-original-title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
                                            
										</td>
									</tr>


										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</tbody>
								</table>
                                <div class="pagin" ><?php echo $_smarty_tpl->tpl_vars['_page']->value;?>
</div>
							</div>
						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->


		<?php $_smarty_tpl->_subTemplateRender("file:public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		</div><!-- /.main-container -->

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		
	</body>
</html>
<?php }
}
