<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:02:13
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\banner\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c346715df8f47_79979296',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c2609ac9ac9cb15b1c3b730d1061467f25d1bf7' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\banner\\index.html',
      1 => 1546938132,
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
function content_5c346715df8f47_79979296 (Smarty_Internal_Template $_smarty_tpl) {
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
                            	<button type="button"  class="btn btn-info btn-sm show_dialog" _url="<?php echo U('banner/add');?>
">
                                添加
                            	</button>
                            	<label class="inline">Banner位：</label>
                                <select name="pos" class="form-control">
                                    <option value="">全部</option>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pos']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                                    <option <?php if (G('pos') == $_smarty_tpl->tpl_vars['k']->value) {?> selected <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
            						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </select>
                                <label class="inline">开始时间：</label>
                            	<input type="text" class="form-control" name="startime" id="startime" value=""/>
                                <label class="inline">结束时间：</label>
                            	<input type="text" class="form-control" name="endtime" id="endtime" value=""/>
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
										<th>图片</th>
                                        <th>广告位置</th>
                                        <th class="hidden-480">链接</th>
                                        <th class="hidden-480">开始时间</th>
                                        <th class="hidden-480">结束时间</th>
                                        <th>排序</th>
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
												<input type="checkbox" class="ace ids" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
												<span class="lbl"></span>
											</label>
										</td>
										<td><img src="<?php echo picSize($_smarty_tpl->tpl_vars['val']->value['img']);?>
" style="max-width:160px; max-height:100px"/></td>
										<td><?php echo $_smarty_tpl->tpl_vars['pos']->value[$_smarty_tpl->tpl_vars['val']->value['pos']];?>
</td>
										<td class="hidden-480"><?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
</td>
										<td class="hidden-480"><?php if (!empty($_smarty_tpl->tpl_vars['val']->value['startime'])) {
echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['startime']);?>
 <?php }?></td>
										<td class="hidden-480">
										<?php if (!empty($_smarty_tpl->tpl_vars['val']->value['endtime'])) {?>	<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['endtime']);?>
 <?php }?>
										</td>
										<td><?php echo $_smarty_tpl->tpl_vars['val']->value['o'];?>
</td>
										<td>
										
											<div class="hidden-sm hidden-xs action-buttons">	
                                                <a class="green show_dialog" href="javascript:;" _url="<?php echo U('banner/add',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id']));?>
" _wh="700,550" title="编辑">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>

                                                <a class="red del" href="javascript:;" _url="<?php echo U('banner/del',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['id'])));?>
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
															<a href="javascript:;" class="tooltip-success show_dialog" _url="<?php echo U('banner/add',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id']));?>
" _wh="700,550" title="编辑" data-rel="tooltip" title="" data-original-title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
															</a>
														</li>

														<li>
															<a href="javascript:;" class="tooltip-error del" _url="<?php echo U('banner/del',array('id'=>$_smarty_tpl->tpl_vars['val']->value['id'],'token'=>creatToken($_smarty_tpl->tpl_vars['val']->value['id'])));?>
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

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('isdate'=>1,'isupfile'=>1), 0, false);
echo '<script'; ?>
 type="text/javascript">
    jQuery(function ($) {
        $('#startime').datetimepicker({
           format: 'yyyy-mm-dd hh:ii:ss',//'yyyy-mm-dd hh:ii:ss'
            autoclose: true,
			//minView: 30,
			language : 'zh-CN',
			minuteStep:1,
			todayBtn: true,
			startView:2,
			startDate: new Date() 
        });
		$('#endtime').datetimepicker({
           format: 'yyyy-mm-dd hh:ii:ss',//'yyyy-mm-dd hh:ii:ss'
            autoclose: true,
			//minView: 30,
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
