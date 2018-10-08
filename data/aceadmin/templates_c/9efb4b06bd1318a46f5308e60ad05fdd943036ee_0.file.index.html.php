<?php
/* Smarty version 3.1.32, created on 2018-09-25 17:49:53
  from 'D:\WWW\wyPhp\aceAdmin\app\templates\main\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5baa04c114ff08_74098869',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9efb4b06bd1318a46f5308e60ad05fdd943036ee' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\aceAdmin\\app\\templates\\main\\index.html',
      1 => 1537088953,
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
function content_5baa04c114ff08_74098869 (Smarty_Internal_Template $_smarty_tpl) {
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
                            <iframe class="main_iframe" scrolling="auto" id="main_iframe" width="100%" height="100%" src="<?php echo U('main/default');?>
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
$(window).load(function () {
	var index = layer.load(0, { shade: [0.6,'#fff']});
	window.setTimeout(function () {
	   adminJs.closeAllf();
	}, 1000);
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
	
}

<?php echo '</script'; ?>
>
		<!-- inline scripts related to this page -->
		
	</body>
</html>
<?php }
}
