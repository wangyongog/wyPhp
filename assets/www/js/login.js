var LoginAjax = {
	live:function(){
		$('.login-form input[type="text"], .login-form input[type="password"]').on('focus', function() {
			$(this).removeClass('input-error');
		});
		$("#sublogin" ).on('click', function(e) {
			if($("#username").val() == ''){
				$("#username").addClass('input-error');
				$('.msgErr').html('请输入用户名！');
				return false;
			}
			if($("#password").val() == ''){
				$("#password").addClass('input-error');
				$('.msgErr').html('请输入密码！');
				return false;
			}
			$.ajax({
				type:'POST',
				dataType:'json',
				url:$(this).attr('_url')+'?t='+(new Date().getTime()),
				data:$('.login-form').serialize(),
				success:function(data){
					if(data.status == 1){
						window.location.href = data.url;
						return;
					}else{
						$('.msgErr').html(data.info);
						return false;
					}
				},complete:function(XMLHttpRequest, textStatus){
					$('#sublogin').attr('disabled',false);
					$('#sublogin').val('登录');
				},beforeSend:function(){
					$('#sublogin').attr('disabled',true);
					$('#sublogin').val('登录中...');
				},error:function(){
					layer.alert('无效操作！',{icon: 2,scrollbar: false});
					return ;
				}
			});
			
		});
		
		$("#register" ).on('click', function(e) {
			if($("#username").val() == ''){
				$("#username").addClass('input-error');
				$('.msgErr').html('请输入用户名！');
				return false;
			}
			if($("#password").val() == ''){
				$("#password").addClass('input-error');
				$('.msgErr').html('请输入密码！');
				return false;
			}
			
			if($("#password1").val() == ''){
				$("#password1").addClass('input-error');
				$('.msgErr').html('请确认密码！');
				
				return false;
			}
			if($("#password1").val() !=$("#password").val()){
				$("#password1").addClass('input-error');
				$('.msgErr').html('2次密码不一致！');
				
				return false;
			}
			if($("#phone").val() == ''){
				$("#phone").addClass('input-error');
				$('.msgErr').html('请输入请输入手机号！');
				return false;
			}
			if(share.isPhoneNew($("#phone").val()) == false){
				$("#phone").addClass('input-error');
				$('.msgErr').html('手机号有误！');
				return false;
			}
			if($("#qq").val()  == ''){
				$("#qq").addClass('input-error');
				$('.msgErr').html('请输入qq号！');
				
				return false;
			}
			/*if($("#ycode").val()  == ''){
				$("#ycode").addClass('input-error');
				$('.msgErr').html('请输入邀请码！');
				
				return false;
			}*/
			$.ajax({
				type:'POST',
				dataType:'json',
				url:$(this).attr('_url')+'?t='+(new Date().getTime()),
				data:$('.login-form').serialize(),
				success:function(data){
					if(data.status == 1){
						layer.msg('注册成功!');
						setTimeout(function(){
							window.location.href = '/login';
						},2000);
						return;
					}else{
						$('.msgErr').html(data.info);
						return false;
					}
				},complete:function(XMLHttpRequest, textStatus){
					$('#register').attr('disabled',false);
					$('#register').val('登录');
				},beforeSend:function(){
					$('#register').attr('disabled',true);
					$('#register').val('注册中...');
				},error:function(){
					layer.alert('无效操作！',{icon: 2,scrollbar: false});
				}
			});
		});
	},
}
$(function () {
	LoginAjax.live();
});
