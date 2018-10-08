<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\head.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c11ccf00_27737861',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ae76e0e6f265c7de5b9a7aa0cf66d08fb69fbaa' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\head.html',
      1 => 1535443008,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c11ccf00_27737861 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							后台管理
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						
						

						

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/aceAdmin/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $_smarty_tpl->tpl_vars['user']->value['user'];?>

								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="javascript:void();" _msg="确定清空缓存？" class="tiphands" _url="<?php echo U('main/clear');?>
">
										<i class="ace-icon fa fa-cog"></i>
										清空缓存
									</a>
								</li>


								<li class="divider"></li>

								<li>
									<a href="<?php echo U('main/logout');?>
">
										<i class="ace-icon fa fa-power-off"></i>
										安全退出
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div><?php }
}
