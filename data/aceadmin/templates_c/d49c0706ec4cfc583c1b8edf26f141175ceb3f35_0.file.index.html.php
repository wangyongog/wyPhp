<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:56
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\sidebar\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c495a881_70963163',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd49c0706ec4cfc583c1b8edf26f141175ceb3f35' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\sidebar\\index.html',
      1 => 1537086290,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/footer.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5baa04c495a881_70963163 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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



			<div class="main-content">
				<div class="main-content-inner">
	

					<div class="page-content">


						<div class="page-header">
                            <button type="button" class="btn btn-info btn-sm add" _url="<?php echo U('sidebar/add');?>
">
                                添加
                            </button>
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
										<th>菜单名称</th>
                                        <th class="hidden-480">链接</th>
                                        <th>ICON</th>
                                        <th>状态</th>
                                        <th class="hidden-480">排序</th>
                                        <th>操作</th>
									</tr>
									</thead>

									<tbody id="tbody_data" data-name="tbody_data"></tbody>
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
