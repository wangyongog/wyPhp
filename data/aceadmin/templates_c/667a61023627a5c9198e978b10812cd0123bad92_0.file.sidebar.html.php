<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\public\sidebar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c1236684_16141053',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '667a61023627a5c9198e978b10812cd0123bad92' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\public\\sidebar.html',
      1 => 1537080984,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5baa04c1236684_16141053 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="sidebar" class="sidebar responsive ace-save-state">
	<?php echo '<script'; ?>
 type="text/javascript">
        try{
            ace.settings.loadState('sidebar')
            }catch(e){
                }
    <?php echo '</script'; ?>
>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <?php if ($_smarty_tpl->tpl_vars['sidebarlist']->value) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebarlist']->value, 'val', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
        <li>
            <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" href="javascript:;" class="<?php if (!empty($_smarty_tpl->tpl_vars['val']->value['children'])) {?>dropdown-toggle<?php } else { ?>menuItem<?php }?>">
                <i class="<?php echo $_smarty_tpl->tpl_vars['val']->value['icon'];?>
 menu-icon"></i>
                <span class="menu-text">
                    <?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>

                </span>
                <b class="arrow <?php if (!empty($_smarty_tpl->tpl_vars['val']->value['children'])) {?> fa fa-angle-down <?php }?>"></b>
            </a>
            <?php if (!empty($_smarty_tpl->tpl_vars['val']->value['children'])) {?>
			<b class="arrow"></b>
            <ul class="submenu">
            	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['children'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
            	<li>
                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" href="javascript:;" class="<?php if (!empty($_smarty_tpl->tpl_vars['v']->value['children'])) {?>dropdown-toggle<?php } else { ?>menuItem<?php }?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>

                        <b class="arrow <?php if (!empty($_smarty_tpl->tpl_vars['v']->value['children'])) {?> fa fa-angle-down <?php }?>"></b>
                    </a>
                    
                    <?php if (!empty($_smarty_tpl->tpl_vars['v']->value['children'])) {?>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['children'], 'va', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['va']->value) {
?>
                        <li>
                            <a data-id="<?php echo $_smarty_tpl->tpl_vars['va']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['va']->value['url'];?>
" href="javascript:;" class="<?php if (!empty($_smarty_tpl->tpl_vars['va']->value['children'])) {?>dropdown-toggle<?php } else { ?>menuItem<?php }?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                <?php echo $_smarty_tpl->tpl_vars['va']->value['title'];?>

                                <b class="arrow <?php if (!empty($_smarty_tpl->tpl_vars['va']->value['children'])) {?> fa fa-angle-down <?php }?>"></b>
                            </a>
                        </li>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                    <?php }?>
                </li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
            <?php }?>
            
        </li>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  	<?php }?> 
        
        
    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div><?php }
}
