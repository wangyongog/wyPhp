<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\main\default.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c1599983_38958071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6072aeedc6a72e7e2733a10060ffaeeae980cef2' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\main\\default.html',
      1 => 1536995360,
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
function content_5baa04c1599983_38958071 (Smarty_Internal_Template $_smarty_tpl) {
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
							<form action="" method="get" class="form-inline">
                            	<label class="inline">用户名：</label>
                            	<input type="text" class="form-control" name="username" value="">
                                
                                <select name="simoney" class="form-control">
                                    <option value="">全部</option>
                                    <option value="1">是</option>
                                    <option value="2">否</option>
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
												<input type="checkbox" class="ace">
												<span class="lbl"></span>
											</label>
										</th>
										<th class="detail-col">Details</th>
										<th>Domain</th>
										<th>Price</th>
										<th class="hidden-480">Clicks</th>

										<th>
											<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
											Update
										</th>
										<th class="hidden-480">Status</th>

										<th></th>
									</tr>
									</thead>

									<tbody>
									<tr>
										<td class="center">
											<label class="pos-rel">
												<input type="checkbox" class="ace">
												<span class="lbl"></span>
											</label>
										</td>

										<td class="center">
											<div class="action-buttons">
												<a href="#" class="green bigger-140 show-details-btn" title="Show Details">
													<i class="ace-icon fa fa-angle-double-down"></i>
													<span class="sr-only">Details</span>
												</a>
											</div>
										</td>

										<td>
											<a href="#">ace.com</a>
										</td>
										<td>$45</td>
										<td class="hidden-480">3,330</td>
										<td>Feb 12</td>

										<td class="hidden-480">
											<span class="label label-sm label-warning">Expiring</span>
										</td>

										<td>
											<div class="hidden-sm hidden-xs btn-group">
												<button class="btn btn-xs btn-success">
													<i class="ace-icon fa fa-check bigger-120"></i>
												</button>

												<button class="btn btn-xs btn-info">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</button>

												<button class="btn btn-xs btn-danger">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</button>

												<button class="btn btn-xs btn-warning">
													<i class="ace-icon fa fa-flag bigger-120"></i>
												</button>
											</div>

											<div class="hidden-md hidden-lg">
												<div class="inline pos-rel">
													<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
														<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
													</button>

													<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
														<li>
															<a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
																			<span class="blue">
																				<i class="ace-icon fa fa-search-plus bigger-120"></i>
																			</span>
															</a>
														</li>

														<li>
															<a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
															</a>
														</li>

														<li>
															<a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
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


									<tr class="detail-row">
										<td colspan="8">
											<div class="table-detail">
												<div class="row">
													<div class="col-xs-12 col-sm-2">
														<div class="text-center">
															<img height="150" class="thumbnail inline no-margin-bottom" alt="Domain Owner's Avatar" src="assets/images/avatars/profile-pic.jpg">
															<br>
															<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
																<div class="inline position-relative">
																	<a class="user-title-label" href="#">
																		<i class="ace-icon fa fa-circle light-green"></i>
																		&nbsp;
																		<span class="white">Alex M. Doe</span>
																	</a>
																</div>
															</div>
														</div>
													</div>

													<div class="col-xs-12 col-sm-7">
														<div class="space visible-xs"></div>

														<div class="profile-user-info profile-user-info-striped">
															<div class="profile-info-row">
																<div class="profile-info-name"> Username </div>

																<div class="profile-info-value">
																	<span>alexdoe</span>
																</div>
															</div>

															<div class="profile-info-row">
																<div class="profile-info-name"> Location </div>

																<div class="profile-info-value">
																	<i class="fa fa-map-marker light-orange bigger-110"></i>
																	<span>Netherlands, Amsterdam</span>
																</div>
															</div>

															<div class="profile-info-row">
																<div class="profile-info-name"> Age </div>

																<div class="profile-info-value">
																	<span>38</span>
																</div>
															</div>

															<div class="profile-info-row">
																<div class="profile-info-name"> Joined </div>

																<div class="profile-info-value">
																	<span>2010/06/20</span>
																</div>
															</div>

															<div class="profile-info-row">
																<div class="profile-info-name"> Last Online </div>

																<div class="profile-info-value">
																	<span>3 hours ago</span>
																</div>
															</div>

															<div class="profile-info-row">
																<div class="profile-info-name"> About Me </div>

																<div class="profile-info-value">
																	<span>Bio</span>
																</div>
															</div>
														</div>
													</div>

													<div class="col-xs-12 col-sm-3">
														<div class="space visible-xs"></div>
														<h4 class="header blue lighter less-margin">Send a message to Alex</h4>

														<div class="space-6"></div>

														<form>
															<fieldset>
																<textarea class="width-100" resize="none" placeholder="Type something…"></textarea>
															</fieldset>

															<div class="hr hr-dotted"></div>

															<div class="clearfix">
																<label class="pull-left">
																	<input type="checkbox" class="ace">
																	<span class="lbl"> Email me a copy</span>
																</label>

																<button class="pull-right btn btn-sm btn-primary btn-white btn-round" type="button">
																	Submit
																	<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
																</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</td>
									</tr>
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

		<!-- inline scripts related to this page -->
		
	</body>
</html>
<?php }
}
