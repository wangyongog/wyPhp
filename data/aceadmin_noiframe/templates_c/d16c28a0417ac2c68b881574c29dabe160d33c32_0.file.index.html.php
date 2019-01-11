<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:33:11
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\manager\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c346047ae7cc6_33759518',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd16c28a0417ac2c68b881574c29dabe160d33c32' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\manager\\index.html',
      1 => 1535594429,
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
function content_5c346047ae7cc6_33759518 (Smarty_Internal_Template $_smarty_tpl) {
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
                            <button type="button" class="btn btn-info btn-sm add" _wh="550,450" _url="<?php echo U('manager/add');?>
">
                                添加
                            </button>
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
										<th>用户名</th>
                                        <th>用户组</th>
                                        <th>最后登录时间</th>
                                        <th>状态</th>
                                        <th>注册时间</th>
                                        <th>操作</th>
									</tr>
									</thead>

									<tbody id="tbody_data" data-name="tbody_data"></tbody>
								</table>
                                <div class="pagin" data-name="pagin" ></div>
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
