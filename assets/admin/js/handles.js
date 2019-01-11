$(function () {
	$('.check-all').on('click',function () {
		$(".ids").prop("checked", this.checked);
	});
	$('[data-name="tbody_data"').on('click','.ids',function () {
		var option = $(".ids");
		option.each(function (i) {
			if (!this.checked) {
				$(".check-all").prop("checked", false);
				return false;
			} else {
				$(".check-all").prop("checked", true);
			}
		});
	});
	$('[data-name="tbody_data"').on('click','.del',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_title') || '确定删除';
		adminJs.confirm_box(msg,function(){
			formAjax.ajaxPost(url);
		}); 
	});
	$('[data-name="tbody_data"').on('click','.edit',function(){
		var title = $(this).attr('_title') || '编辑';
		var url = $(this).attr('_url');
		var wh = $(this).attr('_wh') || '700,630';
		var whArr = typeof wh !='undefined' ? wh.split(',') : '';
		
		adminJs.showIframe(title, url,whArr[0],whArr[1]);
	});
	$('.searchForm').on('click',function(){
		formAjax.tbodyLoading();
	});
	$('.tiphands').on('click',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_msg');
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		adminJs.confirm_box(msg,function(){
			var layars=layer.load(0,{shade:[0.8,'#CCC']});
			$.ajax({
				type:'POST',
				dataType:'json',
				url:url+ex+'t='+(new Date().getTime()),
				data:'',
				success:function(data){
					formAjax.runAjaxResSuccess(data);
					setTimeout(function(){
						formAjax.tbodyLoading();
					},3000);
					
				},complete:function(XMLHttpRequest, textStatus){
					layer.close(layars);
				},beforeSend:function(){
					
				},error:function(){
					adminJs.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
		},null);
	});
	$('[data-name="tbody_data"').on('change','.layui-textarea',function () {
		$.post($(this).attr('_url') ,{remark:$(this).val()},function(data){
			
		});
	});
	$('[data-name="tbody_data"').on('click','.tipClose',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_msg')
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		adminJs.confirm_box(msg,function(){
			var layars=layer.load(0,{shade:[0.8,'#CCC']});
			$.ajax({
				type:'POST',
				dataType:'json',
				url:url+ex+'t='+(new Date().getTime()),
				data:'',
				success:function(data){
					formAjax.runAjaxResSuccess(data);
					setTimeout(function(){
						formAjax.tbodyLoading();
					},3000);
					
				},complete:function(XMLHttpRequest, textStatus){
					layer.close(layars);
				},beforeSend:function(){
					
				},error:function(){
					adminJs.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
		},null);
	});
	$('.tbody_del').on("click",function(){
		if($('.check-all:checked').length < 1){
			adminJs.showAlert('请选择删除选项');
			return false;
		}
		var data = [];
		$('.check-all:checked').each(function(){
			data.push($(this).val()); 
		});
		var btnObj = $(this);
		var key = btnObj.attr("data-param");
		var dataurl = btnObj.attr("_url");
		var data_str = key+"="+data.join(',');
		var url = createurl(dataurl);
		adminJs.confirm_box('删除提示');        
	});
});
