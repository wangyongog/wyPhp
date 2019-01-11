<?php
/* Smarty version 3.1.33, created on 2019-01-09 01:18:24
  from 'D:\WWW\wyphp_new\aceAdmin_noIframe\app\templates\login\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c354be0937603_71731415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3446b2bcb6b99e64fa01b417eb2247bf05b4977a' => 
    array (
      0 => 'D:\\WWW\\wyphp_new\\aceAdmin_noIframe\\app\\templates\\login\\index.html',
      1 => 1534815249,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c354be0937603_71731415 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="zh-CN">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <title></title>
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/bootstrap/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/font_awesome/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/login-elements.css">
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/css/login.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/html5shiv.js"><?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/respond.min.js"><?php echo '</script'; ?>
>
        <![endif]-->

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    
                    <div class="row" style="text-align:center">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong></strong> Login Form</h1>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box ">
                        	<div class="form-top">
                        		<div class="form-top-left msgErr">
                        			<h3>Login to our site</h3>
                            		<p style="color:#F00"></p>
                        		</div>
                        		
                            </div>
                            
                            <div class="form-bottom">
                            <form method="post" class="login-form" onSubmit="return false;">
									<input type="hidden" name="formhash" id="formhash" class="form-control" value="<?php echo formhash();?>
">
			                    	<div class="form-group">
			                        	<input type="text" name="username" id="username" required placeholder="用户名" class=" form-control">
			                        </div>
			                        <div class="form-group">
			                        	<input type="password" name="password" required placeholder="密码" class="form-control" id="password">
			                        </div>
                                    <div class="form-group">
			                        	<input type="text" name="verify" maxlength="4" placeholder="验证码" id="verify" required ><img style="cursor:pointer; padding-left:20px" src="<?php echo U('login/verify');?>
"
                                                                  title="看不清楚？点击刷新"
                                                                 onclick="this.src ='<?php echo U('login/verify');?>
?t='+new Date().getTime()" id="codeimg">
			                        </div>
			                        <button id="sublogin" type="button" class="btn">登录</button>
                                    
                                            </form>
		                    </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
<style>

</style>

        <!-- Javascript -->
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/layer3.02/layer.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/share.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/jquery.backstretch.min.js"><?php echo '</script'; ?>
>
        <!--[if lt IE 10]>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/common/js/jquery.placeholder.js"><?php echo '</script'; ?>
>
        <![endif]-->
        <?php echo '<script'; ?>
 type="text/javascript">
        jQuery(document).ready(function() {
			$.backstretch("<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/images/1.jpg");
			$('.login-form input[type="text"], .login-form input[type="password"]').on('focus', function() {
				$(this).removeClass('input-error');
			});
			$('#sublogin').attr('disabled',false);
			
			$("#sublogin" ).on('click', function(e) {
				if($("#username").val() == ''){
    				$("#username").addClass('input-error');
					$('.msgErr p').html('请输入用户名！');
					return false;
				}
				if($("#password").val() == ''){
    				$("#password").addClass('input-error');
					$('.msgErr p').html('请输入密码！');
					return false;
				}
				if($("#verify").val() == ''){
					$('.msgErr p').html('请输入验证码！');
    				$("#verify").addClass('input-error');
					return false;
				}
				$.ajax({
					type:'POST',
					dataType:'json',
					url:'<?php echo U('login/login');?>
?t='+(new Date().getTime()),
					data:$('.login-form').serialize(),
					success:function(data){
						if(data.status == 1){
							window.location.href = data.url;
							return;
						}else{
							if(typeof data.verify !='undefined'){
								$('#codeimg').click();
							}
							$('.msgErr p').html(data.msg);
							return false;
						}
					},complete:function(XMLHttpRequest, textStatus){
						$('#sublogin').attr('disabled',false);
						$('#sublogin').html('登录');
					},beforeSend:function(){
						$('#sublogin').attr('disabled',true);
						$('#sublogin').html('登录中...');
					},error:function(){
						share.showAlert('服务器异常，请联系管理员',2);return ;
					}
				});
			});
			
			
		});
        <?php echo '</script'; ?>
>

    </body>

</html><?php }
}
