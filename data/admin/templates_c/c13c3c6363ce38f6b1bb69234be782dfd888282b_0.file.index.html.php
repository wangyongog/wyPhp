<?php
/* Smarty version 3.1.32, created on 2018-09-16 17:58:36
  from 'D:\WWW\wyPhp\admin\app\templates\main\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b9e294c02ee05_79896715',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c13c3c6363ce38f6b1bb69234be782dfd888282b' => 
    array (
      0 => 'D:\\WWW\\wyPhp\\admin\\app\\templates\\main\\index.html',
      1 => 1537082510,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/header.html' => 1,
    'file:public/sidebar.html' => 1,
    'file:public/footerJs.html' => 1,
  ),
),false)) {
function content_5b9e294c02ee05_79896715 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div id="ajax-loader" style="cursor: progress; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%; background: #fff; z-index: 10000; overflow: hidden;">
    <img src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/img/ajax-loader.gif" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto;" />
</div>
<div class="wrapper">
	<header class="main-header">
    <a href="/" class="logo">
        <!--<span class="logo-mini">微数据</span>-->
        <span class="logo-lg"> <b>后台管理</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="/" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">菜单栏</span>
        </a>
        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="javascript:;" class="dropdown-toggle cshe" data-toggle="dropdown">
                        阅读
                        <span class="label label-success ntask">0</span>
                    </a>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="javascript:;" class="dropdown-toggle dz" data-toggle="dropdown">
                        点赞
                        <span class="label label-warning ndianzan">0</span>
                    </a>
                </li>
                <!--<li class="dropdown tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle gs" data-toggle="dropdown">
                        高速
                        <span class="label label-danger ngaosu">0</span>
                    </a>
                </li>-->
                <li class="dropdown tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle fs" data-toggle="dropdown">
                        粉丝
                        <span class="label label-danger nfans">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle dy" data-toggle="dropdown">
                        自定义
                        <span class="label label-danger ntaocan">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle tk" data-toggle="dropdown">
                        退款
                        <span class="label label-danger ntuikuan">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle cz" data-toggle="dropdown">
                        充值
                        <span class="label label-danger nrecharge">0</span>
                    </a>
                </li>
                        
  
                <li class="dropdown user user-menu tasks-menu">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['user']->value['user'];?>
</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <li>
                                <a href="javascript:void();" _msg="确定清空缓存？" class="tiphands" _url="<?php echo U('main/clear');?>
">
                                        <h3><i class="fa fa-trash-o"></i>清空缓存</h3>
                                    </a>
                                </li>
                                <li>
                                <a href="<?php echo U('main/logout');?>
">
                                        <h3><i class="ace-icon fa fa-power-off"></i>安全退出</h3>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
	</header>


	<?php $_smarty_tpl->_subTemplateRender("file:public/sidebar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		
	
	<!--中间内容-->
    <div id="content-wrapper" class="content-wrapper">
        <div class="content-tabs">
            <button class="roll-nav roll-left tabLeft">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="menuTab active" data-id="/Home/Default">欢迎首页</a>
                    <!--<a href="javascript:;" class="menuTab" data-id="/Home/About" style="padding-right: 15px;">平台介绍</a>
                    <a href="javascript:;" class="menuTab" data-id="/SystemManage/Organize/Index">机构管理 <i class="fa fa-remove"></i></a>
                    <a href="javascript:;" class="menuTab" data-id="/SystemManage/Role/Index">角色管理 <i class="fa fa-remove"></i></a>
                    <a href="javascript:;" class="menuTab" data-id="/SystemManage/Duty/Index">岗位管理 <i class="fa fa-remove"></i></a>
                    <a href="javascript:;" class="menuTab" data-id="/SystemManage/User/Index">用户管理 <i class="fa fa-remove"></i></a>-->
                </div>
            </nav>
            <button class="roll-nav roll-right tabRight">
                <i class="fa fa-forward" style="margin-left: 3px;"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown tabClose" data-toggle="dropdown">
                    页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="tabReload" href="javascript:void();">刷新当前</a></li>
                    <li><a class="tabCloseCurrent" href="javascript:void();">关闭当前</a></li>
                    <li><a class="tabCloseAll" href="javascript:void();">全部关闭</a></li>
                    <li><a class="tabCloseOther" href="javascript:void();">除此之外全部关闭</a></li>
                </ul>
            </div>
            <button class="roll-nav roll-right fullscreen"><i class="fa fa-arrows-alt"></i></button>
        </div>
        
        <div class="content-iframe">
            <div class="mainContent" id="content-main">
                <iframe class="LRADMS_iframe" scrolling="auto" id="content-iframe" width="100%" height="100%" src="/main/default" frameborder="0" data-id="/main/default"></iframe>
            </div>
        </div>
        
    </div>
   <!--中间内容结束-->
</div>
<!-- basic scripts -->


 <?php $_smarty_tpl->_subTemplateRender("file:public/footerJs.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
 type="text/javascript">
function GetHeight(){
	if ($(".sidebar").height() > $(window).height()) {
		$(".content-wrapper, .right-side").css('min-height', $(".sidebar").height())
	}
}
/*$(function(){
	$('.remarksview').click(function(){
		if($(this).parent().height() >= 50){
			var oDiv = $(this);
			if(oDiv.height() == 50){
			    oDiv.css('max-height',1000);
			    oDiv.css('max-width',1000);
			}else{
			    oDiv.css('max-height',50);
			    oDiv.css('max-width',200);
			}
		}
	  
	});
	$('.sidebar-menu li[two=BUSINESS]').addClass('active');
	$('.sidebar-menu li[two=BUSINESS]').parent().parent().addClass('active');
})*/
setTimeout(GetHeight,100);
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
 $('.cshe').on('click',function(){
		$('.sx89').click();
  });
$('.dz').on('click',function(){
		$('.sx91').click();
  });
  $('.fs').on('click',function(){
		$('.sx95').click();
  });
  $('.gs').on('click',function(){
		$('.sx97').click();
  });
  $('.dy').on('click',function(){
		$('.sx96').click();
  });
  $('.tk').on('click',function(){
		$('.sx97').click();
  });
  $('.cz').on('click',function(){
		$('.sx101').click();
  });
});
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
var arr = Array();
arr = [
	'<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/mp3/notify.mp3',
	/*'<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/mp3/liangliang.mp3',
	'<?php echo $_smarty_tpl->tpl_vars['assets']->value;?>
/admin/mp3/4191.mp3'*/
];
var i = Math.round(Math.random()*2)
var audio = new Audio(arr[0]);
function tilist(){
	audio.currentTime = 0;
	audio.pause();
	$.post('/main/getNum',{},function(data){
		if(data.status == 1){
			$('.nrecharge').html(typeof data.recharge !='undefined' ? data.recharge : 0);
			$('.ntuikuan').html(typeof data.tasklog !='undefined' ? data.tasklog : 0);
			$('.ntask').html(typeof data.task !='undefined' ? data.task : 0);
			$('.ndianzan').html(typeof data.dianzan !='undefined' ? data.dianzan : 0);
			$('.ntaocan').html(typeof data.taocan !='undefined' ? data.taocan : 0);
			$('.ngaosu').html(typeof data.gaosu !='undefined' ? data.gaosu : 0);
			$('.nfans').html(typeof data.fans !='undefined' ? data.fans : 0);
			audio.play();
		}else{
			$('.nrecharge').html(0);
			$('.ntuikuan').html( 0);
			$('.ntask').html(0);
			$('.ndianzan').html( 0);
			$('.ntaocan').html( 0);
			$('.ngaosu').html( 0);
			$('.nfans').html(0);
		}
	},'json');
}
$(function () {
	setInterval("tilist()", 60000);
	setTimeout(function(){
		tilist();
		}, 2000);
		return;
});
    <?php echo '</script'; ?>
>
</body>
</html><?php }
}
