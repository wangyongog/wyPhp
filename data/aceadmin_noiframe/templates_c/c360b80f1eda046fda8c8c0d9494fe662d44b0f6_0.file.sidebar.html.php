<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:31:44
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\sidebar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c345ff0b41a49_09762323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c360b80f1eda046fda8c8c0d9494fe662d44b0f6' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\sidebar.html',
      1 => 1534921458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c345ff0b41a49_09762323 (Smarty_Internal_Template $_smarty_tpl) {
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
        <li class="<?php if (in_array($_smarty_tpl->tpl_vars['act']->value,$_smarty_tpl->tpl_vars['val']->value['acts'])) {?>active<?php }?> <?php if (in_array($_smarty_tpl->tpl_vars['act']->value,$_smarty_tpl->tpl_vars['val']->value['acts']) && !$_smarty_tpl->tpl_vars['val']->value['url']) {?>open<?php }?>" >
            <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" href="<?php if ($_smarty_tpl->tpl_vars['val']->value['url']) {
echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
 <?php } else { ?>javascript:; <?php }?>"  <?php if (!$_smarty_tpl->tpl_vars['val']->value['url']) {?>class="dropdown-toggle"<?php }?>>
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
            	<li <?php if ($_smarty_tpl->tpl_vars['act']->value == $_smarty_tpl->tpl_vars['v']->value['url']) {?> class="active"<?php }?>>
                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" href="<?php if ($_smarty_tpl->tpl_vars['v']->value['url']) {
echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
 <?php } else { ?>javascript:; <?php }?>" <?php if (!$_smarty_tpl->tpl_vars['v']->value['url']) {?>class="dropdown-toggle"<?php }?>>
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
                        <li class="">
                            <a data-id="<?php echo $_smarty_tpl->tpl_vars['va']->value['id'];?>
" _url="<?php echo $_smarty_tpl->tpl_vars['va']->value['url'];?>
" href="<?php if ($_smarty_tpl->tpl_vars['va']->value['url']) {
echo $_smarty_tpl->tpl_vars['va']->value['url'];?>
 <?php } else { ?>javascript:; <?php }?>" <?php if (!$_smarty_tpl->tpl_vars['va']->value['url']) {?>class="dropdown-toggle"<?php }?>>
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
