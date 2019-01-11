<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:34:17
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\archives\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c346089d06c42_48087622',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e5afa9e56bc24b9d5c6f05d84930a0ecd7672bc' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\archives\\index.html',
      1 => 1546936456,
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
function content_5c346089d06c42_48087622 (Smarty_Internal_Template $_smarty_tpl) {
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
                        <div class="page-header">
							<form action="" method="get" class="form-inline">
                            <a href="<?php echo U('archives/add',array('stype'=>G('stype'),'typeid'=>G('typeid')));?>
">
                            	<button type="button" class="btn btn-info btn-sm" >
                                添加
                            	</button></a>
                            	<label class="inline">用户名：</label>
                            	<input type="text" class="form-control" name="username" value=""/>
                                
     
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
												ID<input type="checkbox"  class="ace check-all">
												<span class="lbl"></span>
											</label>
										</th>
                     
										<th>文章标题</th>
                                        <th>所属栏目</th>
                                        <th class="hidden-480">点击量</th>
                                        <th class="hidden-480">发布人</th>
                                        <th>添加时间</th>
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
											<label class="pos-rel"><?php echo $_smarty_tpl->tpl_vars['val']->value['arid'];?>

												<input type="checkbox" class="ace ids" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['arid'];?>
">
												<span class="lbl"></span>
											</label>
										</td>

										
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['typename'];?>
</td>
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['click_num'];?>
</td>
                                        <td><?php echo getAdminName($_smarty_tpl->tpl_vars['val']->value['adduid']);?>
</td>
                                        <td>
										<?php if (!empty($_smarty_tpl->tpl_vars['val']->value['addtime'])) {?>	<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['addtime']);?>
 <?php }?>
										</td>

										<td>
										
											<a href="<?php echo U('archives/add',array('typeid'=>$_smarty_tpl->tpl_vars['val']->value['typeid'],'stype'=>G('stype'),'arid'=>$_smarty_tpl->tpl_vars['val']->value['arid']));?>
">编辑</a> | 
                                            <a href="javascript:;" class="del" _url="<?php echo U('archives/del',array('arid'=>$_smarty_tpl->tpl_vars['val']->value['arid']));?>
">删除</a>
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

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('isdate'=>1), 0, false);
echo '<script'; ?>
 type="text/javascript">
	///parent.document.getElementById('breadcrumbs').innerHTML = 'ssssss';
    jQuery(function ($) {
        $('#startime').datetimepicker({
           format: 'yyyy-mm-dd',//'yyyy-mm-dd hh:ii:ss'
            autoclose: true,
			minView: 30,
			language : 'zh-CN',
			minuteStep:1,
			todayBtn: true,
			startView:2,
			startDate: new Date() 
        });
    });
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
