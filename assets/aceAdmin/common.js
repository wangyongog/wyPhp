jQuery(function($) {
	/*$('.check-all').on('click',function () {
		$(".ids").prop("checked", this.checked);
	});*/
	//parent.document.getElementById('breadcrumbs').innerHTML;
	//alert(parent.document.getElementById('breadcrumbs').innerHTML);
	$('tbody').on('click','.ids',function () {
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
	$('tbody').on('click','.del',function(){
		var url = $(this).data('url');
		var msg = $(this).data('title') || '确定删除?';
		$evt.confirm_box(msg,function(){
			formAjax.dynamicLoading(url);
		}); 
	});
	$(document).on('click', '.close-upimg,.close_remove', function() {
        $(this).parent().remove();
		$('.percent').html('');
    });

	// $('body').on('click','.pass',function(){
 //        var title = $(this).attr('_title') || '编辑';
 //        var url = $(this).attr('_url');
 //        var wh = $(this).attr('_wh') || '700,630';
 //        var whArr = typeof wh !='undefined' ? wh.split(',') : '';

 //        adminJs.ShowDailog(title, url);
 //    });
	$('.ajaxFrom').on('click',function(){
		var formObj = $(this).parents('form');
		var url = formObj.attr('action') || $(this).attr('_url');
		formAjax.ajaxPost(url,formObj);
	});
	$('body').on('click','.edit',function(){
		var title = $(this).attr('_title') || '编辑';
		var url = $(this).attr('_url');
		var wh = $(this).attr('_wh') || '700,630';
		var whArr = typeof wh !='undefined' ? wh.split(',') : '';
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		$evt.showIframe(title, url,whArr[0],whArr[1]);
	});
	$('body').on('click','.addFrame',function(){
		parent.addframes($(this).attr('_url'),'',$(this).attr('title'));
	});
	$('body').on('click','.add',function(){
		var title = $(this).attr('_title') || '添加';
		var url = $(this).attr('_url');
		var wh = $(this).attr('_wh') || '700,630';
		var whArr = typeof wh !='undefined' ? wh.split(',') : '';
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		$evt.showIframe(title, url,whArr[0],whArr[1]);
	});
	$('body').on('click','.show_dialog',function(){
		var title = $(this).data('title') || '添加';
		var url = $(this).data('url');
		var backFun = $(this).data('backFun');
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		$evt.ShowDailog(title, url, backFun);
	});
	
	$('.searchForm').on('click',function(){
		formAjax.tbodyLoading();
	});
	$('.JclearCache').on('click',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_msg');
		parent.adminJs.confirm_box(msg,function(){
			formAjax.dynamicLoading(url);
		},null);
	});
	$('tbody').on('click','.tipClose',function(){
		var url = $(this).attr('_url');
		var msg = $(this).attr('_title') || '确定删除';
		var ex = url.indexOf('?') == -1 ? '?' : '&';
		$evt.confirm_box(msg,function(){
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
					$evt.showAlert('服务器异常，请联系管理员',2);return ;
				}
			});
		},null);
	});
	$('.tbody_del').on("click",function(){
		/*if($('.check-all:checked').length < 1){
			$evt.showAlert(msg);
			return false;
		}*/
		var data = [];
		$(".ids").each(function (i) {
			if (this.checked) {
				data.push(this.value);
			} 
		});
		
		if(data.length<=0){
			$evt.showAlert('请选择操作项');
			return false;
		}
		
		var btnObj = $(this);
		var msg = $(this).data('title') || '确定删除？';
		var url = btnObj.data("url");
		var param = data.join(',');
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		//var url = createurl(dataurl);
		//var url = url.indexOf('?') == -1 ? url+'?' : url+'&'+data_str;
		$evt.confirm_box(msg,function(){
			formAjax.dynamicLoading(url,{ids:param});
		});  
	});
	

	$('body').on('click','.bootstrap_del',function(){
		var url = $(this).data('url');
		var msg = $(this).data('title') || '确定删除?';
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		$evt.bootstrap_confirms(msg,function(){
			formAjax.dynamicLoading(url);
		}); 
	});

	$('body').on('click','.bootstrap_dels',function(){
		var data = [];
		$(".ids").each(function (i) {
			if (this.checked) {
				data.push(this.value);
			} 
		});
		
		if(data.length<=0){
			$evt.bootstrap_alert('请选择操作项');
			return false;
		}
		var msg = $(this).data('title') || '确定删除？';
		var url = $(this).data('url');
		var param = data.join(',');
		if(top.location ==self.location){  
        	$evt = adminJs;
    	}
		$evt.bootstrap_confirms(msg,function(){
			formAjax.dynamicLoading(url,{ids:param});
		}); 
	});

	$('.show-details-btn').on('click', function(e) {
		e.preventDefault();
		$(this).closest('tr').next().toggleClass('open');
		$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
	});
	
	$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
	var active_class = 'active';
	$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
		var th_checked = this.checked;//checkbox inside "TH" table header
		
		$(this).closest('table').find('tbody > tr').each(function(){
			var row = this;
			if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
			else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
		});
	});
})