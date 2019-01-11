<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:05:38
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\group\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3467e2949bc1_84229361',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9e8ed8b62d40ecd500ba57eac6334c7f9ce6fdd' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\group\\index.html',
      1 => 1535612957,
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
function content_5c3467e2949bc1_84229361 (Smarty_Internal_Template $_smarty_tpl) {
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
                        <a href="<?php echo U('group/add');?>
">
                            <button type="button" class="btn btn-info btn-sm ">
                                添加
                            </button></a>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<table id="simple-table" class="table  table-bordered table-hover">
									<thead>
									<tr>
										<th class="center detail-col">
											<label class="pos-rel">
												<input type="checkbox" class="ace check-all">
												<span class="lbl"></span>
											</label>
										</th>
										<th>用户组</th>
                                        <th>状态</th>
                                        <th>操作</th>
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
												<input type="checkbox" class="ace ids" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['groupid'];?>
">
												<span class="lbl"></span>
											</label>
										</td>

										
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</td>
										<td><?php if ($_smarty_tpl->tpl_vars['val']->value['status'] == '1') {?>	启用 <?php } else { ?>禁用 <?php }?></td>
										
										</td>

										<td>
										
											<div class="hidden-sm hidden-xs action-buttons">	
                                                <a class="green" href="<?php echo U('group/add',array('groupid'=>$_smarty_tpl->tpl_vars['val']->value['groupid']));?>
"  title="编辑">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>

                                                <a class="red del" href="javascript:;" _url="<?php echo U('group/del',array('groupid'=>$_smarty_tpl->tpl_vars['val']->value['groupid'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['groupid'])));?>
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
															<a href="javascript:;" class="tooltip-success edit" _url="<?php echo U('group/add',array('groupid'=>$_smarty_tpl->tpl_vars['val']->value['groupid']));?>
" _wh="700,550" title="编辑" data-rel="tooltip" title="" data-original-title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
															</a>
														</li>

														<li>
															<a href="javascript:;" class="tooltip-error del" _url="<?php echo U('group/del',array('groupid'=>$_smarty_tpl->tpl_vars['val']->value['groupid'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['groupid'])));?>
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
