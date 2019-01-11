<?php
/* Smarty version 3.1.33, created on 2019-01-08 08:31:44
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\public\settingsBox.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c345ff0b59148_97764433',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '546b723d47f74906b2923be52f8f98a34a8a521b' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\public\\settingsBox.html',
      1 => 1535335168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c345ff0b59148_97764433 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="ace-settings-container" id="ace-settings-container">
    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
        <i class="ace-icon fa fa-cog bigger-130"></i>
    </div>

    <div class="ace-settings-box clearfix" id="ace-settings-box">
        <div class="pull-left width-50">
            <div class="ace-settings-item">
                <div class="pull-left">
                    <select id="skin-colorpicker" class="hide">
                        <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                        <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                        <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                        <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                    </select>
                </div>
                <span>&nbsp; Choose Skin</span>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                <label class="lbl" for="ace-settings-add-container">
                    Inside
                    <b>.container</b>
                </label>
            </div>
        </div><!-- /.pull-left -->

        <div class="pull-left width-50">
            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
            </div>

            <div class="ace-settings-item">
                <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
            </div>
        </div><!-- /.pull-left -->
    </div><!-- /.ace-settings-box -->
</div><!-- /.ace-settings-container --><?php }
}
