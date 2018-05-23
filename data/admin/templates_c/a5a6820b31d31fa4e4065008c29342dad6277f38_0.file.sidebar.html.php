<?php
/* Smarty version 3.1.30, created on 2018-01-02 14:21:06
  from "D:\WWW\wy\admin\app\templates\public\sidebar.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4b24d244ecf7_30892823',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5a6820b31d31fa4e4065008c29342dad6277f38' => 
    array (
      0 => 'D:\\WWW\\wy\\admin\\app\\templates\\public\\sidebar.html',
      1 => 1514273798,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4b24d244ecf7_30892823 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="main-sidebar">
    <div class="sidebar">
        <!--<div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $_smarty_tpl->tpl_vars['user']->value['user'];?>
</p>
                <a><i class="fa fa-circle text-success"></i>在线</a>
            </div>
        </div>-->

        <ul class="sidebar-menu" id="sidebar-menu">
            <!--<li class="header">导航菜单</li>-->
            <li class="header"></li>
            <?php if ($_smarty_tpl->tpl_vars['sidebarlist']->value) {?>  
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebarlist']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                <li class="treeview ">
                	<a <?php if (!isset($_smarty_tpl->tpl_vars['val']->value['children'])) {?> class="menuItem" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" <?php }?>  href="javascript:;" >
                        <i class="<?php echo $_smarty_tpl->tpl_vars['val']->value['icon'];?>
"></i>
                        <span><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
                        <?php if (isset($_smarty_tpl->tpl_vars['val']->value['children'])) {?><i class="fa fa-angle-left pull-right"></i> <?php }?>
                    </a>
                    <?php if (isset($_smarty_tpl->tpl_vars['val']->value['children'])) {?>
                    	<ul class="treeview-menu " >  
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['children'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                        	<li><a class="menuItem" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" href="javascript:;"><i class="<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
"></i><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </ul>
                    <?php }?>
                </li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <?php }?>  
        	<!--<li class="treeview active">
            	<a href="#">
                    <i class="fa fa-desktop"></i>
                    <span>系统管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu menu-open" style="display: block;">
                	<li>
                    <a href="#"><i class="fa fa-database"></i>数据管理<i class="fa fa-angle-left pull-right"></i></a>
                    	<ul class="treeview-menu">
                        	<li><a class="menuItem" data-id="7cec0a0f-7204-4240-b009-312fa0c11cbf" href="null"><i class="fa fa-plug"></i>数据库连接</a></li>
                            <li><a class="menuItem" data-id="7cec0a0f-7204-4240-b009-312fa0c11cbf" href="null"><i class="fa fa-cloud-download"></i>数据库备份</a></li>
                            <li><a class="menuItem" data-id="7cec0a0f-7204-4240-b009-312fa0c11cbf" href="null"><i class="fa fa-table"></i>数据表管理</a></li>
                        </ul>
                    </li>
                    <li><a class="menuItem" data-id="f21fa3a0-c523-4d02-99ca-fd8dd3ae3d59" href="/SystemManage/Log/Index"><i class="fa fa-warning"></i>系统日志</a></li>
                    <li><a class="menuItem" data-id="21" href="/sidebar"><i class="fa fa-navicon"></i>栏目设置</a></li>
                 </ul>
            </li>
            <li class="treeview">
            	<a href="#"><i class="fa fa-coffee"></i><span>单位组织</span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                    <li><a class="menuItem" data-id="8" href="/BaseManage/Organize/Index"><i class="fa fa-sitemap"></i>机构管理</a></li>
                    <li><a class="menuItem" data-id="9" href="/BaseManage/Department/Index"><i class="fa fa-th-list"></i>部门管理</a></li><li><a class="menuItem" data-id="11" href="/BaseManage/Role/Index"><i class="fa fa-paw"></i>角色管理</a></li><li><a class="menuItem" data-id="13" href="/BaseManage/Post/Index"><i class="fa fa-graduation-cap"></i>岗位管理</a></li><li><a class="menuItem" data-id="12" href="/BaseManage/Job/Index"><i class="fa fa-briefcase"></i>职位管理</a></li><li><a class="menuItem" data-id="14" href="/BaseManage/UserGroup/Index"><i class="fa fa-group"></i>用户组管理</a></li><li><a class="menuItem" data-id="10" href="/BaseManage/User/Index"><i class="fa fa-user"></i>用户管理</a></li>
                    </ul>
            </li>-->
        </ul>
    </div>
</div><?php }
}
