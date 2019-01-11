<?php
/* Smarty version 3.1.33, created on 2019-01-08 09:07:23
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\main\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c34684be20044_10876798',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0d4c98886e8c896135f170cbc9c9abfb3b9d86f6' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\main\\index.html',
      1 => 1537062258,
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
function content_5c34684be20044_10876798 (Smarty_Internal_Template $_smarty_tpl) {
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

					
						<?php $_smarty_tpl->_subTemplateRender("file:public/settingsBox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                        <div id="content-iframe" class="content-iframe">
                            <iframe class="main_iframe" scrolling="auto" id="main_iframe" onload="changeFrameHeight(this)" width="100%" height="100%" src="<?php echo U('main/default');?>
" frameborder="0" data-id="<?php echo U('main/default');?>
"></iframe>
                        </div>
					
				</div>
			</div><!-- /.main-content -->


		<!--<?php $_smarty_tpl->_subTemplateRender("file:public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>-->
		</div><!-- /.main-container -->

		<?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        

        
<?php echo '<script'; ?>
 type="text/javascript">
/*$("#content-iframe").height($(window).height() - 90);
$(window).resize(function (e) {
	$("#content-iframe").height($(window).height() - 90);
});
function resize(resizeHandle){
	var d = document.documentElement;
	var timer;//避免resize触发多次,影响性能
	var width = d.clientWidth, height = d.clientHeight;
	$(top.window).on('resize',function(e){
		if((width != d.clientWidth || height != d.clientHeight)) {
			width = d.clientWidth, height = d.clientHeight;
			if(timer){
				clearTimeout(timer);
			}
			timer = setTimeout(function() {
				resizeHandle();
			},10);	
		}
	});
	
}*/
window.onresize = function () {
        var target = $(".tab-content .active iframe");
        changeFrameHeight(target);
    }
var changeFrameHeight = function (that) {
    $(that).height(document.documentElement.clientHeight - 115);
    $(that).parent(".content-iframe").height(document.documentElement.clientHeight - 90);
}
<?php echo '</script'; ?>
>
		<!-- inline scripts related to this page -->
		
	</body>
</html>
<?php }
}
